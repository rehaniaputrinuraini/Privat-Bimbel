

<?php $__env->startSection('title', 'Profil ' . ucfirst(Auth::user()->peran ?? 'User')); ?>

<?php $__env->startPush('styles'); ?>
<style>
    /* MODAL PREVIEW FOTO */
    .modal-preview-foto {
        display: none;
        position: fixed;
        z-index: 99999;
        left: 0; top: 0;
        width: 100%; height: 100%;
        background: rgba(0,0,0,0.85);
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
    .modal-preview-header {
        position: fixed;
        top: 0; left: 0; right: 0;
        display: flex;
        justify-content: flex-end;
        align-items: center;
        padding: 12px 20px;
        background: rgba(0,0,0,0.6);
        z-index: 10;
    }
    .modal-preview-header .btn-icon {
        background: rgba(255,255,255,0.15);
        border: none;
        color: white;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 16px;
        transition: 0.2s;
    }
    .modal-preview-header .btn-icon:hover {
        background: rgba(255,255,255,0.3);
    }
    .modal-preview-body {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 100%;
        padding: 60px 20px 20px 20px;
    }
    .modal-preview-body img {
        max-width: 95%;
        max-height: 88vh;
        object-fit: contain;
        border-radius: 4px;
    }
    .foto-profil-clickable {
        cursor: pointer;
        transition: 0.2s;
    }
    .foto-profil-clickable:hover {
        opacity: 0.9;
        transform: scale(1.02);
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div style="padding: 10px; font-family: 'Poppins', sans-serif;">
    
    <?php
        $user = Auth::user();
        $pegawai = $user->pegawai;
    ?>

    
    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 30px;">
        <div>
            <h1 style="font-size: 26px; font-weight: 700; color: #111827; margin: 0; letter-spacing: -0.5px; line-height: 1.2;">
                Profil <?php echo e(ucfirst($user->peran ?? 'User')); ?>

            </h1>
            <p style="color: #374151; font-size: 14px; margin: 4px 0 0 0;">Informasi Profil</p>
        </div>
        
        <a href="<?php echo e(route('profile.edit')); ?>" style="text-decoration: none;">
            <button style="background: #4D0B87; color: white; border: none; padding: 12px 35px; border-radius: 10px; font-weight: 700; cursor: pointer; font-size: 16px; box-shadow: 0 4px 10px rgba(77, 11, 135, 0.2);">
                Edit Profil
            </button>
        </a>
    </div>

    <div style="display: flex; gap: 30px; align-items: flex-start;">
        
        
        <div style="flex: 1; background: white; padding: 40px 20px; border-radius: 20px; border: 1px solid #E5E7EB; box-shadow: 0 4px 20px rgba(0,0,0,0.05); text-align: center;">
            
            <?php if($user->foto): ?>
                <div class="foto-profil-clickable" onclick="bukaPreviewFoto('<?php echo e(asset('storage/' . $user->foto)); ?>')" style="width: 180px; height: 180px; border-radius: 50%; overflow: hidden; margin: 0 auto 25px; border: 4px solid #4D0B87;">
                    <img src="<?php echo e(asset('storage/' . $user->foto)); ?>" alt="Foto Profil" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
            <?php else: ?>
                <div style="width: 180px; height: 180px; background: #4D0B87; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 25px;">
                    <span style="color: white; font-size: 70px; font-weight: 800;">
                        <?php echo e(strtoupper(substr($pegawai->nama_lengkap ?? $user->username ?? 'U', 0, 2))); ?>

                    </span>
                </div>
            <?php endif; ?>
            
            
            <h2 style="font-size: 24px; font-weight: 800; color: #111827; margin: 0;">
                <?php echo e($pegawai->nama_lengkap ?? $user->username ?? 'Nama User'); ?>

            </h2>
            
            
            <p style="color: #6B7280; font-size: 16px; font-weight: 500; margin-top: 5px;">
                <?php echo e(ucfirst($user->peran ?? 'user')); ?>

            </p>
        </div>

        
        <div style="flex: 2; background: white; padding: 35px; border-radius: 20px; border: 1px solid #E5E7EB; box-shadow: 0 4px 20px rgba(0,0,0,0.05);">
            <h2 style="font-size: 22px; font-weight: 800; color: #111827; margin: 0 0 25px 0;">Informasi Profil</h2>
            
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 8px;">Nama Lengkap</label>
                <input type="text" value="<?php echo e($pegawai->nama_lengkap ?? '-'); ?>" readonly
                       style="width: 100%; padding: 14px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: #f9fafb; color: #4B5563; font-size: 15px; outline: none;">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 8px;">Email</label>
                <input type="email" value="<?php echo e($user->email ?? '-'); ?>" readonly
                       style="width: 100%; padding: 14px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: #f9fafb; color: #4B5563; font-size: 15px; outline: none;">
            </div>

            <div style="margin-bottom: 10px;">
                <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 8px;">Kontak</label>
                <input type="text" value="<?php echo e($pegawai->no_hp ?? '-'); ?>" readonly
                       style="width: 100%; padding: 14px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: #f9fafb; color: #4B5563; font-size: 15px; outline: none;">
            </div>
        </div>

    </div>

    
    <div style="margin-top: 30px;">
        <a href="<?php echo e(route('password.edit')); ?>" style="text-decoration: none; display: flex; align-items: center; gap: 10px; color: #4D0B87; font-weight: 700; font-size: 18px; width: fit-content;">
            Ubah Kata Sandi <i class="fas fa-arrow-right"></i>
        </a>
    </div>

    <?php if(session('success')): ?>
        <div style="background: #D1FAE5; color: #065F46; padding: 12px; border-radius: 10px; margin-top: 20px;">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

</div>


<div id="modalPreviewFoto" class="modal-preview-foto" onclick="tutupPreviewFoto(event)">
    <div class="modal-preview-header">
        <button onclick="document.getElementById('modalPreviewFoto').style.display='none'" class="btn-icon" title="Tutup">
            <i class="fas fa-times"></i>
        </button>
    </div>
    <div class="modal-preview-body">
        <img id="previewFotoImg" src="" alt="Foto Profil">
    </div>
</div>

<script>
    function bukaPreviewFoto(url) {
        document.getElementById('previewFotoImg').src = url;
        document.getElementById('modalPreviewFoto').style.display = 'flex';
    }

    function tutupPreviewFoto(event) {
        if (event.target === document.getElementById('modalPreviewFoto')) {
            document.getElementById('modalPreviewFoto').style.display = 'none';
        }
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            document.getElementById('modalPreviewFoto').style.display = 'none';
        }
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Privat-Bimbel\resources\views/dashboard/shared/profil/index.blade.php ENDPATH**/ ?>