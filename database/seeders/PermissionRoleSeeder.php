<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i <= 15; $i++) {
            $data = [
                'role_id' => 1,
                'permission_id' => $i,
            ];

            DB::table('permission_role')->insert($data);
        }
    }
}
