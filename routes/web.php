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

// ========== 1. LANDING PAGE ==========
Route::get('/', [LandingPageController::class, 'index'])->name('landing');

// ========== 2. AUTHENTICATION ==========
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


// ========== 3. DASHBOARD UTAMA (SHARED) ==========
Route::get('/superadmin/dashboard', [DashboardController::class, 'superadmin'])->name('superadmin.dashboard');
Route::get('/admin/dashboard', [DashboardController::class, 'admin'])->name('admin.dashboard');
Route::get('/tentor/dashboard', function () {
    return view('dashboard.tentor.index');
})->name('tentor.dashboard');


// ========== 4. FITUR KELOLA MURID ==========
Route::get('/superadmin/kelola-murid', [MuridController::class, 'index'])->name('superadmin.kelola-murid');
Route::get('/admin/kelola-murid', [MuridController::class, 'index'])->name('admin.kelola-murid');
Route::get('/superadmin/kelola-murid/create', [MuridController::class, 'create'])->name('superadmin.murid.create');
Route::get('/admin/kelola-murid/create', [MuridController::class, 'create'])->name('admin.murid.create');
Route::post('/superadmin/kelola-murid/store', [MuridController::class, 'store'])->name('superadmin.murid.store');
Route::post('/admin/kelola-murid/store', [MuridController::class, 'store'])->name('admin.murid.store');
Route::get('/superadmin/kelola-murid/edit/{id}', [MuridController::class, 'edit'])->name('superadmin.murid.edit');
Route::get('/admin/kelola-murid/edit/{id}', [MuridController::class, 'edit'])->name('admin.murid.edit');
Route::put('/superadmin/kelola-murid/update/{id}', [MuridController::class, 'update'])->name('superadmin.murid.update');
Route::put('/admin/kelola-murid/update/{id}', [MuridController::class, 'update'])->name('admin.murid.update');
Route::delete('/superadmin/kelola-murid/destroy/{id}', [MuridController::class, 'destroy'])->name('superadmin.murid.destroy');
Route::delete('/admin/kelola-murid/destroy/{id}', [MuridController::class, 'destroy'])->name('admin.murid.destroy');


// ========== 5. FITUR HARGA PAKET ==========
Route::get('/superadmin/harga-paket', function () { 
    return view('dashboard.shared.harga-paket.harga-paket', ['role' => 'superadmin']); 
})->name('superadmin.harga-paket');
Route::get('/admin/harga-paket', function () { 
    return view('dashboard.shared.harga-paket.harga-paket', ['role' => 'admin']); 
})->name('admin.harga-paket');

Route::get('/superadmin/harga-paket/create', function () {
    return view('dashboard.shared.harga-paket.create-paket', ['role' => 'superadmin']);
})->name('superadmin.harga-paket.create');
Route::get('/admin/harga-paket/create', function () {
    return view('dashboard.shared.harga-paket.create-paket', ['role' => 'admin']);
})->name('admin.harga-paket.create');

Route::post('/superadmin/harga-paket/store', function () {
    return redirect()->route('superadmin.harga-paket')->with('success', 'Paket berhasil ditambah');
})->name('superadmin.harga-paket.store');
Route::post('/admin/harga-paket/store', function () {
    return redirect()->route('admin.harga-paket')->with('success', 'Paket berhasil ditambah');
})->name('admin.harga-paket.store');


// ========== 6. FITUR PEMBAYARAN ==========
Route::get('/superadmin/pembayaran', function () {
    return view('dashboard.shared.pembayaran.pembayaran', ['role' => 'superadmin']);
})->name('superadmin.pembayaran');
Route::get('/admin/pembayaran', function () {
    return view('dashboard.shared.pembayaran.pembayaran', ['role' => 'admin']);
})->name('admin.pembayaran');

Route::get('/superadmin/pembayaran/create', function () {
    return view('dashboard.shared.pembayaran.create-pembayaran', ['role' => 'superadmin']);
})->name('superadmin.pembayaran.create');
Route::get('/admin/pembayaran/create', function () {
    return view('dashboard.shared.pembayaran.create-pembayaran', ['role' => 'admin']);
})->name('admin.pembayaran.create');

Route::post('/superadmin/pembayaran/store', function () {
    return redirect()->route('superadmin.pembayaran');
})->name('superadmin.pembayaran.store');
Route::post('/admin/pembayaran/store', function () {
    return redirect()->route('admin.pembayaran');
})->name('admin.pembayaran.store');


// ========== 7. FITUR PROFIL ==========
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
})->name('password.update');


// ========== 8. KHUSUS KELOLA TENTOR (SUPERADMIN & ADMIN) ==========
Route::get('/superadmin/kelola-tentor', function () { 
    return view('dashboard.superadmin.kelola-tentor.kelola-tentor'); 
})->name('superadmin.kelola-tentor');

Route::get('/superadmin/kelola-tentor/create', function () { 
    return view('dashboard.superadmin.kelola-tentor.create-tentor'); 
})->name('superadmin.kelola-tentor.create');

Route::post('/superadmin/kelola-tentor/store', function (Request $request) {
    return redirect()->route('superadmin.kelola-tentor')->with('success', 'Akun Tentor berhasil dibuat');
})->name('superadmin.kelola-tentor.store');

Route::get('/admin/data-tentor', function () { 
    return view('dashboard.admin.kelola-tentor.kelola-tentor'); 
})->name('admin.data-tentor');


// ========== 9. KHUSUS KELOLA ADMIN (SUPERADMIN ONLY) ==========
Route::get('/superadmin/kelola-admin', function () {
    return view('dashboard.superadmin.kelola-admin.kelola-admin');
})->name('superadmin.kelola-admin');

Route::get('/superadmin/kelola-admin/create', function () {
    return view('dashboard.superadmin.kelola-admin.create-admin');
})->name('superadmin.kelola-admin.create');

Route::post('/superadmin/kelola-admin/store', function (Request $request) {
    return redirect()->route('superadmin.kelola-admin')->with('success', 'Admin berhasil ditambah');
})->name('superadmin.kelola-admin.store');


// ========== 10. FITUR LAPORAN KEUANGAN (SHARED ADMIN & SUPERADMIN) ==========
// --- Superadmin ---
Route::get('/superadmin/laporan-keuangan', function () { 
    return view('dashboard.shared.laporan-keuangan.laporan-keuangan', ['role' => 'superadmin']); 
})->name('superadmin.laporan-keuangan');

Route::get('/superadmin/laporan-keuangan/create', function () {
    return view('dashboard.shared.laporan-keuangan.create-laporan-keuangan', ['role' => 'superadmin']);
})->name('superadmin.laporan-keuangan.create');

Route::post('/superadmin/laporan-keuangan/store', function () {
    return redirect()->route('superadmin.laporan-keuangan')->with('success', 'Data keuangan berhasil disimpan');
})->name('superadmin.laporan-keuangan.store');

// --- Admin ---
Route::get('/admin/laporan-keuangan', function () { 
    return view('dashboard.shared.laporan-keuangan.laporan-keuangan', ['role' => 'admin']); 
})->name('admin.laporan-keuangan');

Route::get('/admin/laporan-keuangan/create', function () {
    return view('dashboard.shared.laporan-keuangan.create-laporan-keuangan', ['role' => 'admin']);
})->name('admin.laporan-keuangan.create');

Route::post('/admin/laporan-keuangan/store', function () {
    return redirect()->route('admin.laporan-keuangan')->with('success', 'Data keuangan berhasil disimpan');
})->name('admin.laporan-keuangan.store');


// ========== 11. FITUR LAINNYA (RIWAYAT & REKAP) ==========
Route::get('/superadmin/riwayat-presensi', function () { 
    return view('dashboard.shared.riwayat presensi.riwayat-presensi', ['role' => 'superadmin']); 
})->name('superadmin.riwayat-presensi');
Route::get('/admin/riwayat-presensi', function () { 
    return view('dashboard.shared.riwayat presensi.riwayat-presensi', ['role' => 'admin']); 
})->name('admin.riwayat-presensi');

Route::get('/superadmin/rekap-gaji', function () { 
    return view('dashboard.shared.rekap-gaji.rekap-gaji', ['role' => 'superadmin']); 
})->name('superadmin.rekap-gaji');
Route::get('/admin/rekap-gaji', function () { 
    return view('dashboard.shared.rekap-gaji.rekap-gaji', ['role' => 'admin']); 
})->name('admin.rekap-gaji');

Route::get('/companyprofile', function () { return view('companyprofile.landing'); })->name('companyprofile');