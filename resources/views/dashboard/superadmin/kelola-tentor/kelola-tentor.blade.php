{{-- =============================================
     Dashboard Superadmin - Kelola Tentor (SCROLL INDICATOR)
     File: resources/views/superadmin/kelola-tentor/index.blade.php
============================================= --}}

@extends('layouts.app')

@section('title', 'Kelola Tentor')

@section('content')

{{-- ── 1. HEADER HALAMAN ── --}}
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
        <div style="position: relative; width: 100%; max-width: 300px;">
            <i class="fas fa-search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #9CA3AF;"></i>
            <input type="text" placeholder="Cari Nama atau ID Tentor..." 
                   style="width: 100%; padding: 10px 15px 10px 45px; border-radius: 12px; border: 1px solid #E5E7EB; outline: none; font-size: 14px; background: white;">
        </div>
        
        <select style="padding: 10px 15px; border-radius: 12px; border: 1px solid #E5E7EB; color: #6B7280; background: white; font-size: 14px; outline: none; cursor: pointer; min-width: 180px;">
            <option value="">--- Status Gaji ---</option>
            <option value="Sudah">Sudah Dibayar</option>
            <option value="Belum">Belum Dibayar</option>
        </select>
    </div>

    <a href="{{ route('superadmin.kelola-tentor.create') }}" style="text-decoration: none;">
        <button style="background-color: #4D0B87; color: white; border: none; padding: 12px 25px; border-radius: 12px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 10px; font-size: 14px; transition: 0.3s; box-shadow: 0 4px 6px rgba(77, 11, 135, 0.2);">
            <i class="fas fa-plus"></i> Tambah
        </button>
    </a>
</div>

{{-- ── 3. TABLE AREA DENGAN INDIKATOR GESER ── --}}
<div style="margin-bottom: 10px; display: flex; align-items: center; gap: 8px; color: #9CA3AF; font-size: 12px;">
</div>

<style>
    @keyframes slideLeftRight {
        0%, 100% { transform: translateX(0); }
        50% { transform: translateX(5px); }
    }
</style>

