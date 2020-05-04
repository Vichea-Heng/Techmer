<?php

namespace App\Http\Controllers\Api\v1\Products;

use App\Http\Controllers\Controller;

use App\Models\Products\ProductOption;
use App\Http\Requests\Products\ProductOptionRequest;
use App\Http\Resources\Products\ProductOptionResource;
use App\Models\Products\Product;
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


        $id = ProductOption::withTrashed()->select("id")->where("id", "like", $data["product_id"] . "%")->orderBy("id", "desc")->first();

        $data["id"] = ($id ? $id->id + 1 : ($data["product_id"] * 1000 + 1));

        DB::beginTransaction();

        $path = "/Techmer/Products/" . $data["product_id"] . "/ProductOptions";

        $data["photo"] = check_file_exist($path, $data["id"], $data["photo"]->getClientOriginalExtension());
        Storage::putFileAs($path, $request->file("photo"), $data["photo"]);

        $data = ProductOption::create($data);

        DB::commit();

        $data = new ProductOptionResource($data);

        return response()->json($data, Response::HTTP_OK);
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

        $data = new ProductOptionResource($product_option);

        return response()->json($data, Response::HTTP_OK);
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

        $data = new ProductOptionResource($product_option);

        return response()->json($data, Response::HTTP_OK);
    }

    public function destroy(ProductOption $product_option)
    {

        // $this->authorize("delete", ProductOption::class);

        $product_option->UserCart->each(fn ($item) => $item->delete());

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

        Storage::delete("/Techmer/Products/" . $data->product_id . "/ProductOptions/" . $data->photo);

        $data = ['message' => "Data Force Delete Successfully !!!"];

        return response()->json($data, Response::HTTP_OK);
    }
}
