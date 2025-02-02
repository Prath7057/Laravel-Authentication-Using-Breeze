<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;
        //
        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                if ($guard == 'super_admin' && Route::is('SuperAdmin.*')) {
                    return redirect()->route('SuperAdmin.dashboard');
                } else if ($guard == 'admin' && Route::is('Admin.*')) {
                    return redirect()->route('Admin.dashboard');
                } else {
                    return redirect()->route('dashboard');
                }

            }
        }
        return $next($request);
    }
}
