<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Delete user
    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('success', 'User deleted successfully');
    }

    // Make Manager
    public function makeManager($id)
    {
        $user = User::findOrFail($id);
        $user->syncRoles('manager');

        return back()->with('success', 'User is now a Manager');
    }

    // Change Role Admin <-> User
    public function changeRole(User $user)
    {
        if ($user->hasRole('admin')) {
            $user->syncRoles('user');
        } else {
            $user->syncRoles('admin');
        }

        return redirect()->back()->with('success', 'User role updated successfully');
    }

    // Show create form
    public function create()
    {
        return view('admin.createuser');
    }

    // List only users
    public function index()
    {
        $users = User::role('user')->with('creator')->get();
        return view('admin.userindex', compact('users'));
    }

    // ⭐ STORE USER (MOST IMPORTANT CHANGE)
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email'=> 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'created_by' => auth()->id(),   // ⭐ IMPORTANT
        ]);

        $user->assignRole('user');

        return redirect()->back()->with('success', 'User created successfully');
    }
}
