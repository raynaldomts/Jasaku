<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class LevelUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $penjual = Role::create(['name' => 'penjual']);
        $penjual->givePermissionTo(['jasa-list','jasa-create','jasa-edit','jasa-delete', 'user-list', 'user-edit', 'order-list', 'order-create', 'order-penjual']);

        $konsumen = Role::create(['name' => 'Konsumen']);
        $konsumen->givePermissionTo(['jasa-list', 'user-list', 'user-edit', 'order-list', 'order-create']);
    }
}
