<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // Redirect berdasarkan role (peran)
                return $this->redirectTo(Auth::user());
            }
        }

        return $next($request);
    }

    /**
     * Redirect user berdasarkan peran mereka
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function redirectTo($user)
    {
        $role = $user->peran; // menggunakan kolom 'peran'

        switch ($role) {
            case 'superadmin':
                return redirect()->route('superadmin.dashboard');
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'tentor':
                return redirect()->route('tentor.dashboard');
            default:
                return redirect()->route('landing');
        }
    }
}