<?php

namespace App\Http\Requests\Products;

use App\Rules\LetterSpaceRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductOptionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if ($this->method() == 'PATCH' or $this->method() == "PUT") {

            $request = $this->all();
            $product_id_rule = [Rule::requiredIf(check_empty_array($request, "product_id")), "numeric", "exists:products,id"];
            $option_rule = [Rule::requiredIf(check_empty_array($request, "option")), Rule::unique("product_options")->where(function ($query) use ($request) {
                return $query->where(["product_id" => $request["product_id"], "option" => $request["option"]]);
            })];
            $price_rule = [Rule::requiredIf(check_empty_array($request, "price")), "numeric", "gte:0"];
            $qty_rule = [Rule::requiredIf(check_empty_array($request, "qty")), "numeric", "gte:0"];
            $discount_rule = [Rule::requiredIf(check_empty_array($request, "discount")), "numeric", "gte:0"];
            $warrenty_rule = [Rule::requiredIf(check_empty_array($request, "warrenty")), "alpha_num"];
        } else {
            $request = $this->all();
            $product_id_rule = "required|numeric|exists:products,id";
            $option_rule = ["required", Rule::unique("product_options")->where(function ($query) use ($request) {
                return $query->where(["product_id" => $request["product_id"], "option" => $request["option"]]);
            })];
            $price_rule = "required|numeric|gte:0";
            $qty_rule = "required|numeric|gte:0";
            $discount_rule = "required|numeric|gte:0";
            $warrenty_rule = "required|alpha_num";
        }
        return [
            "product_id" => $product_id_rule,
            "option" => $option_rule,
            "price" => $price_rule,
            "qty" => $qty_rule,
            "discount" => $discount_rule,
            "warrenty" => $warrenty_rule,
        ];
    }
}
