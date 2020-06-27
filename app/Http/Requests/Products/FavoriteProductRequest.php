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
        $product_id_rule = "bail|required|integer|exists:products,id,deleted_at,NULL";

        return [
            "product_id" => $product_id_rule,
        ];
    }
}
