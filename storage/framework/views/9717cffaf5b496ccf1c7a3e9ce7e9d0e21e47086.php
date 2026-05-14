

<?php $__env->startSection('title', 'Edit Profil'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .cropper-container {
        max-width: 100%;
        max-height: 350px;
        margin: 0 auto;
    }
</style>
<link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div style="padding: 10px; font-family: 'Poppins', sans-serif;">
    
    <?php
        $user = Auth::user();
        $pegawai = $user->pegawai;
    ?>

    
    <div id="modalBatal" style="display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); backdrop-filter: blur(3px); align-items: center; justify-content: center;">
        <div style="background: white; padding: 25px; border-radius: 20px; width: 320px; text-align: center; box-shadow: 0 15px 30px rgba(0,0,0,0.15); font-family: 'Poppins', sans-serif;">
            <div style="color: #F59E0B; font-size: 40px; margin-bottom: 10px;"><i class="fas fa-exclamation-triangle"></i></div>
            <h2 style="margin: 0; font-size: 18px; color: #111827; font-weight: 700;">Batalkan?</h2>
            <p style="color: #6B7280; font-size: 13px; margin: 8px 0 20px 0;">Data yang Anda masukkan tidak akan disimpan. Yakin ingin keluar?</p>
            <div style="display: flex; gap: 10px; justify-content: center;">
                <button onclick="tutupModalBatal()" style="flex: 1; padding: 10px; border-radius: 10px; border: 1px solid #E5E7EB; background: white; font-weight: 600; font-size: 13px; cursor: pointer;">Tidak</button>
                <a href="<?php echo e(route('profile.index')); ?>" style="flex: 1; text-decoration: none;">
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

    
    <div id="modalCrop" style="display: none; position: fixed; z-index: 99999; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.9); align-items: center; justify-content: center; flex-direction: column;">
        <div style="color: white; font-size: 18px; font-weight: 600; margin-bottom: 15px; font-family: 'Poppins', sans-serif;">Sesuaikan Foto</div>
        <div class="cropper-container" style="width: 350px; height: 350px;">
            <img id="imagePreview" src="" alt="Preview">
        </div>
        <div style="display: flex; gap: 15px; margin-top: 20px;">
            <button onclick="batalCrop()" style="padding: 10px 30px; border-radius: 10px; border: 1px solid white; background: transparent; color: white; font-weight: 600; cursor: pointer; font-family: 'Poppins', sans-serif;">Batal</button>
            <button onclick="simpanCrop()" style="padding: 10px 30px; border-radius: 10px; border: none; background: #10B981; color: white; font-weight: 600; cursor: pointer; font-family: 'Poppins', sans-serif;">Simpan</button>
        </div>
    </div>

    
    <div style="margin-bottom: 30px;">
        <h1 style="font-size: 28px; font-weight: 800; color: #111827; margin: 0;">Edit Profil</h1>
        <p style="color: #6B7280; font-size: 16px; margin-top: 5px;">Perbarui Informasi Profil Anda</p>
    </div>

    
    <form action="<?php echo e(route('profile.update')); ?>" method="POST" enctype="multipart/form-data" id="mainForm">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div style="display: flex; gap: 30px; align-items: flex-start;">
            
            
            <div style="flex: 1; background: white; padding: 40px 20px; border-radius: 20px; border: 1px solid #E5E7EB; box-shadow: 0 4px 20px rgba(0,0,0,0.05); text-align: center;">
                
                
                <div id="fotoContainer" style="width: 180px; height: 180px; border-radius: 50%; margin: 0 auto 25px; overflow: hidden; position: relative; border: 4px solid #4D0B87;">
                    <?php if($user->foto): ?>
                        <img id="fotoProfilPreview" src="<?php echo e(asset('storage/' . $user->foto)); ?>" alt="Foto Profil" style="width: 100%; height: 100%; object-fit: cover; display: block;">
                        <span id="inisialText" style="display: none; position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: #4D0B87; color: white; font-size: 70px; font-weight: 800; align-items: center; justify-content: center;"><?php echo e(strtoupper(substr($pegawai->nama_lengkap ?? $user->username ?? 'U', 0, 2))); ?></span>
                        <button type="button" onclick="hapusFoto()" style="position: absolute; bottom: 5px; right: 5px; background: #EF4444; color: white; border: none; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 2px 5px rgba(0,0,0,0.2); z-index: 10;">
                            <i class="fas fa-trash-alt" style="font-size: 16px;"></i>
                        </button>
                    <?php else: ?>
                        <span id="inisialText" style="display: flex; align-items: center; justify-content: center; width: 100%; height: 100%; background: #4D0B87; color: white; font-size: 70px; font-weight: 800;"><?php echo e(strtoupper(substr($pegawai->nama_lengkap ?? $user->username ?? 'U', 0, 2))); ?></span>
                        <img id="fotoProfilPreview" src="" alt="Preview" style="display: none; width: 100%; height: 100%; object-fit: cover; position: absolute; top: 0; left: 0;">
                    <?php endif; ?>
                </div>
                
                <label for="foto_profil" style="display: flex; align-items: center; justify-content: center; gap: 10px; color: #4D0B87; font-weight: 700; font-size: 18px; cursor: pointer; margin-bottom: 10px;">
                    <i class="fas fa-upload"></i> Unggah Foto
                </label>
                <input type="file" id="foto_profil" name="foto" accept="image/*" style="display: none;" onchange="bukaCrop(this)">
                <input type="hidden" name="hapus_foto" id="hapus_foto" value="0">
                
                <p style="color: #6B7280; font-size: 14px; margin: 0;">Format: PNG, JPG (Max. 2MB)</p>
            </div>

            
            <div style="flex: 2; background: white; padding: 35px; border-radius: 20px; border: 1px solid #E5E7EB; box-shadow: 0 4px 20px rgba(0,0,0,0.05);">
                
                <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 25px;">
                    <button type="button" onclick="bukaModalBatal()"
                            style="display: flex; align-items: center; justify-content: center; width: 42px; height: 42px; background-color: #4D0B87; border-radius: 50%; border: none; cursor: pointer; color: white; box-shadow: 0 4px 6px rgba(0,0,0,0.1); transition: all 0.3s ease;">
                        <i class="fas fa-arrow-left" style="font-size: 18px;"></i>
                    </button>
                    <h2 style="font-size: 22px; font-weight: 800; color: #111827; margin: 0;">Informasi Profil</h2>
                </div>
                
                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 8px;">Nama Lengkap <span style="color: #EF4444;">*</span></label>
                    <input type="text" name="nama_lengkap" value="<?php echo e(old('nama_lengkap', $pegawai->nama_lengkap ?? '')); ?>" placeholder="Masukkan Nama Lengkap"
                           style="width: 100%; padding: 14px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: white; color: #111827; font-size: 15px; outline: none; box-sizing: border-box;">
                    <?php $__errorArgs = ['nama_lengkap'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small style="color:#EF4444;"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 8px;">Email <span style="color: #EF4444;">*</span></label>
                    <input type="email" name="email" value="<?php echo e(old('email', $user->email ?? '')); ?>" placeholder="Masukkan Email"
                           style="width: 100%; padding: 14px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: white; color: #111827; font-size: 15px; outline: none; box-sizing: border-box;">
                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small style="color:#EF4444;"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 8px;">Kontak</label>
                    <input type="text" name="no_hp" value="<?php echo e(old('no_hp', $pegawai->no_hp ?? '')); ?>" placeholder="Masukkan Nomor Kontak"
                           style="width: 100%; padding: 14px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: white; color: #111827; font-size: 15px; outline: none; box-sizing: border-box;">
                    <?php $__errorArgs = ['no_hp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small style="color:#EF4444;"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                
                <div style="display: flex; justify-content: flex-end; margin-top: 30px;">
                    <button type="submit" id="btnSimpan" style="background: #4D0B87; color: white; border: none; padding: 12px 65px; border-radius: 12px; font-weight: 600; font-size: 18px; cursor: pointer; box-shadow: 0 4px 10px rgba(77, 11, 135, 0.3); transition: 0.3s;">
                        Simpan
                    </button>
                </div>
            </div>

        </div>
    </form>

    
    <div style="margin-top: 30px;">
        <a href="<?php echo e(route('password.edit')); ?>" id="ubahPasswordLink" style="text-decoration: none; display: inline-flex; align-items: center; gap: 10px; color: #4D0B87; font-weight: 700; font-size: 18px; transition: 0.3s;">
            Ubah Kata Sandi <i class="fas fa-arrow-right"></i>
        </a>
    </div>

</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<script>
    let cropper;

    // ========== BUKA MODAL CROP ==========
    function bukaCrop(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const imagePreview = document.getElementById('imagePreview');
                imagePreview.src = e.target.result;
                imagePreview.style.display = 'block';
                document.getElementById('modalCrop').style.display = 'flex';
                
                if (cropper) cropper.destroy();
                cropper = new Cropper(imagePreview, {
                    aspectRatio: 1,
                    viewMode: 2,
                    autoCropArea: 1,
                    responsive: true,
                    background: false,
                });
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    // ========== SIMPAN CROP ==========
    function simpanCrop() {
        if (cropper) {
            const canvas = cropper.getCroppedCanvas({ width: 300, height: 300 });
            canvas.toBlob(function(blob) {
                const file = new File([blob], 'foto-profil.jpg', { type: 'image/jpeg' });
                const dt = new DataTransfer();
                dt.items.add(file);
                document.getElementById('foto_profil').files = dt.files;
                
                // Preview
                const url = URL.createObjectURL(blob);
                document.getElementById('fotoProfilPreview').src = url;
                document.getElementById('fotoProfilPreview').style.display = 'block';
                document.getElementById('inisialText').style.display = 'none';
                document.getElementById('hapus_foto').value = '0';
            }, 'image/jpeg', 0.9);
            
            document.getElementById('modalCrop').style.display = 'none';
            cropper.destroy();
        }
    }

    // ========== BATAL CROP ==========
    function batalCrop() {
        document.getElementById('modalCrop').style.display = 'none';
        document.getElementById('foto_profil').value = '';
        if (cropper) cropper.destroy();
    }

    // ========== HAPUS FOTO ==========
    function hapusFoto() {
        document.getElementById('hapus_foto').value = '1';
        document.getElementById('fotoProfilPreview').src = '';
        document.getElementById('fotoProfilPreview').style.display = 'none';
        document.getElementById('inisialText').style.display = 'flex';
        document.getElementById('foto_profil').value = '';
    }

    // ========== SUBMIT FORM (BIASA, TANPA FETCH) ==========
    document.getElementById('mainForm').addEventListener('submit', function() {
        const btn = document.getElementById('btnSimpan');
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
    });

    // ========== UNSAVED CHANGES ==========
    let formChanged = false;
    const form = document.getElementById('mainForm');
    const inputs = form.querySelectorAll('input:not([type="file"]):not([type="hidden"]), select, textarea');
    inputs.forEach(input => {
        input.addEventListener('change', () => formChanged = true);
        input.addEventListener('keyup', () => formChanged = true);
    });
    
    function bukaModalBatal() { 
        if (formChanged) {
            document.getElementById('modalPindahHalaman').style.display = 'flex';
            document.getElementById('confirmPindahBtn').onclick = function() {
                formChanged = false;
                window.location.href = "<?php echo e(route('profile.index')); ?>";
            };
        } else {
            document.getElementById('modalBatal').style.display = 'flex';
        }
    }
    
    function tutupModalBatal() { document.getElementById('modalBatal').style.display = 'none'; }
    function tutupModalPindah() { document.getElementById('modalPindahHalaman').style.display = 'none'; }
    
    window.onclick = function(event) {
        if (event.target == document.getElementById('modalBatal')) tutupModalBatal();
        if (event.target == document.getElementById('modalPindahHalaman')) tutupModalPindah();
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Privat-Bimbel\resources\views/dashboard/shared/profil/edit.blade.php ENDPATH**/ ?>