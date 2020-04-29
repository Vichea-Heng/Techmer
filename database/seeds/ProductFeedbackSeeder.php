<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Products\ProductFeedback;
use App\Models\Products\ProductRated;

class ProductFeedbackSeeder extends Seeder
{
    public function run()
    {
        $datas = [
            ["user_id" => "1", "product_id" => "1", "feedback" => "The product is good", "rated" => 5],
            ["user_id" => "1", "product_id" => "1", "feedback" => "The product is good", "rated" => 4],
        ];

        foreach ($datas as $data) {
            ProductFeedback::create($data);
        }

        ProductRated::findOrFail(1)->first()->update(["rated" => 4.5]);

        // factory(ProductFeedback::class, 10)->create());
    }
}
