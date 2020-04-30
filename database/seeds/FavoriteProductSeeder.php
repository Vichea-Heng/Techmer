<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Products\FavoriteProduct;

class FavoriteProductSeeder extends Seeder
{
    public function run()
    {
        $datas = [
            ["user_id" => 1, "product_id" => 1]
        ];

        foreach ($datas as $data) {
            FavoriteProduct::create($data);
        }

        // factory(FavoriteProduct::class, 10)->create());
    }
}
