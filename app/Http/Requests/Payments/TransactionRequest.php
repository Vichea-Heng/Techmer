<?php

namespace App\Http\Requests\Payments;

use App\Models\Products\ProductOption;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TransactionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $cart_id_rule = "bail|required|array";
        $each_cart_id_rule = "bail|required|integer|distinct|exists:user_carts,id";
        $discount_rule = "bail|required|numeric|gte:0|lte:100";
        $stripe_token_rule = "bail|required";

        return [
            "cart_id" => $cart_id_rule,
            "cart_id.*" => $each_cart_id_rule,
            "discount" => $discount_rule,
            "stripe_token" => $stripe_token_rule,
        ];
    }
}
