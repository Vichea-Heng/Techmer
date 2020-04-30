<?php

namespace App\Http\Controllers\Api\v1\Payments;

use App\Exceptions\MessageException;
use App\Http\Controllers\Controller;

use App\Models\Payments\Transaction;
use App\Http\Requests\Payments\TransactionRequest;
use App\Http\Resources\Payments\TransactionResource;
use App\Models\Payments\UserCart;
use App\Models\Products\ProductOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class TransactionController extends Controller
{

    public function __construct()
    {
    }

    public function index()
    {

        // $this->authorize("viewAny", Transaction::class);

        $datas = Transaction::get();

        $datas = (count($datas) == 0 ? ["message" => "Record not Found"] : TransactionResource::collection($datas));

        return response()->json($datas, Response::HTTP_OK);
    }

    public function indexOnlyTrashed()
    {

        // only super admin can access, and check with middleware at the __construct function

        $datas = Transaction::onlyTrashed()->get();

        $datas = (count($datas) == 0 ? ["message" => "Record not Found"] : TransactionResource::collection($datas));

        return response()->json($datas, Response::HTTP_OK);
    }

    public function store(TransactionRequest $request)
    {
        // $this->authorize("create", Transaction::class);

        $data = $request->validated();

        $cart = UserCart::findOrFail($data["cart_id"])->first();

        $data["product_option_id"] = $cart->product_option_id;
        $data["qty"] = $cart->qty;

        $product = ProductOption::findOrFail($data["product_option_id"])->first();
        if ($product->qty < $data["qty"]) {
            $qty = $data["qty"];
            throw new MessageException("The qty must be less than or equal $qty.");
        }

        DB::beginTransaction();
        $data = Transaction::create($data);
        $cart->delete();
        $product->update(["qty" => ($product->qty - $data["qty"])]);
        DB::commit();

        $data = new TransactionResource($data);

        return response()->json($data, Response::HTTP_OK);
    }

    public function show(Transaction $transaction)
    {

        // $this->authorize("view", Transaction::class);

        $data = new TransactionResource($transaction);

        return response()->json($data, Response::HTTP_OK);
    }

    // public function update(TransactionRequest $request, Transaction $transaction)
    // {

    //     // $this->authorize("update", Transaction::class);

    //     $data = $request->validated();

    //     $transaction->update($data);

    //     $data = new TransactionResource($transaction);

    //     return response()->json($data, Response::HTTP_OK);
    // }

    public function destroy(Transaction $transaction)
    {

        // $this->authorize("delete", Transaction::class);

        $transaction->delete();

        $data = ["message" => "Data Delete successfully !!!"];

        return response()->json($data, Response::HTTP_OK);
    }

    public function restore($id)
    {

        // only super admin can access, and check with middleware at the __construct function

        $data = Transaction::onlyTrashed()->findOrFail($id);

        $data->restore();

        $data = ["message" => "Data Restore successfully !!!"];

        return response()->json($data, Response::HTTP_OK);
    }

    public function forceDestroy($id)
    {

        // only super admin can access, and check with middleware at the __construct function

        $data = Transaction::withTrashed()->findOrFail($id);

        $data->forceDelete();

        $data = ['message' => "Data Force Delete Successfully !!!"];

        return response()->json($data, Response::HTTP_OK);
    }
}
