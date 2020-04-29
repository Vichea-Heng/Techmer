<?php

namespace App\Http\Controllers\Api\v1\Products\Payment;

use App\Http\Controllers\Controller;

use App\Models\Products\Payment\UserCart;
use App\Http\Requests\Products\Payment\UserCartRequest;
use App\Http\Resources\Products\Payment\UserCartResource;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserCartController extends Controller
{

    public function __construct()
    {
    }

    public function index()
    {

        // $this->authorize("viewAny", UserCart::class);

        $datas = UserCart::get();

        $datas = (count($datas) == 0 ? ["message" => "Record not Found"] : UserCartResource::collection($datas));

        return response()->json($datas, Response::HTTP_OK);
    }

    public function indexOnlyTrashed()
    {

        // only super admin can access, and check with middleware at the __construct function

        $datas = UserCart::onlyTrashed()->get();

        $datas = (count($datas) == 0 ? ["message" => "Record not Found"] : UserCartResource::collection($datas));

        return response()->json($datas, Response::HTTP_OK);
    }

    public function store(UserCartRequest $request)
    {

        // $this->authorize("create", UserCart::class);

        $data = $request->validated();

        $data = UserCart::create($data);

        $data = new UserCartResource($data);

        return response()->json($data, Response::HTTP_OK);
    }

    public function show(UserCart $user_cart)
    {

        // $this->authorize("view", UserCart::class);

        $data = new UserCartResource($user_cart);

        return response()->json($data, Response::HTTP_OK);
    }

    public function update(UserCartRequest $request, UserCart $user_cart)
    {

        // $this->authorize("update", UserCart::class);

        $data = $request->validated();

        $user_cart->update($data);

        $data = new UserCartResource($user_cart);

        return response()->json($data, Response::HTTP_OK);
    }

    public function destroy(UserCart $user_cart)
    {

        // $this->authorize("delete", UserCart::class);

        $user_cart->delete();

        $data = ["message" => "Data Delete successfully !!!"];

        return response()->json($data, Response::HTTP_OK);
    }

    public function restore($id)
    {

        // only super admin can access, and check with middleware at the __construct function

        $data = UserCart::onlyTrashed()->findOrFail($id);

        $data->restore();

        $data = ["message" => "Data Restore successfully !!!"];

        return response()->json($data, Response::HTTP_OK);
    }

    public function forceDestroy($id)
    {

        // only super admin can access, and check with middleware at the __construct function

        $data = UserCart::withTrashed()->findOrFail($id);

        $data->forceDelete();

        $data = ['message' => "Data Force Delete Successfully !!!"];

        return response()->json($data, Response::HTTP_OK);
    }
}
