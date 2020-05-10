<?php

namespace App\Models\Addresses;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    use SoftDeletes;

    protected $fillable = [
        "country",
        "phone_code"
    ];

    public function productBrands()
    {
        return $this->hasMany("App\Models\Products\ProductBrand", "from_country");
    }
    public function Addresses()
    {
        return $this->hasMany("App\Models\Addresses\Address", "country_id");
    }
}
