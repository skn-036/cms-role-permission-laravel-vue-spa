<?php

namespace Database\Seeders;

use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'Products-all',
            'Products-view',
            'Products-create',
            'Products-edit',
            'Products-delete',
            'Roles-all',
            'Roles-view',
            'Roles-create',
            'Roles-edit',
            'Roles-delete',
            'Permissions-all',
            'Permissions-view',
            'Permissions-create',
            'Permissions-edit',
            'Permissions-delete',
        ];

        foreach ($permissions as $permission) {
            $input = [
                'name' => $permission,
                'created_at' => Carbon::now(),
            ];
            DB::table('permissions')->insert($input);
        }
    }
}
