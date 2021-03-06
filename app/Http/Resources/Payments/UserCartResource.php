<?php

namespace App\Http\Resources\Payments;

use App\Http\Resources\Products\EachProductResource;
use App\Models\Products\ProductOption;
use Illuminate\Http\Resources\Json\JsonResource;

class UserCartResource extends JsonResource
{
    public function toArray($request)
    {

        return [
            "id" => $this->id,
            "user_id" => $this->user_id,
            "product_option_id" => $this->product_option_id,
            "product" => new EachProductResource($this->productOption->product),
            "qty" => $this->qty,
            'deleted_at' => $this->when(!empty($this->deleted_at), $this->deleted_at),
        ];
    }
}
