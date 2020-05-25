<?php

namespace App\Http\Controllers\Api\v1\Payments;

use App\Exceptions\MessageException;
use App\Http\Controllers\Controller;
use Cartalyst\Stripe\Laravel\Facades\Stripe;

use App\Models\Payments\Transaction;
use App\Http\Requests\Payments\TransactionRequest;
use App\Http\Resources\Payments\TransactionResource;
use App\Models\Payments\UserCart;
use App\Models\Products\ProductOption;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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

        if (count($datas) == 0)
            throw new ModelNotFoundException;

        return dataResponse(TransactionResource::collection($datas));
    }

    // public function indexOnlyTrashed()
    // {

    //     // only super admin can access, and check with middleware at the __construct function

    //     $datas = Transaction::onlyTrashed()->get();

    //     $datas = (count($datas) == 0 ? ["message" => "Record not Found"] : TransactionResource::collection($datas));

    //     return response()->json($datas, Response::HTTP_OK);
    // }

    public function store(TransactionRequest $request)
    {
        // $this->authorize("create", Transaction::class);

        $data = $request->validated();

        $total = 0;
        DB::beginTransaction();
        foreach ($data["cart_id"] as $cart) {
            $cart = UserCart::findOrFail($cart);
            $product = ProductOption::findOrFail($cart->product_option_id);

            if ($product->qty < $cart->qty) {
                throw new MessageException("The qty must be less than or equal " . $product->qty . ".");
            }

            $data = Transaction::create([
                "user_id" => $data["user_id"],
                "product_option_id" => $cart->product_option_id,
                "discount" => $data["discount"],
                "purchase_price" => ($total += $product->price * $cart->qty * (100 - $data["discount"]) / 100),
                "qty" => $cart->qty,
            ]);
            $cart->delete();
            $product->update(["qty" => ($product->qty - $cart->qty)]);
        }
        try {
            Stripe::charges()->create([
                'amount' => $total,
                'currency' => "USD",
                'source' => $request->stripe_token,
                'description' => "",
                'receipt_email' => "mr.vichea.007@gmail.com",
            ]);
        } catch (\Throwable $th) {
            throw new MessageException($th);
        }
        DB::commit();

        // $data = new TransactionResource($data);
        // $data = ["message" => "SUCCESSFUL"];

        return successResponse("SUCCESSFUL");
    }

    public function show(Transaction $transaction)
    {

        // $this->authorize("view", Transaction::class);

        return dataResponse(new TransactionResource($transaction));
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

        return destoryResponse();
    }

    // public function restore($id)
    // {

    //     // only super admin can access, and check with middleware at the __construct function

    //     $data = Transaction::onlyTrashed()->findOrFail($id);

    //     $data->restore();

    //     $data = ["message" => "Data Restore successfully !!!"];

    //     return response()->json($data, Response::HTTP_OK);
    // }

    // public function forceDestroy($id)
    // {

    //     // only super admin can access, and check with middleware at the __construct function

    //     $data = Transaction::withTrashed()->findOrFail($id);

    //     $data->forceDelete();

    //     $data = ['message' => "Data Force Delete Successfully !!!"];

    //     return response()->json($data, Response::HTTP_OK);
    // }
}
