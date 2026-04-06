



<?php $__env->startPush('styles'); ?>
<style>
    /* ── 1. FIX LAYOUT (Tanpa Padding Tambahan) ── */
    .dashboard-wrapper {
        width: 100%;
        /* Mengandalkan .content-wrapper bawaan (25px), 
           tanpa padding kiri tambahan agar lurus dengan sidebar */
    }

    /* ── 2. HEADER STYLE (Sesuai Hirarki Visual) ── */
    .dashboard-header { 
        margin-bottom: 25px; 
    }
    /* Baris 1: Bulan & Tahun (13px) */
    .header-meta { 
        font-size: 13px; 
        color: #6B7280; 
        margin-bottom: 4px; 
        font-weight: 400;
        display: block;
    }
    /* Baris 2: Judul Halaman (26px) */
    .header-title { 
        font-size: 26px; 
        font-weight: 700; 
        color: #111827; 
        margin: 0; 
        letter-spacing: -0.5px;
        line-height: 1.2;
    }
    /* Baris 3: Keterangan (14px) */
    .header-desc { 
        font-size: 14px; 
        color: #6B7280; 
        margin-top: 4px;
        display: block;
    }

    /* ── 3. STAT CARDS (Style Kotak 160px) ── */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
        margin-bottom: 25px;
    }
    .stat-box {
        background: #fff;
        height: 160px;
        border-radius: 20px;
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: flex-end;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        padding: 25px;
        border: 1px solid #F3F4F6;
    }
    .stat-box .icon-wrap {
        position: absolute;
        top: 20px;
        left: 20px;
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 22px;
    }

    /* ── 4. STATUS INDICATOR & ALERT ── */
    .status-panel {
        background: white;
        border-radius: 20px;
        padding: 20px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        border: 1px solid #F3F4F6;
        margin-bottom: 20px;
        display: flex;
        gap: 30px;
    }
    .indicator { display: flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 600; color: #4B5563; }
    .dot { width: 10px; height: 10px; border-radius: 50%; }

    .alert-banner {
        display: flex;
        align-items: center;
        padding: 16px 20px;
        border-radius: 15px;
        color: white;
        font-size: 14px;
        font-weight: 700;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="dashboard-wrapper">

    
    <div class="dashboard-header">
        <span class="header-meta"><?php echo e(\Carbon\Carbon::now()->translatedFormat('F Y')); ?></span>
        <h1 class="header-title">Dashboard Tentor</h1>
        <span class="header-desc">Selamat Datang, <?php echo e($nama_tentor ?? 'Tentor'); ?>!</span>
    </div>

    
    <div class="stats-grid">
        <div class="stat-box">
            <div class="icon-wrap" style="background: #4D0B87;">
                <i class="fas fa-calendar-check"></i>
            </div>
            <h3 style="font-size: 32px; font-weight: 800; margin: 0;"><?php echo e($total_hadir ?? 0); ?> Kali</h3>
            <p style="font-size: 12px; color: #6B7280; margin: 5px 0 0 0;">TOTAL HADIR BULAN INI</p>
        </div>

        <div class="stat-box">
            <div class="icon-wrap" style="background: #F59E0B;">
                <i class="fas fa-clock"></i>
            </div>
            <h3 style="font-size: 32px; font-weight: 800; margin: 0;"><?php echo e($total_jam ?? 0); ?> Jam</h3>
            <p style="font-size: 12px; color: #6B7280; margin: 5px 0 0 0;">TOTAL JAM MENGAJAR</p>
        </div>
    </div>

    
    <div class="status-panel">
        <div class="indicator"><div class="dot" style="background: #EF4444;"></div> Belum Presensi</div>
        <div class="indicator"><div class="dot" style="background: #F59E0B;"></div> Sedang Mengajar</div>
        <div class="indicator"><div class="dot" style="background: #10B981;"></div> Selesai Sesi</div>
    </div>

    
    <?php if($status_hari_ini == 'belum'): ?>
    <div class="alert-banner" style="background: #EF4444;">
        <i class="fas fa-exclamation-triangle" style="margin-right: 12px; font-size: 18px;"></i>
        Silakan lakukan presensi masuk terlebih dahulu untuk memulai sesi mengajar hari ini.
    </div>
    <?php elseif($status_hari_ini == 'sedang'): ?>
    <div class="alert-banner" style="background: #F59E0B;">
        <i class="fas fa-chalkboard-teacher" style="margin-right: 12px; font-size: 18px;"></i>
        Anda sedang dalam sesi mengajar. Jangan lupa verifikasi kehadiran setelah selesai!
    </div>
    <?php else: ?>
    <div class="alert-banner" style="background: #10B981;">
        <i class="fas fa-check-circle" style="margin-right: 12px; font-size: 18px;"></i>
        Sesi mengajar hari ini telah selesai. Terima kasih!
    </div>
    <?php endif; ?>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Privat-Bimbel\resources\views/dashboard/tentor/index.blade.php ENDPATH**/ ?>