

<?php $__env->startSection('title', 'Laporan Keuangan'); ?>

<?php $__env->startSection('content'); ?>
<div style="width: 100%;">

    
    <div style="margin-bottom: 25px;">
        <p style="color: #374151; font-size: 13px; margin: 0 0 4px 0;"><?php echo e(\Carbon\Carbon::now()->translatedFormat('F Y')); ?></p>
        <h1 style="font-size: 26px; font-weight: 700; color: #111827; margin: 0;">Laporan Keuangan</h1>
        <p style="color: #374151; font-size: 14px; margin: 4px 0 0 0;">Rekap Semua Transaksi Keuangan</p>
    </div>

    
    <div style="display: flex; gap: 15px; margin-bottom: 20px; flex-wrap: wrap;">
        <div style="flex: 1; min-width: 200px; background: white; border-radius: 16px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.06);">
            <p style="color: #6B7280; font-size: 12px; margin: 0;">Total Pemasukan</p>
            <h3 style="color: #10B981; font-size: 22px; margin: 5px 0 0;">Rp <?php echo e(number_format($totalPemasukan ?? 0, 0, ',', '.')); ?></h3>
        </div>
        <div style="flex: 1; min-width: 200px; background: white; border-radius: 16px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.06);">
            <p style="color: #6B7280; font-size: 12px; margin: 0;">Total Pengeluaran</p>
            <h3 style="color: #EF4444; font-size: 22px; margin: 5px 0 0;">Rp <?php echo e(number_format($totalPengeluaran ?? 0, 0, ',', '.')); ?></h3>
        </div>
        <div style="flex: 1; min-width: 200px; background: white; border-radius: 16px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.06);">
            <p style="color: #6B7280; font-size: 12px; margin: 0;">Saldo</p>
            <h3 style="color: <?php echo e(($totalPemasukan - $totalPengeluaran) >= 0 ? '#4D0B87' : '#EF4444'); ?>; font-size: 22px; margin: 5px 0 0;">
                Rp <?php echo e(number_format(($totalPemasukan ?? 0) - ($totalPengeluaran ?? 0), 0, ',', '.')); ?>

            </h3>
        </div>
    </div>

    
    <div style="background: white; border-radius: 16px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.06); margin-bottom: 20px;">
        <div style="display: flex; gap: 12px; flex-wrap: wrap; align-items: center;">
            <div style="position: relative; flex: 2; min-width: 200px;">
                <i class="fas fa-search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #9CA3AF;"></i>
                <input type="text" id="searchLaporan" placeholder="Cari Keterangan..."
                       style="width: 100%; padding: 10px 15px 10px 45px; border-radius: 12px; border: 1px solid #E5E7EB; background: #F9FAFB; font-size: 14px; font-family: 'Poppins', sans-serif; outline: none;">
            </div>
            <select id="filterKategori" onchange="filterLaporan()"
                    style="flex: 1; min-width: 150px; padding: 10px 14px; border-radius: 12px; border: 1px solid #E5E7EB; background: #F9FAFB; font-size: 13px; font-family: 'Poppins', sans-serif; outline: none; cursor: pointer;">
                <option value="">Semua Kategori</option>
                <option value="Pembayaran Murid" <?php echo e(request('kategori') == 'Pembayaran Murid' ? 'selected' : ''); ?>>Pembayaran Murid</option>
                <option value="Pemasukan Lainnya" <?php echo e(request('kategori') == 'Pemasukan Lainnya' ? 'selected' : ''); ?>>Pemasukan Lainnya</option>
                <option value="Pengeluaran" <?php echo e(request('kategori') == 'Pengeluaran' ? 'selected' : ''); ?>>Pengeluaran</option>
                <option value="Penggajian" <?php echo e(request('kategori') == 'Penggajian' ? 'selected' : ''); ?>>Penggajian</option>
            </select>
            <select id="filterBulan" onchange="filterLaporan()"
                    style="flex: 1; min-width: 120px; padding: 10px 14px; border-radius: 12px; border: 1px solid #E5E7EB; background: #F9FAFB; font-size: 13px; font-family: 'Poppins', sans-serif; outline: none; cursor: pointer;">
                <?php
                    $bulanTersedia = App\Models\TransaksiUmum::selectRaw('DISTINCT MONTH(tanggal_bayar) as bulan')->whereNotNull('tanggal_bayar')->orderBy('bulan')->pluck('bulan');
                    $bulanSekarang = date('n');
                    $requestBulan = request('bulan');
                ?>
                <?php $__currentLoopData = $bulanTersedia; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $selected = false;
                        if ($requestBulan) {
                            $selected = ($requestBulan == $b);
                        } else {
                            $selected = ($bulanSekarang == $b);
                        }
                    ?>
                    <option value="<?php echo e($b); ?>" <?php echo e($selected ? 'selected' : ''); ?>><?php echo e(Carbon\Carbon::create()->month($b)->translatedFormat('F')); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <select id="filterTahun" onchange="filterLaporan()"
                    style="flex: 1; min-width: 100px; padding: 10px 14px; border-radius: 12px; border: 1px solid #E5E7EB; background: #F9FAFB; font-size: 13px; font-family: 'Poppins', sans-serif; outline: none; cursor: pointer;">
                <?php
                    $tahunTersedia = App\Models\TransaksiUmum::selectRaw('DISTINCT YEAR(tanggal_bayar) as tahun')->whereNotNull('tanggal_bayar')->orderBy('tahun', 'desc')->pluck('tahun');
                    $tahunSekarang = date('Y');
                    $requestTahun = request('tahun');
                ?>
                <?php $__currentLoopData = $tahunTersedia; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $selected = false;
                        if ($requestTahun) {
                            $selected = ($requestTahun == $t);
                        } else {
                            $selected = ($tahunSekarang == $t);
                        }
                    ?>
                    <option value="<?php echo e($t); ?>" <?php echo e($selected ? 'selected' : ''); ?>><?php echo e($t); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            
            
            <button onclick="exportToPDF()" 
                    style="background: #4D0B87; color: white; border: none; padding: 10px 20px; border-radius: 12px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 8px; font-size: 13px; transition: 0.3s; box-shadow: 0 2px 5px rgba(239, 68, 68, 0.2);">
                <i class="fas fa-file-pdf"></i> Export PDF
            </button>
        </div>
    </div>

    
    <div style="background: white; border-radius: 20px; overflow-x: auto; box-shadow: 0 4px 15px rgba(0,0,0,0.08);">
        <table style="width: 100%; border-collapse: collapse; font-size: 13px; white-space: nowrap; font-family: 'Poppins', sans-serif;">
            <thead>
                <tr style="background: #F3E8FF;">
                    <th style="padding: 15px; text-align: center; width: 40px;">No</th>
                    <th style="padding: 15px; width: 100px;">Tanggal</th>
                    <th style="padding: 15px; width: 140px;">Kategori</th>
                    <th style="padding: 15px; min-width: 200px;">Keterangan</th>
                    <th style="padding: 15px; text-align: right; width: 150px;">Pemasukan</th>
                    <th style="padding: 15px; text-align: right; width: 150px;">Pengeluaran</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                <?php $__empty_1 = true; $__currentLoopData = $laporan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr style="border-bottom: 1px solid #F3F4F6;">
                    <td style="padding: 15px; text-align: center;"><?php echo e($laporan->firstItem() + $index); ?></td>
                    <td style="padding: 15px;"><?php echo e($item->tanggal); ?></td>
                    <td style="padding: 15px;">
                        <?php
                            $badgeColors = [
                                'Pembayaran Murid' => ['bg' => '#E0E7FF', 'color' => '#1E40AF'],
                                'Pemasukan Lainnya' => ['bg' => '#D1FAE5', 'color' => '#065F46'],
                                'Pengeluaran' => ['bg' => '#FEE2E2', 'color' => '#991B1B'],
                                'Penggajian' => ['bg' => '#FEF3C7', 'color' => '#92400E'],
                            ];
                            $badge = $badgeColors[$item->kategori] ?? ['bg' => '#F3F4F6', 'color' => '#6B7280'];
                        ?>
                        <span style="background:<?php echo e($badge['bg']); ?>;color:<?php echo e($badge['color']); ?>;padding:4px 10px;border-radius:20px;font-size:11px;white-space:nowrap;"><?php echo e($item->kategori); ?></span>
                    </td>
                    <td style="padding: 15px; max-width: 250px; overflow: hidden; text-overflow: ellipsis;"><?php echo e($item->keterangan); ?></td>
                    <td style="padding: 15px; text-align: right; <?php echo e($item->pemasukan > 0 ? 'font-weight:700;color:#10B981;' : 'color:#9CA3AF;'); ?>">
                        <?php echo e($item->pemasukan > 0 ? 'Rp '.number_format($item->pemasukan, 0, ',', '.') : '-'); ?>

                    </td>
                    <td style="padding: 15px; text-align: right; <?php echo e($item->pengeluaran > 0 ? 'font-weight:700;color:#EF4444;' : 'color:#9CA3AF;'); ?>">
                        <?php echo e($item->pengeluaran > 0 ? 'Rp '.number_format($item->pengeluaran, 0, ',', '.') : '-'); ?>

                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="6" style="padding: 50px; text-align: center; color: #9CA3AF;">Belum ada data laporan</td>
                </tr>
                <?php endif; ?>
            </tbody>
            <tfoot>
                <tr style="background: #F3E8FF; font-weight: 700;">
                    <td colspan="4" style="padding: 15px; text-align: right;">TOTAL</td>
                    <td style="padding: 15px; text-align: right; color: #10B981;">Rp <?php echo e(number_format($totalPemasukan ?? 0, 0, ',', '.')); ?></td>
                    <td style="padding: 15px; text-align: right; color: #EF4444;">Rp <?php echo e(number_format($totalPengeluaran ?? 0, 0, ',', '.')); ?></td>
                </tr>
            </tfoot>
        </table>
    </div>

    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px; padding: 0 5px; margin-bottom: 40px;">
        <div style="display: flex; align-items: center; gap: 10px;">
            <select id="pageSelect" onchange="changePage(this.value)"
                    style="padding: 8px 12px; border-radius: 10px; border: 1px solid #E5E7EB; color: #374151; font-size: 13px; background: white; outline: none; cursor: pointer; font-family: 'Poppins', sans-serif;">
                <option value="10" <?php echo e(request('per_page', 10) == 10 ? 'selected' : ''); ?>>10 baris</option>
                <option value="25" <?php echo e(request('per_page') == 25 ? 'selected' : ''); ?>>25 baris</option>
                <option value="50" <?php echo e(request('per_page') == 50 ? 'selected' : ''); ?>>50 baris</option>
            </select>
            <span style="color: #374151; font-size: 13px;">Menampilkan <?php echo e($laporan->total() ?? 0); ?> data</span>
        </div>
        <div style="display: flex; gap: 5px;">
            <?php if($laporan->onFirstPage()): ?>
                <button disabled style="width:35px;height:35px;border-radius:8px;border:1px solid #E5E7EB;background:#F3F4F6;color:#9CA3AF;cursor:not-allowed;"><i class="fas fa-angle-double-left"></i></button>
                <button disabled style="width:35px;height:35px;border-radius:8px;border:1px solid #E5E7EB;background:#F3F4F6;color:#9CA3AF;cursor:not-allowed;"><i class="fas fa-angle-left"></i></button>
            <?php else: ?>
                <a href="<?php echo e($laporan->url(1)); ?>&per_page=<?php echo e(request('per_page', 10)); ?>" style="width:35px;height:35px;border-radius:8px;border:1px solid #E5E7EB;background:white;color:#374151;display:flex;align-items:center;justify-content:center;text-decoration:none;"><i class="fas fa-angle-double-left"></i></a>
                <a href="<?php echo e($laporan->previousPageUrl()); ?>&per_page=<?php echo e(request('per_page', 10)); ?>" style="width:35px;height:35px;border-radius:8px;border:1px solid #E5E7EB;background:white;color:#374151;display:flex;align-items:center;justify-content:center;text-decoration:none;"><i class="fas fa-angle-left"></i></a>
            <?php endif; ?>

            <?php $start = max(1, $laporan->currentPage() - 2); $end = min($laporan->lastPage(), $laporan->currentPage() + 2); ?>
            <?php for($i = $start; $i <= $end; $i++): ?>
                <?php if($i == $laporan->currentPage()): ?>
                    <button style="width:35px;height:35px;border-radius:8px;background:#4D0B87;color:white;border:none;font-weight:600;cursor:pointer;"><?php echo e($i); ?></button>
                <?php else: ?>
                    <a href="<?php echo e($laporan->url($i)); ?>&per_page=<?php echo e(request('per_page', 10)); ?>" style="width:35px;height:35px;border-radius:8px;border:1px solid #E5E7EB;background:white;color:#374151;display:flex;align-items:center;justify-content:center;text-decoration:none;"><?php echo e($i); ?></a>
                <?php endif; ?>
            <?php endfor; ?>

            <?php if($laporan->hasMorePages()): ?>
                <a href="<?php echo e($laporan->nextPageUrl()); ?>&per_page=<?php echo e(request('per_page', 10)); ?>" style="width:35px;height:35px;border-radius:8px;border:1px solid #E5E7EB;background:white;color:#374151;display:flex;align-items:center;justify-content:center;text-decoration:none;"><i class="fas fa-angle-right"></i></a>
            <?php else: ?>
                <button disabled style="width:35px;height:35px;border-radius:8px;border:1px solid #E5E7EB;background:#F3F4F6;color:#9CA3AF;cursor:not-allowed;"><i class="fas fa-angle-right"></i></button>
            <?php endif; ?>
        </div>
    </div>

