<?php

namespace Database\Seeders;

use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $password = Hash::make('password');

        $user1 = [
            'name' => 'Mr. Super Admin',
            'email' => 'sadmin@sadmin.com',
            'role_type' => 'administrator',
            'password' => $password,
            'created_at' => Carbon::now(),
        ];

        DB::table('users')->insert($user1);

        $user2 = [
            'name' => 'Mr. Admin',
            'email' => 'admin@admin.com',
            'role_type' => 'administrator',
            'password' => $password,
            'created_at' => Carbon::now(),
        ];

        DB::table('users')->insert($user2);

        $user3 = [
            'name' => 'Mr. Author',
            'email' => 'author@author.com',
            'role_type' => 'administrator',
            'password' => $password,
            'created_at' => Carbon::now(),
        ];

        DB::table('users')->insert($user3);

        $user4 = [
            'name' => 'Mr. Editor',
            'email' => 'editor@editor.com',
            'role_type' => 'administrator',
            'password' => $password,
            'created_at' => Carbon::now(),
        ];

        DB::table('users')->insert($user4);

        $user5 = [
            'name' => 'Mr. User 1',
            'email' => 'user1@user.com',
            'role_type' => 'user',
            'password' => $password,
            'created_at' => Carbon::now(),
        ];

        DB::table('users')->insert($user5);

        $user6 = [
            'name' => 'Mr. User 2',
            'email' => 'user2@user.com',
            'role_type' => 'user',
            'password' => $password,
            'created_at' => Carbon::now(),
        ];

        DB::table('users')->insert($user6);

        $user7 = [
            'name' => 'Mr. User 3',
            'email' => 'user3@user.com',
            'role_type' => 'user',
            'password' => $password,
            'created_at' => Carbon::now(),
        ];

        DB::table('users')->insert($user7);

        $user8 = [
            'name' => 'Mr. User 4',
            'email' => 'user4@user.com',
            'role_type' => 'user',
            'password' => $password,
            'created_at' => Carbon::now(),
        ];

        DB::table('users')->insert($user8);

        
        $user9 = [
            'name' => 'Mr. User',
            'email' => 'user@user.com',
            'role_type' => 'user',
            'password' => $password,
            'created_at' => Carbon::now(),
        ];

        DB::table('users')->insert($user9);
    }
}
