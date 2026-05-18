@extends('layouts.app')

@section('title', 'Edit Harga Paket')

@section('content')
@php
    $hashId = $hashId ?? hash_id($paket->id_paket);
@endphp

<div style="padding: 10px; font-family: 'Poppins', sans-serif;">
    <h1 style="font-size: 20px; font-weight: 700; color: #111827; margin-bottom: 20px;">Edit Harga Paket</h1>

    <div style="background: #F9FAFB; border-radius: 15px; padding: 30px; border: 1.5px solid #E5E7EB; box-shadow: 0 4px 10px rgba(0,0,0,0.02);">
        <form action="{{ route($role . '.master-data.harga-paket.update', $hashId) }}" method="POST" id="mainForm">
            @csrf
            @method('PUT')
            
            {{-- ID Paket (READONLY) --}}
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">ID Paket</label>
                <input type="text" value="PK{{ str_pad($paket->id_paket, 4, '0', STR_PAD_LEFT) }}" readonly 
                       style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #F3F4F6; outline: none; color: #6B7280; font-size: 14px;">
            </div>

            {{-- Harga Paket (WAJIB & HANYA ANGKA) --}}
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Harga Paket <span style="color: red;">*</span></label>
                <input type="tel" inputmode="numeric" name="harga" value="{{ $paket->harga }}" placeholder="Masukkan Harga Paket" required
                       onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                       oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                       style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none; font-size: 14px;">
                @error('harga') <small style="color: red;">{{ $message }}</small> @enderror
            </div>

            {{-- Tingkat (WAJIB) --}}
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Tingkat <span style="color: red;">*</span></label>
                <input type="text" name="tingkat" value="{{ $paket->tingkat }}" placeholder="Masukkan Tingkat" required 
                       style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none; font-size: 14px;">
                @error('tingkat') <small style="color: red;">{{ $message }}</small> @enderror
            </div>

            {{-- TOMBOL AKSI --}}
            <div style="display: flex; justify-content: flex-end; gap: 20px; margin-top: 30px;">
                <button type="button" id="btnKeluar" 
                        style="padding: 10px 45px; border: 1.5px solid #4D0B87; color: #4D0B87; border-radius: 10px; font-weight: 600; font-size: 16px; background: #FFFFFF; cursor: pointer;">Keluar</button>
                <button type="submit" id="btnUpdate"
                        style="padding: 10px 45px; border: none; background: #4D0B87; color: white; border-radius: 10px; font-weight: 600; font-size: 16px; cursor: pointer; box-shadow: 0 4px 6px rgba(77, 11, 135, 0.2);">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL KONFIRMASI BATAL (UNTUK KELUAR) --}}
<div id="modalBatal" style="display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); backdrop-filter: blur(3px); align-items: center; justify-content: center;">
    <div style="background: white; padding: 25px; border-radius: 20px; width: 320px; text-align: center; box-shadow: 0 15px 30px rgba(0,0,0,0.15); font-family: 'Poppins', sans-serif;">
        <div style="color: #F59E0B; font-size: 40px; margin-bottom: 10px;"><i class="fas fa-exclamation-triangle"></i></div>
        <h2 style="margin: 0; font-size: 18px; color: #111827; font-weight: 700;">Batalkan?</h2>
        <p style="color: #6B7280; font-size: 13px; margin: 8px 0 20px 0;">Data yang Anda masukkan tidak akan disimpan. Yakin ingin keluar?</p>
        <div style="display: flex; gap: 10px; justify-content: center;">
            <button id="btnTidakBatal" style="flex: 1; padding: 10px; border-radius: 10px; border: 1px solid #E5E7EB; background: white; font-weight: 600; font-size: 13px; cursor: pointer;">Tidak</button>
            <button id="btnYaKeluar" style="flex: 1; padding: 10px; border-radius: 10px; border: none; background: #EF4444; color: white; font-weight: 600; font-size: 13px; cursor: pointer;">Ya, Keluar</button>
        </div>
    </div>
</div>

