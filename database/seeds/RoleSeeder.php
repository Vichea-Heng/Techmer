<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $datas = [
            ["name" => "Super Admin", "guard_name" => "api"],
            ["name" => "Admin", "guard_name" => "api"],
            ["name" => "User", "guard_name" => "api"],
        ];

        foreach ($datas as $data) {
            Role::create($data);
        }

        // factory(Role::class, 10)->create());
    }
}
