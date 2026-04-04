{{-- =============================================
     Dashboard Shared - Laporan Keuangan (FINAL REVISI)
     File: resources/views/dashboard/shared/laporan-keuangan/index.blade.php
============================================= --}}

@extends('layouts.app')

@section('title', 'Laporan Keuangan')

@section('content')
<div style="width: 100%;">
    {{-- Inisialisasi Role --}}
    @php $role = $role ?? (Auth::user()->peran); @endphp

    {{-- ── 1. HEADER HALAMAN (26px - Konsisten) ── --}}
    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 25px;">
        <div>
            <p style="color: #6B7280; font-size: 13px; margin: 0 0 4px 0;">
                {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}
            </p>
            <h1 style="font-size: 26px; font-weight: 700; color: #111827; margin: 0; letter-spacing: -0.5px; line-height: 1.2;">
                Laporan Keuangan
            </h1>
            <p style="color: #6B7280; font-size: 14px; margin: 4px 0 0 0;">Data Arus Kas Masuk dan Keluar</p>
        </div>
        
        <a href="{{ route($role . '.laporan-keuangan.create') }}" style="text-decoration: none;">
            <button style="background-color: #4D0B87; color: white; border: none; padding: 12px 25px; border-radius: 12px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 10px; font-size: 14px; transition: 0.3s; box-shadow: 0 4px 6px rgba(77, 11, 135, 0.2);">
            <i class="fas fa-plus"></i> Tambah Transaksi
            </button>
        </a>
    </div>

    {{-- ── 2. RINGKASAN KARTU (STATISTIK) ── --}}
    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-bottom: 30px;">
        @php
            $stats = [
                ['label' => 'Pemasukan Berjalan', 'val' => 'Rp 1.000.000', 'color' => '#4472DF', 'bg' => '#F0F4FF'],
                ['label' => 'Pengeluaran Berjalan', 'val' => 'Rp 500.000', 'color' => '#D74E4E', 'bg' => '#FFF0F0'],
                ['label' => 'Pelunasan Piutang', 'val' => 'Rp 1.000.000', 'color' => '#E7C255', 'bg' => '#FFFDF0'],
                ['label' => 'Pendapatan Dimuka', 'val' => 'Rp 300.000', 'color' => '#4AB462', 'bg' => '#F0FFF4'],
                ['label' => 'Total Pemasukan Kas', 'val' => 'Rp 1.800.000', 'color' => '#6B7280', 'bg' => '#F9FAFB'],
                ['label' => 'Saldo Kas Akhir', 'val' => 'Rp 500.000', 'color' => '#4D0B87', 'bg' => '#F3E8FF'],
            ];
        @endphp

        @foreach($stats as $s)
        <div style="background: white; padding: 18px; border-radius: 15px; border-bottom: 4px solid {{ $s['color'] }}; box-shadow: 0 4px 12px rgba(0,0,0,0.04); transition: 0.3s;">
            <p style="margin: 0; color: #6B7280; font-weight: 600; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">{{ $s['label'] }}</p>
            <h3 style="margin: 8px 0 0; font-size: 18px; font-weight: 800; color: {{ $s['color'] }}">{{ $s['val'] }}</h3>
        </div>
        @endforeach
    </div>

    {{-- ── 3. FILTER AREA ── --}}
    <div style="display: flex; gap: 12px; margin-bottom: 30px;">
        <div style="position: relative; flex: 2;">
            <i class="fas fa-search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #9CA3AF;"></i>
            <input type="text" placeholder="Cari Rincian Transaksi..." 
                   style="width: 100%; padding: 11px 15px 11px 45px; border-radius: 12px; border: 1.5px solid #E5E7EB; outline: none; font-size: 14px; background: white;">
        </div>
        <select style="flex: 1; padding: 11px; border-radius: 12px; border: 1px solid #E5E7EB; background: white; font-size: 14px; color: #4B5563; outline: none; cursor: pointer;">
            <option>Pilih Bulan</option>
            <option selected>Maret 2026</option>
        </select>
        <select style="flex: 1; padding: 11px; border-radius: 12px; border: 1px solid #E5E7EB; background: white; font-size: 14px; color: #4B5563; outline: none; cursor: pointer;">
            <option>Semua Kategori</option>
        </select>
    </div>

    {{-- ── 4. TABEL LAPORAN (Per Kategori) ── --}}
    @php
        $tables = [
            ['title' => 'Pemasukan Periode Berjalan', 'color' => '#4472DF', 'bg_head' => '#E0E7FF', 'total' => 'Rp 15.000.000'],
            ['title' => 'Pengeluaran Periode Berjalan', 'color' => '#D74E4E', 'bg_head' => '#FEE2E2', 'total' => 'Rp 3.000.000'],
            ['title' => 'Pelunasan Piutang (Tunggakan)', 'color' => '#E7C255', 'bg_head' => '#FEF3C7', 'total' => 'Rp 400.000'],
            ['title' => 'Pendapatan Uang Dimuka', 'color' => '#4AB462', 'bg_head' => '#DCFCE7', 'total' => 'Rp 1.080.000'],
        ];
    @endphp

    @foreach($tables as $table)
    <div style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.06); border: 1px solid #F3F4F6; margin-bottom: 30px;">
        <div style="padding: 15px 25px; border-bottom: 1px solid #F3F4F6; display: flex; justify-content: space-between; align-items: center;">
            <h4 style="margin: 0; font-weight: 700; color: #111827; font-size: 15px; display: flex; align-items: center; gap: 10px;">
                <span style="width: 8px; height: 18px; background: {{ $table['color'] }}; border-radius: 10px;"></span>
                {{ $table['title'] }}
            </h4>
        </div>
        
        <table style="width: 100%; border-collapse: collapse; text-align: center; font-size: 13px;">
            <thead>
                <tr style="background: {{ $table['bg_head'] }}; color: #111827;">
                    <th style="padding: 15px; font-weight: 700; width: 60px;">No</th>
                    <th style="padding: 15px; font-weight: 700;">Tanggal</th>
                    <th style="padding: 15px; font-weight: 700; text-align: left;">Rincian Transaksi</th>
                    <th style="padding: 15px; font-weight: 700;">Jumlah</th>
                </tr>
            </thead>
            <tbody style="color: #4B5563;">
                <tr style="border-bottom: 1px solid #F3F4F6;">
                    <td style="padding: 14px;">1</td>
                    <td style="padding: 14px;">09 Mar 2026</td>
                    <td style="padding: 14px; text-align: left; font-weight: 600;">Pemasukan SPP Murid - Paket SD</td>
                    <td style="padding: 14px; font-weight: 700; color: {{ $table['color'] }};">{{ $table['total'] }}</td>
                </tr>
            </tbody>
            <tfoot>
                <tr style="background: #F9FAFB;">
                    <td colspan="3" style="padding: 15px 25px; text-align: right; font-weight: 700; color: #111827;">Subtotal:</td>
                    <td style="padding: 15px; font-weight: 800; color: {{ $table['color'] }}; font-size: 14px;">{{ $table['total'] }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
    @endforeach

    {{-- ── 5. TOMBOL EXPORT (Primary Action) ── --}}
    <button style="width: 100%; background: #10B981; color: white; border: none; padding: 16px; border-radius: 15px; font-size: 16px; font-weight: 700; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 12px; transition: 0.3s; box-shadow: 0 4px 15px rgba(16, 185, 129, 0.2); margin-bottom: 40px;"
            onmouseover="this.style.background='#059669'" onmouseout="this.style.background='#10B981'">
        <i class="fas fa-file-pdf" style="font-size: 20px;"></i>
        EXPORT LAPORAN (PDF)
    </button>
</div>
@endsection