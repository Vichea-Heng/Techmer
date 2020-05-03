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
    ];

    public function UserCart()
    {
        return $this->hasMany("App\Models\Payments\UserCart", "product_option_id");
    }
}
