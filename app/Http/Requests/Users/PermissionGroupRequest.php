<?php

namespace App\Http\Requests\Users;

use App\Rules\LetterSpaceRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PermissionGroupRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if ($this->method() == 'PATCH' or $this->method() == "PUT") {
            $name_rule = ["bail", "filled", new LetterSpaceRule, "unique:permission_groups,name," . $this->route("permission_group")->id];
        } else {
            $name_rule = ["bail", "required", new LetterSpaceRule, "unique:permission_groups"];
        }
        return [
            "name" => $name_rule,
        ];
    }
}
