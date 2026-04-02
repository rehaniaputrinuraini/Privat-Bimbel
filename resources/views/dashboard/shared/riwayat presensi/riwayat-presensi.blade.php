@extends('layouts.app')

@section('title', 'Riwayat Presensi')

@section('content')
{{-- Header Halaman --}}
<div style="margin-bottom: 25px;">
    <p style="color: #6B7280; font-size: 14px; margin-bottom: 5px;">{{ \Carbon\Carbon::now()->translatedFormat('F Y') }}</p>
    <h1 style="font-size: 28px; font-weight: 800; color: #111827; margin: 0;">Riwayat Presensi</h1>
    <p style="color: #6B7280; font-size: 14px; margin-top: 5px;">Lihat Riwayat Presensi Semua Tentor</p>
</div>

{{-- Filter Area --}}
<div style="display: flex; gap: 20px; align-items: flex-end; margin-bottom: 25px;">
    <div style="flex: 1; max-width: 400px;">
        <label style="display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 8px;">Filter Bulan</label>
        <div style="position: relative; background: white; border-radius: 15px; border: 1px solid #E5E7EB; padding: 12px 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
            <select style="width: 100%; border: none; outline: none; background: transparent; font-weight: 500; color: #4B5563; appearance: none; cursor: pointer;">
                <option value="Maret">Maret</option>
                <option value="Februari">Februari</option>
            </select>
            <i class="fas fa-chevron-down" style="position: absolute; right: 20px; top: 50%; transform: translateY(-50%); color: #9CA3AF; pointer-events: none;"></i>
        </div>
    </div>
    
    <div style="position: relative; flex: 1; max-width: 300px;">
        <i class="fas fa-search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #9CA3AF;"></i>
        <input type="text" placeholder="Cari" style="width: 100%; padding: 12px 15px 12px 40px; border-radius: 12px; border: 1px solid #E5E7EB; outline: none; background: white;">
    </div>
</div>

{{-- Tabel Container --}}
<div style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.05); border: 1px solid #E5E7EB; padding-bottom: 20px;">
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; text-align: center; font-size: 13px;">
            <thead>
                <tr style="background-color: #F3E8FF; color: #111827; font-weight: 700;">
                    <th style="padding: 15px;">No</th>
                    <th style="padding: 15px;">Nama</th>
                    <th style="padding: 15px;">Tanggal</th>
                    <th style="padding: 15px;">Jam Masuk</th>
                    <th style="padding: 15px;">Jam Keluar</th>
                    <th style="padding: 15px;">Kelas</th>
                    <th style="padding: 15px;">Status Murid</th>
                    <th style="padding: 15px;">Total Honor</th>
                    <th style="padding: 15px;">Uang Makan</th>
                    <th style="padding: 15px;">Transport</th>
                    <th style="padding: 15px;">Bukti Foto</th>
                    <th style="padding: 15px;">Verifikasi Kehadiran</th>
                    <th style="padding: 15px;">Aksi</th>
                </tr>
            </thead>
            <tbody style="color: #111827; font-weight: 600;">
                @php
                    $presensi = [
                        ['no' => 1, 'nama' => 'sari', 'tgl' => '9 Feb 2026', 'masuk' => '14.00', 'keluar' => '17.00', 'kelas' => '9A', 'status' => 'Hadir', 'honor' => '30.000', 'makan' => '10.000', 'trans' => '10.000', 'verif' => false],
                        ['no' => 2, 'nama' => 'sari', 'tgl' => '10 Feb 2026', 'masuk' => '14.00', 'keluar' => '17.00', 'kelas' => '9A', 'status' => 'Tidak Hadir', 'honor' => '15.000', 'makan' => '-', 'trans' => '10.000', 'verif' => true],
                        ['no' => 3, 'nama' => 'sari', 'tgl' => '10 Feb 2026', 'masuk' => '14.00', 'keluar' => '17.00', 'kelas' => '9A', 'status' => 'Hadir', 'honor' => '30.000', 'makan' => '10.000', 'trans' => '-', 'verif' => true],
                    ];
                @endphp

                @foreach($presensi as $p)
                <tr style="border-bottom: 1px solid #F3F4F6;">
                    <td style="padding: 20px;">{{ $p['no'] }}</td>
                    <td style="padding: 20px;">{{ $p['nama'] }}</td>
                    <td style="padding: 20px;">{{ $p['tgl'] }}</td>
                    <td style="padding: 20px;">{{ $p['masuk'] }}</td>
                    <td style="padding: 20px;">{{ $p['keluar'] }}</td>
                    <td style="padding: 20px;">{{ $p['kelas'] }}</td>
                    <td style="padding: 20px;">
                        <span style="background: {{ $p['status'] == 'Hadir' ? '#B2F5B2' : '#FFD2D2' }}; color: #111827; padding: 6px 15px; border-radius: 10px; font-size: 11px;">
                            {{ $p['status'] }}
                        </span>
                    </td>
                    <td style="padding: 20px;">Rp {{ $p['honor'] }}</td>
                    <td style="padding: 20px;">Rp {{ $p['makan'] == '-' ? '-' : $p['makan'] }}</td>
                    <td style="padding: 20px;">Rp {{ $p['trans'] == '-' ? '-' : $p['trans'] }}</td>
                    <td style="padding: 20px;">
                        <button style="background: white; border: 1px solid #5D10A2; color: #5D10A2; padding: 8px 12px; border-radius: 8px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 5px;">
                            <i class="fas fa-download" style="font-size: 11px;"></i> Lihat Bukti
                        </button>
                    </td>
                    <td style="padding: 20px;">
                        <input type="checkbox" {{ $p['verif'] ? 'checked' : '' }} style="width: 18px; height: 18px; cursor: pointer;">
                    </td>
                    <td style="padding: 20px;">
                        <button style="background: #D9534F; color: white; border: none; padding: 10px 15px; border-radius: 8px; cursor: pointer; display: flex; align-items: center; gap: 5px; font-weight: 600;">
                            <i class="fas fa-trash-alt"></i> Hapus
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    {{-- Footer Summary Tabel --}}
    <div style="padding: 20px 40px; display: flex; justify-content: space-between; align-items: center; font-size: 12px; font-weight: 700;">
        <span style="color: #6B7280;">Total 3 data dalam bulan februari</span>
        <span style="color: #111827;">Total Honor: Rp 250.000</span>
    </div>
</div>

{{-- Pagination --}}
<div style="display: flex; justify-content: space-between; align-items: center; margin-top: 25px;">
    <select style="padding: 8px 15px; border-radius: 10px; border: 1px solid #E5E7EB; color: #6B7280; font-size: 13px;">
        <option>10 baris</option>
    </select>
    
    <div style="display: flex; gap: 5px;">
        <button style="padding: 8px 12px; background: #F3F4F6; border: none; border-radius: 8px; cursor: pointer; color: #9CA3AF;"><i class="fas fa-chevron-left"></i><i class="fas fa-chevron-left"></i></button>
        <button style="padding: 8px 12px; background: #F3F4F6; border: none; border-radius: 8px; cursor: pointer; color: #9CA3AF;"><i class="fas fa-chevron-left"></i></button>
        <button style="padding: 8px 15px; background: #5D10A2; color: white; border: none; border-radius: 8px; font-weight: 700; cursor: pointer;">1</button>
        <button style="padding: 8px 12px; background: #F3F4F6; border: none; border-radius: 8px; cursor: pointer; color: #9CA3AF;"><i class="fas fa-chevron-right"></i></button>
    </div>
</div>
@endsection