<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        $datas = [
            ["name" => "Create Role", "guard_name" => "api", "group_id" => "1"],
            ["name" => "ViewAny Role", "guard_name" => "api", "group_id" => "1"],
            ["name" => "ViewOwn Role", "guard_name" => "api", "group_id" => "1"],
            ["name" => "Update Role", "guard_name" => "api", "group_id" => "1"],
            ["name" => "Delete Role", "guard_name" => "api", "group_id" => "1"],

            ["name" => "Create Permission", "guard_name" => "api", "group_id" => "2"],
            ["name" => "ViewAny Permission", "guard_name" => "api", "group_id" => "2"],
            ["name" => "ViewOwn Permission", "guard_name" => "api", "group_id" => "2"],
            ["name" => "Update Permission", "guard_name" => "api", "group_id" => "2"],
            ["name" => "Delete Permission", "guard_name" => "api", "group_id" => "2"],
        ];

        foreach ($datas as $data) {
            Permission::create($data);
        }

        // factory(Permission::class, 10)->create());
    }
}
