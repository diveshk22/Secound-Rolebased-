<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();
        $allowedRoles = collect($roles)->flatMap(fn($role) => explode('|', $role))->toArray();

        if ($user->hasAnyRole($allowedRoles)) {
            return $next($request);
        }

        abort(403, 'Access Denied: You do not have the required role(s) to access this page.');
    }
}