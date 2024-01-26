<?php

namespace Database\Seeders;

use App\Models\Keranjang;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreateAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'nama' => 'Admin', 
            'email' => 'admin@gmail.com',
            'email_verified_at' => now('Asia/Bangkok'),
            'no_telp' => '08000',
            'password' => bcrypt('123456789'),
            'alamat' => 'Jalan Abc',
            'no_rek' => '000',
        ]);

        Keranjang::create([
            'id_pengguna' => $user->id,
        ]);
    
        $role = Role::create(['name' => 'Admin']);
     
        $permissions = Permission::pluck('id','id')->all();
   
        $role->syncPermissions($permissions);
     
        $user->assignRole([$role->id]);
    }
}
