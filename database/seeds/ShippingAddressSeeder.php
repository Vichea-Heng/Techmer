<?php

use App\Models\Addresses\Address;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Payments\ShippingAddress;
use Illuminate\Support\Facades\Auth;

class ShippingAddressSeeder extends Seeder
{
    public function run()
    {
        $datas = factory(Address::class, 10)->create();

        // $datas = [
        // ["address_id" => 1, "phone_number" => "85577774587"]
        // ];

        foreach ($datas as $data) {
            Auth::loginUsingId(rand(1, 11));
            ShippingAddress::create(["address_id" => $data->id, "phone_number" => "85577774587"]);
        }

        // factory(ShippingAddress::class, 10)->create());
    }
}
