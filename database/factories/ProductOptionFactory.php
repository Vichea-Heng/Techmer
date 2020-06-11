<?php

use App\Models\Products\Product;
use App\Models\Products\ProductOption;
use Faker\Generator as Faker;

$factory->define(ProductOption::class, function (Faker $faker) {
    $product = factory(Product::class, 1)->create()[0];
    return [
        "id" => $product->id * 1000 + 1,
        "product_id" => $product->id,
        "option" => $faker->title,
        "price" => "12",
        "qty" => 100,
        "discount" => 0,
        "warrenty" => $faker->paragraph,
        "category" => $faker->title,
        "photo" => "1001.jpg",
    ];
});
