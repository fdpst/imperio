<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        /*$this->call(UsersTableSeeder::class);*/
        DB::table('users')->insert([
           'name' => 'admin',
           'email' => 'admin@admin.com',
           'password' => Hash::make('admin'),
           'email_verified_at' => now(),
           'role' => 'admin'
       ]);
    }
}
