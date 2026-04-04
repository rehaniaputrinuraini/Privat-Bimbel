{{-- =============================================
     Dashboard Shared - Pembayaran
     File: resources/views/dashboard/shared/pembayaran/pembayaran.blade.php
============================================= --}}

@extends('layouts.app')

@section('title', 'Pembayaran')

@push('styles')
<style>
    /* Hilangkan panah default browser pada select */
    .filter-select {
        
        -webkit-
        -moz-
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%239CA3AF' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 14px center;
        padding-right: 38px !important;
    }

    /* Tab aktif & non aktif */
    .tab-item {
        flex: 1;
        padding: 14px 20px;
        cursor: pointer;
        font-weight: 700;
        font-size: 15px;
        text-align: center;
        position: relative;
        bottom: -2px;
        transition: 0.3s;
        color: #9CA3AF;
    }
</style>
@endpush

@section('content')
<div x-data="{ tab: 'tagihan' }" style="width: 100%;">

    {{-- ── 1. HEADER HALAMAN ── --}}
    <div style="margin-bottom: 25px;">
        <p style="color: #374151; font-size: 13px; margin: 0 0 4px 0;">
            {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}
        </p>
        <h1 style="font-size: 26px; font-weight: 700; color: #111827; margin: 0; letter-spacing: -0.5px; line-height: 1.2;">
            Pembayaran
        </h1>
        <p style="color: #374151; font-size: 14px; margin: 4px 0 0 0;">Kelola Pembayaran Murid dan Riwayat Pembayaran</p>
    </div>

    {{-- ── 2. ACTIONS BAR ── --}}
    <div style="display: flex; justify-content: flex-end; align-items: center; margin-bottom: 25px;">
        <a href="{{ route($role . '.pembayaran.create') }}" style="text-decoration: none;">
            <button style="background-color: #4D0B87; color: white; border: none; padding: 12px 25px; border-radius: 12px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 10px; font-size: 14px; transition: 0.3s; box-shadow: 0 4px 6px rgba(77, 11, 135, 0.2);">
                <i class="fas fa-plus"></i> Input Pembayaran Murid
            </button>
        </a>
    </div>

    {{-- ── 3. NAVIGASI TAB (TENGAH, RATA) ── --}}
    <div style="display: flex; width: 100%; border-bottom: 2px solid #E5E7EB; margin-bottom: 25px;">
        <div class="tab-item"
             @click="tab = 'tagihan'"
             :style="tab === 'tagihan' ? 'border-bottom: 3px solid #4D0B87; color: #4D0B87;' : 'color: #9CA3AF;'">
            Tagihan Murid
        </div>
        <div class="tab-item"
             @click="tab = 'riwayat'"
             :style="tab === 'riwayat' ? 'border-bottom: 3px solid #4D0B87; color: #4D0B87;' : 'color: #9CA3AF;'">
            Riwayat Pembayaran
        </div>
    </div>

    {{-- ── TAB 1: TAGIHAN MURID ── --}}
    <div x-show="tab === 'tagihan'" x-transition:enter.duration.300ms>

        {{-- Filter Card --}}
        <div style="background: white; border-radius: 16px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.06); border: 1px solid #F3F4F6; margin-bottom: 20px;">
            <div style="position: relative; margin-bottom: 12px;">
                <i class="fas fa-search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #9CA3AF;"></i>
                <input type="text" placeholder="Cari"
                       style="width: 100%; padding: 12px 15px 12px 45px; border-radius: 12px; border: 1px solid #E5E7EB; outline: none; background: #F9FAFB; font-size: 14px; color: #374151;">
            </div>
            <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                <select class="filter-select" style="flex: 1; padding: 10px 14px; border-radius: 12px; border: 1px solid #E5E7EB; color: #374151; font-size: 13px; background: #F9FAFB; outline: none; cursor: pointer; min-width: 150px;">
                    <option value="">Status Paket</option>
                    <option value="SD">SD</option>
                    <option value="SMP">SMP</option>
                    <option value="SMA">SMA</option>
                </select>
                <select class="filter-select" style="flex: 1; padding: 10px 14px; border-radius: 12px; border: 1px solid #E5E7EB; color: #374151; font-size: 13px; background: #F9FAFB; outline: none; cursor: pointer; min-width: 150px;">
                    <option value="">Status Pembayaran</option>
                    <option value="Lunas">Lunas</option>
                    <option value="Belum">Belum</option>
                </select>
                <select class="filter-select" style="flex: 1; padding: 10px 14px; border-radius: 12px; border: 1px solid #E5E7EB; color: #374151; font-size: 13px; background: #F9FAFB; outline: none; cursor: pointer; min-width: 150px;">
                    <option value="">Status Tagihan</option>
                    <option value="Lunas">Lunas</option>
                    <option value="Tunggak">Tunggak</option>
                    <option value="Uang Muka">Uang Muka</option>
                </select>
            </div>
        </div>

        {{-- Tabel Tagihan --}}
        <div style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.08); border: 1px solid #F3F4F6;">
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 13px; white-space: nowrap;">
                    <thead>
                        <tr style="background: #F3E8FF; color: #111827;">
                            <th style="padding: 15px; font-weight: 700; width: 50px;">No</th>
                            <th style="padding: 15px; font-weight: 700;">Nama Lengkap</th>
                            <th style="padding: 15px; font-weight: 700;">Kelas</th>
                            <th style="padding: 15px; font-weight: 700;">Status Paket</th>
                            <th style="padding: 15px; font-weight: 700; text-align: center;">Status Pembayaran</th>
                            <th style="padding: 15px; font-weight: 700; text-align: center;">Status Tagihan</th>
                            <th style="padding: 15px; font-weight: 700; text-align: center;">Total Bulan</th>
                            <th style="padding: 15px; font-weight: 700; text-align: center;">Total Piutang</th>
                            <th style="padding: 15px; font-weight: 700; text-align: center;">Total Uang Muka</th>
                        </tr>
                    </thead>
                    <tbody style="color: #374151;">
                        @php
                            $tagihan = [
                                ['no' => 1, 'nama' => 'Rehan Putri', 'kelas' => '5.1', 'paket' => 'SD', 'status_pembayaran' => 'Lunas',  'status_tagihan' => 'Lunas',           'total_bulan' => '-', 'total_piutang' => '-',          'uang_muka' => '-'],
                                ['no' => 2, 'nama' => 'Rehan Putri', 'kelas' => '5.1', 'paket' => 'SD', 'status_pembayaran' => 'Belum',  'status_tagihan' => 'Tunggak 1 Bln',   'total_bulan' => '1', 'total_piutang' => 'Rp 120.000',  'uang_muka' => '-'],
                                ['no' => 3, 'nama' => 'Rehan Putri', 'kelas' => '5.1', 'paket' => 'SD', 'status_pembayaran' => 'Lunas',  'status_tagihan' => 'Tunggak 3+ Bln',  'total_bulan' => '3', 'total_piutang' => 'Rp 360.000',  'uang_muka' => '-'],
                                ['no' => 4, 'nama' => 'Rehan Putri', 'kelas' => '5.1', 'paket' => 'SD', 'status_pembayaran' => 'Lunas',  'status_tagihan' => 'Uang Muka 1 Bln', 'total_bulan' => '-', 'total_piutang' => '-',          'uang_muka' => '120.000'],
                                ['no' => 5, 'nama' => 'Rehan Putri', 'kelas' => '5.1', 'paket' => 'SD', 'status_pembayaran' => 'Lunas',  'status_tagihan' => 'Lunas',           'total_bulan' => '-', 'total_piutang' => '-',          'uang_muka' => '-'],
                                ['no' => 6, 'nama' => 'Rehan Putri', 'kelas' => '5.1', 'paket' => 'SD', 'status_pembayaran' => 'Belum',  'status_tagihan' => 'Tunggak 1 Bln',   'total_bulan' => '1', 'total_piutang' => 'Rp 120.000',  'uang_muka' => '-'],
                                ['no' => 7, 'nama' => 'Rehan Putri', 'kelas' => '5.1', 'paket' => 'SD', 'status_pembayaran' => 'Lunas',  'status_tagihan' => 'Tunggak 3+ Bln',  'total_bulan' => '3', 'total_piutang' => 'Rp 360.000',  'uang_muka' => '-'],
                                ['no' => 8, 'nama' => 'Rehan Putri', 'kelas' => '5.1', 'paket' => 'SD', 'status_pembayaran' => 'Lunas',  'status_tagihan' => 'Uang Muka 1 Bln', 'total_bulan' => '-', 'total_piutang' => '-',          'uang_muka' => '120.000'],
                            ];
                        @endphp

                        @foreach($tagihan as $t)
                        <tr style="border-bottom: 1px solid #F3F4F6; transition: 0.2s;"
                            onmouseover="this.style.background='#F9FAFB'"
                            onmouseout="this.style.background='transparent'">
                            <td style="padding: 15px;">{{ $t['no'] }}</td>
                            <td style="padding: 15px;">{{ $t['nama'] }}</td>
                            <td style="padding: 15px;">{{ $t['kelas'] }}</td>
                            <td style="padding: 15px;">{{ $t['paket'] }}</td>
                            <td style="padding: 15px; text-align: center;">
                                @if($t['status_pembayaran'] == 'Lunas')
                                    <span style="padding: 5px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; background: #E1F7E3; color: #0E7490;">Lunas</span>
                                @else
                                    <span style="padding: 5px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; background: #FEE2E2; color: #EF4444;">Belum</span>
                                @endif
                            </td>
                            <td style="padding: 15px; text-align: center;">
                                @if($t['status_tagihan'] == 'Lunas')
                                    <span style="padding: 5px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; background: #E1F7E3; color: #0E7490;">Lunas</span>
                                @elseif(str_contains($t['status_tagihan'], 'Tunggak'))
                                    <span style="padding: 5px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; background: #FEF3C7; color: #92400E;">{{ $t['status_tagihan'] }}</span>
                                @else
                                    <span style="padding: 5px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; background: #E0E7FF; color: #4338CA;">{{ $t['status_tagihan'] }}</span>
                                @endif
                            </td>
                            <td style="padding: 15px; text-align: center;">{{ $t['total_bulan'] }}</td>
                            <td style="padding: 15px; text-align: center; {{ $t['total_piutang'] != '-' ? 'font-weight: 700; color: #EF4444;' : '' }}">{{ $t['total_piutang'] }}</td>
                            <td style="padding: 15px; text-align: center;">{{ $t['uang_muka'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination Tagihan --}}
        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px; padding: 0 5px;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <select class="filter-select" style="padding: 8px 12px; border-radius: 10px; border: 1px solid #E5E7EB; color: #374151; font-size: 13px; background: white; outline: none; cursor: pointer;">
                    <option value="10">10 baris</option>
                    <option value="25">25 baris</option>
                    <option value="50">50 baris</option>
                </select>
                <span style="color: #374151; font-size: 13px;">Menampilkan {{ count($tagihan) }} data</span>
            </div>
            <div style="display: flex; gap: 5px;">
                <button style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; cursor: pointer;"><i class="fas fa-angle-double-left"></i></button>
                <button style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; cursor: pointer;"><i class="fas fa-angle-left"></i></button>
                <button style="width: 35px; height: 35px; border-radius: 8px; background: #4D0B87; color: white; border: none; font-weight: 600; cursor: pointer;">1</button>
                <button style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; cursor: pointer;"><i class="fas fa-angle-right"></i></button>
            </div>
        </div>

    </div>

    {{-- ── TAB 2: RIWAYAT PEMBAYARAN ── --}}
    <div x-show="tab === 'riwayat'" x-transition:enter.duration.300ms>

        {{-- Filter Card --}}
        <div style="background: white; border-radius: 16px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.06); border: 1px solid #F3F4F6; margin-bottom: 20px;">
            <div style="position: relative; margin-bottom: 12px;">
                <i class="fas fa-search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #9CA3AF;"></i>
                <input type="text" placeholder="Cari"
                       style="width: 100%; padding: 12px 15px 12px 45px; border-radius: 12px; border: 1px solid #E5E7EB; outline: none; background: #F9FAFB; font-size: 14px; color: #374151;">
            </div>
            <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                <select class="filter-select" style="flex: 1; padding: 10px 14px; border-radius: 12px; border: 1px solid #E5E7EB; color: #374151; font-size: 13px; background: #F9FAFB; outline: none; cursor: pointer; min-width: 150px;">
                    <option value="">Status Paket</option>
                    <option value="SD">SD</option>
                    <option value="SMP">SMP</option>
                    <option value="SMA">SMA</option>
                </select>
                <select class="filter-select" style="flex: 1; padding: 10px 14px; border-radius: 12px; border: 1px solid #E5E7EB; color: #374151; font-size: 13px; background: #F9FAFB; outline: none; cursor: pointer; min-width: 150px;">
                    <option value="">Pilih Bulan</option>
                    <option value="1">Januari</option>
                    <option value="2">Februari</option>
                    <option value="3">Maret</option>
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
                <select class="filter-select" style="flex: 1; padding: 10px 14px; border-radius: 12px; border: 1px solid #E5E7EB; color: #374151; font-size: 13px; background: #F9FAFB; outline: none; cursor: pointer; min-width: 150px;">
                    <option value="">Pilih Tahun</option>
                    <option value="2024">2024</option>
                    <option value="2025">2025</option>
                    <option value="2026" selected>2026</option>
                </select>
            </div>
        </div>

        {{-- Tabel Riwayat --}}
        <div style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.08); border: 1px solid #F3F4F6;">
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 13px; white-space: nowrap;">
                    <thead>
                        <tr style="background: #F3E8FF; color: #111827;">
                            <th style="padding: 15px; font-weight: 700; width: 50px;">No</th>
                            <th style="padding: 15px; font-weight: 700;">Tanggal</th>
                            <th style="padding: 15px; font-weight: 700;">Nama Murid</th>
                            <th style="padding: 15px; font-weight: 700;">Paket Awal</th>
                            <th style="padding: 15px; font-weight: 700;">Paket Selanjutnya</th>
                            <th style="padding: 15px; font-weight: 700; text-align: center;">Total Bayar</th>
                            <th style="padding: 15px; font-weight: 700;">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody style="color: #374151;">
                        <tr style="border-bottom: 1px solid #F3F4F6; transition: 0.2s;"
                            onmouseover="this.style.background='#F9FAFB'"
                            onmouseout="this.style.background='transparent'">
                            <td style="padding: 15px;">1</td>
                            <td style="padding: 15px;">12/02/2026</td>
                            <td style="padding: 15px;">Rehan Putri</td>
                            <td style="padding: 15px;">100.000</td>
                            <td style="padding: 15px;">SD</td>
                            <td style="padding: 15px; text-align: center; font-weight: 700; color: #4D0B87;">Rp 120.000</td>
                            <td style="padding: 15px;">Pembayaran Paket Januari</td>
                        </tr>
                        <tr style="border-bottom: 1px solid #F3F4F6; transition: 0.2s;"
                            onmouseover="this.style.background='#F9FAFB'"
                            onmouseout="this.style.background='transparent'">
                            <td style="padding: 15px;">2</td>
                            <td style="padding: 15px;">15/03/2026</td>
                            <td style="padding: 15px;">Budi Santoso</td>
                            <td style="padding: 15px;">100.000</td>
                            <td style="padding: 15px;">SD</td>
                            <td style="padding: 15px; text-align: center; font-weight: 700; color: #4D0B87;">Rp 120.000</td>
                            <td style="padding: 15px;">Pembayaran Paket Februari</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination Riwayat --}}
        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px; padding: 0 5px;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <select class="filter-select" style="padding: 8px 12px; border-radius: 10px; border: 1px solid #E5E7EB; color: #374151; font-size: 13px; background: white; outline: none; cursor: pointer;">
                    <option value="10">10 baris</option>
                    <option value="25">25 baris</option>
                    <option value="50">50 baris</option>
                </select>
                <span style="color: #374151; font-size: 13px;">Menampilkan 2 data</span>
            </div>
            <div style="display: flex; gap: 5px;">
                <button style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; cursor: pointer;"><i class="fas fa-angle-double-left"></i></button>
                <button style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; cursor: pointer;"><i class="fas fa-angle-left"></i></button>
                <button style="width: 35px; height: 35px; border-radius: 8px; background: #4D0B87; color: white; border: none; font-weight: 600; cursor: pointer;">1</button>
                <button style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; cursor: pointer;"><i class="fas fa-angle-right"></i></button>
            </div>
        </div>

    </div>

</div>

<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endsection