@extends('layouts.app')

@section('title', 'Input Pemasukan/Pengeluaran')

@section('content')
<div style="padding: 10px; font-family: 'Poppins', sans-serif;">
    
    {{-- Header Judul --}}
    <h1 style="font-size: 20px; font-weight: 700; color: #111827; margin-bottom: 20px;">Input Pemasukan/Pengeluaran</h1>

    {{-- Container Form Utama --}}
    <div style="background: #F9FAFB; border-radius: 15px; padding: 35px; border: 1.5px solid #E5E7EB; box-shadow: 0 4px 10px rgba(0,0,0,0.02);">
        
        {{-- Pastikan action mengarah ke route store yang benar --}}
        <form action="{{ route($role . '.laporan-keuangan.store') }}" method="POST">
            @csrf
            
            {{-- Grid 2 Kolom --}}
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 25px 40px;">
                
                {{-- SISI KIRI --}}
                <div>
                    {{-- Tanggal --}}
                    <div style="margin-bottom: 25px;">
                        <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 10px;">Tanggal</label>
                        <input type="text" name="tanggal" value="{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}" 
                               style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 2px solid #3B82F6; background: #FFFFFF; outline: none; box-shadow: 0 2px 4px rgba(59, 130, 246, 0.1);" readonly>
                    </div>

                    {{-- Rincian --}}
                    <div>
                        <label id="label-rincian" style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 10px;">Rincian Pemasukan</label>
                        <input type="text" id="input-rincian" name="rincian" placeholder="Masukkan Rincian Pemasukan" required
                               style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #D1D5DB; background: #FFFFFF; outline: none; transition: 0.3s;"
                               onfocus="this.style.borderColor='#4D0B87'">
                    </div>
                </div>

                {{-- SISI KANAN --}}
                <div>
                    {{-- Kategori --}}
                    <div style="margin-bottom: 25px;">
                        <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 10px;">Kategori</label>
                        <select name="kategori" id="select-kategori" onchange="updateLabel()" required
                                style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #D1D5DB; background: #FFFFFF; outline: none; color: #111827; cursor: pointer;">
                            <option value="" disabled selected>Pilih (Pemasukan/Pengeluaran)</option>
                            <option value="pemasukan">Pemasukan</option>
                            <option value="pengeluaran">Pengeluaran</option>
                        </select>
                    </div>

                    {{-- Jumlah --}}
                    <div>
                        <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 10px;">Jumlah</label>
                        <input type="number" name="jumlah" placeholder="Masukkan Jumlah" required
                               style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #D1D5DB; background: #FFFFFF; outline: none; transition: 0.3s;"
                               onfocus="this.style.borderColor='#4D0B87'">
                    </div>
                </div>
            </div>

            {{-- Tombol Aksi (Kanan Bawah) --}}
            <div style="display: flex; justify-content: flex-end; gap: 20px; margin-top: 40px;">
                {{-- Tombol Keluar --}}
                <a href="{{ route($role . '.laporan-keuangan') }}" 
                   style="text-decoration: none; padding: 12px 65px; border: 1.5px solid #4D0B87; color: #4D0B87; border-radius: 12px; font-weight: 600; font-size: 18px; background: #FFFFFF; text-align: center; transition: 0.3s;"
                   onmouseover="this.style.background='#F3E8FF'" onmouseout="this.style.background='#FFFFFF'">
                    Keluar
                </a>
                {{-- Tombol Simpan --}}
                <button type="submit" 
                        style="padding: 12px 65px; border: none; background: #4D0B87; color: white; border-radius: 12px; font-weight: 600; font-size: 18px; cursor: pointer; box-shadow: 0 4px 6px rgba(77, 11, 135, 0.2); transition: 0.3s;"
                        onmouseover="this.style.background='#3D096B'" onmouseout="this.style.background='#4D0B87'">
                    Simpan
                </button>
            </div>

        </form>
    </div>
</div>

{{-- Script Sederhana untuk Update Label Otomatis --}}
<script>
    function updateLabel() {
        const kategori = document.getElementById('select-kategori').value;
        const label = document.getElementById('label-rincian');
        const input = document.getElementById('input-rincian');

        if (kategori === 'pengeluaran') {
            label.innerText = 'Rincian Pengeluaran';
            input.placeholder = 'Masukkan Rincian Pengeluaran';
        } else {
            label.innerText = 'Rincian Pemasukan';
            input.placeholder = 'Masukkan Rincian Pemasukan';
        }
    }
</script>
@endsection