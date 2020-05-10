<?php

namespace App\Models\Payments;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        "user_id",
        "product_option_id",
        "qty",
        "purchase_price",
        "discount",
    ];

    // public function user()
    // {
    //     return $this->belongsTo("App\Models\Users\User", "user_id", "id");
    // }
    // public function productOption()
    // {
    //     return $this->belongsTo("App\Models\Products\ProductOption", "product_option_id", "id");
    // }
}
