<?php

namespace Tests;

use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseMigrations;
}

// php artisan crud:api-generator v1/Payments/Coupon --test
// php artisan crud:api-generator v1/Payments/ShippingAddress --test
// php artisan crud:api-generator v1/Payments/Transaction --test
// php artisan crud:api-generator v1/Payments/UserCart --test

// php artisan crud:api-generator v1/Products/FavoriteProduct --test
// php artisan crud:api-generator v1/Products/ProductBrand --test
// php artisan crud:api-generator v1/Products/ProductCategory --test
// php artisan crud:api-generator v1/Products/Product --test
// php artisan crud:api-generator v1/Products/ProductFeedback --test
// php artisan crud:api-generator v1/Products/ProductOption --test
// php artisan crud:api-generator v1/Products/ProductRated --test

// php artisan crud:api-generator v1/Users/Permission --test
// php artisan crud:api-generator v1/Users/PermissionGroup --test
// php artisan crud:api-generator v1/Users/Role --test
// php artisan crud:api-generator v1/Users/User --test