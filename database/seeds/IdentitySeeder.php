<?php

use App\Models\Users\Identity;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IdentitySeeder extends Seeder
{
    public function run()
    {
        $datas = [
            ["user_id" => 1, "first_name" => "Vichea", "last_name" => "Heng", "date_of_birth" => "2000-10-10"],
        ];

        foreach ($datas as $data) {
            Identity::create($data);
        }

        factory(Identity::class, 10)->create();
    }
}
