{{-- =============================================
     Dashboard Shared - Rekap Gaji Tentor
     File: resources/views/dashboard/shared/rekap-gaji/rekap-gaji.blade.php
============================================= --}}

@extends('layouts.app')

@section('title', 'Rekap Gaji Tentor')

@section('content')
<div style="width: 100%;">

    {{-- ── 1. HEADER HALAMAN ── --}}
    <div style="margin-bottom: 25px;">
        <p style="color: #374151; font-size: 13px; margin: 0 0 4px 0;">
            {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}
        </p>
        <h1 style="font-size: 26px; font-weight: 700; color: #111827; margin: 0; letter-spacing: -0.5px; line-height: 1.2;">
            Rekap Gaji Tentor
        </h1>
        <p style="color: #374151; font-size: 14px; margin: 4px 0 0 0;">Kelola dan Cetak Slip Gaji Bulanan</p>
    </div>

    {{-- ── 2. ACTIONS BAR ── --}}
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; gap: 15px;">
        <div style="display: flex; align-items: center; gap: 12px; flex: 1;">

            {{-- Search --}}
            <div style="position: relative; width: 280px;">
                <i class="fas fa-search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #9CA3AF;"></i>
                <input type="text" placeholder="Cari Nama Tentor..."
                       style="width: 100%; padding: 10px 15px 10px 45px; border-radius: 12px; border: 1px solid #E5E7EB; outline: none; background: white; font-size: 14px; color: #374151;">
            </div>

            {{-- Filter Bulan --}}
            <select style="padding: 10px 12px; border-radius: 12px; border: 1px solid #E5E7EB; color: #374151; font-size: 13px; min-width: 150px; background: white; outline: none; cursor: pointer;">
                <option value="">--- Pilih Bulan ---</option>
                <option value="1">Januari</option>
                <option value="2">Februari</option>
                <option value="3" selected>Maret</option>
                <option value="4">April</option>
                <option value="5">Mei</option>
                <option value="6">Juni</option>
                <option value="7">Juli</option>
                <option value="8">Agustus</option>
                <option value="9">September</option>
                <option value="10">Oktober</option>
                <option value="11">November</option>
                <option value="12">Desember</option>
            </select>

            {{-- Filter Tahun --}}
            <select style="padding: 10px 12px; border-radius: 12px; border: 1px solid #E5E7EB; color: #374151; font-size: 13px; min-width: 120px; background: white; outline: none; cursor: pointer;">
                <option value="">--- Tahun ---</option>
                <option value="2024">2024</option>
                <option value="2025">2025</option>
                <option value="2026" selected>2026</option>
            </select>

        </div>
    </div>

    {{-- ── 3. TABEL UTAMA ── --}}
    <div style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.08); border: 1px solid #F3F4F6;">
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 13px; white-space: nowrap;">
                <thead>
                    <tr style="background: #F3E8FF; color: #111827;">
                        <th style="padding: 15px; font-weight: 700; text-align: center; width: 50px;">No</th>
                        <th style="padding: 15px; font-weight: 700;">Nama Tentor</th>
                        <th style="padding: 15px; font-weight: 700;">Hadir</th>
                        <th style="padding: 15px; font-weight: 700;">Honor</th>
                        <th style="padding: 15px; font-weight: 700;">Uang Makan</th>
                        <th style="padding: 15px; font-weight: 700;">Transport</th>
                        <th style="padding: 15px; font-weight: 700;">Total Gaji</th>
                        <th style="padding: 15px; font-weight: 700; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody style="color: #374151;">
                    @php
                        $gajis = [
                            ['no' => 1, 'nama' => 'Mas Alvin',     'hadir' => '12 Kali', 'honor' => '1.700.000', 'makan' => '1.700.000', 'trans' => '1.700.000', 'total' => '5.100.000'],
                            ['no' => 2, 'nama' => 'Rehania Putri', 'hadir' => '6 Kali',  'honor' => '800.000',   'makan' => '800.000',   'trans' => '800.000',   'total' => '2.400.000'],
                        ];
                    @endphp

                    @foreach($gajis as $g)
                    <tr style="border-bottom: 1px solid #F3F4F6; transition: 0.2s;"
                        onmouseover="this.style.background='#F9FAFB'"
                        onmouseout="this.style.background='transparent'">
                        <td style="padding: 15px; text-align: center;">{{ $g['no'] }}</td>
                        <td style="padding: 15px;">{{ $g['nama'] }}</td>
                        <td style="padding: 15px;">{{ $g['hadir'] }}</td>
                        <td style="padding: 15px;">Rp {{ $g['honor'] }}</td>
                        <td style="padding: 15px;">Rp {{ $g['makan'] }}</td>
                        <td style="padding: 15px;">Rp {{ $g['trans'] }}</td>
                        <td style="padding: 15px;">Rp {{ $g['total'] }}</td>
                        <td style="padding: 15px;">
                            <div style="display: flex; gap: 8px; justify-content: center;">
                                <button title="Cetak Slip"
                                        style="background: #5EB37E; color: white; padding: 6px 12px; border-radius: 6px; border: none; cursor: pointer; display: flex; align-items: center; gap: 5px; font-size: 12px; font-weight: 600;">
                                    <i class="fas fa-file-invoice"></i> SLIP
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Total Pengeluaran --}}
        <div style="padding: 20px 30px; display: flex; justify-content: space-between; align-items: center; background: #F9FAFB; border-top: 2px solid #F3F4F6;">
            <span style="font-size: 15px; font-weight: 700; color: #374151;">Total Pengeluaran Gaji Bulan Ini :</span>
            <div style="background: #10B981; color: white; padding: 10px 25px; border-radius: 12px; font-size: 17px; font-weight: 800; box-shadow: 0 4px 10px rgba(16, 185, 129, 0.2);">
                Rp 7.500.000
            </div>
        </div>
    </div>

    {{-- ── 4. PAGINATION & SHOW ENTRIES ── --}}
    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px; padding: 0 5px;">

        {{-- Kiri: Show entries --}}
        <div style="display: flex; align-items: center; gap: 10px;">
            <select style="padding: 8px 12px; border-radius: 10px; border: 1px solid #E5E7EB; color: #374151; font-size: 13px; background: white; outline: none; cursor: pointer; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                <option value="10">10 baris</option>
                <option value="25">25 baris</option>
                <option value="50">50 baris</option>
            </select>
            <span style="color: #374151; font-size: 13px;">Menampilkan {{ count($gajis) }} data</span>
        </div>

        {{-- Kanan: Navigasi halaman --}}
        <div style="display: flex; gap: 5px;">
            <button style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; cursor: pointer;"><i class="fas fa-angle-double-left"></i></button>
            <button style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; cursor: pointer;"><i class="fas fa-angle-left"></i></button>
            <button style="width: 35px; height: 35px; border-radius: 8px; background: #4D0B87; color: white; border: none; font-weight: 600; cursor: pointer;">1</button>
            <button style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; cursor: pointer;"><i class="fas fa-angle-right"></i></button>
        </div>
    </div>

    {{-- ── 5. TOMBOL CETAK SEMUA (BAWAH, FULL WIDTH) ── --}}
    <button style="width: 100%; background: #22C55E; color: white; border: none; padding: 16px; border-radius: 15px; font-size: 16px; font-weight: 700; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 12px; margin-top: 25px; transition: 0.3s; box-shadow: 0 4px 15px rgba(34, 197, 94, 0.3);"
            onmouseover="this.style.background='#16A34A'"
            onmouseout="this.style.background='#22C55E'">
        <i class="fas fa-print" style="font-size: 20px;"></i>
        CETAK SEMUA SLIP GAJI TENTOR
    </button>

</div>
@endsection