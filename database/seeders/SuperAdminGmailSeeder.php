<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class SuperAdminGmailSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure superadmin role exists
        Role::firstOrCreate(['name' => 'superadmin', 'guard_name' => 'web']);
        
        // Create or update superadmin@gmail.com user
        $superadmin = User::updateOrCreate(
            ['email' => 'superadmin@gmail.com'],
            [
                'name' => 'Super Admin',
                'password' => bcrypt('12345678')
            ]
        );
        
        // Assign superadmin role
        if (!$superadmin->hasRole('superadmin')) {
            $superadmin->assignRole('superadmin');
        }
        
        echo "Super admin (superadmin@gmail.com) created/updated successfully!\n";
    }
}