</div>

<script>
    function filterLaporan() {
        const kategori = document.getElementById('filterKategori').value;
        const bulan = document.getElementById('filterBulan').value;
        const tahun = document.getElementById('filterTahun').value;
        let url = new URL(window.location.href);
        if (kategori) url.searchParams.set('kategori', kategori); else url.searchParams.delete('kategori');
        if (bulan) url.searchParams.set('bulan', bulan); else url.searchParams.delete('bulan');
        if (tahun) url.searchParams.set('tahun', tahun); else url.searchParams.delete('tahun');
        url.searchParams.delete('page');
        window.location.href = url.toString();
    }

    function changePage(perPage) {
        const url = new URL(window.location.href);
        url.searchParams.set('per_page', perPage);
        url.searchParams.delete('page');
        window.location.href = url.toString();
    }

    document.getElementById('searchLaporan')?.addEventListener('keyup', function() {
        const s = this.value.toLowerCase();
        document.querySelectorAll('#tableBody tr').forEach(row => {
            if (!row.cells || row.cells.length < 6) return;
            const ket = row.cells[3]?.innerText.toLowerCase() || '';
            row.style.display = ket.includes(s) ? '' : 'none';
        });
    });

    function exportToPDF() {
        const kategori = document.getElementById('filterKategori').value;
        const bulan = document.getElementById('filterBulan').value;
        const tahun = document.getElementById('filterTahun').value;
        
        let url = "<?php echo e(route($role . '.laporan-keuangan.export-pdf')); ?>";
        let params = [];
        if (kategori) params.push(`kategori=${encodeURIComponent(kategori)}`);
        if (bulan) params.push(`bulan=${bulan}`);
        if (tahun) params.push(`tahun=${tahun}`);
        
        if (params.length > 0) {
            url += '?' + params.join('&');
        }
        
        window.open(url, '_blank');
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Privat-Bimbel\resources\views/dashboard/shared/laporan-keuangan/laporan-keuangan.blade.php ENDPATH**/ ?>