<?php

namespace App\Http\Resources\Products;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "title" => $this->title,
            "brand" => $this->productBrand->brand,
            "brand_id" => $this->brand_id,
            "short_description" => $this->short_description,
            "full_description" => $this->full_description,
            "category" => $this->productCategory->category,
            "posted_by" => $this->posted_by,
            "published" => $this->published,
            "gallery" => $this->url_gallery,
            "rated" => $this->productRated->rated,
            'deleted_at' => $this->when(!empty($this->deleted_at), $this->deleted_at),
        ];
    }
}
