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
    public function handle($request, Closure $next, $role)
    {

        if (!Auth::check() || !Auth::user()->hasRole($role)) {
            if(Auth::user()->hasRole('superadmin')){
                return redirect()->route('superadmin.dashboard');
            }else if(Auth::user()->hasRole('admin')){
                return redirect()->route('admin.dashboard');
            }else if(Auth::user()->hasRole('sales')){
                return redirect()->route('sales.dashboard');
            }else{
                // return $next($request);
                abort(403, 'Unauthorized');
            }
        }
        return $next($request);
    }
}
