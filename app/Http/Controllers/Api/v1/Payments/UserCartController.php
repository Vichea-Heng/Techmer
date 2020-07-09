<?php

namespace App\Http\Controllers\Api\v1\Payments;

use App\Http\Controllers\Controller;

use App\Models\Payments\UserCart;
use App\Http\Requests\Payments\UserCartRequest;
use App\Http\Resources\Payments\UserCartResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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

        if (count($datas) == 0)
            throw new ModelNotFoundException;

        return dataResponse(UserCartResource::collection($datas));
    }

    // public function indexOnlyTrashed()
    // {

    //     // only super admin can access, and check with middleware at the __construct function

    //     $datas = UserCart::onlyTrashed()->get();

    //     $datas = (count($datas) == 0 ? ["message" => "Record not Found"] : UserCartResource::collection($datas));

    //     return response()->json($datas, Response::HTTP_OK);
    // }

    public function store(UserCartRequest $request)
    {

        // $this->authorize("create", UserCart::class);

        $data = $request->validated();

        // $id = UserCart::select("id")->where("id", "like", $data["user_id"] . "%")->orderBy("id", "desc")->first();

        // $data["id"] = ($id ? $id->id + 1 : ($data["user_id"] * 100 + 1));

        $data = UserCart::create($data);

        return dataResponse(new UserCartResource($data));
    }

    public function show(UserCart $user_cart)
    {

        // $this->authorize("view", UserCart::class);

        return dataResponse(new UserCartResource($user_cart));
    }

    public function update(UserCartRequest $request, UserCart $user_cart)
    {

        // $this->authorize("update", UserCart::class);

        $data = $request->validated();

        $user_cart->update($data);

        return dataResponse(new UserCartResource($user_cart));
    }

    public function destroy(UserCart $user_cart)
    {

        // $this->authorize("delete", UserCart::class);

        $user_cart->delete();

        return destoryResponse();
    }

    // public function restore($id)
    // {

    //     // only super admin can access, and check with middleware at the __construct function

    //     $data = UserCart::onlyTrashed()->findOrFail($id);

    //     $data->restore();

    //     $data = ["message" => "Data Restore successfully !!!"];

    //     return response()->json($data, Response::HTTP_OK);
    // }

    // public function forceDestroy($id)
    // {

    //     // only super admin can access, and check with middleware at the __construct function

    //     $data = UserCart::withTrashed()->findOrFail($id);

    //     $data->forceDelete();

    //     $data = ['message' => "Data Force Delete Successfully !!!"];

    //     return response()->json($data, Response::HTTP_OK);
    // }

    public function eachUser()
    {
        $datas = UserCart::where("user_id", auth()->id())->get();

        if (count($datas) == 0)
            throw new ModelNotFoundException;

        return dataResponse(UserCartResource::collection($datas));
    }

    public function clearCart()
    {
        $datas = UserCart::where("user_id", auth()->id())->get()->each(fn ($each) => $each->delete());

        return successResponse("Delete Successfully");
    }
}
