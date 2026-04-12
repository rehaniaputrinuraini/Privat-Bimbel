

<?php $__env->startSection('title', 'Pembayaran'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .filter-select {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%239CA3AF' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 14px center;
        padding-right: 38px !important;
    }
    .tab-item {
        flex: 1;
        padding: 14px 20px;
        cursor: pointer;
        font-weight: 700;
        font-size: 15px;
        text-align: center;
        transition: 0.3s;
        color: #9CA3AF;
        border-bottom: 2px solid transparent;
    }
    .tab-active {
        border-bottom-color: #4D0B87 !important;
        color: #4D0B87 !important;
    }
    [x-cloak] { display: none !important; }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div x-data="{ tab: 'tagihan' }" style="width: 100%;">

    
    <div style="margin-bottom: 25px;">
        <p style="color: #374151; font-size: 13px; margin: 0 0 4px 0;">
            <?php echo e(\Carbon\Carbon::now()->translatedFormat('F Y')); ?>

        </p>
        <h1 style="font-size: 26px; font-weight: 700; color: #111827; margin: 0;">Pembayaran</h1>
        <p style="color: #374151; font-size: 14px; margin: 4px 0 0 0;">Kelola Pembayaran Murid dan Riwayat Pembayaran</p>
    </div>

    
    <div style="display: flex; justify-content: flex-end; margin-bottom: 25px;">
        <a href="<?php echo e(route($role . '.pembayaran.create')); ?>" style="text-decoration: none;">
            <button style="background-color: #4D0B87; color: white; border: none; padding: 12px 25px; border-radius: 12px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-plus"></i> Input Pembayaran Murid
            </button>
        </a>
    </div>

    
    <div style="display: flex; width: 100%; border-bottom: 2px solid #E5E7EB; margin-bottom: 25px;">
        <div class="tab-item" :class="tab === 'tagihan' ? 'tab-active' : ''" @click="tab = 'tagihan'">
            Tagihan Murid
        </div>
        <div class="tab-item" :class="tab === 'riwayat' ? 'tab-active' : ''" @click="tab = 'riwayat'">
            Riwayat Pembayaran
        </div>
    </div>

    
    <div x-show="tab === 'tagihan'" x-cloak>
        <div style="background: white; border-radius: 16px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.06); margin-bottom: 20px;">
            <div style="position: relative; margin-bottom: 12px;">
                <i class="fas fa-search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #9CA3AF;"></i>
                <input type="text" id="searchTagihan" placeholder="Cari Nama Murid..."
                       style="width: 100%; padding: 12px 15px 12px 45px; border-radius: 12px; border: 1px solid #E5E7EB; background: #F9FAFB; font-size: 14px;">
            </div>
            <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                <select id="filterPaket" class="filter-select" style="flex: 1; padding: 10px 14px; border-radius: 12px; border: 1px solid #E5E7EB; background: #F9FAFB;">
                    <option value="">Status Paket</option>
                    <?php $__currentLoopData = $paketList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($paket->tingkat); ?>"><?php echo e($paket->tingkat); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <select id="filterPembayaran" class="filter-select" style="flex: 1; padding: 10px 14px; border-radius: 12px; border: 1px solid #E5E7EB; background: #F9FAFB;">
                    <option value="">Status Pembayaran Bulan Ini</option>
                    <option value="Lunas">Lunas</option>
                    <option value="Belum">Belum</option>
                </select>
                <select id="filterTagihan" class="filter-select" style="flex: 1; padding: 10px 14px; border-radius: 12px; border: 1px solid #E5E7EB; background: #F9FAFB;">
                    <option value="">Status Tagihan</option>
                    <option value="Lunas">Lunas</option>
                    <option value="Tunggak">Tunggak</option>
                    <option value="Uang Muka">Uang Muka</option>
                </select>
            </div>
        </div>

        <div style="background: white; border-radius: 20px; overflow-x: auto; box-shadow: 0 4px 15px rgba(0,0,0,0.08);">
            <table style="width: 100%; border-collapse: collapse; font-size: 13px; white-space: nowrap;">
                <thead>
                    <tr style="background: #F3E8FF;">
                        <th style="padding: 15px;">No</th>
                        <th style="padding: 15px;">Nama Murid</th>
                        <th style="padding: 15px;">Kelas</th>
                        <th style="padding: 15px;">Status Paket</th>
                        <th style="padding: 15px; text-align: center;">Status Pendaftaran</th>
                        <th style="padding: 15px; text-align: center;">Status Pembayaran</th>
                        <th style="padding: 15px; text-align: center;">Status Tagihan</th>
                        <th style="padding: 15px; text-align: center;">Tagihan Bulan</th>
                        <th style="padding: 15px; text-align: center;">Total Piutang</th>
                        <th style="padding: 15px; text-align: center;">Uang Muka</th>
                    </tr>
                </thead>
                <tbody id="tagihanTableBody">
                    <?php $__empty_1 = true; $__currentLoopData = $tagihan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr style="border-bottom: 1px solid #F3F4F6;">
                        <td style="padding: 15px;"><?php echo e($index + 1); ?></td>
                        <td style="padding: 15px;"><?php echo e($t->nama_murid); ?></td>
                        <td style="padding: 15px;"><?php echo e($t->kelas); ?></td>
                        <td style="padding: 15px;"><?php echo e($t->paket); ?></td>
                        
                        
                        <td style="padding: 15px; text-align: center;">
                            <?php if($t->status_pendaftaran == 'Lunas'): ?>
                                <span style="padding: 5px 12px; border-radius: 20px; background: #E1F7E3; color: #0E7490;">Lunas</span>
                            <?php else: ?>
                                <span style="padding: 5px 12px; border-radius: 20px; background: #FEE2E2; color: #EF4444;">Belum</span>
                            <?php endif; ?>
                        </td>
                        
                        
                        <td style="padding: 15px; text-align: center;">
                            <?php if($t->status_pembayaran == 'Lunas'): ?>
                                <span style="padding: 5px 12px; border-radius: 20px; background: #E1F7E3; color: #0E7490;">Lunas</span>
                            <?php elseif($t->status_pembayaran == 'Belum'): ?>
                                <span style="padding: 5px 12px; border-radius: 20px; background: #FEE2E2; color: #EF4444;">Belum</span>
                            <?php else: ?>
                                <span style="padding: 5px 12px; border-radius: 20px; background: #F3F4F6; color: #6B7280;">-</span>
                            <?php endif; ?>
                        </td>
                        
                        
                        <td style="padding: 15px; text-align: center;">
                            <?php if($t->status_tagihan == 'Lunas'): ?>
                                <span style="padding: 5px 12px; border-radius: 20px; background: #E1F7E3; color: #0E7490;">Lunas</span>
                            <?php elseif($t->status_tagihan == 'Tunggak'): ?>
                                <span style="padding: 5px 12px; border-radius: 20px; background: #FEF3C7; color: #92400E;">Tunggak</span>
                            <?php elseif($t->status_tagihan == 'Uang Muka'): ?>
                                <span style="padding: 5px 12px; border-radius: 20px; background: #E0E7FF; color: #4338CA;">Uang Muka</span>
                            <?php else: ?>
                                <span style="padding: 5px 12px; border-radius: 20px; background: #F3F4F6; color: #6B7280;">-</span>
                            <?php endif; ?>
                        </td>
                        
                        <td style="padding: 15px; text-align: center;"><?php echo e($t->tagihan_bulan); ?></td>
                        <td style="padding: 15px; text-align: center; <?php echo e($t->total_piutang != '-' ? 'font-weight:700;color:#EF4444;' : ''); ?>"><?php echo e($t->total_piutang); ?></td>
                        <td style="padding: 15px; text-align: center;"><?php echo e($t->uang_muka); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="10" style="padding: 40px; text-align: center; color: #9CA3AF;">Belum ada data tagihan</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    
    <div x-show="tab === 'riwayat'" x-cloak>
        <div style="background: white; border-radius: 16px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.06); margin-bottom: 20px;">
            <div style="position: relative; margin-bottom: 12px;">
                <i class="fas fa-search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #9CA3AF;"></i>
                <input type="text" id="searchRiwayat" placeholder="Cari Nama Murid..."
                       style="width: 100%; padding: 12px 15px 12px 45px; border-radius: 12px; border: 1px solid #E5E7EB; background: #F9FAFB; font-size: 14px;">
            </div>
            <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                <select id="filterPaketRiwayat" class="filter-select" style="flex: 1; padding: 10px 14px; border-radius: 12px; border: 1px solid #E5E7EB; background: #F9FAFB;">
                    <option value="">Status Paket</option>
                    <?php $__currentLoopData = $paketList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($paket->tingkat); ?>"><?php echo e($paket->tingkat); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <select id="filterBulan" class="filter-select" style="flex: 1; padding: 10px 14px; border-radius: 12px; border: 1px solid #E5E7EB; background: #F9FAFB;">
                    <option value="">Pilih Bulan</option>
                    <option value="1">Januari</option>
                    <option value="2">Februari</option>
                    <option value="3">Maret</option>
                    <option value="4">April</option>
                    <option value="5">Mei</option>
                    <option value="6">Juni</option>
                    <option value="7">Juli</option>
                    <option value="8">Agustus</option>
                    <option value="9">September</option>
                    <option value="10">Oktober</option>
                    <option value="11">November</option>
                    <option value="12">Desember</option>
                </select>
                <select id="filterTahunRiwayat" class="filter-select" style="flex: 1; padding: 10px 14px; border-radius: 12px; border: 1px solid #E5E7EB; background: #F9FAFB;">
                    <option value="">Pilih Tahun</option>
                </select>
            </div>
        </div>

        <div style="background: white; border-radius: 20px; overflow-x: auto; box-shadow: 0 4px 15px rgba(0,0,0,0.08);">
            <table style="width: 100%; border-collapse: collapse; font-size: 13px; white-space: nowrap;">
                <thead>
                    <tr style="background: #F3E8FF;">
                        <th style="padding: 15px;">No</th>
                        <th style="padding: 15px;">Tanggal</th>
                        <th style="padding: 15px;">Nama Murid</th>
                        <th style="padding: 15px;">Paket Awal</th>
                        <th style="padding: 15px;">Paket Belajar</th>
                        <th style="padding: 15px;">Untuk Bulan</th>
                        <th style="padding: 15px; text-align: center;">Total Bayar</th>
                        <th style="padding: 15px;">Keterangan</th>
                    </tr>
                </thead>
                <tbody id="riwayatTableBody">
                    <?php $__empty_1 = true; $__currentLoopData = $riwayat; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr style="border-bottom: 1px solid #F3F4F6;">
                        <td style="padding: 15px;"><?php echo e($index + 1); ?></td>
                        <td style="padding: 15px;"><?php echo e($r->tanggal); ?></td>
                        <td style="padding: 15px;"><?php echo e($r->nama_murid); ?></td>
                        <td style="padding: 15px;"><?php echo e($r->paket_awal); ?></td>
                        <td style="padding: 15px;"><?php echo e($r->paket_selanjutnya); ?></td>
                        <td style="padding: 15px;"><?php echo e($r->bulan_dibayar); ?></td>
                        <td style="padding: 15px; text-align: center; font-weight: 700; color: #4D0B87;"><?php echo e($r->total_bayar); ?></td>
                        <td style="padding: 15px;"><?php echo e($r->keterangan); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="8" style="padding: 40px; text-align: center; color: #9CA3AF;">Belum ada riwayat pembayaran</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<script>
    // Filter Tagihan
    function filterTagihan() {
        const search = document.getElementById('searchTagihan')?.value.toLowerCase() || '';
        const filterPaket = document.getElementById('filterPaket')?.value || '';
        const filterPembayaran = document.getElementById('filterPembayaran')?.value || '';
        const filterTagihanStatus = document.getElementById('filterTagihan')?.value || '';
        
        const rows = document.querySelectorAll('#tagihanTableBody tr');
        rows.forEach(row => {
            if (!row.cells || row.cells.length < 10) return;
            const nama = row.cells[1]?.innerText.toLowerCase() || '';
            const paket = row.cells[3]?.innerText || '';
            const statusPembayaran = row.cells[5]?.innerText.trim() || '';
            const statusTagihan = row.cells[6]?.innerText.trim() || '';
            
            let show = true;
            if (search && !nama.includes(search)) show = false;
            if (filterPaket && paket !== filterPaket) show = false;
            if (filterPembayaran && statusPembayaran !== filterPembayaran) show = false;
            if (filterTagihanStatus) {
                if (filterTagihanStatus === 'Tunggak' && statusTagihan !== 'Tunggak') show = false;
                else if (filterTagihanStatus === 'Uang Muka' && statusTagihan !== 'Uang Muka') show = false;
                else if (filterTagihanStatus === 'Lunas' && statusTagihan !== 'Lunas') show = false;
            }
            row.style.display = show ? '' : 'none';
        });
    }
    
    // Filter Riwayat
    function filterRiwayat() {
        const search = document.getElementById('searchRiwayat')?.value.toLowerCase() || '';
        const filterPaket = document.getElementById('filterPaketRiwayat')?.value || '';
        const filterBulan = document.getElementById('filterBulan')?.value || '';
        const filterTahun = document.getElementById('filterTahunRiwayat')?.value || '';
        
        const rows = document.querySelectorAll('#riwayatTableBody tr');
        rows.forEach(row => {
            if (!row.cells || row.cells.length < 8) return;
            const nama = row.cells[2]?.innerText.toLowerCase() || '';
            const paket = row.cells[4]?.innerText || '';
            const tgl = row.cells[1]?.innerText || '';
            const parts = tgl.split('/');
            const bulan = parts[1] ? parseInt(parts[1]) : 0;
            const tahun = parts[2] ? parseInt(parts[2]) : 0;
            
            let show = true;
            if (search && !nama.includes(search)) show = false;
            if (filterPaket && paket !== filterPaket) show = false;
            if (filterBulan && bulan !== parseInt(filterBulan)) show = false;
            if (filterTahun && tahun !== parseInt(filterTahun)) show = false;
            row.style.display = show ? '' : 'none';
        });
    }
    
    // Event Listeners
    document.getElementById('searchTagihan')?.addEventListener('keyup', filterTagihan);
    document.getElementById('filterPaket')?.addEventListener('change', filterTagihan);
    document.getElementById('filterPembayaran')?.addEventListener('change', filterTagihan);
    document.getElementById('filterTagihan')?.addEventListener('change', filterTagihan);
    
    document.getElementById('searchRiwayat')?.addEventListener('keyup', filterRiwayat);
    document.getElementById('filterPaketRiwayat')?.addEventListener('change', filterRiwayat);
    document.getElementById('filterBulan')?.addEventListener('change', filterRiwayat);
    document.getElementById('filterTahunRiwayat')?.addEventListener('change', filterRiwayat);
    
    // Isi dropdown tahun riwayat
    const tahunSelect = document.getElementById('filterTahunRiwayat');
    if (tahunSelect) {
        const tahunSet = new Set();
        document.querySelectorAll('#riwayatTableBody tr').forEach(row => {
            if (row.cells && row.cells[1]) {
                const tgl = row.cells[1].innerText;
                const parts = tgl.split('/');
                if (parts[2]) tahunSet.add(parseInt(parts[2]));
            }
        });
        Array.from(tahunSet).sort().reverse().forEach(tahun => {
            const option = document.createElement('option');
            option.value = tahun;
            option.textContent = tahun;
            tahunSelect.appendChild(option);
        });
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Privat-Bimbel\resources\views/dashboard/shared/pembayaran/pembayaran.blade.php ENDPATH**/ ?>