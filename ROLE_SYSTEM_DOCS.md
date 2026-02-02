# Role-Based Access Control System

## Overview
This Laravel application implements a comprehensive role-based access control system with three main roles:
- **Super Admin**: Full system control, can manage all users and change roles
- **Admin**: Can manage tasks and users (limited permissions)
- **User**: Basic access to assigned tasks and profile management

## How It Works

### Role Management
1. **Super Admin Dashboard**: Access via `/superadmin/Super-dashboard`
2. **User Management**: Super Admins can view all users at `/superadmin/users`
3. **Role Changes**: Super Admins can change any user's role (except their own)

### Authentication Flow
1. User logs in with email/password
2. System checks user's current role from database
3. User is redirected to appropriate dashboard:
   - Super Admin → `/superadmin/Super-dashboard`
   - Admin → `/admin/dashboard`
   - User → `/user/dashboard`

### Role Change Process
1. Super Admin selects new role from dropdown
2. System validates the role change
3. Database is updated with new role
4. User gets appropriate access on next login

### Security Features
- **Middleware Protection**: Each route group is protected by role-specific middleware
- **Auto-Redirect**: Users trying to access wrong role areas are redirected to their dashboard
- **Self-Protection**: Super Admins cannot change their own role
- **Validation**: All role changes are validated before processing

### Key Files
- `SuperAdminController.php`: Handles user management and role changes
- `LoginController.php`: Manages authentication and role-based redirection
- `RedirectIfWrongRole.php`: Middleware for role-based access control
- `users.blade.php`: Super Admin interface for managing users

### Database
- Uses Spatie Laravel Permission package
- Roles are stored in `roles` table
- User-role relationships in `model_has_roles` table
- Changes are immediately reflected in database

## Usage
1. Super Admin logs in and goes to "Manage Users"
2. Selects new role from dropdown for any user
3. Clicks "Update" and confirms the change
4. User's role is immediately updated in database
5. When that user logs in next time, they get access according to new role

## Testing
To test the system:
1. Create test users with different roles
2. Log in as Super Admin
3. Change a user's role from Admin to User
4. Log out and log in as that user
5. Verify they now have User-level access only