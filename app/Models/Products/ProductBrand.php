<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductBrand extends Model
{
    use SoftDeletes;

    protected $fillable = [
        "brand",
        "from_country",
        "posted_by",
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
