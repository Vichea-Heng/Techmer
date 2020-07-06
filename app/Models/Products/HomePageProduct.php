<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Model;

class HomePageProduct extends Model
{
    protected $fillable = [
        "product_id",
        "product_type",
    ];

    public function product()
    {
        return $this->belongsTo("\App\Models\Products\Product");
    }
}
