<?php

namespace App\Http\Controllers\Api\v1\Products;

use App\Exceptions\MessageException;
use App\Http\Controllers\Controller;

use App\Models\Products\Product;
use App\Http\Requests\Products\ProductRequest;
use App\Http\Resources\Products\EachProductResource;
use App\Http\Resources\Products\ProductResource;
use App\Http\Resources\Products\SearchProductResource;
use App\Models\Products\ProductBrand;
use App\Models\Products\ProductCategory;
use App\Models\Products\ProductRated;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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

    public function index($page)
    {

        // $this->authorize("viewAny", Product::class);

        $datas = Product::paginate($page);

        if (count($datas) == 0)
            throw new ModelNotFoundException;

        $paginate = EachProductResource::collection($datas);

        // dd($datas);

        return dataResponse($datas);
    }

    public function indexOnlyTrashed()
    {

        // only super admin can access, and check with middleware at the __construct function

        $datas = Product::onlyTrashed()->get();

        if (count($datas) == 0)
            throw new ModelNotFoundException;

        return dataResponse(ProductResource::collection($datas));
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
            $file_name = checkFileExist($path, $data->id . "-" . ($key + 1), $gallery->getClientOriginalExtension());
            Storage::putFileAs($path, $gallery, $file_name);
            array_push($gallery_name, $file_name);
        }
        $data->update(["gallery" => json_encode($gallery_name)]);

        DB::commit();

        return dataResponse(new ProductResource($data));
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
            $file_name = checkFileExist($path, $product->id . "-" . ($key + 1), $ext);

            Storage::move("$path/" . $each, "$path/" . $file_name);
            if (!Storage::exists("$path/" . $product->id . "-" . ($key + 1) . "." . $ext)) {
                Storage::move("$path/" . $file_name, "$path/" . ($product->id . "-" . ($key + 1) . "." . $ext));
                $file_name = $product->id . "-" . ($key + 1) . "." . $ext;
            }
            $each = $file_name;
        }

        $product->update(["gallery" => json_encode($gallery_name)]);

        return dataResponse(new ProductResource($product));
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
            $file_name = checkFileExist($path, $product->id . "-" . ($key + 1 + $cnt), $gallery->getClientOriginalExtension());
            Storage::putFileAs($path, $gallery, $file_name);
            array_push($gallery_name, $file_name);
        }

        $product->update(["gallery" => json_encode($gallery_name)]);

        return dataResponse(new ProductResource($product));
    }

    public function show(Product $product)
    {

        // $this->authorize("view", Product::class);

        return dataResponse(new EachProductResource($product));
    }

    public function update(ProductRequest $request, Product $product)
    {

        // $this->authorize("update", Product::class);

        $data = $request->validated();

        $product->update($data);

        return dataResponse(new ProductResource($product));
    }

    public function publishProduct(Product $product)
    {
        DB::beginTransaction();

        $product->update(["published" => !$product->published]);

        if (!$product->published) {
            $product->productOptions->each(function ($item) {
                $item->userCarts->each(fn ($item2) => $item2->delete());
                $item->transactions->each(fn ($item2) => $item2->delete());
            });
        }

        DB::commit();

        return dataResponse(new ProductResource($product));
    }

    public function destroy(Product $product)
    {
        // $this->authorize("delete", Product::class);

        $product->productOptions->each(function ($item) {
            $item->userCarts->each(fn ($item2) => $item2->delete());
            $item->transactions->each(fn ($item2) => $item2->delete());
        });

        $product->delete();

        return destoryResponse();
    }

    public function restore($id)
    {

        // only super admin can access, and check with middleware at the __construct function

        $data = Product::onlyTrashed()->findOrFail($id);

        $data->restore();

        return restoreResponse();
    }

    public function forceDestroy($id)
    {

        // only super admin can access, and check with middleware at the __construct function

        $data = Product::withTrashed()->findOrFail($id);

        $data->forceDelete();

        Storage::deleteDirectory("/Techmer/Products/" . $id);

        return forceDestoryResponse();
    }

    public function productByCategory($id)
    {
        $datas = Product::where("category_id", $id)->get();

        if (count($datas) == 0)
            throw new ModelNotFoundException;

        return dataResponse(EachProductResource::collection($datas));
    }

    public function productByBrand($id)
    {
        $datas = Product::where("brand_id", $id)->get();

        if (count($datas) == 0)
            throw new ModelNotFoundException;

        return dataResponse(EachProductResource::collection($datas));
    }

    protected function searchAlgorithm($toSearch, &$array)
    {
        Product::where("title", "like", "%$toSearch%")->get()->each(function ($each) use (&$array) {
            array_push($array, new EachProductResource($each));
        });

        $datas = ProductBrand::where("brand", "like", "%$toSearch%")->with("products")->get();
        $datas->each(
            function ($each) use (&$array) {
                $each->products->each(function ($each1)  use (&$array) {
                    array_push($array, new EachProductResource($each1));
                });
            }
        );

        $datas = ProductCategory::where("category", "like", "%$toSearch%")->with("products")->get();

        $datas->each(
            function ($each) use (&$array) {
                $each->products->each(function ($each1)  use (&$array) {
                    array_push($array, new EachProductResource($each1));
                });
            }
        );
    }

    public function searchProduct(Request $request)
    {
        $data = $request->validate([
            "toSearch" => "required"
        ]);

        $array = [];
        $this->searchAlgorithm($data["toSearch"], $array);
        foreach (explode(" ", $data["toSearch"]) as $word) {
            $this->searchAlgorithm($word, $array);
        }

        if (count($array) == 0)
            throw new ModelNotFoundException;

        $tempArr = array_unique(array_column($array, 'id'));
        $array = array_intersect_key($array, $tempArr);

        return dataResponse($array);
    }
}
