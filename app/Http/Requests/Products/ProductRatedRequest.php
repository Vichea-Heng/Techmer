<?php

namespace App\Http\Requests\Products;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRatedRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if ($this->method() == 'PATCH' or $this->method() == "PUT") {
            $rated_rule = ["bail", "filled", "numeric", "gte:0", "lte:5"];
            return [
                "rated" => $rated_rule,
            ];
        } else {
            $product_id_rule = "bail|required|integer|exists:products,id,deleted_at,NULL|unique:product_rateds";
            $rated_rule = "bail|nullable|numeric|gte:0|lte:5";
            return [
                "product_id" => $product_id_rule,
                // "rated" => $rated_rule,
            ];
        }
    }
}
