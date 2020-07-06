<?php

namespace App\Http\Resources\Products;

use Illuminate\Http\Resources\Json\JsonResource;

class HomePageProductResource extends JsonResource
{
    public function toArray($request)
    {
        $product = $this->product;

        return [
            "id" => $product->id,
            "title" => $product->title,
            "brand" => $product->productBrand->brand,
            "short_description" => $product->short_description,
            "full_description" => $product->full_description,
            "category" => $product->productCategory->category,
            "posted_by" => $product->posted_by,
            "published" => $product->published,
            "gallery" => $product->url_gallery,
            "rated" => $product->productRated->rated,
            "product_option" => ProductOptionResource::collection($product->productOptions()->get()),
            'deleted_at' => $this->when(!empty($product->deleted_at), $product->deleted_at),
        ];
    }
}
