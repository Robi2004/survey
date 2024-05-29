<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use function Laravel\Prompts\table;

class PermissionRolesSeeder extends Seeder
{
    /**
     * Create roles and permissions
     */
    public function run(): void
    {
        $role = Role::create(['name' => 'user']);
        $permissions = Permission::create(['name' => 'user']);
        $role->syncPermissions($permissions);
        
        $role = Role::create(['name' => 'admin']);
        $permissions = Permission::create(['name' => 'admin']);
        $role->syncPermissions($permissions);
    }
}
