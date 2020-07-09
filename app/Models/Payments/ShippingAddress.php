<?php

namespace App\Models\Payments;

use App\Models\Addresses\Address;
use App\Traits\AuthIdField;
use Illuminate\Database\Eloquent\Model;

class ShippingAddress extends Model
{
    use AuthIdField;

    protected $fillable = [
        "address_id",
        "phone_number",
        "first_name",
        "last_name",
    ];

    protected $authIdFields = ["user_id"];

    public function address()
    {
        return $this->belongsTo("App\Models\Addresses\Address", "address_id", "id");
    }
    // public function user()
    // {
    //     return $this->belongsTo("App\Models\Users\User", "user_id", "id");
    // }

    public function getFullNameAttribute()
    {
        return $this->first_name . " " . $this->last_name;
    }
}
