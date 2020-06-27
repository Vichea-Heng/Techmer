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
            $category_rule = ["bail", "filled", new LetterSpaceRule, "unique:product_categories,category," . $this->route("product_category")->id];
            $description_rule = "nullable";
        } else {
            $category_rule = ["bail", "required", new LetterSpaceRule, "unique:product_categories"];
            $description_rule = "nullable";
        }
        return [
            "category" => $category_rule,
            "description" => $description_rule,
        ];
    }
}
