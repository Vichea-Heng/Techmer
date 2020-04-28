<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Products\ProductBrand;

class ProductBrandSeeder extends Seeder
{
    public function run()
    {
        $datas = [
            ["brand" => "Intel", "from_country" => "1", "posted_by" => "1"],
            ["brand" => "AMD", "from_country" => "2", "posted_by" => "1"],
            ["brand" => "Apple", "from_country" => "3", "posted_by" => "1"],
        ];

        foreach ($datas as $data) {
            ProductBrand::create($data);
        }

        // factory(ProductBrand::class, 10)->create());
    }
}
