<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        Role::create([
            "name" => "Super Admin",
            "guard_name" => "api",
        ]);

        // factory(Role::class, 10)->create());
    }
}
