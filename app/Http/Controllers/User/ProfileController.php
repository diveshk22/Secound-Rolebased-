<?php

namespace App\Http\Controllers\User;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{

    public function edit()
    {
        return view('user.task.profile');
    }
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed',
            'photo' => 'nullable|image|max:2048',
        ]);

        if($request ->hasFile('photo')){
            $imageName = time().'.'.$request->photo->extension();
            $request->photo->move(public_path('profile_photos'), $imageName);
            $user->photo = $imageName;
        }
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();
        return back()->with('success', 'profile updated successfully.');
    }
}
