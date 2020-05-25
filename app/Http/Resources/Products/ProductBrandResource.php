<?php

namespace App\Http\Resources\Products;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductBrandResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "brand" => $this->brand,
            "from_country" => $this->from_country,
            "posted_by" => $this->posted_by,
            'deleted_at' => $this->when(!empty($this->deleted_at), $this->deleted_at),
        ];
    }
}
