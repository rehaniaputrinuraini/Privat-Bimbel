{{-- =============================================
     Dashboard Shared - Kelola Admin
     File: resources/views/dashboard/superadmin/kelola-admin/index.blade.php
============================================= --}}

@extends('layouts.app')

@section('title', 'Kelola Admin')

@section('content')

{{-- ── 1. HEADER HALAMAN ── --}}
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
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; flex-wrap: wrap; gap: 15px;">
    <div style="display: flex; gap: 15px; flex: 1;">
        <div style="position: relative; width: 100%; max-width: 300px;">
            <i class="fas fa-search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #9CA3AF;"></i>
            <input type="text" placeholder="Cari Nama atau ID Admin..." 
                   style="width: 100%; padding: 10px 15px 10px 45px; border-radius: 12px; border: 1px solid #E5E7EB; outline: none; font-size: 14px; background: white;">
        </div>
        
        <select style="padding: 10px 15px; border-radius: 12px; border: 1px solid #E5E7EB; color: #6B7280; background: white; font-size: 14px; outline: none; cursor: pointer; min-width: 180px;">
            <option value="">--- Status Gaji ---</option>
            <option value="Sudah">Sudah Dibayar</option>
            <option value="Belum">Belum Dibayar</option>
        </select>
    </div>

    <a href="{{ route('superadmin.kelola-admin.create') }}" style="text-decoration: none;">
        <button style="background-color: #4D0B87; color: white; border: none; padding: 12px 25px; border-radius: 12px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 10px; font-size: 14px; transition: 0.3s; box-shadow: 0 4px 6px rgba(77, 11, 135, 0.2);">
            <i class="fas fa-plus"></i> Tambah
        </button>
    </a>
</div>

