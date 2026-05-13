<div style="padding: 20px; font-family: 'Poppins', sans-serif; background: #FFFFFF; border-radius: 16px;">
    
    <div style="margin-bottom: 20px; padding-bottom: 14px; border-bottom: 1.5px solid #F3F4F6;">
        <h2 style="font-size: 19px; font-weight: 700; color: #111827; margin: 0;">Input Data Admin</h2>
        <p style="color: #9CA3AF; font-size: 12px; margin: 2px 0 0 0;">Lengkapi form di bawah</p>
    </div>

    <div id="alertError" style="display: none; background: #FEE2E2; color: #991B1B; padding: 12px 15px; border-radius: 10px; margin-bottom: 15px; align-items: center; gap: 10px;">
        <i class="fas fa-exclamation-circle" style="font-size: 18px;"></i>
        <span id="alertErrorText"></span>
    </div>

    <form action="<?php echo e(route('superadmin.kelola-admin.store')); ?>" method="POST" id="mainForm">
        <?php echo csrf_field(); ?>
        
        <div style="margin-bottom: 15px;">
            <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 6px;">Nama Lengkap <span style="color: #EF4444;">*</span></label>
            <input type="text" name="nama_lengkap" value="<?php echo e(old('nama_lengkap')); ?>" placeholder="Masukkan Nama Lengkap" required
                   style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: #FFFFFF; outline: none; font-size: 14px; font-family: 'Poppins', sans-serif; box-sizing: border-box;">
        </div>

        <div style="margin-bottom: 15px;">
            <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 6px;">Alamat</label>
            <textarea name="alamat" rows="2" placeholder="Masukkan Alamat"
                      style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: #FFFFFF; outline: none; font-family: 'Poppins', sans-serif; font-size: 14px; resize: vertical; box-sizing: border-box;"><?php echo e(old('alamat')); ?></textarea>
        </div>

        <div style="margin-bottom: 15px;">
            <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 6px;">No HP</label>
            <input type="text" name="no_hp" value="<?php echo e(old('no_hp')); ?>" placeholder="Masukkan No HP"
                   oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                   style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: #FFFFFF; outline: none; font-size: 14px; font-family: 'Poppins', sans-serif; box-sizing: border-box;">
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0 40px; margin-bottom: 15px;">
            <div>
                <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 6px;">Gaji Pokok (Rp)</label>
                <input type="text" name="gaji_pokok" value="<?php echo e(old('gaji_pokok')); ?>" placeholder="Masukkan Gaji Pokok"
                       oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                       style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: #FFFFFF; outline: none; font-size: 14px; font-family: 'Poppins', sans-serif; box-sizing: border-box;">
            </div>
            <div>
                <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 6px;">Email <span style="color: #EF4444;">*</span></label>
                <input type="email" name="email" value="<?php echo e(old('email')); ?>" placeholder="Masukkan Email" required
                       style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: #FFFFFF; outline: none; font-size: 14px; font-family: 'Poppins', sans-serif; box-sizing: border-box;">
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0 40px; margin-bottom: 15px;">
            <div>
                <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 6px;">Username <span style="color: #EF4444;">*</span></label>
                <input type="text" name="username" value="<?php echo e(old('username')); ?>" placeholder="Masukkan Username" required
                       style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: #FFFFFF; outline: none; font-size: 14px; font-family: 'Poppins', sans-serif; box-sizing: border-box;">
            </div>
            <div>
                <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 6px;">Password <span style="color: #EF4444;">*</span></label>
                <div style="position: relative; width: 100%;">
                    <input type="password" name="password" id="password" placeholder="Masukkan Password" required autocomplete="new-password"
                           style="width: 100%; padding: 12px 45px 12px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: #FFFFFF; outline: none; font-size: 14px; font-family: 'Poppins', sans-serif; box-sizing: border-box;">
                    <button type="button" id="togglePassword"
                            style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #9CA3AF; font-size: 18px; padding: 0;">
                        <i class="fas fa-eye-slash"></i>
                    </button>
                </div>
            </div>
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 20px; margin-top: 30px; padding-top: 16px; border-top: 1.5px solid #F3F4F6;">
            <button type="button" id="btnKeluar"
                    style="padding: 10px 45px; border: 1.5px solid #4D0B87; color: #4D0B87; border-radius: 10px; font-weight: 600; font-size: 16px; background: #FFFFFF; cursor: pointer;">
                Keluar
            </button>
            <button type="submit" id="btnSimpan"
                    style="padding: 10px 45px; border: none; background: #4D0B87; color: white; border-radius: 10px; font-weight: 600; font-size: 16px; cursor: pointer; box-shadow: 0 4px 6px rgba(77, 11, 135, 0.2);">
                Simpan
            </button>
        </div>
    </form>
