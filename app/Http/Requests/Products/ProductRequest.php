<?php

namespace App\Http\Requests\Products;

use App\Rules\LetterSpaceRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if ($this->method() == 'PATCH' or $this->method() == "PUT") {
            $request = $this->all();

            $title_rule = [Rule::requiredIf(check_empty_array($request, "title")), "unique:products,title," . $this->route("product")->id];
            $brand_id_rule = [Rule::requiredIf(check_empty_array($request, "brand_id")), "numeric", "exists:product_brands,id"];
            $content_rule = [Rule::requiredIf(check_empty_array($request, "content"))];
            $category_id_rule = [Rule::requiredIf(check_empty_array($request, "category_id")), "numeric", "exists:product_categories,id"];
            $posted_by_rule = [Rule::requiredIf(check_empty_array($request, "posted_by")), "numeric", "exists:users,id"];
        } else {
            $title_rule = ["required", "unique:products"];
            $brand_id_rule = "required|numeric|exists:product_brands,id";
            $content_rule = "required";
            $category_id_rule = "required|numeric|exists:product_categories,id";
            $posted_by_rule = "required|numeric|exists:users,id";
        }
        return [
            "title" => $title_rule,
            "brand_id" => $brand_id_rule,
            "content" => $content_rule,
            "category_id" => $category_id_rule,
            "posted_by" => $posted_by_rule,
        ];
    }
}
