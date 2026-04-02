<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function superadmin()
    {
        // Data sementara (dummy) untuk testing
        $stats = [
            'total_murid' => 307,
            'total_tentor' => 20,
            'pemasukan' => 500000,
            'pengeluaran' => 200000,
            'laba_bersih' => 300000,
        ];

        $keuangan = [
            ['label' => 'Pembayaran Murid SD', 'jumlah' => 5000000, 'tipe' => 'pemasukan'],
            ['label' => 'Bayar WiFi', 'jumlah' => 100000, 'tipe' => 'pengeluaran'],
            ['label' => 'Pembayaran Murid SMA', 'jumlah' => 4000000, 'tipe' => 'pemasukan'],
        ];

        return view('dashboard.shared.halaman-utama.index', [
            'role' => 'superadmin',
            'stats' => $stats,
            'keuangan' => $keuangan,
        ]);
    }

    public function admin()
    {
        // Data sementara (dummy) untuk testing
        $stats = [
            'total_murid' => 307,
            'total_tentor' => 20,
            'pemasukan' => 500000,
            'pengeluaran' => 200000,
            'laba_bersih' => 300000,
        ];

        $keuangan = [
            ['label' => 'Pembayaran Murid SD', 'jumlah' => 5000000, 'tipe' => 'pemasukan'],
            ['label' => 'Bayar WiFi', 'jumlah' => 100000, 'tipe' => 'pengeluaran'],
            ['label' => 'Pembayaran Murid SMA', 'jumlah' => 4000000, 'tipe' => 'pemasukan'],
        ];

        return view('dashboard.shared.halaman-utama.index', [
            'role' => 'admin',
            'stats' => $stats,
            'keuangan' => $keuangan,
        ]);
    }
}