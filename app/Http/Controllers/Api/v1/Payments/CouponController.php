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
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CouponController extends Controller
{

    public function __construct()
    {
    }

    public function index()
    {

        // $this->authorize("viewAny", Coupon::class);

        $datas = Coupon::get();

        if (count($datas) == 0)
            throw new ModelNotFoundException;

        return dataResponse(CouponResource::collection($datas));
    }

    public function indexOnlyTrashed()
    {

        // only super admin can access, and check with middleware at the __construct function

        $datas = Coupon::onlyTrashed()->get();

        if (count($datas) == 0)
            throw new ModelNotFoundException;

        return dataResponse(CouponResource::collection($datas));
    }

    public function store(CouponRequest $request)
    {

        // $this->authorize("create", Coupon::class);

        $data = $request->validated();

        $data = Coupon::create($data);

        return dataResponse(new CouponResource($data));
    }

    public function show(Coupon $coupon)
    {

        // $this->authorize("view", Coupon::class);

        return dataResponse(new CouponResource($coupon));
    }

    public function update(CouponRequest $request, Coupon $coupon)
    {

        // $this->authorize("update", Coupon::class);

        $data = $request->validated();

        $coupon->update($data);

        return dataResponse(new CouponResource($coupon));
    }

    public function destroy(Coupon $coupon)
    {

        // $this->authorize("delete", Coupon::class);

        $coupon->delete();

        return destoryResponse();
    }

    public function restore($id)
    {

        // only super admin can access, and check with middleware at the __construct function

        $data = Coupon::onlyTrashed()->findOrFail($id);

        $data->restore();

        return restoreResponse();
    }

    public function forceDestroy($id)
    {

        // only super admin can access, and check with middleware at the __construct function

        $data = Coupon::withTrashed()->findOrFail($id);

        $data->forceDelete();

        return forceDestoryResponse();
    }
}
