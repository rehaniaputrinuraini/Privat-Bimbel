{{-- =============================================
     Dashboard Shared - Kelola Tentor
     File: resources/views/dashboard/superadmin/kelola-tentor/index.blade.php
============================================= --}}

@extends('layouts.app')

@section('title', 'Kelola Tentor')

@section('content')

{{-- ── 1. HEADER HALAMAN (Revisi: Ukuran 26px agar proporsional) ── --}}
<div style="margin-bottom: 25px;">
    <p style="color: #6B7280; font-size: 13px; margin-bottom: 4px;">
        {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}
    </p>
    <h1 style="font-size: 26px; font-weight: 700; color: #111827; margin: 0; letter-spacing: -0.5px;">
        Kelola Tentor
    </h1>
    <p style="color: #6B7280; font-size: 14px; margin-top: 4px;">Manajemen Data dan Akun Tentor Bimbel Privat</p>
</div>

{{-- ── 2. FILTER AREA & TOMBOL TAMBAH ── --}}
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
    <div style="display: flex; gap: 15px; flex: 1;">
        {{-- Search Bar --}}
        <div style="position: relative; width: 100%; max-width: 300px;">
            <i class="fas fa-search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #9CA3AF;"></i>
            <input type="text" placeholder="Cari Nama atau ID Tentor..." 
                   style="width: 100%; padding: 10px 15px 10px 45px; border-radius: 12px; border: 1px solid #E5E7EB; outline: none; font-size: 14px; background: white;">
        </div>
        
        {{-- Filter Dropdown --}}
        <select style="padding: 10px 15px; border-radius: 12px; border: 1px solid #E5E7EB; color: #6B7280; background: white; font-size: 14px; outline: none; cursor: pointer; min-width: 180px;">
            <option value="">--- Status Gaji ---</option>
            <option value="Sudah">Sudah Dibayar</option>
            <option value="Belum">Belum Dibayar</option>
        </select>
    </div>

    {{-- Tombol Tambah Akun --}}
    <a href="{{ route('superadmin.kelola-tentor.create') }}" style="text-decoration: none;">
        <button style="background-color: #4D0B87; color: white; border: none; padding: 12px 25px; border-radius: 12px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 10px; font-size: 14px; transition: 0.3s; box-shadow: 0 4px 6px rgba(77, 11, 135, 0.2);">
            <i class="fas fa-plus"></i> Tambah Akun
        </button>
    </a>
</div>

{{-- ── 3. TABLE AREA (Shadow 0.08 agar halus) ── --}}
<div style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.08); border: 1px solid #F3F4F6;">
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 12px; white-space: nowrap;">
            <thead>
                <tr style="background: #F3E8FF; color: #111827;">
                    <th style="padding: 18px 15px; text-align: center; font-weight: 700;">No</th>
                    <th style="padding: 18px 15px; font-weight: 700;">ID</th>
                    <th style="padding: 18px 15px; font-weight: 700;">Nama Lengkap</th>
                    <th style="padding: 18px 15px; font-weight: 700;">Alamat</th>
                    <th style="padding: 18px 15px; font-weight: 700;">No HP</th>
                    <th style="padding: 18px 15px; font-weight: 700;">Mapel</th>
                    <th style="padding: 18px 15px; font-weight: 700; text-align: center;">Grade</th>
                    <th style="padding: 18px 15px; font-weight: 700;">HR SD</th>
                    <th style="padding: 18px 15px; font-weight: 700;">HR SMP</th>
                    <th style="padding: 18px 15px; font-weight: 700;">HR SMA</th>
                    <th style="padding: 18px 15px; font-weight: 700;">Makan</th>
                    <th style="padding: 18px 15px; font-weight: 700; text-align: center;">Akun</th>
                    <th style="padding: 18px 15px; text-align: center; font-weight: 700;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $data = [
                        ['id' => 'TE0001', 'nama' => 'Rati Maria', 'status_gaji' => 'Sudah', 'status_akun' => 'Aktif'],
                        ['id' => 'TE0002', 'nama' => 'Dwi Rahayu', 'status_gaji' => 'Sudah', 'status_akun' => 'Tidak Aktif'],
                        ['id' => 'TE0003', 'nama' => 'Rahma Tyas', 'status_gaji' => 'Belum', 'status_akun' => 'Aktif'],
                        ['id' => 'TE0004', 'nama' => 'Sinta Putri', 'status_gaji' => 'Belum', 'status_akun' => 'Aktif'],
                    ];
                @endphp

                @foreach($data as $index => $t)
                <tr style="border-bottom: 1px solid #F3F4F6; transition: 0.2s;" onmouseover="this.style.background='#F9FAFB'" onmouseout="this.style.background='transparent'">
                    <td style="padding: 15px; text-align: center; color: #6B7280;">{{ $index + 1 }}</td>
                    <td style="padding: 15px; font-weight: 600; color: #4D0B87;">{{ $t['id'] }}</td>
                    <td style="padding: 15px; font-weight: 600; color: #111827;">{{ $t['nama'] }}</td>
                    <td style="padding: 15px; color: #6B7280;">Madiun, Jawa Timur</td>
                    <td style="padding: 15px;">08812345678</td>
                    <td style="padding: 15px; color: #6B7280;">Matematika</td>
                    <td style="padding: 15px; text-align: center;"><span style="background: #E0E7FF; color: #4338CA; padding: 2px 8px; border-radius: 6px; font-weight: 600;">A</span></td>
                    <td style="padding: 15px;">50.000</td>
                    <td style="padding: 15px;">50.000</td>
                    <td style="padding: 15px;">50.000</td>
                    <td style="padding: 15px;">10.000</td>
                    <td style="padding: 15px; text-align: center;">
                        <span style="display: inline-flex; align-items: center; gap: 6px; padding: 5px 12px; border-radius: 20px; background: {{ $t['status_akun'] == 'Aktif' ? '#D1FAE5' : '#FEE2E2' }}; color: {{ $t['status_akun'] == 'Aktif' ? '#065F46' : '#991B1B' }}; font-weight: 500; font-size: 10px;">
                            <div style="width: 6px; height: 6px; border-radius: 50%; background: currentColor;"></div>
                            {{ $t['status_akun'] }}
                        </span>
                    </td>
                    <td style="padding: 15px; text-align: center;">
                        <div style="display: flex; gap: 8px; justify-content: center;">
                            <button title="Edit" style="background: #F3E8FF; color: #4D0B87; border: none; width: 32px; height: 32px; border-radius: 8px; cursor: pointer; transition: 0.3s;"><i class="fas fa-edit"></i></button>
                            <button title="Hapus" style="background: #FEE2E2; color: #EF4444; border: none; width: 32px; height: 32px; border-radius: 8px; cursor: pointer; transition: 0.3s;"><i class="fas fa-trash"></i></button>
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