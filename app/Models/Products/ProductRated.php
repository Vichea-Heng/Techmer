<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Model;

class ProductRated extends Model
{
    protected $guard_name = "";

    protected $primaryKey = "product_id";

    public $incrementing = false;

    public function getRouteKey()
    {
        return "product_id";
    }

    protected $fillable = [
        "product_id",
        "rated",
    ];

    public function product()
    {
        return $this->belongsTo("App\Models\Products\Product", "product_id", "id");
    }
}
