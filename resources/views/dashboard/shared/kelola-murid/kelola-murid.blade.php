{{-- =============================================
     Dashboard Shared - Kelola Murid (FINAL REVISI DESIGN)
     File: resources/views/dashboard/shared/kelola-murid/index.blade.php
============================================= --}}

@extends('layouts.app')

@section('title', 'Kelola Murid')

@section('content')
<div style="width: 100%;">
    
    {{-- ── 1. HEADER HALAMAN ── --}}
    <div style="margin-bottom: 25px;">
        <p style="color: #6B7280; font-size: 13px; margin: 0 0 4px 0;">
            {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}
        </p>
        <h1 style="font-size: 26px; font-weight: 700; color: #111827; margin: 0; letter-spacing: -0.5px; line-height: 1.2;">
            Kelola Murid
        </h1>
        <p style="color: #6B7280; font-size: 14px; margin: 4px 0 0 0;">Manajemen Data Murid</p>
    </div>

    {{-- ── 2. ACTIONS BAR ── --}}
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; gap: 15px;">
        <div style="display: flex; align-items: center; gap: 12px; flex: 1;">
            <select style="padding: 8px 12px; border-radius: 10px; border: 1px solid #E5E7EB; color: #9CA3AF; font-size: 13px; min-width: 140px; background: white; outline: none;">
                <option value="">---Pilih Kelas---</option>
            </select>

            <select style="padding: 8px 12px; border-radius: 10px; border: 1px solid #E5E7EB; color: #9CA3AF; font-size: 13px; min-width: 140px; background: white; outline: none;">
                <option value="">---Tahun Masuk---</option>
            </select>
        </div>
        
        <a href="{{ route($role.'.murid.create') }}" style="text-decoration: none;">
        <button style="background-color: #4D0B87; color: white; border: none; padding: 12px 25px; border-radius: 12px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 10px; font-size: 14px; transition: 0.3s; box-shadow: 0 4px 6px rgba(77, 11, 135, 0.2);">
            <i class="fas fa-plus"></i> Tambah
            </button>
        </a>
    </div>

    {{-- Search Bar (Bawah Actions) --}}
    <div style="position: relative; width: 400px; margin-bottom: 25px;">
        <i class="fas fa-search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #9CA3AF;"></i>
        <input type="text" placeholder="Cari" 
               style="width: 100%; padding: 10px 15px 10px 45px; border-radius: 12px; border: 1px solid #E5E7EB; outline: none; background: white; font-size: 14px;">
    </div>

