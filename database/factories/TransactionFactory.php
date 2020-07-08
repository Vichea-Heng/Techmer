<?php

use App\Models\Payments\Transaction;
use Faker\Generator as Faker;

$factory->define(Transaction::class, function (Faker $faker) {
    return [
        "product_option_id" => $faker->randomDigitNotNull * 1000 + 1,
        "qty" => $faker->numberBetween(1, 5),
        "purchase_price" => $faker->numberBetween(50, 100),
        "discount" => $faker->numberBetween(1, 80),
        "shipping_address_id" => 1,
    ];
});
