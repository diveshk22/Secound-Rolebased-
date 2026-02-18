<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    // Handle an incoming request.
    public function handle(Request $request, Closure $next,  ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect('login');
        }   

        // dd($roles);
        $hasAccess = false;
        foreach ($roles as $role){
            if(auth()->user()->hasRole($role)){
                $hasAccess = true;
                break;
            }
        }
        if (!$hasAccess) {
            abort(403, 'Access Denied: You do not have the required role(s) to access this page.');
        }
        return $next($request);
    }
}