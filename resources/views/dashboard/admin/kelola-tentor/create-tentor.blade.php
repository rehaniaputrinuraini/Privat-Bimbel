@extends('layouts.app')

@section('title', 'Input Data Tentor')

@section('content')
<div style="padding: 10px; font-family: 'Poppins', sans-serif;">
    
    {{-- Header Judul --}}
    <h1 style="font-size: 20px; font-weight: 700; color: #111827; margin-bottom: 20px;">Input Data Tentor</h1>

    {{-- Container Form Utama --}}
    <div style="background: #F9FAFB; border-radius: 15px; padding: 30px; border: 1.5px solid #E5E7EB; box-shadow: 0 4px 10px rgba(0,0,0,0.02);">
        
        <form action="{{ route($role . '.data-tentor.store') }}" method="POST">
            @csrf
            
            {{-- ID (Readonly) --}}
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">ID</label>
                <input type="text" name="id" value="TE0004" readonly 
                       style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none; color: #6B7280;">
            </div>

            {{-- Nama Lengkap --}}
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Nama Lengkap</label>
                <input type="text" name="nama" placeholder="Masukkan Nama Lengkap" required
                       style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none;">
            </div>

            {{-- Alamat --}}
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Alamat</label>
                <input type="text" name="alamat" placeholder="Masukkan Alamat" required
                       style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none;">
            </div>

            {{-- No HP --}}
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">No HP</label>
                <input type="text" name="no_hp" placeholder="Masukkan No HP" required
                       style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none;">
            </div>

            <hr style="border: 0; border-top: 1px solid #E5E7EB; margin-bottom: 25px;">

            {{-- Grid 2 Kolom --}}
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0 40px;">
                
                {{-- Kolom Kiri --}}
                <div>
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Mapel</label>
                        <input type="text" name="mapel" placeholder="Masukkan Mapel"
                               style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none;">
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Grade</label>
                        <select name="grade" required
                                style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none; color: #374151; cursor: pointer;">
                            <option value="">Pilih Grade</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                        </select>
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">HR SD</label>
                        <input type="text" name="hr_sd" placeholder="Masukkan HR SD"
                               style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none;">
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">HR SMP</label>
                        <input type="text" name="hr_smp" placeholder="Masukkan HR SMP"
                               style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none;">
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">HR SMA</label>
                        <input type="text" name="hr_sma" placeholder="Masukkan HR SMA"
                               style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none;">
                    </div>
                </div>

                {{-- Kolom Kanan --}}
                <div>
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Uang Makan</label>
                        <input type="text" name="uang_makan" placeholder="Masukkan Uang Makan"
                               style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none;">
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Uang Transport</label>
                        <input type="text" name="uang_transport" placeholder="Masukkan Uang Transport"
                               style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none;">
                    </div>
                </div>
            </div>

            {{-- Tombol Aksi --}}
            <div style="display: flex; justify-content: flex-end; gap: 20px; margin-top: 30px;">
                <a href="{{ route($role . '.data-tentor') }}" 
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