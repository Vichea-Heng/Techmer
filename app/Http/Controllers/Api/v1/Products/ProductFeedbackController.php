<?php

namespace App\Http\Controllers\Api\v1\Products;

use App\Http\Controllers\Controller;

use App\Models\Products\ProductFeedback;
use App\Http\Requests\Products\ProductFeedbackRequest;
use App\Http\Resources\Products\ProductFeedbackResource;
use App\Models\Products\ProductRated;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ProductFeedbackController extends Controller
{

    public function __construct()
    {
    }

    public function index()
    {

        // $this->authorize("viewAny", ProductFeedback::class);

        $datas = ProductFeedback::get();

        $datas = (count($datas) == 0 ? ["message" => "Record not Found"] : ProductFeedbackResource::collection($datas));

        return response()->json($datas, Response::HTTP_OK);
    }

    public function indexOnlyTrashed()
    {

        // only super admin can access, and check with middleware at the __construct function

        $datas = ProductFeedback::onlyTrashed()->get();

        $datas = (count($datas) == 0 ? ["message" => "Record not Found"] : ProductFeedbackResource::collection($datas));

        return response()->json($datas, Response::HTTP_OK);
    }

    public function store(ProductFeedbackRequest $request)
    {

        // $this->authorize("create", ProductFeedback::class);

        $data = $request->validated();

        DB::beginTransaction();

        $data = ProductFeedback::create($data);

        $last_rated = ProductRated::findOrFail($data["product_id"]);

        $amount_rated = ProductFeedback::where("product_id", $data["product_id"])->count();

        $rated = (($last_rated->rated * (($amount_rated - 1) == 0 ? 1 : ($amount_rated - 1)) + $data["rated"])) / $amount_rated;

        $last_rated->update(["rated" => $rated]);

        DB::commit();

        $data = new ProductFeedbackResource($data);

        return response()->json($data, Response::HTTP_OK);
    }

    public function show(ProductFeedback $product_feedback)
    {

        // $this->authorize("view", ProductFeedback::class);

        $data = new ProductFeedbackResource($product_feedback);

        return response()->json($data, Response::HTTP_OK);
    }

    public function update(ProductFeedbackRequest $request, ProductFeedback $product_feedback)
    {

        // $this->authorize("update", ProductFeedback::class);

        $data = $request->validated();

        DB::beginTransaction();

        if (array_key_exists("rated", $data)) {
            $last_rated = ProductRated::findOrFail($product_feedback->product_id);

            $amount_rated = ProductFeedback::where("product_id", $product_feedback->product_id)->count();

            $rated = (($last_rated->rated * (($amount_rated) == 0 ? 1 : ($amount_rated))) - $product_feedback->rated + $data["rated"]) / $amount_rated;

            $last_rated->update(["rated" => $rated]);
        }

        $product_feedback->update($data);

        DB::commit();

        $data = new ProductFeedbackResource($product_feedback);

        return response()->json($data, Response::HTTP_OK);
    }

    public function destroy(ProductFeedback $product_feedback)
    {

        // $this->authorize("delete", ProductFeedback::class);

        $product_feedback->delete();

        $data = ["message" => "Data Delete successfully !!!"];

        return response()->json($data, Response::HTTP_OK);
    }

    public function restore($id)
    {

        // only super admin can access, and check with middleware at the __construct function

        $data = ProductFeedback::onlyTrashed()->findOrFail($id);

        $data->restore();

        $data = ["message" => "Data Restore successfully !!!"];

        return response()->json($data, Response::HTTP_OK);
    }

    public function forceDestroy($id)
    {

        // only super admin can access, and check with middleware at the __construct function

        $data = ProductFeedback::withTrashed()->findOrFail($id);

        $data->forceDelete();

        $data = ['message' => "Data Force Delete Successfully !!!"];

        return response()->json($data, Response::HTTP_OK);
    }
}
