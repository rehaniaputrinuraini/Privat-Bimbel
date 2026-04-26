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
                    <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 6px;">Periode Aktif <span style="color: #EF4444;">*</span></label>
                    <input type="text" value="<?php echo e($periodeAktif ? $periodeAktif->tahun_periode : 'Tidak ada periode aktif'); ?>" readonly
                           style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: #F3F4F6; outline: none; font-size: 14px; font-family: 'Poppins', sans-serif; color: #4D0B87; font-weight: 600;">
                    <small style="color: #6B7280; font-size: 11px; display: block; margin-top: 4px;">
                        <?php if($periodeAktif): ?>
                            <?php echo e(date('d M Y', strtotime($periodeAktif->tanggal_mulai))); ?> - <?php echo e(date('d M Y', strtotime($periodeAktif->tanggal_selesai))); ?>

                        <?php else: ?>
                            Silakan tambahkan periode terlebih dahulu
                        <?php endif; ?>
                    </small>
                </div>
                <input type="hidden" name="id_periode" value="<?php echo e($periodeAktif ? $periodeAktif->id_periode : ''); ?>">
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
</div><?php /**PATH C:\xampp\htdocs\Privat-Bimbel\resources\views/dashboard/shared/kelola-murid/create-murid.blade.php ENDPATH**/ ?>