@extends('layouts.app')

@section('title', 'Profil ' . ucfirst(Auth::user()->peran ?? 'Admin'))

@section('content')
<div style="padding: 10px; font-family: 'Poppins', sans-serif;">
    
    {{-- 1. HEADER HALAMAN --}}
    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 30px;">
        <div>
            {{-- OTOMATIS: Profil Superadmin / Profil Admin --}}
            <h1 style="font-size: 28px; font-weight: 800; color: #111827; margin: 0;">
                Profil {{ ucfirst(Auth::user()->peran ?? 'Admin') }}
            </h1>
            <p style="color: #6B7280; font-size: 16px; margin-top: 5px;">Informasi Profil</p>
        </div>
        {{-- Tombol Edit Profil --}}
        <a href="{{ route('profile.edit') }}" style="text-decoration: none;">
            <button style="background: #4D0B87; color: white; border: none; padding: 12px 35px; border-radius: 10px; font-weight: 700; cursor: pointer; font-size: 16px; box-shadow: 0 4px 10px rgba(77, 11, 135, 0.2);">
                Edit Profil
            </button>
        </a>
    </div>

    <div style="display: flex; gap: 30px; align-items: flex-start;">
        
        {{-- 2. KARTU FOTO PROFIL (SISI KIRI) --}}
        <div style="flex: 1; background: white; padding: 40px 20px; border-radius: 20px; border: 1px solid #E5E7EB; box-shadow: 0 4px 20px rgba(0,0,0,0.05); text-align: center;">
            <div style="width: 180px; height: 180px; background: #4D0B87; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 25px;">
                <span style="color: white; font-size: 70px; font-weight: 800;">
                    {{-- Inisial Nama Otomatis --}}
                    {{ strtoupper(substr(Auth::user()->name ?? 'SA', 0, 2)) }}
                </span>
            </div>
            
            <button style="background: none; border: none; color: #4D0B87; font-weight: 700; font-size: 18px; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 10px; margin: 0 auto 10px;">
                <i class="fas fa-upload"></i> Ubah Foto
            </button>
            <p style="color: #6B7280; font-size: 14px; margin: 0;">Format: PNG, JPG (Max. 2MB)</p>
        </div>

        {{-- 3. FORM INFORMASI PROFIL (SISI KANAN) --}}
        <div style="flex: 2; background: white; padding: 35px; border-radius: 20px; border: 1px solid #E5E7EB; box-shadow: 0 4px 20px rgba(0,0,0,0.05);">
            <h2 style="font-size: 22px; font-weight: 800; color: #111827; margin: 0 0 25px 0;">Informasi Profil</h2>
            
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 8px;">Nama Lengkap</label>
                <input type="text" value="{{ Auth::user()->name ?? 'Sari Putri' }}" readonly
                       style="width: 100%; padding: 14px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: white; color: #4B5563; font-size: 15px; outline: none;">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 8px;">Email</label>
                <input type="email" value="{{ Auth::user()->email ?? 'SariPutri@gmail.com' }}" readonly
                       style="width: 100%; padding: 14px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: white; color: #4B5563; font-size: 15px; outline: none;">
            </div>

            <div style="margin-bottom: 10px;">
                <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 8px;">Kontak</label>
                <input type="text" value="{{ Auth::user()->kontak ?? '0099887766' }}" readonly
                       style="width: 100%; padding: 14px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: white; color: #4B5563; font-size: 15px; outline: none;">
            </div>
        </div>

    </div>

    {{-- 4. LINK UBAH KATA SANDI --}}
    <div style="margin-top: 30px;">
        <a href="{{ route('password.edit') }}" style="text-decoration: none; display: flex; align-items: center; gap: 10px; color: #4D0B87; font-weight: 700; font-size: 18px; width: fit-content;">
            Ubah Kata Sandi <i class="fas fa-arrow-right"></i>
        </a>
    </div>

</div>
@endsection