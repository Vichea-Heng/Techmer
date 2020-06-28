<?php

use App\Models\Payments\Coupon;
use Faker\Generator as Faker;

$factory->define(Coupon::class, function (Faker $faker) {
    return [
        "coupon" => $faker->lastName,
        "discount" => $faker->numberBetween(1, 100),
        "expired_date" => $faker->dateTimeBetween('now', '+3 years', null),
    ];
});
