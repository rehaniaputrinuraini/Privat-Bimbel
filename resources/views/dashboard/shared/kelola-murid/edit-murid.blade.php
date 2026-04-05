@extends('layouts.app')

@section('title', 'Edit Data Murid')

@section('content')
<div style="padding: 10px; font-family: 'Poppins', sans-serif;">
    
    <h1 style="font-size: 20px; font-weight: 700; color: #111827; margin-bottom: 20px;">Edit Data Murid</h1>

    <div style="background: #F9FAFB; border-radius: 15px; padding: 30px; border: 1.5px solid #E5E7EB; box-shadow: 0 4px 10px rgba(0,0,0,0.02);">
        
        <form action="{{ route($role . '.murid.update', $murid->id_murid) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">ID Murid</label>
                <input type="text" name="id_murid" value="{{ $murid->id_murid }}" readonly 
                       style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none; color: #6B7280;">
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Nama Lengkap</label>
                <input type="text" name="nama_lengkap_murid" value="{{ $murid->nama_lengkap_murid }}" placeholder="Masukkan Nama Lengkap" required
                       style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none;">
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Kelas</label>
                <input type="text" name="kelas" value="{{ $murid->kelas }}" placeholder="Masukkan Kelas"
                       style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none;">
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Asal Sekolah</label>
                <input type="text" name="asal_sekolah" value="{{ $murid->asal_sekolah }}" placeholder="Masukkan Asal Sekolah"
                       style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none;">
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Alamat</label>
                <input type="text" name="alamat_murid" value="{{ $murid->alamat_murid }}" placeholder="Masukkan Alamat"
                       style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none;">
            </div>

            <hr style="border: 0; border-top: 1px solid #E5E7EB; margin-bottom: 25px;">

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0 40px;">
                <div>
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">No HP Siswa</label>
                        <input type="text" name="no_hp_murid" value="{{ $murid->no_hp_murid }}" placeholder="Masukkan No HP"
                               style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none;">
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Nama Orang Tua</label>
                        <input type="text" name="nama_orang_tua" value="{{ $murid->nama_orang_tua }}" placeholder="Masukkan Nama Orang Tua"
                               style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none;">
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">No HP Orang Tua</label>
                        <input type="text" name="no_hp_orang_tua" value="{{ $murid->no_hp_orang_tua }}" placeholder="Masukkan No HP Orang Tua"
                               style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none;">
                    </div>
                </div>
                <div>
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Paket Awal</label>
                        <input type="text" name="paket_awal" value="{{ $murid->paket_awal }}" placeholder="Masukkan Paket Awal"
                               style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none;">
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Pilihan Paket</label>
                        <select name="pilihan_paket" 
                                style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none; color: #374151;">
                            <option value="">Pilih Paket</option>
                            <option value="SD" {{ $murid->pilihan_paket == 'SD' ? 'selected' : '' }}>SD</option>
                            <option value="SMP" {{ $murid->pilihan_paket == 'SMP' ? 'selected' : '' }}>SMP</option>
                            <option value="SMA" {{ $murid->pilihan_paket == 'SMA' ? 'selected' : '' }}>SMA</option>
                        </select>
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Tahun Masuk</label>
                        <input type="text" name="tahun_masuk" value="{{ $murid->tahun_masuk }}" placeholder="Masukkan Tahun Masuk"
                               style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none;">
                    </div>
                </div>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 20px; margin-top: 30px;">
                {{-- TOMBOL KELUAR: Diubah menjadi Button agar bisa memanggil modal --}}
                <button type="button" onclick="bukaModalBatal()" 
                        style="padding: 12px 65px; border: 1.5px solid #4D0B87; color: #4D0B87; border-radius: 12px; font-weight: 600; font-size: 18px; background: #FFFFFF; cursor: pointer;">
                    Keluar
                </button>
                <button type="submit" 
                        style="padding: 12px 65px; border: none; background: #4D0B87; color: white; border-radius: 12px; font-weight: 600; font-size: 18px; cursor: pointer; box-shadow: 0 4px 6px rgba(77, 11, 135, 0.2);">
                    Simpan
                </button>
            </div>

        </form>
    </div>
</div>

{{-- MODAL KONFIRMASI BATAL --}}
<div id="modalBatal" style="display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); backdrop-filter: blur(3px); align-items: center; justify-content: center;">
    <div style="background: white; padding: 25px; border-radius: 20px; width: 320px; text-align: center; box-shadow: 0 15px 30px rgba(0,0,0,0.15); font-family: 'Poppins', sans-serif;">
        <div style="color: #F59E0B; font-size: 40px; margin-bottom: 10px;"><i class="fas fa-exclamation-triangle"></i></div>
        <h2 style="margin: 0; font-size: 18px; color: #111827; font-weight: 700;">Batalkan?</h2>
        <p style="color: #6B7280; font-size: 13px; margin: 8px 0 20px 0;">Data yang Anda masukkan tidak akan disimpan. Yakin ingin keluar?</p>
        <div style="display: flex; gap: 10px; justify-content: center;">
            <button onclick="tutupModalBatal()" style="flex: 1; padding: 10px; border-radius: 10px; border: 1px solid #E5E7EB; background: white; font-weight: 600; font-size: 13px; cursor: pointer;">Tidak</button>
            <a href="{{ route($role . '.kelola-murid') }}" style="flex: 1; text-decoration: none;">
                <button type="button" style="width: 100%; padding: 10px; border-radius: 10px; border: none; background: #EF4444; color: white; font-weight: 600; font-size: 13px; cursor: pointer;">Ya, Keluar</button>
            </a>
        </div>
    </div>
</div>

<script>
    function bukaModalBatal() { 
        document.getElementById('modalBatal').style.display = 'flex'; 
    }
    
    function tutupModalBatal() { 
        document.getElementById('modalBatal').style.display = 'none'; 
    }

    // Menutup modal jika area luar kotak putih diklik
    window.onclick = function(event) {
        let modal = document.getElementById('modalBatal');
        if (event.target == modal) {
            tutupModalBatal();
        }
    }
</script>
@endsection