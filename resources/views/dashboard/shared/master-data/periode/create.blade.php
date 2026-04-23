@extends('layouts.app')

@section('title', 'Tambah Periode')

@section('content')
<div style="padding: 10px; font-family: 'Poppins', sans-serif;">
    <h1 style="font-size: 20px; font-weight: 700; color: #111827; margin-bottom: 20px;">Tambah Periode</h1>

    <div style="background: #F9FAFB; border-radius: 15px; padding: 30px; border: 1.5px solid #E5E7EB;">
        <form action="{{ route($role . '.periode.store') }}" method="POST" id="mainForm">
            @csrf
            
            {{-- Tahun Periode --}}
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Tahun Periode <span style="color: red;">*</span></label>
                <input type="text" name="tahun_periode" value="{{ old('tahun_periode') }}" 
                       placeholder="Contoh: 2024/2025" maxlength="9" required
                       style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; outline: none;">
                <small style="color: #6B7280;">Format: YYYY/YYYY (contoh: 2024/2025)</small>
                @error('tahun_periode') <br><small style="color: red;">{{ $message }}</small> @enderror
            </div>

            {{-- Tanggal Mulai --}}
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Tanggal Mulai <span style="color: red;">*</span></label>
                <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}" required
                       style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; outline: none;">
                @error('tanggal_mulai') <small style="color: red;">{{ $message }}</small> @enderror
            </div>

            {{-- Tanggal Selesai --}}
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Tanggal Selesai <span style="color: red;">*</span></label>
                <input type="date" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}" required
                       style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; outline: none;">
                @error('tanggal_selesai') <small style="color: red;">{{ $message }}</small> @enderror
            </div>

            {{-- Tombol --}}
            <div style="display: flex; justify-content: flex-end; gap: 20px; margin-top: 30px;">
                <a href="{{ route($role . '.master-data') }}" style="padding: 10px 45px; border: 1.5px solid #4D0B87; color: #4D0B87; border-radius: 10px; font-weight: 600; text-decoration: none;">Keluar</a>
                <button type="submit" style="padding: 10px 45px; border: none; background: #4D0B87; color: white; border-radius: 10px; font-weight: 600;">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection