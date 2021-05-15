<?php

namespace Database\Seeders;

use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'name' => 'Super Admin',
                'user_id' => 1,
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'Admin',
                'user_id' => 2,
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'Author',
                'user_id' => 3,
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'Editor',
                'user_id' => 4,
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'User',
                'user_id' => 5,
                'created_at' => Carbon::now(),
            ],
        ];

        foreach($roles as $role) {
            DB::table('roles')->insert($role);
        }
    }
}
