<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\MuridController;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [LandingPageController::class, 'index'])->name('landing');

// ========== ROUTE LOGIN (SUGGUHAN) ==========
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function (Request $request) {
    $credentials = $request->only('email', 'password');
    
    if (Auth::attempt($credentials)) {
        $user = Auth::user();
        
        if ($user->peran == 'tentor') {
            return redirect('/dashboard/tentor');
        } elseif ($user->peran == 'admin') {
            return redirect('/dashboard/admin');
        } elseif ($user->peran == 'superadmin') {
            return redirect('/dashboard/superadmin');
        }
        
        return redirect('/dashboard');
    }
    
    return back()->withErrors(['email' => 'Email atau password salah.']);
})->name('login.post');

// ========== ROUTE REGISTER ==========
Route::get('/register', function () {
    return view('auth.register');
})->name('register');

// ========== ROUTE LUPA PASSWORD ==========
Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('password.request');

Route::post('/forgot-password', function () {
    return redirect('/verify-email');
})->name('password.email');

// ========== ROUTE VERIFIKASI EMAIL ==========
Route::get('/verify-email', function () {
    return view('auth.verify-email');
})->name('verification.notice');

Route::post('/verify-email', function () {
    return redirect('/reset-password/123');
})->name('verification.verify');

// ========== ROUTE RESET PASSWORD ==========
Route::get('/reset-password/{token}', function ($token) {
    return view('auth.reset-password', ['token' => $token]);
})->name('password.reset');

Route::post('/reset-password', function () {
    return redirect('/login')->with('status', 'Password berhasil direset!');
})->name('password.update');

// ========== ROUTE DASHBOARD UTAMA ==========
Route::get('/dashboard/tentor', function () {
    return view('dashboard.tentor.index');
})->name('tentor.dashboard');

Route::get('/dashboard/admin', function () {
    return view('dashboard.admin.index');
})->name('dashboard.admin');

Route::get('/dashboard/superadmin', function () {
    return view('dashboard.superadmin.index');
})->name('superadmin.dashboard');

// ========== ROUTE SUPERADMIN ==========
Route::get('/superadmin/kelola-admin', function () {
    return view('dashboard.superadmin.kelola-admin');
})->name('superadmin.kelola-admin');

Route::get('/superadmin/kelola-tentor', function () {
    return view('dashboard.superadmin.kelola-tentor');
})->name('superadmin.kelola-tentor');

Route::get('/superadmin/kelola-murid', [MuridController::class, 'index'])->name('superadmin.kelola-murid');
Route::get('/superadmin/kelola-murid/create', [MuridController::class, 'create'])->name('superadmin.murid.create');
Route::get('/superadmin/kelola-murid/edit/{id}', [MuridController::class, 'edit'])->name('superadmin.murid.edit');

Route::get('/superadmin/harga-paket', function () {
    return view('dashboard.superadmin.harga-paket');
})->name('superadmin.harga-paket');

Route::get('/superadmin/riwayat-presensi', function () {
    return view('dashboard.superadmin.riwayat-presensi');
})->name('superadmin.riwayat-presensi');

Route::get('/superadmin/pembayaran', function () {
    return view('dashboard.superadmin.pembayaran');
})->name('superadmin.pembayaran');

Route::get('/superadmin/rekap-gaji', function () {
    return view('dashboard.superadmin.rekap-gaji');
})->name('superadmin.rekap-gaji');

Route::get('/superadmin/laporan-keuangan', function () {
    return view('dashboard.superadmin.laporan-keuangan');
})->name('superadmin.laporan-keuangan');

// ========== ROUTE ADMIN ==========
Route::get('/admin/data-tentor', function () {
    return view('dashboard.admin.data-tentor');
})->name('admin.data-tentor');

Route::get('/admin/kelola-murid', [MuridController::class, 'index'])->name('admin.kelola-murid');
Route::get('/admin/kelola-murid/create', [MuridController::class, 'create'])->name('admin.murid.create');
Route::get('/admin/kelola-murid/edit/{id}', [MuridController::class, 'edit'])->name('admin.murid.edit');

Route::get('/admin/harga-paket', function () {
    return view('dashboard.admin.harga-paket');
})->name('admin.harga-paket');

Route::get('/admin/riwayat-presensi', function () {
    return view('dashboard.admin.riwayat-presensi');
})->name('admin.riwayat-presensi');

Route::get('/admin/pembayaran', function () {
    return view('dashboard.admin.pembayaran');
})->name('admin.pembayaran');

Route::get('/admin/rekap-gaji', function () {
    return view('dashboard.admin.rekap-gaji');
})->name('admin.rekap-gaji');

Route::get('/admin/laporan-keuangan', function () {
    return view('dashboard.admin.laporan-keuangan');
})->name('admin.laporan-keuangan');

// ========== ROUTE TENTOR ==========
Route::get('/tentor/presensi', function () {
    return view('dashboard.tentor.presensi');
})->name('tentor.presensi');

Route::get('/tentor/riwayat-presensi', function () {
    return view('dashboard.tentor.riwayat-presensi');
})->name('tentor.riwayat-presensi');

// ========== ROUTE COMPANY PROFILE ==========
Route::get('/companyprofile', function () {
    return view('companyprofile.landing');
})->name('companyprofile');

Route::get('/about', function () {
    return view('companyprofile.about');
})->name('about');

Route::get('/contact', function () {
    return view('companyprofile.contact');
})->name('contact');

// ========== ROUTE PROFIL ==========
Route::get('/dashboard/profil', function () {
    return view('dashboard.profil.index');
})->name('profile.index');

Route::get('/dashboard/profil/edit', function () {
    return view('dashboard.profil.edit');
})->name('profile.edit');

Route::get('/dashboard/profil/ubah-password', function () {
    return view('dashboard.profil.ubah-password');
})->name('profile.change-password');

// ========== ROUTE LOGOUT ==========
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');

// ========== ROUTE DUMMY (SEMENTARA) ==========
Route::get('/murid', function () {
    return view('murid.index');
})->name('murid.index');

Route::get('/harga-paket', function () {
    return view('harga_paket.index');
})->name('harga_paket.index');