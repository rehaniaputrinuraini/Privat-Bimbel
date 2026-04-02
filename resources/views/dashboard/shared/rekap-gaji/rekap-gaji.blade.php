@extends('layouts.app')

@section('title', 'Rekap Gaji Tentor')

@section('content')
{{-- Header Halaman --}}
<div style="margin-bottom: 25px;">
    <p style="color: #6B7280; font-size: 14px; margin-bottom: 5px;">{{ \Carbon\Carbon::now()->translatedFormat('F Y') }}</p>
    <h1 style="font-size: 28px; font-weight: 800; color: #111827; margin: 0;">Rekap Gaji</h1>
    <p style="color: #6B7280; font-size: 14px; margin-top: 5px;">Cetak Slip Gaji Semua Tentor</p>
</div>

{{-- Filter Area --}}
<div style="display: flex; gap: 15px; align-items: flex-end; margin-bottom: 25px;">
    <div style="width: 150px;">
        <label style="display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 8px;">Filter Bulan</label>
        <div style="position: relative;">
            <select style="width: 100%; padding: 10px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: white; appearance: none; cursor: pointer; font-size: 14px; color: #4B5563;">
                <option>Maret</option>
                <option>Februari</option>
            </select>
            <i class="fas fa-chevron-down" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); color: #9CA3AF; pointer-events: none; font-size: 12px;"></i>
        </div>
    </div>
    
    <div style="position: relative; width: 200px;">
        <i class="fas fa-search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #9CA3AF;"></i>
        <input type="text" placeholder="Cari" style="width: 100%; padding: 10px 15px 10px 40px; border-radius: 12px; border: 1px solid #E5E7EB; outline: none; background: white; font-size: 14px;">
    </div>
</div>

{{-- Tabel Container --}}
<div style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.05); border: 1px solid #E5E7EB; margin-bottom: 25px;">
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; text-align: center; font-size: 13px;">
            <thead>
                <tr style="background-color: #F3E8FF; color: #111827; font-weight: 700;">
                    <th style="padding: 15px;">No</th>
                    <th style="padding: 15px;">Tentor</th>
                    <th style="padding: 15px;">Total Hadir</th>
                    <th style="padding: 15px;">Total Honor</th>
                    <th style="padding: 15px;">Total Uang Makan</th>
                    <th style="padding: 15px;">Total Transport</th>
                    <th style="padding: 15px;">Total Gaji</th>
                    <th style="padding: 15px;">Aksi</th>
                </tr>
            </thead>
            <tbody style="color: #111827; font-weight: 600;">
                @php
                    $gajis = [
                        ['no' => 1, 'nama' => 'Mas Alvin', 'hadir' => '12 Kali', 'honor' => '1.700.000', 'makan' => '1.700.000', 'trans' => '1.700.000', 'total' => '1.700.000'],
                        ['no' => 2, 'nama' => 'Rehania Putri', 'hadir' => '6 Kali', 'honor' => '800.000', 'makan' => '800.000', 'trans' => '800.000', 'total' => '800.000'],
                    ];
                @endphp

                @foreach($gajis as $g)
                <tr style="border-bottom: 1px solid #F3F4F6;">
                    <td style="padding: 20px;">{{ $g['no'] }}</td>
                    <td style="padding: 20px; font-weight: 800;">{{ $g['nama'] }}</td>
                    <td style="padding: 20px; color: #6B7280;">{{ $g['hadir'] }}</td>
                    <td style="padding: 20px; color: #6B7280;">Rp. {{ $g['honor'] }}</td>
                    <td style="padding: 20px; color: #6B7280;">Rp. {{ $g['makan'] }}</td>
                    <td style="padding: 20px; color: #6B7280;">Rp. {{ $g['trans'] }}</td>
                    <td style="padding: 20px; color: #6B7280;">Rp. {{ $g['total'] }}</td>
                    <td style="padding: 20px;">
                        <button style="background: #5D10A2; color: white; border: none; padding: 10px 15px; border-radius: 8px; cursor: pointer; display: flex; align-items: center; gap: 8px; font-weight: 700; font-size: 11px; text-transform: uppercase;">
                            <i class="fas fa-file-invoice"></i> Cetak Slip
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    {{-- Total Pengeluaran Bar --}}
    <div style="padding: 20px 30px; display: flex; justify-content: space-between; align-items: center; background: white; border-top: 1px solid #F3F4F6;">
        <span style="font-size: 18px; font-weight: 800; color: #111827;">Total Pengeluaran Gaji :</span>
        <div style="background: #10B981; color: white; padding: 10px 25px; border-radius: 10px; font-size: 18px; font-weight: 800;">
            Rp. 2.500.000
        </div>
    </div>
</div>

{{-- Pagination & Bulk Action --}}
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
    <select style="padding: 8px 15px; border-radius: 10px; border: 1px solid #E5E7EB; color: #6B7280; font-size: 13px; background: white;">
        <option>10 baris</option>
    </select>
    
    <div style="display: flex; gap: 5px;">
        <button style="padding: 8px 12px; background: #F3F4F6; border: none; border-radius: 8px; cursor: pointer; color: #9CA3AF;"><i class="fas fa-angle-double-left"></i></button>
        <button style="padding: 8px 12px; background: #F3F4F6; border: none; border-radius: 8px; cursor: pointer; color: #9CA3AF;"><i class="fas fa-angle-left"></i></button>
        <button style="padding: 8px 15px; background: #5D10A2; color: white; border: none; border-radius: 8px; font-weight: 700;">1</button>
        <button style="padding: 8px 12px; background: #F3F4F6; border: none; border-radius: 8px; cursor: pointer; color: #9CA3AF;"><i class="fas fa-angle-right"></i></button>
    </div>
</div>

{{-- Tombol Cetak Semua --}}
<button style="width: 100%; background: #22C55E; color: white; border: none; padding: 18px; border-radius: 15px; font-size: 18px; font-weight: 800; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 15px; box-shadow: 0 4px 15px rgba(34, 197, 94, 0.3);">
    <i class="fas fa-print" style="font-size: 24px;"></i>
    CETAK SEMUA SLIP GAJI
</button>

@endsection