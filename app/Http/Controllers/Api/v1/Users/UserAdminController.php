<?php

namespace App\Http\Controllers\Api\v1\Users;

use App\Http\Controllers\Controller;

use App\Exceptions\MessageException;
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

class UserAdminController extends Controller
{

    public function __construct()
    {
    }

    public function index()
    {

        // $this->authorize("viewAny", User::class);

        $datas = User::role(["Super Admin", "Admin"])->with(["identity"])->get();

        if (count($datas) == 0)
            throw new ModelNotFoundException;

        return dataResponse(UserResource::collection($datas));
    }

    public function store(Request $request)
    {

        // $this->authorize("create", User::class);

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

        $user->assignRole("Super Admin"); //should be admin 

        $user->success = $user->createToken("blah");
        DB::commit();

        // $user->createAsStripeCustomer();

        return dataResponse($user);
    }

    public function show(User $user_admin)
    {
        if (!$user_admin->hasRole(["Super Admin", "Admin"])) {
            throw new MessageException("User not admin");
        }
        // $this->authorize("view", User::class);

        return dataResponse(new UserResource($user_admin));
    }

    public function update(Request $request, User $user_admin)
    {

        // $this->authorize("update", User::class);

        $data = $request->validate([
            "username" => "filled|max:255|alpha_num|unique:users,username," . $user_admin->id,
            "first_name" => "filled|max:255|alpha",
            "last_name" => "filled|max:255|alpha",
            "date_of_birth" => "filled|date|before:" . date("Y-m-d"),
            "phone_number" => "filled|string|min:6|max:14",
            "phone_code" => "required_with:phone_number|exists:countries,id",
            "email" => "filled|max:255|email|unique:users",
            "password" => "filled|min:3|max:255|confirmed",
        ]);

        $data["phone_number"] = Country::findOrFail($data["phone_code"])->phone_code . $data["phone_number"];

        if (!empty(User::where("phone_number", $data["phone_number"])->where("id", "!=", $user_admin->id)->first())) {
            throw ValidationException::withMessages(["phone_number" => "The phone number has already taken."]);
        }

        if (array_key_exists("phone_number", $data)) {
            $data["phone_number"] = Country::findOrFail($data["phone_code"])->dial_code + $data["phone_number"];
        }

        $user_admin->update($data);

        return dataResponse(new UserResource($user_admin));
    }

    public function destroy(User $user_admin)
    {
        // $this->authorize("delete", User::class);
        if (!$user_admin->hasRole(["Super Admin", "Admin"])) {
            throw new MessageException("User not admin");
        }

        $user_admin->delete();

        return destoryResponse();
    }

    public function loginAdmin(Request $request)
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
            if (!Auth::user()->hasRole("Super Admin") && !Auth::user()->hasRole("Admin"))
                throw new UnauthorizedException;

            $user = Auth::user()->createToken("asd");
            // $user = Auth::user()->createSetupIntent();

            return dataResponse($user);
        } else {
            throw new MessageException("Your Username and Password are incorrect");
        }
    }
}
