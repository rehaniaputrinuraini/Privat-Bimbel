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

// ========== LUPA PASSWORD & RESET PASSWORD ==========
Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('password.request');

Route::post('/forgot-password', function () {
    return redirect('/verify-email');
})->name('password.email');

Route::get('/verify-email', function () {
    return view('auth.verify-email');
})->name('verification.notice');

Route::post('/verify-email', function () {
    return redirect('/reset-password/123');
})->name('verification.verify');

Route::get('/reset-password/{token}', function ($token) {
    return view('auth.reset-password', ['token' => $token]);
})->name('password.reset');

Route::post('/reset-password', function () {
    return redirect('/login')->with('status', 'Password berhasil direset!');
})->name('password.update');

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');


// ========== 3. DASHBOARD UTAMA (SHARED) ==========
Route::get('/superadmin/dashboard', [DashboardController::class, 'superadmin'])->name('superadmin.dashboard');
Route::get('/admin/dashboard', [DashboardController::class, 'admin'])->name('admin.dashboard');
Route::get('/tentor/dashboard', function () {
    return view('dashboard.tentor.index', [
        'total_hadir'     => 12,
        'total_jam'       => 100,
        'status_hari_ini' => 'belum',
    ]);
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

// --- 5A. RUTE KHUSUS SUPERADMIN ---
Route::get('/superadmin/harga-paket', function () {
    return view('dashboard.shared.harga-paket.harga-paket', ['role' => 'superadmin']);
})->name('superadmin.harga-paket');

Route::get('/superadmin/harga-paket/create', function () {
    return view('dashboard.shared.harga-paket.create-paket', ['role' => 'superadmin']);
})->name('superadmin.harga-paket.create');

Route::post('/superadmin/harga-paket/store', function () {
    return redirect()->route('superadmin.harga-paket')->with('success', 'Paket berhasil ditambah');
})->name('superadmin.harga-paket.store');

Route::get('/superadmin/harga-paket/edit/{id}', function ($id) {
    return view('dashboard.shared.harga-paket.edit-paket', ['role' => 'superadmin', 'id' => $id]);
})->name('superadmin.harga-paket.edit');

Route::put('/superadmin/harga-paket/update/{id}', function ($id) {
    return redirect()->route('superadmin.harga-paket')->with('success', 'Paket berhasil diperbarui');
})->name('superadmin.harga-paket.update');

Route::delete('/superadmin/harga-paket/destroy/{id}', function ($id) {
    return redirect()->route('superadmin.harga-paket')->with('success', 'Paket berhasil dihapus');
})->name('superadmin.harga-paket.destroy');


// --- 5B. RUTE KHUSUS ADMIN ---
Route::get('/admin/harga-paket', function () {
    return view('dashboard.shared.harga-paket.harga-paket', ['role' => 'admin']);
})->name('admin.harga-paket');

Route::get('/admin/harga-paket/create', function () {
    return view('dashboard.shared.harga-paket.create-paket', ['role' => 'admin']);
})->name('admin.harga-paket.create');

Route::post('/admin/harga-paket/store', function () {
    return redirect()->route('admin.harga-paket')->with('success', 'Paket berhasil ditambah');
})->name('admin.harga-paket.store');

Route::get('/admin/harga-paket/edit/{id}', function ($id) {
    return view('dashboard.shared.harga-paket.edit-paket', ['role' => 'admin', 'id' => $id]);
})->name('admin.harga-paket.edit');

Route::put('/admin/harga-paket/update/{id}', function ($id) {
    return redirect()->route('admin.harga-paket')->with('success', 'Paket berhasil diperbarui');
})->name('admin.harga-paket.update');

Route::delete('/admin/harga-paket/destroy/{id}', function ($id) {
    return redirect()->route('admin.harga-paket')->with('success', 'Paket berhasil dihapus');
})->name('admin.harga-paket.destroy');


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

// --- SUPERADMIN KELOLA TENTOR ---
Route::get('/superadmin/kelola-tentor', function () {
    return view('dashboard.superadmin.kelola-tentor.kelola-tentor', ['role' => 'superadmin']);
})->name('superadmin.kelola-tentor');

Route::get('/superadmin/kelola-tentor/create', function () {
    return view('dashboard.superadmin.kelola-tentor.create-tentor', ['role' => 'superadmin']);
})->name('superadmin.kelola-tentor.create');

Route::post('/superadmin/kelola-tentor/store', function (Request $request) {
    return redirect()->route('superadmin.kelola-tentor')->with('success', 'Akun Tentor berhasil dibuat');
})->name('superadmin.kelola-tentor.store');

Route::get('/superadmin/kelola-tentor/edit/{id}', function ($id) {
    $tentor = [
        'id' => $id,
        'nama' => 'Rati Maria',
        'alamat' => 'Madiun, Jawa Timur',
        'no_hp' => '0881999999',
        'mapel' => 'Matematika',
        'grade' => 'A',
        'hr_sd' => '50.000',
        'hr_smp' => '50.000',
        'hr_sma' => '50.000',
        'uang_makan' => '10.000',
        'uang_transport' => '10.000',
        'email' => 'rati@email.com',
        'username' => 'rati_maria',
        'status_akun' => 'Aktif',
        'status_gaji' => 'Sudah',
    ];
    return view('dashboard.superadmin.kelola-tentor.edit-tentor', ['tentor' => $tentor, 'role' => 'superadmin']);
})->name('superadmin.kelola-tentor.edit');

Route::put('/superadmin/kelola-tentor/update/{id}', function ($id) {
    return redirect()->route('superadmin.kelola-tentor')->with('success', 'Data tentor berhasil diperbarui');
})->name('superadmin.kelola-tentor.update');

Route::delete('/superadmin/kelola-tentor/destroy/{id}', function ($id) {
    return redirect()->route('superadmin.kelola-tentor')->with('success', 'Data tentor berhasil dihapus');
})->name('superadmin.kelola-tentor.destroy');

// --- ADMIN DATA TENTOR ---
Route::get('/admin/data-tentor', function () {
    return view('dashboard.admin.kelola-tentor.kelola-tentor', ['role' => 'admin']);
})->name('admin.data-tentor');

Route::get('/admin/data-tentor/create', function () {
    return view('dashboard.admin.kelola-tentor.create-tentor', ['role' => 'admin']);
})->name('admin.data-tentor.create');

Route::post('/admin/data-tentor/store', function (Request $request) {
    return redirect()->route('admin.data-tentor')->with('success', 'Data tentor berhasil ditambahkan');
})->name('admin.data-tentor.store');

Route::get('/admin/data-tentor/edit/{id}', function ($id) {
    $tentor = [
        'id' => $id,
        'nama' => 'Rati Maria',
        'alamat' => 'Madiun, Jawa Timur',
        'no_hp' => '0881999999',
        'mapel' => 'Matematika',
        'grade' => 'A',
        'hr_sd' => '50.000',
        'hr_smp' => '50.000',
        'hr_sma' => '50.000',
        'uang_makan' => '10.000',
        'uang_transport' => '10.000',
    ];
    return view('dashboard.admin.kelola-tentor.edit-tentor', ['tentor' => $tentor, 'role' => 'admin']);
})->name('admin.data-tentor.edit');

Route::put('/admin/data-tentor/update/{id}', function ($id) {
    return redirect()->route('admin.data-tentor')->with('success', 'Data tentor berhasil diperbarui');
})->name('admin.data-tentor.update');

Route::delete('/admin/data-tentor/destroy/{id}', function ($id) {
    return redirect()->route('admin.data-tentor')->with('success', 'Data tentor berhasil dihapus');
})->name('admin.data-tentor.destroy');


// ========== 9. KHUSUS KELOLA ADMIN (SUPERADMIN ONLY) ==========
Route::get('/superadmin/kelola-admin', function () {
    return view('dashboard.superadmin.kelola-admin.kelola-admin', ['role' => 'superadmin']);
})->name('superadmin.kelola-admin');

Route::get('/superadmin/kelola-admin/create', function () {
    return view('dashboard.superadmin.kelola-admin.create-admin', ['role' => 'superadmin']);
})->name('superadmin.kelola-admin.create');

Route::post('/superadmin/kelola-admin/store', function (Request $request) {
    return redirect()->route('superadmin.kelola-admin')->with('success', 'Admin berhasil ditambah');
})->name('superadmin.kelola-admin.store');

Route::get('/superadmin/kelola-admin/edit/{id}', function ($id) {
    $admin = [
        'id' => $id,
        'nama' => 'Wella',
        'alamat' => 'Madiun, Jawa Timur',
        'no_hp' => '08812345678',
        'gaji' => '1.200.000',
        'email' => 'wella@email.com',
        'username' => 'wella_adm',
    ];
    return view('dashboard.superadmin.kelola-admin.edit-admin', ['admin' => $admin, 'role' => 'superadmin']);
})->name('superadmin.kelola-admin.edit');

Route::put('/superadmin/kelola-admin/update/{id}', function ($id) {
    return redirect()->route('superadmin.kelola-admin')->with('success', 'Admin berhasil diperbarui');
})->name('superadmin.kelola-admin.update');

Route::delete('/superadmin/kelola-admin/destroy/{id}', function ($id) {
    return redirect()->route('superadmin.kelola-admin')->with('success', 'Admin berhasil dihapus');
})->name('superadmin.kelola-admin.destroy');


// ========== 10. FITUR LAPORAN KEUANGAN (SHARED ADMIN & SUPERADMIN) ==========
Route::get('/superadmin/laporan-keuangan', function () {
    return view('dashboard.shared.laporan-keuangan.laporan-keuangan', ['role' => 'superadmin']);
})->name('superadmin.laporan-keuangan');

Route::get('/superadmin/laporan-keuangan/create', function () {
    return view('dashboard.shared.laporan-keuangan.create-laporan-keuangan', ['role' => 'superadmin']);
})->name('superadmin.laporan-keuangan.create');

Route::post('/superadmin/laporan-keuangan/store', function () {
    return redirect()->route('superadmin.laporan-keuangan')->with('success', 'Data keuangan berhasil disimpan');
})->name('superadmin.laporan-keuangan.store');

Route::get('/admin/laporan-keuangan', function () {
    return view('dashboard.shared.laporan-keuangan.laporan-keuangan', ['role' => 'admin']);
})->name('admin.laporan-keuangan');

Route::get('/admin/laporan-keuangan/create', function () {
    return view('dashboard.shared.laporan-keuangan.create-laporan-keuangan', ['role' => 'admin']);
})->name('admin.laporan-keuangan.create');

Route::post('/admin/laporan-keuangan/store', function () {
    return redirect()->route('admin.laporan-keuangan')->with('success', 'Data keuangan berhasil disimpan');
})->name('admin.laporan-keuangan.store');


// ========== 11. FITUR RIWAYAT PRESENSI (SUPERADMIN & ADMIN) ==========
Route::get('/superadmin/riwayat-presensi', function () {
    return view('dashboard.shared.riwayat-presensi.riwayat-presensi', ['role' => 'superadmin']);
})->name('superadmin.riwayat-presensi');

Route::get('/admin/riwayat-presensi', function () {
    return view('dashboard.shared.riwayat-presensi.riwayat-presensi', ['role' => 'admin']);
})->name('admin.riwayat-presensi');


// ========== 12. KHUSUS TENTOR ==========
Route::get('/tentor/presensi', function () {
    return view('dashboard.tentor.presensi');
})->name('tentor.presensi');

Route::post('/tentor/presensi/masuk', function (Request $request) {
    return redirect()->route('tentor.presensi')->with('success', 'Berhasil melakukan presensi masuk!');
})->name('tentor.presensi.masuk');

Route::get('/tentor/riwayat-presensi', function () {
    return view('dashboard.tentor.riwayat-presensi');
})->name('tentor.riwayat-presensi');


// ========== 13. REKAP GAJI (SHARED ADMIN & SUPERADMIN) ==========
Route::get('/superadmin/rekap-gaji', function () {
    return view('dashboard.shared.rekap-gaji.rekap-gaji', ['role' => 'superadmin']);
})->name('superadmin.rekap-gaji');

Route::get('/admin/rekap-gaji', function () {
    return view('dashboard.shared.rekap-gaji.rekap-gaji', ['role' => 'admin']);
})->name('admin.rekap-gaji');


// ========== 14. COMPANY PROFILE ==========
Route::get('/companyprofile', function () {
    return view('companyprofile.landing');
})->name('companyprofile');