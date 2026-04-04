{{-- =============================================
     Dashboard Shared - Laporan Keuangan
     File: resources/views/dashboard/shared/laporan-keuangan/laporan-keuangan.blade.php
============================================= --}}

@extends('layouts.app')

@section('title', 'Laporan Keuangan')

@push('styles')
<style>
    .filter-select {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='10' viewBox='0 0 24 24' fill='none' stroke='%236B7280' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
        background-size: 12px 12px;
        padding-right: 36px !important;
    }
</style>
@endpush

@section('content')
<div style="width: 100%;">

    @php $role = $role ?? (Auth::user()->peran); @endphp

    {{-- ── 1. HEADER HALAMAN (sama style Kelola Admin) ── --}}
    <div style="margin-bottom: 25px;">
        <p style="color: #374151; font-size: 13px; margin: 0 0 4px 0;">
            {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}
        </p>
        <h1 style="font-size: 26px; font-weight: 700; color: #111827; margin: 0; letter-spacing: -0.5px; line-height: 1.2;">
            Laporan Keuangan
        </h1>
        <p style="color: #374151; font-size: 14px; margin: 4px 0 0 0;">Data Laporan Arus Kas Masuk dan Keluar</p>
    </div>

    {{-- ── 2. RINGKASAN KARTU ── --}}
    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 30px;">
        <div style="background: white; padding: 20px; border-radius: 15px; border-left: 8px solid #4472DF; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
            <p style="margin: 0; color: #4472DF; font-weight: 700; font-size: 13px;">Pemasukan Periode Berjalan</p>
            <h3 style="margin: 10px 0 0; font-size: 20px; font-weight: 800; color: #4472DF;">Rp. 1.000.000</h3>
        </div>
        <div style="background: white; padding: 20px; border-radius: 15px; border-left: 8px solid #D74E4E; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
            <p style="margin: 0; color: #D74E4E; font-weight: 700; font-size: 13px;">Pengeluaran Periode Berjalan</p>
            <h3 style="margin: 10px 0 0; font-size: 20px; font-weight: 800; color: #D74E4E;">Rp. 500.000</h3>
        </div>
        <div style="background: white; padding: 20px; border-radius: 15px; border-left: 8px solid #E7C255; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
            <p style="margin: 0; color: #E7C255; font-weight: 700; font-size: 13px;">Pelunasan Piutang</p>
            <h3 style="margin: 10px 0 0; font-size: 20px; font-weight: 800; color: #E7C255;">Rp. 1.000.000</h3>
        </div>
        <div style="background: white; padding: 20px; border-radius: 15px; border-left: 8px solid #4AB462; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
            <p style="margin: 0; color: #4AB462; font-weight: 700; font-size: 13px;">Pendapatan Uang Dimuka</p>
            <h3 style="margin: 10px 0 0; font-size: 20px; font-weight: 800; color: #4AB462;">Rp. 300.000</h3>
        </div>
        <div style="background: white; padding: 20px; border-radius: 15px; border-left: 8px solid #ACB2AD; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
            <p style="margin: 0; color: #ACB2AD; font-weight: 700; font-size: 13px;">Total Pemasukan Kas</p>
            <h3 style="margin: 10px 0 0; font-size: 20px; font-weight: 800; color: #ACB2AD;">Rp. 1.800.000</h3>
        </div>
        <div style="background: white; padding: 20px; border-radius: 15px; border-left: 8px solid #4D0B87; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
            <p style="margin: 0; color: #4D0B87; font-weight: 700; font-size: 13px;">Saldo Kas</p>
            <h3 style="margin: 10px 0 0; font-size: 20px; font-weight: 800; color: #4D0B87;">Rp. 500.000</h3>
        </div>
    </div>

    {{-- ── 3. FILTER & TOMBOL TAMBAH ── --}}
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; gap: 15px;">
        <div style="display: flex; align-items: center; gap: 12px; flex: 1;">

            {{-- Search --}}
            <div style="position: relative; width: 280px;">
                <i class="fas fa-search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #9CA3AF;"></i>
                <input type="text" placeholder="Cari..."
                       style="width: 100%; padding: 10px 15px 10px 45px; border-radius: 12px; border: 1px solid #E5E7EB; outline: none; background: white; font-size: 14px; color: #374151;">
            </div>

            {{-- Filter Bulan --}}
            <select class="filter-select" style="padding: 10px 12px; border-radius: 12px; border: 1px solid #E5E7EB; color: #374151; font-size: 13px; min-width: 140px; background: white; outline: none; cursor: pointer;">
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
            <select class="filter-select" style="padding: 10px 12px; border-radius: 12px; border: 1px solid #E5E7EB; color: #374151; font-size: 13px; min-width: 120px; background: white; outline: none; cursor: pointer;">
                <option value="">--- Tahun ---</option>
                <option value="2024">2024</option>
                <option value="2025">2025</option>
                <option value="2026" selected>2026</option>
            </select>

            {{-- Filter Kategori --}}
            <select class="filter-select" style="padding: 10px 12px; border-radius: 12px; border: 1px solid #E5E7EB; color: #374151; font-size: 13px; min-width: 150px; background: white; outline: none; cursor: pointer;">
                <option value="">--- Kategori ---</option>
                <option value="pemasukan">Pemasukan</option>
                <option value="pengeluaran">Pengeluaran</option>
                <option value="piutang">Piutang</option>
                <option value="uang_muka">Uang Dimuka</option>
            </select>
        </div>

        <a href="{{ route($role . '.laporan-keuangan.create') }}" style="text-decoration: none;">
            <button style="background-color: #4D0B87; color: white; border: none; padding: 12px 25px; border-radius: 12px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 10px; font-size: 14px; transition: 0.3s; box-shadow: 0 4px 6px rgba(77, 11, 135, 0.2);">
                <i class="fas fa-plus"></i> Tambah
            </button>
        </a>
    </div>

    {{-- ── 4. TABEL-TABEL LAPORAN ── --}}

    {{-- TABEL 1: PEMASUKAN --}}
    @php
        $pemasukan = [
            ['no' => 1, 'tanggal' => '9 Feb 2026', 'rincian' => 'Pembayaran Murid Paket SD',  'jumlah' => 'Rp 5.000.000'],
            ['no' => 2, 'tanggal' => '9 Feb 2026', 'rincian' => 'Pembayaran Murid Paket SMP', 'jumlah' => 'Rp 10.000.000'],
            ['no' => 3, 'tanggal' => '9 Feb 2026', 'rincian' => 'Pembayaran Murid Paket Awal','jumlah' => 'Rp 4.000.000'],
        ];
        $pengeluaran = [
            ['no' => 1, 'tanggal' => '9 Feb 2026', 'rincian' => 'Gaji Tentor',  'jumlah' => 'Rp 2.500.000'],
            ['no' => 2, 'tanggal' => '9 Feb 2026', 'rincian' => 'Sewa Tempat',  'jumlah' => 'Rp 400.000'],
            ['no' => 3, 'tanggal' => '9 Feb 2026', 'rincian' => 'Bayar Wifi',   'jumlah' => 'Rp 100.000'],
        ];
        $piutang = [
            ['no' => 1, 'tanggal' => '9 Feb 2026', 'nama' => 'Satoru Goju', 'bulan' => 'Januari 2026, Februari 2026', 'jumlah' => 'Rp 150.000'],
            ['no' => 2, 'tanggal' => '9 Feb 2026', 'nama' => 'Jaden',       'bulan' => 'Februari 2026',               'jumlah' => 'Rp 100.000'],
            ['no' => 3, 'tanggal' => '9 Feb 2026', 'nama' => 'Marselino',   'bulan' => 'Maret 2026',                  'jumlah' => 'Rp 150.000'],
        ];
        $uang_muka = [
            ['no' => 1, 'tanggal' => '9 Feb 2026', 'nama' => 'Satoru Goju', 'periode' => 'Jan-Feb 2026',  'jumlah' => 'Rp 240.000'],
            ['no' => 2, 'tanggal' => '9 Feb 2026', 'nama' => 'Jaden',       'periode' => 'Jan-Mar 2026',  'jumlah' => 'Rp 360.000'],
            ['no' => 3, 'tanggal' => '9 Feb 2026', 'nama' => 'Marselino',   'periode' => 'Jan-Apr 2026',  'jumlah' => 'Rp 480.000'],
        ];
    @endphp

    {{-- TABEL PEMASUKAN --}}
    <div style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.08); border: 1px solid #F3F4F6; margin-bottom: 25px;">
        <div style="padding: 20px 20px 15px;">
            <h4 style="margin: 0; font-size: 15px; font-weight: 700; color: #111827;">Riwayat Pemasukan Periode Berjalan</h4>
        </div>
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 13px; white-space: nowrap;">
                <thead>
                    <tr style="background: #A2B9EE; color: #111827;">
                        <th style="padding: 15px; font-weight: 700; text-align: center; width: 50px;">No</th>
                        <th style="padding: 15px; font-weight: 700;">Tanggal</th>
                        <th style="padding: 15px; font-weight: 700;">Rincian Pemasukan</th>
                        <th style="padding: 15px; font-weight: 700; text-align: right;">Jumlah</th>
                    </tr>
                </thead>
                <tbody style="color: #374151;">
                    @foreach($pemasukan as $p)
                    <tr style="border-bottom: 1px solid #F3F4F6; background: #F0F4FF; transition: 0.2s;"
                        onmouseover="this.style.background='#E0EAFF'"
                        onmouseout="this.style.background='#F0F4FF'">
                        <td style="padding: 15px; text-align: center;">{{ $p['no'] }}</td>
                        <td style="padding: 15px;">{{ $p['tanggal'] }}</td>
                        <td style="padding: 15px;">{{ $p['rincian'] }}</td>
                        <td style="padding: 15px; text-align: right; font-weight: 700; color: #4472DF;">{{ $p['jumlah'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div style="display: flex; justify-content: space-between; align-items: center; padding: 15px 20px; border-top: 2px solid #F3F4F6;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <select class="filter-select" style="padding: 7px 10px; border-radius: 8px; border: 1px solid #E5E7EB; color: #374151; font-size: 12px; background: white; outline: none; cursor: pointer;">
                    <option>10 baris</option><option>25 baris</option><option>50 baris</option>
                </select>
            </div>
            <div style="display: flex; gap: 4px;">
                <button style="width: 30px; height: 30px; border-radius: 6px; border: 1px solid #E5E7EB; background: white; color: #374151; cursor: pointer; font-size: 11px;"><i class="fas fa-angle-double-left"></i></button>
                <button style="width: 30px; height: 30px; border-radius: 6px; border: 1px solid #E5E7EB; background: white; color: #374151; cursor: pointer; font-size: 11px;"><i class="fas fa-angle-left"></i></button>
                <button style="width: 30px; height: 30px; border-radius: 6px; background: #4472DF; color: white; border: none; font-weight: 600; cursor: pointer; font-size: 12px;">1</button>
                <button style="width: 30px; height: 30px; border-radius: 6px; border: 1px solid #E5E7EB; background: white; color: #374151; cursor: pointer; font-size: 11px;"><i class="fas fa-angle-right"></i></button>
            </div>
        </div>
        <div style="display: flex; justify-content: space-between; padding: 15px 20px; background: #F9FAFB; border-top: 1px solid #F3F4F6;">
            <span style="font-size: 14px; font-weight: 700; color: #111827;">Total Pemasukan Periode Berjalan</span>
            <span style="font-size: 15px; font-weight: 800; color: #4472DF;">Rp 19.000.000</span>
        </div>
    </div>

    {{-- TABEL PENGELUARAN --}}
    <div style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.08); border: 1px solid #F3F4F6; margin-bottom: 25px;">
        <div style="padding: 20px 20px 15px;">
            <h4 style="margin: 0; font-size: 15px; font-weight: 700; color: #111827;">Riwayat Pengeluaran Periode Berjalan</h4>
        </div>
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 13px; white-space: nowrap;">
                <thead>
                    <tr style="background: #EEA2A2; color: #111827;">
                        <th style="padding: 15px; font-weight: 700; text-align: center; width: 50px;">No</th>
                        <th style="padding: 15px; font-weight: 700;">Tanggal</th>
                        <th style="padding: 15px; font-weight: 700;">Rincian Pengeluaran</th>
                        <th style="padding: 15px; font-weight: 700; text-align: right;">Jumlah</th>
                    </tr>
                </thead>
                <tbody style="color: #374151;">
                    @foreach($pengeluaran as $p)
                    <tr style="border-bottom: 1px solid #F3F4F6; background: #FFF0F0; transition: 0.2s;"
                        onmouseover="this.style.background='#FFE0E0'"
                        onmouseout="this.style.background='#FFF0F0'">
                        <td style="padding: 15px; text-align: center;">{{ $p['no'] }}</td>
                        <td style="padding: 15px;">{{ $p['tanggal'] }}</td>
                        <td style="padding: 15px;">{{ $p['rincian'] }}</td>
                        <td style="padding: 15px; text-align: right; font-weight: 700; color: #D74E4E;">{{ $p['jumlah'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div style="display: flex; justify-content: space-between; align-items: center; padding: 15px 20px; border-top: 2px solid #F3F4F6;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <select class="filter-select" style="padding: 7px 10px; border-radius: 8px; border: 1px solid #E5E7EB; color: #374151; font-size: 12px; background: white; outline: none; cursor: pointer;">
                    <option>10 baris</option><option>25 baris</option><option>50 baris</option>
                </select>
            </div>
            <div style="display: flex; gap: 4px;">
                <button style="width: 30px; height: 30px; border-radius: 6px; border: 1px solid #E5E7EB; background: white; color: #374151; cursor: pointer; font-size: 11px;"><i class="fas fa-angle-double-left"></i></button>
                <button style="width: 30px; height: 30px; border-radius: 6px; border: 1px solid #E5E7EB; background: white; color: #374151; cursor: pointer; font-size: 11px;"><i class="fas fa-angle-left"></i></button>
                <button style="width: 30px; height: 30px; border-radius: 6px; background: #D74E4E; color: white; border: none; font-weight: 600; cursor: pointer; font-size: 12px;">1</button>
                <button style="width: 30px; height: 30px; border-radius: 6px; border: 1px solid #E5E7EB; background: white; color: #374151; cursor: pointer; font-size: 11px;"><i class="fas fa-angle-right"></i></button>
            </div>
        </div>
        <div style="display: flex; justify-content: space-between; padding: 15px 20px; background: #F9FAFB; border-top: 1px solid #F3F4F6;">
            <span style="font-size: 14px; font-weight: 700; color: #111827;">Total Pengeluaran Periode Berjalan</span>
            <span style="font-size: 15px; font-weight: 800; color: #D74E4E;">Rp 3.000.000</span>
        </div>
    </div>

    {{-- TABEL PIUTANG --}}
    <div style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.08); border: 1px solid #F3F4F6; margin-bottom: 25px;">
        <div style="padding: 20px 20px 15px;">
            <h4 style="margin: 0; font-size: 15px; font-weight: 700; color: #111827;">Riwayat Pelunasan Piutang (Tunggakan)</h4>
        </div>
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 13px; white-space: nowrap;">
                <thead>
                    <tr style="background: #EEDCA2; color: #111827;">
                        <th style="padding: 15px; font-weight: 700; text-align: center; width: 50px;">No</th>
                        <th style="padding: 15px; font-weight: 700;">Tanggal</th>
                        <th style="padding: 15px; font-weight: 700;">Nama Murid</th>
                        <th style="padding: 15px; font-weight: 700;">Bulan Tagihan</th>
                        <th style="padding: 15px; font-weight: 700; text-align: right;">Jumlah</th>
                    </tr>
                </thead>
                <tbody style="color: #374151;">
                    @foreach($piutang as $p)
                    <tr style="border-bottom: 1px solid #F3F4F6; background: #FFFDF0; transition: 0.2s;"
                        onmouseover="this.style.background='#FFF8D0'"
                        onmouseout="this.style.background='#FFFDF0'">
                        <td style="padding: 15px; text-align: center;">{{ $p['no'] }}</td>
                        <td style="padding: 15px;">{{ $p['tanggal'] }}</td>
                        <td style="padding: 15px;">{{ $p['nama'] }}</td>
                        <td style="padding: 15px;">{{ $p['bulan'] }}</td>
                        <td style="padding: 15px; text-align: right; font-weight: 700; color: #E7C255;">{{ $p['jumlah'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div style="display: flex; justify-content: space-between; align-items: center; padding: 15px 20px; border-top: 2px solid #F3F4F6;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <select class="filter-select" style="padding: 7px 10px; border-radius: 8px; border: 1px solid #E5E7EB; color: #374151; font-size: 12px; background: white; outline: none; cursor: pointer;">
                    <option>10 baris</option><option>25 baris</option><option>50 baris</option>
                </select>
            </div>
            <div style="display: flex; gap: 4px;">
                <button style="width: 30px; height: 30px; border-radius: 6px; border: 1px solid #E5E7EB; background: white; color: #374151; cursor: pointer; font-size: 11px;"><i class="fas fa-angle-double-left"></i></button>
                <button style="width: 30px; height: 30px; border-radius: 6px; border: 1px solid #E5E7EB; background: white; color: #374151; cursor: pointer; font-size: 11px;"><i class="fas fa-angle-left"></i></button>
                <button style="width: 30px; height: 30px; border-radius: 6px; background: #E7C255; color: white; border: none; font-weight: 600; cursor: pointer; font-size: 12px;">1</button>
                <button style="width: 30px; height: 30px; border-radius: 6px; border: 1px solid #E5E7EB; background: white; color: #374151; cursor: pointer; font-size: 11px;"><i class="fas fa-angle-right"></i></button>
            </div>
        </div>
        <div style="display: flex; justify-content: space-between; padding: 15px 20px; background: #F9FAFB; border-top: 1px solid #F3F4F6;">
            <span style="font-size: 14px; font-weight: 700; color: #111827;">Total Pemasukan Piutang (Tunggakan)</span>
            <span style="font-size: 15px; font-weight: 800; color: #E7C255;">Rp 400.000</span>
        </div>
    </div>

    {{-- TABEL UANG MUKA --}}
    <div style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.08); border: 1px solid #F3F4F6; margin-bottom: 25px;">
        <div style="padding: 20px 20px 15px;">
            <h4 style="margin: 0; font-size: 15px; font-weight: 700; color: #111827;">Riwayat Pendapatan Uang Dimuka</h4>
        </div>
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 13px; white-space: nowrap;">
                <thead>
                    <tr style="background: #A2EEB9; color: #111827;">
                        <th style="padding: 15px; font-weight: 700; text-align: center; width: 50px;">No</th>
                        <th style="padding: 15px; font-weight: 700;">Tanggal</th>
                        <th style="padding: 15px; font-weight: 700;">Nama Murid</th>
                        <th style="padding: 15px; font-weight: 700;">Periode Pembayaran</th>
                        <th style="padding: 15px; font-weight: 700; text-align: right;">Jumlah</th>
                    </tr>
                </thead>
                <tbody style="color: #374151;">
                    @foreach($uang_muka as $u)
                    <tr style="border-bottom: 1px solid #F3F4F6; background: #F0FFF4; transition: 0.2s;"
                        onmouseover="this.style.background='#DCFCE7'"
                        onmouseout="this.style.background='#F0FFF4'">
                        <td style="padding: 15px; text-align: center;">{{ $u['no'] }}</td>
                        <td style="padding: 15px;">{{ $u['tanggal'] }}</td>
                        <td style="padding: 15px;">{{ $u['nama'] }}</td>
                        <td style="padding: 15px;">{{ $u['periode'] }}</td>
                        <td style="padding: 15px; text-align: right; font-weight: 700; color: #4AB462;">{{ $u['jumlah'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div style="display: flex; justify-content: space-between; align-items: center; padding: 15px 20px; border-top: 2px solid #F3F4F6;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <select class="filter-select" style="padding: 7px 10px; border-radius: 8px; border: 1px solid #E5E7EB; color: #374151; font-size: 12px; background: white; outline: none; cursor: pointer;">
                    <option>10 baris</option><option>25 baris</option><option>50 baris</option>
                </select>
            </div>
            <div style="display: flex; gap: 4px;">
                <button style="width: 30px; height: 30px; border-radius: 6px; border: 1px solid #E5E7EB; background: white; color: #374151; cursor: pointer; font-size: 11px;"><i class="fas fa-angle-double-left"></i></button>
                <button style="width: 30px; height: 30px; border-radius: 6px; border: 1px solid #E5E7EB; background: white; color: #374151; cursor: pointer; font-size: 11px;"><i class="fas fa-angle-left"></i></button>
                <button style="width: 30px; height: 30px; border-radius: 6px; background: #4AB462; color: white; border: none; font-weight: 600; cursor: pointer; font-size: 12px;">1</button>
                <button style="width: 30px; height: 30px; border-radius: 6px; border: 1px solid #E5E7EB; background: white; color: #374151; cursor: pointer; font-size: 11px;"><i class="fas fa-angle-right"></i></button>
            </div>
        </div>
        <div style="display: flex; justify-content: space-between; padding: 15px 20px; background: #F9FAFB; border-top: 1px solid #F3F4F6;">
            <span style="font-size: 14px; font-weight: 700; color: #111827;">Total Pendapatan Uang Dimuka</span>
            <span style="font-size: 15px; font-weight: 800; color: #4AB462;">Rp 1.080.000</span>
        </div>
    </div>

    {{-- ── 5. TOMBOL EXPORT PDF ── --}}
    <button style="width: 100%; background: #22C55E; color: white; border: none; padding: 18px; border-radius: 15px; font-size: 16px; font-weight: 700; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 12px; margin-bottom: 30px; transition: 0.3s; box-shadow: 0 4px 15px rgba(34, 197, 94, 0.3);"
        onmouseover="this.style.background='#16A34A'"
        onmouseout="this.style.background='#22C55E'">
        <i class="fas fa-file-pdf" style="font-size: 20px;"></i> EXPORT PDF
    </button>

</div>
@endsection