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
        
        // AMBIL DATA KEUANGAN DARI tr_transaksi & ms_transaksi
        $keuangan = $this->getDataKeuangan();
        
        $stats = [
            'total_murid' => $totalMurid,
            'total_tentor' => $totalTentor,
            'total_admin' => $totalAdmin,
            'pemasukan' => $keuangan['totalPemasukan'],
            'pengeluaran' => $keuangan['totalPengeluaran'],
            'laba_bersih' => $keuangan['labaBersih'],
        ];
        
        $chartData = [
            'months' => [],
            'incomes' => [],
            'expenses' => []
        ];
        
        $riwayatKeuangan = $keuangan['riwayat'];
        
        return view('dashboard.shared.halaman-utama.index', compact('stats', 'riwayatKeuangan', 'chartData'));
    }
    
    // Admin Dashboard
    public function admin()
    {
        $totalMurid = Murid::count();
        $totalTentor = Pegawai::where('jenis_pegawai', 'tentor')->count();
        
        // AMBIL DATA KEUANGAN DARI tr_transaksi & ms_transaksi
        $keuangan = $this->getDataKeuangan();
        
        $stats = [
            'total_murid' => $totalMurid,
            'total_tentor' => $totalTentor,
            'pemasukan' => $keuangan['totalPemasukan'],
            'pengeluaran' => $keuangan['totalPengeluaran'],
            'laba_bersih' => $keuangan['labaBersih'],
        ];
        
        $riwayatKeuangan = $keuangan['riwayat'];
        
        return view('dashboard.shared.halaman-utama.index', compact('stats', 'riwayatKeuangan'));
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
    
    // FUNGSI PRIVATE UNTUK AMBIL DATA KEUANGAN
    private function getDataKeuangan()
    {
        // 1. PEMASUKAN = Pendaftaran + Pemasukan Manual
        $pemasukanPendaftaran = Pembayaran::whereNotNull('paket_awal')
            ->whereNull('paket_selanjutnya')
            ->sum('paket_awal');
        
        $pemasukanManual = Pembayaran::whereHas('transaksiUmum', function($q) {
            $q->where('kategori', 'pemasukan');
        })->sum('total_pembayaran');
        
        $totalPemasukan = $pemasukanPendaftaran + $pemasukanManual;
        
        // 2. PENGELUARAN = Dari transaksiUmum kategori pengeluaran
        $totalPengeluaran = Pembayaran::whereHas('transaksiUmum', function($q) {
            $q->where('kategori', 'pengeluaran');
        })->sum('total_pembayaran');
        
        // 3. LABA BERSIH
        $labaBersih = $totalPemasukan - $totalPengeluaran;
        
        // 4. RIWAYAT KEUANGAN TERAKHIR (10 data)
        $riwayat = collect();
        
        // Pemasukan Pendaftaran
        $pendaftaran = Pembayaran::whereNotNull('paket_awal')
            ->whereNull('paket_selanjutnya')
            ->with('murid')
            ->orderBy('tanggal', 'desc')
            ->limit(5)
            ->get();
        
        foreach ($pendaftaran as $item) {
            $riwayat->push((object)[
                'tanggal' => $item->tanggal,
                'rincian' => 'Pendaftaran - ' . ($item->murid->nama_lengkap ?? 'Tidak Diketahui'),
                'jumlah' => $item->paket_awal ?? 100000,
                'kategori' => 'pemasukan',
            ]);
        }
        
        // Pemasukan Manual
        $manualMasuk = Pembayaran::whereHas('transaksiUmum', function($q) {
            $q->where('kategori', 'pemasukan');
        })->with('transaksiUmum')
          ->orderBy('tanggal', 'desc')
          ->limit(5)
          ->get();
        
        foreach ($manualMasuk as $item) {
            $riwayat->push((object)[
                'tanggal' => $item->tanggal,
                'rincian' => $item->transaksiUmum->keterangan ?? 'Pemasukan Manual',
                'jumlah' => $item->total_pembayaran ?? 0,
                'kategori' => 'pemasukan',
            ]);
        }
        
        // Pengeluaran
        $pengeluaran = Pembayaran::whereHas('transaksiUmum', function($q) {
            $q->where('kategori', 'pengeluaran');
        })->with('transaksiUmum')
          ->orderBy('tanggal', 'desc')
          ->limit(5)
          ->get();
        
        foreach ($pengeluaran as $item) {
            $riwayat->push((object)[
                'tanggal' => $item->tanggal,
                'rincian' => $item->transaksiUmum->keterangan ?? 'Pengeluaran',
                'jumlah' => $item->total_pembayaran ?? 0,
                'kategori' => 'pengeluaran',
            ]);
        }
        
        // Piutang (Tunggakan)
        $piutang = Pembayaran::whereNotNull('paket_selanjutnya')
            ->where('status_tagihan', 'tunggak')
            ->with('murid')
            ->orderBy('tanggal', 'desc')
            ->limit(5)
            ->get();
        
        foreach ($piutang as $item) {
            $bulanPeriode = $item->bulan_dibayar 
                ? Carbon::create()->month($item->bulan_dibayar)->translatedFormat('F') . ' ' . $item->tahun_dibayar
                : '-';
            $riwayat->push((object)[
                'tanggal' => $item->tanggal,
                'rincian' => 'Piutang - ' . ($item->murid->nama_lengkap ?? 'Tidak Diketahui') . ' (' . $bulanPeriode . ')',
                'jumlah' => $item->total_piutang ?? 0,
                'kategori' => 'piutang',
            ]);
        }
        
        // Uang Muka
        $uangMuka = Pembayaran::whereNotNull('paket_selanjutnya')
            ->where('status_tagihan', 'uang_muka')
            ->with('murid')
            ->orderBy('tanggal', 'desc')
            ->limit(5)
            ->get();
        
        foreach ($uangMuka as $item) {
            $bulanPeriode = $item->bulan_dibayar 
                ? Carbon::create()->month($item->bulan_dibayar)->translatedFormat('F') . ' ' . $item->tahun_dibayar
                : '-';
            $riwayat->push((object)[
                'tanggal' => $item->tanggal,
                'rincian' => 'Uang Muka - ' . ($item->murid->nama_lengkap ?? 'Tidak Diketahui') . ' (' . $bulanPeriode . ')',
                'jumlah' => $item->total_uang_muka ?? 0,
                'kategori' => 'uang_muka',
            ]);
        }
        
        // Sortir dan ambil 10 terbaru
        $riwayat = $riwayat->sortByDesc('tanggal')->take(10)->values();
        
        return [
            'totalPemasukan' => $totalPemasukan,
            'totalPengeluaran' => $totalPengeluaran,
            'labaBersih' => $labaBersih,
            'riwayat' => $riwayat,
        ];
    }
}