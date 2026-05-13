

<?php $__env->startSection('title', 'Pembayaran Murid'); ?>

<?php $__env->startSection('content'); ?>
<div style="width: 100%;">

    
    <div style="margin-bottom: 25px;">
        <p style="color: #374151; font-size: 13px; margin: 0 0 4px 0;"><?php echo e(\Carbon\Carbon::now()->translatedFormat('F Y')); ?></p>
        <h1 style="font-size: 26px; font-weight: 700; color: #111827; margin: 0;">Pembayaran Murid</h1>
        <p style="color: #374151; font-size: 14px; margin: 4px 0 0 0;">Kelola Pembayaran Murid</p>
    </div>

    
    <div style="display: flex; gap: 15px; margin-bottom: 20px; flex-wrap: wrap;">
        <div style="flex: 1; min-width: 150px; background: white; border-radius: 16px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.06);">
            <p style="color: #6B7280; font-size: 12px; margin: 0;">Total Bulan Ini</p>
            <h3 style="color: #10B981; font-size: 20px; margin: 5px 0 0;">Rp <?php echo e(number_format($totalBulanIni ?? 0, 0, ',', '.')); ?></h3>
        </div>
        <div style="flex: 1; min-width: 150px; background: white; border-radius: 16px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.06);">
            <p style="color: #6B7280; font-size: 12px; margin: 0;">Total Keseluruhan</p>
            <h3 style="color: #4D0B87; font-size: 20px; margin: 5px 0 0;">Rp <?php echo e(number_format($totalKeseluruhan ?? 0, 0, ',', '.')); ?></h3>
        </div>
        <div style="flex: 1; min-width: 150px; background: white; border-radius: 16px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.06);">
            <p style="color: #6B7280; font-size: 12px; margin: 0;">Dari Murid</p>
            <h3 style="color: #3B82F6; font-size: 20px; margin: 5px 0 0;">Rp <?php echo e(number_format($totalMurid ?? 0, 0, ',', '.')); ?></h3>
        </div>
        <div style="flex: 1; min-width: 150px; background: white; border-radius: 16px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.06);">
            <p style="color: #6B7280; font-size: 12px; margin: 0;">Dari Lainnya</p>
            <h3 style="color: #F59E0B; font-size: 20px; margin: 5px 0 0;">Rp <?php echo e(number_format($totalLainnya ?? 0, 0, ',', '.')); ?></h3>
        </div>
    </div>

    
    <div style="display: flex; justify-content: flex-end; margin-bottom: 15px;">
        <button onclick="bukaModalCreate()"
                style="background-color: #4D0B87; color: white; border: none; padding: 12px 25px; border-radius: 12px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 10px; font-size: 14px; box-shadow: 0 4px 6px rgba(77,11,135,0.2); font-family: 'Poppins', sans-serif;">
            <i class="fas fa-plus"></i> Input Pembayaran Murid
        </button>
    </div>

    <?php if(session('success')): ?>
        <div style="background: #D1FAE5; color: #065F46; padding: 12px; border-radius: 10px; margin-bottom: 20px;">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    
    <div style="background: white; border-radius: 16px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.06); margin-bottom: 20px;">
        <div style="position: relative; margin-bottom: 12px;">
            <i class="fas fa-search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #9CA3AF;"></i>
            <input type="text" id="searchTagihan" placeholder="Cari Nama Murid..."
                   style="width: 100%; padding: 12px 15px 12px 45px; border-radius: 12px; border: 1px solid #E5E7EB; background: #F9FAFB; font-size: 14px; font-family: 'Poppins', sans-serif; box-sizing: border-box; outline: none;">
        </div>
        <div style="display: flex; gap: 12px; flex-wrap: wrap;">
            <select id="filterPaket"
                    style="flex: 1; padding: 10px 14px; border-radius: 12px; border: 1px solid #E5E7EB; background: #F9FAFB; font-size: 13px; font-family: 'Poppins', sans-serif; outline: none; cursor: pointer;">
                <option value="">Semua Paket</option>
                <?php $__currentLoopData = $paketList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($paket->tingkat); ?>"><?php echo e($paket->tingkat); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <select id="filterTagihan"
                    style="flex: 1; padding: 10px 14px; border-radius: 12px; border: 1px solid #E5E7EB; background: #F9FAFB; font-size: 13px; font-family: 'Poppins', sans-serif; outline: none; cursor: pointer;">
                <option value="">Semua Tagihan</option>
                <option value="Tidak Ada">Tidak Ada Tagihan</option>
                <option value="Ada">Ada Tagihan</option>
            </select>
            <select id="filterPeriode"
                    style="flex: 1; padding: 10px 14px; border-radius: 12px; border: 1px solid #E5E7EB; background: #F9FAFB; font-size: 13px; font-family: 'Poppins', sans-serif; outline: none; cursor: pointer;">
                <option value="">Semua Periode</option>
                <?php $__currentLoopData = $periodeList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $periode): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($periode->tahun_periode); ?>" <?php echo e(($periodeAktif && $periodeAktif->tahun_periode == $periode->tahun_periode) ? 'selected' : ''); ?>><?php echo e($periode->tahun_periode); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
    </div>

    
    <div style="background: white; border-radius: 20px; overflow-x: auto; box-shadow: 0 4px 15px rgba(0,0,0,0.08); margin-bottom: 25px;">
        <table style="width: 100%; border-collapse: collapse; font-size: 13px; white-space: nowrap; font-family: 'Poppins', sans-serif;">
            <thead>
                <tr style="background: #F3E8FF;">
                    <th style="padding: 15px; text-align: left;">No</th>
                    <th style="padding: 15px; text-align: left;">Nama Murid</th>
                    <th style="padding: 15px; text-align: left;">Kelas</th>
                    <th style="padding: 15px; text-align: left;">Status Paket</th>
                    <th style="padding: 15px; text-align: center;">Pendaftaran</th>
                    <th style="padding: 15px; text-align: center;">Tagihan</th>
                    <th style="padding: 15px; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody id="tagihanTableBody">
                <?php $__empty_1 = true; $__currentLoopData = $tagihan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr style="border-bottom: 1px solid #F3F4F6;" data-periode="<?php echo e($t->periode ?? ''); ?>" data-status-tagihan="<?php echo e($t->status_tagihan); ?>">
                    <td style="padding: 15px;"><?php echo e($tagihan->firstItem() + $index); ?></td>
                    <td style="padding: 15px; font-weight: 500;"><?php echo e($t->nama_murid); ?></td>
                    <td style="padding: 15px;"><?php echo e($t->kelas ?? '-'); ?></td>
                    <td style="padding: 15px;"><?php echo e($t->paket ?? '-'); ?></td>
                    <td style="padding: 15px; text-align: center;">
                        <?php if($t->status_pendaftaran == 'Lunas'): ?>
                            <span style="padding:5px 12px;border-radius:20px;background:#D1FAE5;color:#065F46;font-size:12px;font-weight:600;">Lunas</span>
                        <?php else: ?>
                            <span style="padding:5px 12px;border-radius:20px;background:#FEE2E2;color:#EF4444;font-size:12px;font-weight:600;">Belum</span>
                        <?php endif; ?>
                    </td>
                    <td style="padding: 15px; text-align: center;">
                        <?php if($t->status_tagihan == 'Lunas' || $t->status_tagihan == 'Uang Muka'): ?>
                            <span style="padding:5px 12px;border-radius:20px;background:#D1FAE5;color:#065F46;font-size:12px;font-weight:600;">Tidak Ada</span>
                        <?php else: ?>
                            <span style="padding:5px 12px;border-radius:20px;background:#FEE2E2;color:#EF4444;font-size:12px;font-weight:600;">Ada</span>
                        <?php endif; ?>
                    </td>
                    <td style="padding: 15px; text-align: center;">
                        <button onclick="bukaDetailPembayaran(<?php echo e($t->id_murid); ?>)"
                                style="background: #4D0B87; color: white; border: none; padding: 8px 16px; border-radius: 8px; cursor: pointer; font-size: 12px; font-weight: 600; font-family: 'Poppins', sans-serif;">
                            <i class="fas fa-eye"></i> Detail
                        </button>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="7" style="padding: 50px; text-align: center; color: #9CA3AF; font-size: 14px;">
                        <i class="fas fa-inbox" style="font-size: 32px; margin-bottom: 10px; display: block; opacity: .4;"></i>
                        Belum ada data pembayaran murid
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 10px; padding: 0 5px; margin-bottom: 40px;">
        <div style="display: flex; align-items: center; gap: 10px;">
            <select id="pageSelect"
                    style="padding: 8px 12px; border-radius: 10px; border: 1px solid #E5E7EB; color: #374151; font-size: 13px; background: white; outline: none; cursor: pointer; font-family: 'Poppins', sans-serif;">
                <option value="10"  <?php echo e(request('per_page', 10) == 10  ? 'selected' : ''); ?>>10 baris</option>
                <option value="25"  <?php echo e(request('per_page') == 25  ? 'selected' : ''); ?>>25 baris</option>
                <option value="50"  <?php echo e(request('per_page') == 50  ? 'selected' : ''); ?>>50 baris</option>
            </select>
            <span style="color: #374151; font-size: 13px;">Menampilkan <?php echo e($tagihan->total() ?? 0); ?> data</span>
        </div>
        <div style="display: flex; gap: 5px;">
            <?php if($tagihan->onFirstPage()): ?>
                <button disabled style="width:35px;height:35px;border-radius:8px;border:1px solid #E5E7EB;background:#F3F4F6;color:#9CA3AF;cursor:not-allowed;"><i class="fas fa-angle-double-left"></i></button>
                <button disabled style="width:35px;height:35px;border-radius:8px;border:1px solid #E5E7EB;background:#F3F4F6;color:#9CA3AF;cursor:not-allowed;"><i class="fas fa-angle-left"></i></button>
            <?php else: ?>
                <a href="<?php echo e($tagihan->url(1)); ?>&per_page=<?php echo e(request('per_page', 10)); ?>"
                   style="width:35px;height:35px;border-radius:8px;border:1px solid #E5E7EB;background:white;color:#374151;display:flex;align-items:center;justify-content:center;text-decoration:none;">
                    <i class="fas fa-angle-double-left"></i>
                </a>
                <a href="<?php echo e($tagihan->previousPageUrl()); ?>&per_page=<?php echo e(request('per_page', 10)); ?>"
                   style="width:35px;height:35px;border-radius:8px;border:1px solid #E5E7EB;background:white;color:#374151;display:flex;align-items:center;justify-content:center;text-decoration:none;">
                    <i class="fas fa-angle-left"></i>
                </a>
            <?php endif; ?>

            <?php $start = max(1, $tagihan->currentPage() - 2); $end = min($tagihan->lastPage(), $tagihan->currentPage() + 2); ?>
            <?php for($i = $start; $i <= $end; $i++): ?>
                <?php if($i == $tagihan->currentPage()): ?>
                    <button style="width:35px;height:35px;border-radius:8px;background:#4D0B87;color:white;border:none;font-weight:600;font-family:'Poppins',sans-serif;"><?php echo e($i); ?></button>
                <?php else: ?>
                    <a href="<?php echo e($tagihan->url($i)); ?>&per_page=<?php echo e(request('per_page', 10)); ?>"
                       style="width:35px;height:35px;border-radius:8px;border:1px solid #E5E7EB;background:white;color:#374151;display:flex;align-items:center;justify-content:center;text-decoration:none;">
                        <?php echo e($i); ?>

                    </a>
                <?php endif; ?>
            <?php endfor; ?>

            <?php if($tagihan->hasMorePages()): ?>
                <a href="<?php echo e($tagihan->nextPageUrl()); ?>&per_page=<?php echo e(request('per_page', 10)); ?>"
                   style="width:35px;height:35px;border-radius:8px;border:1px solid #E5E7EB;background:white;color:#374151;display:flex;align-items:center;justify-content:center;text-decoration:none;">
                    <i class="fas fa-angle-right"></i>
                </a>
            <?php else: ?>
                <button disabled style="width:35px;height:35px;border-radius:8px;border:1px solid #E5E7EB;background:#F3F4F6;color:#9CA3AF;cursor:not-allowed;"><i class="fas fa-angle-right"></i></button>
            <?php endif; ?>
        </div>
    </div>

