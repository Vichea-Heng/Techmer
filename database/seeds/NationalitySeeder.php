<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Nationality;

class NationalitySeeder extends Seeder
{
    public function run()
    {
        DB::table("nationalities")->insert([
            ["nationality" => "Cambodian"],
            ["nationality" => "Thailand"],
            ["nationality" => "Vietnamese"],
            ["nationality" => "Singaporean"],
        ]);

        // factory(Nationality::class, 10)->create());
    }
}
