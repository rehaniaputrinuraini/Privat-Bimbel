<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Murid;
use App\Models\Tentor;
use App\Models\Pembayaran;
use App\Models\PresensiTentor;
use App\Models\LaporanKeuangan;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    // Dashboard Superadmin
    public function superadmin()
    {
        // Data dari database
        $totalMurid = Murid::count();
        $totalTentor = Tentor::count();
        
        // Hitung pemasukan dari tabel laporan keuangan (tr_keuangan)
        $totalPemasukan = LaporanKeuangan::where('kategori', 'pemasukan')->sum('jumlah');
        
        // Hitung pengeluaran dari tabel laporan keuangan (tr_keuangan)
        $totalPengeluaran = LaporanKeuangan::where('kategori', 'pengeluaran')->sum('jumlah');
        
        // Laba bersih = pemasukan - pengeluaran
        $labaBersih = $totalPemasukan - $totalPengeluaran;
        
        $stats = [
            'total_murid' => $totalMurid,
            'total_tentor' => $totalTentor,
            'pemasukan' => $totalPemasukan,
            'pengeluaran' => $totalPengeluaran,
            'laba_bersih' => $labaBersih,
        ];
        
        // Ambil 5 data keuangan terakhir untuk ditampilkan di dashboard
        $riwayatKeuangan = LaporanKeuangan::orderBy('tanggal', 'desc')
            ->limit(5)
            ->get();
        
        return view('dashboard.shared.halaman-utama.index', [
            'role' => 'superadmin',
            'stats' => $stats,
            'riwayatKeuangan' => $riwayatKeuangan,
        ]);
    }

    // Dashboard Admin
    public function admin()
    {
        // Data dari database
        $totalMurid = Murid::count();
        $totalTentor = Tentor::count();
        
        // Hitung pemasukan dari tabel laporan keuangan (tr_keuangan)
        $totalPemasukan = LaporanKeuangan::where('kategori', 'pemasukan')->sum('jumlah');
        
        // Hitung pengeluaran dari tabel laporan keuangan (tr_keuangan)
        $totalPengeluaran = LaporanKeuangan::where('kategori', 'pengeluaran')->sum('jumlah');
        
        // Laba bersih = pemasukan - pengeluaran
        $labaBersih = $totalPemasukan - $totalPengeluaran;
        
        $stats = [
            'total_murid' => $totalMurid,
            'total_tentor' => $totalTentor,
            'pemasukan' => $totalPemasukan,
            'pengeluaran' => $totalPengeluaran,
            'laba_bersih' => $labaBersih,
        ];
        
        // Ambil 5 data keuangan terakhir untuk ditampilkan di dashboard
        $riwayatKeuangan = LaporanKeuangan::orderBy('tanggal', 'desc')
            ->limit(5)
            ->get();
        
        return view('dashboard.shared.halaman-utama.index', [
            'role' => 'admin',
            'stats' => $stats,
            'riwayatKeuangan' => $riwayatKeuangan,
        ]);
    }
    
    // Dashboard Tentor (TIDAK DIUBAH - tetap seperti kode Anda)
    public function tentor()
    {
        // Ambil user yang sedang login
        $user = Auth::user();
        
        // Cari tentor berdasarkan id_user (relasi)
        $tentor = Tentor::where('id_user', $user->id_user)->first();
        
        if (!$tentor) {
            // Jika belum ada data tentor, tampilkan data kosong
            return view('dashboard.tentor.index', [
                'total_hadir' => 0,
                'total_jam' => 0,
                'status_hari_ini' => 'belum',
                'nama_tentor' => $user->username,
            ]);
        }
        
        // Hitung total hadir bulan ini (status_murid = 'Hadir')
        $totalHadir = PresensiTentor::where('id_tentor', $tentor->id_tentor)
            ->whereMonth('tanggal', date('m'))
            ->whereYear('tanggal', date('Y'))
            ->where('status_murid', 'Hadir')
            ->count();
        
        // Hitung total jam mengajar (ambil dari kolom jam_mengajar)
        $totalJam = PresensiTentor::where('id_tentor', $tentor->id_tentor)
            ->whereMonth('tanggal', date('m'))
            ->whereYear('tanggal', date('Y'))
            ->sum('jam_mengajar');
        
        // Cek status presensi hari ini
        $presensiHariIni = PresensiTentor::where('id_tentor', $tentor->id_tentor)
            ->whereDate('tanggal', date('Y-m-d'))
            ->first();
        
        if (!$presensiHariIni) {
            $statusHariIni = 'belum';
        } elseif ($presensiHariIni->verifikasi_kehadiran) {
            $statusHariIni = 'selesai';
        } else {
            $statusHariIni = 'sedang';
        }
        
        return view('dashboard.tentor.index', [
            'total_hadir' => $totalHadir,
            'total_jam' => $totalJam,
            'status_hari_ini' => $statusHariIni,
            'nama_tentor' => $tentor->nama_lengkap_tentor ?? $user->username,
        ]);
    }
}