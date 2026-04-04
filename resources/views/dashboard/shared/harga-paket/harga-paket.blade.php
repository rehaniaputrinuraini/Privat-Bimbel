{{-- =============================================
     Dashboard Shared - Harga Paket (REVISI LURUS)
     File: resources/views/dashboard/shared/harga-paket/index.blade.php
============================================= --}}

@extends('layouts.app')

@section('title', 'Manajemen Harga Paket')

@section('content')

{{-- ── 1. HEADER HALAMAN ── --}}
<div style="margin-bottom: 25px;">
    <p style="color: #6B7280; font-size: 13px; margin: 0 0 4px 0;">
        {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}
    </p>
    <h1 style="font-size: 26px; font-weight: 700; color: #111827; margin: 0; letter-spacing: -0.5px; line-height: 1.2;">
        Harga Paket
    </h1>
    <p style="color: #6B7280; font-size: 14px; margin: 4px 0 0 0;">Manajemen Harga Paket</p>
</div>

{{-- ── 2. ACTIONS BAR ── --}}
<div style="display: flex; justify-content: flex-end; margin-bottom: 25px;">
    <a href="{{ route($role . '.harga-paket.create') }}" style="text-decoration: none;">
        <button style="background-color: #4D0B87; color: white; border: none; padding: 12px 25px; border-radius: 12px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 10px; font-size: 14px; transition: 0.3s; box-shadow: 0 4px 6px rgba(77, 11, 135, 0.2);">
            <i class="fas fa-plus"></i> Tambah
        </button>
    </a>
</div>

{{-- ── 3. TABLE AREA ── --}}
<div style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.08); border: 1px solid #F3F4F6;">
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 13px; white-space: nowrap;">
            <thead>
                <tr style="background: #F3E8FF; color: #111827;">
                    <th style="padding: 12px 15px; font-weight: 700; text-align: center; width: 60px;">No</th>
                    <th style="padding: 12px 15px; font-weight: 700;">ID</th>
                    <th style="padding: 12px 15px; font-weight: 700;">Harga Paket</th>
                    <th style="padding: 12px 15px; font-weight: 700;">Tingkat</th>
                    <th style="padding: 12px 15px; font-weight: 700; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $pakets = [
                        (object)['kode' => 'PK0001', 'harga' => '120.000', 'tingkat' => 'SD'],
                        (object)['kode' => 'PK0002', 'harga' => '150.000', 'tingkat' => 'SMP'],
                        (object)['kode' => 'PK0003', 'harga' => '180.000', 'tingkat' => 'SMA'],
                        (object)['kode' => 'PK0004', 'harga' => '100.000', 'tingkat' => 'Biaya Pendaftaran'],
                    ];
                @endphp

                @foreach($pakets as $index => $p)
                <tr style="border-bottom: 1px solid #F3F4F6; transition: 0.2s;" onmouseover="this.style.background='#F9FAFB'" onmouseout="this.style.background='transparent'">
                    <td style="padding: 15px; text-align: center; color: #6B7280; vertical-align: middle;">{{ $index + 1 }}</td>
                    <td style="padding: 15px; font-weight: 600; color: #4D0B87; vertical-align: middle;">{{ $p->kode }}</td>
                    <td style="padding: 15px; font-weight: 600; color: #111827; vertical-align: middle;">Rp {{ $p->harga }}</td>
                    {{-- Teks Tingkat Biasa --}}
                    <td style="padding: 15px; color: #111827; vertical-align: middle;">{{ $p->tingkat }}</td>
                    <td style="padding: 15px; vertical-align: middle;">
                        <div style="display: flex; gap: 8px; justify-content: center;">
                            {{-- Tombol Edit Hijau --}}
                            <a href="#" style="background: #5EB37E; color: white; padding: 6px 12px; border-radius: 6px; text-decoration: none; display: flex; align-items: center; gap: 5px; font-size: 12px;">
                                <i class="far fa-edit"></i> Edit
                            </a>
                            
                            {{-- Tombol Hapus Merah --}}
                            <form action="#" method="POST" style="margin: 0;">
                                @csrf @method('DELETE')
                                <button type="submit" onclick="return confirm('Hapus data?')" 
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
<div style="display: flex; justify-content: space-between; align-items: center; margin-top: 25px; padding: 0 5px;">
    <div style="color: #6B7280; font-size: 13px;">
        Menampilkan {{ count($pakets) }} baris per halaman
    </div>
    <div style="display: flex; gap: 5px;">
        <button style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #6B7280; cursor: pointer;"><i class="fas fa-angle-left"></i></button>
        <button style="width: 35px; height: 35px; border-radius: 8px; background: #4D0B87; color: white; border: none; font-weight: 600;">1</button>
        <button style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #6B7280; cursor: pointer;"><i class="fas fa-angle-right"></i></button>
    </div>
</div>

@endsection