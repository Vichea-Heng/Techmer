<?php

namespace App\Http\Controllers\Api\v1\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\Payments\ShippingAddressRequest;
use App\Models\Products\ProductBrand;
use App\Http\Requests\Products\ProductBrandRequest;
use App\Http\Resources\Products\ProductBrandResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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

        if (count($datas) == 0)
            throw new ModelNotFoundException;

        return dataResponse(ProductBrandResource::collection($datas));
    }

    public function indexOnlyTrashed()
    {

        // only super admin can access, and check with middleware at the __construct function

        $datas = ProductBrand::onlyTrashed()->get();

        if (count($datas) == 0)
            throw new ModelNotFoundException;

        return dataResponse(ProductBrandResource::collection($datas));
    }

    public function store(ProductBrandRequest $request)
    {

        // $this->authorize("create", ProductBrand::class);

        $data = $request->validated();

        $data = ProductBrand::create($data);

        return dataResponse(new ProductBrandResource($data));
    }

    public function show(ProductBrand $product_brand)
    {

        // $this->authorize("view", ProductBrand::class);

        return dataResponse(new ProductBrandResource($product_brand));
    }

    public function update(ProductBrandRequest $request, ProductBrand $product_brand)
    {

        // $this->authorize("update", ProductBrand::class);

        $data = $request->validated();

        $product_brand->update($data);

        return dataResponse(new ProductBrandResource($product_brand));
    }

    public function destroy(ProductBrand $product_brand)
    {

        // $this->authorize("delete", ProductBrand::class);

        $product_brand->delete();

        return destoryResponse();
    }

    public function restore($id)
    {

        // only super admin can access, and check with middleware at the __construct function

        $data = ProductBrand::onlyTrashed()->findOrFail($id);

        $data->restore();

        return restoreResponse();
    }

    public function forceDestroy($id)
    {

        // only super admin can access, and check with middleware at the __construct function

        $data = ProductBrand::withTrashed()->findOrFail($id);

        $data->forceDelete();

        return forceDestoryResponse();
    }
}
