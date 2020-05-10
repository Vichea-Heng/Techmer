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

    public function favoriteProducts()
    {
        return $this->hasMany("App\Models\Products\FavoriteProduct", "product_id");
    }
    public function productFeedback()
    {
        return $this->hasMany("App\Models\Products\ProductFeedback", "product_id");
    }
    public function productOptions()
    {
        return $this->hasMany("App\Models\Products\ProductOption", "product_id");
    }
    public function productRateds()
    {
        return $this->hasMany("App\Models\Products\ProductRated", "product_id");
    }

    public function user()
    {
        return $this->belongsTo("App\Models\Users\User", "posted_by", "id");
    }
    public function productBrand()
    {
        return $this->belongsTo("App\Models\Products\ProductBrand", "brand_id", "id");
    }
    public function productCategory()
    {
        return $this->belongsTo("App\Models\Products\ProductCategory", "category_id", "id");
    }
}
