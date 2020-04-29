<?php

namespace App\Http\Resources\Products\Payment;

use Illuminate\Http\Resources\Json\JsonResource;

class UserCartResource extends JsonResource
{
    public function toArray($request)
    {
        if ($this->deleted_at != NULL) {
            return [
                "id" => $this->id,
                "user_id" => $this->user_id,
                "product_option_id" => $this->product_option_id,
                "qty" => $this->qty,
                'deleted_at' => $this->deleted_at,
            ];
        }

        return [
            "id" => $this->id,
            "user_id" => $this->user_id,
            "product_option_id" => $this->product_option_id,
            "qty" => $this->qty,
        ];
    }
}
