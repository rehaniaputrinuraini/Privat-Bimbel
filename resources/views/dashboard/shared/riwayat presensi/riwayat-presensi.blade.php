{{-- =============================================
     Dashboard Shared - Riwayat Presensi (FINAL REVISI)
     File: resources/views/dashboard/shared/riwayat-presensi/index.blade.php
============================================= --}}

@extends('layouts.app')

@section('title', 'Riwayat Presensi')

@section('content')
{{-- 
    INFO: Jarak kiri dan atas sudah otomatis 25px dari .content-wrapper (dashboard.css).
    Jangan gunakan div pembungkus dengan padding lagi agar tetap sejajar.
--}}
<div style="width: 100%;">

    {{-- ── 1. HEADER HALAMAN (26px - Konsisten) ── --}}
    <div style="margin-bottom: 25px;">
        <p style="color: #6B7280; font-size: 13px; margin: 0 0 4px 0;">
            {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}
        </p>
        <h1 style="font-size: 26px; font-weight: 700; color: #111827; margin: 0; letter-spacing: -0.5px; line-height: 1.2;">
            Riwayat Presensi
        </h1>
        <p style="color: #6B7280; font-size: 14px; margin: 4px 0 0 0;">Lihat Riwayat Presensi Semua Tentor</p>
    </div>

    {{-- ── 2. FILTER AREA (Search & Dropdown) ── --}}
    <div style="display: flex; gap: 15px; align-items: flex-end; margin-bottom: 25px;">
        {{-- Dropdown Filter Bulan --}}
        <div style="flex: 1; max-width: 300px;">
            <label style="display: block; font-size: 12px; font-weight: 700; color: #374151; margin-bottom: 6px; text-transform: uppercase;">Filter Bulan</label>
            <div style="position: relative;">
                <select style="width: 100%; padding: 10px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: white; color: #4B5563; font-size: 14px; outline: none; appearance: none; cursor: pointer;">
                    <option value="Maret">Maret 2026</option>
                    <option value="Februari">Februari 2026</option>
                </select>
                <i class="fas fa-chevron-down" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); color: #9CA3AF; pointer-events: none; font-size: 12px;"></i>
            </div>
        </div>
        
        {{-- Search Bar --}}
        <div style="position: relative; flex: 1; max-width: 300px;">
            <i class="fas fa-search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #9CA3AF;"></i>
            <input type="text" placeholder="Cari Nama Tentor..." 
                   style="width: 100%; padding: 10px 15px 10px 45px; border-radius: 12px; border: 1px solid #E5E7EB; outline: none; background: white; font-size: 14px;">
        </div>
    </div>

    {{-- ── 3. TABLE AREA (Shadow & Master Style) ── --}}
    <div style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.08); border: 1px solid #F3F4F6;">
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: center; font-size: 13px; white-space: nowrap;">
                <thead>
                    <tr style="background: #F3E8FF; color: #111827;">
                        <th style="padding: 18px 15px; font-weight: 700; width: 60px;">No</th>
                        <th style="padding: 18px 15px; font-weight: 700; text-align: left;">Nama Tentor</th>
                        <th style="padding: 18px 15px; font-weight: 700;">Tanggal</th>
                        <th style="padding: 18px 15px; font-weight: 700;">Jam</th>
                        <th style="padding: 18px 15px; font-weight: 700;">Kelas</th>
                        <th style="padding: 18px 15px; font-weight: 700;">Status</th>
                        <th style="padding: 18px 15px; font-weight: 700;">Honor</th>
                        <th style="padding: 18px 15px; font-weight: 700;">Makan</th>
                        <th style="padding: 18px 15px; font-weight: 700;">Trans</th>
                        <th style="padding: 18px 15px; font-weight: 700;">Bukti</th>
                        <th style="padding: 18px 15px; font-weight: 700; width: 80px;">Verif</th>
                    </tr>
                </thead>
                <tbody style="color: #4B5563;">
                    @php
                        $presensi = [
                            ['no' => 1, 'nama' => 'Sari Putri', 'tgl' => '09 Feb 2026', 'jam' => '14:00 - 17:00', 'kelas' => '9A', 'status' => 'Hadir', 'honor' => '30.000', 'makan' => '10.000', 'trans' => '10.000', 'verif' => false],
                            ['no' => 2, 'nama' => 'Sari Putri', 'tgl' => '10 Feb 2026', 'jam' => '14:00 - 17:00', 'kelas' => '9A', 'status' => 'Tidak Hadir', 'honor' => '15.000', 'makan' => '-', 'trans' => '10.000', 'verif' => true],
                            ['no' => 3, 'nama' => 'Sari Putri', 'tgl' => '11 Feb 2026', 'jam' => '14:00 - 17:00', 'kelas' => '9A', 'status' => 'Hadir', 'honor' => '30.000', 'makan' => '10.000', 'trans' => '-', 'verif' => true],
                        ];
                    @endphp

                    @foreach($presensi as $p)
                    <tr style="border-bottom: 1px solid #F3F4F6; transition: 0.2s;" onmouseover="this.style.background='#F9FAFB'" onmouseout="this.style.background='transparent'">
                        <td style="padding: 15px; color: #6B7280;">{{ $p['no'] }}</td>
                        <td style="padding: 15px; text-align: left; font-weight: 700; color: #111827;">{{ $p['nama'] }}</td>
                        <td style="padding: 15px;">{{ $p['tgl'] }}</td>
                        <td style="padding: 15px; font-weight: 500;">{{ $p['jam'] }}</td>
                        <td style="padding: 15px;">
                            <span style="background: #E0E7FF; color: #4338CA; padding: 4px 10px; border-radius: 8px; font-weight: 700; font-size: 11px;">{{ $p['kelas'] }}</span>
                        </td>
                        <td style="padding: 15px;">
                            <span style="background: {{ $p['status'] == 'Hadir' ? '#DCFCE7' : '#FEE2E2' }}; 
                                         color: {{ $p['status'] == 'Hadir' ? '#166534' : '#991B1B' }}; 
                                         padding: 5px 12px; border-radius: 8px; font-size: 11px; font-weight: 700;">
                                {{ $p['status'] }}
                            </span>
                        </td>
                        <td style="padding: 15px; font-weight: 700; color: #111827;">Rp {{ $p['honor'] }}</td>
                        <td style="padding: 15px;">{{ $p['makan'] == '-' ? '-' : 'Rp '.$p['makan'] }}</td>
                        <td style="padding: 15px;">{{ $p['trans'] == '-' ? '-' : 'Rp '.$p['trans'] }}</td>
                        <td style="padding: 15px;">
                            <button title="Download Bukti" style="background: #F3E8FF; border: none; color: #4D0B87; width: 32px; height: 32px; border-radius: 8px; cursor: pointer; transition: 0.3s;">
                                <i class="fas fa-file-download"></i>
                            </button>
                        </td>
                        <td style="padding: 15px;">
                            <input type="checkbox" {{ $p['verif'] ? 'checked' : '' }} 
                                   style="accent-color: #4D0B87; width: 18px; height: 18px; cursor: pointer;">
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
            Menampilkan {{ count($presensi) }} baris per halaman
        </div>
        <div style="display: flex; gap: 5px;">
            <button style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #6B7280; cursor: pointer;"><i class="fas fa-angle-left"></i></button>
            <button style="width: 35px; height: 35px; border-radius: 8px; background: #4D0B87; color: white; border: none; font-weight: 600;">1</button>
            <button style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #6B7280; cursor: pointer;"><i class="fas fa-angle-right"></i></button>
        </div>
    </div>
</div>
@endsection