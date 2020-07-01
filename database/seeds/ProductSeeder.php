<?php

use App\Models\Payments\Transaction;
use App\Models\Payments\UserCart;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Products\Product;
use App\Models\Products\ProductFeedback;
use App\Models\Products\ProductOption;
use App\Models\Products\ProductRated;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $datas = [
            ["title" => "XPG Ram", "brand_id" => "1", "short_description" => "available in RGB light", "full_description" => "available in RGB light", "category_id" => 1, "published" => 1, "gallery" => json_encode([
                "1-1.jpg",
                "1-2.jpg",
                "1-3.jpg",
            ])],
            ["title" => "Cosair Ram", "brand_id" => "1", "short_description" => "available in RGB light", "full_description" => "available in RGB light", "category_id" => 1, "published" => 1, "gallery" => json_encode([
                "2-1.jpg",
                "2-2.jpg",
                "2-3.jpg",
            ])],
        ];

        foreach ($datas as $data) {
            Product::create($data);
        }

        $datas = [
            ["id" => 1001, "product_id" => 1, "option" => "64Gb", "price" => "12", "qty" => 10, "discount" => 0, "warrenty" => "24 Months", "category" => "Capacity", "photo" => "1001.jpg"],
            ["id" => 1002, "product_id" => 1, "option" => "32Gb", "price" => "12", "qty" => 2, "discount" => 0, "warrenty" => "24 Months", "category" => "Capacity", "photo" => "1002.jpg"],
            ["id" => 1003, "product_id" => 1, "option" => "16Gb", "price" => "12", "qty" => 3, "discount" => 0, "warrenty" => "24 Months", "category" => "Capacity", "photo" => "1003.jpg"],
            ["id" => 1004, "product_id" => 1, "option" => "8Gb", "price" => "12", "qty" => 4, "discount" => 0, "warrenty" => "24 Months", "category" => "Capacity", "photo" => "1004.jpg"],
            ["id" => 2001, "product_id" => 2, "option" => "64Gb", "price" => "12", "qty" => 10, "discount" => 0, "warrenty" => "24 Months", "category" => "Capacity", "photo" => "2001.jpg"],
            ["id" => 2002, "product_id" => 2, "option" => "32Gb", "price" => "12", "qty" => 2, "discount" => 0, "warrenty" => "24 Months", "category" => "Capacity", "photo" => "2002.jpg"],
            ["id" => 2003, "product_id" => 2, "option" => "16Gb", "price" => "12", "qty" => 3, "discount" => 0, "warrenty" => "24 Months", "category" => "Capacity", "photo" => "2003.jpg"],
            ["id" => 2004, "product_id" => 2, "option" => "8Gb", "price" => "12", "qty" => 4, "discount" => 0, "warrenty" => "24 Months", "category" => "Capacity", "photo" => "2004.jpg"],
        ];

        foreach ($datas as $data) {
            ProductOption::create($data);
        }

        $datas = factory(Product::class, 20)->create();

        foreach ($datas as $data) {
            $data->update(["gallery" => json_encode([
                $data->id . "-1.jpg",
                $data->id . "-2.jpg",
                $data->id . "-3.jpg",
            ])]);

            ProductRated::create([
                "product_id" => $data->id,
            ]);

            $avg = 0;
            for ($i = 0; $i < 3; $i++) {
                $feedback = factory(ProductFeedback::class, 1)->create(["product_id" => $data->id]);
                $avg += $feedback[0]->rated;
            }

            $data->productRated->update(["rated" => $avg / 3]);

            for ($i = 1; $i <= rand(3, 6); $i++) {
                $id = factory(ProductOption::class, 1)->create(["id" => $data->id * 1000 + $i, "product_id" => $data->id, "photo" => ($data->id * 1000 + $i) . ".jpg"]);
                factory(Transaction::class, 1)->create(["product_option_id" => $id[0]->id]);
            }
        }

        for ($i = 1; $i <= 11; $i++) {
            for ($l = 1; $l <= 3; $l++) {
                factory(UserCart::class, 1)->create([
                    "id" => ($i * 100 + $l),
                    "product_option_id" => (rand(1, 22) * 1000 + $l),
                ]);
            }
        }
    }
}
