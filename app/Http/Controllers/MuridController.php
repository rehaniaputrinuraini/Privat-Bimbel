<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MuridController extends Controller
{
    public function index()
    {
        // Data Dummy Murid
        $murids = [
            (object)[
                'id_murid' => 1, 'nama_lengkap_murid' => 'Rizky Pratama', 'kelas' => '12 SMA',
                'asal_sekolah' => 'SMAN 1 Madiun', 'no_hp_murid' => '0812345678', 'nama_orang_tua' => 'Bambang',
                'no_hp_orang_tua' => '0812999000', 'paket_awal' => 'Reguler', 'pilihan_paket' => 'Matematika', 'tahun_masuk' => '2023'
            ],
            (object)[
                'id_murid' => 2, 'nama_lengkap_murid' => 'Aisyah Putri', 'kelas' => '9 SMP',
                'asal_sekolah' => 'SMPN 2 Madiun', 'no_hp_murid' => '0856777888', 'nama_orang_tua' => 'Agus',
                'no_hp_orang_tua' => '0856111222', 'paket_awal' => 'Intensif', 'pilihan_paket' => 'IPA Terpadu', 'tahun_masuk' => '2024'
            ],
        ];

        // Data untuk Dropdown Filter
        $filter_kelas = ['7 SMP', '8 SMP', '9 SMP', '10 SMA', '11 SMA', '12 SMA'];
        $filter_tahun = ['2023', '2024', '2025'];

        return view('dashboard.admin.kelola-murid', compact('murids', 'filter_kelas', 'filter_tahun'));
    }

    public function create()
    {
        return view('dashboard.admin.create-murid');
    }
}