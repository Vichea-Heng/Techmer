<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Products\ProductRated;

class ProductRatedSeeder extends Seeder
{
    public function run()
    {
        $datas = [
            ["product_id" => "1"],
            ["product_id" => "2"],
        ];

        foreach ($datas as $data) {
            ProductRated::create($data);
        }

        // factory(ProductRated::class, 10)->create());
    }
}
