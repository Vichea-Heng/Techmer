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
            $title_rule = ["bail", "filled", "unique:products,title," . $this->route("product")->id];
            $brand_id_rule = ["bail", "filled", "integer", "exists:product_brands,id,deleted_at,NULL"];
            $short_description_rule = ["filled"];
            $full_description_rule = ["filled"];
            $category_id_rule = ["bail", "filled", "integer", "exists:product_categories,id,deleted_at,NULL"];
            return [
                "title" => $title_rule,
                "brand_id" => $brand_id_rule,
                "short_description" => $short_description_rule,
                "full_description" => $full_description_rule,
                // "content" => $content_rule,
                "category_id" => $category_id_rule,
                // "published" => $published_rule,
            ];
        } else {
            $title_rule = ["bail", "required", "unique:products"];
            $brand_id_rule = "bail|required|integer|exists:product_brands,id,deleted_at,NULL";
            $short_description_rule = ["required"];
            $full_description_rule = ["required"];
            $category_id_rule = "bail|required|integer|exists:product_categories,id,deleted_at,NULL";
            $published_rule = "bail|required|boolean";
            $photo_rule = "bail|required|array|max:10";
            $each_photo_rule = "bail|required|image|max:15000";
        }
        return [
            "title" => $title_rule,
            "brand_id" => $brand_id_rule,
            "short_description" => $short_description_rule,
            "full_description" => $full_description_rule,
            "category_id" => $category_id_rule,
            "published" => $published_rule,
            "photo" => $photo_rule,
            "photo.*" => $each_photo_rule,
        ];
    }
}
