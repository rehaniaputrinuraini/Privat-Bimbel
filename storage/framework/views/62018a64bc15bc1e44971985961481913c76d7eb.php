



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
        $statsList = [
            ['title' => 'Total Murid',  'val' => number_format($stats['total_murid'], 0, ',', '.'),         'bg' => '#3A3AA7', 'icon' => 'icon_orang.png',       'size' => '35px'],
            ['title' => 'Total Tentor', 'val' => number_format($stats['total_tentor'], 0, ',', '.'),        'bg' => '#BE7E5E', 'icon' => 'icon_orang.png',       'size' => '35px'],
            ['title' => 'Pemasukan',    'val' => 'Rp ' . number_format($stats['pemasukan'], 0, ',', '.'),    'bg' => '#0CCC0C', 'icon' => 'icon_pemasukan.png',   'size' => '30px'],
            ['title' => 'Pengeluaran',  'val' => 'Rp ' . number_format($stats['pengeluaran'], 0, ',', '.'),  'bg' => '#F14D4D', 'icon' => 'icon_pengeluaran.png', 'size' => '30px'],
            ['title' => 'Laba Bersih',  'val' => 'Rp ' . number_format($stats['laba_bersih'], 0, ',', '.'),    'bg' => '#E7C255', 'icon' => 'icon_lababersih.png',  'size' => '40px'],
        ];

        $role = Auth::user()->peran ?? 'admin';
    ?>

    <?php $__currentLoopData = $statsList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
        
        <?php $__empty_1 = true; $__currentLoopData = $riwayatKeuangan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php
                $isPemasukan = $item->kategori == 'pemasukan';
                $bgColor = $isPemasukan ? '#60A060' : '#D74E4E';
                $icon = $isPemasukan ? '📥' : '📤';
            ?>
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 14px 20px; background: <?php echo e($bgColor); ?>; color: white; border-radius: 12px; transition: 0.2s;">
                <span style="font-weight: 600; font-size: 14px;">
                    <?php echo e($icon); ?> <?php echo e($item->rincian); ?>

                    <small style="opacity: 0.8; font-weight: normal;">(<?php echo e(\Carbon\Carbon::parse($item->tanggal)->translatedFormat('d M Y')); ?>)</small>
                </span>
                <span style="font-weight: 700; font-size: 14px;">
                    Rp <?php echo e(number_format($item->jumlah, 0, ',', '.')); ?>

                </span>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div style="padding: 20px; text-align: center; color: #9CA3AF;">
                Belum ada data keuangan
            </div>
        <?php endif; ?>

    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\privat-bimbel\resources\views/dashboard/shared/halaman-utama/index.blade.php ENDPATH**/ ?>