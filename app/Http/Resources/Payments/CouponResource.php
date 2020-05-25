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
            "expired_date" => $this->expired_date,
            "posted_by" => $this->posted_by,
            'deleted_at' => $this->when(!empty($this->deleted_at), $this->deleted_at),
        ];
    }
}
