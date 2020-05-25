<?php

namespace App\Http\Resources\Payments;

use Illuminate\Http\Resources\Json\JsonResource;

class ShippingAddressResource extends JsonResource
{
    public function toArray($request)
    {
        $address = $this->Address;
        return [
            "id" => $this->id,
            "user_id" => $this->user_id,
            "address_line1" => $address->address_line1,
            "address_line2" => $address->address_line2,
            "country_id" => $address->country_id,
            "address_id" => $this->address_id,
            "phone_number" => $this->phone_number,
            'deleted_at' => $this->when(!empty($this->deleted_at), $this->deleted_at),
        ];
    }
}