<div style="background: white; border-radius: 20px; position: relative; box-shadow: 0 4px 15px rgba(0,0,0,0.08); border: 1px solid #F3F4F6;">
    {{-- Shadow Overlay untuk indikator bisa geser --}}
    <div style="position: absolute; right: 0; top: 0; bottom: 0; width: 40px; background: linear-gradient(to right, transparent, rgba(255,255,255,0.8)); pointer-events: none; border-radius: 0 20px 20px 0; z-index: 10;"></div>

    <div style="overflow-x: auto; padding: 15px 15px 5px 15px;">
        <table style="width: 100%; border-collapse: separate; border-spacing: 0; font-size: 13px; white-space: nowrap;">
            <thead>
                <tr style="color: #111827;">
                    <th style="background: #F3E8FF; padding: 12px 15px; font-weight: 700; text-align: center; width: 50px; border-radius: 30px 0 0 30px;">No</th>
                    <th style="background: #F3E8FF; padding: 12px 15px; font-weight: 700; text-align: left;">ID</th>
                    <th style="background: #F3E8FF; padding: 12px 15px; font-weight: 700; text-align: left;">Nama Lengkap</th>
                    <th style="background: #F3E8FF; padding: 12px 15px; font-weight: 700; text-align: left;">Alamat</th>
                    <th style="background: #F3E8FF; padding: 12px 15px; font-weight: 700; text-align: left;">No HP</th>
                    <th style="background: #F3E8FF; padding: 12px 15px; font-weight: 700; text-align: left;">Mapel</th>
                    <th style="background: #F3E8FF; padding: 12px 15px; font-weight: 700; text-align: center;">Grade</th>
                    <th style="background: #F3E8FF; padding: 12px 15px; font-weight: 700; text-align: left;">HR SD</th>
                    <th style="background: #F3E8FF; padding: 12px 15px; font-weight: 700; text-align: left;">HR SMP</th>
                    <th style="background: #F3E8FF; padding: 12px 15px; font-weight: 700; text-align: left;">HR SMA</th>
                    <th style="background: #F3E8FF; padding: 12px 15px; font-weight: 700; text-align: left;">Makan</th>
                    <th style="background: #F3E8FF; padding: 12px 15px; font-weight: 700; text-align: left;">Transport</th>
                    <th style="background: #F3E8FF; padding: 12px 15px; font-weight: 700; text-align: left;">Status Gaji</th>
                    <th style="background: #F3E8FF; padding: 12px 15px; font-weight: 700; text-align: center;">Status Akun</th>
                    <th style="background: #F3E8FF; padding: 12px 15px; font-weight: 700; text-align: center; border-radius: 0 30px 30px 0;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $data = [
                        ['id' => 'TE0001', 'nama' => 'Rati Maria', 'status_akun' => 'Aktif', 'status_gaji' => 'Sudah'],
                        ['id' => 'TE0002', 'nama' => 'Dwi Rahayu', 'status_akun' => 'Tidak Aktif', 'status_gaji' => 'Belum'],
                        ['id' => 'TE0003', 'nama' => 'Rahma Tyas', 'status_akun' => 'Aktif', 'status_gaji' => 'Sudah'],
                    ];
                @endphp

                @foreach($data as $index => $t)
                <tr style="border-bottom: 1px solid #F3F4F6; transition: 0.2s;" onmouseover="this.style.background='#F9FAFB'" onmouseout="this.style.background='transparent'">
                    <td style="padding: 15px; text-align: center; color: #6B7280; vertical-align: middle;">{{ $index + 1 }}</td>
                    <td style="padding: 15px; font-weight: 600; color: #4D0B87; vertical-align: middle;">{{ $t['id'] }}</td>
                    <td style="padding: 15px; font-weight: 600; color: #111827; vertical-align: middle;">{{ $t['nama'] }}</td>
                    <td style="padding: 15px; color: #6B7280; vertical-align: middle;">Madiun, Jawa Timur</td>
                    <td style="padding: 15px; color: #6B7280; vertical-align: middle;">08812345678</td>
                    <td style="padding: 15px; color: #6B7280; vertical-align: middle;">Matematika</td>
                    <td style="padding: 15px; font-weight: 500; text-align: center; vertical-align: middle;">A</td>
                    <td style="padding: 15px; color: #111827; vertical-align: middle;">50.000</td>
                    <td style="padding: 15px; color: #111827; vertical-align: middle;">50.000</td>
                    <td style="padding: 15px; color: #111827; vertical-align: middle;">50.000</td>
                    <td style="padding: 15px; color: #111827; vertical-align: middle;">10.000</td>
                    <td style="padding: 15px; color: #111827; vertical-align: middle;">10.000</td>
                    <td style="padding: 15px; vertical-align: middle;">
                        <span style="color: {{ $t['status_gaji'] == 'Sudah' ? '#5EB37E' : '#E35D5D' }}; font-weight: 600;">
                            {{ $t['status_gaji'] }}
                        </span>
                    </td>
                    <td style="padding: 15px; vertical-align: middle;">
                        <div style="display: flex; align-items: center; justify-content: center; gap: 8px; font-weight: 500; color: #111827;">
                            <div style="width: 10px; height: 10px; border-radius: 50%; background: {{ $t['status_akun'] == 'Aktif' ? '#5EB37E' : '#E35D5D' }}; flex-shrink: 0;"></div>
                            <span style="line-height: 1;">{{ $t['status_akun'] }}</span>
                        </div>
                    </td>
                    <td style="padding: 15px; vertical-align: middle;">
                        <div style="display: flex; gap: 8px; justify-content: center; align-items: center;">
                            <a href="#" style="background: #5EB37E; color: white; padding: 6px 12px; border-radius: 6px; text-decoration: none; display: flex; align-items: center; gap: 5px; font-size: 12px; height: 32px;">
                                <i class="far fa-edit"></i> Edit
                            </a>
                            <form action="#" method="POST" style="margin: 0; display: flex; align-items: center;">
                                @csrf @method('DELETE')
                                <button type="submit" onclick="return confirm('Hapus data?')" 
                                        style="background: #E35D5D; color: white; padding: 6px 12px; border-radius: 6px; border: none; cursor: pointer; display: flex; align-items: center; gap: 5px; font-size: 12px; height: 32px;">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                            @if($t['status_akun'] == 'Aktif')
                                <button style="background: white; color: #E35D5D; border: 1px solid #E35D5D; padding: 6px 12px; border-radius: 6px; cursor: pointer; display: flex; align-items: center; gap: 5px; font-size: 12px; font-weight: 600; height: 32px;">
                                    <i class="fas fa-times-circle"></i> NonAktifkan
                                </button>
                            @else
                                <button style="background: white; color: #5EB37E; border: 1px solid #5EB37E; padding: 6px 12px; border-radius: 6px; cursor: pointer; display: flex; align-items: center; gap: 5px; font-size: 12px; font-weight: 600; height: 32px;">
                                    <i class="fas fa-check-circle"></i> Aktifkan
                                </button>
                            @endif
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
        <button style="width: 35px; height: 35px; border-radius: 8px; background: #4D0B87; color: white; border: none; font-weight: 600;">1</button>
        <button style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #6B7280; cursor: pointer;"><i class="fas fa-angle-right"></i></button>
    </div>
</div>

@endsection