<?php

namespace App\Models\Addresses;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Nationality extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nationality',
    ];
}
