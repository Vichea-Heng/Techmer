<?php

namespace App\Models\Addresses;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use SoftDeletes;

    protected $fillable = [
        "user_id",
        "address_line1",
        "address_line2",
        "country_id",
    ];
}
