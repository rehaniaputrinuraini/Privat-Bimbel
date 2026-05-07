<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\MuridController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\MasterDataController;
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
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);
        
        $loginType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $user = \App\Models\User::where($loginType, $request->login)->first();
        
        if ($user && \Hash::check($request->password, $user->password) && $user->status == 1) {
            Auth::login($user, $request->filled('remember'));
            $request->session()->regenerate();
            return redirect()->route($user->peran . '.dashboard');
        }
        
        return back()->withErrors(['login' => 'Email/Username atau password salah.'])->withInput();
    })->name('login.post');
    
    Route::get('/register', function () {
        return view('auth.register');
    })->name('register');
});

// Logout
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
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
    
    // ========== PROFIL ==========

    Route::get('/profil', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profil/edit', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profil/update', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profil/ubah-password', function () {
        return view('dashboard.shared.profil.ubah_password');
            })->name('password.edit');
    Route::put('/profil/password-update', [App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('password.update.profile');
    
    // ========== SUPERADMIN ONLY ==========
    Route::middleware(['role:superadmin'])->prefix('superadmin')->name('superadmin.')->group(function () {
        
        // KELOLA MURID
        Route::get('/kelola-murid', [MuridController::class, 'index'])->name('kelola-murid');
        Route::get('/kelola-murid/create', [MuridController::class, 'create'])->name('murid.create');
        Route::post('/kelola-murid/store', [MuridController::class, 'store'])->name('murid.store');
        Route::get('/kelola-murid/edit/{id}', [MuridController::class, 'edit'])->name('murid.edit');
        Route::put('/kelola-murid/update/{id}', [MuridController::class, 'update'])->name('murid.update');
        Route::delete('/kelola-murid/destroy/{id}', [MuridController::class, 'destroy'])->name('murid.destroy');
        
        // LANJUT PERIODE
        Route::get('/kelola-murid/lanjut-periode/{id}', [MuridController::class, 'lanjutPeriodeForm'])->name('murid.lanjut-periode-form');
        Route::post('/kelola-murid/lanjut-periode', [MuridController::class, 'lanjutPeriode'])->name('murid.lanjut-periode');
        
        // ========== MASTER DATA (SUB MENU) ==========
        
        // Master Data - Harga Paket
        Route::get('/master-data/harga-paket', [MasterDataController::class, 'indexPaket'])->name('master-data.harga-paket');
        Route::get('/master-data/harga-paket/create', [MasterDataController::class, 'createPaket'])->name('master-data.harga-paket.create');
        Route::post('/master-data/harga-paket/store', [MasterDataController::class, 'storePaket'])->name('master-data.harga-paket.store');
        Route::get('/master-data/harga-paket/edit/{id}', [MasterDataController::class, 'editPaket'])->name('master-data.harga-paket.edit');
        Route::put('/master-data/harga-paket/update/{id}', [MasterDataController::class, 'updatePaket'])->name('master-data.harga-paket.update');
        Route::delete('/master-data/harga-paket/destroy/{id}', [MasterDataController::class, 'destroyPaket'])->name('master-data.harga-paket.destroy');
        
        // Master Data - Kelas
        Route::get('/master-data/kelas', [MasterDataController::class, 'indexKelas'])->name('master-data.kelas');
        Route::get('/master-data/kelas/create', [MasterDataController::class, 'createKelas'])->name('master-data.kelas.create');
        Route::post('/master-data/kelas/store', [MasterDataController::class, 'storeKelas'])->name('master-data.kelas.store');
        Route::get('/master-data/kelas/edit/{id}', [MasterDataController::class, 'editKelas'])->name('master-data.kelas.edit');
        Route::put('/master-data/kelas/update/{id}', [MasterDataController::class, 'updateKelas'])->name('master-data.kelas.update');
        Route::delete('/master-data/kelas/destroy/{id}', [MasterDataController::class, 'destroyKelas'])->name('master-data.kelas.destroy');
        
        // Master Data - Ruang
        Route::get('/master-data/ruang', [MasterDataController::class, 'indexRuang'])->name('master-data.ruang');
        Route::get('/master-data/ruang/create', [MasterDataController::class, 'createRuang'])->name('master-data.ruang.create');
        Route::post('/master-data/ruang/store', [MasterDataController::class, 'storeRuang'])->name('master-data.ruang.store');
        Route::get('/master-data/ruang/edit/{id}', [MasterDataController::class, 'editRuang'])->name('master-data.ruang.edit');
        Route::put('/master-data/ruang/update/{id}', [MasterDataController::class, 'updateRuang'])->name('master-data.ruang.update');
        Route::delete('/master-data/ruang/destroy/{id}', [MasterDataController::class, 'destroyRuang'])->name('master-data.ruang.destroy');
        
        // Master Data - Periode
        Route::get('/master-data/periode', [MasterDataController::class, 'indexPeriode'])->name('master-data.periode');
        Route::get('/master-data/periode/create', [MasterDataController::class, 'createPeriode'])->name('master-data.periode.create');
        Route::post('/master-data/periode/store', [MasterDataController::class, 'storePeriode'])->name('master-data.periode.store');
        Route::get('/master-data/periode/edit/{id}', [MasterDataController::class, 'editPeriode'])->name('master-data.periode.edit');
        Route::put('/master-data/periode/update/{id}', [MasterDataController::class, 'updatePeriode'])->name('master-data.periode.update');
        Route::delete('/master-data/periode/destroy/{id}', [MasterDataController::class, 'destroyPeriode'])->name('master-data.periode.destroy');

        // ========== PEMBAYARAN (SUB MENU) ==========
        Route::get('/pembayaran/tagihan', [PembayaranController::class, 'indexTagihan'])->name('pembayaran.tagihan');
        Route::get('/pembayaran/riwayat', [PembayaranController::class, 'indexRiwayat'])->name('pembayaran.riwayat');
        Route::get('/pembayaran/create', [PembayaranController::class, 'create'])->name('pembayaran.create');
        Route::post('/pembayaran/store', [PembayaranController::class, 'store'])->name('pembayaran.store');
        Route::get('/pembayaran/edit/{id}', [PembayaranController::class, 'edit'])->name('pembayaran.edit');
        Route::put('/pembayaran/update/{id}', [PembayaranController::class, 'update'])->name('pembayaran.update');
        Route::delete('/pembayaran/destroy/{id}', [PembayaranController::class, 'destroy'])->name('pembayaran.destroy');
        // TRANSAKSI PEMASUKAN
        Route::get('/transaksi/pemasukan', [PembayaranController::class, 'indexPemasukan'])->name('transaksi.pemasukan');
        
        // TRANSAKSI PENGELUARAN
        Route::get('/transaksi/pengeluaran', [PembayaranController::class, 'indexPengeluaran'])->name('transaksi.pengeluaran');
        Route::get('/pengeluaran/create', [PembayaranController::class, 'createPengeluaran'])->name('pengeluaran.create');
        Route::post('/pengeluaran/store', [PembayaranController::class, 'storePengeluaran'])->name('pengeluaran.store');

        // TRANSAKSI PENGGAJIAN
        Route::get('/transaksi/penggajian', [PembayaranController::class, 'indexPenggajian'])->name('transaksi.penggajian');
        Route::post('/penggajian/bayar/{id}', [PembayaranController::class, 'bayarGaji'])->name('penggajian.bayar');

        // KELOLA TENTOR
        Route::get('/kelola-tentor', [KelolaTentorController::class, 'index'])->name('kelola-tentor');
        Route::get('/kelola-tentor/create', [KelolaTentorController::class, 'create'])->name('kelola-tentor.create');
        Route::post('/kelola-tentor/store', [KelolaTentorController::class, 'store'])->name('kelola-tentor.store');
        Route::get('/kelola-tentor/edit/{id}', [KelolaTentorController::class, 'edit'])->name('kelola-tentor.edit');
        Route::put('/kelola-tentor/update/{id}', [KelolaTentorController::class, 'update'])->name('kelola-tentor.update');
        Route::put('/kelola-tentor/password/{id}', [KelolaTentorController::class, 'updatePassword'])->name('kelola-tentor.updatePassword');
        Route::delete('/kelola-tentor/destroy/{id}', [KelolaTentorController::class, 'destroy'])->name('kelola-tentor.destroy');
        Route::patch('/kelola-tentor/toggle-status/{id}', [KelolaTentorController::class, 'toggleStatus'])->name('kelola-tentor.toggleStatus');
        
        // KELOLA ADMIN
        Route::get('/kelola-admin', [KelolaAdminController::class, 'index'])->name('kelola-admin');
        Route::get('/kelola-admin/create', [KelolaAdminController::class, 'create'])->name('kelola-admin.create');
        Route::post('/kelola-admin/store', [KelolaAdminController::class, 'store'])->name('kelola-admin.store');
        Route::get('/kelola-admin/edit/{id}', [KelolaAdminController::class, 'edit'])->name('kelola-admin.edit');
        Route::put('/kelola-admin/update/{id}', [KelolaAdminController::class, 'update'])->name('kelola-admin.update');
        Route::put('/kelola-admin/password/{id}', [KelolaAdminController::class, 'updatePassword'])->name('kelola-admin.updatePassword');
        Route::patch('/kelola-admin/toggle-status/{id}', [KelolaAdminController::class, 'toggleStatus'])->name('kelola-admin.toggleStatus');
        Route::delete('/kelola-admin/destroy/{id}', [KelolaAdminController::class, 'destroy'])->name('kelola-admin.destroy');

        // LAPORAN KEUANGAN (3 HALAMAN)
        Route::get('/laporan-keuangan/pemasukan', [LaporanKeuanganController::class, 'pemasukan'])->name('laporan-keuangan.pemasukan');
        Route::get('/laporan-keuangan/pengeluaran', [LaporanKeuanganController::class, 'pengeluaran'])->name('laporan-keuangan.pengeluaran');
        Route::get('/laporan-keuangan/penggajian', [LaporanKeuanganController::class, 'penggajian'])->name('laporan-keuangan.penggajian');
        
        // KELOLA PRESENSI
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
    
    // ========== ADMIN ONLY ==========
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        
        // KELOLA MURID
        Route::get('/kelola-murid', [MuridController::class, 'index'])->name('kelola-murid');
        Route::get('/kelola-murid/create', [MuridController::class, 'create'])->name('murid.create');
        Route::post('/kelola-murid/store', [MuridController::class, 'store'])->name('murid.store');
        Route::get('/kelola-murid/edit/{id}', [MuridController::class, 'edit'])->name('murid.edit');
        Route::put('/kelola-murid/update/{id}', [MuridController::class, 'update'])->name('murid.update');
        Route::delete('/kelola-murid/destroy/{id}', [MuridController::class, 'destroy'])->name('murid.destroy');
        
        // LANJUT PERIODE
        Route::get('/kelola-murid/lanjut-periode/{id}', [MuridController::class, 'lanjutPeriodeForm'])->name('murid.lanjut-periode-form');
        Route::post('/kelola-murid/lanjut-periode', [MuridController::class, 'lanjutPeriode'])->name('murid.lanjut-periode');
        
        // ========== MASTER DATA (SUB MENU) ==========
        
        // Master Data - Harga Paket
        Route::get('/master-data/harga-paket', [MasterDataController::class, 'indexPaket'])->name('master-data.harga-paket');
        Route::get('/master-data/harga-paket/create', [MasterDataController::class, 'createPaket'])->name('master-data.harga-paket.create');
        Route::post('/master-data/harga-paket/store', [MasterDataController::class, 'storePaket'])->name('master-data.harga-paket.store');
        Route::get('/master-data/harga-paket/edit/{id}', [MasterDataController::class, 'editPaket'])->name('master-data.harga-paket.edit');
        Route::put('/master-data/harga-paket/update/{id}', [MasterDataController::class, 'updatePaket'])->name('master-data.harga-paket.update');
        Route::delete('/master-data/harga-paket/destroy/{id}', [MasterDataController::class, 'destroyPaket'])->name('master-data.harga-paket.destroy');
        
        // Master Data - Kelas
        Route::get('/master-data/kelas', [MasterDataController::class, 'indexKelas'])->name('master-data.kelas');
        Route::get('/master-data/kelas/create', [MasterDataController::class, 'createKelas'])->name('master-data.kelas.create');
        Route::post('/master-data/kelas/store', [MasterDataController::class, 'storeKelas'])->name('master-data.kelas.store');
        Route::get('/master-data/kelas/edit/{id}', [MasterDataController::class, 'editKelas'])->name('master-data.kelas.edit');
        Route::put('/master-data/kelas/update/{id}', [MasterDataController::class, 'updateKelas'])->name('master-data.kelas.update');
        Route::delete('/master-data/kelas/destroy/{id}', [MasterDataController::class, 'destroyKelas'])->name('master-data.kelas.destroy');
        
        // Master Data - Ruang
        Route::get('/master-data/ruang', [MasterDataController::class, 'indexRuang'])->name('master-data.ruang');
        Route::get('/master-data/ruang/create', [MasterDataController::class, 'createRuang'])->name('master-data.ruang.create');
        Route::post('/master-data/ruang/store', [MasterDataController::class, 'storeRuang'])->name('master-data.ruang.store');
        Route::get('/master-data/ruang/edit/{id}', [MasterDataController::class, 'editRuang'])->name('master-data.ruang.edit');
        Route::put('/master-data/ruang/update/{id}', [MasterDataController::class, 'updateRuang'])->name('master-data.ruang.update');
        Route::delete('/master-data/ruang/destroy/{id}', [MasterDataController::class, 'destroyRuang'])->name('master-data.ruang.destroy');
        
        // Master Data - Periode
        Route::get('/master-data/periode', [MasterDataController::class, 'indexPeriode'])->name('master-data.periode');
        Route::get('/master-data/periode/create', [MasterDataController::class, 'createPeriode'])->name('master-data.periode.create');
        Route::post('/master-data/periode/store', [MasterDataController::class, 'storePeriode'])->name('master-data.periode.store');
        Route::get('/master-data/periode/edit/{id}', [MasterDataController::class, 'editPeriode'])->name('master-data.periode.edit');
        Route::put('/master-data/periode/update/{id}', [MasterDataController::class, 'updatePeriode'])->name('master-data.periode.update');
        Route::delete('/master-data/periode/destroy/{id}', [MasterDataController::class, 'destroyPeriode'])->name('master-data.periode.destroy');
        
        // ========== PEMBAYARAN (SUB MENU) ==========
        Route::get('/pembayaran/tagihan', [PembayaranController::class, 'indexTagihan'])->name('pembayaran.tagihan');
        Route::get('/pembayaran/riwayat', [PembayaranController::class, 'indexRiwayat'])->name('pembayaran.riwayat');
        Route::get('/pembayaran/create', [PembayaranController::class, 'create'])->name('pembayaran.create');
        Route::post('/pembayaran/store', [PembayaranController::class, 'store'])->name('pembayaran.store');
        Route::get('/pembayaran/edit/{id}', [PembayaranController::class, 'edit'])->name('pembayaran.edit');
        Route::put('/pembayaran/update/{id}', [PembayaranController::class, 'update'])->name('pembayaran.update');
        Route::delete('/pembayaran/destroy/{id}', [PembayaranController::class, 'destroy'])->name('pembayaran.destroy');
        // TRANSAKSI PEMASUKAN
        Route::get('/transaksi/pemasukan', [PembayaranController::class, 'indexPemasukan'])->name('transaksi.pemasukan');
        
        // TRANSAKSI PENGELUARAN
        Route::get('/transaksi/pengeluaran', [PembayaranController::class, 'indexPengeluaran'])->name('transaksi.pengeluaran');
        Route::get('/pengeluaran/create', [PembayaranController::class, 'createPengeluaran'])->name('pengeluaran.create');
        Route::post('/pengeluaran/store', [PembayaranController::class, 'storePengeluaran'])->name('pengeluaran.store');

        // TRANSAKSI PENGGAJIAN
        Route::get('/transaksi/penggajian', [PembayaranController::class, 'indexPenggajian'])->name('transaksi.penggajian');
        Route::post('/penggajian/bayar/{id}', [PembayaranController::class, 'bayarGaji'])->name('penggajian.bayar');

        // DATA TENTOR
        Route::get('/data-tentor', [KelolaTentorController::class, 'index'])->name('data-tentor');
        
        // LAPORAN KEUANGAN (3 HALAMAN)
        Route::get('/laporan-keuangan/pemasukan', [LaporanKeuanganController::class, 'pemasukan'])->name('laporan-keuangan.pemasukan');
        Route::get('/laporan-keuangan/pengeluaran', [LaporanKeuanganController::class, 'pengeluaran'])->name('laporan-keuangan.pengeluaran');
        Route::get('/laporan-keuangan/penggajian', [LaporanKeuanganController::class, 'penggajian'])->name('laporan-keuangan.penggajian');
        
        // KELOLA PRESENSI
        Route::get('/kelola-presensi', [KelolaPresensiController::class, 'index'])->name('kelola-presensi');
        Route::get('/kelola-presensi/{id}', [KelolaPresensiController::class, 'show'])->name('kelola-presensi.show');
        Route::post('/kelola-presensi/{id}/verify', [KelolaPresensiController::class, 'verify'])->name('kelola-presensi.verify');
        Route::post('/kelola-presensi/{id}/unverify', [KelolaPresensiController::class, 'unverify'])->name('kelola-presensi.unverify');
        Route::delete('/kelola-presensi/{id}', [KelolaPresensiController::class, 'destroy'])->name('kelola-presensi.destroy');
        Route::get('/kelola-presensi/download/{id}', [KelolaPresensiController::class, 'downloadFoto'])->name('kelola-presensi.download');
        
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

// ========== API ROUTES ==========
Route::middleware(['auth'])->group(function () {
    Route::get('/search-murid', [MuridController::class, 'search'])->name('search.murid');
    Route::get('/get-harga-paket/{id}', [MuridController::class, 'getHargaPaket'])->name('get.harga.paket');
    Route::get('/get-murid-paket/{id}', [PembayaranController::class, 'getMuridPaket'])->name('get.murid.paket');
    Route::get('/cek-status-pembayaran/{id}', [PembayaranController::class, 'cekStatusPembayaran'])->name('cek.status.pembayaran');
});