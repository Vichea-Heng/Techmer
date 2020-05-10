<?php

namespace App\Models\Addresses;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        "user_id",
        "address_line1",
        "address_line2",
        "country_id",
    ];

    public function shippingAddresses()
    {
        return $this->hasMany("App\Models\Payments\ShippingAddress", "address_id");
    }
    public function identity()
    {
        return $this->hasOne("App\Models\Users\Identity", "address_id");
    }

    public function user()
    {
        return $this->belongsTo("App\Models\Users\User", "user_id", "id");
    }
    public function country()
    {
        return $this->belongsTo("App\Models\Addresses\Country", "country_id", "id");
    }
}
