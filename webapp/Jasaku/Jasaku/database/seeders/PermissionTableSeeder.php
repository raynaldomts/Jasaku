<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            'jasa-list',
            'jasa-create',
            'jasa-edit',
            'jasa-delete',
            'order-list',
            'order-create',
            'order-edit',
            'order-delete',
            'order-penjual',
            ];
        
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
