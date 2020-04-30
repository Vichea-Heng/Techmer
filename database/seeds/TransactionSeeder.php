<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Payments\Transaction;

class TransactionSeeder extends Seeder
{
    public function run()
    {
        $datas = [
            ["user_id" => "1", "product_option_id" => "1", "qty" => "2"],
        ];

        foreach ($datas as $data) {
            Transaction::create($data);
        }

        // factory(Transaction::class, 10)->create());
    }
}
