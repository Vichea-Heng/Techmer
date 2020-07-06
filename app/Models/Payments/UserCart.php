<?php

namespace App\Models\Payments;

use App\Traits\AuthIdField;
use Illuminate\Database\Eloquent\Model;

class UserCart extends Model
{
    use AuthIdField;

    protected $fillable = [
        "product_option_id",
        "qty",
    ];

    protected $authIdFields = ["user_id"];

    // public function user()
    // {
    //     return $this->belongsTo("App\Models\Users\User", "user_id", "id");
    // }
    public function productOption()
    {
        return $this->belongsTo("App\Models\Products\ProductOption", "product_option_id", "id");
    }
}
