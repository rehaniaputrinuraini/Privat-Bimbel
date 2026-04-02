@extends('layouts.app')

@section('title', 'Kelola Admin')

@section('content')
<div style="padding: 10px; font-family: 'Poppins', sans-serif;">
    
    {{-- Header --}}
    <div style="margin-bottom: 20px;">
        <p style="color: #6B7280; font-size: 14px; margin-bottom: 5px;">Maret 2026</p>
        <h1 style="font-size: 24px; font-weight: 700; color: #111827; margin: 0;">Kelola Admin</h1>
        <p style="color: #6B7280; font-size: 13px;">Manajemen Data Admin</p>
    </div>

    {{-- Filter Area --}}
    <div style="display: flex; gap: 15px; margin-bottom: 20px; align-items: center;">
        <div style="position: relative; flex: 1; max-width: 250px;">
            <i class="fas fa-search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #9CA3AF;"></i>
            <input type="text" placeholder="Cari" style="width: 100%; padding: 8px 15px 8px 40px; border-radius: 10px; border: 1px solid #E5E7EB; outline: none; font-size: 13px;">
        </div>
        <select style="padding: 8px 15px; border-radius: 10px; border: 1px solid #E5E7EB; color: #6B7280; background: white; font-size: 13px; outline: none;">
            <option value="">---Status Gaji---</option>
            <option value="Sudah">Sudah</option>
            <option value="Belum">Belum</option>
        </select>
        
        {{-- Link ke halaman create-admin --}}
        <a href="{{ route('superadmin.kelola-admin.create') }}" style="text-decoration: none;">
            <button style="background-color: #4D0B87; color: white; border: none; padding: 10px 20px; border-radius: 10px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 8px; font-size: 13px;">
                <i class="fas fa-plus"></i> Tambah Akun
            </button>
        </a>
    </div>

    {{-- Table Area --}}
    <div style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border: 1px solid #E5E7EB;">
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 12px; white-space: nowrap;">
                <thead>
                    <tr style="background: #F3E8FF; color: #111827;">
                        <th style="padding: 15px; text-align: center;">No</th>
                        <th style="padding: 15px;">ID</th>
                        <th style="padding: 15px;">Nama Lengkap</th>
                        <th style="padding: 15px;">Alamat</th>
                        <th style="padding: 15px;">No HP</th>
                        <th style="padding: 15px;">Gaji</th>
                        <th style="padding: 15px;">Status Gaji</th>
                        <th style="padding: 15px;">Email</th>
                        <th style="padding: 15px;">Username</th>
                        <th style="padding: 15px;">Password</th>
                        <th style="padding: 15px; text-align: center;">Aksi</th>
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
                    <tr style="border-bottom: 1px solid #F3F4F6;">
                        <td style="padding: 12px; text-align: center;">{{ $index + 1 }}</td>
                        <td style="padding: 12px;">{{ $a['id'] }}</td>
                        <td style="padding: 12px; font-weight: 600;">{{ $a['nama'] }}</td>
                        <td style="padding: 12px; color: #6B7280;">XXXXXXXXXXXX</td>
                        <td style="padding: 12px;">0881999999</td>
                        <td style="padding: 12px;">{{ $a['gaji'] }}</td>
                        <td style="padding: 12px;">{{ $a['status'] }}</td>
                        <td style="padding: 12px; color: #6B7280;">XXXXXXXXXX</td>
                        <td style="padding: 12px; color: #6B7280;">YYYYYYYYYY</td>
                        <td style="padding: 12px; color: #6B7280;">XXXXXXXXXX</td>
                        <td style="padding: 12px; text-align: center;">
                            <div style="display: flex; gap: 5px; justify-content: center;">
                                <button style="background: #60A060; color: white; border: none; padding: 6px 12px; border-radius: 5px; font-size: 11px; cursor: pointer; display: flex; align-items: center; gap: 5px;">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <button style="background: #D74E4E; color: white; border: none; padding: 6px 12px; border-radius: 5px; font-size: 11px; cursor: pointer; display: flex; align-items: center; gap: 5px;">
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

    {{-- Pagination Dummy --}}
    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px;">
        <select style="padding: 5px; border-radius: 5px; border: 1px solid #E5E7EB; font-size: 12px;">
            <option>10 baris</option>
        </select>
        <div style="display: flex; gap: 3px;">
            <button style="padding: 5px 10px; border-radius: 5px; border: 1px solid #E5E7EB; background: #F3F4F6;"><i class="fas fa-angle-double-left"></i></button>
            <button style="padding: 5px 10px; border-radius: 5px; border: 1px solid #E5E7EB; background: #F3F4F6;"><i class="fas fa-angle-left"></i></button>
            <button style="padding: 5px 12px; border-radius: 5px; background: #4D0B87; color: white; border: none;">1</button>
            <button style="padding: 5px 10px; border-radius: 5px; border: 1px solid #E5E7EB; background: #F3F4F6;"><i class="fas fa-angle-right"></i></button>
        </div>
    </div>
</div>
@endsection