<?php

namespace App\Models\Products\UserExperience;

use Illuminate\Database\Eloquent\Model;

class ProductFeedback extends Model
{
    protected $fillable = [
        "user_id",
        "product_id",
        "feedback",
        "rated",
    ];
}
