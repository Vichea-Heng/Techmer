<?php

namespace App\Models\Products;

use App\Traits\AuthIdField;
use App\Traits\SoftDeleteAndRestore;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductCategory extends Model
{
    use SoftDeletes, AuthIdField, SoftDeleteAndRestore;

    protected $fillable = [
        "category",
        "description",
    ];

    protected $authIdFields = ["posted_by"];

    protected $softDeleteCascades = [
        "products",
    ];

    protected $checkBeforeRestore = [
        "user",
    ];

    public function products()
    {
        return $this->hasMany("App\Models\Products\Product", "category_id");
    }

    public function user()
    {
        return $this->belongsTo("App\Models\Users\User", "posted_by", "id");
    }
}