</div>


<div id="modalForm"
     style="display: none; position: fixed; z-index: 9998; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); backdrop-filter: blur(3px); align-items: center; justify-content: center; overflow-y: auto; padding: 20px; box-sizing: border-box;">
    <div style="background: white; border-radius: 20px; width: 750px; max-width: 95%; max-height: 90vh; overflow-y: auto; box-shadow: 0 15px 30px rgba(0,0,0,0.15);" id="modalContent"></div>
</div>


<div id="modalDetail"
     style="display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); backdrop-filter: blur(3px); align-items: center; justify-content: center; overflow-y: auto; padding: 20px; box-sizing: border-box;">
    <div style="background: white; border-radius: 20px; width: 700px; max-width: 95%; max-height: 90vh; overflow-y: auto; box-shadow: 0 15px 30px rgba(0,0,0,0.15);" id="modalDetailContent"></div>
</div>

<script>
    /* ================================================================
       BUKA MODAL CREATE
    ================================================================ */
    function bukaModalCreate() {
        fetch("<?php echo e(route($role . '.pembayaran.create')); ?>")
            .then(r => r.text())
            .then(html => {
                const cont = document.getElementById('modalContent');
                cont.innerHTML = html;
                document.getElementById('modalForm').style.display = 'flex';
                cont.querySelectorAll('script').forEach(oldScript => {
                    const newScript = document.createElement('script');
                    newScript.textContent = oldScript.textContent;
                    document.body.appendChild(newScript);
                    document.body.removeChild(newScript);
                });
            })
            .catch(() => alert('Gagal memuat form. Coba lagi.'));
    }

    function tutupModalForm() {
        document.getElementById('modalForm').style.display = 'none';
        document.getElementById('modalContent').innerHTML = '';
    }

    /* ================================================================
    BUKA MODAL DETAIL PEMBAYARAN MURID
    =============================================================== */
    function bukaDetailPembayaran(idMurid) {
        const baseUrl = "<?php echo e(url($role . '/pembayaran/detail')); ?>/" + idMurid;
        
        fetch(baseUrl)
            .then(r => r.text())
            .then(html => {
                const cont = document.getElementById('modalDetailContent');
                cont.innerHTML = html;
                document.getElementById('modalDetail').style.display = 'flex';
                cont.querySelectorAll('script').forEach(oldScript => {
                    const newScript = document.createElement('script');
                    newScript.textContent = oldScript.textContent;
                    document.body.appendChild(newScript);
                    document.body.removeChild(newScript);
                });
            })
            .catch(() => alert('Gagal memuat detail pembayaran.'));
    }

    function tutupModalDetail() {
        document.getElementById('modalDetail').style.display = 'none';
        document.getElementById('modalDetailContent').innerHTML = '';
    }
    
    /* ================================================================
       PAGINATION: ganti jumlah baris
    ================================================================ */
    document.getElementById('pageSelect').addEventListener('change', function () {
        const url = new URL(window.location.href);
        url.searchParams.set('per_page', this.value);
        url.searchParams.delete('page');
        window.location.href = url.toString();
    });

    /* ================================================================
       FILTER TABEL CLIENT-SIDE
    ================================================================ */
    document.getElementById('searchTagihan')?.addEventListener('keyup', filterTagihan);
    document.getElementById('filterPaket')?.addEventListener('change', filterTagihan);
    document.getElementById('filterTagihan')?.addEventListener('change', filterTagihan);
    document.getElementById('filterPeriode')?.addEventListener('change', filterTagihan);

    function filterTagihan() {
        const s   = (document.getElementById('searchTagihan')?.value || '').toLowerCase();
        const fp  = document.getElementById('filterPaket')?.value || '';
        const ftg = document.getElementById('filterTagihan')?.value || '';
        const fpr = document.getElementById('filterPeriode')?.value || '';

        document.querySelectorAll('#tagihanTableBody tr').forEach(row => {
            if (!row.cells || row.cells.length < 7) return;
            const nama = (row.cells[1]?.innerText || '').toLowerCase();
            const paket = row.cells[3]?.innerText.trim() || '';
            const statusTagihan = row.cells[5]?.innerText.trim() || '';
            const periodeRow = row.getAttribute('data-periode') || '';

            let show = true;
            if (s   && !nama.includes(s))              show = false;
            if (fp  && paket !== fp)                    show = false;
            if (ftg && statusTagihan !== ftg)           show = false;
            if (fpr && periodeRow && periodeRow !== fpr) show = false;

            row.style.display = show ? '' : 'none';
        });
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Privat-Bimbel\resources\views/dashboard/shared/transaksi/pemasukan.blade.php ENDPATH**/ ?>