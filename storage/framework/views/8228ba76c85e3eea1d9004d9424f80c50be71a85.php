

<?php $__env->startSection('title', 'Presensi Tentor'); ?>

<?php $__env->startSection('content'); ?>
<style>
    .presensi-flex { 
        display: flex; 
        gap: 20px; 
        align-items: flex-start; 
        flex-wrap: wrap;
        font-family: 'Poppins', sans-serif;
    }
    
    .presensi-card { 
        background: #FFFFFF; 
        border-radius: 15px; 
        padding: 30px; 
        box-shadow: 0 4px 10px rgba(0,0,0,0.02); 
        flex: 1; 
        min-width: 350px;
        border: 1.5px solid #E5E7EB;
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
        font-weight: 600; 
        color: #fff; 
        cursor: pointer; 
        display: flex; 
        align-items: center; 
        gap: 10px; 
        flex: 1; 
        justify-content: center; 
        transition: 0.3s; 
        font-family: 'Poppins', sans-serif;
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
        font-size: 14px; 
        font-weight: 600; 
        color: #374151; 
        margin-bottom: 8px; 
        font-family: 'Poppins', sans-serif;
    }
    .form-control-custom { 
        width: 100%; 
        padding: 12px 15px; 
        border: 1px solid #E5E7EB; 
        border-radius: 12px; 
        outline: none; 
        font-size: 14px; 
        background: #FFFFFF;
        font-family: 'Poppins', sans-serif;
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
        font-family: 'Poppins', sans-serif;
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
        font-family: 'Poppins', sans-serif;
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
        font-size: 12px;
        color: #EF4444;
        margin-top: 5px;
        display: block;
        font-family: 'Poppins', sans-serif;
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
        border-radius: 10px; 
        font-weight: 600; 
        font-size: 16px;
        cursor: pointer; 
        transition: 0.3s; 
        font-family: 'Poppins', sans-serif;
        box-shadow: 0 4px 6px rgba(77, 11, 135, 0.2);
    }
    .btn-submit:hover { 
        background: #3B0A6B; 
        transform: translateY(-1px);
    }
    .btn-submit:disabled {
        background: #9CA3AF;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }

    .presensi-info { 
        font-size: 13px; 
        color: #6B7280; 
        line-height: 1.6; 
        padding: 12px 15px; 
        background: #F9FAFB; 
        border-radius: 10px; 
        border-left: 4px solid #4D0B87;
        font-family: 'Poppins', sans-serif;
    }
    
    .alert-success {
        background: #D1FAE5;
        color: #065F46;
        padding: 12px 15px;
        border-radius: 10px;
        margin-bottom: 15px;
        display: none;
        font-family: 'Poppins', sans-serif;
        font-size: 14px;
    }
    
    .alert-error {
        background: #FEE2E2;
        color: #EF4444;
        padding: 12px 15px;
        border-radius: 10px;
        margin-bottom: 15px;
        display: none;
        font-family: 'Poppins', sans-serif;
        font-size: 14px;
    }
    
    #previewFoto {
        margin-top: 10px;
        max-width: 100%;
        border-radius: 10px;
        display: none;
    }
    
    small {
        font-family: 'Poppins', sans-serif;
        font-size: 12px;
    }
    
    select.form-control-custom {
        cursor: pointer;
    }
</style>

