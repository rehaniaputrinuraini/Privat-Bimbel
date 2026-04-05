<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Murid;
use App\Models\Tentor;
use App\Models\Pembayaran;
use App\Models\PresensiTentor;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function superadmin()
    {
        // Data dari database
        $totalMurid = Murid::count();
        $totalTentor = Tentor::count();
        
        // Hitung pemasukan dari pembayaran
        $pemasukan = Pembayaran::sum('total_pembayaran');
        
        // TODO: Hitung pengeluaran dari gaji tentor, dll (jika ada tabel pengeluaran)
        $pengeluaran = 0; // Sementara 0, nanti diisi sesuai kebutuhan
        
        $labaBersih = $pemasukan - $pengeluaran;
        
        $stats = [
            'total_murid' => $totalMurid,
            'total_tentor' => $totalTentor,
            'pemasukan' => $pemasukan,
            'pengeluaran' => $pengeluaran,
            'laba_bersih' => $labaBersih,
        ];
        
        // Data keuangan berdasarkan jenis paket
        $keuangan = [
            [
                'label' => 'Pembayaran Murid SD', 
                'jumlah' => Pembayaran::where('paket_selanjutnya', 'SD')->sum('total_pembayaran'),
                'tipe' => 'pemasukan'
            ],
            [
                'label' => 'Pembayaran Murid SMP', 
                'jumlah' => Pembayaran::where('paket_selanjutnya', 'SMP')->sum('total_pembayaran'),
                'tipe' => 'pemasukan'
            ],
            [
                'label' => 'Pembayaran Murid SMA', 
                'jumlah' => Pembayaran::where('paket_selanjutnya', 'SMA')->sum('total_pembayaran'),
                'tipe' => 'pemasukan'
            ],
        ];
        
        return view('dashboard.shared.halaman-utama.index', [
            'role' => 'superadmin',
            'stats' => $stats,
            'keuangan' => $keuangan,
        ]);
    }

    public function admin()
    {
        // Data dari database (sama seperti superadmin)
        $totalMurid = Murid::count();
        $totalTentor = Tentor::count();
        
        $pemasukan = Pembayaran::sum('total_pembayaran');
        $pengeluaran = 0; // Sementara 0
        
        $labaBersih = $pemasukan - $pengeluaran;
        
        $stats = [
            'total_murid' => $totalMurid,
            'total_tentor' => $totalTentor,
            'pemasukan' => $pemasukan,
            'pengeluaran' => $pengeluaran,
            'laba_bersih' => $labaBersih,
        ];
        
        $keuangan = [
            [
                'label' => 'Pembayaran Murid SD', 
                'jumlah' => Pembayaran::where('paket_selanjutnya', 'SD')->sum('total_pembayaran'),
                'tipe' => 'pemasukan'
            ],
            [
                'label' => 'Pembayaran Murid SMP', 
                'jumlah' => Pembayaran::where('paket_selanjutnya', 'SMP')->sum('total_pembayaran'),
                'tipe' => 'pemasukan'
            ],
            [
                'label' => 'Pembayaran Murid SMA', 
                'jumlah' => Pembayaran::where('paket_selanjutnya', 'SMA')->sum('total_pembayaran'),
                'tipe' => 'pemasukan'
            ],
        ];
        
        return view('dashboard.shared.halaman-utama.index', [
            'role' => 'admin',
            'stats' => $stats,
            'keuangan' => $keuangan,
        ]);
    }
    
    // Dashboard Tentor (ditambahkan di sini juga)
    public function tentor()
    {
        // Ambil tentor berdasarkan email yang login
        $tentor = Tentor::where('email', Auth::user()->email)->first();
        
        if (!$tentor) {
            $tentor = Tentor::where('username', Auth::user()->email)->first();
        }
        
        $tentorId = $tentor->id_tentor ?? null;
        
        // Hitung total hadir bulan ini
        $totalHadir = PresensiTentor::where('id_tentor', $tentorId)
            ->whereMonth('tanggal', date('m'))
            ->whereYear('tanggal', date('Y'))
            ->where('status', 'Hadir')
            ->count();
        
        // Hitung total jam mengajar (asumsi 1x hadir = 2 jam)
        $totalJam = $totalHadir * 2;
        
        // Cek status presensi hari ini
        $presensiHariIni = PresensiTentor::where('id_tentor', $tentorId)
            ->whereDate('tanggal', date('Y-m-d'))
            ->first();
        
        if (!$presensiHariIni) {
            $statusHariIni = 'belum';
        } elseif ($presensiHariIni->jam_keluar) {
            $statusHariIni = 'selesai';
        } else {
            $statusHariIni = 'sedang';
        }
        
        return view('dashboard.tentor.index', [
            'total_hadir' => $totalHadir,
            'total_jam' => $totalJam,
            'status_hari_ini' => $statusHariIni,
            'nama_tentor' => $tentor->nama_lengkap ?? Auth::user()->name ?? 'Tentor',
        ]);
    }
}