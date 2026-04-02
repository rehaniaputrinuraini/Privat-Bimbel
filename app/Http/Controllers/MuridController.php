<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MuridController extends Controller
{
    public function index()
    {
        $role = Auth::user()->peran;

        $murids = [
            (object)[
                'id_murid' => 1, 
                'nama_lengkap_murid' => 'Rizky Pratama', 
                'kelas' => '12 SMA',
                'asal_sekolah' => 'SMAN 1 Madiun', 
                'alamat_murid' => 'Jl. Pahlawan No. 10, Madiun',
                'no_hp_murid' => '0812345678', 
                'nama_orang_tua' => 'Bambang',
                'no_hp_orang_tua' => '0812999000', 
                'paket_awal' => '2500000', 
                'pilihan_paket' => 'SMA', 
                'tahun_masuk' => '2023'
            ],
            (object)[
                'id_murid' => 2, 
                'nama_lengkap_murid' => 'Aisyah Putri', 
                'kelas' => '9 SMP',
                'asal_sekolah' => 'SMPN 2 Madiun', 
                'alamat_murid' => 'Jl. Kartini No. 5, Madiun',
                'no_hp_murid' => '0856777888', 
                'nama_orang_tua' => 'Agus',
                'no_hp_orang_tua' => '0856111222', 
                'paket_awal' => '1800000', 
                'pilihan_paket' => 'SMP', 
                'tahun_masuk' => '2024'
            ],
        ];

        $filter_kelas = ['7 SMP', '8 SMP', '9 SMP', '10 SMA', '11 SMA', '12 SMA'];
        $filter_tahun = ['2023', '2024', '2025'];

        return view('dashboard.shared.kelola-murid.kelola-murid', compact('murids', 'filter_kelas', 'filter_tahun', 'role'));
    }

    public function create()
    {
        $role = Auth::user()->peran;
        return view('dashboard.shared.kelola-murid.create-murid', compact('role'));
    }

    // --- TAMBAHKAN FUNGSI STORE INI ---
    public function store(Request $request)
    {
        $role = Auth::user()->peran;
        
        // Logika simpan ke database nanti di sini
        // Untuk sekarang, kita redirect balik ke halaman index
        return redirect()->route($role.'.kelola-murid')->with('success', 'Data murid berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $role = Auth::user()->peran;

        $murid = (object)[
            'id_murid' => $id,
            'nama_lengkap_murid' => 'Rizky Pratama',
            'kelas' => '12 SMA',
            'asal_sekolah' => 'SMAN 1 Madiun',
            'alamat_murid' => 'Jl. Pahlawan No. 10, Madiun',
            'no_hp_murid' => '0812345678',
            'nama_orang_tua' => 'Bambang',
            'no_hp_orang_tua' => '0812999000',
            'paket_awal' => '2500000',
            'pilihan_paket' => 'SMA',
            'tahun_masuk' => '2023'
        ];

        return view('dashboard.shared.kelola-murid.edit-murid', compact('role', 'id', 'murid'));
    }

    // --- TAMBAHKAN FUNGSI UPDATE INI ---
    public function update(Request $request, $id)
    {
        $role = Auth::user()->peran;
        
        // Logika update ke database nanti di sini
        return redirect()->route($role.'.kelola-murid')->with('success', 'Data murid berhasil diperbarui!');
    }

    // --- TAMBAHKAN FUNGSI DESTROY INI ---
    public function destroy($id)
    {
        $role = Auth::user()->peran;
        return redirect()->route($role.'.kelola-murid')->with('success', 'Data murid berhasil dihapus!');
    }
}