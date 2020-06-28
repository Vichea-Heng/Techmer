<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Payments\Coupon;

class CouponSeeder extends Seeder
{
    public function run()
    {
        $datas = [
            ["coupon" => "COVID19", "discount" => "30", "expired_date" => "2020-10-10"]
        ];

        foreach ($datas as $data) {
            Coupon::create($data);
        }

        factory(Coupon::class, 10)->create();
    }
}
