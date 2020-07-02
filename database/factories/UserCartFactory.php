<?php

use App\Models\Payments\UserCart;
use Faker\Generator as Faker;

$factory->define(UserCart::class, function (Faker $faker) {
    return [
        "product_option_id" => $faker->randomDigitNotNull * 1000 + 1,
        "qty" => $faker->numberBetween(1, 5),
    ];
});
