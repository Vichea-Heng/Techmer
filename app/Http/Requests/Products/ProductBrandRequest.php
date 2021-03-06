<?php

namespace App\Http\Requests\Products;

use App\Rules\LetterSpaceRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductBrandRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if ($this->method() == 'PATCH' or $this->method() == "PUT") {
            $brand_rule = ["bail", "filled", new LetterSpaceRule, "unique:product_brands,brand," . $this->route("product_brand")->id];
            $from_country_rule = ["bail", "filled", "integer", "exists:countries,id"];
        } else {
            $brand_rule = ["bail", "required", new LetterSpaceRule, "unique:product_brands"];
            $from_country_rule = "bail|required|integer|exists:countries,id";
        }
        return [
            "brand" => $brand_rule,
            "from_country" => $from_country_rule,
        ];
    }
}
