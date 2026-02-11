<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfWrongRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();
        $user->load('roles');

        // If Super Admin tries to access other role routes, redirect to Super Admin dashboard
        if ($user->hasRole('superadmin') && $role !== 'superadmin') {
            return redirect()->route('superadmin.superdashboard');
        }

        // If user doesn't have the required role, redirect to their appropriate dashboard
        if (!$user->hasRole($role)) {
            if ($user->hasRole('superadmin')) {
                return redirect()->route('superadmin.superdashboard');
            } elseif ($user->hasRole('admin')) {
                return redirect()->route('admin.dashboard');
            } elseif ($user->hasRole('manager')) {
                return redirect('/manager/dashboard');
            } elseif ($user->hasRole('user')) {
                return redirect()->route('user.dashboard');
            }
            
            // If no role found, logout and redirect to login
            auth()->logout();
            return redirect()->route('login')->with('error', 'Access denied. Please contact administrator.');
        }

        return $next($request);
    }
}