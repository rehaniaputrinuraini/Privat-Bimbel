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

            // ===== SUPERADMIN ROUTES =====
            'superadmin.kelola-murid',
            'superadmin.murid.create',
            'superadmin.murid.store',
            'superadmin.murid.edit',
            'superadmin.murid.update',
            'superadmin.murid.destroy',

            'superadmin.harga-paket',
            'superadmin.harga-paket.create',
            'superadmin.harga-paket.store',
            'superadmin.harga-paket.edit',
            'superadmin.harga-paket.update',
            'superadmin.harga-paket.destroy',

            'superadmin.pembayaran',
            'superadmin.pembayaran.create',
            'superadmin.pembayaran.store',
            'superadmin.pembayaran.edit',
            'superadmin.pembayaran.update',
            'superadmin.pembayaran.destroy',

            'superadmin.kelola-tentor',
            'superadmin.kelola-tentor.create',
            'superadmin.kelola-tentor.store',
            'superadmin.kelola-tentor.edit',
            'superadmin.kelola-tentor.update',
            'superadmin.kelola-tentor.destroy',
            'superadmin.kelola-tentor.toggle-status',

            'superadmin.kelola-admin',
            'superadmin.kelola-admin.create',
            'superadmin.kelola-admin.store',
            'superadmin.kelola-admin.edit',
            'superadmin.kelola-admin.update',
            'superadmin.kelola-admin.destroy',

            'superadmin.laporan-keuangan',
            'superadmin.laporan-keuangan.create',
            'superadmin.laporan-keuangan.store',
            'superadmin.laporan-keuangan.destroy',

            'superadmin.riwayat-presensi',
            'superadmin.rekap-gaji',

            // ===== ADMIN ROUTES =====
            'admin.kelola-murid',
            'admin.murid.create',
            'admin.murid.store',
            'admin.murid.edit',
            'admin.murid.update',
            'admin.murid.destroy',

            'admin.harga-paket',
            'admin.harga-paket.create',
            'admin.harga-paket.store',
            'admin.harga-paket.edit',
            'admin.harga-paket.update',
            'admin.harga-paket.destroy',

            'admin.pembayaran',
            'admin.pembayaran.create',
            'admin.pembayaran.store',
            'admin.pembayaran.edit',
            'admin.pembayaran.update',
            'admin.pembayaran.destroy',

            'admin.data-tentor',  // ← PERHATIKAN: data-tentor, BUKAN kelola-tentor

            'admin.laporan-keuangan',
            'admin.laporan-keuangan.create',
            'admin.laporan-keuangan.store',
            'admin.laporan-keuangan.destroy',

            'admin.riwayat-presensi',
            'admin.rekap-gaji',

            // ===== TENTOR ROUTES =====
            'tentor.presensi',
            'tentor.presensi.masuk',
            'tentor.presensi.laporan',
            'tentor.presensi.keluar',
            'tentor.presensi.cek-status',
            'tentor.riwayat-presensi',
        ];
        
        $currentRoute = $request->route()->getName();
        
        if (!$currentRoute || in_array($currentRoute, $allowedDirectRoutes)) {
            session(['last_valid_url' => $request->fullUrl()]);
            return $next($request);
        }
        
        $referer = $request->headers->get('referer');
        $user = Auth::user();
        $userRole = $user->peran;

        $previousUrl = session('last_valid_url');
        
        // Jika TIDAK ADA referer (ketik URL langsung di browser)
        if (!$referer) {
            if ($previousUrl && $previousUrl !== $request->fullUrl()) {
                return redirect()->to($previousUrl)
                    ->with('error', '⚠️ Akses ditolak! Halaman hanya bisa diakses melalui menu sidebar.');
            }
            
            return redirect()->route($userRole . '.dashboard')
                ->with('error', '⚠️ Akses ditolak! Silakan gunakan menu sidebar.');
        }
        
        // Cek domain
        $currentHost = $request->getHost();
        $refererHost = parse_url($referer, PHP_URL_HOST);
        
        if ($currentHost !== $refererHost) {
            return redirect()->to($previousUrl ?? route($userRole . '.dashboard'))
                ->with('error', '⚠️ Akses ditolak! Akses hanya dari halaman internal.');
        }

        $refererPath = parse_url($referer, PHP_URL_PATH);
        $currentPath = $request->getPathInfo();

        $allowedPrefixes = ['/admin/', '/superadmin/', '/tentor/'];
        
        $refererHasRolePrefix = false;
        $currentHasRolePrefix = false;

        foreach ($allowedPrefixes as $prefix) {
            if (strpos($refererPath, $prefix) === 0) {
                $refererHasRolePrefix = true;
            }
            if (strpos($currentPath, $prefix) === 0) {
                $currentHasRolePrefix = true;
            }
        }

        if ($refererHasRolePrefix && $currentHasRolePrefix) {
            // Simpan URL terakhir yang valid
            session(['last_valid_url' => $request->fullUrl()]);
            return $next($request);
        }

        session(['last_valid_url' => $request->fullUrl()]);
        
        return $next($request);
    }
}