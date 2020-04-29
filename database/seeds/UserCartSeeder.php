<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Payments\UserCart;

class UserCartSeeder extends Seeder
{
    public function run()
    {
        $datas = [
            ["user_id" => "1", "product_option_id" => "1", "qty" => "2"],
        ];

        foreach ($datas as $data) {
            UserCart::create($data);
        }

        // factory(UserCart::class, 10)->create());
    }
}
