<div style="padding: 20px; font-family: 'Poppins', sans-serif; background: #FFFFFF; border-radius: 16px;">
    
    <div style="margin-bottom: 20px; padding-bottom: 14px; border-bottom: 1.5px solid #F3F4F6;">
        <h2 style="font-size: 19px; font-weight: 700; color: #111827; margin: 0;">Input Data Tentor</h2>
        <p style="color: #9CA3AF; font-size: 12px; margin: 2px 0 0 0;">Lengkapi form di bawah</p>
    </div>

    <div id="alertError" style="display: none; background: #FEE2E2; color: #991B1B; padding: 12px 15px; border-radius: 10px; margin-bottom: 15px;">
        <i class="fas fa-exclamation-circle"></i> <span id="alertErrorText"></span>
    </div>

    <form id="mainForm" action="<?php echo e(route('superadmin.kelola-tentor.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="peran" value="tentor">

        <div style="margin-bottom: 15px;">
            <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 6px;">Nama Lengkap <span style="color: #EF4444;">*</span></label>
            <input type="text" name="nama_lengkap" value="<?php echo e(old('nama_lengkap')); ?>" placeholder="Masukkan Nama Lengkap" required
                   style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: #FFFFFF; outline: none; font-size: 14px; font-family: 'Poppins', sans-serif;"
                   onfocus="this.style.borderColor='#4D0B87'" onblur="this.style.borderColor='#E5E7EB'">
        </div>

        <div style="margin-bottom: 15px;">
            <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 6px;">Alamat <span style="color: #EF4444;">*</span></label>
            <textarea name="alamat" rows="2" placeholder="Masukkan Alamat" required
                      style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: #FFFFFF; outline: none; font-family: 'Poppins', sans-serif; font-size: 14px; resize: vertical;"
                      onfocus="this.style.borderColor='#4D0B87'" onblur="this.style.borderColor='#E5E7EB'"><?php echo e(old('alamat')); ?></textarea>
        </div>

        <div style="margin-bottom: 15px;">
            <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 6px;">No HP <span style="color: #EF4444;">*</span></label>
            <input type="tel" name="no_hp" value="<?php echo e(old('no_hp')); ?>" placeholder="08xxxxxxxxxx" required
                   oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                   style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: #FFFFFF; outline: none; font-size: 14px; font-family: 'Poppins', sans-serif;"
                   onfocus="this.style.borderColor='#4D0B87'" onblur="this.style.borderColor='#E5E7EB'">
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0 40px;">
            <div>
                <div style="margin-bottom: 15px;"><label style="font-weight: 600; font-size: 14px; color: #374151;">Mapel <span style="color: #EF4444;">*</span></label><input type="text" name="mapel" value="<?php echo e(old('mapel')); ?>" placeholder="Mapel" required style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; outline: none; font-size: 14px; font-family: 'Poppins', sans-serif;"></div>
                <div style="margin-bottom: 15px;"><label style="font-weight: 600; font-size: 14px; color: #374151;">Grade <span style="color: #EF4444;">*</span></label><select name="grade" required style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; outline: none; font-size: 14px; font-family: 'Poppins', sans-serif; cursor: pointer;"><option value="">Pilih</option><option value="A" <?php echo e(old('grade')=='A'?'selected':''); ?>>A</option><option value="B" <?php echo e(old('grade')=='B'?'selected':''); ?>>B</option></select></div>
                <div style="margin-bottom: 15px;"><label style="font-weight: 600; font-size: 14px; color: #374151;">HR SD</label><input type="text" name="hr_sd" value="<?php echo e(old('hr_sd')); ?>" placeholder="HR SD" oninput="this.value = this.value.replace(/[^0-9]/g, '')" style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; outline: none; font-size: 14px; font-family: 'Poppins', sans-serif;"></div>
                <div style="margin-bottom: 15px;"><label style="font-weight: 600; font-size: 14px; color: #374151;">HR SMP</label><input type="text" name="hr_smp" value="<?php echo e(old('hr_smp')); ?>" placeholder="HR SMP" oninput="this.value = this.value.replace(/[^0-9]/g, '')" style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; outline: none; font-size: 14px; font-family: 'Poppins', sans-serif;"></div>
                <div style="margin-bottom: 15px;"><label style="font-weight: 600; font-size: 14px; color: #374151;">HR SMA</label><input type="text" name="hr_sma" value="<?php echo e(old('hr_sma')); ?>" placeholder="HR SMA" oninput="this.value = this.value.replace(/[^0-9]/g, '')" style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; outline: none; font-size: 14px; font-family: 'Poppins', sans-serif;"></div>
            </div>
            <div>
                <div style="margin-bottom: 15px;"><label style="font-weight: 600; font-size: 14px; color: #374151;">Uang Makan</label><input type="text" name="uang_makan" value="<?php echo e(old('uang_makan')); ?>" placeholder="Uang Makan" oninput="this.value = this.value.replace(/[^0-9]/g, '')" style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; outline: none; font-size: 14px; font-family: 'Poppins', sans-serif;"></div>
                <div style="margin-bottom: 15px;"><label style="font-weight: 600; font-size: 14px; color: #374151;">Uang Transport</label><input type="text" name="uang_transport" value="<?php echo e(old('uang_transport')); ?>" placeholder="Uang Transport" oninput="this.value = this.value.replace(/[^0-9]/g, '')" style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; outline: none; font-size: 14px; font-family: 'Poppins', sans-serif;"></div>
                <div style="margin-bottom: 15px;"><label style="font-weight: 600; font-size: 14px; color: #374151;">Email <span style="color: #EF4444;">*</span></label><input type="email" name="email" value="<?php echo e(old('email')); ?>" placeholder="Email" required style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; outline: none; font-size: 14px; font-family: 'Poppins', sans-serif;"></div>
                <div style="margin-bottom: 15px;"><label style="font-weight: 600; font-size: 14px; color: #374151;">Username <span style="color: #EF4444;">*</span></label><input type="text" name="username" value="<?php echo e(old('username')); ?>" placeholder="Username" required style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; outline: none; font-size: 14px; font-family: 'Poppins', sans-serif;"></div>
                <div style="margin-bottom: 15px;"><label style="font-weight: 600; font-size: 14px; color: #374151;">Password <span style="color: #EF4444;">*</span></label><input type="password" name="password" value="<?php echo e(old('password')); ?>" placeholder="Password" required autocomplete="new-password" style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; outline: none; font-size: 14px; font-family: 'Poppins', sans-serif;"></div>
            </div>
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 20px; margin-top: 30px; padding-top: 16px; border-top: 1.5px solid #F3F4F6;">
            <button type="button" id="btnKeluar" style="padding: 10px 45px; border: 1.5px solid #4D0B87; color: #4D0B87; border-radius: 10px; font-weight: 600; font-size: 16px; background: #FFFFFF; cursor: pointer;">Keluar</button>
            <button type="submit" id="btnSimpan" style="padding: 10px 45px; border: none; background: #4D0B87; color: white; border-radius: 10px; font-weight: 600; font-size: 16px; cursor: pointer; box-shadow: 0 4px 6px rgba(77, 11, 135, 0.2);">Simpan</button>
        </div>
    </form>
