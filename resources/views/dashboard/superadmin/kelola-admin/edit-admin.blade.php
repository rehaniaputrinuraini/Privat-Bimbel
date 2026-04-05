@extends('layouts.app')

@section('title', 'Edit Data Admin')

@section('content')
<div style="padding: 10px; font-family: 'Poppins', sans-serif;">
    
    {{-- Header Judul --}}
    <h1 style="font-size: 20px; font-weight: 700; color: #111827; margin-bottom: 20px;">Edit Data Admin</h1>

    {{-- Container Form Utama --}}
    <div style="background: #F9FAFB; border-radius: 15px; padding: 30px; border: 1.5px solid #E5E7EB; box-shadow: 0 4px 10px rgba(0,0,0,0.02);" data-aos="fade-up">
        
        <form action="{{ route('superadmin.kelola-admin.update', $admin['id']) }}" method="POST">
            @csrf
            @method('PUT')
            
            {{-- ID (Readonly) --}}
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">ID</label>
                <input type="text" name="id" value="{{ $admin['id'] }}" readonly 
                       style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none; color: #6B7280;">
            </div>

            {{-- Nama Lengkap --}}
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Nama Lengkap</label>
                <input type="text" name="name" value="{{ $admin['nama'] }}" placeholder="Masukkan Nama Lengkap" required
                       style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none;">
            </div>

            {{-- Alamat --}}
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Alamat</label>
                <input type="text" name="alamat" value="{{ $admin['alamat'] }}" placeholder="Masukkan Alamat" required
                       style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none;">
            </div>

            {{-- Grid 2 Kolom --}}
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0 40px;">
                <div>
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">No Hp</label>
                        <input type="text" name="kontak" value="{{ $admin['no_hp'] }}" placeholder="Masukkan No HP"
                               style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none;">
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Gaji</label>
                        <input type="text" name="gaji" value="{{ $admin['gaji'] }}" placeholder="Masukkan Gaji"
                               style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none;">
                    </div>
                </div>
                <div>
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Username</label>
                        <input type="text" name="username" value="{{ $admin['username'] }}" placeholder="Masukkan Username"
                               style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none;">
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Password</label>
                        <input type="password" name="password" placeholder="Kosongkan jika tidak diubah"
                               style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none;">
                    </div>
                </div>
            </div>

            {{-- Tombol Aksi --}}
            <div style="display: flex; justify-content: flex-end; gap: 20px; margin-top: 30px;">
                <button type="button" onclick="bukaModalBatal()" 
                        style="padding: 10px 45px; border: 1.5px solid #4D0B87; color: #4D0B87; border-radius: 10px; font-weight: 600; font-size: 16px; background: #FFFFFF; cursor: pointer;">
                    Keluar
                </button>
                
                <button type="submit" 
                        style="padding: 10px 45px; border: none; background: #4D0B87; color: white; border-radius: 10px; font-weight: 600; font-size: 16px; cursor: pointer; box-shadow: 0 4px 6px rgba(77, 11, 135, 0.2);">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- =============================================
     MODAL KECIL (SMALL POP-UP)
============================================= --}}
<div id="modalBatal" style="display: none; position: fixed; z-index: 99999; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); backdrop-filter: blur(3px); align-items: center; justify-content: center;">
    <div style="background: white; padding: 25px; border-radius: 20px; width: 320px; text-align: center; box-shadow: 0 15px 30px rgba(0,0,0,0.15); font-family: 'Poppins', sans-serif;">
        
        <div style="color: #F59E0B; font-size: 40px; margin-bottom: 10px;">
            <i class="fas fa-exclamation-triangle"></i>
        </div>

        <h2 style="margin: 0; font-size: 18px; color: #111827; font-weight: 700;">Batalkan?</h2>
        <p style="color: #6B7280; font-size: 13px; margin: 8px 0 20px 0; line-height: 1.4;">
            Perubahan Anda tidak akan disimpan. Yakin ingin keluar?
        </p>

        <div style="display: flex; gap: 10px; justify-content: center;">
            {{-- Tombol Batal --}}
            <button onclick="tutupModalBatal()" style="flex: 1; padding: 10px; border-radius: 10px; border: 1px solid #E5E7EB; background: white; color: #374151; font-weight: 600; font-size: 13px; cursor: pointer;">
                Tidak
            </button>

            {{-- Tombol Iya --}}
            <a href="{{ route('superadmin.kelola-admin') }}" style="flex: 1; text-decoration: none;">
                <button type="button" style="width: 100%; padding: 10px; border-radius: 10px; border: none; background: #EF4444; color: white; font-weight: 600; font-size: 13px; cursor: pointer;">
                    Ya, Keluar
                </button>
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

    window.addEventListener('click', function(event) {
        let modal = document.getElementById('modalBatal');
        if (event.target == modal) {
            tutupModalBatal();
        }
    });
</script>
@endsection