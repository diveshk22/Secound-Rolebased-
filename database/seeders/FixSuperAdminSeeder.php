<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class FixSuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure superadmin role exists
        $superadminRole = Role::firstOrCreate(['name' => 'superadmin', 'guard_name' => 'web']);
        
        // Find super admin user by email
        $superadmin = User::where('email', 'superadmin@example.com')->first();
        
        if ($superadmin) {
            // Remove all existing roles
            $superadmin->syncRoles([]);
            
            // Assign superadmin role
            $superadmin->assignRole('superadmin');
            
            echo "Super admin role assigned successfully!\n";
        } else {
            echo "Super admin user not found. Creating new super admin...\n";
            
            $superadmin = User::create([
                'name' => 'Super Admin',
                'email' => 'superadmin@example.com',
                'password' => bcrypt('password')
            ]);
            
            $superadmin->assignRole('superadmin');
            
            echo "Super admin created and role assigned!\n";
        }
    }
}
