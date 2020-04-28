<?php

namespace App\Http\Controllers\Api\v1\Products;

use App\Http\Controllers\Controller;

use App\Models\Products\ProductCategory;
use App\Http\Requests\Products\ProductCategoryRequest;
use App\Http\Resources\Products\ProductCategoryResource;

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

        $datas = (count($datas) == 0 ? ["message" => "Record not Found"] : ProductCategoryResource::collection($datas));

        return response()->json($datas, Response::HTTP_OK);
    }

    public function indexOnlyTrashed()
    {

        // only super admin can access, and check with middleware at the __construct function

        $datas = ProductCategory::onlyTrashed()->get();

        $datas = (count($datas) == 0 ? ["message" => "Record not Found"] : ProductCategoryResource::collection($datas));

        return response()->json($datas, Response::HTTP_OK);
    }

    public function store(ProductCategoryRequest $request)
    {

        // $this->authorize("create", ProductCategory::class);

        $data = $request->validated();

        $data = ProductCategory::create($data);

        $data = new ProductCategoryResource($data);

        return response()->json($data, Response::HTTP_OK);
    }

    public function show(ProductCategory $product_category)
    {

        // $this->authorize("view", ProductCategory::class);

        $data = new ProductCategoryResource($product_category);

        return response()->json($data, Response::HTTP_OK);
    }

    public function update(ProductCategoryRequest $request, ProductCategory $product_category)
    {

        // $this->authorize("update", ProductCategory::class);

        $data = $request->validated();

        $product_category->update($data);

        $data = new ProductCategoryResource($product_category);

        return response()->json($data, Response::HTTP_OK);
    }

    public function destroy(ProductCategory $product_category)
    {

        // $this->authorize("delete", ProductCategory::class);

        $product_category->delete();

        $data = ["message" => "Data Delete successfully !!!"];

        return response()->json($data, Response::HTTP_OK);
    }

    public function restore($id)
    {

        // only super admin can access, and check with middleware at the __construct function

        $data = ProductCategory::onlyTrashed()->findOrFail($id);

        $data->restore();

        $data = ["message" => "Data Restore successfully !!!"];

        return response()->json($data, Response::HTTP_OK);
    }

    public function forceDestroy($id)
    {

        // only super admin can access, and check with middleware at the __construct function

        $data = ProductCategory::withTrashed()->findOrFail($id);

        $data->forceDelete();

        $data = ['message' => "Data Force Delete Successfully !!!"];

        return response()->json($data, Response::HTTP_OK);
    }
}
