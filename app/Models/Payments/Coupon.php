<?php

namespace App\Models\Payments;

use App\Exceptions\MessageException;
use App\Traits\AuthIdField;
use App\Traits\SoftDeleteAndRestore;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use SoftDeletes, AuthIdField, SoftDeleteAndRestore;

    protected $fillable = [
        "coupon",
        "discount",
        "expired_date",
    ];

    protected $authIdFields = ["posted_by"];

    protected $checkBeforeRestore = ["user"];

    public function user()
    {
        return $this->belongsTo("App\Models\Users\User", "posted_by", "id");
    }
}
