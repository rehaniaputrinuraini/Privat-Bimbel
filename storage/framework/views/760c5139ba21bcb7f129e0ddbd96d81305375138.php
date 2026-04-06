

<?php $__env->startSection('title', 'Input Data Tentor'); ?>

<?php $__env->startSection('content'); ?>
<div style="padding: 10px; font-family: 'Poppins', sans-serif;">
    
    <h1 style="font-size: 20px; font-weight: 700; color: #111827; margin-bottom: 20px;">Input Data Tentor</h1>

    <div style="background: #F9FAFB; border-radius: 15px; padding: 30px; border: 1.5px solid #E5E7EB;">
        
        <form action="<?php echo e(route('superadmin.kelola-tentor.store')); ?>" method="POST" id="mainForm">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="peran" value="tentor">
            
            
            <div style="margin-bottom: 15px;">
                <label style="font-weight: 600;">Nama Lengkap <span style="color: red;">*</span></label>
                <input type="text" name="nama_lengkap_tentor" placeholder="Masukkan Nama Lengkap" required
                       style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid #E5E7EB;">
                <?php $__errorArgs = ['nama_lengkap_tentor'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small style="color: red;"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            
            <div style="margin-bottom: 15px;">
                <label style="font-weight: 600;">Alamat</label>
                <input type="text" name="alamat_tentor" placeholder="Masukkan Alamat"
                       style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid #E5E7EB;">
                <?php $__errorArgs = ['alamat_tentor'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small style="color: red;"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            
            <div style="margin-bottom: 15px;">
                <label style="font-weight: 600;">No HP</label>
                <input type="text" name="no_hp_tentor" placeholder="Masukkan No HP"
                       style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid #E5E7EB;">
                <?php $__errorArgs = ['no_hp_tentor'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small style="color: red;"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <hr style="border: 0; border-top: 1px solid #E5E7EB; margin-bottom: 25px;">

            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0 40px;">
                <div>
                    <div style="margin-bottom: 15px;">
                        <label style="font-weight: 600;">Mapel</label>
                        <input type="text" name="mapel" placeholder="Masukkan Mapel"
                               style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid #E5E7EB;">
                        <?php $__errorArgs = ['mapel'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small style="color: red;"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="font-weight: 600;">Grade</label>
                        <select name="grade" style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid #E5E7EB;">
                            <option value="">Pilih Grade</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                        </select>
                        <?php $__errorArgs = ['grade'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small style="color: red;"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="font-weight: 600;">HR SD</label>
                        <input type="number" name="hr_sd" placeholder="Masukkan HR SD"
                               style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid #E5E7EB;">
                        <?php $__errorArgs = ['hr_sd'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small style="color: red;"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="font-weight: 600;">HR SMP</label>
                        <input type="number" name="hr_smp" placeholder="Masukkan HR SMP"
                               style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid #E5E7EB;">
                        <?php $__errorArgs = ['hr_smp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small style="color: red;"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="font-weight: 600;">HR SMA</label>
                        <input type="number" name="hr_sma" placeholder="Masukkan HR SMA"
                               style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid #E5E7EB;">
                        <?php $__errorArgs = ['hr_sma'];
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
                        <label style="font-weight: 600;">Uang Makan</label>
                        <input type="number" name="uang_makan" placeholder="Masukkan Uang Makan"
                               style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid #E5E7EB;">
                        <?php $__errorArgs = ['uang_makan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small style="color: red;"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="font-weight: 600;">Uang Transport</label>
                        <input type="number" name="uang_transport" placeholder="Masukkan Uang Transport"
                               style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid #E5E7EB;">
                        <?php $__errorArgs = ['uang_transport'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small style="color: red;"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="font-weight: 600;">Email <span style="color: red;">*</span></label>
                        <input type="email" name="email" placeholder="Masukkan Email" required
                               style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid #E5E7EB;">
                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small style="color: red;"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="font-weight: 600;">Username <span style="color: red;">*</span></label>
                        <input type="text" name="username" placeholder="Masukkan Username" required
                               style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid #E5E7EB;">
                        <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small style="color: red;"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="font-weight: 600;">Password <span style="color: red;">*</span></label>
                        <input type="password" name="password" placeholder="Masukkan Password" required
                               style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid #E5E7EB;">
                        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small style="color: red;"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
            </div>

            
            <div style="display: flex; justify-content: flex-end; gap: 20px; margin-top: 30px;">
                <button type="button" onclick="bukaModalBatal()" style="padding: 10px 45px; border: 1.5px solid #4D0B87; color: #4D0B87; border-radius: 10px; background: white; cursor: pointer;">Batal</button>
                <button type="submit" style="padding: 10px 45px; border: none; background: #4D0B87; color: white; border-radius: 10px; cursor: pointer;">Simpan</button>
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
            <a href="#" id="confirmKeluarLink" style="flex: 1; text-decoration: none;">
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
    // ========== UNSAVED CHANGES WARNING ==========
    let formChanged = false;
    let pendingUrl = null;
    const form = document.getElementById('mainForm');
    
    if (form) {
        const inputs = form.querySelectorAll('input, select, textarea');
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
                window.location.href = "<?php echo e(route('superadmin.kelola-tentor')); ?>";
            };
        } else {
            document.getElementById('modalBatal').style.display = 'flex';
            document.getElementById('confirmKeluarLink').href = "<?php echo e(route('superadmin.kelola-tentor')); ?>";
        }
    }
    
    function tutupModalBatal() { document.getElementById('modalBatal').style.display = 'none'; }
    function tutupModalPindah() { document.getElementById('modalPindahHalaman').style.display = 'none'; pendingUrl = null; }
    
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
                    } else if (this.classList.contains('logout-btn')) {
                        pendingUrl = "<?php echo e(route('logout')); ?>";
                        document.getElementById('modalPindahHalaman').style.display = 'flex';
                        document.getElementById('confirmPindahBtn').onclick = function() {
                            formChanged = false;
                            document.getElementById('modalPindahHalaman').style.display = 'none';
                            bukaModalLogout();
                        };
                    }
                }
            });
        });
    });
    
    window.onclick = function(event) {
        let modalBatal = document.getElementById('modalBatal');
        let modalPindah = document.getElementById('modalPindahHalaman');
        if (event.target == modalBatal) tutupModalBatal();
        if (event.target == modalPindah) tutupModalPindah();
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Privat-Bimbel\resources\views/dashboard/superadmin/kelola-tentor/create-tentor.blade.php ENDPATH**/ ?>