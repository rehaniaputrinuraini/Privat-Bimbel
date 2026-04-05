@extends('layouts.app')

@section('title', 'Edit Profil Admin')

@section('content')
<div style="padding: 10px; font-family: 'Poppins', sans-serif;">
    
    {{-- Header Halaman --}}
    <div style="margin-bottom: 30px;">
        <h1 style="font-size: 28px; font-weight: 800; color: #111827; margin: 0;">Edit Profil Admin</h1>
        <p style="color: #6B7280; font-size: 16px; margin-top: 5px;">Perbarui Informasi Profil Anda</p>
    </div>

    {{-- Form Utama --}}
    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div style="display: flex; gap: 30px; align-items: flex-start;">
            
            {{-- KARTU FOTO PROFIL (KIRI) --}}
            <div style="flex: 1; background: white; padding: 40px 20px; border-radius: 20px; border: 1px solid #E5E7EB; box-shadow: 0 4px 20px rgba(0,0,0,0.05); text-align: center;">
                {{-- Foto Profil (Bulatan Besar Ungu) --}}
                <div style="width: 180px; height: 180px; background: #4D0B87; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 25px; position: relative;">
                    <span style="color: white; font-size: 70px; font-weight: 800;">SA</span>
                    
                    {{-- Tombol Hapus Foto (Ikon Tempat Sampah Merah) --}}
                    <button type="button" style="position: absolute; bottom: 5px; right: 5px; background: #EF4444; color: white; border: none; width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 2px 5px rgba(0,0,0,0.2);">
                        <i class="fas fa-trash-alt" style="font-size: 18px;"></i>
                    </button>
                </div>
                
                {{-- Tombol Unggah Foto Baru --}}
                <label for="foto_profil" style="display: flex; align-items: center; justify-content: center; gap: 10px; color: #4D0B87; font-weight: 700; font-size: 18px; cursor: pointer; margin-bottom: 10px;">
                    <i class="fas fa-upload"></i> Unggah Foto
                </label>
                <input type="file" id="foto_profil" name="foto_profil" style="display: none;">
                
                <p style="color: #6B7280; font-size: 14px; margin: 0;">Format: PNG, JPG (Max. 2MB)</p>
            </div>

            {{-- FORM INFORMASI PROFIL (KANAN) --}}
            <div style="flex: 2; background: white; padding: 35px; border-radius: 20px; border: 1px solid #E5E7EB; box-shadow: 0 4px 20px rgba(0,0,0,0.05);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
                    <h2 style="font-size: 22px; font-weight: 800; color: #111827; margin: 0;">Informasi Profil</h2>
                    {{-- Tombol Simpan (Ungu) --}}
                    <button type="submit" style="background: #4D0B87; color: white; border: none; padding: 12px 35px; border-radius: 10px; font-weight: 700; cursor: pointer; font-size: 16px; box-shadow: 0 4px 10px rgba(77, 11, 135, 0.2);">
                        Simpan
                    </button>
                </div>
                
                {{-- Field Input Nama Lengkap --}}
                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 8px;">Nama Lengkap</label>
                    <input type="text" name="name" value="Sari Putri" placeholder="Masukkan Nama Lengkap"
                           style="width: 100%; padding: 14px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: white; color: #111827; font-size: 15px; outline: none;">
                </div>

                {{-- Field Input Email --}}
                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 8px;">Email</label>
                    <input type="email" name="email" value="SariPutri@gmail.com" placeholder="Masukkan Email"
                           style="width: 100%; padding: 14px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: white; color: #111827; font-size: 15px; outline: none;">
                </div>

                {{-- Field Input Kontak --}}
                <div style="margin-bottom: 10px;">
                    <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 8px;">Kontak</label>
                    <input type="text" name="phone" value="0099887766" placeholder="Masukkan Nomor Kontak"
                           style="width: 100%; padding: 14px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: white; color: #111827; font-size: 15px; outline: none;">
                </div>
            </div>

        </div>
    </form>

    {{-- Link Ubah Kata Sandi (Ungu) --}}
    <div style="margin-top: 30px;">
        <a href="{{ route('password.edit') }}" style="text-decoration: none; display: flex; align-items: center; gap: 10px; color: #4D0B87; font-weight: 700; font-size: 18px;">
            Ubah Kata Sandi <i class="fas fa-arrow-right"></i>
        </a>
    </div>

</div>
@endsection