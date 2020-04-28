<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Products\ProductCategory;

class ProductCategorySeeder extends Seeder
{
    public function run()
    {
        $datas = [
            ["category" => "Case", "posted_by" => 1],
            ["category" => "Mother Board", "posted_by" => 1],
            ["category" => "Ram", "posted_by" => 1],
            ["category" => "Hard Drive", "posted_by" => 1],
            ["category" => "Graphic Card", "posted_by" => 1],
            ["category" => "CPU", "posted_by" => 1],
        ];

        foreach ($datas as $data) {
            ProductCategory::create($data);
        }

        // factory(ProductCategory::class, 10)->create());
    }
}
