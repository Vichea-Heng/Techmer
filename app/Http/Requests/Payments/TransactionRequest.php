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

        $user_id_rule = "bail|required|integer|exists:users,id";
        $cart_id_rule = "bail|required|array";
        $each_cart_id_rule = "bail|required|integer|distinct|exists:user_carts,id";
        $discount_rule = "bail|required|numeric|gte:0|lte:100";

        return [
            "user_id" => $user_id_rule,
            "cart_id" => $cart_id_rule,
            "cart_id.*" => $each_cart_id_rule,
            "discount" => $discount_rule,
        ];
    }
}
