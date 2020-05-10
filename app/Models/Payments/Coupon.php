<?php

namespace App\Models\Payments;

use App\Exceptions\MessageException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use SoftDeletes;

    protected $fillable = [
        "coupon",
        "discount",
        "expired_date",
        "posted_by",
    ];

    public function user()
    {
        return $this->belongsTo("App\Models\Users\User", "posted_by", "id");
    }

    public function checkBeforeRestore()
    {
        if (!empty($this->user->deleted_at)) {
            throw new MessageException("User have to restore parent table first");
        }
    }
}
