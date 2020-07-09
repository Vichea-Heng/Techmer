<?php

namespace App\Http\Resources\Users;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $identity = $this->identity;
        return [
            "id" => $this->id,
            "username" => $this->username,
            "full_name" => $identity->full_name,
            "first_name" => $identity->first_name,
            "last_name" => $identity->last_name,
            "date_of_birth" => $identity->date_of_birth,
            "email" => $this->email,
            "email_verified" => $this->email_verified,
            "phone_number" => $this->phone_number,
            "phone_verified" => $this->phone_verified,
            "status" => $this->status ? "Active" : "In-Active",
            'deleted_at' => $this->when(!empty($this->deleted_at), $this->deleted_at),
        ];
    }
}
