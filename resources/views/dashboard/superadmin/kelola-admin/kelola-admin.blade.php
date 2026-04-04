{{-- =============================================
     Dashboard Shared - Kelola Admin
     File: resources/views/dashboard/superadmin/kelola-admin/index.blade.php
============================================= --}}

@extends('layouts.app')

@section('title', 'Kelola Admin')

@section('content')

{{-- ── 1. HEADER HALAMAN (Sesuai Revisi Dashboard: 26px) ── --}}
<div style="margin-bottom: 25px;">
    <p style="color: #6B7280; font-size: 13px; margin-bottom: 4px;">
        {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}
    </p>
    <h1 style="font-size: 26px; font-weight: 700; color: #111827; margin: 0; letter-spacing: -0.5px;">
        Kelola Admin
    </h1>
    <p style="color: #6B7280; font-size: 14px; margin-top: 4px;">Manajemen Data dan Akun Administrator Sistem</p>
</div>

{{-- ── 2. FILTER AREA & TOMBOL TAMBAH ── --}}
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
    <div style="display: flex; gap: 15px; flex: 1;">
        {{-- Search Bar --}}
        <div style="position: relative; width: 100%; max-width: 300px;">
            <i class="fas fa-search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #9CA3AF;"></i>
            <input type="text" placeholder="Cari Nama atau ID Admin..." 
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
    <a href="{{ route('superadmin.kelola-admin.create') }}" style="text-decoration: none;">
        <button style="background-color: #4D0B87; color: white; border: none; padding: 12px 25px; border-radius: 12px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 10px; font-size: 14px; transition: 0.3s; box-shadow: 0 4px 6px rgba(77, 11, 135, 0.2);">
            <i class="fas fa-plus"></i> Tambah Akun
        </button>
    </a>
</div>

{{-- ── 3. TABLE AREA (Sesuai Shadow Master Template) ── --}}
<div style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.08); border: 1px solid #F3F4F6;">
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 13px; white-space: nowrap;">
            <thead>
                <tr style="background: #F3E8FF; color: #111827;">
                    <th style="padding: 18px 15px; text-align: center; font-weight: 700;">No</th>
                    <th style="padding: 18px 15px; font-weight: 700;">ID</th>
                    <th style="padding: 18px 15px; font-weight: 700;">Nama Lengkap</th>
                    <th style="padding: 18px 15px; font-weight: 700;">Alamat</th>
                    <th style="padding: 18px 15px; font-weight: 700;">No HP</th>
                    <th style="padding: 18px 15px; font-weight: 700;">Gaji</th>
                    <th style="padding: 18px 15px; font-weight: 700;">Status Gaji</th>
                    <th style="padding: 18px 15px; font-weight: 700;">Email</th>
                    <th style="padding: 18px 15px; font-weight: 700;">Username</th>
                    <th style="padding: 18px 15px; font-weight: 700;">Password</th>
                    <th style="padding: 18px 15px; text-align: center; font-weight: 700;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $admins = [
                        ['id' => 'AD0001', 'nama' => 'Wella', 'gaji' => '1.200.000', 'status' => 'Sudah'],
                        ['id' => 'AD0002', 'nama' => 'Nindy', 'gaji' => '1.500.000', 'status' => 'Sudah'],
                        ['id' => 'AD0003', 'nama' => 'Nindy', 'gaji' => '1.500.000', 'status' => 'Belum'],
                        ['id' => 'AD0004', 'nama' => 'Nindy', 'gaji' => '1.500.000', 'status' => 'Sudah'],
                    ];
                @endphp

                @foreach($admins as $index => $a)
                <tr style="border-bottom: 1px solid #F3F4F6; transition: 0.2s;" onmouseover="this.style.background='#F9FAFB'" onmouseout="this.style.background='transparent'">
                    <td style="padding: 15px; text-align: center; color: #6B7280;">{{ $index + 1 }}</td>
                    <td style="padding: 15px; font-weight: 600; color: #4D0B87;">{{ $a['id'] }}</td>
                    <td style="padding: 15px; font-weight: 600; color: #111827;">{{ $a['nama'] }}</td>
                    <td style="padding: 15px; color: #6B7280;">Madiun, Jawa Timur</td>
                    <td style="padding: 15px;">0881999999</td>
                    <td style="padding: 15px; font-weight: 600;">Rp {{ $a['gaji'] }}</td>
                    <td style="padding: 15px;">
                        <span style="color: {{ $a['status'] == 'Sudah' ? '#10B981' : '#F59E0B' }}; font-weight: 600;">
                            {{ $a['status'] }}
                        </span>
                    </td>
                    <td style="padding: 15px; color: #6B7280;">wella@email.com</td>
                    <td style="padding: 15px; color: #6B7280;">wella_admin</td>
                    <td style="padding: 15px; color: #6B7280;">********</td>
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

{{-- ── 4. PAGINATION (Identik dengan Kelola Tentor) ── --}}
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