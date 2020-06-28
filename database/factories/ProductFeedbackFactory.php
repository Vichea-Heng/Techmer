<?php

use App\Models\Products\ProductFeedback;
use Faker\Generator as Faker;

$factory->define(ProductFeedback::class, function (Faker $faker) {
    return [
        "product_id" => $faker->numberBetween(1, 22),
        "feedback" => $faker->paragraph,
        "rated" => $faker->numberBetween(0, 5),
    ];
});
