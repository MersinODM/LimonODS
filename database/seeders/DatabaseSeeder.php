<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

//        $this->call([
//            PermissionRoleSeeder::class
//            ]);

        $user = new User([
            "full_name" => "Hakan GÜLEN",
            "phone" => "05556614641",
            "email" => "hgulen33@gmail.com",
            "password" => Hash::make("Hakan.1986")
        ]);
        $user->save();
        $user->assignRole('admin');
    }
}
