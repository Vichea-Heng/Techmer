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
            $request = $this->all();

            $address_line1_rule = [Rule::requiredIf(check_empty_array($request, "address_line1"))];
            $address_line2_rule = [Rule::requiredIf(check_empty_array($request, "address_line2"))];
            $country_id_rule = [Rule::requiredIf(check_empty_array($request, "country_id")), "numeric','exists:countries,id"];

            return [
                "address_line1" => $address_line1_rule,
                "address_line2" => $address_line2_rule,
                "country_id" => $country_id_rule,
            ];
        } else {
            $user_id_rule = "required|numeric|exists:users,id";
            $address_line1_rule = "required";
            $address_line2_rule = "required";
            $country_id_rule = "required|numeric|exists:countries,id";
        }
        return [
            "user_id" => $user_id_rule,
            "address_line1" => $address_line1_rule,
            "address_line2" => $address_line2_rule,
            "country_id" => $country_id_rule,
        ];
    }
}
