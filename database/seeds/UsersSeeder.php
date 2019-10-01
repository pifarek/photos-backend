<?php

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Marcin Piwarski',
            'email' =>'marcinpiwarski@gmail.com',
            'password' => bcrypt('system123'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
