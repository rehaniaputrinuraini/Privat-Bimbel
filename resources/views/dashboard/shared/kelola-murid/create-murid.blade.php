@extends('layouts.app')

@section('content')
<div class="container-fluid" style="padding: 20px;">
    {{-- Judul Halaman --}}
    <h2 style="font-size: 20px; font-weight: 600; margin-bottom: 20px; font-family: 'Poppins', sans-serif; color: #111827;">
        Input Data Murid
    </h2>

    {{-- Container Form --}}
    <div style="background: white; padding: 40px; border-radius: 15px; border: 1.5px solid #D1D5DB; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
        <form action="{{ route($role.'.murid.store') }}" method="POST">
            @csrf
            
            {{-- Bagian Atas: Input Lebar Penuh --}}
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 500; margin-bottom: 8px; color: #374151;">Nama Lengkap</label>
                <input type="text" name="nama_lengkap_murid" placeholder="Masukkan Nama Lengkap" required 
                       style="width: 100%; padding: 14px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: #F9FAFB; outline: none;">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 500; margin-bottom: 8px; color: #374151;">Kelas</label>
                <input type="text" name="kelas" placeholder="Masukkan Kelas" 
                       style="width: 100%; padding: 14px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: #F9FAFB; outline: none;">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 500; margin-bottom: 8px; color: #374151;">Asal Sekolah</label>
                <input type="text" name="asal_sekolah" placeholder="Masukkan Asal Sekolah" 
                       style="width: 100%; padding: 14px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: #F9FAFB; outline: none;">
            </div>

            <div style="margin-bottom: 30px;">
                <label style="display: block; font-weight: 500; margin-bottom: 8px; color: #374151;">Alamat</label>
                <input type="text" name="alamat_murid" placeholder="Masukkan Alamat" 
                       style="width: 100%; padding: 14px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: #F9FAFB; outline: none;">
            </div>

            {{-- Bagian Bawah: Grid Dua Kolom --}}
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px; margin-bottom: 40px;">
                
                {{-- Kolom Kiri --}}
                <div style="display: flex; flex-direction: column; gap: 20px;">
                    <div>
                        <label style="display: block; font-weight: 500; margin-bottom: 8px; color: #374151;">No Hp Siswa</label>
                        <input type="text" name="no_hp_murid" placeholder="Masukkan No HP" 
                               style="width: 100%; padding: 14px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: #F9FAFB; outline: none;">
                    </div>
                    <div>
                        <label style="display: block; font-weight: 500; margin-bottom: 8px; color: #374151;">Nama Orang Tua</label>
                        <input type="text" name="nama_orang_tua" placeholder="Masukkan Orang Tua" 
                               style="width: 100%; padding: 14px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: #F9FAFB; outline: none;">
                    </div>
                    <div>
                        <label style="display: block; font-weight: 500; margin-bottom: 8px; color: #374151;">No Hp Ortu</label>
                        <input type="text" name="no_hp_orang_tua" placeholder="Masukkan No HP" 
                               style="width: 100%; padding: 14px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: #F9FAFB; outline: none;">
                    </div>
                </div>

                {{-- Kolom Kanan --}}
                <div style="display: flex; flex-direction: column; gap: 20px;">
                    <div>
                        <label style="display: block; font-weight: 500; margin-bottom: 8px; color: #374151;">Paket Awal</label>
                        <input type="text" name="paket_awal" placeholder="Paket Awal" 
                               style="width: 100%; padding: 14px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: #F9FAFB; outline: none;">
                    </div>
                    <div>
                        <label style="display: block; font-weight: 500; margin-bottom: 8px; color: #374151;">Pilihan Paket</label>
                        <select name="pilihan_paket" 
                                style="width: 100%; padding: 14px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: #F9FAFB; color: #6B7280; outline: none; appearance: none;">
                            <option value="">Pilihan Paket Selanjutnya</option>
                            <option value="SD">SD</option>
                            <option value="SMP">SMP</option>
                            <option value="SMA">SMA</option>
                        </select>
                    </div>
                    <div>
                        <label style="display: block; font-weight: 500; margin-bottom: 8px; color: #374151;">Tahun Masuk</label>
                        <input type="text" name="tahun_masuk" placeholder="Masukkan Tahun Masuk" 
                               style="width: 100%; padding: 14px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: #F9FAFB; outline: none;">
                    </div>
                </div>
            </div>

            {{-- Tombol Aksi (Sesuai Desain Gambar) --}}
            <div style="display: flex; justify-content: flex-end; gap: 20px; align-items: center;">
                <a href="{{ route($role.'.kelola-murid') }}" 
                   style="padding: 12px 60px; border-radius: 12px; border: 2px solid #5D10A2; color: #5D10A2; text-decoration: none; font-weight: 600; text-align: center; font-size: 16px; transition: 0.3s;">
                    Keluar
                </a>
                <button type="submit" 
                        style="padding: 14px 60px; border-radius: 12px; border: none; background: #4D0B87; color: white; font-weight: 600; cursor: pointer; font-size: 16px; transition: 0.3s;">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection