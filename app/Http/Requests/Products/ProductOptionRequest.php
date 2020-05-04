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
            $data = $this->route("product_option");
            // $product_id_rule = [Rule::requiredIf(check_empty_array($request, "product_id")), "numeric", "exists:products,id"];
            $option_rule = [Rule::requiredIf(check_empty_array($request, "option")), Rule::unique("product_options")->where(function ($query) use ($request) {
                return $query->where(["product_id" => $request["product_id"], "option" => $request["option"], "category" => $request["category"]]);
            })->ignore($data->id)];
            $category_rule = [Rule::requiredIf(check_empty_array($request, "category"))];
            $price_rule = [Rule::requiredIf(check_empty_array($request, "price")), "numeric", "gte:0"];
            $qty_rule = [Rule::requiredIf(check_empty_array($request, "qty")), "numeric", "gte:0"];
            $discount_rule = [Rule::requiredIf(check_empty_array($request, "discount")), "numeric", "gte:0"];
            $warrenty_rule = [Rule::requiredIf(check_empty_array($request, "warrenty")), "alpha_num"];
            $photo_rule = [Rule::requiredIf(check_empty_array($request, "photo")), "image", "max:15000"];

            return [
                // "product_id" => $product_id_rule,
                "option" => $option_rule,
                "category" => $category_rule,
                "price" => $price_rule,
                "qty" => $qty_rule,
                "discount" => $discount_rule,
                "warrenty" => $warrenty_rule,
                "photo" => $photo_rule,
            ];
        } else {
            $request = $this->all();
            $product_id_rule = "required|numeric|exists:products,id";
            $category_rule = "required";
            $option_rule = ["bail", "required", Rule::unique("product_options")->where(function ($query) use ($request) {
                return $query->where(["product_id" => $request["product_id"], "option" => $request["option"], "category" => $request["category"] ?? ""]);
            })];
            $price_rule = "required|numeric|gte:0";
            $qty_rule = "required|numeric|gte:0";
            $discount_rule = "required|numeric|gte:0";
            $warrenty_rule = "required|alpha_num";
            $photo_rule = "required|image|max:15000";
        }
        return [
            "product_id" => $product_id_rule,
            "option" => $option_rule,
            "category" => $category_rule,
            "price" => $price_rule,
            "qty" => $qty_rule,
            "discount" => $discount_rule,
            "warrenty" => $warrenty_rule,
            "photo" => $photo_rule,
        ];
    }
}
