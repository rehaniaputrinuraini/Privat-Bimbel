@extends('layouts.app')

@section('title', 'Input Pembayaran')

@section('content')
<div class="container-fluid" style="padding: 20px;">
    {{-- Judul Halaman --}}
    <h2 style="font-size: 22px; font-weight: 700; margin-bottom: 25px; font-family: 'Poppins', sans-serif; color: #111827;">
        Input Pembayaran
    </h2>

    {{-- Container Form Putih --}}
    <div style="background: white; padding: 40px; border-radius: 20px; border: 1.5px solid #D1D5DB; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
        
        <form action="#" method="POST">
            @csrf
            
            {{-- Input Tanggal dengan Ikon Kalender --}}
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; margin-bottom: 10px; color: #111827;">Tanggal</label>
                <div style="position: relative;">
                    <input type="text" name="tanggal" placeholder="AD0009" 
                           style="width: 100%; padding: 14px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: #F9FAFB; outline: none;">
                    <i class="fas fa-calendar-alt" style="position: absolute; right: 20px; top: 50%; transform: translateY(-50%); color: #4B5563; font-size: 18px;"></i>
                </div>
            </div>

            {{-- Input Nama --}}
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; margin-bottom: 10px; color: #111827;">Nama</label>
                <input type="text" name="nama" placeholder="Masukkan Nama" 
                       style="width: 100%; padding: 14px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: #F9FAFB; outline: none;">
            </div>

            {{-- Input Paket Awal (Readonly/Otomatis) --}}
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; margin-bottom: 10px; color: #111827;">Paket Awal</label>
                <input type="text" name="paket_awal" placeholder="Terisi Otomatis" readonly
                       style="width: 100%; padding: 14px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: #F9FAFB; outline: none; color: #6B7280;">
            </div>

            {{-- Input Paket Selanjutnya --}}
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; margin-bottom: 10px; color: #111827;">Paket Selanjutnya</label>
                <input type="text" name="paket_selanjutnya" placeholder="Terisi Otomatis" 
                       style="width: 100%; padding: 14px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: #F9FAFB; outline: none; color: #6B7280;">
            </div>

            {{-- Input Total Pembayaran --}}
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; margin-bottom: 10px; color: #111827;">Total Pembayaran</label>
                <input type="text" name="total_pembayaran" placeholder="Terisi Otomatis" 
                       style="width: 100%; padding: 14px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: #F9FAFB; outline: none; color: #6B7280;">
            </div>

            {{-- Input Keterangan --}}
            <div style="margin-bottom: 35px;">
                <label style="display: block; font-weight: 600; margin-bottom: 10px; color: #111827;">Keterangaan</label>
                <input type="text" name="keterangan" placeholder="Masukkan Keterangan" 
                       style="width: 100%; padding: 14px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: #F9FAFB; outline: none;">
            </div>

            {{-- Tombol Aksi --}}
            <div style="display: flex; justify-content: flex-end; gap: 20px; align-items: center;">
                <a href="{{ route($role.'.pembayaran') }}" 
                   style="padding: 12px 60px; border-radius: 12px; border: 2px solid #5D10A2; color: #5D10A2; text-decoration: none; font-weight: 700; text-align: center; font-size: 16px; transition: 0.3s;">
                    Keluar
                </a>
                <button type="submit" 
                        style="padding: 14px 60px; border-radius: 12px; border: none; background: #4D0B87; color: white; font-weight: 700; cursor: pointer; font-size: 16px; transition: 0.3s;">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection