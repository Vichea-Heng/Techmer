<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Model;

class FavoriteProduct extends Model
{
    protected $fillable = [
        "user_id",
        "product_id",
    ];
}
