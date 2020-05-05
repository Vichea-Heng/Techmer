<?php

namespace App\Http\Resources\Payments;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    public function toArray($request)
    {
        if ($this->deleted_at != NULL) {
            return [
                "id" => $this->id,
                "user_id" => $this->user_id,
                "product_option_id" => $this->product_option_id,
                "qty" => $this->qty,
                "purchase_price" => $this->purchase_price,
                "discount" => $this->discount,
                'deleted_at' => $this->deleted_at,
            ];
        }

        return [
            "id" => $this->id,
            "user_id" => $this->user_id,
            "product_option_id" => $this->product_option_id,
            "qty" => $this->qty,
            "purchase_price" => $this->purchase_price,
            "discount" => $this->discount,
        ];
    }
}