</div>


<div id="modalBatal" style="display: none; position: fixed; z-index: 99999; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); backdrop-filter: blur(3px); align-items: center; justify-content: center;">
    <div style="background: white; padding: 25px; border-radius: 20px; width: 320px; text-align: center; box-shadow: 0 15px 30px rgba(0,0,0,0.15); font-family: 'Poppins', sans-serif;">
        <div style="color: #F59E0B; font-size: 40px; margin-bottom: 10px;"><i class="fas fa-exclamation-triangle"></i></div>
        <h2 style="margin: 0; font-size: 18px; color: #111827; font-weight: 700;">Batalkan?</h2>
        <p style="color: #6B7280; font-size: 13px; margin: 8px 0 20px 0;">Data yang Anda masukkan tidak akan disimpan.</p>
        <div style="display: flex; gap: 10px; justify-content: center;">
            <button id="btnTidakBatal" style="flex: 1; padding: 10px; border-radius: 10px; border: 1px solid #E5E7EB; background: white; font-weight: 600; font-size: 13px; cursor: pointer;">Tidak</button>
            <button id="btnYaKeluar" style="flex: 1; padding: 10px; border-radius: 10px; border: none; background: #EF4444; color: white; font-weight: 600; font-size: 13px; cursor: pointer;">Ya, Keluar</button>
        </div>
    </div>
</div>


