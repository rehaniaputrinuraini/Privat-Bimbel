<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\MuridController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\ForgotPasswordController;
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
Route::get('/search-murid', [MuridController::class, 'search'])->name('search.murid');
Route::delete('/superadmin/kelola-murid/destroy/{id}', [MuridController::class, 'destroy'])->name('superadmin.murid.destroy');
Route::delete('/admin/kelola-murid/destroy/{id}', [MuridController::class, 'destroy'])->name('admin.murid.destroy');

// API untuk ambil harga paket (auto-fill paket_awal di form murid)
Route::get('/get-harga-paket/{id}', [MuridController::class, 'getHargaPaket'])->name('get.harga.paket');

// ========== 5. FITUR HARGA PAKET ==========
// SUPERADMIN
Route::get('/superadmin/harga-paket', [HargaPaketController::class, 'index'])->name('superadmin.harga-paket');
Route::get('/superadmin/harga-paket/create', [HargaPaketController::class, 'create'])->name('superadmin.harga-paket.create');
Route::post('/superadmin/harga-paket/store', [HargaPaketController::class, 'store'])->name('superadmin.harga-paket.store');
Route::get('/superadmin/harga-paket/edit/{id}', [HargaPaketController::class, 'edit'])->name('superadmin.harga-paket.edit');
Route::put('/superadmin/harga-paket/update/{id}', [HargaPaketController::class, 'update'])->name('superadmin.harga-paket.update');
Route::delete('/superadmin/harga-paket/destroy/{id}', [HargaPaketController::class, 'destroy'])->name('superadmin.harga-paket.destroy');

// ADMIN
Route::get('/admin/harga-paket', [HargaPaketController::class, 'index'])->name('admin.harga-paket');
Route::get('/admin/harga-paket/create', [HargaPaketController::class, 'create'])->name('admin.harga-paket.create');
Route::post('/admin/harga-paket/store', [HargaPaketController::class, 'store'])->name('admin.harga-paket.store');
Route::get('/admin/harga-paket/edit/{id}', [HargaPaketController::class, 'edit'])->name('admin.harga-paket.edit');
Route::put('/admin/harga-paket/update/{id}', [HargaPaketController::class, 'update'])->name('admin.harga-paket.update');
Route::delete('/admin/harga-paket/destroy/{id}', [HargaPaketController::class, 'destroy'])->name('admin.harga-paket.destroy');

// ========== 6. FITUR PEMBAYARAN ==========
// INDEX
Route::get('/superadmin/pembayaran', [PembayaranController::class, 'index'])->name('superadmin.pembayaran');
Route::get('/admin/pembayaran', [PembayaranController::class, 'index'])->name('admin.pembayaran');

// CREATE
Route::get('/superadmin/pembayaran/create', [PembayaranController::class, 'create'])->name('superadmin.pembayaran.create');
Route::get('/admin/pembayaran/create', [PembayaranController::class, 'create'])->name('admin.pembayaran.create');

// STORE
Route::post('/superadmin/pembayaran/store', [PembayaranController::class, 'store'])->name('superadmin.pembayaran.store');
Route::post('/admin/pembayaran/store', [PembayaranController::class, 'store'])->name('admin.pembayaran.store');

// API untuk auto-fill paket murid
Route::get('/get-murid-paket/{id}', [PembayaranController::class, 'getMuridPaket'])->name('get.murid.paket');

// API untuk cek status pembayaran murid (sudah bayar pendaftaran atau belum)
Route::get('/cek-status-pembayaran/{id}', [PembayaranController::class, 'cekStatusPembayaran'])->name('cek.status.pembayaran');

// EDIT
Route::get('/superadmin/pembayaran/edit/{id}', [PembayaranController::class, 'edit'])->name('superadmin.pembayaran.edit');
Route::get('/admin/pembayaran/edit/{id}', [PembayaranController::class, 'edit'])->name('admin.pembayaran.edit');

// UPDATE
Route::put('/superadmin/pembayaran/update/{id}', [PembayaranController::class, 'update'])->name('superadmin.pembayaran.update');
Route::put('/admin/pembayaran/update/{id}', [PembayaranController::class, 'update'])->name('admin.pembayaran.update');

// DELETE
Route::delete('/superadmin/pembayaran/destroy/{id}', [PembayaranController::class, 'destroy'])->name('superadmin.pembayaran.destroy');
Route::delete('/admin/pembayaran/destroy/{id}', [PembayaranController::class, 'destroy'])->name('admin.pembayaran.destroy');

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
})->name('password.update.profile');

