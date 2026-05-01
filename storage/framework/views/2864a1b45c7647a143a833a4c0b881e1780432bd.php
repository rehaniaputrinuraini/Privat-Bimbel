

<?php $__env->startSection('title', 'Transaksi Pengeluaran'); ?>

<?php $__env->startSection('content'); ?>
<div style="width: 100%;">

    
    <div style="margin-bottom: 25px;">
        <p style="color: #374151; font-size: 13px; margin: 0 0 4px 0;"><?php echo e(\Carbon\Carbon::now()->translatedFormat('F Y')); ?></p>
        <h1 style="font-size: 26px; font-weight: 700; color: #111827; margin: 0;">Transaksi Pengeluaran</h1>
        <p style="color: #374151; font-size: 14px; margin: 4px 0 0 0;">Kelola Pengeluaran Operasional (WiFi, Listrik, ATK, dll)</p>
    </div>

    
    <div style="display: flex; gap: 15px; margin-bottom: 20px; flex-wrap: wrap;">
        <div style="flex: 1; min-width: 200px; background: white; border-radius: 16px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.06);">
            <p style="color: #6B7280; font-size: 12px; margin: 0;">Total Pengeluaran Bulan Ini</p>
            <h3 style="color: #EF4444; font-size: 20px; margin: 5px 0 0;">Rp <?php echo e(number_format($totalBulanIni ?? 0, 0, ',', '.')); ?></h3>
        </div>
        <div style="flex: 1; min-width: 200px; background: white; border-radius: 16px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.06);">
            <p style="color: #6B7280; font-size: 12px; margin: 0;">Total Pengeluaran Keseluruhan</p>
            <h3 style="color: #4D0B87; font-size: 20px; margin: 5px 0 0;">Rp <?php echo e(number_format($totalKeseluruhan ?? 0, 0, ',', '.')); ?></h3>
        </div>
    </div>

    
    <div style="display: flex; justify-content: flex-end; margin-bottom: 15px;">
        <button onclick="bukaModalCreate()"
                style="background-color: #EF4444; color: white; border: none; padding: 12px 25px; border-radius: 12px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 10px; font-size: 14px; box-shadow: 0 4px 6px rgba(239,68,68,0.2); font-family: 'Poppins', sans-serif;">
            <i class="fas fa-plus"></i> Input Pengeluaran
        </button>
    </div>

    <?php if(session('success')): ?>
        <div style="background: #D1FAE5; color: #065F46; padding: 12px; border-radius: 10px; margin-bottom: 20px;"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    
    <div style="background: white; border-radius: 16px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.06); margin-bottom: 20px;">
        <div style="display: flex; gap: 12px; flex-wrap: wrap;">
            <div style="position: relative; flex: 2; min-width: 200px;">
                <i class="fas fa-search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #9CA3AF;"></i>
                <input type="text" id="searchPengeluaran" placeholder="Cari Keperluan..."
                       style="width: 100%; padding: 10px 15px 10px 45px; border-radius: 12px; border: 1px solid #E5E7EB; background: #F9FAFB; font-size: 14px; font-family: 'Poppins', sans-serif; outline: none;">
            </div>
            <select id="filterJenis"
                    style="flex: 1; min-width: 130px; padding: 10px 14px; border-radius: 12px; border: 1px solid #E5E7EB; background: #F9FAFB; font-size: 13px; font-family: 'Poppins', sans-serif; outline: none; cursor: pointer;">
                <option value="">Jenis</option>
                <option value="Tunai">Tunai</option>
                <option value="Transfer">Transfer</option>
            </select>
            <select id="filterBulan"
                    style="flex: 1; min-width: 110px; padding: 10px 14px; border-radius: 12px; border: 1px solid #E5E7EB; background: #F9FAFB; font-size: 13px; font-family: 'Poppins', sans-serif; outline: none; cursor: pointer;">
                <option value="">Bulan</option>
                <?php for($i=1; $i<=12; $i++): ?><option value="<?php echo e($i); ?>"><?php echo e(Carbon\Carbon::create()->month($i)->translatedFormat('F')); ?></option><?php endfor; ?>
            </select>
            <select id="filterTahun"
                    style="flex: 1; min-width: 100px; padding: 10px 14px; border-radius: 12px; border: 1px solid #E5E7EB; background: #F9FAFB; font-size: 13px; font-family: 'Poppins', sans-serif; outline: none; cursor: pointer;">
                <option value="">Tahun</option>
                <?php for($i=date('Y'); $i>=2020; $i--): ?><option value="<?php echo e($i); ?>"><?php echo e($i); ?></option><?php endfor; ?>
            </select>
        </div>
    </div>

    
    <div style="background: white; border-radius: 20px; overflow-x: auto; box-shadow: 0 4px 15px rgba(0,0,0,0.08);">
        <table style="width: 100%; border-collapse: collapse; font-size: 13px; white-space: nowrap; font-family: 'Poppins', sans-serif;">
            <thead><tr style="background: #F3E8FF;">
                <th style="padding: 15px; text-align: center; width: 40px;">No</th>
                <th style="padding: 15px; text-align: center;width: 100px;">Tanggal</th>
                <th style="padding: 15px; text-align: center; width: 200px;">Keperluan</th>
                <th style="padding: 15px; text-align: center; width: 80px;">Jenis</th>
                <th style="padding: 15px; text-align: right; width: 130px;">Jumlah</th>
                <th style="padding: 15px; text-align: center; width: 200px;">Keterangan</th>
            </tr></thead>
            <tbody id="tableBody">
                <?php $__empty_1 = true; $__currentLoopData = $pengeluaran; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr style="border-bottom: 1px solid #F3F4F6;">
                    <td style="padding: 15px; text-align: center;"><?php echo e($pengeluaran->firstItem() + $index); ?></td>
                    <td style="padding: 15px; text-align: center;"><?php echo e($item->tanggal); ?></td>
                    <td style="padding: 15px; text-align: center; max-width: 200px; overflow: hidden; text-overflow: ellipsis;"><?php echo e($item->keperluan); ?></td>
                    <td style="padding: 15px; text-align: center;"><?php echo e($item->jenis_pembayaran); ?></td>
                    <td style="padding: 15px; text-align: right; font-weight: 700; color: #EF4444;">Rp <?php echo e(number_format($item->jumlah, 0, ',', '.')); ?></td>
                    <td style="padding: 15px; text-align: center; max-width: 200px; overflow: hidden; text-overflow: ellipsis;"><?php echo e($item->keterangan); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="6" style="padding: 50px; text-align: center; color: #9CA3AF;">Belum ada data pengeluaran</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px; padding: 0 5px; margin-bottom: 40px;">
        <div style="display: flex; align-items: center; gap: 10px;">
            <select id="pageSelect"
                    style="padding: 8px 12px; border-radius: 10px; border: 1px solid #E5E7EB; color: #374151; font-size: 13px; background: white; outline: none; cursor: pointer; font-family: 'Poppins', sans-serif;">
                <option value="10" <?php echo e(request('per_page', 10) == 10 ? 'selected' : ''); ?>>10 baris</option>
                <option value="25" <?php echo e(request('per_page') == 25 ? 'selected' : ''); ?>>25 baris</option>
                <option value="50" <?php echo e(request('per_page') == 50 ? 'selected' : ''); ?>>50 baris</option>
            </select>
            <span style="color: #374151; font-size: 13px;">Menampilkan <?php echo e($pengeluaran->total() ?? 0); ?> data</span>
        </div>
        <div style="display: flex; gap: 5px;">
            <?php if($pengeluaran->onFirstPage()): ?>
                <button disabled style="width:35px;height:35px;border-radius:8px;border:1px solid #E5E7EB;background:#F3F4F6;color:#9CA3AF;cursor:not-allowed;"><i class="fas fa-angle-double-left"></i></button>
                <button disabled style="width:35px;height:35px;border-radius:8px;border:1px solid #E5E7EB;background:#F3F4F6;color:#9CA3AF;cursor:not-allowed;"><i class="fas fa-angle-left"></i></button>
            <?php else: ?>
                <a href="<?php echo e($pengeluaran->url(1)); ?>&per_page=<?php echo e(request('per_page', 10)); ?>" style="width:35px;height:35px;border-radius:8px;border:1px solid #E5E7EB;background:white;color:#374151;display:flex;align-items:center;justify-content:center;text-decoration:none;"><i class="fas fa-angle-double-left"></i></a>
                <a href="<?php echo e($pengeluaran->previousPageUrl()); ?>&per_page=<?php echo e(request('per_page', 10)); ?>" style="width:35px;height:35px;border-radius:8px;border:1px solid #E5E7EB;background:white;color:#374151;display:flex;align-items:center;justify-content:center;text-decoration:none;"><i class="fas fa-angle-left"></i></a>
            <?php endif; ?>

            <?php $start = max(1, $pengeluaran->currentPage() - 2); $end = min($pengeluaran->lastPage(), $pengeluaran->currentPage() + 2); ?>
            <?php for($i = $start; $i <= $end; $i++): ?>
                <?php if($i == $pengeluaran->currentPage()): ?>
                    <button style="width:35px;height:35px;border-radius:8px;background:#4D0B87;color:white;border:none;font-weight:600;font-family:'Poppins',sans-serif;"><?php echo e($i); ?></button>
                <?php else: ?>
                    <a href="<?php echo e($pengeluaran->url($i)); ?>&per_page=<?php echo e(request('per_page', 10)); ?>" style="width:35px;height:35px;border-radius:8px;border:1px solid #E5E7EB;background:white;color:#374151;display:flex;align-items:center;justify-content:center;text-decoration:none;"><?php echo e($i); ?></a>
                <?php endif; ?>
            <?php endfor; ?>

            <?php if($pengeluaran->hasMorePages()): ?>
                <a href="<?php echo e($pengeluaran->nextPageUrl()); ?>&per_page=<?php echo e(request('per_page', 10)); ?>" style="width:35px;height:35px;border-radius:8px;border:1px solid #E5E7EB;background:white;color:#374151;display:flex;align-items:center;justify-content:center;text-decoration:none;"><i class="fas fa-angle-right"></i></a>
            <?php else: ?>
                <button disabled style="width:35px;height:35px;border-radius:8px;border:1px solid #E5E7EB;background:#F3F4F6;color:#9CA3AF;cursor:not-allowed;"><i class="fas fa-angle-right"></i></button>
            <?php endif; ?>
        </div>
    </div>

</div>


<div id="modalForm"
     style="display: none; position: fixed; z-index: 9998; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); backdrop-filter: blur(3px); align-items: center; justify-content: center; overflow-y: auto; padding: 20px; box-sizing: border-box;">
    <div style="background: white; border-radius: 20px; width: 600px; max-width: 95%; max-height: 90vh; overflow-y: auto; box-shadow: 0 15px 30px rgba(0,0,0,0.15);" id="modalContent"></div>
</div>

<script>
    function bukaModalCreate() {
        fetch("<?php echo e(route($role . '.pengeluaran.create')); ?>").then(r => r.text()).then(html => {
            const cont = document.getElementById('modalContent');
            cont.innerHTML = html;
            document.getElementById('modalForm').style.display = 'flex';
            cont.querySelectorAll('script').forEach(oldScript => {
                const newScript = document.createElement('script');
                newScript.textContent = oldScript.textContent;
                document.body.appendChild(newScript);
                document.body.removeChild(newScript);
            });
        }).catch(() => alert('Gagal memuat form.'));
    }
    function tutupModalForm() { document.getElementById('modalForm').style.display = 'none'; document.getElementById('modalContent').innerHTML = ''; }
    document.getElementById('modalForm').addEventListener('click', function(e) { if (e.target === this) tutupModalForm(); });

    document.getElementById('pageSelect').addEventListener('change', function() {
        const url = new URL(window.location.href);
        url.searchParams.set('per_page', this.value);
        url.searchParams.delete('page');
        window.location.href = url.toString();
    });

    document.getElementById('searchPengeluaran')?.addEventListener('keyup', filterTable);
    document.getElementById('filterJenis')?.addEventListener('change', filterTable);
    document.getElementById('filterBulan')?.addEventListener('change', filterTable);
    document.getElementById('filterTahun')?.addEventListener('change', filterTable);
    function filterTable() {
        const s = (document.getElementById('searchPengeluaran')?.value || '').toLowerCase();
        const jenis = document.getElementById('filterJenis')?.value || '';
        const bulan = document.getElementById('filterBulan')?.value || '';
        const tahun = document.getElementById('filterTahun')?.value || '';
        document.querySelectorAll('#tableBody tr').forEach(row => {
            if (!row.cells || row.cells.length < 6) return;
            const keperluan = (row.cells[2]?.innerText || '').toLowerCase();
            const j = row.cells[3]?.innerText.trim() || '';
            const tgl = row.cells[1]?.innerText || '';
            const parts = tgl.split('/');
            const b = parts[1] ? parseInt(parts[1]) : 0;
            const t = parts[2] ? parseInt(parts[2]) : 0;
            let show = true;
            if (s && !keperluan.includes(s)) show = false;
            if (jenis && j !== jenis) show = false;
            if (bulan && b !== parseInt(bulan)) show = false;
            if (tahun && t !== parseInt(tahun)) show = false;
            row.style.display = show ? '' : 'none';
        });
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Privat-Bimbel\resources\views/dashboard/shared/transaksi/pengeluaran.blade.php ENDPATH**/ ?>