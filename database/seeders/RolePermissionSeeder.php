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
        Permission::firstOrCreate(['name' => 'manage tasks', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'view tasks', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'create tasks', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'edit tasks', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'delete tasks', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'view projects', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'create projects', 'guard_name' => 'web']);

        // Create roles
        $superadminRole = Role::firstOrCreate(['name' => 'superadmin', 'guard_name' => 'web']);
        $adminRole      = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $managerRole    = Role::firstOrCreate(['name' => 'manager', 'guard_name' => 'web']); // ✅ yeh missing tha
        $userRole       = Role::firstOrCreate(['name' => 'user', 'guard_name' => 'web']);

        // Assign permissions to roles
        $superadminRole->syncPermissions(Permission::all());
        $adminRole->syncPermissions(Permission::all());
        $managerRole->syncPermissions(['view tasks', 'create tasks', 'edit tasks', 'view projects', 'create projects']);
        $userRole->syncPermissions(['view tasks', 'create tasks']);
    }
}
