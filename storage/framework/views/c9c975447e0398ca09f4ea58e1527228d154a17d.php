

<?php $__env->startSection('title', 'Edit Periode'); ?>

<?php $__env->startSection('content'); ?>
<div style="padding: 10px; font-family: 'Poppins', sans-serif;">
    <h1 style="font-size: 20px; font-weight: 700; color: #111827; margin-bottom: 20px;">Edit Periode</h1>

    <div style="background: #F9FAFB; border-radius: 15px; padding: 30px; border: 1.5px solid #E5E7EB;">
        <form action="<?php echo e(route($role . '.periode.update', $periode->id_periode)); ?>" method="POST" id="mainForm">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            
            
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">ID Periode</label>
                <input type="text" value="PR<?php echo e(str_pad($periode->id_periode, 4, '0', STR_PAD_LEFT)); ?>" readonly 
                       style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #F3F4F6; outline: none; color: #6B7280; font-size: 14px;">
            </div>

            
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Tahun Periode <span style="color: red;">*</span></label>
                <input type="text" name="tahun_periode" value="<?php echo e(old('tahun_periode', $periode->tahun_periode)); ?>" 
                       placeholder="Contoh: 2024/2025" maxlength="9" required
                       style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; outline: none;">
                <small style="color: #6B7280;">Format: YYYY/YYYY (contoh: 2024/2025)</small>
                <?php $__errorArgs = ['tahun_periode'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <br><small style="color: red;"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Tanggal Mulai <span style="color: red;">*</span></label>
                <input type="date" name="tanggal_mulai" value="<?php echo e(old('tanggal_mulai', $periode->tanggal_mulai)); ?>" required
                       style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; outline: none;">
                <?php $__errorArgs = ['tanggal_mulai'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small style="color: red;"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Tanggal Selesai <span style="color: red;">*</span></label>
                <input type="date" name="tanggal_selesai" value="<?php echo e(old('tanggal_selesai', $periode->tanggal_selesai)); ?>" required
                       style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; outline: none;">
                <?php $__errorArgs = ['tanggal_selesai'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small style="color: red;"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            
            <div style="display: flex; justify-content: flex-end; gap: 20px; margin-top: 30px;">
                <a href="<?php echo e(route($role . '.master-data')); ?>" style="padding: 10px 45px; border: 1.5px solid #4D0B87; color: #4D0B87; border-radius: 10px; font-weight: 600; text-decoration: none;">Keluar</a>
                <button type="submit" style="padding: 10px 45px; border: none; background: #4D0B87; color: white; border-radius: 10px; font-weight: 600;">Simpan</button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Privat-Bimbel\resources\views/dashboard/shared/master-data/periode/edit.blade.php ENDPATH**/ ?>