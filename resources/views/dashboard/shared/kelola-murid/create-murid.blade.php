@extends('layouts.app')

@section('title', 'Input Data Murid')

@section('content')
<div style="padding: 10px; font-family: 'Poppins', sans-serif;">
    
    {{-- Header Judul --}}
    <h1 style="font-size: 20px; font-weight: 700; color: #111827; margin-bottom: 20px;">Input Data Murid</h1>

    {{-- Container Form Utama --}}
    <div style="background: #F9FAFB; border-radius: 15px; padding: 30px; border: 1.5px solid #E5E7EB; box-shadow: 0 4px 10px rgba(0,0,0,0.02);">
        
        <form action="{{ route($role . '.murid.store') }}" method="POST">
            @csrf
            
            {{-- Nama Lengkap --}}
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Nama Lengkap</label>
                <input type="text" name="nama_lengkap_murid" placeholder="Masukkan Nama Lengkap" required
                       style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none;">
            </div>

            {{-- Kelas --}}
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Kelas</label>
                <input type="text" name="kelas" placeholder="Masukkan Kelas"
                       style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none;">
            </div>

            {{-- Asal Sekolah --}}
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Asal Sekolah</label>
                <input type="text" name="asal_sekolah" placeholder="Masukkan Asal Sekolah"
                       style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none;">
            </div>

            {{-- Alamat --}}
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Alamat</label>
                <input type="text" name="alamat_murid" placeholder="Masukkan Alamat"
                       style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none;">
            </div>

            <hr style="border: 0; border-top: 1px solid #E5E7EB; margin-bottom: 25px;">

            {{-- Grid 2 Kolom --}}
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0 40px;">
                
                {{-- Kolom Kiri --}}
                <div>
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">No HP Siswa</label>
                        <input type="text" name="no_hp_murid" placeholder="Masukkan No HP"
                               style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none;">
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Nama Orang Tua</label>
                        <input type="text" name="nama_orang_tua" placeholder="Masukkan Nama Orang Tua"
                               style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none;">
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">No HP Orang Tua</label>
                        <input type="text" name="no_hp_orang_tua" placeholder="Masukkan No HP Orang Tua"
                               style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none;">
                    </div>
                </div>

                {{-- Kolom Kanan --}}
                <div>
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Paket Awal</label>
                        <input type="text" name="paket_awal" placeholder="Masukkan Paket Awal"
                               style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none;">
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Pilihan Paket</label>
                        <select name="pilihan_paket" 
                                style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none; color: #374151;">
                            <option value="">Pilih Paket</option>
                            <option value="SD">SD</option>
                            <option value="SMP">SMP</option>
                            <option value="SMA">SMA</option>
                        </select>
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Tahun Masuk</label>
                        <input type="text" name="tahun_masuk" placeholder="Masukkan Tahun Masuk"
                               style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none;">
                    </div>
                </div>
            </div>

            {{-- Tombol Aksi --}}
            <div style="display: flex; justify-content: flex-end; gap: 20px; margin-top: 30px;">
                <a href="{{ route($role . '.kelola-murid') }}" 
                   style="text-decoration: none; padding: 12px 65px; border: 1.5px solid #4D0B87; color: #4D0B87; border-radius: 12px; font-weight: 600; font-size: 18px; background: #FFFFFF; text-align: center;">
                    Keluar
                </a>
                <button type="submit" 
                        style="padding: 12px 65px; border: none; background: #4D0B87; color: white; border-radius: 12px; font-weight: 600; font-size: 18px; cursor: pointer; box-shadow: 0 4px 6px rgba(77, 11, 135, 0.2);">
                    Simpan
                </button>
            </div>

        </form>
    </div>
</div>
@endsection