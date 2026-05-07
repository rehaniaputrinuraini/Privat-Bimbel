<header class="header">
    <div class="header-left">
        <i class="fas fa-bars burger-btn" id="toggle-sidebar"></i>
        <img src="<?php echo e(asset('images/logo/foto_logo.png')); ?>" alt="Logo" class="logo-img">
    </div>
    <div class="header-center">
        <div class="tagline">Prestasi Lebih Baik</div>
    </div>
    <div class="header-right">
        <a href="<?php echo e(route('profile.index')); ?>" class="profile-link">
            <div class="user-avatar-top">
                <?php
                    $user = Auth::user();
                ?>
                <?php if($user->foto): ?>
                    <img src="<?php echo e(asset('storage/' . $user->foto)); ?>" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                <?php else: ?>
                    <img src="<?php echo e(asset('images/dashboard/icons/icon_orang.png')); ?>" alt="Avatar">
                <?php endif; ?>
            </div>
        </a>
    </div>
</header><?php /**PATH C:\xampp\htdocs\Privat-Bimbel\resources\views/components/header.blade.php ENDPATH**/ ?>