<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Daftar permission sesuai permintaan
        $permissions = [
            'create.user',
            'edit.user',
            'delete.user',
            'create.role',
            'edit.role',
            'delete.role',
            'create.permission',
            'edit.permission',
            'delete.permission',
        ];

        // Buat permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Buat role Admin & assign semua permission
       // $admin = Role::firstOrCreate(['name' => 'admin']);
       //$admin->syncPermissions($permissions);

        // Buat role User & hanya assign permission 'edit.user'
      //  $user = Role::firstOrCreate(['name' => 'user']);
       // $user->syncPermissions(['edit.user']);
    }
}
