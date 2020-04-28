<?php

use App\Models\Addresses\Nationality;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NationalitySeeder extends Seeder
{
    public function run()
    {
        $datas = [
            ["nationality" => "Cambodian"],
            ["nationality" => "Thailand"],
            ["nationality" => "Vietnamese"],
            ["nationality" => "Singaporean"],
        ];

        foreach ($datas as $data) {
            Nationality::create($data);
        }

        // factory(Nationality::class, 10)->create());
    }
}
