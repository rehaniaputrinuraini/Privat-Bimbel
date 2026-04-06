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

// ========== 4. ROUTE YANG DILINDUNGI MIDDLEWARE ==========
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
    Route::middleware(['role:superadmin'])->prefix('superadmin')->group(function () {
        
        // KELOLA MURID
        Route::get('/kelola-murid', [MuridController::class, 'index'])->name('superadmin.kelola-murid');
        Route::get('/kelola-murid/create', [MuridController::class, 'create'])->name('superadmin.murid.create');
        Route::post('/kelola-murid/store', [MuridController::class, 'store'])->name('superadmin.murid.store');
        Route::get('/kelola-murid/edit/{id}', [MuridController::class, 'edit'])->name('superadmin.murid.edit');
        Route::put('/kelola-murid/update/{id}', [MuridController::class, 'update'])->name('superadmin.murid.update');
        Route::delete('/kelola-murid/destroy/{id}', [MuridController::class, 'destroy'])->name('superadmin.murid.destroy');
        
        // HARGA PAKET
        Route::get('/harga-paket', [HargaPaketController::class, 'index'])->name('superadmin.harga-paket');
        Route::get('/harga-paket/create', [HargaPaketController::class, 'create'])->name('superadmin.harga-paket.create');
        Route::post('/harga-paket/store', [HargaPaketController::class, 'store'])->name('superadmin.harga-paket.store');
        Route::get('/harga-paket/edit/{id}', [HargaPaketController::class, 'edit'])->name('superadmin.harga-paket.edit');
        Route::put('/harga-paket/update/{id}', [HargaPaketController::class, 'update'])->name('superadmin.harga-paket.update');
        Route::delete('/harga-paket/destroy/{id}', [HargaPaketController::class, 'destroy'])->name('superadmin.harga-paket.destroy');
        
        // PEMBAYARAN
        Route::get('/pembayaran', [PembayaranController::class, 'index'])->name('superadmin.pembayaran');
        Route::get('/pembayaran/create', [PembayaranController::class, 'create'])->name('superadmin.pembayaran.create');
        Route::post('/pembayaran/store', [PembayaranController::class, 'store'])->name('superadmin.pembayaran.store');
        Route::get('/pembayaran/edit/{id}', [PembayaranController::class, 'edit'])->name('superadmin.pembayaran.edit');
        Route::put('/pembayaran/update/{id}', [PembayaranController::class, 'update'])->name('superadmin.pembayaran.update');
        Route::delete('/pembayaran/destroy/{id}', [PembayaranController::class, 'destroy'])->name('superadmin.pembayaran.destroy');
        
        // KELOLA TENTOR
        Route::get('/kelola-tentor', [KelolaTentorController::class, 'index'])->name('superadmin.kelola-tentor');
        Route::get('/kelola-tentor/create', [KelolaTentorController::class, 'create'])->name('superadmin.kelola-tentor.create');
        Route::post('/kelola-tentor/store', [KelolaTentorController::class, 'store'])->name('superadmin.kelola-tentor.store');
        Route::get('/kelola-tentor/edit/{id}', [KelolaTentorController::class, 'edit'])->name('superadmin.kelola-tentor.edit');
        Route::put('/kelola-tentor/update/{id}', [KelolaTentorController::class, 'update'])->name('superadmin.kelola-tentor.update');
        Route::delete('/kelola-tentor/destroy/{id}', [KelolaTentorController::class, 'destroy'])->name('superadmin.kelola-tentor.destroy');
        Route::patch('/kelola-tentor/toggle-status/{id}', [KelolaTentorController::class, 'toggleStatus'])->name('superadmin.kelola-tentor.toggle-status');
        
        // KELOLA ADMIN
        Route::get('/kelola-admin', [KelolaAdminController::class, 'index'])->name('superadmin.kelola-admin');
        Route::get('/kelola-admin/create', [KelolaAdminController::class, 'create'])->name('superadmin.kelola-admin.create');
        Route::post('/kelola-admin/store', [KelolaAdminController::class, 'store'])->name('superadmin.kelola-admin.store');
        Route::get('/kelola-admin/edit/{id}', [KelolaAdminController::class, 'edit'])->name('superadmin.kelola-admin.edit');
        Route::put('/kelola-admin/update/{id}', [KelolaAdminController::class, 'update'])->name('superadmin.kelola-admin.update');
        Route::delete('/kelola-admin/destroy/{id}', [KelolaAdminController::class, 'destroy'])->name('superadmin.kelola-admin.destroy');
        
        // LAPORAN KEUANGAN
        Route::get('/laporan-keuangan', [LaporanKeuanganController::class, 'index'])->name('superadmin.laporan-keuangan');
        Route::get('/laporan-keuangan/create', [LaporanKeuanganController::class, 'create'])->name('superadmin.laporan-keuangan.create');
        Route::post('/laporan-keuangan/store', [LaporanKeuanganController::class, 'store'])->name('superadmin.laporan-keuangan.store');
        Route::delete('/laporan-keuangan/destroy/{id}', [LaporanKeuanganController::class, 'destroy'])->name('superadmin.laporan-keuangan.destroy');
        
        // RIWAYAT PRESENSI
        Route::get('/riwayat-presensi', function () {
            return view('dashboard.shared.riwayat presensi.riwayat-presensi', ['role' => 'superadmin']);
        })->name('superadmin.riwayat-presensi');
        
        // REKAP GAJI
        Route::get('/rekap-gaji', function () {
            return view('dashboard.shared.rekap-gaji.rekap-gaji', ['role' => 'superadmin']);
        })->name('superadmin.rekap-gaji');
    });
    
    // ========== ADMIN ONLY ==========
    Route::middleware(['role:admin'])->prefix('admin')->group(function () {
        
        // KELOLA MURID
        Route::get('/kelola-murid', [MuridController::class, 'index'])->name('admin.kelola-murid');
        Route::get('/kelola-murid/create', [MuridController::class, 'create'])->name('admin.murid.create');
        Route::post('/kelola-murid/store', [MuridController::class, 'store'])->name('admin.murid.store');
        Route::get('/kelola-murid/edit/{id}', [MuridController::class, 'edit'])->name('admin.murid.edit');
        Route::put('/kelola-murid/update/{id}', [MuridController::class, 'update'])->name('admin.murid.update');
        Route::delete('/kelola-murid/destroy/{id}', [MuridController::class, 'destroy'])->name('admin.murid.destroy');
        
        // HARGA PAKET
        Route::get('/harga-paket', [HargaPaketController::class, 'index'])->name('admin.harga-paket');
        Route::get('/harga-paket/create', [HargaPaketController::class, 'create'])->name('admin.harga-paket.create');
        Route::post('/harga-paket/store', [HargaPaketController::class, 'store'])->name('admin.harga-paket.store');
        Route::get('/harga-paket/edit/{id}', [HargaPaketController::class, 'edit'])->name('admin.harga-paket.edit');
        Route::put('/harga-paket/update/{id}', [HargaPaketController::class, 'update'])->name('admin.harga-paket.update');
        Route::delete('/harga-paket/destroy/{id}', [HargaPaketController::class, 'destroy'])->name('admin.harga-paket.destroy');
        
        // PEMBAYARAN
        Route::get('/pembayaran', [PembayaranController::class, 'index'])->name('admin.pembayaran');
        Route::get('/pembayaran/create', [PembayaranController::class, 'create'])->name('admin.pembayaran.create');
        Route::post('/pembayaran/store', [PembayaranController::class, 'store'])->name('admin.pembayaran.store');
        Route::get('/pembayaran/edit/{id}', [PembayaranController::class, 'edit'])->name('admin.pembayaran.edit');
        Route::put('/pembayaran/update/{id}', [PembayaranController::class, 'update'])->name('admin.pembayaran.update');
        Route::delete('/pembayaran/destroy/{id}', [PembayaranController::class, 'destroy'])->name('admin.pembayaran.destroy');
        
        // DATA TENTOR (Hanya Lihat & Edit)
        Route::get('/data-tentor', [KelolaTentorController::class, 'index'])->name('admin.data-tentor');
        Route::get('/data-tentor/edit/{id}', [KelolaTentorController::class, 'edit'])->name('admin.data-tentor.edit');
        Route::put('/data-tentor/update/{id}', [KelolaTentorController::class, 'update'])->name('admin.data-tentor.update');
        Route::delete('/data-tentor/destroy/{id}', [KelolaTentorController::class, 'destroy'])->name('admin.data-tentor.destroy');
        
        // LAPORAN KEUANGAN
        Route::get('/laporan-keuangan', [LaporanKeuanganController::class, 'index'])->name('admin.laporan-keuangan');
        Route::get('/laporan-keuangan/create', [LaporanKeuanganController::class, 'create'])->name('admin.laporan-keuangan.create');
        Route::post('/laporan-keuangan/store', [LaporanKeuanganController::class, 'store'])->name('admin.laporan-keuangan.store');
        Route::delete('/laporan-keuangan/destroy/{id}', [LaporanKeuanganController::class, 'destroy'])->name('admin.laporan-keuangan.destroy');
        
        // RIWAYAT PRESENSI
        Route::get('/riwayat-presensi', function () {
            return view('dashboard.shared.riwayat presensi.riwayat-presensi', ['role' => 'admin']);
        })->name('admin.riwayat-presensi');
        
        // REKAP GAJI
        Route::get('/rekap-gaji', function () {
            return view('dashboard.shared.rekap-gaji.rekap-gaji', ['role' => 'admin']);
        })->name('admin.rekap-gaji');
    });
    
    // ========== TENTOR ONLY ==========
    Route::middleware(['role:tentor'])->prefix('tentor')->group(function () {
        
        // PRESENSI
        Route::get('/presensi', function () {
            return view('dashboard.tentor.presensi');
        })->name('tentor.presensi');
        
        Route::post('/presensi/masuk', function (Request $request) {
            return redirect()->route('tentor.presensi')->with('success', 'Berhasil melakukan presensi masuk!');
        })->name('tentor.presensi.masuk');
        
        // RIWAYAT PRESENSI
        Route::get('/riwayat-presensi', function () {
            return view('dashboard.tentor.riwayat-presensi');
        })->name('tentor.riwayat-presensi');
    });
});

// ========== API ROUTES (Tanpa Middleware Sidebar) ==========
Route::middleware(['auth'])->group(function () {
    Route::get('/search-murid', [MuridController::class, 'search'])->name('search.murid');
    Route::get('/get-harga-paket/{id}', [MuridController::class, 'getHargaPaket'])->name('get.harga.paket');
    Route::get('/get-murid-paket/{id}', [PembayaranController::class, 'getMuridPaket'])->name('get.murid.paket');
    Route::get('/cek-status-pembayaran/{id}', [PembayaranController::class, 'cekStatusPembayaran'])->name('cek.status.pembayaran');
});