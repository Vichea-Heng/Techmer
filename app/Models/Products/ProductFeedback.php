<?php

namespace App\Models\Products;

use App\Traits\AuthIdField;
use Illuminate\Database\Eloquent\Model;

class ProductFeedback extends Model
{
    use AuthIdField;

    protected $fillable = [
        "product_id",
        "feedback",
        "rated",
    ];

    protected $authIdFields = ["user_id"];

    public function user()
    {
        return $this->belongsTo("\App\Models\Users\User", "user_id", "id");
    }
}
