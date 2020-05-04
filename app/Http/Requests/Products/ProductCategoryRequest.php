<?php

namespace App\Http\Requests\Products;

use App\Rules\LetterSpaceRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductCategoryRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if ($this->method() == 'PATCH' or $this->method() == "PUT") {
            $request = $this->all();
            $category_rule = ["filled", new LetterSpaceRule, "unique:product_categories,category," . $this->route("product_category")->id];
            $description_rule = "nullable";
            $posted_by_rule = ["filled", "numeric", "exists:users,id"];
        } else {
            $category_rule = ["required", new LetterSpaceRule, "unique:product_categories"];
            $description_rule = "nullable";
            $posted_by_rule = "required|numeric|exists:users,id";
        }
        return [
            "category" => $category_rule,
            "description" => $description_rule,
            "posted_by" => $posted_by_rule,
        ];
    }
}
