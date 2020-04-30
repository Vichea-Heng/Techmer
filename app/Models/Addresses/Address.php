<?php

namespace App\Models\Addresses;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        "user_id",
        "address_line1",
        "address_line2",
        "country_id",
    ];
}
