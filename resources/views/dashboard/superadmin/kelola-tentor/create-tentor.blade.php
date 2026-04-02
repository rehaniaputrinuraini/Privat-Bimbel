@extends('layouts.app')

@section('title', 'Input Data Tentor')

@section('content')
<div style="padding: 10px; font-family: 'Poppins', sans-serif;">
    
    {{-- Header Judul --}}
    <h1 style="font-size: 20px; font-weight: 700; color: #111827; margin-bottom: 20px;">Input Data Tentor</h1>

    {{-- Container Form Utama --}}
    <div style="background: #F9FAFB; border-radius: 15px; padding: 30px; border: 1px solid #E5E7EB; box-shadow: 0 4px 10px rgba(0,0,0,0.02);">
        
        <form action="{{ route('superadmin.harga-paket.store') }}" method="POST">
            @csrf
            
            {{-- Bagian Atas: Full Width --}}
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">ID</label>
                <input type="text" name="id" value="A001" readonly 
                       style="width: 100%; padding: 12px 15px; border-radius: 10px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none; box-shadow: inset 0 2px 4px rgba(0,0,0,0.02);">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Nama Lengkap</label>
                <input type="text" name="nama" placeholder="Masukkan Nama Lengkap" required
                       style="width: 100%; padding: 12px 15px; border-radius: 10px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none;">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Alamat</label>
                <input type="text" name="alamat" placeholder="Masukkan Alamat" required
                       style="width: 100%; padding: 12px 15px; border-radius: 10px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none;">
            </div>

            <div style="margin-bottom: 30px;">
                <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">No HP</label>
                <input type="text" name="no_hp" placeholder="Masukkan No HP" required
                       style="width: 100%; padding: 12px 15px; border-radius: 10px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none;">
            </div>

            <hr style="border: 0; border-top: 1px solid #E5E7EB; margin-bottom: 30px;">

            {{-- Bagian Bawah: Grid 2 Kolom --}}
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px 40px;">
                
                {{-- Kolom Kiri --}}
                <div>
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Mapel</label>
                        <input type="text" name="mapel" placeholder="Masukkan Mapel"
                               style="width: 100%; padding: 12px 15px; border-radius: 10px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none;">
                    </div>
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Grade</label>
                        <input type="text" name="grade" placeholder="Masukkan Grade"
                               style="width: 100%; padding: 12px 15px; border-radius: 10px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none;">
                    </div>
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">HR SD</label>
                        <input type="text" name="hr_sd" placeholder="Masukkan HR SD"
                               style="width: 100%; padding: 12px 15px; border-radius: 10px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none;">
                    </div>
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">HR SMP</label>
                        <input type="text" name="hr_smp" placeholder="Masukkan HR SMP"
                               style="width: 100%; padding: 12px 15px; border-radius: 10px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none;">
                    </div>
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">HR SMA</label>
                        <input type="text" name="hr_sma" placeholder="Masukkan HR SMA"
                               style="width: 100%; padding: 12px 15px; border-radius: 10px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none;">
                    </div>
                </div>

                {{-- Kolom Kanan --}}
                <div>
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Uang Makan</label>
                        <input type="text" name="uang_makan" placeholder="Masukkan Uang Makan"
                               style="width: 100%; padding: 12px 15px; border-radius: 10px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none;">
                    </div>
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Uang Transport</label>
                        <input type="text" name="uang_transport" placeholder="Masukkan Uang Transport"
                               style="width: 100%; padding: 12px 15px; border-radius: 10px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none;">
                    </div>
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Email</label>
                        <input type="email" name="email" placeholder="Masukkan Email"
                               style="width: 100%; padding: 12px 15px; border-radius: 10px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none;">
                    </div>
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Username</label>
                        <input type="text" name="username" placeholder="Masukkan Username"
                               style="width: 100%; padding: 12px 15px; border-radius: 10px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none;">
                    </div>
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Password</label>
                        <input type="password" name="password" placeholder="Masukkan Password"
                               style="width: 100%; padding: 12px 15px; border-radius: 10px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none;">
                    </div>
                </div>
            </div>

            {{-- Tombol Aksi --}}
            <div style="display: flex; justify-content: flex-end; gap: 15px; margin-top: 40px;">
                <a href="{{ route('superadmin.kelola-tentor') }}" 
                   style="text-decoration: none; padding: 12px 60px; border: 1px solid #4D0B87; color: #4D0B87; border-radius: 10px; font-weight: 600; font-size: 16px; background: #FFFFFF;">
                    Keluar
                </a>
                <button type="submit" 
                        style="padding: 12px 60px; border: none; background: #4D0B87; color: white; border-radius: 10px; font-weight: 600; font-size: 16px; cursor: pointer; box-shadow: 0 4px 6px rgba(77, 11, 135, 0.2);">
                    Simpan
                </button>
            </div>

        </form>
    </div>
</div>
@endsection