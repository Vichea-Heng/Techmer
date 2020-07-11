<?php

namespace App\Http\Controllers\Api\v1\Users;

use App\Exceptions\MessageException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\AddressRequest;
use App\Http\Resources\Users\UserResource;
use App\Mail\ResetPasswordMail;
use App\Models\Addresses\Address;
use App\Models\Addresses\Country;
use App\Models\Auth\PasswordReset;
use App\Models\Users\Identity;
use App\Models\Users\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $data = $request->validate([
            'username' => "required",
            'password' => "required",
        ]);

        $data["username"] = strtolower($data["username"]);

        if (is_numeric($data["username"])) {
            $cred = ['phone_number' => $data["username"], 'password' => $data["password"]];
        } elseif (filter_var($data["username"], FILTER_VALIDATE_EMAIL)) {
            $cred = ['email' => $data["username"], 'password' => $data["password"]];
        } else {
            $cred = ['username' => $data["username"], 'password' => $data["password"]];
        }

        if (Auth::attempt($cred)) {
            $user = Auth::user()->createToken("asd");
            // $user = Auth::user()->createSetupIntent();

            return dataResponse($user);
        } else {
            throw new MessageException("Your Username and Password are incorrect");
        }
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            "username" => "required|max:255|alpha_num|unique:users",
            "first_name" => "required|max:255|alpha",
            "last_name" => "required|max:255|alpha",
            "date_of_birth" => "required|date|before:" . date("Y-m-d"),
            "phone_number" => "required|string|min:6|max:14",
            "phone_code" => "required|exists:countries,id",
            "email" => "required|max:255|email|unique:users",
            "password" => "required|min:3|max:255|confirmed",
        ]);

        $data["phone_number"] = Country::findOrFail($data["phone_code"])->phone_code . $data["phone_number"];

        $data["username"] = strtolower($data["username"]);

        if (!empty(User::where("phone_number", $data["phone_number"])->first())) {
            throw ValidationException::withMessages(["phone_number" => "The phone number has already taken."]);
        }
        // $data["username"] = $this->generate_username($data);

        $data["password"] = Hash::make($data["password"]);

        DB::beginTransaction();

        $user = User::create($data);
        $data["user_id"] = $user->id;
        Identity::create($data);

        $user->success = $user->createToken("blah");
        DB::commit();

        // $user->createAsStripeCustomer();

        return dataResponse($user);
    }

    public function logout(User $user)
    {
        $user->tokens->each(function ($token) {
            $token->delete();
        });
        return successResponse("Logout Successfully");
    }

    public function addIdentity(Request $request1, AddressRequest $request)
    {
        $data = $request->validated();
        $data = array_merge($data, $request1->validate([
            "nationality_id" => "required|numeric|exists:nationalities,id"
        ]));

        DB::beginTransaction();

        $address = Address::create($data);
        $data["address_id"] = $address->id;
        $update = array_intersect_key($data, ["address_id" => "", "nationality_id" => ""]);
        // dd($update, ["address_id" => $data["address_id"], "nationality_id" => $data["nationality_id"]]);
        $identity = Identity::where("user_id", $data["user_id"])->first()->update($update);
        if (!$identity) {
            throw new MessageException("Cannot Update Address");
        }
        DB::commit();

        return dataResponse($data);
    }

    public function blockUser(User $user)
    {
        //permission
        $user->update(["status" => false]);

        return successResponse("Block Successfully");
    }

    // public function generate_username($data)
    // {
    //     $username = strtolower($data["first_name"][0] . $data["last_name"]);
    //     $order = substr(User::withTrashed()->select("username")->where("username", "like", "$username%")->orderBy("username", "desc")->first()->username ?? $username . "0", strlen($username));
    //     $username = is_numeric($order) ? ($order == 0 ? $username : $username . ((int) $order + 1))  :  $username . "1";

    //     return $username;
    // }

    public function sendResetEmail(Request $request)
    {
        $data = $request->validate([
            "email" => "required|email|exists:users,email",
        ]);

        $token = Str::random(60);

        PasswordReset::updateOrCreate(
            ['email' => $data["email"]],
            [
                'email' => $data["email"],
                'token' => $token,
            ]
        );

        $user = User::where('email', $data["email"])->with("identity")->first();

        $toShow = [
            "full_name" => $user->identity->first_name . " " . $user->identity->last_name,
            "token" => $token,
        ];

        Mail::to($data["email"])->sendNow(new ResetPasswordMail($toShow));

        return successResponse("Please Check your Email with your reset password link");
    }

    public function resetPassword(Request $request)
    {
        $data = $request->validate([
            "token" => "required|exists:password_resets,token",
            "password" => "required|min:8|confirmed",
        ]);

        $password_reset = PasswordReset::where("token", $data["token"])->first();

        if (empty($password_reset)) {
            throw new MessageException("The link is already expired.");
        }

        if (Carbon::parse($password_reset->updated_at)->addMinutes(20)->isPast()) {
            $password_reset->delete();
            throw new MessageException("The link is already expired.");
        }

        $user = User::where("email", $password_reset["email"])->first();

        DB::beginTransaction();

        $user->update(["password" => bcrypt($data["password"])]);

        $password_reset->delete();

        DB::commit();

        $user->createToken("asd");

        return dataResponse($user);
    }

    public function checkResetToken($token)
    {
        $password_reset = PasswordReset::where("token", $token)->first();
        if (empty($password_reset)) {
            throw new MessageException("Token is invalid");
        }

        if (Carbon::parse($password_reset->updated_at)->addMinutes(20)->isPast()) {
            $password_reset->delete();
            throw new MessageException("The link is already expired.");
        }

        return successResponse("Token is valid");
    }

    public function eachUser()
    {
        $user = User::where("id", auth()->id())->with("identity")->first();

        return dataResponse(new UserResource($user));
    }

    public function editProfile(Request $request)
    {
        $user = User::find(auth()->id())->with("identity")->first();
        $data = $request->validate([
            "first_name" => "filled|max:255|alpha",
            "last_name" => "filled|max:255|alpha",
            "date_of_birth" => "filled|date|before:" . date("Y-m-d"),
            "phone_number" => "filled|string|min:6|max:14",
            "email" => "filled|max:255|email|unique:users,email," . $user->id,
        ]);

        $user->update($data);
        $user->identity->update($data);

        return dataResponse(new UserResource($user));
    }
}
