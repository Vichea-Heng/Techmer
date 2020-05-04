<?php

namespace App\Http\Resources\Products;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request)
    {
        if ($this->deleted_at != NULL) {
            return [
                "id" => $this->id,
                "title" => $this->title,
                "brand_id" => $this->brand_id,
                "content" => $this->content,
                "category_id" => $this->category_id,
                "posted_by" => $this->posted_by,
                "published" => $this->published,
                'deleted_at' => $this->deleted_at,
            ];
        }

        return [
            "id" => $this->id,
            "title" => $this->title,
            "brand_id" => $this->brand_id,
            "content" => $this->content,
            "category_id" => $this->category_id,
            "posted_by" => $this->posted_by,
            "published" => $this->published,
        ];
    }
}
