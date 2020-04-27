<?php

use App\Models\Users\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table("users")->insert([
        //     [
        //         "username" => "admin",
        //         "email" => "vheng@gmail.com",
        //         "email_verified" => 1,
        //         "phone_number" => "85577774587",
        //         "phone_verified" => 1,
        //         "password" => Hash::make("admin"),
        //         "status" => 1
        //     ],
        // ]);

        $data = [
            "username" => "admin",
            "email" => "vheng@gmail.com",
            "email_verified" => 1,
            "phone_number" => "85577774587",
            "phone_verified" => 1,
            "password" => Hash::make("admin"),
            "status" => 1
        ];
        $user = User::create($data);
        $user->assignRole("Super Admin");
    }
}
