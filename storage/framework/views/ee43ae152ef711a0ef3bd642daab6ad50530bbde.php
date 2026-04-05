



<?php $__env->startSection('title', 'Dashboard ' . ucfirst(Auth::user()->peran ?? 'Admin')); ?>

<?php $__env->startSection('content'); ?>


<div style="margin-bottom: 25px;">
    <p style="color: #6B7280; font-size: 13px; margin-bottom: 4px;">
        <?php echo e(\Carbon\Carbon::now()->translatedFormat('F Y')); ?>

    </p>
    <h1 style="font-size: 26px; font-weight: 700; color: #111827; margin: 0; letter-spacing: -0.5px;">
        Dashboard <?php echo e(ucfirst(Auth::user()->peran ?? 'Admin')); ?>

    </h1>
    <p style="color: #6B7280; font-size: 14px; margin-top: 4px;">Selamat Datang di Sistem Manajemen Bimbel Privat</p>
</div>


<div class="stats-grid" style="display: grid; grid-template-columns: repeat(5, 1fr); gap: 15px; margin-bottom: 30px;">

    <?php
        $stats = [
            ['title' => 'Total Murid',  'val' => '307',         'bg' => '#3A3AA7', 'icon' => 'icon_orang.png',       'size' => '30px'],
            ['title' => 'Total Tentor', 'val' => '20',          'bg' => '#BE7E5E', 'icon' => 'icon_orang.png',       'size' => '30px'],
            ['title' => 'Pemasukan',    'val' => 'Rp 500.000',    'bg' => '#0CCC0C', 'icon' => 'icon_pemasukan.png',   'size' => '25px'],
            ['title' => 'Pengeluaran',  'val' => 'Rp 200.000',    'bg' => '#F14D4D', 'icon' => 'icon_pengeluaran.png', 'size' => '25px'],
            ['title' => 'Laba Bersih',  'val' => 'Rp 300.000',    'bg' => '#E7C255', 'icon' => 'icon_lababersih.png',  'size' => '25px'],
        ];

        $role = Auth::user()->peran ?? 'admin';
    ?>

    <?php $__currentLoopData = $stats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="stat-box" style="background: white; height: 160px; border-radius: 20px; position: relative; display: flex; flex-direction: column; align-items: center; justify-content: flex-end; box-shadow: 0 4px 15px rgba(0,0,0,0.08); padding: 20px;">
        <div style="position: absolute; top: 15px; left: 15px; background: <?php echo e($s['bg']); ?>; width: 45px; height: 45px; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
            <img src="<?php echo e(asset('images/dashboard/icons/' . $s['icon'])); ?>"
                 style="width: <?php echo e($s['size']); ?>; height: <?php echo e($s['size']); ?>; object-fit: contain; filter: brightness(0) invert(1);">
        </div>
        <div style="height: 40px; display: flex; align-items: center; justify-content: center; width: 100%;">
            <h3 style="font-size: <?php echo e(str_contains($s['val'], 'Rp') ? '20px' : '32px'); ?>; font-weight: 700; color: #111827; margin: 0; line-height: 1;">
                <?php echo e($s['val']); ?>

            </h3>
        </div>
        <div style="height: 20px; display: flex; align-items: center; justify-content: center; width: 100%; margin-top: 5px;">
            <p style="color: #6B7280; font-size: 12px; font-weight: 500; margin: 0;"><?php echo e($s['title']); ?></p>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</div>


<div class="finance-panel" style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.08); border: 1px solid #F3F4F6;">
    
    
    <div style="display: flex; justify-content: space-between; align-items: center; background-color: #F3E8FF; padding: 15px 25px; border-bottom: 1px solid #E5E7EB;">
        <h2 style="font-size: 16px; font-weight: 700; color: #111827; margin: 0;">Rincian Keuangan Terakhir</h2>
        <?php if($role !== 'tentor'): ?>
            <a href="<?php echo e(route($role . '.laporan-keuangan')); ?>" style="color: #4D0B87; text-decoration: none; font-weight: 700; font-size: 13px;">Lihat Semua</a>
        <?php endif; ?>
    </div>

    
    <div style="padding: 20px; display: flex; flex-direction: column; gap: 10px;">
        
        <div style="display: flex; justify-content: space-between; align-items: center; padding: 14px 20px; background: #60A060; color: white; border-radius: 12px; transition: 0.2s;">
            <span style="font-weight: 600; font-size: 14px;">Pembayaran Murid SD</span>
            <span style="font-weight: 700; font-size: 14px;">Rp. 5.000.000</span>
        </div>

        <div style="display: flex; justify-content: space-between; align-items: center; padding: 14px 20px; background: #D74E4E; color: white; border-radius: 12px; transition: 0.2s;">
            <span style="font-weight: 600; font-size: 14px;">Bayar WiFi</span>
            <span style="font-weight: 700; font-size: 14px;">Rp. 100.000</span>
        </div>

        <div style="display: flex; justify-content: space-between; align-items: center; padding: 14px 20px; background: #60A060; color: white; border-radius: 12px; transition: 0.2s;">
            <span style="font-weight: 600; font-size: 14px;">Pembayaran Murid SMA</span>
            <span style="font-weight: 700; font-size: 14px;">Rp. 5.000.000</span>
        </div>

    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Privat-Bimbel\resources\views/dashboard/shared/halaman-utama/index.blade.php ENDPATH**/ ?>