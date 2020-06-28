<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Products\ProductCategory;

class ProductCategorySeeder extends Seeder
{
    public function run()
    {
        $datas = [
            ["category" => "Case"],
            ["category" => "Mother Board"],
            ["category" => "Ram"],
            ["category" => "Hard Drive"],
            ["category" => "Graphic Card"],
            ["category" => "CPU"],
        ];

        foreach ($datas as $data) {
            ProductCategory::create($data);
        }

        factory(ProductCategory::class, 20)->create();
    }
}
