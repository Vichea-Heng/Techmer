<?php

namespace App\Http\Resources\Products;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductOptionResource extends JsonResource
{
    public function toArray($request)
    {
        if ($this->deleted_at != NULL) {
            return [
                "id" => $this->id,
                "product_id" => $this->product_id,
                "option" => $this->option,
                "price" => $this->price,
                "qty" => $this->qty,
                "discount" => $this->discount,
                "warrenty" => $this->warrenty,
                'deleted_at' => $this->deleted_at,
            ];
        }

        return [
            "id" => $this->id,
            "product_id" => $this->product_id,
            "option" => $this->option,
            "price" => $this->price,
            "qty" => $this->qty,
            "discount" => $this->discount,
            "warrenty" => $this->warrenty,
        ];
    }
}
