<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Products\UserExperience\ProductRated;

class ProductRatedSeeder extends Seeder
{
    public function run()
    {
        $datas = [
            ["product_id" => "1", "rated" => "0"],
            ["product_id" => "2", "rated" => "0"],
        ];

        foreach ($datas as $data) {
            ProductRated::create($data);
        }

        // factory(ProductRated::class, 10)->create());
    }
}
