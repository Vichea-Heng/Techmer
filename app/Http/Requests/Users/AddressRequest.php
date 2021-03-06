<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddressRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if ($this->method() == 'PATCH' or $this->method() == "PUT") {
            $address_line1_rule = ["bail", "filled"];
            $address_line2_rule = ["bail", "filled"];
            $country_id_rule = ["bail", "filled", "integer", "exists:countries,id"];
        } else {
            $address_line1_rule = "required";
            $address_line2_rule = "required";
            $country_id_rule = "bail|required|integer|exists:countries,id";
        }
        return [
            "address_line1" => $address_line1_rule,
            "address_line2" => $address_line2_rule,
            "country_id" => $country_id_rule,
        ];
    }
}
