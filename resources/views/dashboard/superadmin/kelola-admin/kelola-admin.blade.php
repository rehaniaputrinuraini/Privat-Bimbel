{{-- =============================================
     Dashboard Shared - Kelola Admin (REVISI: ADD SHOW ENTRIES)
     File: resources/views/dashboard/superadmin/kelola-admin/index.blade.php
============================================= --}}

@extends('layouts.app')

@section('title', 'Kelola Admin')

@section('content')
<div style="width: 100%;">
    
    {{-- ── 1. HEADER HALAMAN ── --}}
    <div style="margin-bottom: 25px;">
        <p style="color: #374151; font-size: 13px; margin: 0 0 4px 0;">
            {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}
        </p>
        <h1 style="font-size: 26px; font-weight: 700; color: #111827; margin: 0; letter-spacing: -0.5px; line-height: 1.2;">
            Kelola Admin
        </h1>
        <p style="color: #374151; font-size: 14px; margin: 4px 0 0 0;">Manajemen Data dan Akun Administrator Sistem</p>
    </div>

    {{-- ── 2. ACTIONS BAR ── --}}
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; gap: 15px;">
        <div style="display: flex; align-items: center; gap: 12px; flex: 1;">
            <div style="position: relative; width: 300px;">
                <i class="fas fa-search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #9CA3AF;"></i>
                <input type="text" placeholder="Cari Nama atau ID Admin..." 
                       style="width: 100%; padding: 10px 15px 10px 45px; border-radius: 12px; border: 1px solid #E5E7EB; outline: none; background: white; font-size: 14px; color: #374151;">
            </div>

            <select style="padding: 10px 12px; border-radius: 12px; border: 1px solid #E5E7EB; color: #374151; font-size: 13px; min-width: 160px; background: white; outline: none; cursor: pointer;">
                <option value="">--- Status Gaji ---</option>
                <option value="Sudah">Sudah</option>
                <option value="Belum">Belum</option>
            </select>
        </div>
        
        <a href="{{ route('superadmin.kelola-admin.create') }}" style="text-decoration: none;">
            <button style="background-color: #4D0B87; color: white; border: none; padding: 12px 25px; border-radius: 12px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 10px; font-size: 14px; transition: 0.3s; box-shadow: 0 4px 6px rgba(77, 11, 135, 0.2);">
                <i class="fas fa-plus"></i> Tambah
            </button>
        </a>
    </div>

    {{-- ── 3. TABEL UTAMA ── --}}
    <div style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.08); border: 1px solid #F3F4F6;">
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 13px; white-space: nowrap;">
                <thead>
                    <tr style="background: #F3E8FF; color: #111827;">
                        <th style="padding: 15px; font-weight: 700; text-align: center; width: 50px;">No</th>
                        <th style="padding: 15px; font-weight: 700;">ID</th>
                        <th style="padding: 15px; font-weight: 700;">Nama Lengkap</th>
                        <th style="padding: 15px; font-weight: 700;">Alamat</th>
                        <th style="padding: 15px; font-weight: 700;">No HP</th>
                        <th style="padding: 15px; font-weight: 700;">Gaji</th>
                        <th style="padding: 15px; font-weight: 700; text-align: center;">Status Gaji</th>
                        <th style="padding: 15px; font-weight: 700;">Email</th>
                        <th style="padding: 15px; font-weight: 700;">Username</th>
                        <th style="padding: 15px; font-weight: 700;">Password</th>
                        <th style="padding: 15px; font-weight: 700; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody style="color: #374151;">
                    @php
                        $admins = [
                            (object)['id_admin' => 'AD0001', 'nama' => 'Wella', 'gaji' => '1.200.000', 'status' => 'Sudah', 'email' => 'wella@email.com', 'user' => 'wella_adm'],
                            (object)['id_admin' => 'AD0002', 'nama' => 'Nindy Sari', 'gaji' => '1.500.000', 'status' => 'Belum', 'email' => 'nindy@email.com', 'user' => 'nindy_sari'],
                            (object)['id_admin' => 'AD0003', 'nama' => 'Riska Amelia', 'gaji' => '1.350.000', 'status' => 'Sudah', 'email' => 'riska@email.com', 'user' => 'riska_am'],
                        ];
                    @endphp

                    @foreach($admins as $index => $a)
                    <tr style="border-bottom: 1px solid #F3F4F6; transition: 0.2s;" onmouseover="this.style.background='#F9FAFB'" onmouseout="this.style.background='transparent'">
                        <td style="padding: 15px; text-align: center;">{{ $index + 1 }}</td>
                        <td style="padding: 15px;">{{ $a->id_admin }}</td>
                        <td style="padding: 15px;">{{ $a->nama }}</td>
                        <td style="padding: 15px;">Madiun, Jawa Timur</td>
                        <td style="padding: 15px;">08812345678</td>
                        <td style="padding: 15px;">Rp {{ $a->gaji }}</td>
                        <td style="padding: 15px; text-align: center;">
                            <span style="padding: 5px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; 
                                background: {{ $a->status == 'Sudah' ? '#E1F7E3' : '#FEE2E2' }}; 
                                color: {{ $a->status == 'Sudah' ? '#0E7490' : '#EF4444' }};">
                                {{ $a->status }}
                            </span>
                        </td>
                        <td style="padding: 15px;">{{ $a->email }}</td>
                        <td style="padding: 15px;">{{ $a->user }}</td>
                        <td style="padding: 15px;">********</td>
                        <td style="padding: 15px;">
                            <div style="display: flex; gap: 8px; justify-content: center;">
                                <a href="{{ route('superadmin.kelola-admin.edit', $a->id_admin) }}" style="background: #5EB37E; color: white; padding: 6px 12px; border-radius: 6px; text-decoration: none; display: flex; align-items: center; gap: 5px; font-size: 12px;">
                                    <i class="far fa-edit"></i> Edit
                                </a>
                                <button type="button" style="background: #E35D5D; color: white; padding: 6px 12px; border-radius: 6px; border: none; cursor: pointer; display: flex; align-items: center; gap: 5px; font-size: 12px;">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
    {{-- ── 4. PAGINATION & SHOW ENTRIES ── --}}
    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px; padding: 0 5px;">
        {{-- BAGIAN KIRI: SHOW ENTRIES (SEPERTI DI GAMBAR) --}}
        <div style="display: flex; align-items: center; gap: 10px;">
            <select style="padding: 8px 12px; border-radius: 10px; border: 1px solid #E5E7EB; color: #374151; font-size: 13px; background: white; outline: none; cursor: pointer; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                <option value="10">10 baris</option>
                <option value="25">25 baris</option>
                <option value="50">50 baris</option>
            </select>
            <span style="color: #374151; font-size: 13px;">Menampilkan {{ count($admins) }} data</span>
        </div>

        {{-- BAGIAN KANAN: NAVIGASI HALAMAN --}}
        <div style="display: flex; gap: 5px;">
            <button style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; cursor: pointer;"><i class="fas fa-angle-double-left"></i></button>
            <button style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; cursor: pointer;"><i class="fas fa-angle-left"></i></button>
            <button style="width: 35px; height: 35px; border-radius: 8px; background: #4D0B87; color: white; border: none; font-weight: 600; cursor: pointer;">1</button>
            <button style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; cursor: pointer;"><i class="fas fa-angle-right"></i></button>
        </div>
    </div>

</div>
@endsection