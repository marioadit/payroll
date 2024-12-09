<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $allowedRoles = ["Admin Bank", "Super Admin", "Admin Payroll"];
        $user = Auth::guard('admin')->user();

        if ($user) {
            \Log::info('Authenticated user role: ' . $user->role);
        } else {
            \Log::info('No authenticated user.');
        }

        if ($user && in_array($user->role, array_merge($allowedRoles, $roles))) {
            return $next($request);
        }

        abort(403, 'Unauthorized action.');
    }
}
