<?php

namespace App\Models\Payments;

use Illuminate\Database\Eloquent\Model;

class UserCart extends Model
{
    protected $fillable = [
        "user_id",
        "product_option_id",
        "qty",
    ];
}
