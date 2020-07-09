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

class UserController extends Controller
{
    public function login(Request $request)
    {
        $data = $request->validate([
            'username' => "required",
            'password' => "required",
        ]);

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

    public function loginAdmin(Request $request)
    {
        $data = $request->validate([
            'username' => "required",
            'password' => "required",
        ]);

        if (is_numeric($data["username"])) {
            $cred = ['phone_number' => $data["username"], 'password' => $data["password"]];
        } elseif (filter_var($data["username"], FILTER_VALIDATE_EMAIL)) {
            $cred = ['email' => $data["username"], 'password' => $data["password"]];
        } else {
            $cred = ['username' => $data["username"], 'password' => $data["password"]];
        }

        if (Auth::attempt($cred)) {
            if (!Auth::user()->hasRole("Super Admin") && !Auth::user()->hasRole("Admin"))
                throw new UnauthorizedException;

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
            "date_of_birth" => "required|date|before:" . Carbon::now(),
            "phone_number" => "required|string|min:6|max:14|unique:users",
            "phone_code" => "required|exists:countries,id",
            "email" => "required|max:255|email|unique:users",
            "password" => "required|min:3|max:255|confirmed",
        ]);

        $data["phone_number"] = Country::findOrFail($data["phone_code"])->dial_code + $data["phone_number"];
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

    public function registerAdmin(Request $request)
    {
        $data = $request->validate([
            "username" => "required|max:255|alpha_num|unique:users",
            "first_name" => "required|max:255|alpha",
            "last_name" => "required|max:255|alpha",
            "date_of_birth" => "required|date|before:" . Carbon::now(),
            "phone_number" => "required|string|min:6|max:14|unique:users",
            "phone_code" => "required|exists:countries,id",
            "email" => "required|max:255|email|unique:users",
            "password" => "required|min:3|max:255|confirmed",
        ]);

        $data["phone_number"] = Country::findOrFail($data["phone_code"])->dial_code + $data["phone_number"];
        // $data["username"] = $this->generate_username($data);

        $data["password"] = Hash::make($data["password"]);

        DB::beginTransaction();

        $user = User::create($data);
        $data["user_id"] = $user->id;
        Identity::create($data);

        $user->assignRole("Super Admin"); //should be admin 

        $user->success = $user->createToken("blah");
        DB::commit();

        // $user->createAsStripeCustomer();

        return dataResponse($user);
    }

    // public function assignAdmin(Request $request)
    // {
    // }

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

        Mail::to($data["email"])->sendNow(new ResetPasswordMail($token));

        return successResponse("Please Check your Email with your reset password link");
    }

    public function resetPassword(Request $request)
    {
        $data = $request->validate([
            "token" => "required",
            "password" => "required|min:8|confirmed",
        ]);

        $password_reset = PasswordReset::where("token", $data["token"])->first();

        if (Carbon::parse($password_reset->updated_at)->addMinutes(20)->isPast()) {
            $password_reset->delete();
            throw new MessageException("This password reset token is invalid.");
        }

        $user = User::where("email", $password_reset["email"])->first();

        $user->update(["password" => bcrypt($data["password"])]);

        $password_reset->delete();

        return successResponse("Reset Successfully");
    }

    public function userAdmin()
    {
        $datas = User::role(["Super Admin", "Admin"])->get();

        if (count($datas) == 0)
            throw new ModelNotFoundException();

        return dataResponse(UserResource::collection($datas));
    }
}
