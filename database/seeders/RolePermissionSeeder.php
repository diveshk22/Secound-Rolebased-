<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset permission cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        Permission::firstOrCreate(['name' => 'manage tasks']);
        Permission::firstOrCreate(['name' => 'view tasks']);
        Permission::firstOrCreate(['name' => 'create tasks']);
        Permission::firstOrCreate(['name' => 'edit tasks']);
        Permission::firstOrCreate(['name' => 'delete tasks']);

        // Create roles
        $superadminRole = Role::firstOrCreate(['name' => 'superadmin']);
        $adminRole      = Role::firstOrCreate(['name' => 'admin']);
        $managerRole    = Role::firstOrCreate(['name' => 'manager']); // ✅ yeh missing tha
        $userRole       = Role::firstOrCreate(['name' => 'user']);

        // Assign permissions to roles
        $superadminRole->syncPermissions(Permission::all());
        $adminRole->syncPermissions(Permission::all());
        $managerRole->syncPermissions(['view tasks', 'create tasks', 'edit tasks']);
        $userRole->syncPermissions(['view tasks', 'create tasks']);
    }
}
