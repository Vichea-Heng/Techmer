<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        "title",
        "brand_id",
        "content",
        "category_id",
        "posted_by",
        "published",
    ];
}
