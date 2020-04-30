<?php

namespace App\Http\Controllers\Api\v1\Payments;

use App\Http\Controllers\Controller;

use App\Models\Payments\Coupon;
use App\Http\Requests\Payments\CouponRequest;
use App\Http\Resources\Payments\CouponResource;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CouponController extends Controller
{

    public function __construct()
    {
    }

    public function index()
    {

        // $this->authorize("viewAny", Coupon::class);

        $datas = Coupon::get();

        $datas = (count($datas) == 0 ? ["message" => "Record not Found"] : CouponResource::collection($datas));

        return response()->json($datas, Response::HTTP_OK);
    }

    public function indexOnlyTrashed()
    {

        // only super admin can access, and check with middleware at the __construct function

        $datas = Coupon::onlyTrashed()->get();

        $datas = (count($datas) == 0 ? ["message" => "Record not Found"] : CouponResource::collection($datas));

        return response()->json($datas, Response::HTTP_OK);
    }

    public function store(CouponRequest $request)
    {

        // $this->authorize("create", Coupon::class);

        $data = $request->validated();

        $data = Coupon::create($data);

        $data = new CouponResource($data);

        return response()->json($data, Response::HTTP_OK);
    }

    public function show(Coupon $coupon)
    {

        // $this->authorize("view", Coupon::class);

        $data = new CouponResource($coupon);

        return response()->json($data, Response::HTTP_OK);
    }

    public function update(CouponRequest $request, Coupon $coupon)
    {

        // $this->authorize("update", Coupon::class);

        $data = $request->validated();

        $coupon->update($data);

        $data = new CouponResource($coupon);

        return response()->json($data, Response::HTTP_OK);
    }

    public function destroy(Coupon $coupon)
    {

        // $this->authorize("delete", Coupon::class);

        $coupon->delete();

        $data = ["message" => "Data Delete successfully !!!"];

        return response()->json($data, Response::HTTP_OK);
    }

    public function restore($id)
    {

        // only super admin can access, and check with middleware at the __construct function

        $data = Coupon::onlyTrashed()->findOrFail($id);

        $data->restore();

        $data = ["message" => "Data Restore successfully !!!"];

        return response()->json($data, Response::HTTP_OK);
    }

    public function forceDestroy($id)
    {

        // only super admin can access, and check with middleware at the __construct function

        $data = Coupon::withTrashed()->findOrFail($id);

        $data->forceDelete();

        $data = ['message' => "Data Force Delete Successfully !!!"];

        return response()->json($data, Response::HTTP_OK);
    }
}
