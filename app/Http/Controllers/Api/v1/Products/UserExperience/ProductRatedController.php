<?php

namespace App\Http\Controllers\Api\v1\Products\UserExperience;

use App\Http\Controllers\Controller;

use App\Models\Products\UserExperience\ProductRated;
use App\Http\Requests\Products\UserExperience\ProductRatedRequest;
use App\Http\Resources\Products\UserExperience\ProductRatedResource;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ProductRatedController extends Controller
{

    public function __construct()
    {
    }

    public function index()
    {

        // $this->authorize("viewAny", ProductRated::class);

        $datas = ProductRated::get();

        $datas = (count($datas) == 0 ? ["message" => "Record not Found"] : ProductRatedResource::collection($datas));

        return response()->json($datas, Response::HTTP_OK);
    }

    public function indexOnlyTrashed()
    {

        // only super admin can access, and check with middleware at the __construct function

        $datas = ProductRated::onlyTrashed()->get();

        $datas = (count($datas) == 0 ? ["message" => "Record not Found"] : ProductRatedResource::collection($datas));

        return response()->json($datas, Response::HTTP_OK);
    }

    public function store(ProductRatedRequest $request)
    {

        // $this->authorize("create", ProductRated::class);

        $data = $request->validated();

        $data = ProductRated::create($data);

        $data = new ProductRatedResource($data);

        return response()->json($data, Response::HTTP_OK);
    }

    public function show(ProductRated $product_rated)
    {

        // $this->authorize("view", ProductRated::class);

        $data = new ProductRatedResource($product_rated);

        return response()->json($data, Response::HTTP_OK);
    }

    public function update(ProductRatedRequest $request, ProductRated $product_rated)
    {

        // $this->authorize("update", ProductRated::class);

        $data = $request->validated();

        $product_rated->update($data);

        $data = new ProductRatedResource($product_rated);

        return response()->json($data, Response::HTTP_OK);
    }

    public function destroy(ProductRated $product_rated)
    {

        // $this->authorize("delete", ProductRated::class);

        $product_rated->delete();

        $data = ["message" => "Data Delete successfully !!!"];

        return response()->json($data, Response::HTTP_OK);
    }

    public function restore($id)
    {

        // only super admin can access, and check with middleware at the __construct function

        $data = ProductRated::onlyTrashed()->findOrFail($id);

        $data->restore();

        $data = ["message" => "Data Restore successfully !!!"];

        return response()->json($data, Response::HTTP_OK);
    }

    public function forceDestroy($id)
    {

        // only super admin can access, and check with middleware at the __construct function

        $data = ProductRated::withTrashed()->findOrFail($id);

        $data->forceDelete();

        $data = ['message' => "Data Force Delete Successfully !!!"];

        return response()->json($data, Response::HTTP_OK);
    }
}
