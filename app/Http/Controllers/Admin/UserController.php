<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // users destroy admin /users/{user}

    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('success', 'User deleted successfully');
    }


    // role defines user index admin /users
    
    public function changeRole(User $user)
    {
        if($user->hasRole('admin')){
            $user->syncRoles('user'); //admin to user
        }else{
            $user->syncRoles('admin'); //user to admin
        }
        return redirect()->back()->with('success', 'User role updated successfully');
    }

    // create users in admin pannel

    public function create()
    {
        return view('admin.createuser');
    }
    // create user index admin /users
    public function index()
    {
        $users = User::role('user')->get(); // Fetch only users with 'user' role wale 
        return view('admin.userindex', compact('users'));   
    }
    // store user in admin pannel
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
        ]);
        // assign role user to created user
        $user->assignRole('user');
        return redirect()->back()->with('success', 'User created successfully');
    }
}
