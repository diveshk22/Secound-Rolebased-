<?php

namespace App\Http\Controllers\Auth;
// app/Http/Controllers/Auth/LoginController.php
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    // Show login form
    public function showLoginForm()
    {
        return view('auth.Login');
    }
    // Handle login request
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        
        // Check for plain text password first
        $user = \App\Models\User::where('email', $request->email)->first();
        
        if ($user && $user->password === $request->password) {
            // Hash the password for future use
            $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
            $user->save();
            
            // Log the user in
            Auth::login($user);
            
            return $this->redirectBasedOnRole($user);
        }
        
        // Try normal hashed password authentication
        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();
            return $this->redirectBasedOnRole($user);
        }
        
        return back()->with('error', 'Invalid Username or Password');
    }
    
    private function redirectBasedOnRole($user)
    {
        // Check if user has admin role
        if($user->hasRole('admin')){
            return redirect()->route('admin.dashboard');
        }
        
        // Check if user has user role
        if($user->hasRole('user')){
            return redirect()->route('user.dashboard');
        }
        
        // If no specific role, check if user has any roles at all
        $roles = $user->getRoleNames();
        if($roles->contains('admin')){
            return redirect()->route('admin.dashboard');
        }
        if($roles->contains('user')){
            return redirect()->route('user.dashboard');
        }
        
        // Default fallback - redirect to user dashboard for any authenticated user
        return redirect()->route('user.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('/');
    }
}
