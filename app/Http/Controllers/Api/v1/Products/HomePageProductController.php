<?php

namespace App\Http\Controllers\Api\v1\Products;

use App\Http\Controllers\Controller;

use App\Models\Products\HomePageProduct;
use App\Http\Requests\Products\HomePageProductRequest;
use App\Http\Resources\Products\HomePageProductResource;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class HomePageProductController extends Controller
{

    public function __construct()
    {
    }

    // public function index(){

    //     // $this->authorize("viewAny", HomePageProduct::class);

    //     $datas = HomePageProduct::get();

    //     if (count($datas) == 0)
    //         throw new ModelNotFoundException;

    //     return dataResponse(HomePageProductResource::collection($datas));
    // }

    // public function indexOnlyTrashed(){

    //     // only super admin can access, and check with middleware at the __construct function

    //     $datas = HomePageProduct::onlyTrashed()->get();  

    //     if (count($datas) == 0)
    //         throw new ModelNotFoundException;

    //     return dataResponse(HomePageProductResource::collection($datas));
    // }

    // public function store(HomePageProductRequest $request){

    //     // $this->authorize("create", HomePageProduct::class);

    //     $data = $request->validated();

    //     $data = HomePageProduct::create($data);

    //     return dataResponse(new HomePageProductResource($data));
    // }

    // public function show(HomePageProduct $home_page_product){

    //     // $this->authorize("view", HomePageProduct::class);

    //     return dataResponse(new HomePageProductResource($home_page_product));
    // }

    // public function update(HomePageProductRequest $request,HomePageProduct $home_page_product){

    //     // $this->authorize("update", HomePageProduct::class);

    //     $data = $request->validated();

    //     $home_page_product->update($data); 

    //     return dataResponse(new HomePageProductResource($home_page_product));
    // }

    // public function destroy(HomePageProduct $home_page_product){

    //     // $this->authorize("delete", HomePageProduct::class);

    //     $home_page_product->delete();

    //     return destoryResponse();
    // }

    // public function restore($id){

    //     // only super admin can access, and check with middleware at the __construct function

    //     $data = HomePageProduct::onlyTrashed()->findOrFail($id); 

    //     $data->restore();

    //     return restoreResponse();
    // }

    // public function forceDestroy($id){

    //     // only super admin can access, and check with middleware at the __construct function

    //     $data = HomePageProduct::withTrashed()->findOrFail($id);

    //     $data->forceDelete();

    //     return forceDestoryResponse();
    // }

    public function productHotDeal()
    {
        $datas = HomePageProduct::where("product_type", "product-hot-deal")->limit(6)->with(["product"])->get();

        if (count($datas) == 0)
            throw new ModelNotFoundException;

        return dataResponse(HomePageProductResource::collection($datas));
    }
    public function productPopular()
    {
        $datas = HomePageProduct::where("product_type", "product-popular")->limit(6)->with(["product"])->get();

        if (count($datas) == 0)
            throw new ModelNotFoundException;

        return dataResponse(HomePageProductResource::collection($datas));
    }
    public function productBestRating()
    {
        $datas = HomePageProduct::where("product_type", "product-best-rating")->limit(6)->with(["product"])->get();

        if (count($datas) == 0)
            throw new ModelNotFoundException;

        return dataResponse(HomePageProductResource::collection($datas));
    }
}
