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

            $coupon_rule = [Rule::requiredIf(check_empty_array($request, "coupon")), "alpha", "unique:coupons,coupon," . $this->route("coupon")->id];
            $discount_rule = [Rule::requiredIf(check_empty_array($request, "discount")), "numeric"];
            $expired_date_rule = [Rule::requiredIf(check_empty_array($request, "expired_date")), "date"];
            $posted_by_rule = [Rule::requiredIf(check_empty_array($request, "posted_by")), "numeric", "exists:users,id"];
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
