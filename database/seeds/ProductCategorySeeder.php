<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Products\ProductCategory;

class ProductCategorySeeder extends Seeder
{
    public function run()
    {
        $datas = json_decode(file_get_contents(resource_path("/json/product_category.json")));

        foreach ($datas as $data) {
            factory(ProductCategory::class, 1)->create(["category" => $data->name]);
        }
    }
}
