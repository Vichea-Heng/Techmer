<?php

namespace App\Models\Payments;

use Illuminate\Database\Eloquent\Model;

class UserCart extends Model
{
    protected $fillable = [
        "id",
        "user_id",
        "product_option_id",
        "qty",
    ];

    public function user()
    {
        return $this->belongsTo("App\Models\Users\User", "user_id", "id");
    }
    public function productOption()
    {
        return $this->belongsTo("App\Models\Products\ProductOption", "product_option_id", "id");
    }
}
