<?php

namespace App\Http\Requests\Payments;

use App\Models\Products\ProductOption;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserCartRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if ($this->method() == 'PATCH' or $this->method() == "PUT") {
            $product = ProductOption::where("id", $this->get("product_option_id"))->first();
            $qty_rule = ["bail", "filled", "integer", "gt:0", "" . ((isset($product->qty)) ? "lte:$product->qty" : "")];

            return [
                "qty" => $qty_rule,
            ];
        } else {
            $product = ProductOption::where("id", $this->get("product_option_id"))->first();
            $product_option_id_rule = ["bail", "required", "integer", "exists:product_options,id,deleted_at,NULL", function ($attribute, $value, $fail) use ($product) {
                if ($product->qty == 0) {
                    $fail($attribute . ' is not available.');
                }
            }];

            $qty_rule = "bail|required|integer|gt:0" . ((isset($product->qty)) ? "|lte:$product->qty" : "");
        }
        return [
            "product_option_id" => $product_option_id_rule,
            "qty" => $qty_rule,
        ];
    }
}
