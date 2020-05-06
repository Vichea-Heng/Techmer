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
        if ($this->method() == 'PATCH' or $this->method() == "PUT") {
            $feedback_rule = "nullable";
            $rated_rule = "bail|filled|numeric|gte:0|lte:5";
            return [
                "feedback" => $feedback_rule,
                "rated" => $rated_rule,
            ];
        } else {
            $user_id_rule = "bail|required|integer|exists:users,id";
            $product_id_rule = "bail|required|integer|exists:products,id";
            $feedback_rule = "nullable";
            $rated_rule = "bail|required|numeric|gte:0|lte:5";
        }
        return [
            "user_id" => $user_id_rule,
            "product_id" => $product_id_rule,
            "feedback" => $feedback_rule,
            "rated" => $rated_rule,
        ];
    }
}
