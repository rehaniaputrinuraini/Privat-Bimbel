

<?php $__env->startSection('title', 'Riwayat Presensi'); ?>

<?php $__env->startSection('content'); ?>
<div style="width: 100%;">
    
    <div style="margin-bottom: 25px;">
        <p style="color: #374151; font-size: 13px; margin: 0 0 4px 0;">
            <?php echo e(isset($bulan) && isset($tahun) ? \Carbon\Carbon::createFromDate($tahun, $bulan, 1)->translatedFormat('F Y') : \Carbon\Carbon::now()->translatedFormat('F Y')); ?>

        </p>
        <h1 style="font-size: 26px; font-weight: 700; color: #111827; margin: 0; letter-spacing: -0.5px; line-height: 1.2;">
            Riwayat Presensi
        </h1>
        <p style="color: #374151; font-size: 14px; margin: 4px 0 0 0;">Lihat riwayat kehadiran mengajar Anda setiap bulannya</p>
    </div>

    <form method="GET" action="<?php echo e(route('tentor.riwayat-presensi')); ?>" id="filterForm">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; gap: 15px;">
            <div style="display: flex; align-items: center; gap: 12px; flex: 1; flex-wrap: wrap;">
                
                
                <div style="position: relative; width: 300px;">
                    <i class="fas fa-search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #9CA3AF;"></i>
                    <input type="text" id="liveSearchInput" placeholder="Cari Kelas, Jenjang, Status..."
                           style="width: 100%; padding: 10px 15px 10px 45px; border-radius: 12px; border: 1px solid #E5E7EB; outline: none; background: white; font-size: 14px; color: #374151;">
                </div>

                <select name="bulan" style="padding: 10px 12px; border-radius: 12px; border: 1px solid #E5E7EB; color: #374151; font-size: 13px; min-width: 140px; background: white; outline: none; cursor: pointer;" onchange="this.form.submit()">
                    <option value="">--- Pilih Bulan ---</option>
                    <?php $__currentLoopData = range(1, 12); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($b); ?>" <?php echo e(($bulan ?? '') == $b ? 'selected' : ''); ?>>
                            <?php echo e(\Carbon\Carbon::create()->month($b)->translatedFormat('F')); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>

                <select name="tahun" style="padding: 10px 12px; border-radius: 12px; border: 1px solid #E5E7EB; color: #374151; font-size: 13px; min-width: 100px; background: white; outline: none; cursor: pointer;" onchange="this.form.submit()">
                    <option value="">--- Tahun ---</option>
                    <?php $currentYear = date('Y'); ?>
                    <?php for($year = $currentYear - 2; $year <= $currentYear + 1; $year++): ?>
                        <option value="<?php echo e($year); ?>" <?php echo e(($tahun ?? '') == $year ? 'selected' : ''); ?>><?php echo e($year); ?></option>
                    <?php endfor; ?>
                </select>
                
                <?php if(($bulan ?? '') || ($tahun ?? '')): ?>
                    <a href="<?php echo e(route('tentor.riwayat-presensi')); ?>" style="padding: 10px 15px; border-radius: 12px; background: #F3F4F6; color: #374151; text-decoration: none; font-size: 13px;">
                        <i class="fas fa-times"></i> Reset
                    </a>
                <?php endif; ?>
            </div>
        </div>
        
        <input type="hidden" name="perPage" id="perPageInput" value="<?php echo e($perPage ?? 10); ?>">
    </form>

    <div style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.08); border: 1px solid #F3F4F6;">
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 13px; white-space: nowrap;">
                <thead>
                    <tr style="background: #F3E8FF; color: #111827;">
                        <th style="padding: 15px; font-weight: 700; width: 50px;">No</th>
                        <th style="padding: 15px; font-weight: 700;">Tanggal</th>
                        <th style="padding: 15px; font-weight: 700;">Kelas</th>
                        <th style="padding: 15px; font-weight: 700;">Jenjang</th>
                        <th style="padding: 15px; font-weight: 700;">Jam Masuk</th>
                        <th style="padding: 15px; font-weight: 700;">Jam Keluar</th>
                        <th style="padding: 15px; font-weight: 700; text-align: center;">Status Kehadiran Murid</th>
                    </tr>
                </thead>
                <tbody id="tableBody" style="color: #374151;">
                    <?php $__empty_1 = true; $__currentLoopData = $riwayat; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php
                            $statusText = $item->status_murid == 'hadir' ? 'Hadir' : 'Tidak Hadir';
                            $statusClass = $item->status_murid == 'hadir' 
                                ? 'background: #E1F7E3; color: #0E7490;' 
                                : 'background: #FEE2E2; color: #EF4444;';
                            $jamMasuk = $item->jam_masuk ? \Carbon\Carbon::parse($item->jam_masuk)->format('H:i') : '-';
                            $jamKeluar = $item->jam_keluar ? \Carbon\Carbon::parse($item->jam_keluar)->format('H:i') : '-';
                        ?>
                        <tr style="border-bottom: 1px solid #F3F4F6; transition: 0.2s;" onmouseover="this.style.background='#F9FAFB'" onmouseout="this.style.background='transparent'">
                            <td style="padding: 15px;"><?php echo e($riwayat->firstItem() + $index); ?></td>
                            <td style="padding: 15px;"><?php echo e(\Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y')); ?></td>
                            <td style="padding: 15px;"><?php echo e($item->kelas ?? '-'); ?></td>
                            <td style="padding: 15px;"><?php echo e($item->jenjang ?? '-'); ?></td>
                            <td style="padding: 15px;"><?php echo e($jamMasuk); ?></td>
                            <td style="padding: 15px;"><?php echo e($jamKeluar); ?></td>
                            <td style="padding: 15px; text-align: center;">
                                <span style="padding: 5px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; <?php echo e($statusClass); ?>">
                                    <?php echo e($statusText); ?>

                                </span>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" style="padding: 40px; text-align: center; color: #9CA3AF;">
                                <i class="fas fa-calendar-alt" style="font-size: 40px; margin-bottom: 10px; display: block;"></i>
                                <?php if(isset($error) && $error): ?>
                                    <?php echo e($error); ?>

                                <?php else: ?>
                                    Belum ada data presensi
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    
    
    <?php if($riwayat->count() > 0): ?>
    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px; padding: 0 5px;">
        <div style="display: flex; align-items: center; gap: 10px;">
            <select id="perPageSelect" style="padding: 8px 12px; border-radius: 10px; border: 1px solid #E5E7EB; color: #374151; font-size: 13px; background: white; outline: none; cursor: pointer;">
                <option value="10" <?php echo e(($perPage ?? 10) == 10 ? 'selected' : ''); ?>>10 baris</option>
                <option value="25" <?php echo e(($perPage ?? 10) == 25 ? 'selected' : ''); ?>>25 baris</option>
                <option value="50" <?php echo e(($perPage ?? 10) == 50 ? 'selected' : ''); ?>>50 baris</option>
            </select>
            <span style="color: #374151; font-size: 13px;">
                Menampilkan <?php echo e($riwayat->total()); ?> data
            </span>
        </div>

        <div style="display: flex; gap: 5px;">
            <?php if($riwayat->onFirstPage()): ?>
                <button style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: #F3F4F6; color: #9CA3AF; cursor: not-allowed;" disabled>
                    <i class="fas fa-angle-double-left"></i>
                </button>
            <?php else: ?>
                <a href="<?php echo e($riwayat->url(1)); ?>&<?php echo e(http_build_query(request()->except('page'))); ?>" 
                   style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; display: flex; align-items: center; justify-content: center; text-decoration: none;">
                    <i class="fas fa-angle-double-left"></i>
                </a>
            <?php endif; ?>

            <?php if($riwayat->onFirstPage()): ?>
                <button style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: #F3F4F6; color: #9CA3AF; cursor: not-allowed;" disabled>
                    <i class="fas fa-angle-left"></i>
                </button>
            <?php else: ?>
                <a href="<?php echo e($riwayat->previousPageUrl()); ?>&<?php echo e(http_build_query(request()->except('page'))); ?>" 
                   style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; display: flex; align-items: center; justify-content: center; text-decoration: none;">
                    <i class="fas fa-angle-left"></i>
                </a>
            <?php endif; ?>

            <button style="width: 35px; height: 35px; border-radius: 8px; background: #4D0B87; color: white; border: none; font-weight: 600; cursor: default;">
                <?php echo e($riwayat->currentPage()); ?>

            </button>

            <?php if($riwayat->hasMorePages()): ?>
                <a href="<?php echo e($riwayat->nextPageUrl()); ?>&<?php echo e(http_build_query(request()->except('page'))); ?>" 
                   style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; display: flex; align-items: center; justify-content: center; text-decoration: none;">
                    <i class="fas fa-angle-right"></i>
                </a>
            <?php else: ?>
                <button style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: #F3F4F6; color: #9CA3AF; cursor: not-allowed;" disabled>
                    <i class="fas fa-angle-right"></i>
                </button>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>

</div>

<script>
    // Live Search - Mencari di Kelas, Jenjang, dan Status
    const liveSearchInput = document.getElementById('liveSearchInput');
    const tableBody = document.getElementById('tableBody');
    
    liveSearchInput?.addEventListener('keyup', function() {
        const searchValue = this.value.toLowerCase();
        const rows = tableBody.querySelectorAll('tr');
        
        rows.forEach(row => {
            if (row.cells && row.cells.length >= 6) {
                const kelas = row.cells[2]?.innerText.toLowerCase() || '';
                const jenjang = row.cells[3]?.innerText.toLowerCase() || '';
                const status = row.cells[6]?.innerText.toLowerCase() || '';
                
                if (kelas.includes(searchValue) || 
                    jenjang.includes(searchValue) || 
                    status.includes(searchValue)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            }
        });
    });

    // Pagination Show Entries
    document.getElementById('perPageSelect')?.addEventListener('change', function() {
        let url = new URL(window.location.href);
        url.searchParams.set('perPage', this.value);
        url.searchParams.delete('page');
        window.location.href = url.toString();
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Privat-Bimbel\resources\views/dashboard/tentor/riwayat-presensi.blade.php ENDPATH**/ ?>