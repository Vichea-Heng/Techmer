<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Users\PermissionGroup;

class PermissionGroupSeeder extends Seeder
{
    public function run()
    {
        DB::table("permission_groups")->insert([
            ["name" => "Role"],
            ["name" => "Permission"],
        ]);

        // factory(PermissionGroup::class, 10)->create());
    }
}
