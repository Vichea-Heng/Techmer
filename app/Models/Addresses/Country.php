<?php

namespace App\Models\Addresses;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = [
        "country",
        "phone_code"
    ];

    // public function productBrands()
    // {
    //     return $this->hasMany("App\Models\Products\ProductBrand", "from_country");
    // }
    // public function addresses()
    // {
    //     return $this->hasMany("App\Models\Addresses\Address", "country_id");
    // }
}
