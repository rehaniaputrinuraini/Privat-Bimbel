<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckSidebarAccess
{
    public function handle(Request $request, Closure $next)
    {
        // Daftar route yang DIizinkan (tidak perlu cek referer)
        $allowedRoutes = [
            'login',
            'logout',
            'superadmin.dashboard',
            'admin.dashboard',
            'tentor.dashboard',
            'profile.index',
            'profile.edit',
            'profile.update',
            'password.edit',
            'password.update.profile',
        ];
        
        $currentRoute = $request->route()->getName();
        
        // Jika route termasuk yang diizinkan, lewati pengecekan
        if (in_array($currentRoute, $allowedRoutes)) {
            return $next($request);
        }
        
        // Ambil URL sebelumnya (referer)
        $referer = $request->headers->get('referer');
        
        // Jika tidak ada referer (akses langsung via URL)
        if (!$referer) {
            $user = auth()->user();
            if ($user) {
                return redirect()->route($user->peran . '.dashboard')
                    ->with('error', 'Akses tidak diizinkan! Silakan gunakan menu sidebar.');
            }
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }
        
        // Cek apakah referer berasal dari domain yang sama
        $currentHost = $request->getHost();
        $refererHost = parse_url($referer, PHP_URL_HOST);
        
        if ($currentHost !== $refererHost) {
            $user = auth()->user();
            if ($user) {
                return redirect()->route($user->peran . '.dashboard')
                    ->with('error', 'Akses tidak diizinkan!');
            }
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }
        
        return $next($request);
    }
}