<?php

use App\Models\Products\Product;
use App\Models\Products\ProductOption;
use Faker\Generator as Faker;

$factory->define(ProductOption::class, function (Faker $faker) {
    // $product = factory(Product::class, 1)->create()[0];
    // $id = $faker->randomDigitNotNull * 1000 + 1;
    return [
        // "id" => $id,
        "product_id" => $faker->randomDigitNotNull,
        "option" => $faker->unique(true)->word,
        "category" => $faker->shuffle(array("Capacity", "Burst Speed", "Speedy"))[0],
        "price" => $faker->numberBetween(50, 100),
        "qty" => $faker->numberBetween(20, 30),
        "discount" => $faker->numberBetween(1, 100),
        "warrenty" => $faker->numberBetween(12, 36) . "Months",
        // "photo" => "$id.jpg",
    ];
});
