# Fix Admin Access Denied Issue

## Problem
Admin login shows "Access Denied" error.

## Root Cause
The admin user may not have the 'admin' role properly assigned in the database.

## Solution

Run this command to fix the admin role assignment:

```bash
php artisan fix:admin-role admin@example.com
```

Replace `admin@example.com` with your actual admin email address.

## Alternative: Run Database Seeders

If the roles don't exist, run:

```bash
php artisan db:seed --class=RolePermissionSeeder
php artisan db:seed --class=AssignAdminRoleSeeder
```

## Verify Role Assignment

After running the fix command, try logging in again. The command will show you the roles assigned to the user.
