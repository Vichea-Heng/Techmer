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
            $title_rule = ["filled", "unique:products,title," . $this->route("product")->id];
            $brand_id_rule = ["filled", "integer", "exists:product_brands,id"];
            $content_rule = ["filled"];
            $category_id_rule = ["filled", "integer", "exists:product_categories,id"];
            $posted_by_rule = ["filled", "integer", "exists:users,id"];
            return [
                "title" => $title_rule,
                "brand_id" => $brand_id_rule,
                "content" => $content_rule,
                "category_id" => $category_id_rule,
                "posted_by" => $posted_by_rule,
                // "published" => $published_rule,
            ];
        } else {
            $title_rule = ["required", "unique:products"];
            $brand_id_rule = "required|integer|exists:product_brands,id";
            $content_rule = "required";
            $category_id_rule = "required|integer|exists:product_categories,id";
            $posted_by_rule = "required|integer|exists:users,id";
            $published_rule = "required|boolean";
        }
        return [
            "title" => $title_rule,
            "brand_id" => $brand_id_rule,
            "content" => $content_rule,
            "category_id" => $category_id_rule,
            "posted_by" => $posted_by_rule,
            "published" => $published_rule,
        ];
    }
}