</div>


<div id="modalBatal" style="display: none; position: fixed; z-index: 99999; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); backdrop-filter: blur(3px); align-items: center; justify-content: center;">
    <div style="background: white; padding: 25px; border-radius: 20px; width: 320px; text-align: center; box-shadow: 0 15px 30px rgba(0,0,0,0.15); font-family: 'Poppins', sans-serif;">
        <div style="color: #F59E0B; font-size: 40px; margin-bottom: 10px;"><i class="fas fa-exclamation-triangle"></i></div>
        <h2 style="margin: 0; font-size: 18px; color: #111827; font-weight: 700;">Batalkan?</h2>
        <p style="color: #6B7280; font-size: 13px; margin: 8px 0 20px 0;">Data yang Anda masukkan tidak akan disimpan. Yakin ingin keluar?</p>
        <div style="display: flex; gap: 10px; justify-content: center;">
            <button type="button" id="btnTidakBatal" style="flex: 1; padding: 10px; border-radius: 10px; border: 1px solid #E5E7EB; background: white; color: #374151; font-weight: 600; font-size: 13px; cursor: pointer;">Tidak</button>
            <button type="button" id="btnYaKeluar" style="flex: 1; padding: 10px; border-radius: 10px; border: none; background: #EF4444; color: white; font-weight: 600; font-size: 13px; cursor: pointer;">Ya, Keluar</button>
        </div>
    </div>
</div>


<div id="modalPindahHalaman" style="display: none; position: fixed; z-index: 10000; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); backdrop-filter: blur(3px); align-items: center; justify-content: center;">
    <div style="background: white; padding: 25px; border-radius: 20px; width: 320px; text-align: center; box-shadow: 0 15px 30px rgba(0,0,0,0.15); font-family: 'Poppins', sans-serif;">
        <div style="color: #F59E0B; font-size: 40px; margin-bottom: 10px;"><i class="fas fa-exclamation-triangle"></i></div>
        <h2 style="margin: 0; font-size: 18px; color: #111827; font-weight: 700;">Perubahan Belum Disimpan</h2>
        <p style="color: #6B7280; font-size: 13px; margin: 8px 0 20px 0;">Ada data yang belum disimpan. Yakin ingin meninggalkan halaman ini?</p>
        <div style="display: flex; gap: 10px; justify-content: center;">
            <button type="button" id="btnTidakPindah" style="flex: 1; padding: 10px; border-radius: 10px; border: 1px solid #E5E7EB; background: white; font-weight: 600; font-size: 13px; cursor: pointer;">Tidak</button>
            <button type="button" id="btnYaPindah" style="flex: 1; padding: 10px; border-radius: 10px; border: none; background: #EF4444; color: white; font-weight: 600; font-size: 13px; cursor: pointer;">Ya, Keluar</button>
        </div>
    </div>
</div>


<div id="modalSukses" style="display: none; position: fixed; z-index: 99999; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); backdrop-filter: blur(3px); align-items: center; justify-content: center;">
    <div style="background: white; padding: 25px; border-radius: 20px; width: 320px; text-align: center; box-shadow: 0 15px 30px rgba(0,0,0,0.15); font-family: 'Poppins', sans-serif;">
        <div style="color: #10B981; font-size: 50px; margin-bottom: 10px;"><i class="fas fa-check-circle"></i></div>
        <h2 style="margin: 0; font-size: 18px; color: #111827; font-weight: 700;">Berhasil!</h2>
        <p style="color: #6B7280; font-size: 13px; margin: 8px 0 20px 0;" id="pesanSukses">Data admin berhasil disimpan.</p>
        <button type="button" id="btnOkSukses" style="width: 100%; padding: 10px; border-radius: 10px; border: none; background: #10B981; color: white; font-weight: 600; font-size: 13px; cursor: pointer;">OK</button>
    </div>
</div>

