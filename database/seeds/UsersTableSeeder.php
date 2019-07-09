<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => '$2y$10$x8.us8JYo4gHFj9Pm9XUruby9Uyza.EwrRh4lAlsdYQuEW.rvG2Em' //Useradmin
        ]);
    }
}
