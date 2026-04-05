<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // JIKA USER SUDAH LOGIN, TENDANG KE DASHBOARD SESUAI PERANNYA
                $user = Auth::user();
                return redirect()->route($user->peran . '.dashboard');
            }
        }

        return $next($request);
    }
}