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
            "from_country" => $this->country->country,
            "from_country_id" => $this->from_country,
            "posted_by" => $this->user->identity->full_name,
            'deleted_at' => $this->when(!empty($this->deleted_at), $this->deleted_at),
        ];
    }
}
