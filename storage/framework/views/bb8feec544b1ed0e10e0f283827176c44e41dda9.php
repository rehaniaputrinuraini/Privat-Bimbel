<?php
    $hashId = $hashId ?? hash_id($tentor->id_pegawai);
?>

<div style="padding: 20px; font-family: 'Poppins', sans-serif; background: #FFFFFF; border-radius: 16px;">
    
    <div style="margin-bottom: 20px; padding-bottom: 14px; border-bottom: 1.5px solid #F3F4F6;">
        <h2 style="font-size: 19px; font-weight: 700; color: #111827; margin: 0;">Edit Data Tentor</h2>
        <p style="color: #9CA3AF; font-size: 12px; margin: 2px 0 0 0;">Perbarui data tentor</p>
    </div>

    <div id="alertError" style="display: none; background: #FEE2E2; color: #991B1B; padding: 12px 15px; border-radius: 10px; margin-bottom: 15px;">
        <i class="fas fa-exclamation-circle"></i> <span id="alertErrorText"></span>
    </div>

    <div style="display: flex; gap: 14px; margin-bottom: 18px;">
        <div style="flex: 1; padding: 10px 15px; background: #F9FAFB; border-radius: 10px; border: 1px solid #E5E7EB;">
            <span style="font-size: 11px; color: #9CA3AF; display: block;">ID Tentor</span>
            <span style="font-weight: 700; color: #4D0B87; font-size: 14px;">#<?php echo e($tentor->id_pegawai); ?></span>
        </div>
    </div>

    <form id="mainForm" action="<?php echo e(route('superadmin.kelola-tentor.update', $hashId)); ?>" method="POST">
        <?php echo csrf_field(); ?> 
        <?php echo method_field('PUT'); ?>

        <div style="margin-bottom: 15px;">
            <label style="font-weight: 600; font-size: 14px; color: #374151;">Nama Lengkap <span style="color: #EF4444;">*</span></label>
            <input type="text" name="nama_lengkap" value="<?php echo e(old('nama_lengkap', $tentor->nama_lengkap)); ?>" required 
                   style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; outline: none; font-size: 14px;">
        </div>
        
        <div style="margin-bottom: 15px;">
            <label style="font-weight: 600; font-size: 14px; color: #374151;">Alamat <span style="color: #EF4444;">*</span></label>
            <textarea name="alamat" rows="2" required 
                      style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; outline: none; font-size: 14px; resize: vertical;"><?php echo e(old('alamat', $tentor->alamat)); ?></textarea>
        </div>
        
        <div style="margin-bottom: 15px;">
            <label style="font-weight: 600; font-size: 14px; color: #374151;">No HP <span style="color: #EF4444;">*</span></label>
            <input type="tel" name="no_hp" value="<?php echo e(old('no_hp', $tentor->no_hp)); ?>" required 
                   oninput="this.value = this.value.replace(/[^0-9]/g, '')" 
                   style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; outline: none; font-size: 14px;">
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0 40px;">
            <div>
                <div style="margin-bottom: 15px;">
                    <label style="font-weight: 600; font-size: 14px; color: #374151;">Mapel <span style="color: #EF4444;">*</span></label>
                    <input type="text" name="mapel" value="<?php echo e(old('mapel', $tentor->mapel)); ?>" required 
                           style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; outline: none; font-size: 14px;">
                </div>
                
                <div style="margin-bottom: 15px;">
                    <label style="font-weight: 600; font-size: 14px; color: #374151;">Grade <span style="color: #EF4444;">*</span></label>
                    <select name="grade" required style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; outline: none; font-size: 14px;">
                        <option value="">Pilih</option>
                        <option value="A" <?php echo e(old('grade', $tentor->grade) == 'A' ? 'selected' : ''); ?>>A</option>
                        <option value="B" <?php echo e(old('grade', $tentor->grade) == 'B' ? 'selected' : ''); ?>>B</option>
                    </select>
                </div>
                
                <div style="margin-bottom: 15px;">
                    <label style="font-weight: 600; font-size: 14px; color: #374151;">HR SD</label>
                    <input type="text" name="hr_sd" value="<?php echo e(old('hr_sd', $tentor->hr_sd)); ?>" 
                           oninput="this.value = this.value.replace(/[^0-9]/g, '')" 
                           style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; outline: none; font-size: 14px;">
                </div>
                
                <div style="margin-bottom: 15px;">
                    <label style="font-weight: 600; font-size: 14px; color: #374151;">HR SMP</label>
                    <input type="text" name="hr_smp" value="<?php echo e(old('hr_smp', $tentor->hr_smp)); ?>" 
                           oninput="this.value = this.value.replace(/[^0-9]/g, '')" 
                           style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; outline: none; font-size: 14px;">
                </div>
                
                <div style="margin-bottom: 15px;">
                    <label style="font-weight: 600; font-size: 14px; color: #374151;">HR SMA</label>
                    <input type="text" name="hr_sma" value="<?php echo e(old('hr_sma', $tentor->hr_sma)); ?>" 
                           oninput="this.value = this.value.replace(/[^0-9]/g, '')" 
                           style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; outline: none; font-size: 14px;">
                </div>
            </div>
            
            <div>
                <div style="margin-bottom: 15px;">
                    <label style="font-weight: 600; font-size: 14px; color: #374151;">Uang Makan</label>
                    <input type="text" name="uang_makan" value="<?php echo e(old('uang_makan', $tentor->uang_makan)); ?>" 
                           oninput="this.value = this.value.replace(/[^0-9]/g, '')" 
                           style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; outline: none; font-size: 14px;">
                </div>
                
                <div style="margin-bottom: 15px;">
                    <label style="font-weight: 600; font-size: 14px; color: #374151;">Uang Transport</label>
                    <input type="text" name="uang_transport" value="<?php echo e(old('uang_transport', $tentor->uang_transport)); ?>" 
                           oninput="this.value = this.value.replace(/[^0-9]/g, '')" 
                           style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; outline: none; font-size: 14px;">
                </div>
                
                <div style="margin-bottom: 15px;">
                    <label style="font-weight: 600; font-size: 14px; color: #374151;">Email <span style="color: #EF4444;">*</span></label>
                    <input type="email" name="email" value="<?php echo e(old('email', $tentor->user->email ?? '')); ?>" required 
                           style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; outline: none; font-size: 14px;">
                </div>
                
                <div style="margin-bottom: 15px;">
                    <label style="font-weight: 600; font-size: 14px; color: #374151;">Username <span style="color: #EF4444;">*</span></label>
                    <input type="text" name="username" value="<?php echo e(old('username', $tentor->user->username ?? '')); ?>" required 
                           style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; outline: none; font-size: 14px;">
                </div>
            </div>
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 20px; margin-top: 30px; padding-top: 16px; border-top: 1.5px solid #F3F4F6;">
            <button type="button" id="btnKeluar" style="padding: 10px 45px; border: 1.5px solid #4D0B87; color: #4D0B87; border-radius: 10px; font-weight: 600; font-size: 16px; background: #FFFFFF; cursor: pointer;">Keluar</button>
            <button type="submit" id="btnUpdate" style="padding: 10px 45px; border: none; background: #4D0B87; color: white; border-radius: 10px; font-weight: 600; font-size: 16px; cursor: pointer; box-shadow: 0 4px 6px rgba(77, 11, 135, 0.2);">Update</button>
        </div>
    </form>
