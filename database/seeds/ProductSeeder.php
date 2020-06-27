<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Products\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $datas = [
            ["title" => "XPG Ram", "brand_id" => "1", "content" => "available in RGB light", "category_id" => 1, "published" => 1],
            ["title" => "Cosair Ram", "brand_id" => "1", "content" => "available in RGB light", "category_id" => 1, "published" => 1],
        ];

        foreach ($datas as $data) {
            Product::create($data);
        }

        // factory(Product::class, 10)->create());
    }
}
