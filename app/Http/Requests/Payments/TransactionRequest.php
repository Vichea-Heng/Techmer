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

        $user_id_rule = "bail|required|numeric|exists:users,id";
        $card_id_rule = "bail|required|numeric|exists:user_carts,id";

        return [
            "user_id" => $user_id_rule,
            "cart_id" => $card_id_rule,
        ];
    }
}
