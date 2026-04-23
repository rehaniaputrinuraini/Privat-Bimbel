@extends('layouts.app')

@section('title', 'Input Data Murid')

@section('content')
<div style="padding: 10px; font-family: 'Poppins', sans-serif;">
    <h1 style="font-size: 20px; font-weight: 700; color: #111827; margin-bottom: 20px;">Input Data Murid</h1>

    <div style="background: #F9FAFB; border-radius: 15px; padding: 30px; border: 1.5px solid #E5E7EB; box-shadow: 0 4px 10px rgba(0,0,0,0.02);">
        <form action="{{ route($role . '.murid.store') }}" method="POST" id="mainForm">
            @csrf

            {{-- Nama Lengkap --}}
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Nama Lengkap <span style="color: red;">*</span></label>
                <input type="text" name="nama_lengkap" placeholder="Masukkan Nama Lengkap" 
                       value="{{ old('nama_lengkap') }}" required
                       style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none; font-size: 14px;">
                @error('nama_lengkap') <small style="color: red;">{{ $message }}</small> @enderror
            </div>

            {{-- DROPDOWN KELAS --}}
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Pilih Kelas <span style="color: red;">*</span></label>
                <select name="id_kelas" id="id_kelas" required 
                        style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none; font-size: 14px;">
                    <option value="">-- Pilih Kelas --</option>
                    @foreach($kelasList as $kelas)
                        @php
                            $sisaKursi = 10 - $kelas->jumlah_murid;
                        @endphp
                        <option value="{{ $kelas->id_kelas }}" 
                                data-jenjang="{{ $kelas->jenjang }}" 
                                data-nama="{{ $kelas->nama_kelas }}"
                                {{ old('id_kelas') == $kelas->id_kelas ? 'selected' : '' }}>
                            {{ $kelas->jenjang }} - {{ $kelas->nama_kelas }} ({{ $sisaKursi }} kursi tersedia)
                        </option>
                    @endforeach
                </select>
                <small id="infoKelas" style="color: #6B7280; display: block; margin-top: 5px;">Pilih kelas yang tersedia</small>
                @error('id_kelas') <small style="color: red;">{{ $message }}</small> @enderror
            </div>

            {{-- Asal Sekolah --}}
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Asal Sekolah</label>
                <input type="text" name="asal_sekolah" placeholder="Masukkan Asal Sekolah" 
                       value="{{ old('asal_sekolah') }}"
                       style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none; font-size: 14px;">
                @error('asal_sekolah') <small style="color: red;">{{ $message }}</small> @enderror
            </div>

            {{-- Alamat --}}
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Alamat</label>
                <textarea name="alamat" rows="3" placeholder="Masukkan Alamat Lengkap"
                          style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none; font-family: 'Poppins', sans-serif; font-size: 14px; resize: vertical;">{{ old('alamat') }}</textarea>
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
                        <input type="tel" inputmode="numeric" name="no_hp" placeholder="Masukkan No HP Siswa"
                               value="{{ old('no_hp') }}"
                               onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                               oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                               style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none; font-size: 14px;">
                        @error('no_hp') <small style="color: red;">{{ $message }}</small> @enderror
                    </div>

                    {{-- Nama Orang Tua --}}
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Nama Orang Tua</label>
                        <input type="text" name="nama_orang_tua" placeholder="Masukkan Nama Orang Tua"
                               value="{{ old('nama_orang_tua') }}"
                               style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none; font-size: 14px;">
                        @error('nama_orang_tua') <small style="color: red;">{{ $message }}</small> @enderror
                    </div>

                    {{-- No HP Orang Tua --}}
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">No HP Orang Tua</label>
                        <input type="tel" inputmode="numeric" name="no_hp_orang_tua" placeholder="Masukkan No HP Orang Tua"
                               value="{{ old('no_hp_orang_tua') }}"
                               onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                               oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                               style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none; font-size: 14px;">
                        @error('no_hp_orang_tua') <small style="color: red;">{{ $message }}</small> @enderror
                    </div>
                </div>

                {{-- KOLOM KANAN --}}
                <div>
                    {{-- DROPDOWN PAKET --}}
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Pilih Paket <span style="color: red;">*</span></label>
                        <select name="id_paket" id="id_paket" required 
                                style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none; font-size: 14px;">
                            <option value="">-- Pilih Paket --</option>
                            @foreach($paketList as $paket)
                                <option value="{{ $paket->id_paket }}" 
                                        data-tingkat="{{ $paket->tingkat }}" 
                                        data-harga="{{ $paket->harga }}"
                                        {{ old('id_paket') == $paket->id_paket ? 'selected' : '' }}>
                                    {{ $paket->tingkat }} - Rp {{ number_format($paket->harga, 0, ',', '.') }}
                                </option>
                            @endforeach
                        </select>
                        <small id="infoPaket" style="color: #6B7280; display: block; margin-top: 5px;">Pilih paket untuk melihat detail harga</small>
                        @error('id_paket') <small style="color: red;">{{ $message }}</small> @enderror
                    </div>

                    {{-- INFO HARGA PAKET --}}
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Detail Paket</label>
                        <div style="padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #F3F4F6;">
                            <span id="hargaPaket" style="font-weight: 700; color: #4D0B87;">-</span>
                            <span id="deskripsiPaket" style="display: block; font-size: 12px; color: #6B7280; margin-top: 5px;"></span>
                        </div>
                    </div>

                    {{-- Tahun Masuk --}}
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Tahun Masuk</label>
                        <input type="tel" inputmode="numeric" name="tahun_masuk" placeholder="Masukkan Tahun Masuk" 
                               value="{{ old('tahun_masuk', date('Y')) }}"
                               min="2000" max="{{ date('Y') }}"
                               onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                               oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                               style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none; font-size: 14px;">
                        @error('tahun_masuk') <small style="color: red;">{{ $message }}</small> @enderror
                    </div>

                    {{-- PERIODE (HIDDEN) --}}
                    <input type="hidden" name="id_periode" value="{{ $periodeAktif->id_periode ?? '' }}">
                </div>
            </div>

            {{-- TOMBOL AKSI --}}
            <div style="display: flex; justify-content: flex-end; gap: 20px; margin-top: 30px;">
                <button type="button" onclick="bukaModalBatal()" 
                        style="padding: 10px 45px; border: 1.5px solid #4D0B87; color: #4D0B87; border-radius: 10px; font-weight: 600; font-size: 16px; background: #FFFFFF; cursor: pointer;">Keluar</button>
                <button type="submit" 
                        style="padding: 10px 45px; border: none; background: #4D0B87; color: white; border-radius: 10px; font-weight: 600; font-size: 16px; cursor: pointer; box-shadow: 0 4px 6px rgba(77, 11, 135, 0.2);">Simpan</button>
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
            <a href="{{ route($role . '.kelola-murid') }}" id="confirmKeluarLink" style="flex: 1; text-decoration: none;">
                <button type="button" style="width: 100%; padding: 10px; border-radius: 10px; border: none; background: #EF4444; color: white; font-weight: 600; font-size: 13px; cursor: pointer;">Ya, Keluar</button>
            </a>
        </div>
    </div>
</div>

{{-- MODAL KONFIRMASI PINDAH HALAMAN --}}
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
    // ========== MAPPING JENJANG KE KELAS ==========
    const jenjangKelasMap = {
        'SD': ['1', '2', '3', '4', '5', '6'],
        'SMP': ['7', '8', '9'],
        'SMA': ['10', '11', '12']
    };
    
    // ========== EVENT: PILIH KELAS → AUTO PILIH PAKET ==========
    document.getElementById('id_kelas').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const jenjang = selectedOption.getAttribute('data-jenjang');
        const infoKelas = document.getElementById('infoKelas');
        
        if (this.value) {
            infoKelas.innerHTML = 'Kelas terpilih: ' + selectedOption.text;
            
            // Auto pilih paket sesuai jenjang
            if (jenjang) {
                const paketSelect = document.getElementById('id_paket');
                for (let i = 0; i < paketSelect.options.length; i++) {
                    if (paketSelect.options[i].getAttribute('data-tingkat') === jenjang) {
                        paketSelect.value = paketSelect.options[i].value;
                        paketSelect.dispatchEvent(new Event('change'));
                        break;
                    }
                }
            }
        } else {
            infoKelas.innerHTML = 'Pilih kelas yang tersedia';
        }
    });
    
    // ========== EVENT: PILIH PAKET → FILTER KELAS ==========
    document.getElementById('id_paket').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const tingkat = selectedOption.getAttribute('data-tingkat');
        const harga = selectedOption.getAttribute('data-harga');
        
        // Update info harga
        if (harga) {
            document.getElementById('hargaPaket').innerHTML = 'Rp ' + new Intl.NumberFormat('id-ID').format(harga);
            document.getElementById('deskripsiPaket').innerHTML = 'Paket ' + tingkat;
        } else {
            document.getElementById('hargaPaket').innerHTML = '-';
            document.getElementById('deskripsiPaket').innerHTML = '';
        }
        
        // Filter kelas berdasarkan tingkat paket
        const kelasSelect = document.getElementById('id_kelas');
        
        if (tingkat) {
            // Reset semua opsi
            for (let i = 0; i < kelasSelect.options.length; i++) {
                const opt = kelasSelect.options[i];
                if (opt.value === '') {
                    opt.style.display = ''; // Opsi default selalu tampil
                    continue;
                }
                
                const jenjangKelas = opt.getAttribute('data-jenjang');
                opt.style.display = (jenjangKelas === tingkat) ? '' : 'none';
            }
            
            // Reset pilihan kelas jika tidak sesuai
            const selectedKelas = kelasSelect.options[kelasSelect.selectedIndex];
            if (selectedKelas && selectedKelas.getAttribute('data-jenjang') !== tingkat) {
                kelasSelect.value = '';
                document.getElementById('infoKelas').innerHTML = 'Pilih kelas yang tersedia';
            }
        } else {
            // Tampilkan semua kelas
            for (let i = 0; i < kelasSelect.options.length; i++) {
                kelasSelect.options[i].style.display = '';
            }
        }
    });
    
    // ========== TRIGGER SAAT HALAMAN LOAD ==========
    document.addEventListener('DOMContentLoaded', function() {
        const paketSelect = document.getElementById('id_paket');
        const kelasSelect = document.getElementById('id_kelas');
        
        if (paketSelect.value) {
            paketSelect.dispatchEvent(new Event('change'));
        }
        
        if (kelasSelect.value) {
            kelasSelect.dispatchEvent(new Event('change'));
        }
    });

    // ========== UNSAVED CHANGES WARNING ==========
    let formChanged = false;
    let pendingUrl = null;
    const form = document.getElementById('mainForm');
    
    if (form) {
        const inputs = form.querySelectorAll('input:not([type="hidden"]), select, textarea');
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
                window.location.href = "{{ route($role . '.kelola-murid') }}";
            };
        } else {
            document.getElementById('modalBatal').style.display = 'flex';
        }
    }
    
    function tutupModalBatal() { 
        document.getElementById('modalBatal').style.display = 'none'; 
    }
    
    function tutupModalPindah() {
        document.getElementById('modalPindahHalaman').style.display = 'none';
        pendingUrl = null;
    }
    
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
                    }
                }
            });
        });
    });
</script>
@endsection