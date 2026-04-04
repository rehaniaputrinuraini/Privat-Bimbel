{{-- =============================================
     Dashboard Shared - Kelola Murid (FINAL REVISI)
     File: resources/views/dashboard/shared/kelola-murid/index.blade.php
============================================= --}}

@extends('layouts.app')

@section('title', 'Kelola Murid')

@section('content')
{{-- 
    INFO: Jarak kiri dan atas sudah otomatis 25px dari .content-wrapper (dashboard.css).
    Jangan gunakan class container-fluid atau padding tambahan di sini.
--}}
<div style="width: 100%;">
    
    {{-- ── 1. HEADER HALAMAN (26px - Konsisten) ── --}}
    <div style="margin-bottom: 25px;">
        <p style="color: #6B7280; font-size: 13px; margin: 0 0 4px 0;">
            {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}
        </p>
        <h1 style="font-size: 26px; font-weight: 700; color: #111827; margin: 0; letter-spacing: -0.5px; line-height: 1.2;">
            Kelola Murid
        </h1>
        <p style="color: #6B7280; font-size: 14px; margin: 4px 0 0 0;">Manajemen Data Murid</p>
    </div>

    {{-- ── 2. ACTIONS BAR (Search, Filter, & Tambah) ── --}}
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; gap: 15px;">
        
        <div style="display: flex; align-items: center; gap: 12px; flex: 1;">
            {{-- Search Bar --}}
            <div style="position: relative; width: 300px;">
                <i class="fas fa-search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #9CA3AF;"></i>
                <input type="text" placeholder="Cari Nama Murid..." 
                       style="width: 100%; padding: 10px 15px 10px 45px; border-radius: 12px; border: 1px solid #E5E7EB; outline: none; background: white; font-size: 14px;">
            </div>

            {{-- Filter Kelas --}}
            <select style="padding: 10px 15px; border-radius: 12px; border: 1px solid #E5E7EB; color: #6B7280; font-size: 14px; min-width: 160px; background: white; outline: none; cursor: pointer;">
                <option value="">--- Pilih Kelas ---</option>
                {{-- Data dummy atau loop --}}
                <option>Kelas 1</option>
                <option>Kelas 2</option>
            </select>

            {{-- Filter Tahun --}}
            <select style="padding: 10px 15px; border-radius: 12px; border: 1px solid #E5E7EB; color: #6B7280; font-size: 14px; min-width: 160px; background: white; outline: none; cursor: pointer;">
                <option value="">--- Tahun Masuk ---</option>
                <option>2024</option>
                <option>2025</option>
            </select>
        </div>
        
        {{-- Tombol Tambah --}}
        <a href="{{ route($role.'.murid.create') }}" style="text-decoration: none;">
            <button style="background: #4D0B87; color: white; padding: 10px 24px; border-radius: 12px; border: none; font-weight: 600; display: flex; align-items: center; gap: 10px; font-size: 14px; cursor: pointer; white-space: nowrap; box-shadow: 0 4px 10px rgba(77, 11, 135, 0.2);">
                <i class="fas fa-plus"></i> Tambah Murid
            </button>
        </a>
    </div>

    {{-- ── 3. TABEL UTAMA (Shadow & Style Master) ── --}}
    <div style="background: white; border-radius: 20px; border: 1px solid #F3F4F6; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.08);">
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; min-width: 1300px; text-align: left; font-size: 13px;">
                <thead>
                    <tr style="background: #F3E8FF; color: #111827;">
                        <th style="padding: 18px 15px; font-weight: 700; text-align: center; width: 60px;">No</th>
                        <th style="padding: 18px 15px; font-weight: 700;">Nama Lengkap</th>
                        <th style="padding: 18px 15px; font-weight: 700; text-align: center;">Kelas</th>
                        <th style="padding: 18px 15px; font-weight: 700;">Asal Sekolah</th>
                        <th style="padding: 18px 15px; font-weight: 700;">Alamat</th>
                        <th style="padding: 18px 15px; font-weight: 700;">No HP Siswa</th>
                        <th style="padding: 18px 15px; font-weight: 700;">Nama Orang Tua</th>
                        <th style="padding: 18px 15px; font-weight: 700;">No HP Ortu</th>
                        <th style="padding: 18px 15px; font-weight: 700;">Paket Awal</th>
                        <th style="padding: 18px 15px; text-align: center; font-weight: 700;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($murids as $index => $m)
                    <tr style="border-bottom: 1px solid #F3F4F6; transition: 0.2s;" onmouseover="this.style.background='#F9FAFB'" onmouseout="this.style.background='transparent'">
                        <td style="padding: 15px; text-align: center; color: #6B7280;">{{ $index + 1 }}</td>
                        <td style="padding: 15px; font-weight: 700; color: #111827;">{{ $m->nama_lengkap_murid }}</td>
                        <td style="padding: 15px; text-align: center;">
                            <span style="background: #E0E7FF; color: #4338CA; padding: 4px 10px; border-radius: 8px; font-weight: 700; font-size: 11px;">
                                {{ $m->kelas }}
                            </span>
                        </td>
                        <td style="padding: 15px; color: #4B5563;">{{ $m->asal_sekolah }}</td>
                        <td style="padding: 15px; font-size: 12px; color: #6B7280; white-space: normal; max-width: 200px;">
                            {{ $m->alamat_murid ?? 'Madiun, Jawa Timur' }}
                        </td>
                        <td style="padding: 15px; color: #111827;">{{ $m->no_hp_murid }}</td>
                        <td style="padding: 15px; color: #111827;">{{ $m->nama_orang_tua }}</td>
                        <td style="padding: 15px; color: #111827;">{{ $m->no_hp_orang_tua }}</td>
                        <td style="padding: 15px; font-weight: 700; color: #4D0B87;">Rp {{ number_format($m->paket_awal, 0, ',', '.') }}</td>
                        <td style="padding: 15px;">
                            <div style="display: flex; gap: 8px; justify-content: center;">
                                <a href="{{ route($role.'.murid.edit', $m->id_murid) }}" title="Edit" style="background: #F3E8FF; color: #4D0B87; width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; text-decoration: none; transition: 0.3s;">
                                    <i class="fas fa-edit" style="font-size: 12px;"></i>
                                </a>
                                <form action="#" method="POST" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit" onclick="return confirm('Hapus data murid?')" style="background: #FEE2E2; color: #EF4444; width: 32px; height: 32px; border-radius: 8px; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: 0.3s;">
                                        <i class="fas fa-trash" style="font-size: 12px;"></i>
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
    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 25px;">
        <div style="color: #6B7280; font-size: 13px;">
            Menampilkan {{ count($murids) }} baris per halaman
        </div>
        <div style="display: flex; gap: 5px;">
            <button style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #6B7280; cursor: pointer;"><i class="fas fa-angle-left"></i></button>
            <button style="width: 35px; height: 35px; border-radius: 8px; background: #4D0B87; color: white; border: none; font-weight: 600;">1</button>
            <button style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #6B7280; cursor: pointer;"><i class="fas fa-angle-right"></i></button>
        </div>
    </div>
</div>
@endsection