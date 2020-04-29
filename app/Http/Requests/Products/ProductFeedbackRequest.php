<?php

namespace App\Http\Requests\Products;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductFeedbackRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $user_id_rule = "required|numeric|exists:users,id";
        $product_id_rule = "required|numeric|exists:products,id";
        $feedback_rule = "required";
        $rated_rule = "required|numeric|gte:0|lte:5";

        return [
            "user_id" => $user_id_rule,
            "product_id" => $product_id_rule,
            "feedback" => $feedback_rule,
            "rated" => $rated_rule,
        ];
    }
}