<div id="modalPindahHalaman" style="display: none; position: fixed; z-index: 10000; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); backdrop-filter: blur(3px); align-items: center; justify-content: center;">
    <div style="background: white; padding: 25px; border-radius: 20px; width: 320px; text-align: center; box-shadow: 0 15px 30px rgba(0,0,0,0.15); font-family: 'Poppins', sans-serif;">
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
    <div style="background: white; padding: 25px; border-radius: 20px; width: 320px; text-align: center; box-shadow: 0 15px 30px rgba(0,0,0,0.15); font-family: 'Poppins', sans-serif;">
        <div style="color: #10B981; font-size: 50px; margin-bottom: 10px;"><i class="fas fa-check-circle"></i></div>
        <h2 style="margin: 0; font-size: 18px; color: #111827; font-weight: 700;">Berhasil!</h2>
        <p style="color: #6B7280; font-size: 13px; margin: 8px 0 20px 0;" id="pesanSukses">Data tentor berhasil disimpan.</p>
        <button id="btnOkSukses" style="width: 100%; padding: 10px; border-radius: 10px; border: none; background: #10B981; color: white; font-weight: 600; font-size: 13px; cursor: pointer;">OK</button>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var form = document.getElementById('mainForm');
        var btnKeluar = document.getElementById('btnKeluar');
        var btnSimpan = document.getElementById('btnSimpan');
        var modalBatal = document.getElementById('modalBatal');
        var modalPindahHalaman = document.getElementById('modalPindahHalaman');
        var modalSukses = document.getElementById('modalSukses');
        var alertError = document.getElementById('alertError');
        var alertErrorText = document.getElementById('alertErrorText');
        var pesanSukses = document.getElementById('pesanSukses');
        var formChanged = false;

        if (form) {
            form.querySelectorAll('input, select, textarea').forEach(function(i) {
                i.addEventListener('change', function() { formChanged = true; });
                i.addEventListener('keyup', function() { formChanged = true; });
            });
        }

        function tampilkanError(pesan) {
            alertErrorText.textContent = pesan;
            alertError.style.display = 'flex';
            setTimeout(function() { alertError.style.display = 'none'; }, 5000);
        }

        if (btnKeluar) {
            btnKeluar.addEventListener('click', function() {
                if (formChanged) modalPindahHalaman.style.display = 'flex';
                else modalBatal.style.display = 'flex';
            });
        }

        document.getElementById('btnTidakBatal').addEventListener('click', function() { modalBatal.style.display = 'none'; });
        document.getElementById('btnYaKeluar').addEventListener('click', function() {
            modalBatal.style.display = 'none';
            if (window.parent && window.parent.tutupModalForm) window.parent.tutupModalForm();
        });

        document.getElementById('btnTidakPindah').addEventListener('click', function() { modalPindahHalaman.style.display = 'none'; });
        document.getElementById('btnYaPindah').addEventListener('click', function() {
            modalPindahHalaman.style.display = 'none';
            if (window.parent && window.parent.tutupModalForm) window.parent.tutupModalForm();
        });

        document.getElementById('btnOkSukses').addEventListener('click', function() {
            modalSukses.style.display = 'none';
            setTimeout(function() {
                if (window.parent && window.parent.tutupModalForm) window.parent.tutupModalForm();
                window.parent.location.reload();
            }, 300);
        });

        [modalBatal, modalPindahHalaman, modalSukses].forEach(function(m) {
            if (m) m.addEventListener('click', function(e) { if (e.target === m) m.style.display = 'none'; });
        });

        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                var formData = new FormData(form);
                if (btnSimpan) { btnSimpan.disabled = true; btnSimpan.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...'; }

                fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: { 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '', 'Accept': 'application/json' }
                })
                .then(function(r) { return r.json().then(function(data) { return { status: r.status, data: data }; }); })
                .then(function(result) {
                    if (result.data.success) {
                        if (pesanSukses) pesanSukses.textContent = result.data.message || 'Data tentor berhasil disimpan.';
                        if (modalSukses) modalSukses.style.display = 'flex';
                    } else {
                        var err = result.data.message || 'Gagal';
                        if (result.data.errors) { err = ''; for (var f in result.data.errors) err += result.data.errors[f].join('\n') + '\n'; }
                        tampilkanError(err);
                        if (btnSimpan) { btnSimpan.disabled = false; btnSimpan.innerHTML = 'Simpan'; }
                    }
                })
                .catch(function(err) { tampilkanError(err.message); if (btnSimpan) { btnSimpan.disabled = false; btnSimpan.innerHTML = 'Simpan'; } });
            });
        }
    });
</script><?php /**PATH C:\xampp\htdocs\Privat-Bimbel\resources\views/dashboard/superadmin/kelola-tentor/create-tentor.blade.php ENDPATH**/ ?>