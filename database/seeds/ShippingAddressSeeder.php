<?php

use App\Models\Addresses\Address;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Payments\ShippingAddress;

class ShippingAddressSeeder extends Seeder
{
    public function run()
    {
        Address::create(["address_line1" => "asd", "address_line2" => "asd", "country_id" => 1]);

        $datas = [
            ["address_id" => 1, "phone_number" => "85577774587"]
        ];

        foreach ($datas as $data) {
            ShippingAddress::create($data);
        }

        // factory(ShippingAddress::class, 10)->create());
    }
}