</div>


<div id="modalBatal" style="display: none; position: fixed; z-index: 99999; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); backdrop-filter: blur(3px); align-items: center; justify-content: center;">
    <div style="background: white; padding: 25px; border-radius: 20px; width: 320px; text-align: center; box-shadow: 0 15px 30px rgba(0,0,0,0.15);">
        <div style="color: #F59E0B; font-size: 40px; margin-bottom: 10px;"><i class="fas fa-exclamation-triangle"></i></div>
        <h2 style="margin: 0; font-size: 18px; color: #111827; font-weight: 700;">Batalkan?</h2>
        <p style="color: #6B7280; font-size: 13px; margin: 8px 0 20px 0;">Perubahan tidak akan disimpan.</p>
        <div style="display: flex; gap: 10px; justify-content: center;">
            <button id="btnTidakBatal" style="flex: 1; padding: 10px; border-radius: 10px; border: 1px solid #E5E7EB; background: white; font-weight: 600; font-size: 13px; cursor: pointer;">Tidak</button>
            <button id="btnYaKeluar" style="flex: 1; padding: 10px; border-radius: 10px; border: none; background: #EF4444; color: white; font-weight: 600; font-size: 13px; cursor: pointer;">Ya, Keluar</button>
        </div>
    </div>
</div>

<div id="modalPindahHalaman" style="display: none; position: fixed; z-index: 10000; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); backdrop-filter: blur(3px); align-items: center; justify-content: center;">
    <div style="background: white; padding: 25px; border-radius: 20px; width: 320px; text-align: center; box-shadow: 0 15px 30px rgba(0,0,0,0.15);">
        <div style="color: #F59E0B; font-size: 40px; margin-bottom: 10px;"><i class="fas fa-exclamation-triangle"></i></div>
        <h2 style="margin: 0; font-size: 18px; color: #111827; font-weight: 700;">Perubahan Belum Disimpan</h2>
        <p style="color: #6B7280; font-size: 13px; margin: 8px 0 20px 0;">Ada data yang belum disimpan.</p>
        <div style="display: flex; gap: 10px; justify-content: center;">
            <button id="btnTidakPindah" style="flex: 1; padding: 10px; border-radius: 10px; border: 1px solid #E5E7EB; background: white; font-weight: 600; font-size: 13px; cursor: pointer;">Tidak</button>
            <button id="btnYaPindah" style="flex: 1; padding: 10px; border-radius: 10px; border: none; background: #EF4444; color: white; font-weight: 600; font-size: 13px; cursor: pointer;">Ya, Keluar</button>
        </div>
    </div>
</div>

