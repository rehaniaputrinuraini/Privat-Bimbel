

<?php $__env->startSection('title', 'Input Data Murid'); ?>

<?php $__env->startSection('content'); ?>
<div style="padding: 10px; font-family: 'Poppins', sans-serif;">
    <h1 style="font-size: 20px; font-weight: 700; color: #111827; margin-bottom: 20px;">Input Data Murid</h1>

    <div style="background: #F9FAFB; border-radius: 15px; padding: 30px; border: 1.5px solid #E5E7EB; box-shadow: 0 4px 10px rgba(0,0,0,0.02);">
        <form action="<?php echo e(route($role . '.murid.store')); ?>" method="POST" id="mainForm">
            <?php echo csrf_field(); ?>

            
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Nama Lengkap <span style="color: red;">*</span></label>
                <input type="text" name="nama_lengkap" placeholder="Masukkan Nama Lengkap" 
                       value="<?php echo e(old('nama_lengkap')); ?>" required
                       style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none; font-size: 14px;">
                <?php $__errorArgs = ['nama_lengkap'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small style="color: red;"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Pilih Kelas <span style="color: red;">*</span></label>
                <select name="id_kelas" id="id_kelas" required 
                        style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none; font-size: 14px;">
                    <option value="">-- Pilih Kelas --</option>
                    <?php $__currentLoopData = $kelasList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kelas): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $sisaKursi = 10 - $kelas->jumlah_murid;
                        ?>
                        <option value="<?php echo e($kelas->id_kelas); ?>" 
                                data-jenjang="<?php echo e($kelas->jenjang); ?>" 
                                data-nama="<?php echo e($kelas->nama_kelas); ?>"
                                <?php echo e(old('id_kelas') == $kelas->id_kelas ? 'selected' : ''); ?>>
                            <?php echo e($kelas->jenjang); ?> - <?php echo e($kelas->nama_kelas); ?> (<?php echo e($sisaKursi); ?> kursi tersedia)
                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <small id="infoKelas" style="color: #6B7280; display: block; margin-top: 5px;">Pilih kelas yang tersedia</small>
                <?php $__errorArgs = ['id_kelas'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small style="color: red;"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Asal Sekolah</label>
                <input type="text" name="asal_sekolah" placeholder="Masukkan Asal Sekolah" 
                       value="<?php echo e(old('asal_sekolah')); ?>"
                       style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none; font-size: 14px;">
                <?php $__errorArgs = ['asal_sekolah'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small style="color: red;"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Alamat</label>
                <textarea name="alamat" rows="3" placeholder="Masukkan Alamat Lengkap"
                          style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none; font-family: 'Poppins', sans-serif; font-size: 14px; resize: vertical;"><?php echo e(old('alamat')); ?></textarea>
                <?php $__errorArgs = ['alamat'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small style="color: red;"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <hr style="border: 0; border-top: 1px solid #E5E7EB; margin-bottom: 25px;">

            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0 40px; align-items: start;">
                
                <div>
                    
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">No HP Siswa</label>
                        <input type="tel" inputmode="numeric" name="no_hp" placeholder="Masukkan No HP Siswa"
                               value="<?php echo e(old('no_hp')); ?>"
                               onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                               oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                               style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none; font-size: 14px;">
                        <?php $__errorArgs = ['no_hp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small style="color: red;"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Nama Orang Tua</label>
                        <input type="text" name="nama_orang_tua" placeholder="Masukkan Nama Orang Tua"
                               value="<?php echo e(old('nama_orang_tua')); ?>"
                               style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none; font-size: 14px;">
                        <?php $__errorArgs = ['nama_orang_tua'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small style="color: red;"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">No HP Orang Tua</label>
                        <input type="tel" inputmode="numeric" name="no_hp_orang_tua" placeholder="Masukkan No HP Orang Tua"
                               value="<?php echo e(old('no_hp_orang_tua')); ?>"
                               onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                               oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                               style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none; font-size: 14px;">
                        <?php $__errorArgs = ['no_hp_orang_tua'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small style="color: red;"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                
                <div>
                    
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Pilih Paket <span style="color: red;">*</span></label>
                        <select name="id_paket" id="id_paket" required 
                                style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none; font-size: 14px;">
                            <option value="">-- Pilih Paket --</option>
                            <?php $__currentLoopData = $paketList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($paket->id_paket); ?>" 
                                        data-tingkat="<?php echo e($paket->tingkat); ?>" 
                                        data-harga="<?php echo e($paket->harga); ?>"
                                        <?php echo e(old('id_paket') == $paket->id_paket ? 'selected' : ''); ?>>
                                    <?php echo e($paket->tingkat); ?> - Rp <?php echo e(number_format($paket->harga, 0, ',', '.')); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <small id="infoPaket" style="color: #6B7280; display: block; margin-top: 5px;">Pilih paket untuk melihat detail harga</small>
                        <?php $__errorArgs = ['id_paket'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small style="color: red;"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Detail Paket</label>
                        <div style="padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #F3F4F6;">
                            <span id="hargaPaket" style="font-weight: 700; color: #4D0B87;">-</span>
                            <span id="deskripsiPaket" style="display: block; font-size: 12px; color: #6B7280; margin-top: 5px;"></span>
                        </div>
                    </div>

                    
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Tahun Masuk</label>
                        <input type="tel" inputmode="numeric" name="tahun_masuk" placeholder="Masukkan Tahun Masuk" 
                               value="<?php echo e(old('tahun_masuk', date('Y'))); ?>"
                               min="2000" max="<?php echo e(date('Y')); ?>"
                               onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                               oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                               style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none; font-size: 14px;">
                        <?php $__errorArgs = ['tahun_masuk'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small style="color: red;"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    
                    <input type="hidden" name="id_periode" value="<?php echo e($periodeAktif->id_periode ?? ''); ?>">
                </div>
            </div>

            
            <div style="display: flex; justify-content: flex-end; gap: 20px; margin-top: 30px;">
                <button type="button" onclick="bukaModalBatal()" 
                        style="padding: 10px 45px; border: 1.5px solid #4D0B87; color: #4D0B87; border-radius: 10px; font-weight: 600; font-size: 16px; background: #FFFFFF; cursor: pointer;">Keluar</button>
                <button type="submit" 
                        style="padding: 10px 45px; border: none; background: #4D0B87; color: white; border-radius: 10px; font-weight: 600; font-size: 16px; cursor: pointer; box-shadow: 0 4px 6px rgba(77, 11, 135, 0.2);">Simpan</button>
            </div>
        </form>
    </div>
</div>


<div id="modalBatal" style="display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); backdrop-filter: blur(3px); align-items: center; justify-content: center;">
    <div style="background: white; padding: 25px; border-radius: 20px; width: 320px; text-align: center; box-shadow: 0 15px 30px rgba(0,0,0,0.15); font-family: 'Poppins', sans-serif;">
        <div style="color: #F59E0B; font-size: 40px; margin-bottom: 10px;"><i class="fas fa-exclamation-triangle"></i></div>
        <h2 style="margin: 0; font-size: 18px; color: #111827; font-weight: 700;">Batalkan?</h2>
        <p style="color: #6B7280; font-size: 13px; margin: 8px 0 20px 0;">Data yang Anda masukkan tidak akan disimpan. Yakin ingin keluar?</p>
        <div style="display: flex; gap: 10px; justify-content: center;">
            <button onclick="tutupModalBatal()" style="flex: 1; padding: 10px; border-radius: 10px; border: 1px solid #E5E7EB; background: white; font-weight: 600; font-size: 13px; cursor: pointer;">Tidak</button>
            <a href="<?php echo e(route($role . '.kelola-murid')); ?>" id="confirmKeluarLink" style="flex: 1; text-decoration: none;">
                <button type="button" style="width: 100%; padding: 10px; border-radius: 10px; border: none; background: #EF4444; color: white; font-weight: 600; font-size: 13px; cursor: pointer;">Ya, Keluar</button>
            </a>
        </div>
    </div>
</div>


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
                window.location.href = "<?php echo e(route($role . '.kelola-murid')); ?>";
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Privat-Bimbel\resources\views/dashboard/shared/kelola-murid/create-murid.blade.php ENDPATH**/ ?>