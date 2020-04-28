<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductOption extends Model
{
    use SoftDeletes;

    protected $fillable = [
        "product_id",
        "option",
        "price",
        "qty",
        "discount",
        "warrenty",
    ];
}
