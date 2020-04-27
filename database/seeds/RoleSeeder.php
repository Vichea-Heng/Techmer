<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Users\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        DB::table("roles")->insert([
            [
                "name" => "Super Admin",
                "guard_name" => "api",
            ]
        ]);

        // factory(Role::class, 10)->create());
    }
}
