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
            $request = $this->all();
            $brand_rule = ["filled", new LetterSpaceRule, "unique:product_brands,brand," . $this->route("product_brand")->id];
            $from_country_rule = ["filled", "numeric", "exists:countries,id"];
            $posted_by_rule = ["filled", "numeric", "exists:users,id"];
        } else {
            $brand_rule = ["required", new LetterSpaceRule, "unique:product_brands"];
            $from_country_rule = "required|numeric|exists:countries,id";
            $posted_by_rule = "required|numeric|exists:users,id";
        }
        return [
            "brand" => $brand_rule,
            "from_country" => $from_country_rule,
            "posted_by" => $posted_by_rule,
        ];
    }
}
