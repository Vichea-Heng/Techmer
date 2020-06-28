<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Payments\UserCart;

class UserCartSeeder extends Seeder
{
    public function run()
    {
        // $datas = [
        //     ["id" => "101", "product_option_id" => "1001", "qty" => "2"],
        // ];

        // foreach ($datas as $data) {
        //     UserCart::create($data);
        // }

        // for ($i = 1; $i <= 11; $i++) {
        //     for ($l = 1; $l <= 3; $l++) {
        //         factory(UserCart::class, 1)->create([
        //             "id" => ($i * 100 + $l),
        //             "product_option_id" => (rand(1, 22) * 1000 + $l),
        //         ]);
        //     }
        // }

        // factory(UserCart::class, 10)->create());
    }
}
