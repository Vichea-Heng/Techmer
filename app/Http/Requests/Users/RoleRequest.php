<?php

namespace App\Http\Requests\Users;

use App\Rules\LetterSpaceRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoleRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if ($this->method() == 'PATCH' or $this->method() == "PUT") {
            $request = $this->all();

            $name_rule = ["bail", "filled", new LetterSpaceRule, Rule::unique("roles")->where(function ($query) use ($request) {
                return $query->where(["name" => $request["name"], "guard_name" => $request["guard_name"]]);
            })->ignore($this->route("role")->id)];
            $guard_name_rule = ["bail", "filled", "in:api,web"];
        } else {
            $name_rule = ["bail", "required", new LetterSpaceRule, Rule::unique("roles")->where(function ($query) {
                return $query->where(["name" => $this->get("name"), "guard_name" => $this->get("guard_name")]);
            })];
            $guard_name_rule = "bail|required|in:api,web";
        }
        return [
            "name" => $name_rule,
            "guard_name" => $guard_name_rule,
        ];
    }
}
