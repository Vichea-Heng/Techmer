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
            $request = $this->all();

            $coupon_rule = [Rule::requiredIf(check_empty_array($request, "group_id")), "alpha", "unique:coupons,coupon," . $this->route("coupon")->id];
            $discount_rule = [Rule::requiredIf(check_empty_array($request, "group_id")), "numeric"];
            $expired_date_rule = [Rule::requiredIf(check_empty_array($request, "group_id")), "date"];
            $posted_by_rule = [Rule::requiredIf(check_empty_array($request, "group_id")), "numeric", "exists:users,id"];
        } else {
            $coupon_rule = "required|alpha_num|unique:coupons";
            $discount_rule = "required|numeric";
            $expired_date_rule = "required|date|after:" . Carbon::now();
            $posted_by_rule = "required|numeric|exists:users,id";
        }
        return [
            "coupon" => $coupon_rule,
            "discount" => $discount_rule,
            "expired_date" => $expired_date_rule,
            "posted_by" => $posted_by_rule,
        ];
    }
}
