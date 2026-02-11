<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

class FixSuperAdminRole extends Command
{
    protected $signature = 'fix:superadmin';
    protected $description = 'Fix super admin role assignment';

    public function handle()
    {
        $this->info('Fixing super admin role...');
        
        // Ensure role exists
        $role = Role::firstOrCreate(['name' => 'superadmin', 'guard_name' => 'web']);
        $this->info('Super admin role ensured in database');
        
        // Find or create super admin user
        $user = User::where('email', 'superadmin@example.com')->first();
        
        if (!$user) {
            $user = User::create([
                'name' => 'Super Admin',
                'email' => 'superadmin@example.com',
                'password' => bcrypt('password')
            ]);
            $this->info('Super admin user created');
        }
        
        // Sync roles
        $user->syncRoles(['superadmin']);
        $this->info('Super admin role assigned');
        
        // Verify
        if ($user->hasRole('superadmin')) {
            $this->info('✓ Success! Super admin can now login');
        } else {
            $this->error('✗ Failed to assign role');
        }
    }
}
