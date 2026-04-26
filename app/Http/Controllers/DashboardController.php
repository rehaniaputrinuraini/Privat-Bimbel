<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pegawai;
use App\Models\Mengajar;
use App\Models\Murid;
use App\Models\Pembayaran;
use App\Models\TransaksiUmum;
use Carbon\Carbon;

class DashboardController extends Controller
{
    // Superadmin Dashboard
    public function superadmin()
    {
        $totalMurid = Murid::count();
        $totalTentor = Pegawai::where('jenis_pegawai', 'tentor')->count();
        $totalAdmin = Pegawai::where('jenis_pegawai', 'admin')->count();
        
        // AMBIL DATA KEUANGAN DARI TRANSAKSI UMUM
        $keuangan = $this->getDataKeuangan();
        
        $stats = [
            'total_murid' => $totalMurid,
            'total_tentor' => $totalTentor,
            'total_admin' => $totalAdmin,
            'pemasukan' => $keuangan['totalPemasukan'],
            'pengeluaran' => $keuangan['totalPengeluaran'],
            'laba_bersih' => $keuangan['labaBersih'],
        ];
        
        $chartData = $this->getChartData();
        $riwayatKeuangan = $keuangan['riwayat'];
        
        return view('dashboard.shared.halaman-utama.index', compact('stats', 'riwayatKeuangan', 'chartData'));
    }
    
    // Admin Dashboard
    public function admin()
    {
        $totalMurid = Murid::count();
        $totalTentor = Pegawai::where('jenis_pegawai', 'tentor')->count();
        
        // AMBIL DATA KEUANGAN DARI TRANSAKSI UMUM
        $keuangan = $this->getDataKeuangan();
        
        $stats = [
            'total_murid' => $totalMurid,
            'total_tentor' => $totalTentor,
            'pemasukan' => $keuangan['totalPemasukan'],
            'pengeluaran' => $keuangan['totalPengeluaran'],
            'laba_bersih' => $keuangan['labaBersih'],
        ];
        
        $chartData = $this->getChartData();
        $riwayatKeuangan = $keuangan['riwayat'];
        
        return view('dashboard.shared.halaman-utama.index', compact('stats', 'riwayatKeuangan', 'chartData'));
    }
    
    // Tentor Dashboard
    public function tentor()
    {
        $user = Auth::user();
        $pegawai = Pegawai::where('id_pegawai', $user->id_pegawai)
                          ->where('jenis_pegawai', 'tentor')
                          ->first();
        
        if (!$pegawai) {
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
        $totalHadir = Mengajar::where('id_pegawai', $pegawai->id_pegawai)
                                    ->whereMonth('tanggal', now()->month)
                                    ->whereYear('tanggal', now()->year)
                                    ->where('murid_hadir', 'Hadir')
                                    ->count();
        
        // Total Jam Mengajar
        $presensiSelesai = Mengajar::where('id_pegawai', $pegawai->id_pegawai)
                                         ->whereNotNull('jam_selesai')
                                         ->get();
        
        $totalMenit = 0;
        foreach ($presensiSelesai as $p) {
            if ($p->jam_mulai && $p->jam_selesai) {
                $masuk = Carbon::parse($p->jam_mulai);
                $keluar = Carbon::parse($p->jam_selesai);
                $totalMenit += $masuk->diffInMinutes($keluar);
            }
        }
        
        $totalJam = floor($totalMenit / 60);
        $totalMenitSisa = $totalMenit % 60;
        $totalJamFormatted = $totalJam . ' Jam ' . $totalMenitSisa . ' Menit';
        
        // Cek status hari ini
        $presensiHariIni = Mengajar::where('id_pegawai', $pegawai->id_pegawai)
                                         ->whereDate('tanggal', today())
                                         ->first();
        
        $statusHariIni = 'belum';
        $presensiAktif = null;
        $jamMulai = null;
        $durasiBerjalan = '0 jam 0 menit';
        $menitBerjalan = 0;
        
        if ($presensiHariIni) {
            if ($presensiHariIni->jam_selesai) {
                $statusHariIni = 'selesai';
            } else {
                $statusHariIni = 'sedang';
                $presensiAktif = $presensiHariIni;
                $jamMulai = Carbon::parse($presensiHariIni->jam_mulai);
                
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
            'nama_tentor' => $pegawai->nama_lengkap,
            'tentor' => $pegawai
        ]);
    }
    
    // FUNGSI DATA KEUANGAN DARI TRANSAKSI UMUM
    private function getDataKeuangan()
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        
        // Total Pemasukan (debit) bulan ini
        $totalPemasukan = TransaksiUmum::whereMonth('tanggal_bayar', $currentMonth)
            ->whereYear('tanggal_bayar', $currentYear)
            ->sum('debit');
        
        // Total Pengeluaran (kredit) bulan ini
        $totalPengeluaran = TransaksiUmum::whereMonth('tanggal_bayar', $currentMonth)
            ->whereYear('tanggal_bayar', $currentYear)
            ->sum('kredit');
        
        // Laba Bersih
        $labaBersih = $totalPemasukan - $totalPengeluaran;
        
        // Riwayat 5 transaksi terbaru
        $riwayat = TransaksiUmum::with('murid')
            ->orderBy('tanggal_bayar', 'desc')
            ->orderBy('id_transaksi', 'desc')
            ->limit(3)
            ->get()
            ->map(function($item) {
                $isPemasukan = $item->debit > 0;
                
                return (object)[
                    'rincian' => $item->keterangan ?? ($isPemasukan ? 'Pemasukan' : 'Pengeluaran'),
                    'tanggal' => $item->tanggal_bayar,
                    'jumlah' => $isPemasukan ? $item->debit : $item->kredit,
                    'kategori' => $isPemasukan ? 'pemasukan' : 'pengeluaran',
                ];
            });
        
        return [
            'totalPemasukan' => $totalPemasukan,
            'totalPengeluaran' => $totalPengeluaran,
            'labaBersih' => $labaBersih,
            'riwayat' => $riwayat,
        ];
    }
    
    // FUNGSI CHART DATA
    private function getChartData()
    {
        $months = [];
        $incomes = [];
        $expenses = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $months[] = $date->translatedFormat('M');
            
            $incomes[] = TransaksiUmum::whereMonth('tanggal_bayar', $date->month)
                ->whereYear('tanggal_bayar', $date->year)
                ->sum('debit');
                
            $expenses[] = TransaksiUmum::whereMonth('tanggal_bayar', $date->month)
                ->whereYear('tanggal_bayar', $date->year)
                ->sum('kredit');
        }
        
        return [
            'months' => $months,
            'incomes' => $incomes,
            'expenses' => $expenses
        ];
    }
}