<div id="modalSukses" style="display: none; position: fixed; z-index: 99999; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); backdrop-filter: blur(3px); align-items: center; justify-content: center;">
    <div style="background: white; padding: 25px; border-radius: 20px; width: 320px; text-align: center; box-shadow: 0 15px 30px rgba(0,0,0,0.15);">
        <div style="color: #10B981; font-size: 50px; margin-bottom: 10px;"><i class="fas fa-check-circle"></i></div>
        <h2 style="margin: 0; font-size: 18px; color: #111827; font-weight: 700;">Berhasil!</h2>
        <p style="color: #6B7280; font-size: 13px; margin: 8px 0 20px 0;" id="pesanSukses">Data tentor berhasil diupdate.</p>
        <button id="btnOkSukses" style="width: 100%; padding: 10px; border-radius: 10px; border: none; background: #10B981; color: white; font-weight: 600; font-size: 13px; cursor: pointer;">OK</button>
    </div>
</div>

<script>
    (function() {
        var form = document.getElementById('mainForm');
        var btnKeluar = document.getElementById('btnKeluar');
        var btnUpdate = document.getElementById('btnUpdate');
        var modalBatal = document.getElementById('modalBatal');
        var modalPindahHalaman = document.getElementById('modalPindahHalaman');
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

        // Track perubahan form
        if (form) {
            form.querySelectorAll('input:not([readonly]), select, textarea').forEach(function(el) {
                el.addEventListener('input', function() { if (!formSubmitted) formChanged = true; });
                el.addEventListener('change', function() { if (!formSubmitted) formChanged = true; });
            });
        }

        function tampilkanError(pesan) {
            if (alertError && alertErrorText) {
                alertErrorText.textContent = pesan;
                alertError.style.display = 'flex';
                setTimeout(function() { alertError.style.display = 'none'; }, 5000);
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

        if (btnKeluar) {
            btnKeluar.addEventListener('click', function(e) {
                e.preventDefault();
                if (formChanged && !formSubmitted) {
                    if (modalPindahHalaman) modalPindahHalaman.style.display = 'flex';
                } else {
                    if (modalBatal) modalBatal.style.display = 'flex';
                }
            });
        }

        if (btnTidakBatal) btnTidakBatal.addEventListener('click', function() { if (modalBatal) modalBatal.style.display = 'none'; });
        if (btnYaKeluar) btnYaKeluar.addEventListener('click', function() { 
            if (modalBatal) modalBatal.style.display = 'none'; 
            tutupModalForm();
        });
        if (btnTidakPindah) btnTidakPindah.addEventListener('click', function() { if (modalPindahHalaman) modalPindahHalaman.style.display = 'none'; });
        if (btnYaPindah) btnYaPindah.addEventListener('click', function() { 
            if (modalPindahHalaman) modalPindahHalaman.style.display = 'none'; 
            tutupModalForm();
        });
        if (btnOkSukses) btnOkSukses.addEventListener('click', function() { 
            if (modalSukses) modalSukses.style.display = 'none'; 
            setTimeout(function() {
                tutupModalForm();
                try {
                    window.parent.location.reload();
                } catch(e) {
                    console.log('Tidak dapat reload parent');
                }
            }, 300);
        });

        if (modalBatal) modalBatal.addEventListener('click', function(e) { if (e.target === modalBatal) modalBatal.style.display = 'none'; });
        if (modalPindahHalaman) modalPindahHalaman.addEventListener('click', function(e) { if (e.target === modalPindahHalaman) modalPindahHalaman.style.display = 'none'; });
        if (modalSukses) modalSukses.addEventListener('click', function(e) { if (e.target === modalSukses) modalSukses.style.display = 'none'; });

        // Submit form
        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Validasi sederhana
                var nama = document.querySelector('input[name="nama_lengkap"]');
                var alamat = document.querySelector('textarea[name="alamat"]');
                var noHp = document.querySelector('input[name="no_hp"]');
                var email = document.querySelector('input[name="email"]');
                var username = document.querySelector('input[name="username"]');
                
                if (!nama || !nama.value.trim()) { tampilkanError('Nama lengkap harus diisi'); return; }
                if (!alamat || !alamat.value.trim()) { tampilkanError('Alamat harus diisi'); return; }
                if (!noHp || !noHp.value.trim()) { tampilkanError('No HP harus diisi'); return; }
                if (!email || !email.value.trim()) { tampilkanError('Email harus diisi'); return; }
                if (!username || !username.value.trim()) { tampilkanError('Username harus diisi'); return; }
                
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
                        if (pesanSukses) pesanSukses.textContent = data.message || 'Data tentor berhasil diupdate.';
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
                        if (btnUpdate) { btnUpdate.disabled = false; btnUpdate.innerHTML = 'Update'; }
                    }
                })
                .catch(function(err) {
                    console.error('Fetch error:', err);
                    tampilkanError('Terjadi kesalahan: ' + err.message);
                    if (btnUpdate) { btnUpdate.disabled = false; btnUpdate.innerHTML = 'Update'; }
                });
            });
        }
    })();
</script><?php /**PATH C:\xampp\htdocs\Privat-Bimbel\resources\views/dashboard/superadmin/kelola-tentor/edit-tentor.blade.php ENDPATH**/ ?>