<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, ...$roles)
    {

        if (!Auth::check()) {
            return redirect()->route('login');
        }

      $user = Auth::user();

        // Check if user has at least one of the required roles
        if (!$user->hasAnyRole($roles)) {  
            // Redirect based on role
            if ($user->hasRole('super admin')) {
                return redirect()->route('superadmin.dashboard');
            } elseif ($user->hasRole('admin')) {
                return redirect()->route('admin.dashboard');
            } elseif ($user->hasRole('sales')) {
                return redirect()->route('sales.dashboard');
            } elseif ($user->hasRole('staff')) { 
                return redirect()->route('staff.dashboard');
            } elseif ($user->hasRole('reporting manager')) { 
                return redirect()->route('reportingmanager.dashboard');
            }
             else {
                abort(403, 'Unauthorized Access');
            }
        }
        return $next($request);
    }
}
