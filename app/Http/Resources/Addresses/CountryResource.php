<?php

namespace App\Http\Resources\Addresses;

use Illuminate\Http\Resources\Json\JsonResource;

class CountryResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "country" => $this->country,
            "phone_code" => $this->phone_code,
            "country_code" => $this->country_code,
            'deleted_at' => $this->when(!empty($this->deleted_at), $this->deleted_at),
        ];
    }
}