{{-- ── 3. TABLE AREA (DENGAN SCROLLBAR PERSIS GAMBAR) ── --}}
<div style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.08); border: 1px solid #F3F4F6; position: relative;">
    
    {{-- Container Scroll --}}
    <div class="table-responsive-custom" style="overflow-x: auto; width: 100%; -webkit-overflow-scrolling: touch; padding: 15px 15px 0 15px;">
        <table style="width: 100%; border-collapse: separate; border-spacing: 0; text-align: center; font-size: 13px; white-space: nowrap;">
            <thead>
                <tr style="color: #111827;">
                    <th style="background: #F3E8FF; padding: 18px 15px; font-weight: 700; text-align: center; width: 50px; border-radius: 30px 0 0 30px;">No</th>
                    <th style="background: #F3E8FF; padding: 12px 15px; font-weight: 700;">ID</th>
                    <th style="background: #F3E8FF; padding: 12px 15px; font-weight: 700;">Nama Lengkap</th>
                    <th style="background: #F3E8FF; padding: 12px 15px; font-weight: 700;">Alamat</th>
                    <th style="background: #F3E8FF; padding: 12px 15px; font-weight: 700;">No HP</th>
                    <th style="background: #F3E8FF; padding: 12px 15px; font-weight: 700;">Gaji</th>
                    <th style="background: #F3E8FF; padding: 12px 15px; font-weight: 700;">Status Gaji</th>
                    <th style="background: #F3E8FF; padding: 12px 15px; font-weight: 700;">Email</th>
                    <th style="background: #F3E8FF; padding: 12px 15px; font-weight: 700;">Username</th>
                    <th style="background: #F3E8FF; padding: 12px 15px; font-weight: 700;">Password</th>
                    <th style="background: #F3E8FF; padding: 12px 15px; font-weight: 700; border-radius: 0 30px 30px 0;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    // Data Dummy untuk Preview
                    $admins = [
                        ['id' => 'AD0001', 'nama' => 'Wella', 'gaji' => '1.200.000', 'status' => 'Sudah', 'email' => 'wella@email.com', 'user' => 'wella_adm'],
                        ['id' => 'AD0002', 'nama' => 'Nindy Sari', 'gaji' => '1.500.000', 'status' => 'Belum', 'email' => 'nindy@email.com', 'user' => 'nindy_sari'],
                        ['id' => 'AD0003', 'nama' => 'Riska Amelia', 'gaji' => '1.350.000', 'status' => 'Sudah', 'email' => 'riska@email.com', 'user' => 'riska_am'],
                    ];
                @endphp

                @foreach($admins as $index => $a)
                <tr style="border-bottom: 1px solid #F3F4F6; transition: 0.2s;" onmouseover="this.style.background='#F9FAFB'" onmouseout="this.style.background='transparent'">
                    <td style="padding: 15px; text-align: center; color: #6B7280;">{{ $index + 1 }}</td>
                    <td style="padding: 15px; font-weight: 600; color: #4D0B87;">{{ $a['id'] }}</td>
                    <td style="padding: 15px; font-weight: 600; color: #111827;">{{ $a['nama'] }}</td>
                    <td style="padding: 15px; color: #6B7280;">Madiun, Jawa Timur</td>
                    <td style="padding: 15px;">08812345678</td>
                    <td style="padding: 15px; font-weight: 600;">{{ $a['gaji'] }}</td>
                    <td style="padding: 15px;">
                        <span style="color: {{ $a['status'] == 'Sudah' ? '#10B981' : '#E35D5D' }}; font-weight: 600;">
                            {{ $a['status'] }}
                        </span>
                    </td>
                    <td style="padding: 15px; color: #6B7280;">{{ $a['email'] }}</td>
                    <td style="padding: 15px; color: #6B7280;">{{ $a['user'] }}</td>
                    <td style="padding: 15px; color: #6B7280;">********</td>
                    <td style="padding: 15px;">
                        <div style="display: flex; gap: 8px; justify-content: center;">
                            <a href="#" style="background: #5EB37E; color: white; padding: 6px 12px; border-radius: 6px; text-decoration: none; font-size: 12px;">
                                <i class="far fa-edit"></i> Edit
                            </a>
                            <button style="background: #E35D5D; color: white; padding: 6px 12px; border-radius: 6px; border: none; cursor: pointer; font-size: 12px;">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Indikator Geser (Gaya Scrollbar Gambar) --}}
    <div style="display: flex; align-items: center; padding: 15px; background: white;">
        <i class="fas fa-caret-left" style="color: #D1D5DB; font-size: 18px;"></i>
        <div style="flex: 1; height: 8px; background: #E5E7EB; margin: 0 10px; border-radius: 10px; position: relative; overflow: hidden;">
            <div style="position: absolute; left: 0; top: 0; height: 100%; width: 40%; background: #9CA3AF; border-radius: 10px;"></div>
        </div>
        <i class="fas fa-caret-right" style="color: #D1D5DB; font-size: 18px;"></i>
    </div>
</div>

{{-- ── 4. PAGINATION ── --}}
<div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px; padding: 0 5px;">
    <div style="color: #6B7280; font-size: 13px; display: flex; align-items: center; gap: 10px;">
        Menampilkan 
        <select style="padding: 5px 10px; border-radius: 8px; border: 1px solid #E5E7EB; outline: none; background: white;">
            <option>10</option>
            <option>25</option>
        </select>
        baris per halaman
    </div>
    <div style="display: flex; gap: 5px; align-items: center;">
        <button style="width: 32px; height: 32px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #D1D5DB;"><i class="fas fa-angle-double-left"></i></button>
        <button style="width: 32px; height: 32px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #D1D5DB;"><i class="fas fa-angle-left"></i></button>
        <button style="width: 32px; height: 32px; border-radius: 8px; background: #4D0B87; color: white; border: none; font-weight: 600;">1</button>
        <button style="width: 32px; height: 32px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #6B7280;"><i class="fas fa-angle-right"></i></button>
    </div>
</div>

<style>
    /* Styling scrollbar asli agar tipis dan bersih */
    .table-responsive-custom::-webkit-scrollbar {
        height: 0px; /* Kita sembunyikan karena sudah ada indikator visual di bawah */
    }
    
    /* Jika ingin tetap memunculkan scrollbar asli tapi gaya minimalis */
    .table-responsive-custom {
        scrollbar-width: none; /* Firefox */
        -ms-overflow-style: none;  /* IE and Edge */
    }
</style>

@endsection