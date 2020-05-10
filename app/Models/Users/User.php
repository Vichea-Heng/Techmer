<?php

namespace App\Models\Users;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasRoles, HasApiTokens, SoftDeletes;

    protected $fillable = [
        "username",
        "email",
        "email_verified",
        "phone_number",
        "phone_verified",
        "password",
        "status",
    ];

    protected $guard_name = "api";

    public function addresses()
    {
        return $this->hasMany("App\Models\Addresses\Address", "user_id");
    }
    public function coupons()
    {
        return $this->hasMany("App\Models\Payments\Coupon", "posted_by");
    }
    public function shippingAddresses()
    {
        return $this->hasMany("App\Models\Payments\ShippingAddress", "user_id");
    }
    public function transactions()
    {
        return $this->hasMany("App\Models\Payments\Transaction", "user_id");
    }
    public function userCarts()
    {
        return $this->hasMany("App\Models\Payments\UserCart", "user_id");
    }
    public function favoriteProducts()
    {
        return $this->hasMany("App\Models\Products\FavoriteProduct", "user_id");
    }
    public function products()
    {
        return $this->hasMany("App\Models\Products\Product", "posted_by");
    }
    public function productBrands()
    {
        return $this->hasMany("App\Models\Products\ProductBrand", "posted_by");
    }
    public function productCategories()
    {
        return $this->hasMany("App\Models\Products\ProductCategory", "posted_by");
    }
    public function productFeedback()
    {
        return $this->hasMany("App\Models\Products\ProductFeedback", "posted_by");
    }
    public function identity()
    {
        return $this->hasOne("App\Models\Users\Identity", "user_id");
    }
}
