<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }
        
        // Cek apakah peran user sesuai dengan yang diizinkan
        if (auth()->user()->peran !== $role) {
            // Redirect ke dashboard masing-masing dengan pesan error
            $dashboardRoute = auth()->user()->peran . '.dashboard';
            return redirect()->route($dashboardRoute)
                ->with('error', 'Anda tidak memiliki akses ke halaman ' . $request->path());
        }
        
        return $next($request);
    }
}