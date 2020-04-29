<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleSeeder::class);
        $this->call(PermissionGroupSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(IdentitySeeder::class);
        $this->call(CountrySeeder::class);
        $this->call(NationalitySeeder::class);

        $this->call(ProductBrandSeeder::class);
        $this->call(ProductCategorySeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(ProductOptionSeeder::class);
        $this->call(ProductRatedSeeder::class);
        $this->call(ProductFeedbackSeeder::class);
        $this->call(UserCartSeeder::class);
    }
}
