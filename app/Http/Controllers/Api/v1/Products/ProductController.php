<?php

namespace App\Http\Controllers\Api\v1\Products;

use App\Http\Controllers\Controller;

use App\Models\Products\Product;
use App\Http\Requests\Products\ProductRequest;
use App\Http\Resources\Products\ProductResource;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{

    public function __construct()
    {
    }

    public function index()
    {

        // $this->authorize("viewAny", Product::class);

        $datas = Product::get();

        $datas = (count($datas) == 0 ? ["message" => "Record not Found"] : ProductResource::collection($datas));

        return response()->json($datas, Response::HTTP_OK);
    }

    public function indexOnlyTrashed()
    {

        // only super admin can access, and check with middleware at the __construct function

        $datas = Product::onlyTrashed()->get();

        $datas = (count($datas) == 0 ? ["message" => "Record not Found"] : ProductResource::collection($datas));

        return response()->json($datas, Response::HTTP_OK);
    }

    public function store(ProductRequest $request)
    {

        // $this->authorize("create", Product::class);

        $data = $request->validated();

        $data = Product::create($data);

        $data = new ProductResource($data);

        return response()->json($data, Response::HTTP_OK);
    }

    public function show(Product $product)
    {

        // $this->authorize("view", Product::class);

        $data = new ProductResource($product);

        return response()->json($data, Response::HTTP_OK);
    }

    public function update(ProductRequest $request, Product $product)
    {

        // $this->authorize("update", Product::class);

        $data = $request->validated();

        $product->update($data);

        $data = new ProductResource($product);

        return response()->json($data, Response::HTTP_OK);
    }

    public function publishProduct(Product $product)
    {
        $product->update(["published" => !$product->published]);

        $data = new ProductResource($product);

        return response()->json($data, Response::HTTP_OK);
    }

    public function destroy(Product $product)
    {
        // $this->authorize("delete", Product::class);

        $product->delete();

        $data = ["message" => "Data Delete successfully !!!"];

        return response()->json($data, Response::HTTP_OK);
    }

    public function restore($id)
    {

        // only super admin can access, and check with middleware at the __construct function

        $data = Product::onlyTrashed()->findOrFail($id);

        $data->restore();

        $data = ["message" => "Data Restore successfully !!!"];

        return response()->json($data, Response::HTTP_OK);
    }

    public function forceDestroy($id)
    {

        // only super admin can access, and check with middleware at the __construct function

        $data = Product::withTrashed()->findOrFail($id);

        $data->forceDelete();

        $data = ['message' => "Data Force Delete Successfully !!!"];

        return response()->json($data, Response::HTTP_OK);
    }
}
