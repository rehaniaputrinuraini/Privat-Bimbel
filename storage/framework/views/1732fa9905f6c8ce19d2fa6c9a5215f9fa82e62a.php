

<?php $__env->startSection('title', 'Data Tentor'); ?>

<?php $__env->startSection('content'); ?>
<div style="width: 100%;">
    
    
    <div style="margin-bottom: 25px;">
        <p style="color: #374151; font-size: 13px; margin: 0 0 4px 0;">
            <?php echo e(\Carbon\Carbon::now()->translatedFormat('F Y')); ?>

        </p>
        <h1 style="font-size: 26px; font-weight: 700; color: #111827; margin: 0; letter-spacing: -0.5px; line-height: 1.2;">
            Data Tentor
        </h1>
        <p style="color: #374151; font-size: 14px; margin: 4px 0 0 0;">Manajemen Data dan Honorarium Tentor Bimbel Privat</p>
    </div>

    
    <?php if(session('success')): ?>
        <div style="background: #D1FAE5; color: #065F46; padding: 12px; border-radius: 10px; margin-bottom: 20px;">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; gap: 15px;">
        <div style="display: flex; align-items: center; gap: 12px; flex: 1;">
            <div style="position: relative; width: 300px;">
                <i class="fas fa-search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #9CA3AF;"></i>
                <input type="text" id="searchInput" placeholder="Cari Nama atau ID Tentor..." 
                       style="width: 100%; padding: 10px 15px 10px 45px; border-radius: 12px; border: 1px solid #E5E7EB; outline: none; background: white; font-size: 14px; color: #374151;">
            </div>
        </div>
    </div>

    
    <div style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.08); border: 1px solid #F3F4F6;">
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 13px; white-space: nowrap;">
                <thead>
                    <tr style="background: #F3E8FF; color: #111827;">
                        <th style="padding: 15px; font-weight: 700; width: 50px; text-align: center;">No</th>
                        <th style="padding: 15px; font-weight: 700;">ID</th>
                        <th style="padding: 15px; font-weight: 700;">Nama Lengkap</th>
                        <th style="padding: 15px; font-weight: 700;">Alamat</th>
                        <th style="padding: 15px; font-weight: 700;">No HP</th>
                        <th style="padding: 15px; font-weight: 700;">Mapel</th>
                        <th style="padding: 15px; font-weight: 700; text-align: center;">Grade</th>
                        <th style="padding: 15px; font-weight: 700;">HR SD</th>
                        <th style="padding: 15px; font-weight: 700;">HR SMP</th>
                        <th style="padding: 15px; font-weight: 700;">HR SMA</th>
                        <th style="padding: 15px; font-weight: 700;">Uang Makan</th>
                        <th style="padding: 15px; font-weight: 700;">Transport</th>
                    </tr>
                </thead>
                <tbody id="tableBody" style="color: #374151;">
                    <?php $__empty_1 = true; $__currentLoopData = $tentors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr style="border-bottom: 1px solid #F3F4F6; transition: 0.2s;" onmouseover="this.style.background='#F9FAFB'" onmouseout="this.style.background='transparent'">
                        <td style="padding: 15px; text-align: center;"><?php echo e($tentors->firstItem() + $index); ?></td>
                        <td style="padding: 15px;">TE<?php echo e(str_pad($t->id_tentor, 4, '0', STR_PAD_LEFT)); ?></td>
                        <td style="padding: 15px;"><?php echo e($t->nama_lengkap_tentor); ?></td>
                        <td style="padding: 15px;"><?php echo e($t->alamat_tentor ?? '-'); ?></td>
                        <td style="padding: 15px;"><?php echo e($t->no_hp_tentor ?? '-'); ?></td>
                        <td style="padding: 15px;"><?php echo e($t->mapel ?? '-'); ?></td>
                        <td style="padding: 15px; text-align: center;"><?php echo e($t->grade ?? '-'); ?></td>
                        <td style="padding: 15px;">Rp <?php echo e(number_format($t->hr_sd ?? 0, 0, ',', '.')); ?></td>
                        <td style="padding: 15px;">Rp <?php echo e(number_format($t->hr_smp ?? 0, 0, ',', '.')); ?></td>
                        <td style="padding: 15px;">Rp <?php echo e(number_format($t->hr_sma ?? 0, 0, ',', '.')); ?></td>
                        <td style="padding: 15px;">Rp <?php echo e(number_format($t->uang_makan ?? 0, 0, ',', '.')); ?></td>
                        <td style="padding: 15px;">Rp <?php echo e(number_format($t->uang_transport ?? 0, 0, ',', '.')); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="12" style="padding: 40px; text-align: center; color: #9CA3AF;">
                            <i class="fas fa-database" style="font-size: 40px; margin-bottom: 10px; display: block;"></i>
                            Belum ada data tentor.
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px; padding: 0 5px;">
        <div style="display: flex; align-items: center; gap: 10px;">
            <select id="pageSelect" style="padding: 8px 12px; border-radius: 10px; border: 1px solid #E5E7EB; color: #374151; font-size: 13px; background: white; outline: none; cursor: pointer;">
                <option value="10">10 baris</option>
                <option value="25">25 baris</option>
                <option value="50">50 baris</option>
            </select>
            <span style="color: #374151; font-size: 13px;">Menampilkan <?php echo e($tentors->total()); ?> data</span>
        </div>

        <div class="pagination-container" style="display: flex; gap: 5px;">
            <?php echo e($tentors->appends(request()->query())->links()); ?>

        </div>
    </div>

</div>

<script>
    // Live search (berdasarkan NAMA)
    document.getElementById('searchInput').addEventListener('keyup', function() {
        let searchValue = this.value.toLowerCase();
        let rows = document.querySelectorAll('#tableBody tr');
        
        rows.forEach(row => {
            if(row.cells && row.cells.length >= 3) {
                let nama = row.cells[2]?.innerText.toLowerCase() || '';
                if(nama.includes(searchValue)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            }
        });
    });

    // Page Select (show entries)
    document.getElementById('pageSelect').addEventListener('change', function() {
        let perPage = this.value;
        let url = new URL(window.location.href);
        url.searchParams.set('per_page', perPage);
        window.location.href = url.toString();
    });

    // Set selected value on page load
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const perPage = urlParams.get('per_page');
        if (perPage && document.getElementById('pageSelect')) {
            document.getElementById('pageSelect').value = perPage;
        }
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\privat-bimbel\resources\views/dashboard/admin/data-tentor/data-tentor.blade.php ENDPATH**/ ?>