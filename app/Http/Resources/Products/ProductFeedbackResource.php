<?php

namespace App\Http\Resources\Products;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductFeedbackResource extends JsonResource
{
    public function toArray($request)
    {
        if ($this->deleted_at != NULL) {
            return [
                "id" => $this->id,
                "user_id" => $this->user_id,
                "product_id" => $this->product_id,
                "feedback" => $this->feedback,
                "rated" => $this->rated,
                'deleted_at' => $this->deleted_at,
            ];
        }

        return [
            "id" => $this->id,
            "user_id" => $this->user_id,
            "product_id" => $this->product_id,
            "feedback" => $this->feedback,
            "rated" => $this->rated,
        ];
    }
}
