{{-- =============================================
     Dashboard Shared - Manajemen Pembayaran (FINAL REVISI)
     File: resources/views/dashboard/shared/pembayaran/index.blade.php
============================================= --}}

@extends('layouts.app')

@section('title', 'Manajemen Pembayaran')

@section('content')
{{-- Inisialisasi Alpine.js untuk fitur Tab --}}
<div x-data="{ tab: 'tagihan' }" style="width: 100%;">
    
    {{-- ── 1. HEADER HALAMAN (26px - Konsisten) ── --}}
    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 25px;">
        <div>
            <p style="color: #6B7280; font-size: 13px; margin: 0 0 4px 0;">
                {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}
            </p>
            <h1 style="font-size: 26px; font-weight: 700; color: #111827; margin: 0; letter-spacing: -0.5px; line-height: 1.2;">
                Pembayaran
            </h1>
            <p style="color: #6B7280; font-size: 14px; margin: 4px 0 0 0;">Kelola Pembayaran Murid dan Riwayat Pembayaran</p>
        </div>
        
        <a href="{{ route($role . '.pembayaran.create') }}" style="text-decoration: none;">
            <button style="background: #4D0B87; color: white; padding: 10px 24px; border-radius: 12px; border: none; font-weight: 600; display: flex; align-items: center; gap: 10px; font-size: 14px; cursor: pointer; box-shadow: 0 4px 10px rgba(77, 11, 135, 0.2);">
                <i class="fas fa-plus"></i> Input Pembayaran
            </button>
        </a>
    </div>

    {{-- ── 2. NAVIGASI TAB (Modern Underline) ── --}}
    <div style="display: flex; width: 100%; border-bottom: 2px solid #F3F4F6; margin-bottom: 25px; gap: 40px;">
        <div @click="tab = 'tagihan'" 
             :style="tab === 'tagihan' ? 'border-bottom: 3px solid #4D0B87; color: #4D0B87' : 'color: #9CA3AF'" 
             style="padding: 12px 10px; cursor: pointer; font-weight: 700; transition: 0.3s; font-size: 15px; position: relative; bottom: -2px;">
            Tagihan Murid
        </div>
        <div @click="tab = 'riwayat'" 
             :style="tab === 'riwayat' ? 'border-bottom: 3px solid #4D0B87; color: #4D0B87' : 'color: #9CA3AF'" 
             style="padding: 12px 10px; cursor: pointer; font-weight: 700; transition: 0.3s; font-size: 15px; position: relative; bottom: -2px;">
            Riwayat Pembayaran
        </div>
    </div>

    {{-- ── KONTEN TAB 1: TAGIHAN MURID ── --}}
    <div x-show="tab === 'tagihan'" x-transition:enter.duration.300ms>
        {{-- Filter Box --}}
        <div style="display: flex; gap: 12px; margin-bottom: 25px;">
            <div style="position: relative; flex: 2;">
                <i class="fas fa-search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #9CA3AF;"></i>
                <input type="text" placeholder="Cari Nama Murid..." style="width: 100%; padding: 10px 15px 10px 45px; border-radius: 12px; border: 1px solid #E5E7EB; background: white; outline: none; font-size: 14px;">
            </div>
            <select style="flex: 1; padding: 10px; border-radius: 12px; border: 1px solid #E5E7EB; color: #6B7280; outline: none; font-size: 14px; background: white; cursor: pointer;">
                <option>Status Paket</option>
            </select>
            <select style="flex: 1; padding: 10px; border-radius: 12px; border: 1px solid #E5E7EB; color: #6B7280; outline: none; font-size: 14px; background: white; cursor: pointer;">
                <option>Status Tagihan</option>
            </select>
        </div>

        {{-- Tabel Tagihan --}}
        <div style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.08); border: 1px solid #F3F4F6;">
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; text-align: center; font-size: 13px; white-space: nowrap;">
                    <thead>
                        <tr style="background: #F3E8FF; color: #111827;">
                            <th style="padding: 18px 15px; font-weight: 700;">No</th>
                            <th style="padding: 18px 15px; font-weight: 700; text-align: left;">Nama Lengkap</th>
                            <th style="padding: 18px 15px; font-weight: 700;">Kelas</th>
                            <th style="padding: 18px 15px; font-weight: 700;">Paket</th>
                            <th style="padding: 18px 15px; font-weight: 700;">Pembayaran</th>
                            <th style="padding: 18px 15px; font-weight: 700;">Status Tagihan</th>
                            <th style="padding: 18px 15px; font-weight: 700;">Tunggakan</th>
                            <th style="padding: 18px 15px; font-weight: 700;">Total Piutang</th>
                        </tr>
                    </thead>
                    <tbody style="color: #4B5563;">
                        <tr style="border-bottom: 1px solid #F3F4F6; transition: 0.2s;" onmouseover="this.style.background='#F9FAFB'" onmouseout="this.style.background='transparent'">
                            <td style="padding: 15px; color: #6B7280;">1</td>
                            <td style="padding: 15px; text-align: left; font-weight: 700; color: #111827;">Rehan Putri</td>
                            <td style="padding: 15px;">5.1</td>
                            <td style="padding: 15px;">SD</td>
                            <td style="padding: 15px;"><span style="background: #DCFCE7; color: #166534; padding: 5px 12px; border-radius: 8px; font-size: 11px; font-weight: 700;">Lunas</span></td>
                            <td style="padding: 15px;"><span style="background: #DCFCE7; color: #166534; padding: 5px 12px; border-radius: 8px; font-size: 11px; font-weight: 700;">Lunas</span></td>
                            <td style="padding: 15px;">-</td>
                            <td style="padding: 15px;">-</td>
                        </tr>
                        <tr style="border-bottom: 1px solid #F3F4F6; transition: 0.2s;" onmouseover="this.style.background='#F9FAFB'" onmouseout="this.style.background='transparent'">
                            <td style="padding: 15px; color: #6B7280;">2</td>
                            <td style="padding: 15px; text-align: left; font-weight: 700; color: #111827;">Budi Santoso</td>
                            <td style="padding: 15px;">6.2</td>
                            <td style="padding: 15px;">SD</td>
                            <td style="padding: 15px;"><span style="background: #FEE2E2; color: #991B1B; padding: 5px 12px; border-radius: 8px; font-size: 11px; font-weight: 700;">Belum</span></td>
                            <td style="padding: 15px;"><span style="background: #FEF3C7; color: #92400E; padding: 5px 12px; border-radius: 8px; font-size: 11px; font-weight: 700;">Tunggak 1 Bln</span></td>
                            <td style="padding: 15px;">1 Bln</td>
                            <td style="padding: 15px; font-weight: 700; color: #EF4444;">Rp 120.000</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- ── KONTEN TAB 2: RIWAYAT MURID ── --}}
    <div x-show="tab === 'riwayat'" x-transition:enter.duration.300ms>
        <div style="display: flex; gap: 12px; margin-bottom: 25px;">
            <div style="position: relative; flex: 2;">
                <i class="fas fa-search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #9CA3AF;"></i>
                <input type="text" placeholder="Cari Riwayat Pembayaran..." style="width: 100%; padding: 10px 15px 10px 45px; border-radius: 12px; border: 1px solid #E5E7EB; background: white; outline: none; font-size: 14px;">
            </div>
            <div style="flex: 1; position: relative;">
                <input type="date" style="width: 100%; padding: 10px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: white; color: #6B7280; outline: none; font-size: 14px; cursor: pointer;">
            </div>
        </div>

        <div style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.08); border: 1px solid #F3F4F6;">
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; text-align: center; font-size: 13px; white-space: nowrap;">
                    <thead>
                        <tr style="background: #F3E8FF; color: #111827;">
                            <th style="padding: 18px 15px; font-weight: 700;">No</th>
                            <th style="padding: 18px 15px; font-weight: 700;">Tanggal</th>
                            <th style="padding: 18px 15px; font-weight: 700; text-align: left;">Nama Murid</th>
                            <th style="padding: 18px 15px; font-weight: 700;">Paket Awal</th>
                            <th style="padding: 18px 15px; font-weight: 700;">Paket Selanjutnya</th>
                            <th style="padding: 18px 15px; font-weight: 700;">Total Bayar</th>
                            <th style="padding: 18px 15px; font-weight: 700; text-align: left;">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody style="color: #4B5563;">
                        <tr style="border-bottom: 1px solid #F3F4F6; transition: 0.2s;" onmouseover="this.style.background='#F9FAFB'" onmouseout="this.style.background='transparent'">
                            <td style="padding: 15px; color: #6B7280;">1</td>
                            <td style="padding: 15px;">12/02/2026</td>
                            <td style="padding: 15px; text-align: left; font-weight: 700; color: #111827;">Rehan Putri</td>
                            <td style="padding: 15px;">100.000</td>
                            <td style="padding: 15px;">SD</td>
                            <td style="padding: 15px; font-weight: 700; color: #4D0B87;">Rp 120.000</td>
                            <td style="padding: 15px; text-align: left;">Pembayaran Paket Januari</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- ── 3. PAGINATION (Konsisten) ── --}}
    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 25px;">
        <div style="color: #6B7280; font-size: 13px;">Menampilkan 10 baris</div>
        <div style="display: flex; gap: 5px;">
            <button style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #6B7280; cursor: pointer;"><i class="fas fa-angle-left"></i></button>
            <button style="width: 35px; height: 35px; border-radius: 8px; background: #4D0B87; color: white; border: none; font-weight: 600;">1</button>
            <button style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #6B7280; cursor: pointer;"><i class="fas fa-angle-right"></i></button>
        </div>
    </div>

</div>

{{-- Script Alpine.js --}}
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endsection