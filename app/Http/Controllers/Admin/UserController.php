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

    // Show create form
    public function create()
    {
        
        return view('admin.createUser');
    }

    // user index with role-based visibility
    public function index()
    {
        
        $authUser = auth()->user();

        if ($authUser->hasRole('superadmin')) {
            // SuperAdmin sees only admins and managers
            $users = User::with('creator')
                ->whereHas('roles', function ($q) {
                    $q->whereIn('name', ['admin', 'manager']);
                })
                ->get();
        }

        elseif ($authUser->hasRole('admin')) {
            // Admin sees only users
            $users = User::with('creator')
                ->whereHas('roles', function ($q) {
                    $q->whereIn('name', ['manager', 'user']);
                })
                ->get();
        }

        elseif ($authUser->hasRole('manager')) {
            // Manager sees only users created by him
            $users = User::with('creator')
                ->whereHas('roles', function ($q) {
                    $q->where('name', 'user');
                })
                ->where('created_by', $authUser->id)
                ->get();
        }

        return view('admin.userindex', compact('users'));
    }


    // ⭐ STORE USER (MOST IMPORTANT CHANGE)
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email'=> 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'role' => 'required',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'created_by' => auth()->id(),   // ⭐ IMPORTANT
        ]);
    //    dd($user->getRoleNames());

        $user->assignRole($request->role); // Assign role to user

        return redirect()->back()->with('success', 'User created successfully');
    }

    // Show single user
    public function show($id)
    {
        return redirect()->route('admin.users.index');
    }
    // Show edit form
    public function edit($id)
    {
        $user = User::findOrFail($id);
        
        return view('admin.useredit', compact('user'));
    }

    // Update user

    public function update(Request $request, $id)
    {
    $user = User::findOrFail($id);

    $user->name = $request->name;
    $user->email = $request->email;

    if ($request->filled('password')) {
        $user->password = bcrypt($request->password);
    }

    $user->save();

    return back()->with('updated', 'User updated successfully!');
    }

}
