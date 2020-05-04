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
            $phone_number_rule = ["filled", "numeric"];
        } else {
            $phone_number_rule = "required|numeric";
        }
        return [
            "phone_number" => $phone_number_rule,
        ];
    }
}
