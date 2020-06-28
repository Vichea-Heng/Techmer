<?php

use App\Models\Products\Product;
use App\Models\Products\ProductBrand;
use App\Models\Products\ProductCategory;
use App\Models\Users\User;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    // $category = factory(ProductCategory::class, 1)->create()[0];
    // $brand = factory(ProductBrand::class, 1)->create()[0];
    // $user = factory(User::class, 1)->create()[0];
    return [
        "title" => $faker->unique()->word,
        "brand_id" => $faker->numberBetween(1, 23),
        "short_description" => $faker->paragraph,
        "full_description" => $faker->text(5000),
        "category_id" => $faker->numberBetween(1, 23),
        "published" => 1,
    ];
});
