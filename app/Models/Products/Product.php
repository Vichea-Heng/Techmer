<?php

namespace App\Models\Products;

use App\Exceptions\MessageException;
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

    protected $softCascade = [
        // 'favoriteProducts', //restrict
        'productFeedback', //restrict
        'productOptions', //restrict
        // 'productRateds', //restrict
    ];

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
    public function productRated()
    {
        return $this->hasOne("App\Models\Products\ProductRated", "product_id");
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



    public function checkBeforeRestore()
    {
        if (
            !empty($this->user->deleted_at)
            || !empty($this->productBrand->deleted_at)
            || !empty($this->productCategory->deleted_at)
        ) {
            throw new MessageException("User have to restore parent table first");
        }
    }

    public function beforeForceDelete()
    {
        $this->favoriteProducts->each(function ($query) {
            return $query->delete();
        });
        $this->productFeedback->each(function ($query) {
            return $query->forceDelete();
        });
        $this->productOptions->each(function ($query) {
            return $query->forceDelete();
        });
        $this->productRated->delete();
    }
}
