<?php

namespace App\Models\Payments;

use App\Models\Addresses\Address;
use Illuminate\Database\Eloquent\Model;

class ShippingAddress extends Model
{
    protected $fillable = [
        "user_id",
        "address_id",
        "phone_number",
    ];

    public function Address()
    {
        return $this->belongsTo("App\Models\Addresses\Address", "address_id", "id");
    }
}
