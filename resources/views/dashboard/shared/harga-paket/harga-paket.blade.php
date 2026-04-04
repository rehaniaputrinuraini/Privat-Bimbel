{{-- =============================================
     Dashboard Shared - Harga Paket (FINAL REVISI)
     File: resources/views/dashboard/shared/harga-paket/index.blade.php
============================================= --}}

@extends('layouts.app')

@section('title', 'Manajemen Harga Paket')

@section('content')
{{-- 
    INFO: Tidak perlu pembungkus <div class="container"> atau style padding lagi. 
    Jarak sudah otomatis diatur oleh .content-wrapper di dashboard.css
--}}

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

{{-- ── 2. ACTIONS BAR (Tombol Tambah) ── --}}
<div style="display: flex; justify-content: flex-end; margin-bottom: 25px;">
    <a href="{{ route($role . '.harga-paket.create') }}" style="text-decoration: none;">
        <button style="background: #4D0B87; color: white; border: none; padding: 10px 24px; border-radius: 12px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 10px; font-size: 14px; transition: 0.3s; box-shadow: 0 4px 10px rgba(77, 11, 135, 0.2);">
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
                    <th style="padding: 18px 15px; text-align: center; font-weight: 700; width: 70px;">No</th>
                    <th style="padding: 18px 15px; font-weight: 700;">ID</th>
                    <th style="padding: 18px 15px; font-weight: 700;">Harga Paket</th>
                    <th style="padding: 18px 15px; font-weight: 700;">Tingkat</th>
                    <th style="padding: 18px 15px; text-align: center; font-weight: 700;">Aksi</th>
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
                    <td style="padding: 15px; text-align: center; color: #6B7280;">{{ $index + 1 }}</td>
                    <td style="padding: 15px; font-weight: 600; color: #4D0B87;">{{ $p->kode }}</td>
                    <td style="padding: 15px; font-weight: 700; color: #111827;">Rp {{ $p->harga }}</td>
                    <td style="padding: 15px;">
                        <span style="background: #E0E7FF; color: #4338CA; padding: 4px 12px; border-radius: 8px; font-weight: 700; font-size: 11px;">
                            {{ $p->tingkat }}
                        </span>
                    </td>
                    <td style="padding: 15px;">
                        <div style="display: flex; gap: 8px; justify-content: center;">
                            <a href="#" title="Edit" style="background: #F3E8FF; color: #4D0B87; width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; text-decoration: none; transition: 0.3s;">
                                <i class="fas fa-edit" style="font-size: 12px;"></i>
                            </a>
                            <form action="#" method="POST" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" title="Hapus" onclick="return confirm('Hapus paket ini?')" style="background: #FEE2E2; color: #EF4444; width: 32px; height: 32px; border-radius: 8px; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: 0.3s;">
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
        Menampilkan {{ count($pakets) }} baris per halaman
    </div>
    <div style="display: flex; gap: 5px;">
        <button style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #6B7280; cursor: pointer;"><i class="fas fa-angle-left"></i></button>
        <button style="width: 35px; height: 35px; border-radius: 8px; background: #4D0B87; color: white; border: none; font-weight: 600;">1</button>
        <button style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #6B7280; cursor: pointer;"><i class="fas fa-angle-right"></i></button>
    </div>
</div>
@endsection