@extends('layouts.app')

@section('title', 'Edit Data Murid')

@section('content')
<div style="padding: 10px; font-family: 'Poppins', sans-serif;">
    <h1 style="font-size: 20px; font-weight: 700; color: #111827; margin-bottom: 20px;">Edit Data Murid</h1>

    <div style="background: #F9FAFB; border-radius: 15px; padding: 30px; border: 1.5px solid #E5E7EB; box-shadow: 0 4px 10px rgba(0,0,0,0.02);">
        <form action="{{ route($role . '.murid.update', $murid->id_murid) }}" method="POST" id="mainForm">
            @csrf
            @method('PUT')

            {{-- ID Murid (READONLY) --}}
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">ID Murid</label>
                <input type="text" value="{{ $murid->id_murid }}" readonly 
                       style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #F3F4F6; outline: none; color: #6B7280; font-size: 14px;">
            </div>

            {{-- Nama Lengkap --}}
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $murid->nama_lengkap) }}" 
                       placeholder="Masukkan Nama Lengkap"
                       style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none; font-size: 14px;">
                @error('nama_lengkap') <small style="color: red;">{{ $message }}</small> @enderror
            </div>

            {{-- Asal Sekolah --}}
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Asal Sekolah</label>
                <input type="text" name="asal_sekolah" value="{{ old('asal_sekolah', $murid->asal_sekolah) }}" 
                       placeholder="Masukkan Asal Sekolah"
                       style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none; font-size: 14px;">
                @error('asal_sekolah') <small style="color: red;">{{ $message }}</small> @enderror
            </div>

            {{-- Alamat --}}
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Alamat</label>
                <textarea name="alamat" rows="3" placeholder="Masukkan Alamat Lengkap"
                          style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none; font-family: 'Poppins', sans-serif; font-size: 14px; resize: vertical;">{{ old('alamat', $murid->alamat) }}</textarea>
                @error('alamat') <small style="color: red;">{{ $message }}</small> @enderror
            </div>

            <hr style="border: 0; border-top: 1px solid #E5E7EB; margin-bottom: 25px;">

            {{-- GRID 2 KOLOM --}}
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0 40px; align-items: start;">
                {{-- KOLOM KIRI --}}
                <div>
                    {{-- No HP Siswa --}}
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">No HP Siswa</label>
                        <input type="tel" inputmode="numeric" name="no_hp" value="{{ old('no_hp', $murid->no_hp) }}" 
                               placeholder="Masukkan No HP Siswa"
                               onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                               oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                               style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none; font-size: 14px;">
                        @error('no_hp') <small style="color: red;">{{ $message }}</small> @enderror
                    </div>

                    {{-- Nama Orang Tua --}}
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Nama Orang Tua</label>
                        <input type="text" name="nama_orang_tua" value="{{ old('nama_orang_tua', $murid->nama_orang_tua) }}" 
                               placeholder="Masukkan Nama Orang Tua"
                               style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none; font-size: 14px;">
                        @error('nama_orang_tua') <small style="color: red;">{{ $message }}</small> @enderror
                    </div>

                    {{-- No HP Orang Tua --}}
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">No HP Orang Tua</label>
                        <input type="tel" inputmode="numeric" name="no_hp_orang_tua" value="{{ old('no_hp_orang_tua', $murid->no_hp_orang_tua) }}" 
                               placeholder="Masukkan No HP Orang Tua"
                               onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                               oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                               style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none; font-size: 14px;">
                        @error('no_hp_orang_tua') <small style="color: red;">{{ $message }}</small> @enderror
                    </div>
                </div>

                {{-- KOLOM KANAN --}}
                <div>
                    {{-- Tahun Masuk --}}
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Tahun Masuk</label>
                        <input type="tel" inputmode="numeric" name="tahun_masuk" value="{{ old('tahun_masuk', $murid->tahun_masuk) }}" 
                               placeholder="Masukkan Tahun Masuk"
                               min="2000" max="{{ date('Y') }}"
                               onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                               oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                               style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none; font-size: 14px;">
                        @error('tahun_masuk') <small style="color: red;">{{ $message }}</small> @enderror
                    </div>

                    {{-- Tanggal Daftar (READONLY) --}}
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Tanggal Daftar</label>
                        <input type="text" value="{{ $murid->tanggal_daftar ? date('d/m/Y', strtotime($murid->tanggal_daftar)) : '-' }}" readonly 
                               style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #F3F4F6; outline: none; color: #6B7280; font-size: 14px;">
                    </div>
                </div>
            </div>

            {{-- TOMBOL AKSI --}}
            <div style="display: flex; justify-content: flex-end; gap: 20px; margin-top: 30px;">
                <button type="button" onclick="bukaModalBatal()" 
                        style="padding: 10px 45px; border: 1.5px solid #4D0B87; color: #4D0B87; border-radius: 10px; font-weight: 600; font-size: 16px; background: #FFFFFF; cursor: pointer;">Keluar</button>
                <button type="submit" 
                        style="padding: 10px 45px; border: none; background: #4D0B87; color: white; border-radius: 10px; font-weight: 600; font-size: 16px; cursor: pointer; box-shadow: 0 4px 6px rgba(77, 11, 135, 0.2);">Update</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL SCRIPTS (SAMA SEPERTI CREATE) --}}
{{-- Copy script yang sama dari view create di atas --}}
@endsection