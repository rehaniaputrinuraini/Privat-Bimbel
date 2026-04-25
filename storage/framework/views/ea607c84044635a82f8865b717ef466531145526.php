<div style="padding: 20px; font-family: 'Poppins', sans-serif; background: #FFFFFF; border-radius: 16px;">
    
    <div style="margin-bottom: 20px; padding-bottom: 14px; border-bottom: 1.5px solid #F3F4F6;">
        <h2 style="font-size: 19px; font-weight: 700; color: #111827; margin: 0;">Input Data Murid</h2>
        <p style="color: #9CA3AF; font-size: 12px; margin: 2px 0 0 0;">Lengkapi form di bawah</p>
    </div>

    
    <div id="alertSukses" style="display: none; background: #D1FAE5; color: #065F46; padding: 12px 15px; border-radius: 10px; margin-bottom: 15px; align-items: center; gap: 10px;">
        <i class="fas fa-check-circle" style="font-size: 18px;"></i>
        <span id="alertSuksesText"></span>
    </div>

    
    <div id="alertError" style="display: none; background: #FEE2E2; color: #991B1B; padding: 12px 15px; border-radius: 10px; margin-bottom: 15px; align-items: center; gap: 10px;">
        <i class="fas fa-exclamation-circle" style="font-size: 18px;"></i>
        <span id="alertErrorText"></span>
    </div>

    <form action="<?php echo e(route($role . '.murid.store')); ?>" method="POST" id="mainForm">
        <?php echo csrf_field(); ?>

        <div style="margin-bottom: 15px;">
            <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 6px;">Nama Lengkap <span style="color: #EF4444;">*</span></label>
            <input type="text" name="nama_lengkap" value="<?php echo e(old('nama_lengkap')); ?>" placeholder="Masukkan nama lengkap" required
                   style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: #FFFFFF; outline: none; font-size: 14px; font-family: 'Poppins', sans-serif;"
                   onfocus="this.style.borderColor='#4D0B87'" onblur="this.style.borderColor='#E5E7EB'">
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0 40px; margin-bottom: 15px;">
            <div>
                <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 6px;">Pilih Kelas <span style="color: #EF4444;">*</span></label>
                <select name="id_kelas" id="id_kelas" required style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: #FFFFFF; outline: none; font-size: 14px; font-family: 'Poppins', sans-serif; cursor: pointer;"
                        onfocus="this.style.borderColor='#4D0B87'" onblur="this.style.borderColor='#E5E7EB'">
                    <option value="">-- Pilih Kelas --</option>
                    <?php $__currentLoopData = $kelasList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kelas): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php $sisa = 10 - $kelas->jumlah_murid; ?>
                        <option value="<?php echo e($kelas->id_kelas); ?>" data-jenjang="<?php echo e($kelas->jenjang); ?>" <?php echo e(old('id_kelas') == $kelas->id_kelas ? 'selected' : ''); ?>><?php echo e($kelas->jenjang); ?> - <?php echo e($kelas->nama_kelas); ?> (<?php echo e($sisa); ?> kursi)</option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div>
                <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 6px;">Pilih Paket <span style="color: #EF4444;">*</span></label>
                <select name="id_paket" id="id_paket" required style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: #FFFFFF; outline: none; font-size: 14px; font-family: 'Poppins', sans-serif; cursor: pointer;"
                        onfocus="this.style.borderColor='#4D0B87'" onblur="this.style.borderColor='#E5E7EB'">
                    <option value="">-- Pilih Paket --</option>
                    <?php $__currentLoopData = $paketList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($paket->id_paket); ?>" data-tingkat="<?php echo e($paket->tingkat); ?>" data-harga="<?php echo e($paket->harga); ?>" <?php echo e(old('id_paket') == $paket->id_paket ? 'selected' : ''); ?>><?php echo e($paket->tingkat); ?> - Rp <?php echo e(number_format($paket->harga, 0, ',', '.')); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        </div>

        <div style="margin-bottom: 15px;">
            <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 6px;">Asal Sekolah</label>
            <input type="text" name="asal_sekolah" value="<?php echo e(old('asal_sekolah')); ?>" placeholder="Masukkan asal sekolah"
                   style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: #FFFFFF; outline: none; font-size: 14px; font-family: 'Poppins', sans-serif;"
                   onfocus="this.style.borderColor='#4D0B87'" onblur="this.style.borderColor='#E5E7EB'">
        </div>

        <div style="margin-bottom: 15px;">
            <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 6px;">Alamat</label>
            <textarea name="alamat" rows="3" placeholder="Masukkan alamat lengkap"
                      style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: #FFFFFF; outline: none; font-family: 'Poppins', sans-serif; font-size: 14px; resize: vertical;"
                      onfocus="this.style.borderColor='#4D0B87'" onblur="this.style.borderColor='#E5E7EB'"><?php echo e(old('alamat')); ?></textarea>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0 40px;">
            <div>
                <div style="margin-bottom: 15px;">
                    <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 6px;">No HP Siswa</label>
                    <input type="tel" name="no_hp" value="<?php echo e(old('no_hp')); ?>" placeholder="08xxxxxxxxxx" oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                           style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: #FFFFFF; outline: none; font-size: 14px; font-family: 'Poppins', sans-serif;"
                           onfocus="this.style.borderColor='#4D0B87'" onblur="this.style.borderColor='#E5E7EB'">
                </div>
                <div style="margin-bottom: 15px;">
                    <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 6px;">Nama Orang Tua</label>
                    <input type="text" name="nama_orang_tua" value="<?php echo e(old('nama_orang_tua')); ?>" placeholder="Nama orang tua"
                           style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: #FFFFFF; outline: none; font-size: 14px; font-family: 'Poppins', sans-serif;"
                           onfocus="this.style.borderColor='#4D0B87'" onblur="this.style.borderColor='#E5E7EB'">
                </div>
                <div style="margin-bottom: 15px;">
                    <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 6px;">No HP Orang Tua</label>
                    <input type="tel" name="no_hp_orang_tua" value="<?php echo e(old('no_hp_orang_tua')); ?>" placeholder="08xxxxxxxxxx" oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                           style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: #FFFFFF; outline: none; font-size: 14px; font-family: 'Poppins', sans-serif;"
                           onfocus="this.style.borderColor='#4D0B87'" onblur="this.style.borderColor='#E5E7EB'">
                </div>
            </div>
            <div>
                <div style="margin-bottom: 15px;">
                    <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 6px;">Detail Paket</label>
                    <div style="padding: 12px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: #F9FAFB;">
                        <span id="hargaPaket" style="font-weight: 700; color: #4D0B87; font-size: 14px;">-</span>
                    </div>
                </div>
                <div style="margin-bottom: 15px;">
                    <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 6px;">Tahun Masuk</label>
                    <input type="tel" name="tahun_masuk" value="<?php echo e(old('tahun_masuk', date('Y'))); ?>" oninput="this.value = this.value.replace(/[^0-9]/g, '')" maxlength="4"
                           style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: #FFFFFF; outline: none; font-size: 14px; font-family: 'Poppins', sans-serif;"
                           onfocus="this.style.borderColor='#4D0B87'" onblur="this.style.borderColor='#E5E7EB'">
                </div>
                <input type="hidden" name="id_periode" value="<?php echo e($periodeAktif->id_periode ?? ''); ?>">
            </div>
        </div>

        
        <div style="display: flex; justify-content: flex-end; gap: 20px; margin-top: 30px; padding-top: 16px; border-top: 1.5px solid #F3F4F6;">
            <button type="button" id="btnKeluar"
                    style="padding: 10px 45px; border: 1.5px solid #4D0B87; color: #4D0B87; border-radius: 10px; font-weight: 600; font-size: 16px; background: #FFFFFF; cursor: pointer; transition: 0.3s;">
                Keluar
            </button>
            <button type="submit" id="btnSimpan"
                    style="padding: 10px 45px; border: none; background: #4D0B87; color: white; border-radius: 10px; font-weight: 600; font-size: 16px; cursor: pointer; box-shadow: 0 4px 6px rgba(77, 11, 135, 0.2); transition: 0.3s;">
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
        <p style="color: #6B7280; font-size: 13px; margin: 8px 0 20px 0;" id="pesanSukses">Data murid berhasil disimpan.</p>
        <button type="button" id="btnOkSukses" style="width: 100%; padding: 10px; border-radius: 10px; border: none; background: #10B981; color: white; font-weight: 600; font-size: 13px; cursor: pointer;">OK</button>
    </div>
