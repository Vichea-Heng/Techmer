<?php

namespace App\Models\Products;

use App\Traits\AuthIdField;
use Illuminate\Database\Eloquent\Model;

class FavoriteProduct extends Model
{
    use AuthIdField;

    protected $fillable = [
        "product_id",
    ];

    protected $authIdFields = ["user_id"];
}
