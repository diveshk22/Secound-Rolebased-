<?php
// Run this script once to fix the password in database
// Then delete this file

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

// Update the admin user password to be properly hashed
$user = User::where('email', 'admin@gmail.com')->first();
if ($user) {
    $user->password = Hash::make('12345678');
    $user->save();
    echo "Password updated successfully for admin@gmail.com\n";
} else {
    echo "User admin@gmail.com not found\n";
}