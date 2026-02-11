<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Get admin user by email - CHANGE THIS EMAIL
$email = 'admin@example.com';

$user = App\Models\User::where('email', $email)->first();

if (!$user) {
    echo "User not found with email: {$email}\n";
    echo "Please update the \$email variable in fix_admin.php with your actual admin email.\n";
    exit(1);
}

echo "Found user: {$user->name} ({$user->email})\n";
echo "Current roles: " . $user->roles->pluck('name')->implode(', ') . "\n";

// Ensure admin role exists
$adminRole = Spatie\Permission\Models\Role::firstOrCreate(['name' => 'admin']);

// Assign admin role
$user->syncRoles(['admin']);

echo "Admin role assigned!\n";
echo "New roles: " . $user->fresh()->roles->pluck('name')->implode(', ') . "\n";
echo "\nYou can now login with this account.\n";
