<?php

use App\Models\Payments\Transaction;
use App\Models\Payments\UserCart;
use App\Models\Products\HomePageProduct;
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
            ["product_id" => 1, "option" => "64Gb", "price" => "12", "qty" => 10, "discount" => 0, "warrenty" => "24 Months", "category" => "Capacity", "photo" => "1001.jpg"],
            ["product_id" => 1, "option" => "32Gb", "price" => "12", "qty" => 2, "discount" => 0, "warrenty" => "24 Months", "category" => "Capacity", "photo" => "1002.jpg"],
            ["product_id" => 1, "option" => "16Gb", "price" => "12", "qty" => 3, "discount" => 0, "warrenty" => "24 Months", "category" => "Capacity", "photo" => "1003.jpg"],
            ["product_id" => 1, "option" => "8Gb", "price" => "12", "qty" => 4, "discount" => 0, "warrenty" => "24 Months", "category" => "Capacity", "photo" => "1004.jpg"],
            ["product_id" => 2, "option" => "64Gb", "price" => "12", "qty" => 10, "discount" => 0, "warrenty" => "24 Months", "category" => "Capacity", "photo" => "2001.jpg"],
            ["product_id" => 2, "option" => "32Gb", "price" => "12", "qty" => 2, "discount" => 0, "warrenty" => "24 Months", "category" => "Capacity", "photo" => "2002.jpg"],
            ["product_id" => 2, "option" => "16Gb", "price" => "12", "qty" => 3, "discount" => 0, "warrenty" => "24 Months", "category" => "Capacity", "photo" => "2003.jpg"],
            ["product_id" => 2, "option" => "8Gb", "price" => "12", "qty" => 4, "discount" => 0, "warrenty" => "24 Months", "category" => "Capacity", "photo" => "2004.jpg"],
        ];

        foreach ($datas as $data) {
            ProductOption::create($data);
        }

        $titles = json_decode(file_get_contents(resource_path("/json/title.json")));

        foreach ($titles as $each) {
            $datas = factory(Product::class, 1)->create(["title" => $each->title, "brand_id" => $each->brand_id, "category_id" => $each->category_id])->first();
            $datas->update(["gallery" => json_encode([
                $datas->id . "-1.jpg",
                $datas->id . "-2.jpg",
                $datas->id . "-3.jpg",
            ])]);
        }

        for ($i = 1; $i <= 6; $i++) {
            HomePageProduct::create([
                "product_id" => "$i",
                "product_type" => "product-hot-deal",
            ]);
        }
        for ($i = 7; $i <= 12; $i++) {
            HomePageProduct::create([
                "product_id" => "$i",
                "product_type" => "product-popular",
            ]);
        }
        for ($i = 13; $i <= 18; $i++) {
            HomePageProduct::create([
                "product_id" => "$i",
                "product_type" => "product-best-rating",
            ]);
        }

        // foreach ($datas as $data) {
        for ($i = 3; $i <= 77; $i++) {
            $data = Product::find($i);

            ProductRated::create([
                "product_id" => $data->id,
            ]);

            $avg = 0;
            for ($ii = 0; $ii < 3; $ii++) {
                $feedback = factory(ProductFeedback::class, 1)->create(["product_id" => $data->id]);
                $avg += $feedback[0]->rated;
            }

            $data->productRated->update(["rated" => $avg / 3]);

            for ($ii = 1; $ii <= rand(3, 6); $ii++) {
                $id = factory(ProductOption::class, 1)->create(["product_id" => $data->id, "photo" => ($data->id * 1000 + $ii) . ".jpg"]);
                factory(Transaction::class, 1)->create(["product_option_id" => $id[0]->id]);
            }
        }

        for ($i = 1; $i <= 11; $i++) {
            for ($l = 1; $l <= 3; $l++) {
                factory(UserCart::class, 1)->create([
                    "product_option_id" => (rand(1, 22)),
                ]);
            }
        }
    }
}
