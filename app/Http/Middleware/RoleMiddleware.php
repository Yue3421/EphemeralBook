<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();
        
        // Check if user has the required role
        if ($role === 'admin' && !$user->isAdmin()) {
            abort(403, 'Unauthorized. Admin access required.');
        }
        
        if ($role === 'staff' && !$user->isStaff() && !$user->isAdmin()) {
            abort(403, 'Unauthorized. Staff access required.');
        }
        
        if ($role === 'customer' && !$user->isCustomer()) {
            abort(403, 'Unauthorized. Customer access required.');
        }

        return $next($request);
    }
}
