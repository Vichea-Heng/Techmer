<?php

namespace App\Http\Controllers\Api\v1\Products;

use App\Http\Controllers\Controller;

use App\Models\Products\ProductCategory;
use App\Http\Requests\Products\ProductCategoryRequest;
use App\Http\Resources\Products\ProductCategoryResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ProductCategoryController extends Controller
{

    public function __construct()
    {
    }

    public function index()
    {

        // $this->authorize("viewAny", ProductCategory::class);

        $datas = ProductCategory::get();

        if (count($datas) == 0)
            throw new ModelNotFoundException;

        return dataResponse(ProductCategoryResource::collection($datas));
    }

    public function indexOnlyTrashed()
    {

        // only super admin can access, and check with middleware at the __construct function

        $datas = ProductCategory::onlyTrashed()->get();

        if (count($datas) == 0)
            throw new ModelNotFoundException;

        return dataResponse(ProductCategoryResource::collection($datas));
    }

    public function store(ProductCategoryRequest $request)
    {

        // $this->authorize("create", ProductCategory::class);

        $data = $request->validated();

        $data = ProductCategory::create($data);

        return dataResponse(new ProductCategoryResource($data));
    }

    public function show(ProductCategory $product_category)
    {

        // $this->authorize("view", ProductCategory::class);

        return dataResponse(new ProductCategoryResource($product_category));
    }

    public function update(ProductCategoryRequest $request, ProductCategory $product_category)
    {

        // $this->authorize("update", ProductCategory::class);

        $data = $request->validated();

        $product_category->update($data);

        return dataResponse(new ProductCategoryResource($product_category));
    }

    public function destroy(ProductCategory $product_category)
    {

        // $this->authorize("delete", ProductCategory::class);

        $product_category->delete();

        return destoryResponse();
    }

    public function restore($id)
    {

        // only super admin can access, and check with middleware at the __construct function

        $data = ProductCategory::onlyTrashed()->findOrFail($id);

        $data->restore();

        return restoreResponse();
    }

    public function forceDestroy($id)
    {

        // only super admin can access, and check with middleware at the __construct function

        $data = ProductCategory::withTrashed()->findOrFail($id);

        $data->forceDelete();

        return forceDestoryResponse();
    }
}