{{-- MODAL KONFIRMASI UNTUK PINDAH HALAMAN (SAAT FORM BERUBAH) --}}
<div id="modalPindahHalaman" style="display: none; position: fixed; z-index: 10000; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); backdrop-filter: blur(3px); align-items: center; justify-content: center;">
    <div style="background: white; padding: 25px; border-radius: 20px; width: 320px; text-align: center; box-shadow: 0 15px 30px rgba(0,0,0,0.15); font-family: 'Poppins', sans-serif;">
        <div style="color: #F59E0B; font-size: 40px; margin-bottom: 10px;"><i class="fas fa-exclamation-triangle"></i></div>
        <h2 style="margin: 0; font-size: 18px; color: #111827; font-weight: 700;">Perubahan Belum Disimpan</h2>
        <p style="color: #6B7280; font-size: 13px; margin: 8px 0 20px 0;">Ada data yang belum disimpan. Yakin ingin meninggalkan halaman ini?</p>
        <div style="display: flex; gap: 10px; justify-content: center;">
            <button id="btnTidakPindah" style="flex: 1; padding: 10px; border-radius: 10px; border: 1px solid #E5E7EB; background: white; font-weight: 600; font-size: 13px; cursor: pointer;">Tidak</button>
            <button id="btnYaPindah" style="flex: 1; padding: 10px; border-radius: 10px; border: none; background: #EF4444; color: white; font-weight: 600; font-size: 13px; cursor: pointer;">Ya, Keluar</button>
        </div>
    </div>
</div>

{{-- MODAL SUKSES --}}
<div id="modalSukses" style="display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); backdrop-filter: blur(3px); align-items: center; justify-content: center;">
    <div style="background: white; padding: 25px; border-radius: 20px; width: 320px; text-align: center; box-shadow: 0 15px 30px rgba(0,0,0,0.15); font-family: 'Poppins', sans-serif;">
        <div style="color: #10B981; font-size: 50px; margin-bottom: 10px;"><i class="fas fa-check-circle"></i></div>
        <h2 style="margin: 0; font-size: 18px; color: #111827; font-weight: 700;">Berhasil!</h2>
        <p style="color: #6B7280; font-size: 13px; margin: 8px 0 20px 0;" id="pesanSukses">Harga paket berhasil diupdate.</p>
        <button id="btnOkSukses" style="width: 100%; padding: 10px; border-radius: 10px; border: none; background: #10B981; color: white; font-weight: 600; font-size: 13px; cursor: pointer;">OK</button>
    </div>
</div>

