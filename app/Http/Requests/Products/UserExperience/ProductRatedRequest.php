<?php

namespace App\Http\Requests\Products\UserExperience;

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
            $rated_rule = [Rule::requiredIf(check_empty_array($this->all(), "rated")), "numeric", "gte:0", "lte:5"];
            return [
                "rated" => $rated_rule,
            ];
        } else {
            $product_id_rule = "required|numeric|exists:products,id|unique:product_rateds";
            $rated_rule = "nullable|numeric|gte:0|lte:5";
            return [
                "product_id" => $product_id_rule,
                // "rated" => $rated_rule,
            ];
        }
    }
}
