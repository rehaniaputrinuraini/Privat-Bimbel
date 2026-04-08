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
     * @param  \Closure  $next
     * @param  string  ...$roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        $userRole = $user->peran;

        // Cek apakah role user termasuk dalam roles yang diizinkan
        if (in_array($userRole, $roles)) {
            return $next($request);
        }

        // Jika tidak memiliki akses, redirect ke dashboard masing-masing
        switch ($userRole) {
            case 'superadmin':
                return redirect()->route('superadmin.dashboard')->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
            case 'admin':
                return redirect()->route('admin.dashboard')->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
            case 'tentor':
                return redirect()->route('tentor.dashboard')->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
            default:
                abort(403, 'Unauthorized access.');
        }
    }
}