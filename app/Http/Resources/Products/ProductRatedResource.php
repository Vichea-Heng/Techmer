<?php

namespace App\Http\Resources\Products;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductRatedResource extends JsonResource
{
    public function toArray($request)
    {
        if ($this->deleted_at != NULL) {
            return [
                "product_id" => $this->product_id,
                "rated" => $this->rated ?? 0,
                'deleted_at' => $this->deleted_at,
            ];
        }

        return [
            "product_id" => $this->product_id,
            "rated" => $this->rated ?? 0,
        ];
    }
}
