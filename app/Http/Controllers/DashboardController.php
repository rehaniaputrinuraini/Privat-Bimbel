<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Tentor;
use App\Models\PresensiTentor;
use App\Models\Murid;
use App\Models\LaporanKeuangan;
use Carbon\Carbon;

class DashboardController extends Controller
{
    // Superadmin Dashboard (pakai view shared/halaman-utama)
    public function superadmin()
    {
        $totalMurid = Murid::count();
        $totalTentor = Tentor::count();
        
        // Pemasukan dari laporan keuangan (kategori = 'pemasukan')
        $pemasukan = LaporanKeuangan::where('kategori', 'pemasukan')->sum('jumlah');
        
        // Pengeluaran dari laporan keuangan (kategori = 'pengeluaran')
        $pengeluaran = LaporanKeuangan::where('kategori', 'pengeluaran')->sum('jumlah');
        
        $labaBersih = $pemasukan - $pengeluaran;
        
        // Data untuk chart (6 bulan terakhir)
        $chartData = $this->getChartData();
        
        // Rincian keuangan terakhir
        $riwayatKeuangan = LaporanKeuangan::orderBy('tanggal', 'desc')->limit(5)->get();
        
        // Siapkan stats untuk view shared
        $stats = [
            'total_murid' => $totalMurid,
            'total_tentor' => $totalTentor,
            'pemasukan' => $pemasukan,
            'pengeluaran' => $pengeluaran,
            'laba_bersih' => $labaBersih,
        ];
        
        // VIEW UNTUK SUPERADMIN (shared/halaman-utama)
        return view('dashboard.shared.halaman-utama.index', compact('stats', 'riwayatKeuangan', 'chartData'));
    }
    
    // Admin Dashboard (pakai view shared/halaman-utama SAMA dengan superadmin)
    public function admin()
    {
        $totalMurid = Murid::count();
        $totalTentor = Tentor::count();
        
        // Pemasukan dari laporan keuangan (kategori = 'pemasukan')
        $pemasukan = LaporanKeuangan::where('kategori', 'pemasukan')->sum('jumlah');
        
        // Pengeluaran dari laporan keuangan (kategori = 'pengeluaran')
        $pengeluaran = LaporanKeuangan::where('kategori', 'pengeluaran')->sum('jumlah');
        
        $labaBersih = $pemasukan - $pengeluaran;
        
        // Rincian keuangan terakhir
        $riwayatKeuangan = LaporanKeuangan::orderBy('tanggal', 'desc')->limit(5)->get();
        
        // Siapkan stats untuk view shared
        $stats = [
            'total_murid' => $totalMurid,
            'total_tentor' => $totalTentor,
            'pemasukan' => $pemasukan,
            'pengeluaran' => $pengeluaran,
            'laba_bersih' => $labaBersih,
        ];
        
        // VIEW UNTUK ADMIN (sama dengan superadmin)
        return view('dashboard.shared.halaman-utama.index', compact('stats', 'riwayatKeuangan'));
    }
    
    // Tentor Dashboard (pakai view tentor/index)
    public function tentor()
    {
        $tentor = Tentor::where('id_user', Auth::id())->first();
        
        if (!$tentor) {
            return view('dashboard.tentor.index', [
                'total_hadir' => 0,
                'total_jam_formatted' => '0 Jam 0 Menit',
                'total_jam_decimal' => 0,
                'total_menit' => 0,
                'status_hari_ini' => 'belum',
                'presensi_aktif' => null,
                'jam_mulai' => null,
                'durasi_berjalan' => '0 jam 0 menit',
                'menit_berjalan' => 0,
                'nama_tentor' => 'Tentor',
                'error' => 'Data tentor tidak ditemukan'
            ]);
        }
        
        // Total Hadir Bulan Ini
        $totalHadir = PresensiTentor::where('id_tentor', $tentor->id_tentor)
                                    ->whereMonth('tanggal', now()->month)
                                    ->whereYear('tanggal', now()->year)
                                    ->where('status_murid', 'hadir')
                                    ->count();
        
        // Total Jam Mengajar (akumulasi dari semua presensi yang sudah keluar)
        $presensiSelesai = PresensiTentor::where('id_tentor', $tentor->id_tentor)
                                         ->whereNotNull('jam_keluar')
                                         ->get();
        
        $totalMenit = 0;
        foreach ($presensiSelesai as $p) {
            if ($p->jam_masuk && $p->jam_keluar) {
                $masuk = Carbon::parse($p->jam_masuk);
                $keluar = Carbon::parse($p->jam_keluar);
                $totalMenit += $masuk->diffInMinutes($keluar);
            }
        }
        
        $totalJam = floor($totalMenit / 60);
        $totalMenitSisa = $totalMenit % 60;
        $totalJamFormatted = $totalJam . ' Jam ' . $totalMenitSisa . ' Menit';
        
        // Cek status hari ini
        $presensiHariIni = PresensiTentor::where('id_tentor', $tentor->id_tentor)
                                         ->whereDate('tanggal', today())
                                         ->first();
        
        $statusHariIni = 'belum';
        $presensiAktif = null;
        $jamMulai = null;
        $durasiBerjalan = '0 jam 0 menit';
        $menitBerjalan = 0;
        
        if ($presensiHariIni) {
            if ($presensiHariIni->jam_keluar) {
                $statusHariIni = 'selesai';
            } else {
                $statusHariIni = 'sedang';
                $presensiAktif = $presensiHariIni;
                $jamMulai = Carbon::parse($presensiHariIni->jam_masuk);
                
                $now = Carbon::now();
                $diffMenit = $jamMulai->diffInMinutes($now);
                $durasiBerjalan = floor($diffMenit / 60) . ' jam ' . ($diffMenit % 60) . ' menit';
                $menitBerjalan = $diffMenit;
            }
        }
        
        return view('dashboard.tentor.index', [
            'total_hadir' => $totalHadir,
            'total_jam_formatted' => $totalJamFormatted,
            'total_jam_decimal' => round($totalMenit / 60, 1),
            'total_menit' => $totalMenit,
            'status_hari_ini' => $statusHariIni,
            'presensi_aktif' => $presensiAktif,
            'jam_mulai' => $jamMulai,
            'durasi_berjalan' => $durasiBerjalan,
            'menit_berjalan' => $menitBerjalan,
            'nama_tentor' => $tentor->nama_lengkap_tentor,
            'tentor' => $tentor
        ]);
    }
    
    // Helper untuk chart data (6 bulan terakhir)
    private function getChartData()
    {
        $months = [];
        $incomes = [];
        $expenses = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $months[] = $month->translatedFormat('M Y');
            
            // Pemasukan per bulan (kategori = 'pemasukan')
            $income = LaporanKeuangan::where('kategori', 'pemasukan')
                                      ->whereMonth('tanggal', $month->month)
                                      ->whereYear('tanggal', $month->year)
                                      ->sum('jumlah');
            
            // Pengeluaran per bulan (kategori = 'pengeluaran')
            $expense = LaporanKeuangan::where('kategori', 'pengeluaran')
                                       ->whereMonth('tanggal', $month->month)
                                       ->whereYear('tanggal', $month->year)
                                       ->sum('jumlah');
            
            $incomes[] = (float) $income;
            $expenses[] = (float) $expense;
        }
        
        return [
            'months' => $months,
            'incomes' => $incomes,
            'expenses' => $expenses
        ];
    }
}