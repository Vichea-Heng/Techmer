<?php

use App\Models\Users\Identity;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IdentitySeeder extends Seeder
{
    public function run()
    {
        DB::table("identities")->insert([
            ["user_id" => 1, "first_name" => "Vichea", "last_name" => "Heng", "date_of_birth" => "2000-10-10"],
        ]);

        // factory(Country::class, 10)->create());
    }
}
