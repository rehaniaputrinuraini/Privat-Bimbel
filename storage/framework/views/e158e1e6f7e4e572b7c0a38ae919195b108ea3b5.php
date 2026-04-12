

<?php $__env->startSection('title', 'Profil ' . (Auth::user()->peran ?? 'User')); ?>

<?php $__env->startSection('content'); ?>
<div style="padding: 10px; font-family: 'Poppins', sans-serif;">
    
    
    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 30px;">
        <div>
            
            <h1 style="font-size: 26px; font-weight: 700; color: #111827; margin: 0; letter-spacing: -0.5px; line-height: 1.2;">
                Profil <?php echo e(Auth::user()->peran ?? 'User'); ?>

            </h1>
            <p style="color: #374151; font-size: 14px; margin: 4px 0 0 0;">Informasi Profil</p>
        </div>
        
        <a href="<?php echo e(route('profile.edit')); ?>" style="text-decoration: none;">
            <button style="background: #4D0B87; color: white; border: none; padding: 12px 35px; border-radius: 10px; font-weight: 700; cursor: pointer; font-size: 16px; shadow: 0 4px 10px rgba(77, 11, 135, 0.2);">
                Edit Profil
            </button>
        </a>
    </div>

    <div style="display: flex; gap: 30px; align-items: flex-start;">
        
        
        <div style="flex: 1; background: white; padding: 40px 20px; border-radius: 20px; border: 1px solid #E5E7EB; box-shadow: 0 4px 20px rgba(0,0,0,0.05); text-align: center;">
            
            <div style="width: 180px; height: 180px; background: #4D0B87; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 25px;">
                <span style="color: white; font-size: 70px; font-weight: 800;">
                    
                    <?php echo e(strtoupper(substr(Auth::user()->name ?? 'UA', 0, 2))); ?>

                </span>
            </div>
            
            
            <h2 style="font-size: 24px; font-weight: 800; color: #111827; margin: 0;">
                <?php echo e(Auth::user()->name ?? 'Nama User'); ?>

            </h2>
            
            
            <p style="color: #6B7280; font-size: 16px; font-weight: 500; margin-top: 5px;">
                <?php echo e(Auth::user()->peran ?? 'User'); ?>

            </p>
        </div>

        
        <div style="flex: 2; background: white; padding: 35px; border-radius: 20px; border: 1px solid #E5E7EB; box-shadow: 0 4px 20px rgba(0,0,0,0.05);">
            <h2 style="font-size: 22px; font-weight: 800; color: #111827; margin: 0 0 25px 0;">Informasi Profil</h2>
            
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 8px;">Nama Lengkap</label>
                <input type="text" value="<?php echo e(Auth::user()->name ?? '-'); ?>" readonly
                       style="width: 100%; padding: 14px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: #f9fafb; color: #4B5563; font-size: 15px; outline: none;">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 8px;">Email</label>
                <input type="email" value="<?php echo e(Auth::user()->email ?? '-'); ?>" readonly
                       style="width: 100%; padding: 14px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: #f9fafb; color: #4B5563; font-size: 15px; outline: none;">
            </div>

            <div style="margin-bottom: 10px;">
                <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 8px;">Kontak</label>
                <input type="text" value="<?php echo e(Auth::user()->kontak ?? '-'); ?>" readonly
                       style="width: 100%; padding: 14px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: #f9fafb; color: #4B5563; font-size: 15px; outline: none;">
            </div>
        </div>

    </div>

    
    <div style="margin-top: 30px;">
        <a href="<?php echo e(route('password.edit')); ?>" style="text-decoration: none; display: flex; align-items: center; gap: 10px; color: #4D0B87; font-weight: 700; font-size: 18px; width: fit-content;">
            Ubah Kata Sandi <i class="fas fa-arrow-right"></i>
        </a>
    </div>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Privat-Bimbel\resources\views/dashboard/shared/profil/index.blade.php ENDPATH**/ ?>