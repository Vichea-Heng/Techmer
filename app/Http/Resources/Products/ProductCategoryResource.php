<?php

namespace App\Http\Resources\Products;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductCategoryResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "category" => $this->category,
            "description" => $this->description,
            "posted_by" => $this->posted_by,
            'deleted_at' => $this->when(!empty($this->deleted_at), $this->deleted_at),
        ];
    }
}
