<?php

namespace App\Models\Products;

use App\Exceptions\MessageException;
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

    public function checkBeforeRestore()
    {
        if (
            !empty($this->product->deleted_at)
        ) {
            throw new MessageException("User have to restore parent table first");
        }
    }

    public function beforeForceDelete()
    {
        $this->userCarts->each(function ($query) {
            return $query->delete();
        });
        $this->transactions->each(function ($query) {
            return $query->delete();
        });
    }
}