<script>
    (function() {
        var form = document.getElementById('mainForm');
        var btnKeluar = document.getElementById('btnKeluar');
        var btnUpdate = document.getElementById('btnUpdate');
        var modalBatal = document.getElementById('modalBatal');
        var modalPindah = document.getElementById('modalPindahHalaman');
        var modalSukses = document.getElementById('modalSukses');
        var alertError = document.getElementById('alertError');
        var alertErrorText = document.getElementById('alertErrorText');
        var pesanSukses = document.getElementById('pesanSukses');
        
        var btnTidakBatal = document.getElementById('btnTidakBatal');
        var btnYaKeluar = document.getElementById('btnYaKeluar');
        var btnTidakPindah = document.getElementById('btnTidakPindah');
        var btnYaPindah = document.getElementById('btnYaPindah');
        var btnOkSukses = document.getElementById('btnOkSukses');
        
        var formChanged = false;
        var formSubmitted = false;
        var role = '{{ $role }}';

        // Track perubahan form
        if (form) {
            form.querySelectorAll('input:not([readonly]), select, textarea').forEach(function(el) {
                el.addEventListener('input', function() { if (!formSubmitted) formChanged = true; });
                el.addEventListener('change', function() { if (!formSubmitted) formChanged = true; });
            });
            
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Validasi
                var harga = document.querySelector('input[name="harga"]');
                var tingkat = document.querySelector('input[name="tingkat"]');
                
                if (!harga || !harga.value.trim()) { tampilkanError('Harga paket harus diisi'); return; }
                if (!tingkat || !tingkat.value.trim()) { tampilkanError('Tingkat harus diisi'); return; }
                if (parseInt(harga.value) < 1000) { tampilkanError('Harga minimal Rp 1.000'); return; }
                
                var formData = new FormData(form);
                
                if (btnUpdate) { 
                    btnUpdate.disabled = true; 
                    btnUpdate.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...'; 
                }

                fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                    }
                })
                .then(function(response) { 
                    if (!response.ok) {
                        return response.text().then(function(text) {
                            throw new Error(text || 'Server error: ' + response.status);
                        });
                    }
                    return response.json(); 
                })
                .then(function(data) {
                    if (data.success) {
                        formChanged = false;
                        formSubmitted = true;
                        if (pesanSukses) pesanSukses.textContent = data.message || 'Harga paket berhasil diupdate.';
                        if (modalSukses) modalSukses.style.display = 'flex';
                    } else {
                        var err = data.message || 'Gagal menyimpan data';
                        if (data.errors) {
                            err = '';
                            for (var f in data.errors) {
                                err += data.errors[f].join('\n') + '\n';
                            }
                        }
                        tampilkanError(err);
                        if (btnUpdate) { btnUpdate.disabled = false; btnUpdate.innerHTML = 'Simpan'; }
                    }
                })
                .catch(function(err) {
                    console.error('Fetch error:', err);
                    tampilkanError('Terjadi kesalahan: ' + err.message);
                    if (btnUpdate) { btnUpdate.disabled = false; btnUpdate.innerHTML = 'Simpan'; }
                });
            });
        }

        function tampilkanError(pesan) {
            // Buat alert error jika tidak ada elemen alertError
            var alertDiv = document.getElementById('alertError');
            if (alertDiv && alertErrorText) {
                alertErrorText.textContent = pesan;
                alertDiv.style.display = 'flex';
                setTimeout(function() { alertDiv.style.display = 'none'; }, 5000);
            } else {
                alert(pesan);
            }
        }

        function tutupModalForm() {
            try {
                var modalForm = window.parent.document.getElementById('modalForm');
                if (modalForm) modalForm.style.display = 'none';
                var modalContent = window.parent.document.getElementById('modalContent');
                if (modalContent) modalContent.innerHTML = '';
            } catch(e) {
                console.log('Tidak dapat mengakses parent');
            }
        }

        // Keluar
        if (btnKeluar) {
            btnKeluar.addEventListener('click', function(e) {
                e.preventDefault();
                if (formChanged && !formSubmitted) {
                    if (modalPindah) modalPindah.style.display = 'flex';
                } else {
                    if (modalBatal) modalBatal.style.display = 'flex';
                }
            });
        }

        // Modal Batal
        if (btnTidakBatal) btnTidakBatal.addEventListener('click', function() { if (modalBatal) modalBatal.style.display = 'none'; });
        if (btnYaKeluar) btnYaKeluar.addEventListener('click', function() { 
            if (modalBatal) modalBatal.style.display = 'none'; 
            window.location.href = "{{ route($role . '.master-data.harga-paket') }}";
        });

        // Modal Pindah
        if (btnTidakPindah) btnTidakPindah.addEventListener('click', function() { if (modalPindah) modalPindah.style.display = 'none'; });
        if (btnYaPindah) btnYaPindah.addEventListener('click', function() { 
            if (modalPindah) modalPindah.style.display = 'none'; 
            window.location.href = "{{ route($role . '.master-data.harga-paket') }}";
        });

        // Modal Sukses
        if (btnOkSukses) btnOkSukses.addEventListener('click', function() { 
            if (modalSukses) modalSukses.style.display = 'none'; 
            tutupModalForm();
            window.location.href = "{{ route($role . '.master-data.harga-paket') }}";
        });

        // Klik di luar modal
        if (modalBatal) modalBatal.addEventListener('click', function(e) { if (e.target === modalBatal) modalBatal.style.display = 'none'; });
        if (modalPindah) modalPindah.addEventListener('click', function(e) { if (e.target === modalPindah) modalPindah.style.display = 'none'; });
        if (modalSukses) modalSukses.addEventListener('click', function(e) { if (e.target === modalSukses) modalSukses.style.display = 'none'; });
    })();
</script>
@endsection