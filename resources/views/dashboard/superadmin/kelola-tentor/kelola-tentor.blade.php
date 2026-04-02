@extends('layouts.app')

@section('title', 'Kelola Tentor')

@section('content')
<div style="padding: 10px; font-family: 'Poppins', sans-serif;">
    
    {{-- 1. HEADER HALAMAN --}}
    <div style="margin-bottom: 20px;">
        <p style="color: #6B7280; font-size: 14px; margin-bottom: 5px;">
            {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}
        </p>
        <h1 style="font-size: 24px; font-weight: 700; color: #111827; margin: 0;">Kelola Tentor</h1>
        <p style="color: #6B7280; font-size: 13px;">Manajemen Data Tentor</p>
    </div>

    {{-- 2. FILTER AREA & TOMBOL TAMBAH --}}
    <div style="display: flex; gap: 15px; margin-bottom: 20px; align-items: center;">
        <div style="position: relative; flex: 1; max-width: 250px;">
            <i class="fas fa-search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #9CA3AF;"></i>
            <input type="text" placeholder="Cari" style="width: 100%; padding: 8px 15px 8px 40px; border-radius: 10px; border: 1px solid #E5E7EB; outline: none; font-size: 13px;">
        </div>
        
        <select style="padding: 8px 15px; border-radius: 10px; border: 1px solid #E5E7EB; color: #6B7280; background: white; font-size: 13px; outline: none; cursor: pointer;">
            <option value="">---Status Gaji---</option>
            <option value="Sudah">Sudah</option>
            <option value="Belum">Belum</option>
        </select>

        {{-- FIX: Tombol Tambah Akun menggunakan Link Route --}}
        <a href="{{ route('superadmin.kelola-tentor.create') }}" style="text-decoration: none;">
            <button style="background-color: #4D0B87; color: white; border: none; padding: 10px 20px; border-radius: 10px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 8px; font-size: 13px; transition: 0.3s;">
                <i class="fas fa-plus"></i> Tambah Akun
            </button>
        </a>
    </div>

    {{-- 3. TABLE AREA (DATA TENTOR) --}}
    <div style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border: 1px solid #E5E7EB;">
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 11px; white-space: nowrap;">
                <thead>
                    <tr style="background: #F3E8FF; color: #111827; font-weight: 700;">
                        <th style="padding: 15px; text-align: center;">No</th>
                        <th style="padding: 15px;">ID</th>
                        <th style="padding: 15px;">Nama Lengkap</th>
                        <th style="padding: 15px;">Alamat</th>
                        <th style="padding: 15px;">No HP</th>
                        <th style="padding: 15px;">Mapel</th>
                        <th style="padding: 15px; text-align: center;">Grade</th>
                        <th style="padding: 15px;">HR SD</th>
                        <th style="padding: 15px;">HR SMP</th>
                        <th style="padding: 15px;">HR SMA</th>
                        <th style="padding: 15px;">Uang Makan</th>
                        <th style="padding: 15px;">Transport</th>
                        <th style="padding: 15px;">Status Gaji</th>
                        <th style="padding: 15px;">Email</th>
                        <th style="padding: 15px;">Username</th>
                        <th style="padding: 15px;">Password</th>
                        <th style="padding: 15px; text-align: center;">Status Akun</th>
                        <th style="padding: 15px; text-align: center;">Aksi</th>
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
                    <tr style="border-bottom: 1px solid #F3F4F6;">
                        <td style="padding: 12px; text-align: center;">{{ $index + 1 }}</td>
                        <td style="padding: 12px;">{{ $t['id'] }}</td>
                        <td style="padding: 12px; font-weight: 600; color: #111827;">{{ $t['nama'] }}</td>
                        <td style="padding: 12px; color: #6B7280;">XXXXXXXXXXXX</td>
                        <td style="padding: 12px;">0881999999</td>
                        <td style="padding: 12px; color: #6B7280;">XXXXXXXXXX</td>
                        <td style="padding: 12px; text-align: center;">A</td>
                        <td style="padding: 12px;">50.000</td>
                        <td style="padding: 12px;">50.000</td>
                        <td style="padding: 12px;">50.000</td>
                        <td style="padding: 12px;">10.000</td>
                        <td style="padding: 12px; text-align: center;">-</td>
                        <td style="padding: 12px;">{{ $t['status_gaji'] }}</td>
                        <td style="padding: 12px; color: #6B7280;">YYYYYY</td>
                        <td style="padding: 12px; color: #6B7280;">YYYYYY</td>
                        <td style="padding: 12px; color: #6B7280;">XXXXXX</td>
                        <td style="padding: 12px; text-align: center;">
                            <span style="display: inline-flex; align-items: center; gap: 5px;">
                                <div style="width: 8px; height: 8px; border-radius: 50%; background: {{ $t['status_akun'] == 'Aktif' ? '#10B981' : '#EF4444' }};"></div>
                                {{ $t['status_akun'] }}
                            </span>
                        </td>
                        <td style="padding: 12px; text-align: center;">
                            <div style="display: flex; gap: 5px; justify-content: center;">
                                <button style="background: #10B981; color: white; border: none; padding: 4px 8px; border-radius: 5px; font-size: 10px; cursor: pointer;"><i class="fas fa-edit"></i> Edit</button>
                                <button style="background: #EF4444; color: white; border: none; padding: 4px 8px; border-radius: 5px; font-size: 10px; cursor: pointer;"><i class="fas fa-trash"></i> Hapus</button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- 4. PAGINATION --}}
    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px;">
        <select style="padding: 5px; border-radius: 5px; border: 1px solid #E5E7EB; font-size: 11px; outline: none;">
            <option>10 baris</option>
        </select>
        <div style="display: flex; gap: 3px;">
            <button style="padding: 5px 10px; border-radius: 5px; border: 1px solid #E5E7EB; background: #F3F4F6; font-size: 11px;"><<</button>
            <button style="padding: 5px 10px; border-radius: 5px; border: 1px solid #E5E7EB; background: #F3F4F6; font-size: 11px;"><</button>
            <button style="padding: 5px 10px; border-radius: 5px; background: #4D0B87; color: white; border: none; font-size: 11px;">1</button>
            <button style="padding: 5px 10px; border-radius: 5px; border: 1px solid #E5E7EB; background: #F3F4F6; font-size: 11px;">></button>
        </div>
    </div>
</div>
@endsection