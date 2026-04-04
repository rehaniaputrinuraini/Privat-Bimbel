@extends('layouts.app')

@section('title', 'Laporan Keuangan')

@section('content')
{{-- Kontainer Utama: Menggunakan width 100% tanpa padding tambahan agar lurus dengan sidebar --}}
<div style="width: 100%; font-family: 'Poppins', sans-serif;">

    {{-- Ambil Role dari variabel yang dikirim controller --}}
    @php $role = $role ?? (Auth::user()->peran); @endphp

    {{-- ── 1. HEADER HALAMAN (HIRARKI VISUAL REVISI) ── --}}
    <div style="margin-bottom: 25px;">
        {{-- Baris 1: Bulan & Tahun --}}
        <p style="color: #6B7280; font-size: 13px; margin: 0 0 4px 0;">
            {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}
        </p>
        
        {{-- Baris 2: Judul Halaman --}}
        <h1 style="font-size: 26px; font-weight: 700; color: #111827; margin: 0; letter-spacing: -0.5px; line-height: 1.2;">
            Laporan Keuangan
        </h1>
        
        {{-- Baris 3: Keterangan/Deskripsi --}}
        <p style="color: #6B7280; font-size: 14px; margin: 4px 0 0 0;">
            Data Laporan Arus Kas Masuk dan Keluar
        </p>
    </div>

    {{-- ── 2. RINGKASAN KARTU (STATISTIK) ── --}}
    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 30px;">
        <div style="background: white; padding: 20px; border-radius: 15px; border-left: 8px solid #4472DF; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
            <p style="margin: 0; color: #4472DF; font-weight: 700; font-size: 13px;">Pemasukan Periode Berjalan</p>
            <h3 style="margin: 10px 0 0; font-size: 20px; font-weight: 800; color: #4472DF">Rp. 1.000.000</h3>
        </div>
        <div style="background: white; padding: 20px; border-radius: 15px; border-left: 8px solid #D74E4E; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
            <p style="margin: 0; color: #D74E4E; font-weight: 700; font-size: 13px;">Pengeluaran Periode Berjalan</p>
            <h3 style="margin: 10px 0 0; font-size: 20px; font-weight: 800; color: #D74E4E">Rp. 500.000</h3>
        </div>
        <div style="background: white; padding: 20px; border-radius: 15px; border-left: 8px solid #E7C255; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
            <p style="margin: 0; color: #E7C255; font-weight: 700; font-size: 13px;">Pelunasan Piutang</p>
            <h3 style="margin: 10px 0 0; font-size: 20px; font-weight: 800; color: #E7C255">Rp. 1.000.000</h3>
        </div>
        <div style="background: white; padding: 20px; border-radius: 15px; border-left: 8px solid #4AB462; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
            <p style="margin: 0; color: #4AB462; font-weight: 700; font-size: 13px;">Pendapatan Uang Dimuka</p>
            <h3 style="margin: 10px 0 0; font-size: 20px; font-weight: 800; color: #4AB462">Rp. 300.000</h3>
        </div>
        <div style="background: white; padding: 20px; border-radius: 15px; border-left: 8px solid #ACB2AD; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
            <p style="margin: 0; color: #ACB2AD; font-weight: 700; font-size: 13px;">Total Pemasukan Kas</p>
            <h3 style="margin: 10px 0 0; font-size: 20px; font-weight: 800; color: #ACB2AD">Rp. 1.800.000</h3>
        </div>
        <div style="background: white; padding: 20px; border-radius: 15px; border-left: 8px solid #4D0B87; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
            <p style="margin: 0; color: #4D0B87; font-weight: 700; font-size: 13px;">Saldo Kas</p>
            <h3 style="margin: 10px 0 0; font-size: 20px; font-weight: 800; color: #4D0B87">Rp. 500.000</h3>
        </div>
    </div>

    {{-- ── 3. FILTER DAN TOMBOL TAMBAH ── --}}
    <div style="display: flex; gap: 15px; align-items: center; margin-bottom: 20px;">
        <div style="position: relative; flex: 3;">
            <i class="fas fa-search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #9CA3AF;"></i>
            <input type="text" placeholder="Cari..." style="width: 100%; padding: 12px 45px; border-radius: 12px; border: 1px solid #E5E7EB; outline: none; background: white;">
        </div>
        <div style="flex: 1; display: flex; justify-content: flex-end;">
            <a href="{{ route($role . '.laporan-keuangan.create') }}" style="text-decoration: none;">
                <button style="background: #4D0B87; color: white; border: none; padding: 12px 30px; border-radius: 12px; font-weight: 700; cursor: pointer; transition: 0.3s; display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-plus"></i> Tambah
                </button>
            </a>
        </div>
    </div>

    <div style="display: flex; gap: 15px; margin-bottom: 35px;">
        <select style="flex: 1; padding: 12px; border-radius: 12px; border: 1px solid #E5E7EB; background: white; color: #4B5563;"><option>Maret</option></select>
        <select style="flex: 2; padding: 12px; border-radius: 12px; border: 1px solid #E5E7EB; background: white; color: #4B5563;"><option>---Kategori---</option></select>
        <div style="flex: 1;"></div>
    </div>

    {{-- ── 4. TABEL-TABEL LAPORAN ── --}}
    @php
        $tables = [
            ['title' => 'Riwayat Pemasukan Periode Berjalan', 'color' => '#4472DF', 'bg_head' => '#A2B9EE', 'bg_row' => '#F0F4FF', 'total_label' => 'Total Pemasukan Periode Berjalan', 'total_val' => 'Rp. 15.000.000'],
            ['title' => 'Riwayat Pengeluaran Periode Berjalan', 'color' => '#D74E4E', 'bg_head' => '#EEA2A2', 'bg_row' => '#FFF0F0', 'total_label' => 'Total Pengeluaran Periode Berjalan', 'total_val' => 'Rp. 3.000.000'],
            ['title' => 'Riwayat Pelunasan Piutang (Tunggakan)', 'color' => '#E7C255', 'bg_head' => '#EEDCA2', 'bg_row' => '#FFFDF0', 'total_label' => 'Total Pemasukan Piutang (Tunggakan)', 'total_val' => 'Rp. 400.000'],
            ['title' => 'Riwayat Pendapatan Uang Dimuka', 'color' => '#4AB462', 'bg_head' => '#A2EEB9', 'bg_row' => '#F0FFF4', 'total_label' => 'Total Pendapatan Uang Dimuka', 'total_val' => 'Rp. 1.080.000'],
        ];
    @endphp

    @foreach($tables as $table)
    <div style="background: white; border-radius: 20px; padding: 25px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); margin-bottom: 35px; border: 1px solid #F3F4F6;">
        <h4 style="margin: 0 0 20px 5px; font-weight: 800; color: #111827;">{{ $table['title'] }}</h4>
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: separate; border-spacing: 0 10px; text-align: center;">
                <thead>
                    <tr style="background: {{ $table['bg_head'] }}; color: #111827;">
                        <th style="padding: 15px; border-radius: 12px 0 0 12px;">No</th>
                        <th style="padding: 15px;">Tanggal</th>
                        <th style="padding: 15px;">Rincian</th>
                        <th style="padding: 15px; border-radius: 0 12px 12px 0;">Jumlah</th>
                    </tr>
                </thead>
                <tbody style="font-weight: 700;">
                    <tr style="background: {{ $table['bg_row'] }};">
                        <td style="padding: 15px; border-radius: 12px 0 0 12px;">1</td>
                        <td style="padding: 15px;">9 Feb 2026</td>
                        <td style="padding: 15px;">Contoh Data Laporan</td>
                        <td style="padding: 15px; border-radius: 0 12px 12px 0; color: {{ $table['color'] }};">{{ $table['total_val'] }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div style="display: flex; justify-content: space-between; font-weight: 800; margin: 15px 10px 20px;">
            <span style="color: #111827;">{{ $table['total_label'] }}</span>
            <span style="color: {{ $table['color'] }}; font-size: 16px;">{{ $table['total_val'] }}</span>
        </div>
    </div>
    @endforeach

    {{-- ── 5. TOMBOL EXPORT FINAL ── --}}
    <button style="width: 100%; background: #22C55E; color: white; border: none; padding: 18px; border-radius: 15px; font-size: 18px; font-weight: 800; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 15px; box-shadow: 0 4px 15px rgba(34, 197, 94, 0.3); margin-bottom: 50px;">
        <i class="fas fa-file-pdf" style="font-size: 24px;"></i> EXPORT PDF
    </button>

</div>
@endsection