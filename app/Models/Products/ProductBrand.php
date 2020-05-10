<?php

namespace App\Models\Products;

use App\Exceptions\MessageException;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductBrand extends Model
{
    use SoftDeletes, SoftCascadeTrait;

    protected $fillable = [
        "brand",
        "from_country",
        "posted_by",
    ];

    protected $softCascade = [
        'products', //restrict
    ];

    public function products()
    {
        return $this->hasMany("App\Models\Products\Product", "brand_id");
    }

    public function country()
    {
        return $this->belongsTo("App\Models\Addresses\Country", "from_country", "id");
    }
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

    public function beforeForceDelete()
    {
        $this->products->each(function ($query) {
            return $query->delete();
        });
    }
}
