<?php

use App\Models\Products\ProductCategory;
use App\Models\Users\User;
use Faker\Generator as Faker;

$factory->define(ProductCategory::class, function (Faker $faker) {
    $user = factory(User::class, 1)->create()[0];

    return [
        "category" => $faker->title,
        "posted_by" => $user->id,
    ];
});
