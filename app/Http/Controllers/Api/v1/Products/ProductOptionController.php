<?php

namespace App\Http\Controllers\Api\v1\Products;

use App\Http\Controllers\Controller;

use App\Models\Products\ProductOption;
use App\Http\Requests\Products\ProductOptionRequest;
use App\Http\Resources\Products\ProductOptionResource;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ProductOptionController extends Controller
{

    public function __construct()
    {
    }

    public function index()
    {

        // $this->authorize("viewAny", ProductOption::class);

        $datas = ProductOption::get();

        $datas = (count($datas) == 0 ? ["message" => "Record not Found"] : ProductOptionResource::collection($datas));

        return response()->json($datas, Response::HTTP_OK);
    }

    public function indexOnlyTrashed()
    {

        // only super admin can access, and check with middleware at the __construct function

        $datas = ProductOption::onlyTrashed()->get();

        $datas = (count($datas) == 0 ? ["message" => "Record not Found"] : ProductOptionResource::collection($datas));

        return response()->json($datas, Response::HTTP_OK);
    }

    public function store(ProductOptionRequest $request)
    {

        // $this->authorize("create", ProductOption::class);

        $data = $request->validated();

        $data = ProductOption::create($data);

        $data = new ProductOptionResource($data);

        return response()->json($data, Response::HTTP_OK);
    }

    public function show(ProductOption $product_option)
    {

        // $this->authorize("view", ProductOption::class);

        $data = new ProductOptionResource($product_option);

        return response()->json($data, Response::HTTP_OK);
    }

    public function update(ProductOptionRequest $request, ProductOption $product_option)
    {

        // $this->authorize("update", ProductOption::class);

        $data = $request->validated();

        $product_option->update($data);

        $data = new ProductOptionResource($product_option);

        return response()->json($data, Response::HTTP_OK);
    }

    public function destroy(ProductOption $product_option)
    {

        // $this->authorize("delete", ProductOption::class);

        $product_option->delete();

        $data = ["message" => "Data Delete successfully !!!"];

        return response()->json($data, Response::HTTP_OK);
    }

    public function restore($id)
    {

        // only super admin can access, and check with middleware at the __construct function

        $data = ProductOption::onlyTrashed()->findOrFail($id);

        $data->restore();

        $data = ["message" => "Data Restore successfully !!!"];

        return response()->json($data, Response::HTTP_OK);
    }

    public function forceDestroy($id)
    {

        // only super admin can access, and check with middleware at the __construct function

        $data = ProductOption::withTrashed()->findOrFail($id);

        $data->forceDelete();

        $data = ['message' => "Data Force Delete Successfully !!!"];

        return response()->json($data, Response::HTTP_OK);
    }
}