{{-- ── 3. TABEL UTAMA (Header Kapsul Ramping & Teks Tengah) ── --}}
<div style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.08); border: 1px solid #F3F4F6; margin-top: 10px;">
    <div style="overflow-x: auto; padding: 15px 15px 5px 15px; background: white;">
        <table style="width: 100%; border-collapse: separate; border-spacing: 0; text-align: center; font-size: 13px; white-space: nowrap;">
            <thead>
                <tr style="color: #000;">
                    {{-- No: Radius 30px, Padding diperkecil (12px), Teks Center --}}
                    <th style="background: #F3E8FF; padding: 12px 15px; font-weight: 600; text-align: center; width: 50px; border-radius: 30px 0 0 30px;">No</th>
                    
                    <th style="background: #F3E8FF; padding: 12px 15px; font-weight: 700; text-align: center;">Nama Lengkap</th>
                    <th style="background: #F3E8FF; padding: 12px 15px; font-weight: 700; text-align: center;">Kelas</th>
                    <th style="background: #F3E8FF; padding: 12px 15px; font-weight: 700; text-align: center;">Asal Sekolah</th>
                    <th style="background: #F3E8FF; padding: 12px 15px; font-weight: 700; text-align: center;">Alamat</th>
                    <th style="background: #F3E8FF; padding: 12px 15px; font-weight: 700; text-align: center;">No HP Siswa</th>
                    <th style="background: #F3E8FF; padding: 12px 15px; font-weight: 700; text-align: center;">Nama Orang Tua</th>
                    <th style="background: #F3E8FF; padding: 12px 15px; font-weight: 700; text-align: center;">No HP Ortu</th>
                    <th style="background: #F3E8FF; padding: 12px 15px; font-weight: 700; text-align: center;">Paket Awal</th>
                    <th style="background: #F3E8FF; padding: 12px 15px; font-weight: 700; text-align: center;">Pilihan Paket</th>
                    <th style="background: #F3E8FF; padding: 12px 15px; font-weight: 700; text-align: center;">Tahun Masuk</th>
                    
                    {{-- Aksi: Radius 30px di ujung kanan --}}
                    <th style="background: #F3E8FF; padding: 12px 15px; font-weight: 600; text-align: center; border-radius: 0 30px 30px 0;">Aksi</th>
                </tr>
            </thead>
                <tbody>
                    @foreach($murids as $index => $m)
                    <tr style="border-bottom: 1px solid #F3F4F6;">
                        <td style="padding: 15px; text-align: center;">{{ $index + 1 }}</td>
                        <td style="padding: 15px; font-weight: 600;">{{ $m->nama_lengkap_murid }}</td>
                        <td style="padding: 15px;">{{ $m->kelas }}</td>
                        <td style="padding: 15px;">{{ $m->asal_sekolah }}</td>
                        <td style="padding: 15px;">{{ $m->alamat_murid }}</td>
                        <td style="padding: 15px;">{{ $m->no_hp_murid }}</td>
                        <td style="padding: 15px;">{{ $m->nama_orang_tua }}</td>
                        <td style="padding: 15px;">{{ $m->no_hp_orang_tua }}</td>
                        <td style="padding: 15px; text-align: center;">
                            <input type="checkbox" checked disabled style="accent-color: #5D10A2; width: 18px; height: 18px;">
                        </td>
                        <td style="padding: 15px; text-align: center;">{{ $m->pilihan_paket }}</td>
                        <td style="padding: 15px; text-align: center;">{{ $m->tahun_masuk }}</td>
                        <td style="padding: 15px;">
                            <div style="display: flex; gap: 8px; justify-content: center;">
                                {{-- Tombol Edit Hijau --}}
                                <a href="{{ route($role.'.murid.edit', $m->id_murid) }}" 
                                   style="background: #5EB37E; color: white; padding: 6px 12px; border-radius: 6px; text-decoration: none; display: flex; align-items: center; gap: 5px; font-size: 12px;">
                                    <i class="far fa-edit"></i> Edit
                                </a>
                                {{-- Tombol Hapus Merah --}}
                                <form action="{{ route($role.'.murid.destroy', $m->id_murid) }}" method="POST" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit" onclick="return confirm('Hapus data murid?')" 
                                            style="background: #E35D5D; color: white; padding: 6px 12px; border-radius: 6px; border: none; cursor: pointer; display: flex; align-items: center; gap: 5px; font-size: 12px;">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
   {{-- ── 4. PAGINATION ── --}}
<div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px; padding: 0 5px;">
    <div style="color: #6B7280; font-size: 13px;">
        Menampilkan 
        <select style="padding: 5px 10px; border-radius: 8px; border: 1px solid #E5E7EB; outline: none; margin: 0 5px;">
            <option>10</option>
            <option>25</option>
        </select>
        baris per halaman
    </div>
    <div style="display: flex; gap: 5px;">
        <button style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #6B7280; cursor: pointer;"><i class="fas fa-angle-double-left"></i></button>
        <button style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #6B7280; cursor: pointer;"><i class="fas fa-angle-left"></i></button>
        <button style="width: 35px; height: 35px; border-radius: 8px; background: #4D0B87; color: white; border: none; font-weight: 600; cursor: pointer;">1</button>
        <button style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #6B7280; cursor: pointer;"><i class="fas fa-angle-right"></i></button>
    </div>
</div>

@endsection