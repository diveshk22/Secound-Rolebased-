<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FixAdminRole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:admin-role {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix admin role assignment for a user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $user = \App\Models\User::where('email', $email)->first();
        
        if (!$user) {
            $this->error("User with email {$email} not found!");
            return 1;
        }
        
        // Remove all existing roles
        $user->syncRoles([]);
        
        // Assign admin role
        $user->assignRole('admin');
        
        $this->info("Admin role assigned to {$user->name} ({$user->email})");
        $this->info("User roles: " . $user->roles->pluck('name')->implode(', '));
        
        return 0;
    }
}
