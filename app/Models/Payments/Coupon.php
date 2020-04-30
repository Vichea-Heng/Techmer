<?php

namespace App\Models\Payments;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use SoftDeletes;
    protected $fillable = [
        "coupon",
        "discount",
        "expired_date",
        "posted_by",
    ];
}
