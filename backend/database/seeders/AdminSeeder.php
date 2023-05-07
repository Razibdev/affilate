<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = DB::table('admins')->where('email', 'superadmin@example.net')->first();

        if (!$admin) {

            DB::table('admins')->insert([

                'name' => 'Super Admin',

                'email' => 'superadmin@example.net',

                'password' => bcrypt('1234567890'),

            ]);
        }
    }
}
