<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  mixed  ...$roles  List of allowed roles
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next, ...$roles)
    {
        $allowedRoles = $roles; // Get roles passed to the middleware
        $user = Auth::guard('admin')->user();
        if ($user) {
            Log::info('RoleMiddleware: User role is ' . $user->role);
            if (in_array($user->role, $allowedRoles)) {
                return $next($request);
            }
        }
        Log::warning('RoleMiddleware: Unauthorized access attempt by user with role ' . $user->role);
        abort(403, 'Unauthorized action.');
    }
}