// ========== 8. KHUSUS KELOLA TENTOR ==========
// SUPERADMIN
Route::get('/superadmin/kelola-tentor', [KelolaTentorController::class, 'index'])->name('superadmin.kelola-tentor');
Route::get('/superadmin/kelola-tentor/create', [KelolaTentorController::class, 'create'])->name('superadmin.kelola-tentor.create');
Route::post('/superadmin/kelola-tentor/store', [KelolaTentorController::class, 'store'])->name('superadmin.kelola-tentor.store');
Route::get('/superadmin/kelola-tentor/edit/{id}', [KelolaTentorController::class, 'edit'])->name('superadmin.kelola-tentor.edit');
Route::put('/superadmin/kelola-tentor/update/{id}', [KelolaTentorController::class, 'update'])->name('superadmin.kelola-tentor.update');
Route::delete('/superadmin/kelola-tentor/destroy/{id}', [KelolaTentorController::class, 'destroy'])->name('superadmin.kelola-tentor.destroy');
Route::patch('/superadmin/kelola-tentor/toggle-status/{id}', [KelolaTentorController::class, 'toggleStatus'])->name('superadmin.kelola-tentor.toggle-status');

// ADMIN
Route::get('/admin/data-tentor', [KelolaTentorController::class, 'index'])->name('admin.data-tentor');
Route::get('/admin/data-tentor/edit/{id}', [KelolaTentorController::class, 'edit'])->name('admin.data-tentor.edit');
Route::put('/admin/data-tentor/update/{id}', [KelolaTentorController::class, 'update'])->name('admin.data-tentor.update');
Route::delete('/admin/data-tentor/destroy/{id}', [KelolaTentorController::class, 'destroy'])->name('admin.data-tentor.destroy');

// ========== 9. KHUSUS KELOLA ADMIN (SUPERADMIN ONLY) ==========
Route::get('/superadmin/kelola-admin', [KelolaAdminController::class, 'index'])->name('superadmin.kelola-admin');
Route::get('/superadmin/kelola-admin/create', [KelolaAdminController::class, 'create'])->name('superadmin.kelola-admin.create');
Route::post('/superadmin/kelola-admin/store', [KelolaAdminController::class, 'store'])->name('superadmin.kelola-admin.store');
Route::get('/superadmin/kelola-admin/edit/{id}', [KelolaAdminController::class, 'edit'])->name('superadmin.kelola-admin.edit');
Route::put('/superadmin/kelola-admin/update/{id}', [KelolaAdminController::class, 'update'])->name('superadmin.kelola-admin.update');
Route::delete('/superadmin/kelola-admin/destroy/{id}', [KelolaAdminController::class, 'destroy'])->name('superadmin.kelola-admin.destroy');

// ========== 10. FITUR LAPORAN KEUANGAN ==========
// SUPERADMIN
Route::get('/superadmin/laporan-keuangan', [LaporanKeuanganController::class, 'index'])->name('superadmin.laporan-keuangan');
Route::get('/superadmin/laporan-keuangan/create', [LaporanKeuanganController::class, 'create'])->name('superadmin.laporan-keuangan.create');
Route::post('/superadmin/laporan-keuangan/store', [LaporanKeuanganController::class, 'store'])->name('superadmin.laporan-keuangan.store');
Route::delete('/superadmin/laporan-keuangan/destroy/{id}', [LaporanKeuanganController::class, 'destroy'])->name('superadmin.laporan-keuangan.destroy');

// ADMIN
Route::get('/admin/laporan-keuangan', [LaporanKeuanganController::class, 'index'])->name('admin.laporan-keuangan');
Route::get('/admin/laporan-keuangan/create', [LaporanKeuanganController::class, 'create'])->name('admin.laporan-keuangan.create');
Route::post('/admin/laporan-keuangan/store', [LaporanKeuanganController::class, 'store'])->name('admin.laporan-keuangan.store');
Route::delete('/admin/laporan-keuangan/destroy/{id}', [LaporanKeuanganController::class, 'destroy'])->name('admin.laporan-keuangan.destroy');

// ========== 11. FITUR RIWAYAT PRESENSI ==========
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

// ========== 13. REKAP GAJI ==========
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

// ========== 15. LUPA PASSWORD (OTP SYSTEM) ==========
Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotForm'])->name('password.request');
Route::post('/forgot-password/send', [ForgotPasswordController::class, 'sendOtp'])->name('otp.send');
Route::get('/verify-otp', [ForgotPasswordController::class, 'showVerifyForm'])->name('otp.verify');
Route::post('/verify-otp', [ForgotPasswordController::class, 'verifyOtp'])->name('otp.check');
Route::get('/reset-password', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('password.update');