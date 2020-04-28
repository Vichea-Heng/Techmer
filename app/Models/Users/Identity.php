<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

class Identity extends Model
{
    protected $fillable = [
        "first_name",
        "last_name",
        "date_of_birth",
        "address_id",
        "nationality_id"
    ];
}
