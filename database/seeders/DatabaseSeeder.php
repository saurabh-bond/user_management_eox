<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

//namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
        /**
         * Seed the application's database.
         *
         * @return void
         */
        public function run()
        {
                DB::table('users')->delete();
                for ($i = 1; $i < 500; $i++) {
                        DB::table('users')->insert([
                                'name' => 'Demo User ' . $i,
                                'username' => "user{$i}",
                                'email' => "user{$i}@gmail.com",
                                'password' => Hash::make('123456'),
                                'active' => 1,
                                'created' => time(),
                                'updated' => time(),
                        ]);
                }
        }
}
