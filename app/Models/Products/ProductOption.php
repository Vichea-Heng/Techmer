<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductOption extends Model
{
    use SoftDeletes;

    protected $fillable = [
        "id",
        "product_id",
        "option",
        "category",
        "price",
        "qty",
        "discount",
        "warrenty",
        "photo",
    ];

    public function userCarts()
    {
        return $this->hasMany("App\Models\Payments\UserCart", "product_option_id");
    }
    public function transactions()
    {
        return $this->hasMany("App\Models\Payments\Transaction", "product_option_id");
    }

    public function product()
    {
        return $this->belongsTo("App\Models\Products\Product", "product_id", "id");
    }
}
