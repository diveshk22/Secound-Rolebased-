<?php

namespace App\Http\Controllers\Managers;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CreateUController extends Controller
{
    public function create()
    {
        $users = User::role('user')->get();
        return view('managers.Userscreate', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'created_by' => auth()->id(),
        ]);
        // die( $user);
        $user->assignRole('user');
        return back()->with('success', 'User created successfully.');
    }
    public function allUsers()
    {
    $users = User::role('user')
                ->where('created_by', auth()->id())
                ->with('creator')
                ->get();

    return view('managers.allusers', compact('users'));
    }


}
