<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pegawai;
use App\Models\Mengajar;  // ✅ GANTI PresensiTentor → Mengajar
use App\Models\Murid;
use Carbon\Carbon;

class DashboardController extends Controller
{
    // Superadmin Dashboard
    public function superadmin()
    {
        $totalMurid = Murid::count();
        $totalTentor = Pegawai::where('jenis_pegawai', 'tentor')->count();
        $totalAdmin = Pegawai::where('jenis_pegawai', 'admin')->count();
        
        $stats = [
            'total_murid' => $totalMurid,
            'total_tentor' => $totalTentor,
            'total_admin' => $totalAdmin,
            'pemasukan' => 0,
            'pengeluaran' => 0,
            'laba_bersih' => 0,
        ];
        
        $chartData = [
            'months' => [],
            'incomes' => [],
            'expenses' => []
        ];
        
        $riwayatKeuangan = collect([]);
        
        return view('dashboard.shared.halaman-utama.index', compact('stats', 'riwayatKeuangan', 'chartData'));
    }
    
    // Admin Dashboard
    public function admin()
    {
        $totalMurid = Murid::count();
        $totalTentor = Pegawai::where('jenis_pegawai', 'tentor')->count();
        
        $stats = [
            'total_murid' => $totalMurid,
            'total_tentor' => $totalTentor,
            'pemasukan' => 0,
            'pengeluaran' => 0,
            'laba_bersih' => 0,
        ];
        
        $riwayatKeuangan = collect([]);
        
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
        $totalHadir = Mengajar::where('id_pegawai', $pegawai->id_pegawai)  // ✅ GANTI id_tentor → id_pegawai
                                    ->whereMonth('tanggal', now()->month)
                                    ->whereYear('tanggal', now()->year)
                                    ->where('murid_hadir', 'Hadir')  // ✅ GANTI status_murid → murid_hadir
                                    ->count();
        
        // Total Jam Mengajar
        $presensiSelesai = Mengajar::where('id_pegawai', $pegawai->id_pegawai)  // ✅ GANTI
                                         ->whereNotNull('jam_selesai')  // ✅ GANTI jam_keluar → jam_selesai
                                         ->get();
        
        $totalMenit = 0;
        foreach ($presensiSelesai as $p) {
            if ($p->jam_mulai && $p->jam_selesai) {  // ✅ GANTI jam_masuk → jam_mulai
                $masuk = Carbon::parse($p->jam_mulai);
                $keluar = Carbon::parse($p->jam_selesai);
                $totalMenit += $masuk->diffInMinutes($keluar);
            }
        }
        
        $totalJam = floor($totalMenit / 60);
        $totalMenitSisa = $totalMenit % 60;
        $totalJamFormatted = $totalJam . ' Jam ' . $totalMenitSisa . ' Menit';
        
        // Cek status hari ini
        $presensiHariIni = Mengajar::where('id_pegawai', $pegawai->id_pegawai)  // ✅ GANTI
                                         ->whereDate('tanggal', today())
                                         ->first();
        
        $statusHariIni = 'belum';
        $presensiAktif = null;
        $jamMulai = null;
        $durasiBerjalan = '0 jam 0 menit';
        $menitBerjalan = 0;
        
        if ($presensiHariIni) {
            if ($presensiHariIni->jam_selesai) {  // ✅ GANTI jam_keluar → jam_selesai
                $statusHariIni = 'selesai';
            } else {
                $statusHariIni = 'sedang';
                $presensiAktif = $presensiHariIni;
                $jamMulai = Carbon::parse($presensiHariIni->jam_mulai);  // ✅ GANTI jam_masuk → jam_mulai
                
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
}