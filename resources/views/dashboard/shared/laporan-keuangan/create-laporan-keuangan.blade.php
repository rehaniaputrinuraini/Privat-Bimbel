@extends('layouts.app')

@section('title', 'Input Pemasukan/Pengeluaran')

@section('content')
<div style="padding: 10px; font-family: 'Poppins', sans-serif;">
    
    {{-- Header Judul --}}
    <h1 style="font-size: 20px; font-weight: 700; color: #111827; margin-bottom: 20px;">Input Pemasukan/Pengeluaran</h1>

    {{-- Container Form Utama --}}
    <div style="background: #F9FAFB; border-radius: 15px; padding: 30px; border: 1.5px solid #E5E7EB; box-shadow: 0 4px 10px rgba(0,0,0,0.02);">
        
        <form action="{{ route($role . '.laporan-keuangan.store') }}" method="POST">
            @csrf
            
            {{-- Grid 2 Kolom (Kiri 2 input, Kanan 2 input) --}}
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0 40px;">
                
                {{-- KOLOM KIRI --}}
                <div>
                    {{-- Tanggal --}}
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Tanggal</label>
                        <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" required
                               style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none;">
                    </div>

                    {{-- Kategori --}}
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Kategori</label>
                        <select name="kategori" id="select-kategori" onchange="updateLabel()" required
                                style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none; color: #374151; cursor: pointer;">
                            <option value="" disabled selected>Pilih (Pemasukan/Pengeluaran)</option>
                            <option value="pemasukan">Pemasukan</option>
                            <option value="pengeluaran">Pengeluaran</option>
                        </select>
                    </div>
                </div>

                {{-- KOLOM KANAN --}}
                <div>
                    {{-- Rincian --}}
                    <div style="margin-bottom: 15px;">
                        <label id="label-rincian" style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Rincian Pemasukan</label>
                        <input type="text" id="input-rincian" name="rincian" placeholder="Masukkan Rincian Pemasukan" required
                               style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none;">
                    </div>

                    {{-- Jumlah --}}
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Jumlah</label>
                        <input type="text" name="jumlah" placeholder="Masukkan Jumlah" required
                               style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none;">
                    </div>
                </div>
            </div>

            <hr style="border: 0; border-top: 1px solid #E5E7EB; margin-bottom: 25px;">

            {{-- Tombol Aksi --}}
            <div style="display: flex; justify-content: flex-end; gap: 20px; margin-top: 30px;">
                <a href="{{ route($role . '.laporan-keuangan') }}" 
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

{{-- Script untuk Update Label Otomatis --}}
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