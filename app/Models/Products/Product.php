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
        "gallery",
    ];

    public function getUrlGalleryAttribute()
    {
        if (!empty($this->gallery)) {
            $gallery = json_decode($this->gallery);

            return (array_map(fn ($val) => url(env("APP_URL") . "v1/product/" . $this->id . "/" . $val), $gallery));
        }
    }
}
