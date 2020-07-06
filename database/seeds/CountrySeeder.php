<?php

use App\Models\Addresses\Country;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    public function run()
    {
        $api_datas = json_decode(file_get_contents(base_path("/blah.json")));

        $datas = [];

        foreach ($api_datas as $api_data) {
            $array = ["country" => $api_data->name, "phone_code" => (int) $api_data->dial_code, "country_code" => $api_data->code];
            array_push($datas, $array);
        }

        // $datas = [
        //     ["country" => "Cambodia", "phone_code" => "855"],
        //     ["country" => "Thai", "phone_code" => "66"],
        //     ["country" => "Vietname", "phone_code" => "84"],
        //     ["country" => "Singapore", "phone_code" => "65"],
        // ];

        foreach ($datas as $data) {
            Country::create($data);
        }

        // factory(Country::class, 10)->create());
    }
}
