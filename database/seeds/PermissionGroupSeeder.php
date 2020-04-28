<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Users\PermissionGroup;

class PermissionGroupSeeder extends Seeder
{
    public function run()
    {
        $datas = [
            ["name" => "Role"],
            ["name" => "Permission"],
        ];

        foreach ($datas as $data) {
            PermissionGroup::create($data);
        }

        // factory(PermissionGroup::class, 10)->create());
    }
}
