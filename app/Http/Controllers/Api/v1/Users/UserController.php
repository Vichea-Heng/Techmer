<?php

namespace App\Http\Controllers\Api\v1\Users;

use App\Exceptions\MessageException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\AddressRequest;
use App\Models\Addresses\Address;
use App\Models\Users\Identity;
use App\Models\Users\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Hash;

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
            $user = Auth::user()->createToken("blah");
            // $user = Auth::user()->createSetupIntent();

            return response()->json($user, Response::HTTP_OK);
        } else {
            throw new MessageException("blah");
        }
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            "username" => "required|max:255|alpha_num|unique:users",
            "first_name" => "required|max:255|alpha",
            "last_name" => "required|max:255|alpha",
            "date_of_birth" => "required|date|before:" . Carbon::now(),
            "phone_number" => "required|numeric|unique:users",
            "email" => "required|max:255|email|unique:users",
            "password" => "required|min:3|max:255|confirmed",
        ]);

        // $data["username"] = $this->generate_username($data);

        $data["password"] = Hash::make($data["password"]);

        DB::beginTransaction();

        $user = User::create($data);
        $data["user_id"] = $user->id;
        Identity::create($data);

        $user->success = $user->createToken("blah");
        DB::commit();

        // $user->createAsStripeCustomer();

        return response()->json($user, Response::HTTP_OK);
    }

    public function logout(User $user)
    {
        $user->tokens->each(function ($token) {
            $token->delete();
        });
        return response()->json(["success" => "SUCCESSFULLY"], Response::HTTP_OK);
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

        return response()->json(["success" => $data], Response::HTTP_OK);
    }

    public function blockUser(User $user)
    {
        //permission
        $user->update(["status" => false]);

        return response()->json(["message" => "SUCCESSFUL"], Response::HTTP_OK);
    }

    // public function generate_username($data)
    // {
    //     $username = strtolower($data["first_name"][0] . $data["last_name"]);
    //     $order = substr(User::withTrashed()->select("username")->where("username", "like", "$username%")->orderBy("username", "desc")->first()->username ?? $username . "0", strlen($username));
    //     $username = is_numeric($order) ? ($order == 0 ? $username : $username . ((int) $order + 1))  :  $username . "1";

    //     return $username;
    // }
}
