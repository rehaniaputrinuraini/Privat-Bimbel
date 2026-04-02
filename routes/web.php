<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\MuridController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [LandingPageController::class, 'index'])->name('landing');

// ========== AUTHENTICATION ==========

Route::get('/register', function () {
    return view('auth.register'); 
})->name('register');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function (Request $request) {
    $credentials = $request->only('email', 'password');
    
    if (Auth::attempt($credentials)) {
        $user = Auth::user();
        
        if ($user->peran == 'tentor') {
            return redirect()->route('tentor.dashboard');
        } elseif ($user->peran == 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->peran == 'superadmin') {
            return redirect()->route('superadmin.dashboard');
        }
        
        return redirect('/');
    }
    
    return back()->withErrors(['email' => 'Email atau password salah.']);
})->name('login.post');

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');


// ========== DASHBOARD UTAMA (SHARED) ==========
Route::get('/superadmin/dashboard', [DashboardController::class, 'superadmin'])->name('superadmin.dashboard');
Route::get('/admin/dashboard', [DashboardController::class, 'admin'])->name('admin.dashboard');
Route::get('/tentor/dashboard', function () {
    return view('dashboard.tentor.index');
})->name('tentor.dashboard');


// ========== FITUR SHARED (Admin & SuperAdmin SAMA) ==========

// 1. Kelola Murid (Lengkap dengan Store, Update, Destroy)
// --- Index & Create ---
Route::get('/superadmin/kelola-murid', [MuridController::class, 'index'])->name('superadmin.kelola-murid');
Route::get('/admin/kelola-murid', [MuridController::class, 'index'])->name('admin.kelola-murid');

Route::get('/superadmin/kelola-murid/create', [MuridController::class, 'create'])->name('superadmin.murid.create');
Route::get('/admin/kelola-murid/create', [MuridController::class, 'create'])->name('admin.murid.create');

// --- Store (Proses Simpan) ---
Route::post('/superadmin/kelola-murid/store', [MuridController::class, 'store'])->name('superadmin.murid.store');
Route::post('/admin/kelola-murid/store', [MuridController::class, 'store'])->name('admin.murid.store');

// --- Edit & Update ---
Route::get('/superadmin/kelola-murid/edit/{id}', [MuridController::class, 'edit'])->name('superadmin.murid.edit');
Route::get('/admin/kelola-murid/edit/{id}', [MuridController::class, 'edit'])->name('admin.murid.edit');

Route::put('/superadmin/kelola-murid/update/{id}', [MuridController::class, 'update'])->name('superadmin.murid.update');
Route::put('/admin/kelola-murid/update/{id}', [MuridController::class, 'update'])->name('admin.murid.update');

// --- Destroy (Hapus) ---
Route::delete('/superadmin/kelola-murid/destroy/{id}', [MuridController::class, 'destroy'])->name('superadmin.murid.destroy');
Route::delete('/admin/kelola-murid/destroy/{id}', [MuridController::class, 'destroy'])->name('admin.murid.destroy');


// 2. Harga Paket
Route::get('/superadmin/harga-paket', function () {
    return view('dashboard.shared.harga-paket.harga-paket');
})->name('superadmin.harga-paket');

Route::get('/admin/harga-paket', function () {
    return view('dashboard.shared.harga-paket.harga-paket');
})->name('admin.harga-paket');

Route::get('/superadmin/harga-paket/create', function () {
    return view('dashboard.shared.harga-paket.create-paket');
})->name('superadmin.harga-paket.create');

Route::get('/admin/harga-paket/create', function () {
    return view('dashboard.shared.harga-paket.create-paket');
})->name('admin.harga-paket.create');

// 3. Riwayat Presensi
Route::get('/superadmin/riwayat-presensi', function () {
    return view('dashboard.shared.riwayat-presensi.riwayat-presensi');
})->name('superadmin.riwayat-presensi');

Route::get('/admin/riwayat-presensi', function () {
    return view('dashboard.shared.riwayat-presensi.riwayat-presensi');
})->name('admin.riwayat-presensi');

// 4. Pembayaran
Route::get('/superadmin/pembayaran', function () {
    return view('dashboard.shared.pembayaran.pembayaran');
})->name('superadmin.pembayaran');

Route::get('/admin/pembayaran', function () {
    return view('dashboard.shared.pembayaran.pembayaran');
})->name('admin.pembayaran');

// 5. Rekap Gaji
Route::get('/superadmin/rekap-gaji', function () {
    return view('dashboard.shared.rekap-gaji.rekap-gaji');
})->name('superadmin.rekap-gaji');

Route::get('/admin/rekap-gaji', function () {
    return view('dashboard.shared.rekap-gaji.rekap-gaji');
})->name('admin.rekap-gaji');

// 6. Laporan Keuangan
Route::get('/superadmin/laporan-keuangan', function () {
    return view('dashboard.shared.laporan-keuangan.laporan-keuangan');
})->name('superadmin.laporan-keuangan');

Route::get('/admin/laporan-keuangan', function () {
    return view('dashboard.shared.laporan-keuangan.laporan-keuangan');
})->name('admin.laporan-keuangan');


// ========== KHUSUS SUPERADMIN ==========
Route::get('/superadmin/kelola-admin', function () {
    return view('dashboard.superadmin.kelola-admin.kelola-admin');
})->name('superadmin.kelola-admin');

Route::get('/superadmin/kelola-admin/create', function () {
    return view('dashboard.superadmin.kelola-admin.create-admin');
})->name('superadmin.kelola-admin.create');

Route::get('/superadmin/kelola-admin/edit/{id}', function ($id) {
    return view('dashboard.superadmin.kelola-admin.edit-admin');
})->name('superadmin.kelola-admin.edit');

Route::get('/superadmin/kelola-tentor', function () {
    return view('dashboard.superadmin.kelola-tentor.kelola-tentor');
})->name('superadmin.kelola-tentor');

Route::get('/superadmin/kelola-tentor/create', function () {
    return view('dashboard.superadmin.kelola-tentor.create-tentor');
})->name('superadmin.kelola-tentor.create');

Route::get('/superadmin/kelola-tentor/edit/{id}', function ($id) {
    return view('dashboard.superadmin.kelola-tentor.edit-tentor');
})->name('superadmin.kelola-tentor.edit');


// ========== KHUSUS ADMIN ==========
Route::get('/admin/data-tentor', function () {
    return view('dashboard.admin.kelola-tentor.kelola-tentor');
})->name('admin.data-tentor');


// ========== KHUSUS TENTOR ==========
Route::get('/tentor/presensi', function () {
    return view('dashboard.tentor.presensi');
})->name('tentor.presensi');

Route::get('/tentor/riwayat-presensi', function () {
    return view('dashboard.tentor.riwayat-presensi');
})->name('tentor.riwayat-presensi');


// ========== PROFIL (SAMA UNTUK SEMUA) ==========
Route::get('/profil', function () {
    return view('dashboard.shared.profil.index');
})->name('profile.index');

Route::get('/profil/edit', function () {
    return view('dashboard.shared.profil.edit');
})->name('profile.edit');

Route::get('/profil/ubah-password', function () {
    return view('dashboard.shared.profil.ubah');
})->name('profile.change-password');


// ========== COMPANY PROFILE ==========
Route::get('/companyprofile', function () {
    return view('companyprofile.landing');
})->name('companyprofile');

Route::get('/about', function () {
    return view('companyprofile.about');
})->name('about');

Route::get('/contact', function () {
    return view('companyprofile.contact');
})->name('contact');