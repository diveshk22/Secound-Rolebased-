<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /* ===========================
       USER LIST (ROLE BASED)
    ============================*/
    public function index()
    {
        $authUser = auth()->user();

        if ($authUser->hasRole('super_admin')) {
            // Super Admin sees all users
            
            $users = User::with('creator')->where('id', '!=', $authUser->id)->get();
        }
        elseif ($authUser->hasRole('admin')) {
            // Admin sees managers + users
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

        return view('usercreation.userIndex', compact('users'));
    }


    /* ===========================
       SHOW CREATE FORM
    ============================*/
    public function create()
    {
    $user = auth()->user();

    if ($user->hasRole('super_admin')) {
        // Super Admin can create all roles
        $roles = ['admin', 'manager', 'user'];
    }
    elseif ($user->hasRole('admin')) {
        // Admin can create manager + user
        $roles = ['manager', 'user'];
    }
    else {
        // Others can only create user
        $roles = ['user'];
    }

    return view('usercreation.CreateUser', compact('roles'));
    }

    /* ===========================
       STORE USER
    ============================*/
    public function store(Request $request)
    {
        $authUser = auth()->user();
        $request->validate([
            'name' => 'required',
            'email'=> 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'role' => 'required',
        ]);

        // Role Restrictions
        if ($authUser->hasRole('manager') && $request->role !== 'user') {
            abort(403);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'created_by' => $authUser->id,
        ]);

        $user->assignRole($request->role);

        // dd($user->getRoleNames());

        $route = $authUser->hasRole('admin') ? 'admin.users.index' : 'manager.users.index';

        return redirect()->back()->with('success', 'User created successfully');
    }


    /* ===========================
       EDIT USER
    ============================*/
    public function edit($id)
    {
        $authUser = auth()->user();
        $user = User::findOrFail($id);

        // Manager can edit only his created users
        if ($authUser->hasRole('manager') && $user->created_by != $authUser->id) {
            abort(403);
        }

        if ($authUser->hasRole('admin')) {
            $roles = \Spatie\Permission\Models\Role::whereIn('name', ['manager', 'user'])->get();
        } else {
            $roles = \Spatie\Permission\Models\Role::where('name', 'user')->get();
        }

        return view('usercreation.useredit', compact('user', 'roles'));
    }


    /* ===========================
       UPDATE USER
    ============================*/
    public function update(Request $request, $id)
    {
        $authUser = auth()->user();
        $user = User::findOrFail($id);

        if ($authUser->hasRole('manager') && $user->created_by != $authUser->id) {
            abort(403);
        }

        //validation users 
        $request->validate([
            'name' => 'required',
            'email'=> 'required|email|unique:users,email,'.$user->id,
            'password' => 'nullable|min:6|confirmed',
            'role' => 'nullable|in:manager,user',
        ]);

         // Role Restrictions
         if ($authUser->hasRole('manager') && $request->role !== 'user') {
            abort(403);
        }

        $user->name = $request->name;
        $user->email = $request->email;
       

        // Update role if changed
        if ($authUser->hasRole('admin') && $request->filled('role')) {
        $user->syncRoles([$request->role]);
        }

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return back()->with('updated', 'User updated successfully!');
    }


    /* ===========================
       DELETE USER
    ============================*/
    public function destroy(User $user)
    {
        $authUser = auth()->user();

        // Manager cannot delete
        if ($authUser->hasAnyRole('manager')) {
            abort(403);
        }

        $user->delete();

        return back()->with('success', 'User deleted successfully');
    }

}