<div style="padding: 10px; font-family: 'Poppins', sans-serif;">
    <div style="width: 100%;">

        <div style="margin-bottom: 25px;">
            <p style="color: #374151; font-size: 13px; margin: 0 0 4px 0;">
                <?php echo e(\Carbon\Carbon::now()->translatedFormat('F Y')); ?>

            </p>
            <h1 style="font-size: 26px; font-weight: 700; color: #111827; margin: 0; letter-spacing: -0.5px; line-height: 1.2;">
                Presensi
            </h1>
            <p style="color: #374151; font-size: 14px; margin: 4px 0 0 0;">Silakan kelola kehadiran sesi mengajar Anda di sini.</p>
        </div>

        <div id="alertSuccess" class="alert-success">
            <i class="fas fa-check-circle"></i> <span id="successMessage"></span>
        </div>
        <div id="alertError" class="alert-error">
            <i class="fas fa-exclamation-circle"></i> <span id="errorMessage"></span>
        </div>

        <?php if(isset($error)): ?>
            <div style="background: #FEE2E2; color: #EF4444; padding: 12px; border-radius: 10px; margin-bottom: 20px; font-family: 'Poppins', sans-serif;">
                <i class="fas fa-exclamation-circle"></i> <?php echo e($error); ?>

            </div>
        <?php endif; ?>

        <div class="presensi-flex">
            
            <div class="presensi-card">
                <div class="card-header-custom">
                    <h3>Presensi Hari Ini</h3>
                    <p><?php echo e(\Carbon\Carbon::now()->translatedFormat('l, d F Y')); ?></p>
                </div>

                <div class="button-group-presensi">
                    <button type="button" class="btn-presensi btn-masuk" id="btnMasuk" 
                        <?php echo e($presensiHariIni ? 'disabled' : ''); ?>>
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

            
            <div class="presensi-card" id="formPresensi" style="display: none;">
                <div class="card-header-custom">
                    <h3>Laporan Kegiatan</h3>
                    <p>Input detail pengajaran hari ini</p>
                </div>

                <form id="formLaporan" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    
                    
                    <div class="form-group">
                        <label>Kelas <span style="color: #EF4444;">*</span></label>
                        <select class="form-control-custom" id="id_kelas" name="id_kelas" required>
                            <option value="">-- Pilih Kelas --</option>
                            <?php $__currentLoopData = $kelasList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kelas): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($kelas->id_kelas); ?>" data-jenjang="<?php echo e($kelas->jenjang); ?>">
                                    <?php echo e($kelas->jenjang); ?> - <?php echo e($kelas->nama_kelas); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <small style="font-size: 12px; color: #6B7280;">Pilih kelas yang diajar</small>
                    </div>

                    
                    <div class="form-group">
                        <label>Ruang <span style="color: #EF4444;">*</span></label>
                        <select class="form-control-custom" id="id_ruang" name="id_ruang" required>
                            <option value="">-- Pilih Ruang --</option>
                            <?php $__currentLoopData = $ruangList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ruang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($ruang->id_ruang); ?>">
                                    <?php echo e($ruang->nama_ruang); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <small style="font-size: 12px; color: #6B7280;">Pilih ruang tempat mengajar</small>
                    </div>

                    
                    <input type="hidden" id="jenjang" name="jenjang">

                    <div class="form-group">
                        <label>Status Kehadiran Murid <span style="color: #EF4444;">*</span></label>
                        <div class="radio-group">
                            <label style="cursor: pointer;">
                                <input type="radio" name="murid_hadir" value="Hadir" checked> Hadir
                            </label>
                            <label style="cursor: pointer;">
                                <input type="radio" name="murid_hadir" value="Tidak Hadir"> Tidak Hadir
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Keterangan</label>
                        <textarea class="form-control-custom" id="keterangan" name="keterangan" 
                                  placeholder="Isikan materi yang diajarkan, kendala, atau catatan lainnya..." maxlength="30"></textarea>
                        <small style="font-size: 12px; color: #6B7280;">Maksimal 30 karakter</small>
                    </div>

                    <div class="form-group">
                        <label>Upload Foto Kegiatan <span style="color: #EF4444;">*</span></label>
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
    const kelasSelect = document.getElementById('id_kelas');
    const ruangSelect = document.getElementById('id_ruang');
    const jenjangHidden = document.getElementById('jenjang');
    const keteranganInput = document.getElementById('keterangan');
    
    // Auto-fill jenjang saat kelas dipilih
    kelasSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const jenjang = selectedOption.getAttribute('data-jenjang');
        jenjangHidden.value = jenjang || '';
    });
    
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
    
    // ✅ BTN MASUK - TANPA KIRIM KELAS & RUANG
    btnMasuk.addEventListener('click', function() {
        fetch('<?php echo e(route("tentor.presensi.masuk")); ?>', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert('success', data.message);
                btnMasuk.disabled = true;
                formCard.style.display = 'block'; // ✅ MUNCUL FORM
            } else {
                showAlert('error', data.message);
            }
        })
        .catch(error => {
            showAlert('error', 'Terjadi kesalahan: ' + error);
        });
    });
    
    // ✅ BTN KIRIM LAPORAN
    formLaporan.addEventListener('submit', function(e) {
        e.preventDefault();
        
        if (!fotoInput.files[0]) {
            showAlert('error', 'Foto kegiatan wajib diupload!');
            return;
        }
        
        if (!kelasSelect.value) {
            showAlert('error', 'Silakan pilih kelas!');
            return;
        }
        
        if (!ruangSelect.value) {
            showAlert('error', 'Silakan pilih ruang!');
            return;
        }
        
        const formData = new FormData();
        formData.append('id_kelas', kelasSelect.value);
        formData.append('id_ruang', ruangSelect.value);
        formData.append('jenjang', jenjangHidden.value);
        formData.append('murid_hadir', document.querySelector('input[name="murid_hadir"]:checked').value);
        formData.append('keterangan', keteranganInput.value);
        formData.append('foto', fotoInput.files[0]);
        
        btnSubmit.disabled = true;
        btnSubmit.innerHTML = '<i class="fas fa-spinner fa-pulse"></i> Mengirim...';
        
        fetch('<?php echo e(route("tentor.presensi.laporan")); ?>', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert('success', data.message);
                btnKeluar.disabled = false;
                kelasSelect.disabled = true;
                ruangSelect.disabled = true;
                keteranganInput.disabled = true;
                document.querySelectorAll('input[name="murid_hadir"]').forEach(radio => {
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
    
    // ✅ BTN KELUAR
    btnKeluar.addEventListener('click', function() {
        btnKeluar.disabled = true;
        btnKeluar.innerHTML = '<i class="fas fa-spinner fa-pulse"></i> Memproses...';
        
        fetch('<?php echo e(route("tentor.presensi.keluar")); ?>', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert('success', data.message);
                
                // Reset semua
                btnMasuk.disabled = false;
                btnKeluar.disabled = true;
                btnKeluar.innerHTML = '<i class="fas fa-sign-out-alt"></i> Keluar';
                formCard.style.display = 'none'; // ✅ SEMBUNYIKAN FORM
                
                kelasSelect.value = '';
                kelasSelect.disabled = false;
                ruangSelect.value = '';
                ruangSelect.disabled = false;
                jenjangHidden.value = '';
                keteranganInput.value = '';
                keteranganInput.disabled = false;
                
                document.querySelectorAll('input[name="murid_hadir"]').forEach(radio => {
                    radio.disabled = false;
                });
                document.querySelector('input[name="murid_hadir"][value="Hadir"]').checked = true;
                
                fotoInput.disabled = false;
                fotoInput.value = '';
                uploadArea.style.pointerEvents = 'auto';
                uploadArea.classList.remove('has-file');
                previewFoto.style.display = 'none';
                uploadHint.innerHTML = '<i class="fas fa-info-circle"></i> Pastikan foto menunjukkan wajah murid yang sedang belajar';
                uploadHint.classList.remove('upload-hint-success');
                
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
    
    // Cek status saat halaman load
    fetch('<?php echo e(route("tentor.presensi.cek-status")); ?>')
        .then(response => response.json())
        .then(data => {
            if (data.has_presensi_masuk) {
                btnMasuk.disabled = true;
                formCard.style.display = 'block'; // ✅ MUNCUL JIKA SUDAH MASUK
            }
            if (data.has_laporan) {
                btnKeluar.disabled = false;
                kelasSelect.disabled = true;
                ruangSelect.disabled = true;
                keteranganInput.disabled = true;
                document.querySelectorAll('input[name="murid_hadir"]').forEach(radio => {
                    radio.disabled = true;
                });
                fotoInput.disabled = true;
                uploadArea.style.pointerEvents = 'none';
                btnSubmit.disabled = true;
                btnSubmit.innerHTML = '<i class="fas fa-check"></i> Laporan Terkirim';
                
                if (data.data) {
                    if (data.data.id_kelas) {
                        kelasSelect.value = data.data.id_kelas;
                        const selectedOption = kelasSelect.options[kelasSelect.selectedIndex];
                        jenjangHidden.value = selectedOption.getAttribute('data-jenjang') || '';
                    }
                    if (data.data.id_ruang) {
                        ruangSelect.value = data.data.id_ruang;
                    }
                    keteranganInput.value = data.data.keterangan || '';
                    if (data.data.murid_hadir) {
                        document.querySelector(`input[name="murid_hadir"][value="${data.data.murid_hadir}"]`).checked = true;
                    }
                    if (data.data.bukti_mengajar) {
                        previewFoto.src = '/storage/' + data.data.bukti_mengajar;
                        previewFoto.style.display = 'block';
                        uploadArea.classList.add('has-file');
                        uploadHint.innerHTML = '<i class="fas fa-check-circle"></i> Foto sudah terupload';
                        uploadHint.classList.add('upload-hint-success');
                    }
                }
            }
        });
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Privat-Bimbel\resources\views/dashboard/tentor/presensi.blade.php ENDPATH**/ ?>