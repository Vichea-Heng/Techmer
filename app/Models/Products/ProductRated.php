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
}
