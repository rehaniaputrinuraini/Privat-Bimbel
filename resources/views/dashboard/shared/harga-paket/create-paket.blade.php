@extends('layouts.app')

@section('title', 'Tambah Harga Paket')

@section('content')
<div class="container-fluid" style="padding: 20px;">
    {{-- Judul Halaman --}}
    <h2 style="font-size: 20px; font-weight: 600; margin-bottom: 20px; font-family: 'Poppins', sans-serif; color: #111827;">
        Input Harga Paket
    </h2>

    {{-- Container Form --}}
    <div style="background: white; padding: 40px; border-radius: 15px; border: 1.5px solid #D1D5DB; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
        
        <form action="{{ route($role.'.harga-paket.store') }}" method="POST">
            @csrf
            
            {{-- Input ID --}}
            <div style="margin-bottom: 25px;">
                <label style="display: block; font-weight: 500; margin-bottom: 10px; color: #374151; font-family: 'Poppins', sans-serif;">ID</label>
                <input type="text" name="kode" placeholder="Masukkan ID" required 
                       style="width: 100%; padding: 14px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: #F9FAFB; outline: none; font-size: 14px;">
            </div>

            {{-- Input Harga Paket --}}
            <div style="margin-bottom: 25px;">
                <label style="display: block; font-weight: 500; margin-bottom: 10px; color: #374151; font-family: 'Poppins', sans-serif;">Harga Paket</label>
                <input type="text" name="harga" placeholder="Masukkan Harga Paket" required 
                       style="width: 100%; padding: 14px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: #F9FAFB; outline: none; font-size: 14px;">
            </div>

            {{-- Input Tingkat --}}
            <div style="margin-bottom: 40px;">
                <label style="display: block; font-weight: 500; margin-bottom: 10px; color: #374151; font-family: 'Poppins', sans-serif;">Tingkat</label>
                <input type="text" name="tingkat" placeholder="Masukkan Tingkat" required 
                       style="width: 100%; padding: 14px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: #F9FAFB; outline: none; font-size: 14px;">
            </div>

            {{-- Tombol Aksi (Sesuai Gambar) --}}
            <div style="display: flex; justify-content: flex-end; gap: 20px; align-items: center;">
                {{-- Tombol Keluar --}}
                <a href="{{ route($role.'.harga-paket') }}" 
                   style="padding: 12px 60px; border-radius: 12px; border: 2px solid #5D10A2; color: #5D10A2; text-decoration: none; font-weight: 600; text-align: center; font-size: 16px; transition: 0.3s; font-family: 'Poppins', sans-serif;">
                    Keluar
                </a>
                
                {{-- Tombol Simpan --}}
                <button type="submit" 
                        style="padding: 14px 60px; border-radius: 12px; border: none; background: #4D0B87; color: white; font-weight: 600; cursor: pointer; font-size: 16px; transition: 0.3s; font-family: 'Poppins', sans-serif;">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection