@extends('layouts.app')

@section('title', 'Edit Data Tentor')

@section('content')
<div style="padding: 10px; font-family: 'Poppins', sans-serif;">
    
    <h1 style="font-size: 20px; font-weight: 700; color: #111827; margin-bottom: 20px;">Edit Data Tentor</h1>

    @if($errors->any())
        <div style="background: #FEE2E2; color: #EF4444; padding: 12px; border-radius: 10px; margin-bottom: 20px;">
            <i class="fas fa-exclamation-circle"></i> 
            <ul style="margin: 5px 0 0 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div style="background: #F9FAFB; border-radius: 15px; padding: 30px; border: 1.5px solid #E5E7EB;">
        
        <form action="{{ route('superadmin.kelola-tentor.update', $tentor->id_tentor) }}" method="POST" id="mainForm">
            @csrf
            @method('PUT')
            
            {{-- ID (Readonly) --}}
            <div style="margin-bottom: 15px;">
                <label style="font-weight: 600;">ID Tentor</label>
                <input type="text" value="TE{{ str_pad($tentor->id_tentor, 4, '0', STR_PAD_LEFT) }}" readonly 
                       style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid #E5E7EB; background: #F3F4F6;">
            </div>

            {{-- Nama Lengkap --}}
            <div style="margin-bottom: 15px;">
                <label style="font-weight: 600;">Nama Lengkap <span style="color: red;">*</span></label>
                <input type="text" name="nama_lengkap_tentor" value="{{ old('nama_lengkap_tentor', $tentor->nama_lengkap_tentor) }}" required
                       style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid #E5E7EB;">
                @error('nama_lengkap_tentor') <small style="color: red;">{{ $message }}</small> @enderror
            </div>

            {{-- Alamat --}}
            <div style="margin-bottom: 15px;">
                <label style="font-weight: 600;">Alamat</label>
                <input type="text" name="alamat_tentor" value="{{ old('alamat_tentor', $tentor->alamat_tentor) }}"
                       style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid #E5E7EB;">
                @error('alamat_tentor') <small style="color: red;">{{ $message }}</small> @enderror
            </div>

            {{-- No HP --}}
            <div style="margin-bottom: 15px;">
                <label style="font-weight: 600;">No HP</label>
                <input type="text" name="no_hp_tentor" value="{{ old('no_hp_tentor', $tentor->no_hp_tentor) }}"
                       style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid #E5E7EB;">
                @error('no_hp_tentor') <small style="color: red;">{{ $message }}</small> @enderror
            </div>

            <hr style="border: 0; border-top: 1px solid #E5E7EB; margin-bottom: 25px;">

            {{-- Grid 2 Kolom --}}
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0 40px;">
                <div>
                    <div style="margin-bottom: 15px;">
                        <label style="font-weight: 600;">Mapel</label>
                        <input type="text" name="mapel" value="{{ old('mapel', $tentor->mapel) }}"
                               style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid #E5E7EB;">
                        @error('mapel') <small style="color: red;">{{ $message }}</small> @enderror
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="font-weight: 600;">Grade</label>
                        <select name="grade" style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid #E5E7EB;">
                            <option value="">Pilih Grade</option>
                            <option value="A" {{ old('grade', $tentor->grade) == 'A' ? 'selected' : '' }}>A</option>
                            <option value="B" {{ old('grade', $tentor->grade) == 'B' ? 'selected' : '' }}>B</option>
                        </select>
                        @error('grade') <small style="color: red;">{{ $message }}</small> @enderror
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="font-weight: 600;">HR SD</label>
                        <input type="number" name="hr_sd" value="{{ old('hr_sd', $tentor->hr_sd) }}"
                               style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid #E5E7EB;">
                        @error('hr_sd') <small style="color: red;">{{ $message }}</small> @enderror
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="font-weight: 600;">HR SMP</label>
                        <input type="number" name="hr_smp" value="{{ old('hr_smp', $tentor->hr_smp) }}"
                               style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid #E5E7EB;">
                        @error('hr_smp') <small style="color: red;">{{ $message }}</small> @enderror
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="font-weight: 600;">HR SMA</label>
                        <input type="number" name="hr_sma" value="{{ old('hr_sma', $tentor->hr_sma) }}"
                               style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid #E5E7EB;">
                        @error('hr_sma') <small style="color: red;">{{ $message }}</small> @enderror
                    </div>
                </div>
                <div>
                    <div style="margin-bottom: 15px;">
                        <label style="font-weight: 600;">Uang Makan</label>
                        <input type="number" name="uang_makan" value="{{ old('uang_makan', $tentor->uang_makan) }}"
                               style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid #E5E7EB;">
                        @error('uang_makan') <small style="color: red;">{{ $message }}</small> @enderror
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="font-weight: 600;">Uang Transport</label>
                        <input type="number" name="uang_transport" value="{{ old('uang_transport', $tentor->uang_transport) }}"
                               style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid #E5E7EB;">
                        @error('uang_transport') <small style="color: red;">{{ $message }}</small> @enderror
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="font-weight: 600;">Email <span style="color: red;">*</span></label>
                        <input type="email" name="email" value="{{ old('email', $tentor->user->email ?? '') }}" required
                               style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid #E5E7EB;">
                        @error('email') <small style="color: red;">{{ $message }}</small> @enderror
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="font-weight: 600;">Username <span style="color: red;">*</span></label>
                        <input type="text" name="username" value="{{ old('username', $tentor->user->username ?? '') }}" required
                               style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid #E5E7EB;">
                        @error('username') <small style="color: red;">{{ $message }}</small> @enderror
                    </div>
                </div>
            </div>

            {{-- Tombol Aksi --}}
            <div style="display: flex; justify-content: flex-end; gap: 20px; margin-top: 30px;">
                <button type="button" onclick="bukaModalBatal()" style="padding: 10px 45px; border: 1.5px solid #4D0B87; color: #4D0B87; border-radius: 10px; background: white; cursor: pointer;">Batal</button>
                <button type="submit" style="padding: 10px 45px; border: none; background: #4D0B87; color: white; border-radius: 10px; cursor: pointer;">Update</button>
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
            <a href="#" id="confirmKeluarLink" style="flex: 1; text-decoration: none;">
                <button type="button" style="width: 100%; padding: 10px; border-radius: 10px; border: none; background: #EF4444; color: white; font-weight: 600; font-size: 13px; cursor: pointer;">Ya, Keluar</button>
            </a>
        </div>
    </div>
