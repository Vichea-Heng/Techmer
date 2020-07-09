<?php

namespace App\Http\Resources\Products;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductFeedbackResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "user_id" => $this->user->identity->full_name,
            "product_id" => $this->product_id,
            "feedback" => $this->feedback,
            "rated" => $this->rated,
            'deleted_at' => $this->when(!empty($this->deleted_at), $this->deleted_at),
        ];
    }
}
