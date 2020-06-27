<?php

namespace App\Models\Addresses;

use App\Traits\AuthIdField;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use AuthIdField;

    protected $fillable = [
        "address_line1",
        "address_line2",
        "country_id",
    ];

    protected $authIdFields = ["user_id"];

    // public function shippingAddresses()
    // {
    //     return $this->hasMany("App\Models\Payments\ShippingAddress", "address_id");
    // }
    // public function identity()
    // {
    //     return $this->hasOne("App\Models\Users\Identity", "address_id");
    // }

    // public function user()
    // {
    //     return $this->belongsTo("App\Models\Users\User", "user_id", "id");
    // }
    // public function country()
    // {
    //     return $this->belongsTo("App\Models\Addresses\Country", "country_id", "id");
    // }
}
