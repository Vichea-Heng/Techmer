<?php

use App\Models\Addresses\Country;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    public function run()
    {
        $datas = [
            ["country" => "Cambodia", "phone_code" => "855"],
            ["country" => "Thai", "phone_code" => "66"],
            ["country" => "Vietname", "phone_code" => "84"],
            ["country" => "Singapore", "phone_code" => "65"],
        ];

        foreach ($datas as $data) {
            Country::create($data);
        }

        // factory(Country::class, 10)->create());
    }
}
