<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Identity extends Model
{
    use SoftDeletes;

    protected $fillable = [
        "first_name",
        "last_name",
        "date_of_birth",
        "address_id",
        "nationality_id"
    ];
}
