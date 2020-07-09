<?php

namespace App\Http\Requests\Payments;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ShippingAddressRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if ($this->method() == 'PATCH' or $this->method() == "PUT") {
            $phone_number_rule = ["bail", "filled", "numeric"];
            $last_name_rule = "bail|filled|alpha";
            $first_name_rule = "bail|filled|alpha";
        } else {
            $phone_number_rule = "bail|required|numeric";
            $last_name_rule = "bail|required|alpha";
            $first_name_rule = "bail|required|alpha";
        }
        return [
            "phone_number" => $phone_number_rule,
            "last_name" => $last_name_rule,
            "first_name" => $first_name_rule,
        ];
    }
}
