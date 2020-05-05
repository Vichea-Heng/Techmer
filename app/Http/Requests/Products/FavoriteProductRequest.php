<?php

namespace App\Http\Requests\Products;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FavoriteProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {

        $user_id_rule = "bail|required|integer|exists:users,id";
        $product_id_rule = "bail|required|integer|exists:products,id";

        return [
            "user_id" => $user_id_rule,
            "product_id" => $product_id_rule,
        ];
    }
}
