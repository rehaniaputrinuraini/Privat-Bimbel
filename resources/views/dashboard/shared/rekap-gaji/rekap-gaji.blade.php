{{-- =============================================
     Dashboard Shared - Rekap Gaji Tentor (FINAL REVISI)
     File: resources/views/dashboard/shared/rekap-gaji/index.blade.php
============================================= --}}

@extends('layouts.app')

@section('title', 'Rekap Gaji Tentor')

@section('content')
<div style="width: 100%;">

    {{-- ── 1. HEADER HALAMAN (26px - Konsisten) ── --}}
    <div style="margin-bottom: 25px;">
        <p style="color: #6B7280; font-size: 13px; margin: 0 0 4px 0;">
            {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}
        </p>
        <h1 style="font-size: 26px; font-weight: 700; color: #111827; margin: 0; letter-spacing: -0.5px; line-height: 1.2;">
            Rekap Gaji Tentor
        </h1>
        <p style="color: #6B7280; font-size: 14px; margin: 4px 0 0 0;">Kelola dan Cetak Slip Gaji Bulanan</p>
    </div>

    {{-- ── 2. FILTER AREA ── --}}
    <div style="display: flex; gap: 15px; align-items: flex-end; margin-bottom: 25px;">
        <div style="width: 180px;">
            <label style="display: block; font-size: 12px; font-weight: 700; color: #374151; margin-bottom: 6px; text-transform: uppercase;">Pilih Bulan</label>
            <div style="position: relative;">
                <select style="width: 100%; padding: 10px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: white; color: #4B5563; font-size: 14px; outline: none; appearance: none; cursor: pointer;">
                    <option>Maret 2026</option>
                    <option>Februari 2026</option>
                </select>
                <i class="fas fa-chevron-down" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); color: #9CA3AF; pointer-events: none; font-size: 12px;"></i>
            </div>
        </div>
        
        <div style="position: relative; width: 250px;">
            <i class="fas fa-search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #9CA3AF;"></i>
            <input type="text" placeholder="Cari Nama Tentor..." 
                   style="width: 100%; padding: 10px 15px 10px 45px; border-radius: 12px; border: 1px solid #E5E7EB; outline: none; background: white; font-size: 14px;">
        </div>
    </div>

    {{-- ── 3. TABEL CONTAINER ── --}}
    <div style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.08); border: 1px solid #F3F4F6; margin-bottom: 25px;">
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: center; font-size: 13px; white-space: nowrap;">
                <thead>
                    <tr style="background: #F3E8FF; color: #111827;">
                        <th style="padding: 18px 15px; font-weight: 700;">No</th>
                        <th style="padding: 18px 15px; font-weight: 700; text-align: left;">Nama Tentor</th>
                        <th style="padding: 18px 15px; font-weight: 700;">Hadir</th>
                        <th style="padding: 18px 15px; font-weight: 700;">Honor</th>
                        <th style="padding: 18px 15px; font-weight: 700;">Uang Makan</th>
                        <th style="padding: 18px 15px; font-weight: 700;">Transport</th>
                        <th style="padding: 18px 15px; font-weight: 700;">Total Gaji</th>
                        <th style="padding: 18px 15px; font-weight: 700;">Aksi</th>
                    </tr>
                </thead>
                <tbody style="color: #4B5563;">
                    @php
                        $gajis = [
                            ['no' => 1, 'nama' => 'Mas Alvin', 'hadir' => '12 Kali', 'honor' => '1.700.000', 'makan' => '1.700.000', 'trans' => '1.700.000', 'total' => '5.100.000'],
                            ['no' => 2, 'nama' => 'Rehania Putri', 'hadir' => '6 Kali', 'honor' => '800.000', 'makan' => '800.000', 'trans' => '800.000', 'total' => '2.400.000'],
                        ];
                    @endphp

                    @foreach($gajis as $g)
                    <tr style="border-bottom: 1px solid #F3F4F6; transition: 0.2s;" onmouseover="this.style.background='#F9FAFB'" onmouseout="this.style.background='transparent'">
                        <td style="padding: 15px; color: #6B7280;">{{ $g['no'] }}</td>
                        <td style="padding: 15px; text-align: left; font-weight: 700; color: #111827;">{{ $g['nama'] }}</td>
                        <td style="padding: 15px; font-weight: 600;">{{ $g['hadir'] }}</td>
                        <td style="padding: 15px;">Rp {{ $g['honor'] }}</td>
                        <td style="padding: 15px;">Rp {{ $g['makan'] }}</td>
                        <td style="padding: 15px;">Rp {{ $g['trans'] }}</td>
                        <td style="padding: 15px; font-weight: 700; color: #4D0B87;">Rp {{ $g['total'] }}</td>
                        <td style="padding: 15px;">
                            <button title="Cetak Slip" style="background: #F3E8FF; border: none; color: #4D0B87; padding: 8px 12px; border-radius: 8px; cursor: pointer; font-weight: 700; font-size: 11px; display: inline-flex; align-items: center; gap: 5px; transition: 0.3s;">
                                <i class="fas fa-file-invoice"></i> SLIP
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        {{-- Total Pengeluaran Bar (High Visibility) --}}
        <div style="padding: 20px 30px; display: flex; justify-content: space-between; align-items: center; background: #F9FAFB; border-top: 2px solid #F3F4F6;">
            <span style="font-size: 16px; font-weight: 700; color: #374151;">Total Pengeluaran Gaji Bulan Ini :</span>
            <div style="background: #10B981; color: white; padding: 10px 25px; border-radius: 12px; font-size: 18px; font-weight: 800; box-shadow: 0 4px 10px rgba(16, 185, 129, 0.2);">
                Rp 7.500.000
            </div>
        </div>
    </div>

    {{-- ── 4. PAGINATION & FOOTER ACTION ── --}}
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
        <div style="color: #6B7280; font-size: 13px;">Menampilkan 10 baris</div>
        
        <div style="display: flex; gap: 5px;">
            <button style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #6B7280; cursor: pointer;"><i class="fas fa-angle-left"></i></button>
            <button style="width: 35px; height: 35px; border-radius: 8px; background: #4D0B87; color: white; border: none; font-weight: 600;">1</button>
            <button style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #6B7280; cursor: pointer;"><i class="fas fa-angle-right"></i></button>
        </div>
    </div>

    {{-- Tombol Cetak Massal (Primary Action) --}}
    <button style="width: 100%; background: #22C55E; color: white; border: none; padding: 16px; border-radius: 15px; font-size: 16px; font-weight: 700; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 12px; transition: 0.3s; box-shadow: 0 4px 15px rgba(34, 197, 94, 0.3);"
            onmouseover="this.style.background='#16A34A'" onmouseout="this.style.background='#22C55E'">
        <i class="fas fa-print" style="font-size: 20px;"></i>
        CETAK SEMUA SLIP GAJI TENTOR
    </button>

</div>
@endsection