<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\MuridController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\HargaPaketController;
use App\Http\Controllers\KelolaAdminController;
use App\Http\Controllers\KelolaTentorController;
use App\Http\Controllers\LaporanKeuanganController;
use App\Http\Controllers\Tentor\PresensiController;
use App\Http\Controllers\KelolaPresensiController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ========== 1. LANDING PAGE (Tanpa Login) ==========
Route::get('/', [LandingPageController::class, 'index'])->name('landing');
Route::get('/companyprofile', function () {
    return view('companyprofile.landing');
})->name('companyprofile');

// ========== 2. AUTHENTICATION (Tanpa Login) ==========
Route::middleware(['guest'])->group(function () {
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

    Route::post('/login', function (Request $request) {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            return redirect()->route($user->peran . '.dashboard');
        }
        return back()->withErrors(['email' => 'Email atau password salah.']);
    })->name('login.post');

    Route::get('/register', function () {
        return view('auth.register');
    })->name('register');
});

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');

// Google Login
Route::get('/auth/google', [GoogleAuthController::class, 'redirect'])->name('google.login');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])->name('google.callback');

// ========== 3. LUPA PASSWORD (OTP SYSTEM) ==========
Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotForm'])->name('password.request');
Route::post('/forgot-password/send', [ForgotPasswordController::class, 'sendOtp'])->name('otp.send');
Route::get('/verify-otp', [ForgotPasswordController::class, 'showVerifyForm'])->name('otp.verify');
Route::post('/verify-otp', [ForgotPasswordController::class, 'verifyOtp'])->name('otp.check');
Route::get('/reset-password', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('password.update');

// ========== 4. ROUTE UNTUK MENYIMPAN URL TERAKHIR ==========
Route::post('/store-last-url', function (Request $request) {
    if (Auth::check()) {
        session(['last_valid_url' => $request->url]);
    }
    return response()->json(['success' => true]);
})->name('store.last.url')->middleware('auth');

// ========== 5. ROUTE YANG DILINDUNGI MIDDLEWARE ==========
Route::middleware(['auth'])->group(function () {
    
    // ========== DASHBOARD ==========
    Route::get('/superadmin/dashboard', [DashboardController::class, 'superadmin'])->name('superadmin.dashboard');
    Route::get('/admin/dashboard', [DashboardController::class, 'admin'])->name('admin.dashboard');
    Route::get('/tentor/dashboard', [DashboardController::class, 'tentor'])->name('tentor.dashboard');
    
    // ========== PROFIL (Semua Role) ==========
    Route::get('/profil', function () {
        return view('dashboard.shared.profil.index');
    })->name('profile.index');
    
    Route::get('/profil/edit', function () {
        return view('dashboard.shared.profil.edit');
    })->name('profile.edit');
    
    Route::put('/profil/update', function (Request $request) {
        return redirect()->route('profile.index')->with('success', 'Profil diperbarui!');
    })->name('profile.update');
    
    Route::get('/profil/ubah-password', function () {
        return view('dashboard.shared.profil.ubah_password');
    })->name('password.edit');
    
    Route::put('/profil/password-update', function (Request $request) {
        return redirect()->route('profile.index')->with('success', 'Password berhasil diubah!');
    })->name('password.update.profile');
    
    // ========== SUPERADMIN ONLY ==========
    Route::middleware(['role:superadmin'])->prefix('superadmin')->name('superadmin.')->group(function () {
        
        // KELOLA MURID
        Route::get('/kelola-murid', [MuridController::class, 'index'])->name('kelola-murid');
        Route::get('/kelola-murid/create', [MuridController::class, 'create'])->name('murid.create');
        Route::post('/kelola-murid/store', [MuridController::class, 'store'])->name('murid.store');
        Route::get('/kelola-murid/edit/{id}', [MuridController::class, 'edit'])->name('murid.edit');
        Route::put('/kelola-murid/update/{id}', [MuridController::class, 'update'])->name('murid.update');
        Route::delete('/kelola-murid/destroy/{id}', [MuridController::class, 'destroy'])->name('murid.destroy');
        
        // HARGA PAKET
        Route::get('/harga-paket', [HargaPaketController::class, 'index'])->name('harga-paket');
        Route::get('/harga-paket/create', [HargaPaketController::class, 'create'])->name('harga-paket.create');
        Route::post('/harga-paket/store', [HargaPaketController::class, 'store'])->name('harga-paket.store');
        Route::get('/harga-paket/edit/{id}', [HargaPaketController::class, 'edit'])->name('harga-paket.edit');
        Route::put('/harga-paket/update/{id}', [HargaPaketController::class, 'update'])->name('harga-paket.update');
        Route::delete('/harga-paket/destroy/{id}', [HargaPaketController::class, 'destroy'])->name('harga-paket.destroy');
        
        // PEMBAYARAN
        Route::get('/pembayaran', [PembayaranController::class, 'index'])->name('pembayaran');
        Route::get('/pembayaran/create', [PembayaranController::class, 'create'])->name('pembayaran.create');
        Route::post('/pembayaran/store', [PembayaranController::class, 'store'])->name('pembayaran.store');
        Route::get('/pembayaran/edit/{id}', [PembayaranController::class, 'edit'])->name('pembayaran.edit');
        Route::put('/pembayaran/update/{id}', [PembayaranController::class, 'update'])->name('pembayaran.update');
        Route::delete('/pembayaran/destroy/{id}', [PembayaranController::class, 'destroy'])->name('pembayaran.destroy');
        
        // KELOLA TENTOR (FULL AKSES: TAMBAH, EDIT, HAPUS)
        Route::get('/kelola-tentor', [KelolaTentorController::class, 'index'])->name('kelola-tentor');
        Route::get('/kelola-tentor/create', [KelolaTentorController::class, 'create'])->name('kelola-tentor.create');
        Route::post('/kelola-tentor/store', [KelolaTentorController::class, 'store'])->name('kelola-tentor.store');
        Route::get('/kelola-tentor/edit/{id}', [KelolaTentorController::class, 'edit'])->name('kelola-tentor.edit');
        Route::put('/kelola-tentor/update/{id}', [KelolaTentorController::class, 'update'])->name('kelola-tentor.update');
        Route::delete('/kelola-tentor/destroy/{id}', [KelolaTentorController::class, 'destroy'])->name('kelola-tentor.destroy');
        Route::patch('/kelola-tentor/toggle-status/{id}', [KelolaTentorController::class, 'toggleStatus'])->name('kelola-tentor.toggle-status');
        
        // KELOLA ADMIN
        Route::get('/kelola-admin', [KelolaAdminController::class, 'index'])->name('kelola-admin');
        Route::get('/kelola-admin/create', [KelolaAdminController::class, 'create'])->name('kelola-admin.create');
        Route::post('/kelola-admin/store', [KelolaAdminController::class, 'store'])->name('kelola-admin.store');
        Route::get('/kelola-admin/edit/{id}', [KelolaAdminController::class, 'edit'])->name('kelola-admin.edit');
        Route::put('/kelola-admin/update/{id}', [KelolaAdminController::class, 'update'])->name('kelola-admin.update');
        Route::delete('/kelola-admin/destroy/{id}', [KelolaAdminController::class, 'destroy'])->name('kelola-admin.destroy');
        
        // LAPORAN KEUANGAN
        Route::get('/laporan-keuangan', [LaporanKeuanganController::class, 'index'])->name('laporan-keuangan');
        Route::get('/laporan-keuangan/create', [LaporanKeuanganController::class, 'create'])->name('laporan-keuangan.create');
        Route::post('/laporan-keuangan/store', [LaporanKeuanganController::class, 'store'])->name('laporan-keuangan.store');
        Route::delete('/laporan-keuangan/destroy/{id}', [LaporanKeuanganController::class, 'destroy'])->name('laporan-keuangan.destroy');
        
        // KELOLA PRESENSI (RIWAYAT PRESENSI TENTOR)
        Route::get('/kelola-presensi', [KelolaPresensiController::class, 'index'])->name('kelola-presensi');
        Route::get('/kelola-presensi/{id}', [KelolaPresensiController::class, 'show'])->name('kelola-presensi.show');
        Route::post('/kelola-presensi/{id}/verify', [KelolaPresensiController::class, 'verify'])->name('kelola-presensi.verify');
        Route::post('/kelola-presensi/{id}/unverify', [KelolaPresensiController::class, 'unverify'])->name('kelola-presensi.unverify');
        Route::delete('/kelola-presensi/{id}', [KelolaPresensiController::class, 'destroy'])->name('kelola-presensi.destroy');
        Route::get('/kelola-presensi/download/{id}', [KelolaPresensiController::class, 'downloadFoto'])->name('kelola-presensi.download');
        
        // REKAP GAJI
        Route::get('/rekap-gaji', function () {
            return view('dashboard.shared.rekap-gaji.rekap-gaji', ['role' => 'superadmin']);
        })->name('rekap-gaji');
    });
    
    // ========== ADMIN ONLY (READ ONLY, TANPA EDIT/TAMBAH/HAPUS) ==========
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        
        // KELOLA MURID
        Route::get('/kelola-murid', [MuridController::class, 'index'])->name('kelola-murid');
        Route::get('/kelola-murid/create', [MuridController::class, 'create'])->name('murid.create');
        Route::post('/kelola-murid/store', [MuridController::class, 'store'])->name('murid.store');
        Route::get('/kelola-murid/edit/{id}', [MuridController::class, 'edit'])->name('murid.edit');
        Route::put('/kelola-murid/update/{id}', [MuridController::class, 'update'])->name('murid.update');
        Route::delete('/kelola-murid/destroy/{id}', [MuridController::class, 'destroy'])->name('murid.destroy');
        
        // HARGA PAKET
        Route::get('/harga-paket', [HargaPaketController::class, 'index'])->name('harga-paket');
        Route::get('/harga-paket/create', [HargaPaketController::class, 'create'])->name('harga-paket.create');
        Route::post('/harga-paket/store', [HargaPaketController::class, 'store'])->name('harga-paket.store');
        Route::get('/harga-paket/edit/{id}', [HargaPaketController::class, 'edit'])->name('harga-paket.edit');
        Route::put('/harga-paket/update/{id}', [HargaPaketController::class, 'update'])->name('harga-paket.update');
        Route::delete('/harga-paket/destroy/{id}', [HargaPaketController::class, 'destroy'])->name('harga-paket.destroy');
        
        // PEMBAYARAN
        Route::get('/pembayaran', [PembayaranController::class, 'index'])->name('pembayaran');
        Route::get('/pembayaran/create', [PembayaranController::class, 'create'])->name('pembayaran.create');
        Route::post('/pembayaran/store', [PembayaranController::class, 'store'])->name('pembayaran.store');
        Route::get('/pembayaran/edit/{id}', [PembayaranController::class, 'edit'])->name('pembayaran.edit');
        Route::put('/pembayaran/update/{id}', [PembayaranController::class, 'update'])->name('pembayaran.update');
        Route::delete('/pembayaran/destroy/{id}', [PembayaranController::class, 'destroy'])->name('pembayaran.destroy');
        
        // DATA TENTOR (READ ONLY - TANPA EDIT, TANPA TAMBAH, TANPA HAPUS)
        Route::get('/data-tentor', [KelolaTentorController::class, 'index'])->name('data-tentor');
        
        // LAPORAN KEUANGAN
        Route::get('/laporan-keuangan', [LaporanKeuanganController::class, 'index'])->name('laporan-keuangan');
        Route::get('/laporan-keuangan/create', [LaporanKeuanganController::class, 'create'])->name('laporan-keuangan.create');
        Route::post('/laporan-keuangan/store', [LaporanKeuanganController::class, 'store'])->name('laporan-keuangan.store');
        Route::delete('/laporan-keuangan/destroy/{id}', [LaporanKeuanganController::class, 'destroy'])->name('laporan-keuangan.destroy');
        
        // KELOLA PRESENSI (RIWAYAT PRESENSI TENTOR) - ADMIN TIDAK BISA HAPUS
        Route::get('/kelola-presensi', [KelolaPresensiController::class, 'index'])->name('kelola-presensi');
        Route::get('/kelola-presensi/{id}', [KelolaPresensiController::class, 'show'])->name('kelola-presensi.show');
        Route::post('/kelola-presensi/{id}/verify', [KelolaPresensiController::class, 'verify'])->name('kelola-presensi.verify');
        Route::post('/kelola-presensi/{id}/unverify', [KelolaPresensiController::class, 'unverify'])->name('kelola-presensi.unverify');
        Route::get('/kelola-presensi/download/{id}', [KelolaPresensiController::class, 'downloadFoto'])->name('kelola-presensi.download');
        // PERHATIAN: Tidak ada route destroy untuk admin!
        
        // REKAP GAJI
        Route::get('/rekap-gaji', function () {
            return view('dashboard.shared.rekap-gaji.rekap-gaji', ['role' => 'admin']);
        })->name('rekap-gaji');
    });
    
    // ========== TENTOR ONLY ==========
    Route::middleware(['role:tentor'])->prefix('tentor')->name('tentor.')->group(function () {
        
        // PRESENSI
        Route::get('/presensi', [PresensiController::class, 'index'])->name('presensi');
        Route::post('/presensi/masuk', [PresensiController::class, 'masuk'])->name('presensi.masuk');
        Route::post('/presensi/laporan', [PresensiController::class, 'simpanLaporan'])->name('presensi.laporan');
        Route::post('/presensi/keluar', [PresensiController::class, 'keluar'])->name('presensi.keluar');
        Route::get('/presensi/cek-status', [PresensiController::class, 'cekStatus'])->name('presensi.cek-status');
        
        // RIWAYAT PRESENSI
        Route::get('/riwayat-presensi', [PresensiController::class, 'riwayat'])->name('riwayat-presensi');
    });
});

// ========== API ROUTES (Tanpa Middleware Sidebar) ==========
Route::middleware(['auth'])->group(function () {
    Route::get('/search-murid', [MuridController::class, 'search'])->name('search.murid');
    Route::get('/get-harga-paket/{id}', [MuridController::class, 'getHargaPaket'])->name('get.harga.paket');
    Route::get('/get-murid-paket/{id}', [PembayaranController::class, 'getMuridPaket'])->name('get.murid.paket');
    Route::get('/cek-status-pembayaran/{id}', [PembayaranController::class, 'cekStatusPembayaran'])->name('cek.status.pembayaran');
});