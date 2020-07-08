<?php

namespace App\Http\Resources\Products;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductOptionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "product_id" => $this->product_id,
            "option" => $this->option,
            "category" => $this->category,
            "price" => $this->price,
            "qty" => $this->qty,
            "discount" => $this->discount,
            "warrenty" => $this->warrenty,
            // "photo" => $this->photo,
            "posted_by" => $this->user->identity->full_name,
            'deleted_at' => $this->when(!empty($this->deleted_at), $this->deleted_at),
        ];
    }
}
