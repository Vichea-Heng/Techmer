<?php

namespace App\Http\Resources\Payments;

use Illuminate\Http\Resources\Json\JsonResource;

class CouponResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "coupon" => $this->coupon,
            "discount" => $this->discount,
            "expired_date" => date("Y-m-d", strtotime($this->expired_date)),
            "posted_by" => $this->user->identity->full_name,
            'deleted_at' => $this->when(!empty($this->deleted_at), $this->deleted_at),
        ];
    }
}
