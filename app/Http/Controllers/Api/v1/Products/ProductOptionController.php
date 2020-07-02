<?php

namespace App\Http\Controllers\Api\v1\Products;

use App\Http\Controllers\Controller;

use App\Models\Products\ProductOption;
use App\Http\Requests\Products\ProductOptionRequest;
use App\Http\Resources\Products\ProductOptionResource;
use App\Models\Products\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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

        if (count($datas) == 0)
            throw new ModelNotFoundException;

        return dataResponse(ProductOptionResource::collection($datas));
    }

    public function indexOnlyTrashed()
    {

        // only super admin can access, and check with middleware at the __construct function

        $datas = ProductOption::onlyTrashed()->get();

        if (count($datas) == 0)
            throw new ModelNotFoundException;

        return dataResponse(ProductOptionResource::collection($datas));
    }

    public function store(ProductOptionRequest $request)
    {

        // $this->authorize("create", ProductOption::class);

        $data = $request->validated();

        // $id = ProductOption::withTrashed()->select("id")->where("id", "like", $data["product_id"] . "%")->orderBy("id", "desc")->first();

        // $data["id"] = ($id ? $id->id + 1 : ($data["product_id"] * 1000 + 1));

        DB::beginTransaction();

        $path = "/Techmer/Products/" . $data["product_id"] . "/ProductOptions";

        $data = new ProductOption();
        // $data->save();
        dd($data->id);

        $data = ProductOption::create($data);

        $data["photo"] = checkFileExist($path, $data["id"], $data["photo"]->getClientOriginalExtension());
        Storage::putFileAs($path, $request->file("photo"), $data["photo"]);

        DB::commit();

        return dataResponse(new ProductOptionResource($data));
    }

    public function getFile(ProductOption $product_option)
    {
        // dd(storage_path("/app/Techmer/Products/" . $product_option->product_id . "/ProductOptions/" . $product_option->photo));
        // return Storage::download("/Techmer/Products/" . $product_option->product_id . "/ProductOptions/" . $product_option->photo);
        return response()->file(storage_path("/app/Techmer/Products/" . $product_option->product_id . "/ProductOptions/" . $product_option->photo));
    }

    public function show(ProductOption $product_option)
    {

        // $this->authorize("view", ProductOption::class);

        return dataResponse(new ProductOptionResource($product_option));
    }

    public function update(ProductOptionRequest $request, ProductOption $product_option)
    {

        // $this->authorize("update", ProductOption::class);

        $data = $request->validated();

        if (isset($data["photo"])) {

            $path = "/Techmer/Products/" . $product_option->product_id . "/ProductOptions";
            Storage::delete($path . "/" . $product_option->photo);
            Storage::putFileAs($path, $request->file("photo"), $product_option->photo);
            $data["photo"] = $product_option->photo;
        }

        $product_option->update($data);

        return dataResponse(new ProductOptionResource($product_option));
    }

    public function destroy(ProductOption $product_option)
    {

        // $this->authorize("delete", ProductOption::class);

        $product_option->userCarts->each(fn ($item) => $item->delete());
        $product_option->transactions->each(fn ($item) => $item->delete());

        $product_option->delete();

        return destoryResponse();
    }

    public function restore($id)
    {

        // only super admin can access, and check with middleware at the __construct function

        $data = ProductOption::onlyTrashed()->findOrFail($id);

        $data->restore();

        return restoreResponse();
    }

    public function forceDestroy($id)
    {

        // only super admin can access, and check with middleware at the __construct function

        $data = ProductOption::withTrashed()->findOrFail($id);

        $data->forceDelete();

        Storage::delete("/Techmer/Products/" . $data->product_id . "/ProductOptions/" . $data->photo);

        return forceDestoryResponse();
    }
}
