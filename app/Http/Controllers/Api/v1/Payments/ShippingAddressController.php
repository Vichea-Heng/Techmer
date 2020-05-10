<?php

namespace App\Http\Controllers\Api\v1\Payments;

use App\Http\Controllers\Controller;

use App\Models\Payments\ShippingAddress;
use App\Http\Requests\Payments\ShippingAddressRequest;
use App\Http\Requests\Users\AddressRequest;
use App\Http\Resources\Payments\ShippingAddressResource;
use App\Models\Addresses\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ShippingAddressController extends Controller
{

    public function __construct()
    {
    }

    public function index()
    {

        // $this->authorize("viewAny", ShippingAddress::class);

        $datas = ShippingAddress::get();

        $datas = (count($datas) == 0 ? ["message" => "Record not Found"] : ShippingAddressResource::collection($datas));

        return response()->json($datas, Response::HTTP_OK);
    }

    public function indexOnlyTrashed()
    {

        // only super admin can access, and check with middleware at the __construct function

        $datas = ShippingAddress::onlyTrashed()->get();

        $datas = (count($datas) == 0 ? ["message" => "Record not Found"] : ShippingAddressResource::collection($datas));

        return response()->json($datas, Response::HTTP_OK);
    }

    public function store(ShippingAddressRequest $request, AddressRequest $request1)
    {

        // $this->authorize("create", ShippingAddress::class);

        $address = $request1->validated();
        $data = $request->validated();
        $address = Address::create($address);

        $data["address_id"] = $address->id;
        $data["user_id"] = $address->user_id;

        $data = ShippingAddress::create($data);

        $data = new ShippingAddressResource($data);

        return response()->json($data, Response::HTTP_OK);
    }

    public function show(ShippingAddress $shipping_address)
    {

        // $this->authorize("view", ShippingAddress::class);

        $data = new ShippingAddressResource($shipping_address);

        return response()->json($data, Response::HTTP_OK);
    }

    public function update(ShippingAddressRequest $request, AddressRequest $request1, ShippingAddress $shipping_address)
    {

        // $this->authorize("update", ShippingAddress::class);

        $data = $request->validated();

        $address = $request1->validated();

        DB::beginTransaction();
        $shipping_address->update($data);
        $shipping_address->address->update($address);
        DB::commit();

        $data = new ShippingAddressResource($shipping_address);

        return response()->json($data, Response::HTTP_OK);
    }

    public function destroy(ShippingAddress $shipping_address)
    {

        // $this->authorize("delete", ShippingAddress::class);

        $shipping_address->address->delete();

        $data = ["message" => "Data Delete successfully !!!"];

        return response()->json($data, Response::HTTP_OK);
    }

    public function restore($id)
    {

        // only super admin can access, and check with middleware at the __construct function

        $data = ShippingAddress::onlyTrashed()->findOrFail($id);

        $data->restore();

        $data = ["message" => "Data Restore successfully !!!"];

        return response()->json($data, Response::HTTP_OK);
    }

    public function forceDestroy($id)
    {

        // only super admin can access, and check with middleware at the __construct function

        $data = ShippingAddress::withTrashed()->findOrFail($id);

        $data->forceDelete();

        $data = ['message' => "Data Force Delete Successfully !!!"];

        return response()->json($data, Response::HTTP_OK);
    }
}
