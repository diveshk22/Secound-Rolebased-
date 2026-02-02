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
        // Refresh user roles from database to get the latest role
        $user->refresh();
        $user->load('roles');
        
        // Check if user has superadmin role
        if($user->hasRole('superadmin')){
            return redirect()->route('superadmin.superdashboard');
        }
        
        // Check if user has admin role
        if($user->hasRole('admin')){
            return redirect()->route('admin.dashboard');
        }
        
        // Check if user has user role
        if($user->hasRole('user')){
            return redirect()->route('user.dashboard');
        }

        if(auth()->user()->hasRole('admin')){
            return redirect('/admin/dashboard');

        }
        elseif (auth()->user()->hasRole('user')){
            return redirect('/manager/dashboard');
        }
        else{
            return redirect('/user/dashboard');
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
