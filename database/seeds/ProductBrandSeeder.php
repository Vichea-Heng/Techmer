<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Products\ProductBrand;

class ProductBrandSeeder extends Seeder
{
    public function run()
    {
        $datas = json_decode(file_get_contents(resource_path("/json/product_brand.json")));

        foreach ($datas as $data) {
            factory(ProductBrand::class, 1)->create(["brand" => $data->name]);
        }

        // factory(ProductBrand::class, 20)->create();
    }
}
