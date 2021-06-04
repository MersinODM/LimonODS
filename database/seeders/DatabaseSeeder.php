<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use SebastianBergmann\Environment\Console;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     * @throws \Exception
     */
    public function run()
    {
        try {
            DB::beginTransaction();
            $this->call([
                PermissionRoleSeeder::class,
                LessonSeeder::class,
            ]);

            $user = new User([
                "full_name" => "Hakan GÜLEN",
                "phone" => "05556614641",
                "email" => "hgulen33@gmail.com",
                "password" => Hash::make("Deneme.1234")
            ]);
            $user->save();
            $user->assignRole('admin');
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
