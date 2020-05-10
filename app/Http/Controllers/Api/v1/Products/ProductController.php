<?php

namespace App\Http\Controllers\Api\v1\Products;

use App\Exceptions\MessageException;
use App\Http\Controllers\Controller;

use App\Models\Products\Product;
use App\Http\Requests\Products\ProductRequest;
use App\Http\Resources\Products\ProductResource;
use App\Models\Products\ProductRated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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

        DB::beginTransaction();

        $data = Product::create($data);

        ProductRated::create(["product_id" => $data->id]);

        $path = "/Techmer/Products/" . $data->id . "/Gallery";

        $gallery_name = array();

        foreach ($request->file("photo") as $key => $gallery) {
            $file_name = check_file_exist($path, $data->id . "-" . ($key + 1), $gallery->getClientOriginalExtension());
            Storage::putFileAs($path, $gallery, $file_name);
            array_push($gallery_name, $file_name);
        }
        $data->update(["gallery" => json_encode($gallery_name)]);

        DB::commit();

        $data = new ProductResource($data);

        return response()->json($data, Response::HTTP_OK);
    }

    public function getFile(Product $product, $file_name)
    {
        return response()->file(storage_path("app/Techmer/Products/" . $product->id . "/Gallery/$file_name"));
    }

    public function deleteFile(Request $request, Product $product)
    {
        $data = $request->validate([
            "photo" => "bail|required|array",
            "photo.*" => "bail|required",
        ]);
        $path = "/Techmer/Products/" . $product->id . "/Gallery";
        $gallery_name = json_decode($product->gallery);
        $to_delete = array();

        foreach ($data["photo"] as $each) {
            if (in_array($each, $gallery_name)) {
                array_push($to_delete, $each);
            }
        }

        $gallery_name = array_values(array_filter($gallery_name, function ($val) use ($to_delete) {
            return !in_array($val, $to_delete);
        }));
        Storage::delete(array_map(fn ($val) => "$path/" . $val, $to_delete));

        foreach ($gallery_name as $key => &$each) {
            $ext = pathinfo($each, PATHINFO_EXTENSION);
            $file_name = check_file_exist($path, $product->id . "-" . ($key + 1), $ext);

            Storage::move("$path/" . $each, "$path/" . $file_name);
            if (!Storage::exists("$path/" . $product->id . "-" . ($key + 1) . "." . $ext)) {
                Storage::move("$path/" . $file_name, "$path/" . ($product->id . "-" . ($key + 1) . "." . $ext));
                $file_name = $product->id . "-" . ($key + 1) . "." . $ext;
            }
            $each = $file_name;
        }

        $product->update(["gallery" => json_encode($gallery_name)]);

        $data = new ProductResource($product);

        return response()->json($data, Response::HTTP_OK);
    }

    public function addFile(Request $request, Product $product)
    {
        $gallery_name = json_decode($product->gallery);
        $cnt = count($gallery_name);
        if ($cnt >= 10) {
            throw new MessageException("Photo can not add more than 10");
        }

        $data = $request->validate([
            "photo" => "bail|required|array|max:" . (10 - $cnt),
            "photo.*" => "bail|required|image|max:15000",
        ]);
        $path = "/Techmer/Products/" . $product->id . "/Gallery";
        foreach ($request->file("photo") as $key => $gallery) {
            $file_name = check_file_exist($path, $product->id . "-" . ($key + 1 + $cnt), $gallery->getClientOriginalExtension());
            Storage::putFileAs($path, $gallery, $file_name);
            array_push($gallery_name, $file_name);
        }

        $product->update(["gallery" => json_encode($gallery_name)]);

        $data = new ProductResource($product);

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

        $data->checkBeforeRestore();

        $data->restore();

        $data = ["message" => "Data Restore successfully !!!"];

        return response()->json($data, Response::HTTP_OK);
    }

    public function forceDestroy($id)
    {

        // only super admin can access, and check with middleware at the __construct function

        $data = Product::withTrashed()->findOrFail($id);

        $data->beforeForceDelete();

        $data->forceDelete();

        Storage::deleteDirectory("/Techmer/Products/" . $id);

        $data = ['message' => "Data Force Delete Successfully !!!"];

        return response()->json($data, Response::HTTP_OK);
    }
}
