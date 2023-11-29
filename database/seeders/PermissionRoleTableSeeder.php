<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissionRole = [];

        for ($i = 1; $i <= 15; $i++) {
            $item = [
                'role_id' => 1,
                'permission_id' => $i,
                'created_at' => now(),
            ];

            $permissionRole[] = $item;
        }

        DB::table('permission_role')->insert($permissionRole);
    }
}
