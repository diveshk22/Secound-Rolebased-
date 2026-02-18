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
        
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();
            if($user->hasRole('superadmin')){
                return redirect()->route('superadmin.superdashboard');
            }
            if($user->hasRole('admin')){
                return redirect()->route('admin.dashboard');
        }
            if($user->hasRole('manager')){
                return redirect()->route('manager.dashboard');
        }
            if($user->hasRole('user')){
                return redirect()->route('user.dashboard');
        }
            Auth::logout();
            return redirect()->route('login')->with('error', 'No valid role assigned. Please contact administrator.');
            return redirect()->route('login')->with('error', 'Invalid Username or Password');
        }

        return back()->with('error', 'Invalid Username or Password');

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
        // Refresh user and load roles
        $user = $user->fresh(['roles']);
        
        // Check roles in priority order
        if($user->hasRole('superadmin')){
            return redirect()->route('superadmin.superdashboard');
        }
        
        if($user->hasRole('admin')){
            return redirect()->route('admin.dashboard');
        }
        
        if($user->hasRole('manager')){
            return redirect()->route('manager.dashboard');
        }
        
        if($user->hasRole('user')){
            return redirect()->route('user.dashboard');
        }
        
        // If no role found, logout and redirect to login
        Auth::logout();
        return redirect()->route('login')->with('error', 'No valid role assigned. Please contact administrator.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('/');
    }
}