</div>

{{-- MODAL PERINGATAN PERUBAHAN BELUM DISIMPAN --}}
<div id="modalPindahHalaman" style="display: none; position: fixed; z-index: 10000; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); backdrop-filter: blur(3px); align-items: center; justify-content: center;">
    <div style="background: white; padding: 25px; border-radius: 20px; width: 320px; text-align: center; box-shadow: 0 15px 30px rgba(0,0,0,0.15); font-family: 'Poppins', sans-serif;">
        <div style="color: #F59E0B; font-size: 40px; margin-bottom: 10px;"><i class="fas fa-exclamation-triangle"></i></div>
        <h2 style="margin: 0; font-size: 18px; color: #111827; font-weight: 700;">Perubahan Belum Disimpan</h2>
        <p style="color: #6B7280; font-size: 13px; margin: 8px 0 20px 0;">Ada data yang belum disimpan. Yakin ingin meninggalkan halaman ini?</p>
        <div style="display: flex; gap: 10px; justify-content: center;">
            <button onclick="tutupModalPindah()" style="flex: 1; padding: 10px; border-radius: 10px; border: 1px solid #E5E7EB; background: white; font-weight: 600; font-size: 13px; cursor: pointer;">Tidak</button>
            <button id="confirmPindahBtn" style="flex: 1; padding: 10px; border-radius: 10px; border: none; background: #EF4444; color: white; font-weight: 600; font-size: 13px; cursor: pointer;">Ya, Keluar</button>
        </div>
    </div>
</div>

<script>
    // ========== UNSAVED CHANGES WARNING ==========
    let formChanged = false;
    let pendingUrl = null;
    const form = document.getElementById('mainForm');
    
    if (form) {
        const inputs = form.querySelectorAll('input:not([readonly]), select, textarea');
        inputs.forEach(input => {
            input.addEventListener('change', () => formChanged = true);
            input.addEventListener('keyup', () => formChanged = true);
        });
        form.addEventListener('submit', () => formChanged = false);
    }
    
    function bukaModalBatal() { 
        if (formChanged) {
            document.getElementById('modalPindahHalaman').style.display = 'flex';
            document.getElementById('confirmPindahBtn').onclick = function() {
                formChanged = false;
                window.location.href = "{{ route('superadmin.kelola-tentor') }}";
            };
        } else {
            document.getElementById('modalBatal').style.display = 'flex';
            document.getElementById('confirmKeluarLink').href = "{{ route('superadmin.kelola-tentor') }}";
        }
    }
    
    function tutupModalBatal() { document.getElementById('modalBatal').style.display = 'none'; }
    function tutupModalPindah() { document.getElementById('modalPindahHalaman').style.display = 'none'; pendingUrl = null; }
    
    document.addEventListener('DOMContentLoaded', function() {
        const sidebarLinks = document.querySelectorAll('.sidebar-nav a, .sidebar-footer a, .logout-btn');
        sidebarLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                if (formChanged) {
                    e.preventDefault();
                    const targetUrl = this.href || (this.tagName === 'BUTTON' ? null : this.getAttribute('href'));
                    if (targetUrl && targetUrl !== '#') {
                        pendingUrl = targetUrl;
                        document.getElementById('modalPindahHalaman').style.display = 'flex';
                        document.getElementById('confirmPindahBtn').onclick = function() {
                            formChanged = false;
                            window.location.href = pendingUrl;
                        };
                    } else if (this.classList.contains('logout-btn')) {
                        pendingUrl = "{{ route('logout') }}";
                        document.getElementById('modalPindahHalaman').style.display = 'flex';
                        document.getElementById('confirmPindahBtn').onclick = function() {
                            formChanged = false;
                            document.getElementById('modalPindahHalaman').style.display = 'none';
                            bukaModalLogout();
                        };
                    }
                }
            });
        });
    });
    
    window.onclick = function(event) {
        let modalBatal = document.getElementById('modalBatal');
        let modalPindah = document.getElementById('modalPindahHalaman');
        if (event.target == modalBatal) tutupModalBatal();
        if (event.target == modalPindah) tutupModalPindah();
    }
</script>
@endsection