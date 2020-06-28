<?php

use App\Models\Products\FavoriteProduct;
use Faker\Generator as Faker;

$factory->define(FavoriteProduct::class, function (Faker $faker) {
    return [
        "product_id" => $faker->numberBetween(1, 22),
    ];
});
