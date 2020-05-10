<?php

namespace App\Http\Controllers\Api\v1\Products;

use App\Http\Controllers\Controller;

use App\Models\Products\FavoriteProduct;
use App\Http\Requests\Products\FavoriteProductRequest;
use App\Http\Resources\Products\FavoriteProductResource;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class FavoriteProductController extends Controller
{

    public function __construct()
    {
    }

    public function index()
    {

        // $this->authorize("viewAny", FavoriteProduct::class);

        $datas = FavoriteProduct::get();

        $datas = (count($datas) == 0 ? ["message" => "Record not Found"] : FavoriteProductResource::collection($datas));

        return response()->json($datas, Response::HTTP_OK);
    }

    // public function indexOnlyTrashed()
    // {

    //     // only super admin can access, and check with middleware at the __construct function

    //     $datas = FavoriteProduct::onlyTrashed()->get();

    //     $datas = (count($datas) == 0 ? ["message" => "Record not Found"] : FavoriteProductResource::collection($datas));

    //     return response()->json($datas, Response::HTTP_OK);
    // }

    public function store(FavoriteProductRequest $request)
    {

        // $this->authorize("create", FavoriteProduct::class);

        $data = $request->validated();

        $data = FavoriteProduct::create($data);

        $data = new FavoriteProductResource($data);

        return response()->json($data, Response::HTTP_OK);
    }

    public function show(FavoriteProduct $favorite_product)
    {

        // $this->authorize("view", FavoriteProduct::class);

        $data = new FavoriteProductResource($favorite_product);

        return response()->json($data, Response::HTTP_OK);
    }

    // public function update(FavoriteProductRequest $request, FavoriteProduct $favorite_product)
    // {

    //     // $this->authorize("update", FavoriteProduct::class);

    //     $data = $request->validated();

    //     $favorite_product->update($data);

    //     $data = new FavoriteProductResource($favorite_product);

    //     return response()->json($data, Response::HTTP_OK);
    // }

    public function destroy(FavoriteProduct $favorite_product)
    {

        // $this->authorize("delete", FavoriteProduct::class);

        $favorite_product->delete();

        $data = ["message" => "Data Delete successfully !!!"];

        return response()->json($data, Response::HTTP_OK);
    }

    // public function restore($id)
    // {

    //     // only super admin can access, and check with middleware at the __construct function

    //     $data = FavoriteProduct::onlyTrashed()->findOrFail($id);

    //     $data->restore();

    //     $data = ["message" => "Data Restore successfully !!!"];

    //     return response()->json($data, Response::HTTP_OK);
    // }

    // public function forceDestroy($id)
    // {

    //     // only super admin can access, and check with middleware at the __construct function

    //     $data = FavoriteProduct::withTrashed()->findOrFail($id);

    //     $data->forceDelete();

    //     $data = ['message' => "Data Force Delete Successfully !!!"];

    //     return response()->json($data, Response::HTTP_OK);
    // }
}
