@extends('layouts.app')

@section('title', 'Ubah Kata Sandi')

@section('content')
<div style="min-height: 80vh; display: flex; flex-direction: column; align-items: center; justify-content: center; font-family: 'Poppins', sans-serif; background-color: #f3f4f6; padding: 20px;">
    
    {{-- Logo dan Nama Bimbel --}}
    <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 30px;">
        <img src="{{ asset('images/logo-privat.png') }}" alt="Logo" style="width: 80px;">
        <h1 style="font-size: 32px; font-weight: 800; color: #4D0B87; margin: 0;">Bimbel Privat</h1>
    </div>

    {{-- Kartu Form Ubah Kata Sandi --}}
    <div style="background: white; width: 100%; max-width: 500px; padding: 40px; border-radius: 20px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); text-align: center;">
        
        <h2 style="font-size: 24px; font-weight: 700; color: #111827; margin: 0;">Ubah Kata Sandi</h2>
        <p style="color: #6B7280; font-size: 14px; margin: 10px 0 30px;">Masukkan Password Lama dan Password Baru Anda</p>

        <form action="#" method="POST">
            @csrf
            {{-- Input Password Lama --}}
            <div style="text-align: left; margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Password Lama</label>
                <input type="password" name="current_password" placeholder="Masukkan Password Lama" required
                       style="width: 100%; padding: 12px 15px; border-radius: 10px; border: 1px solid #E5E7EB; outline: none; transition: 0.3s; box-sizing: border-box;">
            </div>

            {{-- Input Password Baru --}}
            <div style="text-align: left; margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Password Baru</label>
                <input type="password" name="new_password" placeholder="Masukkan Password Baru" required
                       style="width: 100%; padding: 12px 15px; border-radius: 10px; border: 1px solid #E5E7EB; outline: none; transition: 0.3s; box-sizing: border-box;">
            </div>

            {{-- Konfirmasi Password Baru --}}
            <div style="text-align: left; margin-bottom: 30px;">
                <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Konfirmasi Password Baru</label>
                <input type="password" name="new_password_confirmation" placeholder="Konfirmasi Password Baru" required
                       style="width: 100%; padding: 12px 15px; border-radius: 10px; border: 1px solid #E5E7EB; outline: none; transition: 0.3s; box-sizing: border-box;">
            </div>

            {{-- Tombol Ubah Password --}}
            <button type="submit" style="width: 100%; background: #4D0B87; color: white; border: none; padding: 14px; border-radius: 10px; font-weight: 700; font-size: 16px; cursor: pointer; transition: 0.3s; margin-bottom: 20px;">
                Ubah Password
            </button>
        </form>

        {{-- Link Kembali --}}
        <a href="{{ route('profile.index') }}" style="color: #4D0B87; text-decoration: underline; font-weight: 600; font-size: 14px;">
            Kembali ke Profil
        </a>
    </div>
</div>
@endsection