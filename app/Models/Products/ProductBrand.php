<?php

namespace App\Models\Products;

use App\Traits\AuthIdField;
use App\Traits\SoftDeleteAndRestore;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductBrand extends Model
{
    use SoftDeletes, AuthIdField, SoftDeleteAndRestore;

    protected $fillable = [
        "brand",
        "from_country",
    ];

    protected $authIdFields = ["posted_by"];

    protected $softDeleteCascades = [
        "products",
    ];

    protected $checkBeforeRestore = [
        "country",
        "user",
    ];

    public function products()
    {
        return $this->hasMany("App\Models\Products\Product", "brand_id");
    }

    public function country()
    {
        return $this->belongsTo("App\Models\Addresses\Country", "from_country", "id");
    }
    public function user()
    {
        return $this->belongsTo("App\Models\Users\User", "posted_by", "id");
    }
}
