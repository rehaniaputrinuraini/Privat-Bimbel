<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckSidebarAccess
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return $next($request);
        }

        // Daftar route yang BOLEH diakses LANGSUNG (tanpa referer)
        $allowedDirectRoutes = [
            'login', 'logout', 'register', 'landing', 'companyprofile',
            'password.request', 'otp.send', 'otp.verify', 'otp.check', 'password.reset', 'password.update',
            'google.login', 'google.callback',
            'superadmin.dashboard', 'admin.dashboard', 'tentor.dashboard',
            'profile.index', 'profile.edit', 'profile.update', 'password.edit', 'password.update.profile',
            'search.murid', 'get.harga.paket', 'get.murid.paket', 'cek.status.pembayaran',
            'store.last.url',
        ];
        
        $currentRoute = $request->route()->getName();
        
        if (!$currentRoute || in_array($currentRoute, $allowedDirectRoutes)) {
            return $next($request);
        }
        
        $referer = $request->headers->get('referer');
        $user = Auth::user();
        $userRole = $user->peran;
        
        // Jika TIDAK ADA referer (ketik URL langsung di browser)
        if (!$referer) {
            // Ambil URL SEBELUMNYA dari session (halaman sebelumnya)
            $previousUrl = session('last_valid_url');
            
            // Jika ada URL sebelumnya, redirect ke sana
            if ($previousUrl && $previousUrl !== $request->fullUrl()) {
                return redirect()->to($previousUrl)
                    ->with('error', '⚠️ Akses ditolak! Halaman hanya bisa diakses melalui menu sidebar.');
            }
            
            // Fallback: redirect ke dashboard
            return redirect()->route($userRole . '.dashboard')
                ->with('error', '⚠️ Akses ditolak! Silakan gunakan menu sidebar.');
        }
        
        // Cek domain
        $currentHost = $request->getHost();
        $refererHost = parse_url($referer, PHP_URL_HOST);
        
        if ($currentHost !== $refererHost) {
            $previousUrl = session('last_valid_url');
            return redirect()->to($previousUrl ?? route($userRole . '.dashboard'))
                ->with('error', '⚠️ Akses ditolak! Akses hanya dari halaman internal.');
        }
        
        return $next($request);
    }
}