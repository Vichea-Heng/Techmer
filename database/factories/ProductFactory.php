<?php

use App\Models\Products\Product;
use App\Models\Products\ProductBrand;
use App\Models\Products\ProductCategory;
use App\Models\Users\User;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    $category = factory(ProductCategory::class, 1)->create()[0];
    $brand = factory(ProductBrand::class, 1)->create()[0];
    $user = factory(User::class, 1)->create()[0];
    return [
        "title" => $faker->title,
        "brand_id" => $brand->id,
        "content" => $faker->paragraph,
        "category_id" => $category->id,
        "posted_by" => $user->id,
        "published" => 1,
    ];
});
