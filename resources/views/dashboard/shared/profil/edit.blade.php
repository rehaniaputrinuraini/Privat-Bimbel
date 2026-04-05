@extends('layouts.app')

@section('title', 'Edit Profil Admin')

@section('content')
<div style="padding: 10px; font-family: 'Poppins', sans-serif;">
    
    {{-- MODAL KONFIRMASI KELUAR --}}
    <div id="modalBatal" style="display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); backdrop-filter: blur(3px); align-items: center; justify-content: center;">
        <div style="background: white; padding: 25px; border-radius: 20px; width: 320px; text-align: center; box-shadow: 0 15px 30px rgba(0,0,0,0.15); font-family: 'Poppins', sans-serif;">
            <div style="color: #F59E0B; font-size: 40px; margin-bottom: 10px;"><i class="fas fa-exclamation-triangle"></i></div>
            <h2 style="margin: 0; font-size: 18px; color: #111827; font-weight: 700;">Batalkan?</h2>
            <p style="color: #6B7280; font-size: 13px; margin: 8px 0 20px 0;">Data yang Anda masukkan tidak akan disimpan. Yakin ingin keluar?</p>
            <div style="display: flex; gap: 10px; justify-content: center;">
                <button onclick="tutupModalBatal()" style="flex: 1; padding: 10px; border-radius: 10px; border: 1px solid #E5E7EB; background: white; font-weight: 600; font-size: 13px; cursor: pointer;">Tidak</button>
                <a href="{{ route('profile.index') }}" style="flex: 1; text-decoration: none;">
                    <button type="button" style="width: 100%; padding: 10px; border-radius: 10px; border: none; background: #EF4444; color: white; font-weight: 600; font-size: 13px; cursor: pointer;">Ya, Keluar</button>
                </a>
            </div>
        </div>
    </div>

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
                <div style="width: 180px; height: 180px; background: #4D0B87; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 25px; position: relative;">
                    {{-- Inisial Nama atau Foto --}}
                    <span style="color: white; font-size: 70px; font-weight: 800;">SA</span>
                    
                    {{-- Tombol Hapus Foto --}}
                    <button type="button" style="position: absolute; bottom: 5px; right: 5px; background: #EF4444; color: white; border: none; width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 2px 5px rgba(0,0,0,0.2);">
                        <i class="fas fa-trash-alt" style="font-size: 18px;"></i>
                    </button>
                </div>
                
                <label for="foto_profil" style="display: flex; align-items: center; justify-content: center; gap: 10px; color: #4D0B87; font-weight: 700; font-size: 18px; cursor: pointer; margin-bottom: 10px;">
                    <i class="fas fa-upload"></i> Unggah Foto
                </label>
                <input type="file" id="foto_profil" name="foto_profil" style="display: none;">
                
                <p style="color: #6B7280; font-size: 14px; margin: 0;">Format: PNG, JPG (Max. 2MB)</p>
            </div>

            {{-- FORM INFORMASI PROFIL (KANAN) --}}
            <div style="flex: 2; background: white; padding: 35px; border-radius: 20px; border: 1px solid #E5E7EB; box-shadow: 0 4px 20px rgba(0,0,0,0.05);">
                
                {{-- HEADER INFORMASI PROFIL DENGAN TOMBOL PANAH --}}
                <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 25px;">
                    {{-- TOMBOL PANAH (Background Ungu Tua, Panah Putih) --}}
                    <button type="button" onclick="bukaModalBatal()"
                            style="display: flex; align-items: center; justify-content: center; width: 42px; height: 42px; background-color: #4D0B87; border-radius: 50%; border: none; cursor: pointer; color: white; box-shadow: 0 4px 6px rgba(0,0,0,0.1); transition: all 0.3s ease;"
                            onmouseover="this.style.transform='scale(1.1)'; this.style.backgroundColor='#3a0866';" 
                            onmouseout="this.style.transform='scale(1)'; this.style.backgroundColor='#4D0B87';">
                        <i class="fas fa-arrow-left" style="font-size: 18px;"></i>
                    </button>
                    <h2 style="font-size: 22px; font-weight: 800; color: #111827; margin: 0;">Informasi Profil</h2>
                </div>
                
                {{-- Input Fields --}}
                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 8px;">Nama Lengkap</label>
                    <input type="text" name="name" value="Sari Putri" placeholder="Masukkan Nama Lengkap"
                           style="width: 100%; padding: 14px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: white; color: #111827; font-size: 15px; outline: none; box-sizing: border-box;">
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 8px;">Email</label>
                    <input type="email" name="email" value="rehania2018putri@gmail.com" placeholder="Masukkan Email"
                           style="width: 100%; padding: 14px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: white; color: #111827; font-size: 15px; outline: none; box-sizing: border-box;">
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 8px;">Kontak</label>
                    <input type="text" name="phone" value="0099887766" placeholder="Masukkan Nomor Kontak"
                           style="width: 100%; padding: 14px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: white; color: #111827; font-size: 15px; outline: none; box-sizing: border-box;">
                </div>

                {{-- TOMBOL SIMPAN --}}
                <div style="display: flex; justify-content: flex-end; margin-top: 30px;">
                    <button type="submit" style="background: #4D0B87; color: white; border: none; padding: 12px 65px; border-radius: 12px; font-weight: 600; font-size: 18px; cursor: pointer; box-shadow: 0 4px 10px rgba(77, 11, 135, 0.3); transition: 0.3s;"
                            onmouseover="this.style.opacity='0.9'; this.style.transform='translateY(-2px)';"
                            onmouseout="this.style.opacity='1'; this.style.transform='translateY(0)';" >
                        Simpan
                    </button>
                </div>
            </div>

        </div>
    </form>

    {{-- Link Ubah Kata Sandi --}}
    <div style="margin-top: 30px;">
        <a href="{{ route('password.edit') }}" style="text-decoration: none; display: inline-flex; align-items: center; gap: 10px; color: #4D0B87; font-weight: 700; font-size: 18px; transition: 0.3s;" onmouseover="this.style.gap='15px'" onmouseout="this.style.gap='10px'">
            Ubah Kata Sandi <i class="fas fa-arrow-right"></i>
        </a>
    </div>

</div>

<script>
    function bukaModalBatal() {
        document.getElementById('modalBatal').style.display = 'flex';
    }
    function tutupModalBatal() {
        document.getElementById('modalBatal').style.display = 'none';
    }
    
    // Tutup modal jika klik di luar kotak putih
    window.onclick = function(event) {
        let modal = document.getElementById('modalBatal');
        if (event.target == modal) {
            tutupModalBatal();
        }
    }
</script>
@endsection 