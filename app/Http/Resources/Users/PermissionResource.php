<?php

namespace App\Http\Resources\Users;

use Illuminate\Http\Resources\Json\JsonResource;

class PermissionResource extends JsonResource
{
    public function toArray($request)
    {
        if ($this->deleted_at != NULL) {
            return [
                "id" => $this->id,
                "name" => $this->name,
                "guard_name" => $this->guard_name,
                "group_id" => $this->group_id,
                'deleted_at' => $this->deleted_at,
            ];
        }

        return [
            "id" => $this->id,
            "name" => $this->name,
            "guard_name" => $this->guard_name,
            "group_id" => $this->group_id,
        ];
    }
}
