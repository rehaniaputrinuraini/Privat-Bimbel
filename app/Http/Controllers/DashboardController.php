<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
    
    private function getDataKeuangan()
    {
        // =============================================
        // 1. PEMASUKAN = Total debit dari ms_transaksi
        // =============================================
        $totalPemasukan = DB::table('ms_transaksi')
            ->where('debit', '>', 0)
            ->sum('debit');
        
        // =============================================
        // 2. PENGELUARAN = kredit (ms_transaksi) + jumlah (tr_transaksi)
        // =============================================
        $pengeluaranKredit = DB::table('ms_transaksi')
            ->where('kredit', '>', 0)
            ->sum('kredit');
        
        $pengeluaranGaji = DB::table('tr_transaksi')
            ->sum('jumlah');
        
        $totalPengeluaran = $pengeluaranKredit + $pengeluaranGaji;
        
        // =============================================
        // 3. LABA BERSIH
        // =============================================
        $labaBersih = $totalPemasukan - $totalPengeluaran;
        
        // =============================================
        // 4. RIWAYAT KEUANGAN (Gabungan)
        // =============================================
        $riwayat = collect();
        
        // Riwayat dari ms_transaksi (Pemasukan & Pengeluaran Umum)
        $msTransaksi = DB::table('ms_transaksi')
            ->leftJoin('ms_murid', 'ms_transaksi.id_murid', '=', 'ms_murid.id_murid')
            ->select(
                'ms_transaksi.tanggal_bayar as tanggal',
                'ms_murid.nama_lengkap as nama_murid',
                'ms_transaksi.keterangan',
                'ms_transaksi.debit',
                'ms_transaksi.kredit'
            )
            ->orderBy('ms_transaksi.tanggal_bayar', 'desc')
            ->limit(10)
            ->get();
        
        foreach ($msTransaksi as $item) {
            if ($item->debit > 0) {
                $rincian = $item->keterangan ?? 'Pemasukan';
                if ($item->nama_murid) {
                    $rincian .= ' - ' . $item->nama_murid;
                }
                $riwayat->push((object)[
                    'tanggal' => $item->tanggal,
                    'rincian' => $rincian,
                    'jumlah' => $item->debit,
                    'kategori' => 'pemasukan',
                ]);
            }
            if ($item->kredit > 0) {
                $rincian = $item->keterangan ?? 'Pengeluaran';
                if ($item->nama_murid) {
                    $rincian .= ' - ' . $item->nama_murid;
                }
                $riwayat->push((object)[
                    'tanggal' => $item->tanggal,
                    'rincian' => $rincian,
                    'jumlah' => $item->kredit,
                    'kategori' => 'pengeluaran',
                ]);
            }
        }
        
        // Riwayat dari tr_transaksi (Gaji Tutor)
        $trTransaksi = DB::table('tr_transaksi')
            ->join('ms_transaksi', 'tr_transaksi.id_transaksi', '=', 'ms_transaksi.id_transaksi')
            ->leftJoin('ms_pegawai', 'ms_transaksi.id_pegawai', '=', 'ms_pegawai.id_pegawai')
            ->select(
                'ms_transaksi.tanggal_bayar as tanggal',
                'ms_pegawai.nama_lengkap as nama_pegawai',
                'tr_transaksi.keterangan',
                'tr_transaksi.jumlah'
            )
            ->orderBy('ms_transaksi.tanggal_bayar', 'desc')
            ->limit(10)
            ->get();
        
        foreach ($trTransaksi as $item) {
            $rincian = $item->keterangan ?? 'Gaji Tutor';
            if ($item->nama_pegawai) {
                $rincian .= ' - ' . $item->nama_pegawai;
            }
            $riwayat->push((object)[
                'tanggal' => $item->tanggal ?? now()->format('Y-m-d'),
                'rincian' => $rincian,
                'jumlah' => $item->jumlah,
                'kategori' => 'pengeluaran',
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