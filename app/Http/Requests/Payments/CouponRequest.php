<?php

namespace App\Http\Requests\Payments;

use App\Rules\LetterSpaceRule;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CouponRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if ($this->method() == 'PATCH' or $this->method() == "PUT") {
            $coupon_rule = ["bail", "filled", "alpha", "unique:coupons,coupon," . $this->route("coupon")->id];
            $discount_rule = ["bail", "filled", "numeric"];
            $expired_date_rule = ["bail", "filled", "date"];
            $posted_by_rule = ["bail", "filled", "integer", "exists:users,id,deleted_at,NULL"];
        } else {
            $coupon_rule = "bail|required|alpha_num|unique:coupons";
            $discount_rule = "bail|required|numeric";
            $expired_date_rule = "bail|required|date|after:" . Carbon::now();
            $posted_by_rule = "bail|required|integer|exists:users,id,deleted_at,NULL";
        }
        return [
            "coupon" => $coupon_rule,
            "discount" => $discount_rule,
            "expired_date" => $expired_date_rule,
            "posted_by" => $posted_by_rule,
        ];
    }
}
