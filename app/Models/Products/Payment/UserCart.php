<?php

namespace App\Models\Products\Payment;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserCart extends Model
{
    use SoftDeletes;

    protected $fillable = [
        "user_id",
        "product_option_id",
        "qty",
    ];
}
