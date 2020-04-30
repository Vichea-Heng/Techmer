<?php

namespace App\Http\Resources\Products;

use Illuminate\Http\Resources\Json\JsonResource;

class FavoriteProductResource extends JsonResource
{
    public function toArray($request)
    {
        if ($this->deleted_at != NULL) {
            return [
                "id" => $this->id,
                "user_id" => $this->user_id,
                "product_id" => $this->product_id,
                'deleted_at' => $this->deleted_at,
            ];
        }

        return [
            "id" => $this->id,
            "user_id" => $this->user_id,
            "product_id" => $this->product_id,
        ];
    }
}
