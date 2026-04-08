<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckSidebarAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Jika user belum login, biarkan lanjut (akan di-handle oleh auth middleware)
        if (!Auth::check()) {
            return $next($request);
        }

        $user = Auth::user();
        $userRole = $user->peran;
        
        // Daftar route yang DIizinkan tanpa cek referer
        $allowedRoutes = [
            // Auth & Landing
            'login',
            'logout',
            'register',
            'password.request',
            'otp.send',
            'otp.verify',
            'otp.check',
            'password.reset',
            'password.update',
            'google.login',
            'google.callback',
            'landing',
            'companyprofile',
            
            // Dashboard
            'superadmin.dashboard',
            'admin.dashboard',
            'tentor.dashboard',
            
            // Profile (semua role)
            'profile.index',
            'profile.edit',
            'profile.update',
            'password.edit',
            'password.update.profile',
            
            // API routes
            'search.murid',
            'get.harga.paket',
            'get.murid.paket',
            'cek.status.pembayaran',
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
            return redirect()->route($userRole . '.dashboard')
                ->with('error', 'Akses tidak diizinkan! Silakan gunakan menu sidebar.');
        }
        
        // Cek apakah referer berasal dari domain yang sama
        $currentHost = $request->getHost();
        $refererHost = parse_url($referer, PHP_URL_HOST);
        
        if ($currentHost !== $refererHost) {
            return redirect()->route($userRole . '.dashboard')
                ->with('error', 'Akses tidak diizinkan! Akses hanya melalui halaman internal.');
        }
        
        return $next($request);
    }
}