<script>
    // ========== TOGGLE PASSWORD ==========
    const toggleBtn = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');

    if (toggleBtn && passwordInput) {
        toggleBtn.addEventListener('click', function() {
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                this.innerHTML = '<i class="fas fa-eye"></i>';
                this.style.color = '#4D0B87';
            } else {
                passwordInput.type = 'password';
                this.innerHTML = '<i class="fas fa-eye-slash"></i>';
                this.style.color = '#9CA3AF';
            }
        });
    }

    // ========== DETECT FORM CHANGES ==========
    let formChanged = false;
    let formSubmitted = false;
    const form = document.getElementById('mainForm');
    const btnKeluar = document.getElementById('btnKeluar');
    const btnSimpan = document.getElementById('btnSimpan');
    const modalBatal = document.getElementById('modalBatal');
    const modalPindahHalaman = document.getElementById('modalPindahHalaman');
    const modalSukses = document.getElementById('modalSukses');
    const btnTidakBatal = document.getElementById('btnTidakBatal');
    const btnYaKeluar = document.getElementById('btnYaKeluar');
    const btnTidakPindah = document.getElementById('btnTidakPindah');
    const btnYaPindah = document.getElementById('btnYaPindah');
    const btnOkSukses = document.getElementById('btnOkSukses');
    const alertError = document.getElementById('alertError');
    const alertErrorText = document.getElementById('alertErrorText');
    const pesanSukses = document.getElementById('pesanSukses');

    if (form) {
        const inputs = form.querySelectorAll('input:not([readonly]), select, textarea');
        inputs.forEach(input => {
            input.addEventListener('input', () => { if (!formSubmitted) formChanged = true; });
            input.addEventListener('change', () => { if (!formSubmitted) formChanged = true; });
        });
    }

    if (btnKeluar) {
        btnKeluar.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            if (formChanged && !formSubmitted) {
                if (modalPindahHalaman) modalPindahHalaman.style.display = 'flex';
            } else {
                if (modalBatal) modalBatal.style.display = 'flex';
            }
        });
    }

    if (btnTidakBatal) btnTidakBatal.addEventListener('click', () => { if (modalBatal) modalBatal.style.display = 'none'; });
    if (btnYaKeluar) btnYaKeluar.addEventListener('click', () => { formChanged = false; if (modalBatal) modalBatal.style.display = 'none'; window.parent.tutupModalForm(); });
    if (modalBatal) modalBatal.addEventListener('click', (e) => { if (e.target === modalBatal) modalBatal.style.display = 'none'; });

    if (btnTidakPindah) btnTidakPindah.addEventListener('click', () => { if (modalPindahHalaman) modalPindahHalaman.style.display = 'none'; });
    if (btnYaPindah) btnYaPindah.addEventListener('click', () => { formChanged = false; if (modalPindahHalaman) modalPindahHalaman.style.display = 'none'; window.parent.tutupModalForm(); });
    if (modalPindahHalaman) modalPindahHalaman.addEventListener('click', (e) => { if (e.target === modalPindahHalaman) modalPindahHalaman.style.display = 'none'; });

    if (btnOkSukses) btnOkSukses.addEventListener('click', () => { if (modalSukses) modalSukses.style.display = 'none'; window.parent.tutupModalForm(); window.parent.location.reload(); });
    if (modalSukses) modalSukses.addEventListener('click', (e) => { if (e.target === modalSukses) { modalSukses.style.display = 'none'; window.parent.tutupModalForm(); window.parent.location.reload(); } });

    if (form) {
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            const submitBtn = btnSimpan;
            const originalText = submitBtn ? submitBtn.innerHTML : 'Simpan';
            if (submitBtn) { submitBtn.disabled = true; submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...'; }

            fetch(form.action, {
                method: 'POST',
                body: new FormData(form),
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    formChanged = false;
                    formSubmitted = true;
                    if (pesanSukses) pesanSukses.textContent = data.message || 'Data admin berhasil disimpan.';
                    if (modalSukses) modalSukses.style.display = 'flex';
                } else {
                    let errorMsg = data.message || 'Gagal menyimpan data';
                    if (data.errors) { errorMsg = ''; for (let field in data.errors) { errorMsg += data.errors[field].join('\n') + '\n'; } }
                    if (alertError && alertErrorText) { alertErrorText.textContent = errorMsg; alertError.style.display = 'flex'; setTimeout(() => { alertError.style.display = 'none'; }, 5000); }
                    if (submitBtn) { submitBtn.disabled = false; submitBtn.innerHTML = originalText; }
                }
            })
            .catch(err => {
                if (alertError && alertErrorText) { alertErrorText.textContent = 'Terjadi kesalahan: ' + err.message; alertError.style.display = 'flex'; setTimeout(() => { alertError.style.display = 'none'; }, 5000); }
                if (submitBtn) { submitBtn.disabled = false; submitBtn.innerHTML = originalText; }
            });
        });
    }
</script><?php /**PATH C:\xampp\htdocs\Privat-Bimbel\resources\views/dashboard/superadmin/kelola-admin/create-admin.blade.php ENDPATH**/ ?>