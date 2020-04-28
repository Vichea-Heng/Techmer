<?php

namespace App\Http\Controllers\Api\v1\Products;

use App\Http\Controllers\Controller;

use App\Models\Products\ProductBrand;
use App\Http\Requests\Products\ProductBrandRequest;
use App\Http\Resources\Products\ProductBrandResource;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ProductBrandController extends Controller
{

    public function __construct()
    {
    }

    public function index()
    {

        // $this->authorize("viewAny", ProductBrand::class);

        $datas = ProductBrand::get();

        $datas = (count($datas) == 0 ? ["message" => "Record not Found"] : ProductBrandResource::collection($datas));

        return response()->json($datas, Response::HTTP_OK);
    }

    public function indexOnlyTrashed()
    {

        // only super admin can access, and check with middleware at the __construct function

        $datas = ProductBrand::onlyTrashed()->get();

        $datas = (count($datas) == 0 ? ["message" => "Record not Found"] : ProductBrandResource::collection($datas));

        return response()->json($datas, Response::HTTP_OK);
    }

    public function store(ProductBrandRequest $request)
    {

        // $this->authorize("create", ProductBrand::class);

        $data = $request->validated();

        $data = ProductBrand::create($data);

        $data = new ProductBrandResource($data);

        return response()->json($data, Response::HTTP_OK);
    }

    public function show(ProductBrand $product_brand)
    {

        // $this->authorize("view", ProductBrand::class);

        $data = new ProductBrandResource($product_brand);

        return response()->json($data, Response::HTTP_OK);
    }

    public function update(ProductBrandRequest $request, ProductBrand $product_brand)
    {

        // $this->authorize("update", ProductBrand::class);

        $data = $request->validated();

        $product_brand->update($data);

        $data = new ProductBrandResource($product_brand);

        return response()->json($data, Response::HTTP_OK);
    }

    public function destroy(ProductBrand $product_brand)
    {

        // $this->authorize("delete", ProductBrand::class);

        $product_brand->delete();

        $data = ["message" => "Data Delete successfully !!!"];

        return response()->json($data, Response::HTTP_OK);
    }

    public function restore($id)
    {

        // only super admin can access, and check with middleware at the __construct function

        $data = ProductBrand::onlyTrashed()->findOrFail($id);

        $data->restore();

        $data = ["message" => "Data Restore successfully !!!"];

        return response()->json($data, Response::HTTP_OK);
    }

    public function forceDestroy($id)
    {

        // only super admin can access, and check with middleware at the __construct function

        $data = ProductBrand::withTrashed()->findOrFail($id);

        $data->forceDelete();

        $data = ['message' => "Data Force Delete Successfully !!!"];

        return response()->json($data, Response::HTTP_OK);
    }
}
