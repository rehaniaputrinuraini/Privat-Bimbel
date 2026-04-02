@extends('layouts.app')

@section('title', 'Manajemen Pembayaran')

@section('content')
{{-- Inisialisasi Alpine.js untuk fitur Tab --}}
<div x-data="{ tab: 'tagihan' }">
    
    {{-- 1. HEADER HALAMAN --}}
    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 25px;">
        <div>
            <p style="color: #6B7280; font-size: 14px; margin-bottom: 5px;">{{ \Carbon\Carbon::now()->translatedFormat('F Y') }}</p>
            <h1 style="font-size: 28px; font-weight: 800; color: #111827; margin: 0;">Pembayaran</h1>
            <p style="color: #6B7280; font-size: 14px; margin-top: 5px;">Kelola Pembayaran Murid dan Riwayat Pembayaran</p>
        </div>
        
        {{-- PERBAIKAN DI SINI: href="#" diganti menjadi rute create --}}
        <a href="{{ route($role . '.pembayaran.create') }}" style="text-decoration: none;">
            <button style="background-color: #4D0B87; color: white; border: none; padding: 12px 25px; border-radius: 12px; font-weight: 700; cursor: pointer; display: flex; align-items: center; gap: 10px; box-shadow: 0 4px 10px rgba(77, 11, 135, 0.2);">
                <i class="fas fa-plus"></i> Input Pembayaran Murid
            </button>
        </a>
    </div>

    {{-- 2. NAVIGASI TAB (Bagi Dua Rata 50/50) --}}
    <div style="display: flex; width: 100%; border-bottom: 2px solid #E5E7EB; margin-bottom: 30px; background: white; border-radius: 10px 10px 0 0;">
        
        {{-- Tab Tagihan Murid --}}
        <div @click="tab = 'tagihan'" 
             :style="tab === 'tagihan' ? 'border-bottom: 4px solid #5D10A2; color: #5D10A2' : 'color: #6B7280'" 
             style="flex: 1; padding: 18px 0; cursor: pointer; font-weight: 700; transition: 0.3s; text-align: center; font-size: 16px;">
            Tagihan Murid
        </div>

        {{-- Tab Riwayat Murid --}}
        <div @click="tab = 'riwayat'" 
             :style="tab === 'riwayat' ? 'border-bottom: 4px solid #5D10A2; color: #5D10A2' : 'color: #6B7280'" 
             style="flex: 1; padding: 18px 0; cursor: pointer; font-weight: 700; transition: 0.3s; text-align: center; font-size: 16px;">
            Riwayat Murid
        </div>

    </div>

    {{-- ========================================== --}}
    {{-- KONTEN TAB 1: TAGIHAN MURID --}}
    {{-- ========================================== --}}
    <div x-show="tab === 'tagihan'" x-transition>
        {{-- Filter Box --}}
        <div style="background: white; padding: 25px; border-radius: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); margin-bottom: 25px; border: 1px solid #E5E7EB;">
            <div style="position: relative; margin-bottom: 20px;">
                <i class="fas fa-search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #9CA3AF;"></i>
                <input type="text" placeholder="Cari Nama Murid..." style="width: 100%; padding: 12px 15px 12px 45px; border-radius: 12px; border: 1px solid #E5E7EB; background: #F9FAFB; outline: none;">
            </div>
            <div style="display: flex; gap: 15px;">
                <select style="flex: 1; padding: 12px; border-radius: 12px; border: 1px solid #E5E7EB; color: #6B7280; outline: none;"><option>Status Paket</option></select>
                <select style="flex: 1; padding: 12px; border-radius: 12px; border: 1px solid #E5E7EB; color: #6B7280; outline: none;"><option>Status Pembayaran</option></select>
                <select style="flex: 1; padding: 12px; border-radius: 12px; border: 1px solid #E5E7EB; color: #6B7280; outline: none;"><option>Status Tagihan</option></select>
            </div>
        </div>

        {{-- Tabel Data --}}
        <div style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border: 1px solid #E5E7EB;">
            <table style="width: 100%; border-collapse: collapse; text-align: center; font-size: 13px;">
                <thead>
                    <tr style="background: #F3E8FF; color: #111827; font-weight: 800;">
                        <th style="padding: 18px;">No</th>
                        <th style="padding: 18px;">Nama Lengkap</th>
                        <th style="padding: 18px;">Kelas</th>
                        <th style="padding: 18px;">Status Paket</th>
                        <th style="padding: 18px;">Status Pembayaran</th>
                        <th style="padding: 18px;">Status Tagihan</th>
                        <th style="padding: 18px;">Total Bulan</th>
                        <th style="padding: 18px;">Total Piutang</th>
                        <th style="padding: 18px;">Total Uang Muka</th>
                    </tr>
                </thead>
                <tbody style="font-weight: 600; color: #374151;">
                    <tr style="border-bottom: 1px solid #F3F4F6;">
                        <td style="padding: 18px;">1</td>
                        <td style="padding: 18px; font-weight: 800;">Rehan Putri</td>
                        <td style="padding: 18px;">5.1</td>
                        <td style="padding: 18px;">SD</td>
                        <td style="padding: 18px;"><span style="background: #D1FAE5; color: #065F46; padding: 6px 14px; border-radius: 10px; font-size: 11px;">Lunas</span></td>
                        <td style="padding: 18px;"><span style="background: #D1FAE5; color: #065F46; padding: 6px 14px; border-radius: 10px; font-size: 11px;">Lunas</span></td>
                        <td style="padding: 18px;">-</td><td style="padding: 18px;">-</td><td style="padding: 18px;">-</td>
                    </tr>
                    <tr style="border-bottom: 1px solid #F3F4F6;">
                        <td style="padding: 18px;">2</td>
                        <td style="padding: 18px; font-weight: 800;">Rehan Putri</td>
                        <td style="padding: 18px;">5.1</td>
                        <td style="padding: 18px;">SD</td>
                        <td style="padding: 18px;"><span style="background: #FEE2E2; color: #991B1B; padding: 6px 14px; border-radius: 10px; font-size: 11px;">Belum</span></td>
                        <td style="padding: 18px;"><span style="background: #FEF3C7; color: #92400E; padding: 6px 14px; border-radius: 10px; font-size: 11px;">Tunggak 1 Bln</span></td>
                        <td style="padding: 18px;">1</td>
                        <td style="padding: 18px;">Rp 120.000</td>
                        <td style="padding: 18px;">-</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    {{-- ========================================== --}}
    {{-- KONTEN TAB 2: RIWAYAT MURID --}}
    {{-- ========================================== --}}
    <div x-show="tab === 'riwayat'" x-transition>
        <div style="background: white; padding: 25px; border-radius: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); margin-bottom: 25px; border: 1px solid #E5E7EB;">
            <div style="position: relative; margin-bottom: 20px;">
                <i class="fas fa-search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #9CA3AF;"></i>
                <input type="text" placeholder="Cari Riwayat..." style="width: 100%; padding: 12px 15px 12px 45px; border-radius: 12px; border: 1px solid #E5E7EB; background: #F9FAFB; outline: none;">
            </div>
            <div style="display: flex; gap: 15px;">
                <select style="flex: 1; padding: 12px; border-radius: 12px; border: 1px solid #E5E7EB; color: #6B7280; outline: none;"><option>Status Paket</option></select>
                <div style="flex: 1; position: relative;">
                    <input type="text" placeholder="Pilih Tanggal" style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #F9FAFB; outline: none;">
                    <i class="fas fa-calendar" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); color: #9CA3AF;"></i>
                </div>
            </div>
        </div>

        <div style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border: 1px solid #E5E7EB;">
            <table style="width: 100%; border-collapse: collapse; text-align: center; font-size: 13px;">
                <thead>
                    <tr style="background: #F3E8FF; color: #111827; font-weight: 800;">
                        <th style="padding: 18px;">No</th>
                        <th style="padding: 18px;">Tanggal</th>
                        <th style="padding: 18px;">Nama</th>
                        <th style="padding: 18px;">Paket Awal</th>
                        <th style="padding: 18px;">Paket Selanjutnya</th>
                        <th style="padding: 18px;">Total Pembayaran</th>
                        <th style="padding: 18px;">Keterangan</th>
                    </tr>
                </thead>
                <tbody style="font-weight: 600; color: #374151;">
                    <tr style="border-bottom: 1px solid #F3F4F6;">
                        <td style="padding: 18px;">1</td>
                        <td style="padding: 18px;">12/02/2026</td>
                        <td style="padding: 18px; font-weight: 800;">Rehan</td>
                        <td style="padding: 18px;">100.000</td>
                        <td style="padding: 18px;">SD</td>
                        <td style="padding: 18px; font-weight: 800;">120.000</td>
                        <td style="padding: 18px;">Bayar bulan Januari</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    {{-- 3. FOOTER PAGINATION --}}
    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 30px;">
        <select style="padding: 8px 15px; border-radius: 10px; border: 1px solid #E5E7EB; color: #6B7280; font-size: 13px; outline: none; background: white;">
            <option>10 baris</option>
        </select>
        <div style="display: flex; gap: 8px;">
            <button style="padding: 8px 14px; background: #F3F4F6; border-radius: 10px; border: none; cursor: pointer; color: #9CA3AF;"><i class="fas fa-chevron-left"></i></button>
            <button style="padding: 8px 16px; background: #5D10A2; color: white; border-radius: 10px; border: none; font-weight: 700; cursor: pointer;">1</button>
            <button style="padding: 8px 14px; background: #F3F4F6; border-radius: 10px; border: none; cursor: pointer; color: #9CA3AF;"><i class="fas fa-chevron-right"></i></button>
        </div>
    </div>

</div>

{{-- WAJIB: Script Alpine.js agar Tab bisa diklik --}}
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endsection