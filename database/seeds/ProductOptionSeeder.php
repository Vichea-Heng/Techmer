<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Products\ProductOption;

class ProductOptionSeeder extends Seeder
{
    public function run()
    {
        $datas = [
            ["product_id" => 1, "option" => "64Gb", "price" => "12", "qty" => 5, "discount" => 0, "warrenty" => "24 Months"],
            ["product_id" => 1, "option" => "32Gb", "price" => "12", "qty" => 0, "discount" => 0, "warrenty" => "24 Months"],
            ["product_id" => 1, "option" => "16Gb", "price" => "12", "qty" => 0, "discount" => 0, "warrenty" => "24 Months"],
            ["product_id" => 1, "option" => "8Gb", "price" => "12", "qty" => 0, "discount" => 0, "warrenty" => "24 Months"],
        ];

        foreach ($datas as $data) {
            ProductOption::create($data);
        }

        // factory(ProductOption::class, 10)->create());
    }
}
