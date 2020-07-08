<?php

namespace App\Models\Products;

use App\Traits\AuthIdField;
use App\Traits\SoftDeleteAndRestore;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductOption extends Model
{
    use SoftDeletes, AuthIdField, SoftDeleteAndRestore;

    protected $fillable = [
        "product_id",
        "option",
        "category",
        "price",
        "qty",
        "discount",
        "warrenty",
        "photo",
    ];

    protected $authIdFields = ["posted_by"];

    protected $softDeleteCascades = [
        "userCarts",
        "transactions",
    ];

    protected $checkBeforeRestore = [
        "product",
        "user"
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
    public function user()
    {
        return $this->belongsTo("App\Models\Users\User", "posted_by", "id");
    }
}
