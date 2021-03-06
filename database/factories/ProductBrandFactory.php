<?php

use App\Models\Addresses\Country;
use App\Models\Products\ProductBrand;
use App\Models\Users\User;
use Faker\Generator as Faker;

$factory->define(ProductBrand::class, function (Faker $faker) {
    // $country = factory(Country::class, 1)->create()[0];
    // $user = factory(User::class, 1)->create()[0];
    return [
        "brand" => $faker->unique()->word,
        "from_country" => $faker->numberBetween(1, 246),
    ];
});