</div>

<script>
    // Script ini akan dieksekusi setelah DOM dimuat
    document.addEventListener('DOMContentLoaded', function() {
        
        // ===== AMBIL ELEMEN =====
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
        
        let formChanged = false;
        
        // ===== DETEKSI PERUBAHAN FORM =====
        if (form) {
            const inputs = form.querySelectorAll('input, select, textarea');
            inputs.forEach(function(input) {
                input.addEventListener('change', function() { 
                    formChanged = true; 
                    console.log('Form changed to true'); 
                });
                input.addEventListener('keyup', function() { 
                    formChanged = true; 
                });
            });
        }
        
        // ===== FUNGSI TAMPILKAN ERROR =====
        function tampilkanError(pesan) {
            if (alertError && alertErrorText) {
                alertErrorText.textContent = pesan;
                alertError.style.display = 'flex';
                setTimeout(function() {
                    alertError.style.display = 'none';
                }, 5000);
            }
        }
        
        // ===== EVENT: BUTTON KELUAR =====
        if (btnKeluar) {
            btnKeluar.addEventListener('click', function() {
                console.log('Button Keluar diklik, formChanged:', formChanged);
                if (formChanged) {
                    if (modalPindahHalaman) {
                        modalPindahHalaman.style.display = 'flex';
                    }
                } else {
                    if (modalBatal) {
                        modalBatal.style.display = 'flex';
                    }
                }
            });
        }
        
        // ===== EVENT: MODAL BATAL =====
        if (btnTidakBatal) {
            btnTidakBatal.addEventListener('click', function() {
                if (modalBatal) modalBatal.style.display = 'none';
            });
        }
        
        if (btnYaKeluar) {
            btnYaKeluar.addEventListener('click', function() {
                console.log('Konfirmasi keluar dari modal batal');
                formChanged = false;
                // Panggil fungsi tutupModalForm dari parent
                if (window.parent && typeof window.parent.tutupModalForm === 'function') {
                    window.parent.tutupModalForm();
                } else {
                    // Fallback
                    const parentModalForm = window.parent.document.getElementById('modalForm');
                    if (parentModalForm) {
                        parentModalForm.style.display = 'none';
                        const parentModalContent = window.parent.document.getElementById('modalContent');
                        if (parentModalContent) {
                            parentModalContent.innerHTML = '';
                        }
                    }
                }
            });
        }
        
        // Close modal batal if click outside
        if (modalBatal) {
            modalBatal.addEventListener('click', function(e) {
                if (e.target === modalBatal) {
                    modalBatal.style.display = 'none';
                }
            });
        }
        
        // ===== EVENT: MODAL PINDAH HALAMAN =====
        if (btnTidakPindah) {
            btnTidakPindah.addEventListener('click', function() {
                if (modalPindahHalaman) modalPindahHalaman.style.display = 'none';
            });
        }
        
        if (btnYaPindah) {
            btnYaPindah.addEventListener('click', function() {
                console.log('Konfirmasi keluar dari modal pindah');
                formChanged = false;
                // Panggil fungsi tutupModalForm dari parent
                if (window.parent && typeof window.parent.tutupModalForm === 'function') {
                    window.parent.tutupModalForm();
                } else {
                    const parentModalForm = window.parent.document.getElementById('modalForm');
                    if (parentModalForm) {
                        parentModalForm.style.display = 'none';
                        const parentModalContent = window.parent.document.getElementById('modalContent');
                        if (parentModalContent) {
                            parentModalContent.innerHTML = '';
                        }
                    }
                }
            });
        }
        
        // Close modal pindah if click outside
        if (modalPindahHalaman) {
            modalPindahHalaman.addEventListener('click', function(e) {
                if (e.target === modalPindahHalaman) {
                    modalPindahHalaman.style.display = 'none';
                }
            });
        }
        
        // ===== EVENT: MODAL SUKSES =====
        if (btnOkSukses) {
            btnOkSukses.addEventListener('click', function() {
                if (modalSukses) modalSukses.style.display = 'none';
                
                // Tutup modal form dan reload parent
                setTimeout(function() {
                    if (window.parent && typeof window.parent.tutupModalForm === 'function') {
                        window.parent.tutupModalForm();
                    } else {
                        const parentModalForm = window.parent.document.getElementById('modalForm');
                        if (parentModalForm) {
                            parentModalForm.style.display = 'none';
                            const parentModalContent = window.parent.document.getElementById('modalContent');
                            if (parentModalContent) {
                                parentModalContent.innerHTML = '';
                            }
                        }
                    }
                    window.parent.location.reload();
                }, 300);
            });
        }
        
        // Close modal sukses if click outside
        if (modalSukses) {
            modalSukses.addEventListener('click', function(e) {
                if (e.target === modalSukses) {
                    modalSukses.style.display = 'none';
                    setTimeout(function() {
                        if (window.parent && typeof window.parent.tutupModalForm === 'function') {
                            window.parent.tutupModalForm();
                        }
                        window.parent.location.reload();
                    }, 300);
                }
            });
        }
        
        // ===== EVENT: SUBMIT FORM =====
        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const formData = new FormData(form);
                
                // Loading state
                if (btnSimpan) {
                    btnSimpan.disabled = true;
                    btnSimpan.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
                }
                
                fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                        'Accept': 'application/json'
                    }
                })
                .then(function(r) {
                    return r.json().then(function(data) {
                        return { status: r.status, data: data };
                    });
                })
                .then(function(result) {
                    if (result.data.success) {
                        formChanged = false;
                        // Tampilkan modal sukses
                        if (pesanSukses) {
                            pesanSukses.textContent = result.data.message || 'Data murid berhasil disimpan.';
                        }
                        if (modalSukses) {
                            modalSukses.style.display = 'flex';
                        }
                    } else {
                        // Tampilkan error
                        let errorMsg = result.data.message || 'Gagal menyimpan data';
                        if (result.data.errors) {
                            errorMsg = '';
                            for (let field in result.data.errors) {
                                errorMsg += result.data.errors[field].join('\n') + '\n';
                            }
                        }
                        tampilkanError(errorMsg);
                        if (btnSimpan) {
                            btnSimpan.disabled = false;
                            btnSimpan.innerHTML = 'Simpan';
                        }
                    }
                })
                .catch(function(err) {
                    console.error('Error:', err);
                    tampilkanError('Terjadi kesalahan: ' + err.message);
                    if (btnSimpan) {
                        btnSimpan.disabled = false;
                        btnSimpan.innerHTML = 'Simpan';
                    }
                });
            });
        }
        
        // ===== EVENT: SELECT KELAS DAN PAKET =====
        const kelasSelect = document.getElementById('id_kelas');
        const paketSelect = document.getElementById('id_paket');
        const hargaPaket = document.getElementById('hargaPaket');
        
        if (kelasSelect && paketSelect) {
            kelasSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const jenjang = selectedOption?.getAttribute('data-jenjang');
                if (jenjang) {
                    for (let i = 0; i < paketSelect.options.length; i++) {
                        if (paketSelect.options[i].getAttribute('data-tingkat') === jenjang) {
                            paketSelect.value = paketSelect.options[i].value;
                            paketSelect.dispatchEvent(new Event('change'));
                            break;
                        }
                    }
                }
            });
            
            paketSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const harga = selectedOption?.getAttribute('data-harga');
                if (harga && hargaPaket) {
                    hargaPaket.innerHTML = 'Rp ' + new Intl.NumberFormat('id-ID').format(harga);
                }
            });
            
            // Trigger change saat load jika ada selected
            if (paketSelect.value) {
                paketSelect.dispatchEvent(new Event('change'));
            }
        }
        
        console.log('Create Murid Script Loaded Successfully');
    });
</script><?php /**PATH C:\xampp\htdocs\Privat-Bimbel\resources\views/dashboard/shared/kelola-murid/create-murid.blade.php ENDPATH**/ ?>