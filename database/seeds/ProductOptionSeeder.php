<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Products\ProductOption;

class ProductOptionSeeder extends Seeder
{
    public function run()
    {
        $datas = [
            ["id" => 1001, "product_id" => 1, "option" => "64Gb", "price" => "12", "qty" => 10, "discount" => 0, "warrenty" => "24 Months", "category" => "Capacity", "photo" => "1001.jpg"],
            ["id" => 1002, "product_id" => 1, "option" => "32Gb", "price" => "12", "qty" => 2, "discount" => 0, "warrenty" => "24 Months", "category" => "Capacity", "photo" => "1002.jpg"],
            ["id" => 1003, "product_id" => 1, "option" => "16Gb", "price" => "12", "qty" => 3, "discount" => 0, "warrenty" => "24 Months", "category" => "Capacity", "photo" => "1003.jpg"],
            ["id" => 1004, "product_id" => 1, "option" => "8Gb", "price" => "12", "qty" => 4, "discount" => 0, "warrenty" => "24 Months", "category" => "Capacity", "photo" => "1004.jpg"],
        ];

        foreach ($datas as $data) {
            ProductOption::create($data);
        }

        // factory(ProductOption::class, 10)->create());
    }
}
