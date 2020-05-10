<?php

namespace App\Models\Addresses;

use Illuminate\Database\Eloquent\Model;

class Nationality extends Model
{
    protected $fillable = [
        'nationality',
    ];

    // public function identity()
    // {
    //     return $this->hasOne("App\Models\Users\Identity", "nationality_id");
    // }
}
