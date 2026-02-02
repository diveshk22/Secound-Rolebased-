<?php

namespace App\Http\Controllers\superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class SuperAdminController extends Controller
{
    public function index()
    {
        return view('Super-Admin.Super-Dashboard');
    }

    public function users()
    {
        $users = User::with('roles')->get();
        return view('Super-Admin.users', compact('users'));
    }

    public function changeRole(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|in:superadmin,admin,user'
        ]);

        $user = User::findOrFail($id);
        
        // Prevent Super Admin from changing their own role
        if ($user->id === auth()->id() && auth()->user()->hasRole('superadmin')) {
            return back()->with('error', 'You cannot change your own role!');
        }
        
        // Remove all existing roles and assign the new one
        $user->syncRoles([$request->role]);

        return back()->with('success', 'User role updated to ' . ucfirst($request->role) . ' successfully!');
    }
}
