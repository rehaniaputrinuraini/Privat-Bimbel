@extends('layouts.app')

@section('title', 'Presensi Tentor')

@section('content')
<style>
    .presensi-flex { 
        display: flex; 
        gap: 20px; 
        align-items: flex-start; 
        flex-wrap: wrap;
    }
    
    .presensi-card { 
        background: #fff; 
        border-radius: 20px; 
        padding: 25px; 
        box-shadow: 0 4px 15px rgba(0,0,0,0.08); 
        flex: 1; 
        min-width: 350px;
        border: 1px solid #F3F4F6;
    }
    
    .card-header-custom h3 { 
        font-size: 18px; 
        font-weight: 700; 
        margin: 0; 
        color: #111827; 
    }
    .card-header-custom p { 
        font-size: 13px; 
        color: #6B7280; 
        margin: 5px 0 20px 0; 
    }

    .button-group-presensi { 
        display: flex; 
        gap: 12px; 
        margin-bottom: 20px; 
        flex-wrap: wrap;
    }
    .btn-presensi { 
        border: none; 
        border-radius: 12px; 
        padding: 14px 20px; 
        font-size: 15px; 
        font-weight: 700; 
        color: #fff; 
        cursor: pointer; 
        display: flex; 
        align-items: center; 
        gap: 10px; 
        flex: 1; 
        justify-content: center; 
        transition: 0.3s; 
    }
    
    .btn-masuk { background-color: #10B981; }
    .btn-masuk:hover { background-color: #059669; }
    .btn-keluar { background-color: #EF4444; }
    .btn-keluar:hover { background-color: #DC2626; }

    .btn-presensi:disabled { 
        background-color: #E5E7EB !important; 
        color: #9CA3AF !important; 
        cursor: not-allowed; 
    }

    .form-group { margin-bottom: 18px; }
    .form-group label { 
        display: block; 
        font-size: 13px; 
        font-weight: 700; 
        color: #374151; 
        margin-bottom: 8px; 
    }
    .form-control-custom { 
        width: 100%; 
        padding: 12px 15px; 
        border: 1px solid #E5E7EB; 
        border-radius: 12px; 
        outline: none; 
        font-size: 14px; 
        background: #FFFFFF;
    }
    .form-control-custom:focus { 
        border-color: #4D0B87; 
        box-shadow: 0 0 0 2px rgba(77, 11, 135, 0.1);
    }
    
    textarea.form-control-custom {
        resize: vertical;
        min-height: 80px;
    }
    
    .radio-group { 
        display: flex; 
        gap: 20px; 
        font-size: 14px; 
        color: #4B5563; 
    }
    .radio-group label {
        font-weight: normal;
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
    }
    
    .upload-area { 
        border: 2px dashed #E5E7EB; 
        border-radius: 12px; 
        padding: 20px; 
        text-align: center; 
        color: #9CA3AF; 
        cursor: pointer;
        transition: 0.3s;
    }
    .upload-area:hover { 
        border-color: #4D0B87; 
        color: #4D0B87; 
        background: #F9FAFB;
    }
    .upload-area.has-file {
        border-color: #10B981;
        background: #F0FDF4;
        color: #065F46;
    }
    
    .upload-hint {
        font-size: 11px;
        color: #EF4444;
        margin-top: 5px;
        display: block;
    }
    
    .upload-hint-success {
        color: #10B981;
    }

    .btn-submit { 
        width: 100%; 
        background: #4D0B87; 
        color: white; 
        border: none; 
        padding: 14px; 
        border-radius: 12px; 
        font-weight: 700; 
        font-size: 14px;
        cursor: pointer; 
        transition: 0.3s; 
    }
    .btn-submit:hover { 
        background: #3B0A6B; 
        transform: translateY(-1px);
    }
    .btn-submit:disabled {
        background: #9CA3AF;
        cursor: not-allowed;
        transform: none;
    }

    .presensi-info { 
        font-size: 12px; 
        color: #6B7280; 
        line-height: 1.6; 
        padding: 12px; 
        background: #F9FAFB; 
        border-radius: 10px; 
        border-left: 4px solid #4D0B87;
    }
    
    .alert-success {
        background: #D1FAE5;
        color: #065F46;
        padding: 12px 15px;
        border-radius: 10px;
        margin-bottom: 15px;
        display: none;
    }
    
    .alert-error {
        background: #FEE2E2;
        color: #EF4444;
        padding: 12px 15px;
        border-radius: 10px;
        margin-bottom: 15px;
        display: none;
    }
    
    #previewFoto {
        margin-top: 10px;
        max-width: 100%;
        border-radius: 10px;
        display: none;
    }
</style>

<div style="padding: 10px; font-family: 'Poppins', sans-serif;">
    <div style="width: 100%;">

        <div style="margin-bottom: 25px;">
            <p style="color: #6B7280; font-size: 13px; margin: 0 0 4px 0;">
                {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}
            </p>
            <h1 style="font-size: 26px; font-weight: 700; color: #111827; margin: 0; letter-spacing: -0.5px; line-height: 1.2;">
                Presensi
            </h1>
            <p style="color: #6B7280; font-size: 14px; margin: 4px 0 0 0;">Silakan kelola kehadiran sesi mengajar Anda di sini.</p>
        </div>

        <div id="alertSuccess" class="alert-success">
            <i class="fas fa-check-circle"></i> <span id="successMessage"></span>
        </div>
        <div id="alertError" class="alert-error">
            <i class="fas fa-exclamation-circle"></i> <span id="errorMessage"></span>
        </div>

        @if(isset($error))
            <div style="background: #FEE2E2; color: #EF4444; padding: 12px; border-radius: 10px; margin-bottom: 20px;">
                <i class="fas fa-exclamation-circle"></i> {{ $error }}
            </div>
        @endif

        <div class="presensi-flex">
            <div class="presensi-card">
                <div class="card-header-custom">
                    <h3>Presensi Hari Ini</h3>
                    <p>{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
                </div>

                <div class="button-group-presensi">
                    <button type="button" class="btn-presensi btn-masuk" id="btnMasuk" 
                        {{ $presensiHariIni ? 'disabled' : '' }}>
                        <i class="fas fa-sign-in-alt"></i> Masuk
                    </button>

                    <button type="button" class="btn-presensi btn-keluar" id="btnKeluar" disabled>
                        <i class="fas fa-sign-out-alt"></i> Keluar
                    </button>
                </div>

                <div class="presensi-info">
                    <i class="fas fa-info-circle" style="margin-right: 5px; color: #4D0B87;"></i>
                    Presensi keluar bisa dilakukan setelah mengisi laporan kegiatan. Sesi mengajar = 1 sesi.
                </div>
            </div>

            <div class="presensi-card" id="formPresensi" style="{{ $presensiHariIni && !$presensiHariIni->kelas ? 'display: block;' : 'display: none;' }}">
                <div class="card-header-custom">
                    <h3>Laporan Kegiatan</h3>
                    <p>Input detail pengajaran hari ini</p>
                </div>

                <form id="formLaporan" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="form-group">
                        <label>Kelas <span style="color: red;">*</span></label>
                        <input type="text" class="form-control-custom" id="kelas" name="kelas" 
                               placeholder="Contoh: 12D, 9A, 11 IPA" maxlength="50" required>
                        <small style="font-size: 11px; color: #6B7280;">Masukkan nama kelas yang diajar (contoh: 12D, 9A, 11 IPA)</small>
                    </div>

                    <div class="form-group">
                        <label>Jenjang yang Diajar <span style="color: red;">*</span></label>
                        <select class="form-control-custom" id="jenjang" name="jenjang" required>
                            <option value="">Pilih Jenjang</option>
                            <option value="SD">SD (Sekolah Dasar)</option>
                            <option value="SMP">SMP (Sekolah Menengah Pertama)</option>
                            <option value="SMA">SMA (Sekolah Menengah Atas)</option>
                        </select>
                        <small style="font-size: 11px; color: #6B7280;">Jenjang akan mempengaruhi perhitungan honor</small>
                    </div>

                    <div class="form-group">
                        <label>Status Kehadiran Murid <span style="color: red;">*</span></label>
                        <div class="radio-group">
                            <label style="cursor: pointer;">
                                <input type="radio" name="status_murid" value="hadir" checked> Hadir
                            </label>
                            <label style="cursor: pointer;">
                                <input type="radio" name="status_murid" value="tidak_hadir"> Tidak Hadir
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Keterangan</label>
                        <textarea class="form-control-custom" id="keterangan" name="keterangan" 
                                  placeholder="Contoh: Materi yang diajarkan, kendala, atau catatan lainnya..."></textarea>
                    </div>

                    <div class="form-group">
                        <label>Upload Foto Kegiatan <span style="color: red;">*</span></label>
                        <div class="upload-area" id="uploadArea">
                            <i class="fas fa-camera" style="font-size: 20px; margin-bottom: 8px; display: block;"></i>
                            <p style="font-size: 12px; margin: 0;">Klik untuk ambil atau pilih foto KBM</p>
                        </div>
                        <input type="file" id="foto" name="foto" accept="image/*" style="display: none;" required>
                        <small class="upload-hint" id="uploadHint">
                            <i class="fas fa-info-circle"></i> Pastikan foto menunjukkan wajah murid yang sedang belajar
                        </small>
                        <img id="previewFoto" alt="Preview Foto">
                    </div>

                    <button type="submit" class="btn-submit" id="btnSubmitForm">
                        <i class="fas fa-paper-plane"></i> Kirim Laporan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const btnMasuk = document.getElementById('btnMasuk');
    const btnKeluar = document.getElementById('btnKeluar');
    const formCard = document.getElementById('formPresensi');
    const formLaporan = document.getElementById('formLaporan');
    const uploadArea = document.getElementById('uploadArea');
    const fotoInput = document.getElementById('foto');
    const previewFoto = document.getElementById('previewFoto');
    const uploadHint = document.getElementById('uploadHint');
    const btnSubmit = document.getElementById('btnSubmitForm');
    
    function showAlert(type, message) {
        if (type === 'success') {
            document.getElementById('successMessage').innerText = message;
            document.getElementById('alertSuccess').style.display = 'block';
            setTimeout(() => {
                document.getElementById('alertSuccess').style.display = 'none';
            }, 3000);
        } else {
            document.getElementById('errorMessage').innerText = message;
            document.getElementById('alertError').style.display = 'block';
            setTimeout(() => {
                document.getElementById('alertError').style.display = 'none';
            }, 3000);
        }
    }
    
    uploadArea.addEventListener('click', function() {
        fotoInput.click();
    });
    
    fotoInput.addEventListener('change', function(e) {
        if (e.target.files && e.target.files[0]) {
            const reader = new FileReader();
            reader.onload = function(event) {
                previewFoto.src = event.target.result;
                previewFoto.style.display = 'block';
                uploadArea.classList.add('has-file');
                uploadHint.innerHTML = '<i class="fas fa-check-circle"></i> Foto sudah dipilih';
                uploadHint.classList.add('upload-hint-success');
            };
            reader.readAsDataURL(e.target.files[0]);
        } else {
            previewFoto.style.display = 'none';
            uploadArea.classList.remove('has-file');
            uploadHint.innerHTML = '<i class="fas fa-info-circle"></i> Pastikan foto menunjukkan wajah murid yang sedang belajar';
            uploadHint.classList.remove('upload-hint-success');
        }
    });
    
    btnMasuk.addEventListener('click', function() {
        fetch('{{ route("tentor.presensi.masuk") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert('success', data.message);
                btnMasuk.disabled = true;
                formCard.style.display = 'block';
            } else {
                showAlert('error', data.message);
            }
        })
        .catch(error => {
            showAlert('error', 'Terjadi kesalahan: ' + error);
        });
    });
    
    formLaporan.addEventListener('submit', function(e) {
        e.preventDefault();
        
        if (!fotoInput.files[0]) {
            showAlert('error', 'Foto kegiatan wajib diupload!');
            uploadHint.style.color = '#EF4444';
            return;
        }
        
        const formData = new FormData();
        formData.append('kelas', document.getElementById('kelas').value);
        formData.append('jenjang', document.getElementById('jenjang').value);
        formData.append('status_murid', document.querySelector('input[name="status_murid"]:checked').value);
        formData.append('keterangan', document.getElementById('keterangan').value);
        formData.append('foto', fotoInput.files[0]);
        
        btnSubmit.disabled = true;
        btnSubmit.innerHTML = '<i class="fas fa-spinner fa-pulse"></i> Mengirim...';
        
        fetch('{{ route("tentor.presensi.laporan") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert('success', data.message);
                btnKeluar.disabled = false;
                document.getElementById('kelas').disabled = true;
                document.getElementById('jenjang').disabled = true;
                document.getElementById('keterangan').disabled = true;
                document.querySelectorAll('input[name="status_murid"]').forEach(radio => {
                    radio.disabled = true;
                });
                fotoInput.disabled = true;
                uploadArea.style.pointerEvents = 'none';
                btnSubmit.disabled = true;
                btnSubmit.innerHTML = '<i class="fas fa-check"></i> Laporan Terkirim';
            } else {
                showAlert('error', data.message);
                btnSubmit.disabled = false;
                btnSubmit.innerHTML = '<i class="fas fa-paper-plane"></i> Kirim Laporan';
            }
        })
        .catch(error => {
            showAlert('error', 'Terjadi kesalahan: ' + error);
            btnSubmit.disabled = false;
            btnSubmit.innerHTML = '<i class="fas fa-paper-plane"></i> Kirim Laporan';
        });
    });
    
    btnKeluar.addEventListener('click', function() {
        btnKeluar.disabled = true;
        btnKeluar.innerHTML = '<i class="fas fa-spinner fa-pulse"></i> Memproses...';
        
        fetch('{{ route("tentor.presensi.keluar") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert('success', data.message);
                
                btnMasuk.disabled = false;
                btnKeluar.disabled = true;
                btnKeluar.innerHTML = '<i class="fas fa-sign-out-alt"></i> Keluar';
                formCard.style.display = 'none';
                
                document.getElementById('kelas').value = '';
                document.getElementById('kelas').disabled = false;
                document.getElementById('jenjang').value = '';
                document.getElementById('jenjang').disabled = false;
                document.getElementById('keterangan').value = '';
                document.getElementById('keterangan').disabled = false;
                
                document.querySelectorAll('input[name="status_murid"]').forEach(radio => {
                    radio.disabled = false;
                });
                document.querySelector('input[name="status_murid"][value="hadir"]').checked = true;
                
                fotoInput.disabled = false;
                fotoInput.value = '';
                uploadArea.style.pointerEvents = 'auto';
                uploadArea.classList.remove('has-file');
                previewFoto.style.display = 'none';
                uploadHint.innerHTML = '<i class="fas fa-info-circle"></i> Pastikan foto menunjukkan wajah murid yang sedang belajar';
                uploadHint.classList.remove('upload-hint-success');
                uploadHint.style.color = '#EF4444';
                
                btnSubmit.disabled = false;
                btnSubmit.innerHTML = '<i class="fas fa-paper-plane"></i> Kirim Laporan';
                
            } else {
                showAlert('error', data.message);
                btnKeluar.disabled = false;
                btnKeluar.innerHTML = '<i class="fas fa-sign-out-alt"></i> Keluar';
            }
        })
        .catch(error => {
            showAlert('error', 'Terjadi kesalahan: ' + error);
            btnKeluar.disabled = false;
            btnKeluar.innerHTML = '<i class="fas fa-sign-out-alt"></i> Keluar';
        });
    });
    
    fetch('{{ route("tentor.presensi.cek-status") }}')
        .then(response => response.json())
        .then(data => {
            if (data.has_laporan) {
                btnKeluar.disabled = false;
                formCard.style.display = 'block';
                document.getElementById('kelas').disabled = true;
                document.getElementById('jenjang').disabled = true;
                document.getElementById('keterangan').disabled = true;
                document.querySelectorAll('input[name="status_murid"]').forEach(radio => {
                    radio.disabled = true;
                });
                fotoInput.disabled = true;
                uploadArea.style.pointerEvents = 'none';
                btnSubmit.disabled = true;
                btnSubmit.innerHTML = '<i class="fas fa-check"></i> Laporan Terkirim';
                
                if (data.data) {
                    document.getElementById('kelas').value = data.data.kelas || '';
                    document.getElementById('jenjang').value = data.data.jenjang || '';
                    document.getElementById('keterangan').value = data.data.keterangan || '';
                    if (data.data.status_murid) {
                        document.querySelector(`input[name="status_murid"][value="${data.data.status_murid}"]`).checked = true;
                    }
                    if (data.data.bukti_foto) {
                        previewFoto.src = '/storage/' + data.data.bukti_foto;
                        previewFoto.style.display = 'block';
                        uploadArea.classList.add('has-file');
                    }
                }
            } else if (data.has_presensi_masuk) {
                formCard.style.display = 'block';
            }
        });
});
</script>
@endsection