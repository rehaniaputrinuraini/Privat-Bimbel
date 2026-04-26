

<?php $__env->startSection('title', 'Laporan Keuangan'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .filter-select {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='10' viewBox='0 0 24 24' fill='none' stroke='%236B7280' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
        background-size: 12px 12px;
        padding-right: 36px !important;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div style="width: 100%;">

    <?php $role = $role ?? (Auth::user()->peran); ?>

    <div style="margin-bottom: 25px;">
        <p style="color: #374151; font-size: 13px; margin: 0 0 4px 0;">
            <?php echo e(\Carbon\Carbon::now()->translatedFormat('F Y')); ?>

        </p>
        <h1 style="font-size: 26px; font-weight: 700; color: #111827; margin: 0; letter-spacing: -0.5px; line-height: 1.2;">
            Laporan Keuangan
        </h1>
        <p style="color: #374151; font-size: 14px; margin: 4px 0 0 0;">Data Laporan Arus Kas Masuk dan Keluar</p>
    </div>

    <?php if(session('success')): ?>
        <div style="background: #D1FAE5; color: #065F46; padding: 12px; border-radius: 10px; margin-bottom: 20px;">
            <i class="fas fa-check-circle"></i> <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div style="background: #FEE2E2; color: #EF4444; padding: 12px; border-radius: 10px; margin-bottom: 20px;">
            <i class="fas fa-exclamation-circle"></i> <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    
    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 30px;">
        <div style="background: white; padding: 20px; border-radius: 15px; border-left: 8px solid #4472DF; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
            <p style="margin: 0; color: #4472DF; font-weight: 700; font-size: 13px;">Pemasukan (Pendaftaran + Manual)</p>
            <h3 style="margin: 10px 0 0; font-size: 20px; font-weight: 800; color: #4472DF;">Rp <?php echo e(number_format($totalPemasukan, 0, ',', '.')); ?></h3>
        </div>
        <div style="background: white; padding: 20px; border-radius: 15px; border-left: 8px solid #D74E4E; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
            <p style="margin: 0; color: #D74E4E; font-weight: 700; font-size: 13px;">Pengeluaran</p>
            <h3 style="margin: 10px 0 0; font-size: 20px; font-weight: 800; color: #D74E4E;">Rp <?php echo e(number_format($totalPengeluaran, 0, ',', '.')); ?></h3>
        </div>
        <div style="background: white; padding: 20px; border-radius: 15px; border-left: 8px solid #E7C255; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
            <p style="margin: 0; color: #E7C255; font-weight: 700; font-size: 13px;">Piutang (Tunggakan)</p>
            <h3 style="margin: 10px 0 0; font-size: 20px; font-weight: 800; color: #E7C255;">Rp <?php echo e(number_format($totalPiutang, 0, ',', '.')); ?></h3>
        </div>
        <div style="background: white; padding: 20px; border-radius: 15px; border-left: 8px solid #4AB462; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
            <p style="margin: 0; color: #4AB462; font-weight: 700; font-size: 13px;">Uang Muka</p>
            <h3 style="margin: 10px 0 0; font-size: 20px; font-weight: 800; color: #4AB462;">Rp <?php echo e(number_format($totalUangMuka, 0, ',', '.')); ?></h3>
        </div>
        <div style="background: white; padding: 20px; border-radius: 15px; border-left: 8px solid #ACB2AD; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
            <p style="margin: 0; color: #ACB2AD; font-weight: 700; font-size: 13px;">Total Pemasukan Kas</p>
            <h3 style="margin: 10px 0 0; font-size: 20px; font-weight: 800; color: #ACB2AD;">Rp <?php echo e(number_format($totalPemasukanKas, 0, ',', '.')); ?></h3>
        </div>
        <div style="background: white; padding: 20px; border-radius: 15px; border-left: 8px solid #4D0B87; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
            <p style="margin: 0; color: #4D0B87; font-weight: 700; font-size: 13px;">Saldo Kas</p>
            <h3 style="margin: 10px 0 0; font-size: 20px; font-weight: 800; color: #4D0B87;">Rp <?php echo e(number_format($saldoKas, 0, ',', '.')); ?></h3>
        </div>
    </div>

    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; gap: 15px; flex-wrap: wrap;">
        <div style="display: flex; align-items: center; gap: 12px; flex: 1; flex-wrap: wrap;">
            <div style="position: relative; width: 280px;">
                <i class="fas fa-search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #9CA3AF;"></i>
                <input type="text" id="searchInput" placeholder="Cari nama murid..."
                       style="width: 100%; padding: 10px 15px 10px 45px; border-radius: 12px; border: 1px solid #E5E7EB; outline: none; background: white; font-size: 14px; color: #374151;">
            </div>

            <form method="GET" action="<?php echo e(route($role . '.laporan-keuangan')); ?>" style="display: flex; gap: 12px; flex-wrap: wrap;" id="filterForm">
                <select name="bulan" class="filter-select" style="padding: 10px 12px; border-radius: 12px; border: 1px solid #E5E7EB; color: #374151; font-size: 13px; min-width: 140px; background: white; outline: none; cursor: pointer;" onchange="this.form.submit()">
                    <option value="">--- Pilih Bulan ---</option>
                    <?php $__currentLoopData = $bulanList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $bulan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($key); ?>" <?php echo e($filterBulan == $key ? 'selected' : ''); ?>><?php echo e($bulan); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>

                <select name="tahun" class="filter-select" style="padding: 10px 12px; border-radius: 12px; border: 1px solid #E5E7EB; color: #374151; font-size: 13px; min-width: 120px; background: white; outline: none; cursor: pointer;" onchange="this.form.submit()">
                    <option value="">--- Tahun ---</option>
                    <?php $__currentLoopData = $tahunList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tahun): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($tahun); ?>" <?php echo e($filterTahun == $tahun ? 'selected' : ''); ?>><?php echo e($tahun); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>

                <?php if($filterBulan || $filterTahun): ?>
                    <a href="<?php echo e(route($role . '.laporan-keuangan')); ?>" style="padding: 10px 15px; background: #F3F4F6; color: #374151; border-radius: 12px; text-decoration: none; font-size: 13px; display: flex; align-items: center; gap: 5px;">
                        <i class="fas fa-times"></i> Reset
                    </a>
                <?php endif; ?>
            </form>
        </div>

        <button onclick="bukaModalCreate()" style="background-color: #4D0B87; color: white; border: none; padding: 12px 25px; border-radius: 12px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 10px; font-size: 14px; box-shadow: 0 4px 6px rgba(77,11,135,0.2);">
            <i class="fas fa-plus"></i> Tambah Manual
        </button>
    </div>

    
    <div style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.08); border: 1px solid #F3F4F6; margin-bottom: 25px;">
        <div style="padding: 20px 20px 15px;">
            <h4 style="margin: 0; font-size: 15px; font-weight: 700; color: #111827;">Riwayat Pemasukan</h4>
        </div>
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 13px; white-space: nowrap;">
                <thead>
                    <tr style="background: #A2B9EE; color: #111827;">
                        <th style="padding: 15px; text-align: center; width: 50px;">No</th>
                        <th style="padding: 15px;">Tanggal</th>
                        <th style="padding: 15px;">Rincian</th>
                        <th style="padding: 15px;">Jenis Pembayaran</th>
                        <th style="padding: 15px; text-align: right;">Jumlah</th>
                        <th style="padding: 15px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tbodyPemasukan" style="color: #374151;">
                    <?php $__empty_1 = true; $__currentLoopData = $pemasukan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr style="border-bottom: 1px solid #F3F4F6; background: #F0F4FF;">
                        <td style="padding: 15px; text-align: center;"><?php echo e($pemasukan->firstItem() + $index); ?></td>
                        <td style="padding: 15px;"><?php echo e($p->tanggal ? \Carbon\Carbon::parse($p->tanggal)->translatedFormat('d M Y') : '-'); ?></td>
                        <td style="padding: 15px;">
                            <?php echo e($p->rincian); ?>

                            <?php if(isset($p->sumber) && $p->sumber == 'pendaftaran'): ?>
                                <span style="background: #4472DF; color: white; padding: 2px 8px; border-radius: 20px; font-size: 10px; margin-left: 8px;">Auto</span>
                            <?php elseif(isset($p->sumber) && $p->sumber == 'manual'): ?>
                                <span style="background: #9CA3AF; color: white; padding: 2px 8px; border-radius: 20px; font-size: 10px; margin-left: 8px;">Manual</span>
                            <?php endif; ?>
                        </td>
                        <td style="padding: 15px;"><?php echo e($p->jenis_pembayaran ?? '-'); ?></td>
                        <td style="padding: 15px; text-align: right; font-weight: 700; color: #4472DF;">Rp <?php echo e(number_format($p->jumlah, 0, ',', '.')); ?></td>
                        <td style="padding: 15px; text-align: center;">
                            <button type="button" onclick="bukaModalHapus('<?php echo e(route($role . '.laporan-keuangan.destroy', $p->id)); ?>', '<?php echo e(addslashes($p->rincian)); ?>')" 
                                    style="background: #E35D5D; color: white; padding: 6px 12px; border-radius: 6px; border: none; cursor: pointer;">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="6" style="padding: 40px; text-align: center; color: #9CA3AF;">Belum ada data pemasukan</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <div style="display: flex; justify-content: space-between; padding: 12px 20px; background: #F0F4FF; border-top: 2px solid #4472DF;">
            <span style="font-size: 14px; font-weight: 700; color: #111827;">Total Pemasukan</span>
            <span style="font-size: 15px; font-weight: 800; color: #4472DF;">Rp <?php echo e(number_format($totalPemasukan, 0, ',', '.')); ?></span>
        </div>
        
        <div style="display: flex; justify-content: space-between; align-items: center; padding: 10px 20px; background: #F9FAFB; border-top: 1px solid #F3F4F6;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <select onchange="changePerPage(this.value, 'page_pemasukan')" style="padding: 8px 12px; border-radius: 10px; border: 1px solid #E5E7EB; color: #374151; font-size: 13px; background: white; outline: none; cursor: pointer;">
                    <option value="10" <?php echo e(request('per_page_pemasukan', 10) == 10 ? 'selected' : ''); ?>>10 baris</option>
                    <option value="25" <?php echo e(request('per_page_pemasukan') == 25 ? 'selected' : ''); ?>>25 baris</option>
                    <option value="50" <?php echo e(request('per_page_pemasukan') == 50 ? 'selected' : ''); ?>>50 baris</option>
                </select>
                <span style="color: #374151; font-size: 13px;">Menampilkan <?php echo e($pemasukan->count()); ?> data</span>
            </div>
            <div style="display: flex; gap: 5px;">
                <?php if($pemasukan->onFirstPage()): ?>
                    <button disabled style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: #F3F4F6; color: #9CA3AF; cursor: not-allowed;"><i class="fas fa-angle-double-left"></i></button>
                    <button disabled style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: #F3F4F6; color: #9CA3AF; cursor: not-allowed;"><i class="fas fa-angle-left"></i></button>
                <?php else: ?>
                    <a href="<?php echo e(request()->fullUrlWithQuery(['page_pemasukan' => 1])); ?>" style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #4472DF; background: white; color: #4472DF; display: flex; align-items: center; justify-content: center; text-decoration: none;"><i class="fas fa-angle-double-left"></i></a>
                    <a href="<?php echo e($pemasukan->previousPageUrl()); ?>" style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #4472DF; background: white; color: #4472DF; display: flex; align-items: center; justify-content: center; text-decoration: none;"><i class="fas fa-angle-left"></i></a>
                <?php endif; ?>
                <?php $__currentLoopData = $pemasukan->getUrlRange(1, $pemasukan->lastPage()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($page == $pemasukan->currentPage()): ?>
                        <button style="width: 35px; height: 35px; border-radius: 8px; background: #4472DF; color: white; border: none; font-weight: 600; cursor: pointer;"><?php echo e($page); ?></button>
                    <?php else: ?>
                        <a href="<?php echo e($url); ?>" style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #4472DF; background: white; color: #4472DF; display: flex; align-items: center; justify-content: center; text-decoration: none;"><?php echo e($page); ?></a>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php if($pemasukan->hasMorePages()): ?>
                    <a href="<?php echo e($pemasukan->nextPageUrl()); ?>" style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #4472DF; background: white; color: #4472DF; display: flex; align-items: center; justify-content: center; text-decoration: none;"><i class="fas fa-angle-right"></i></a>
                <?php else: ?>
                    <button disabled style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: #F3F4F6; color: #9CA3AF; cursor: not-allowed;"><i class="fas fa-angle-right"></i></button>
                <?php endif; ?>
            </div>
        </div>
    </div>

    
    <div style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.08); border: 1px solid #F3F4F6; margin-bottom: 25px;">
        <div style="padding: 20px 20px 15px;">
            <h4 style="margin: 0; font-size: 15px; font-weight: 700; color: #111827;">Riwayat Pengeluaran</h4>
        </div>
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 13px; white-space: nowrap;">
                <thead>
                    <tr style="background: #EEA2A2; color: #111827;">
                        <th style="padding: 15px; text-align: center; width: 50px;">No</th>
                        <th style="padding: 15px;">Tanggal</th>
                        <th style="padding: 15px;">Rincian</th>
                        <th style="padding: 15px;">Jenis Pembayaran</th>
                        <th style="padding: 15px; text-align: right;">Jumlah</th>
                        <th style="padding: 15px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tbodyPengeluaran" style="color: #374151;">
                    <?php $__empty_1 = true; $__currentLoopData = $pengeluaran; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr style="border-bottom: 1px solid #F3F4F6; background: #FFF0F0;">
                        <td style="padding: 15px; text-align: center;"><?php echo e($pengeluaran->firstItem() + $index); ?></td>
                        <td style="padding: 15px;"><?php echo e($p->tanggal ? \Carbon\Carbon::parse($p->tanggal)->translatedFormat('d M Y') : '-'); ?></td>
                        <td style="padding: 15px;"><?php echo e($p->rincian); ?></td>
                        <td style="padding: 15px;"><?php echo e($p->jenis_pembayaran ?? '-'); ?></td>
                        <td style="padding: 15px; text-align: right; font-weight: 700; color: #D74E4E;">Rp <?php echo e(number_format($p->jumlah, 0, ',', '.')); ?></td>
                        <td style="padding: 15px; text-align: center;">
                            <button type="button" onclick="bukaModalHapus('<?php echo e(route($role . '.laporan-keuangan.destroy', $p->id)); ?>', '<?php echo e(addslashes($p->rincian)); ?>')" 
                                    style="background: #E35D5D; color: white; padding: 6px 12px; border-radius: 6px; border: none; cursor: pointer;">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="6" style="padding: 40px; text-align: center; color: #9CA3AF;">Belum ada data pengeluaran</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <div style="display: flex; justify-content: space-between; padding: 12px 20px; background: #FFF0F0; border-top: 2px solid #D74E4E;">
            <span style="font-size: 14px; font-weight: 700; color: #111827;">Total Pengeluaran</span>
            <span style="font-size: 15px; font-weight: 800; color: #D74E4E;">Rp <?php echo e(number_format($totalPengeluaran, 0, ',', '.')); ?></span>
        </div>
        
        <div style="display: flex; justify-content: space-between; align-items: center; padding: 10px 20px; background: #F9FAFB; border-top: 1px solid #F3F4F6;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <select onchange="changePerPage(this.value, 'page_pengeluaran')" style="padding: 8px 12px; border-radius: 10px; border: 1px solid #E5E7EB; color: #374151; font-size: 13px; background: white; outline: none; cursor: pointer;">
                    <option value="10" <?php echo e(request('per_page_pengeluaran', 10) == 10 ? 'selected' : ''); ?>>10 baris</option>
                    <option value="25" <?php echo e(request('per_page_pengeluaran') == 25 ? 'selected' : ''); ?>>25 baris</option>
                    <option value="50" <?php echo e(request('per_page_pengeluaran') == 50 ? 'selected' : ''); ?>>50 baris</option>
                </select>
                <span style="color: #374151; font-size: 13px;">Menampilkan <?php echo e($pengeluaran->count()); ?> data</span>
            </div>
            <div style="display: flex; gap: 5px;">
                <?php if($pengeluaran->onFirstPage()): ?>
                    <button disabled style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: #F3F4F6; color: #9CA3AF; cursor: not-allowed;"><i class="fas fa-angle-double-left"></i></button>
                    <button disabled style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: #F3F4F6; color: #9CA3AF; cursor: not-allowed;"><i class="fas fa-angle-left"></i></button>
                <?php else: ?>
                    <a href="<?php echo e(request()->fullUrlWithQuery(['page_pengeluaran' => 1])); ?>" style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #D74E4E; background: white; color: #D74E4E; display: flex; align-items: center; justify-content: center; text-decoration: none;"><i class="fas fa-angle-double-left"></i></a>
                    <a href="<?php echo e($pengeluaran->previousPageUrl()); ?>" style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #D74E4E; background: white; color: #D74E4E; display: flex; align-items: center; justify-content: center; text-decoration: none;"><i class="fas fa-angle-left"></i></a>
                <?php endif; ?>
                <?php $__currentLoopData = $pengeluaran->getUrlRange(1, $pengeluaran->lastPage()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($page == $pengeluaran->currentPage()): ?>
                        <button style="width: 35px; height: 35px; border-radius: 8px; background: #D74E4E; color: white; border: none; font-weight: 600; cursor: pointer;"><?php echo e($page); ?></button>
                    <?php else: ?>
                        <a href="<?php echo e($url); ?>" style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #D74E4E; background: white; color: #D74E4E; display: flex; align-items: center; justify-content: center; text-decoration: none;"><?php echo e($page); ?></a>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php if($pengeluaran->hasMorePages()): ?>
                    <a href="<?php echo e($pengeluaran->nextPageUrl()); ?>" style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #D74E4E; background: white; color: #D74E4E; display: flex; align-items: center; justify-content: center; text-decoration: none;"><i class="fas fa-angle-right"></i></a>
                <?php else: ?>
                    <button disabled style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: #F3F4F6; color: #9CA3AF; cursor: not-allowed;"><i class="fas fa-angle-right"></i></button>
                <?php endif; ?>
            </div>
        </div>
    </div>

    
    <div style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.08); border: 1px solid #F3F4F6; margin-bottom: 25px;">
        <div style="padding: 20px 20px 15px;">
            <h4 style="margin: 0; font-size: 15px; font-weight: 700; color: #111827;">Riwayat Piutang (Tunggakan)</h4>
        </div>
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 13px; white-space: nowrap;">
                <thead>
                    <tr style="background: #EEDCA2; color: #111827;">
                        <th style="padding: 15px; text-align: center; width: 50px;">No</th>
                        <th style="padding: 15px;">Tanggal</th>
                        <th style="padding: 15px;">Nama Murid</th>
                        <th style="padding: 15px;">Bulan Tagihan</th>
                        <th style="padding: 15px; text-align: right;">Jumlah</th>
                        <th style="padding: 15px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tbodyPiutang" style="color: #374151;">
                    <?php $__empty_1 = true; $__currentLoopData = $piutang; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr style="border-bottom: 1px solid #F3F4F6; background: #FFFDF0;">
                        <td style="padding: 15px; text-align: center;"><?php echo e($piutang->firstItem() + $index); ?></td>
                        <td style="padding: 15px;"><?php echo e($p->tanggal ? \Carbon\Carbon::parse($p->tanggal)->translatedFormat('d M Y') : '-'); ?></td>
                        <td style="padding: 15px;">
                            <?php echo e($p->nama_murid ?? '-'); ?>

                            <span style="background: #E7C255; color: white; padding: 2px 8px; border-radius: 20px; font-size: 10px; margin-left: 8px;">Auto</span>
                        </td>
                        <td style="padding: 15px;"><?php echo e($p->bulan_periode ?? '-'); ?></td>
                        <td style="padding: 15px; text-align: right; font-weight: 700; color: #E7C255;">Rp <?php echo e(number_format($p->jumlah, 0, ',', '.')); ?></td>
                        <td style="padding: 15px; text-align: center;">
                            <button type="button" onclick="bukaModalHapus('<?php echo e(route($role . '.laporan-keuangan.destroy', $p->id)); ?>', '<?php echo e(addslashes($p->nama_murid ?? '')); ?> - <?php echo e(addslashes($p->bulan_periode ?? '')); ?>')" 
                                    style="background: #E35D5D; color: white; padding: 6px 12px; border-radius: 6px; border: none; cursor: pointer;">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="6" style="padding: 40px; text-align: center; color: #9CA3AF;">Belum ada data piutang</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <div style="display: flex; justify-content: space-between; padding: 12px 20px; background: #FFFDF0; border-top: 2px solid #E7C255;">
            <span style="font-size: 14px; font-weight: 700; color: #111827;">Total Piutang</span>
            <span style="font-size: 15px; font-weight: 800; color: #E7C255;">Rp <?php echo e(number_format($totalPiutang, 0, ',', '.')); ?></span>
        </div>
        
        <div style="display: flex; justify-content: space-between; align-items: center; padding: 10px 20px; background: #F9FAFB; border-top: 1px solid #F3F4F6;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <select onchange="changePerPage(this.value, 'page_piutang')" style="padding: 8px 12px; border-radius: 10px; border: 1px solid #E5E7EB; color: #374151; font-size: 13px; background: white; outline: none; cursor: pointer;">
                    <option value="10" <?php echo e(request('per_page_piutang', 10) == 10 ? 'selected' : ''); ?>>10 baris</option>
                    <option value="25" <?php echo e(request('per_page_piutang') == 25 ? 'selected' : ''); ?>>25 baris</option>
                    <option value="50" <?php echo e(request('per_page_piutang') == 50 ? 'selected' : ''); ?>>50 baris</option>
                </select>
                <span style="color: #374151; font-size: 13px;">Menampilkan <?php echo e($piutang->count()); ?> data</span>
            </div>
            <div style="display: flex; gap: 5px;">
                <?php if($piutang->onFirstPage()): ?>
                    <button disabled style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: #F3F4F6; color: #9CA3AF; cursor: not-allowed;"><i class="fas fa-angle-double-left"></i></button>
                    <button disabled style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: #F3F4F6; color: #9CA3AF; cursor: not-allowed;"><i class="fas fa-angle-left"></i></button>
                <?php else: ?>
                    <a href="<?php echo e(request()->fullUrlWithQuery(['page_piutang' => 1])); ?>" style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E7C255; background: white; color: #E7C255; display: flex; align-items: center; justify-content: center; text-decoration: none;"><i class="fas fa-angle-double-left"></i></a>
                    <a href="<?php echo e($piutang->previousPageUrl()); ?>" style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E7C255; background: white; color: #E7C255; display: flex; align-items: center; justify-content: center; text-decoration: none;"><i class="fas fa-angle-left"></i></a>
                <?php endif; ?>
                <?php $__currentLoopData = $piutang->getUrlRange(1, $piutang->lastPage()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($page == $piutang->currentPage()): ?>
                        <button style="width: 35px; height: 35px; border-radius: 8px; background: #E7C255; color: white; border: none; font-weight: 600; cursor: pointer;"><?php echo e($page); ?></button>
                    <?php else: ?>
                        <a href="<?php echo e($url); ?>" style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E7C255; background: white; color: #E7C255; display: flex; align-items: center; justify-content: center; text-decoration: none;"><?php echo e($page); ?></a>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php if($piutang->hasMorePages()): ?>
                    <a href="<?php echo e($piutang->nextPageUrl()); ?>" style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E7C255; background: white; color: #E7C255; display: flex; align-items: center; justify-content: center; text-decoration: none;"><i class="fas fa-angle-right"></i></a>
                <?php else: ?>
                    <button disabled style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: #F3F4F6; color: #9CA3AF; cursor: not-allowed;"><i class="fas fa-angle-right"></i></button>
                <?php endif; ?>
            </div>
        </div>
    </div>

    
    <div style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.08); border: 1px solid #F3F4F6; margin-bottom: 25px;">
        <div style="padding: 20px 20px 15px;">
            <h4 style="margin: 0; font-size: 15px; font-weight: 700; color: #111827;">Riwayat Uang Muka</h4>
        </div>
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 13px; white-space: nowrap;">
                <thead>
                    <tr style="background: #A2EEB9; color: #111827;">
                        <th style="padding: 15px; text-align: center; width: 50px;">No</th>
                        <th style="padding: 15px;">Tanggal</th>
                        <th style="padding: 15px;">Nama Murid</th>
                        <th style="padding: 15px;">Periode</th>
                        <th style="padding: 15px; text-align: right;">Jumlah</th>
                        <th style="padding: 15px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tbodyUangMuka" style="color: #374151;">
                    <?php $__empty_1 = true; $__currentLoopData = $uang_muka; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr style="border-bottom: 1px solid #F3F4F6; background: #F0FFF4;">
                        <td style="padding: 15px; text-align: center;"><?php echo e($uang_muka->firstItem() + $index); ?></td>
                        <td style="padding: 15px;"><?php echo e($u->tanggal ? \Carbon\Carbon::parse($u->tanggal)->translatedFormat('d M Y') : '-'); ?></td>
                        <td style="padding: 15px;">
                            <?php echo e($u->nama_murid ?? '-'); ?>

                            <span style="background: #4AB462; color: white; padding: 2px 8px; border-radius: 20px; font-size: 10px; margin-left: 8px;">Auto</span>
                        </td>
                        <td style="padding: 15px;"><?php echo e($u->bulan_periode ?? '-'); ?></td>
                        <td style="padding: 15px; text-align: right; font-weight: 700; color: #4AB462;">Rp <?php echo e(number_format($u->jumlah, 0, ',', '.')); ?></td>
                        <td style="padding: 15px; text-align: center;">
                            <button type="button" onclick="bukaModalHapus('<?php echo e(route($role . '.laporan-keuangan.destroy', $u->id)); ?>', '<?php echo e(addslashes($u->nama_murid ?? '')); ?> - <?php echo e(addslashes($u->bulan_periode ?? '')); ?>')" 
                                    style="background: #E35D5D; color: white; padding: 6px 12px; border-radius: 6px; border: none; cursor: pointer;">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="6" style="padding: 40px; text-align: center; color: #9CA3AF;">Belum ada data uang muka</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <div style="display: flex; justify-content: space-between; padding: 12px 20px; background: #F0FFF4; border-top: 2px solid #4AB462;">
            <span style="font-size: 14px; font-weight: 700; color: #111827;">Total Uang Muka</span>
            <span style="font-size: 15px; font-weight: 800; color: #4AB462;">Rp <?php echo e(number_format($totalUangMuka, 0, ',', '.')); ?></span>
        </div>
        
        <div style="display: flex; justify-content: space-between; align-items: center; padding: 10px 20px; background: #F9FAFB; border-top: 1px solid #F3F4F6;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <select onchange="changePerPage(this.value, 'page_uangmuka')" style="padding: 8px 12px; border-radius: 10px; border: 1px solid #E5E7EB; color: #374151; font-size: 13px; background: white; outline: none; cursor: pointer;">
                    <option value="10" <?php echo e(request('per_page_uangmuka', 10) == 10 ? 'selected' : ''); ?>>10 baris</option>
                    <option value="25" <?php echo e(request('per_page_uangmuka') == 25 ? 'selected' : ''); ?>>25 baris</option>
                    <option value="50" <?php echo e(request('per_page_uangmuka') == 50 ? 'selected' : ''); ?>>50 baris</option>
                </select>
                <span style="color: #374151; font-size: 13px;">Menampilkan <?php echo e($uang_muka->count()); ?> data</span>
            </div>
            <div style="display: flex; gap: 5px;">
                <?php if($uang_muka->onFirstPage()): ?>
                    <button disabled style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: #F3F4F6; color: #9CA3AF; cursor: not-allowed;"><i class="fas fa-angle-double-left"></i></button>
                    <button disabled style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: #F3F4F6; color: #9CA3AF; cursor: not-allowed;"><i class="fas fa-angle-left"></i></button>
                <?php else: ?>
                    <a href="<?php echo e(request()->fullUrlWithQuery(['page_uangmuka' => 1])); ?>" style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #4AB462; background: white; color: #4AB462; display: flex; align-items: center; justify-content: center; text-decoration: none;"><i class="fas fa-angle-double-left"></i></a>
                    <a href="<?php echo e($uang_muka->previousPageUrl()); ?>" style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #4AB462; background: white; color: #4AB462; display: flex; align-items: center; justify-content: center; text-decoration: none;"><i class="fas fa-angle-left"></i></a>
                <?php endif; ?>
                <?php $__currentLoopData = $uang_muka->getUrlRange(1, $uang_muka->lastPage()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($page == $uang_muka->currentPage()): ?>
                        <button style="width: 35px; height: 35px; border-radius: 8px; background: #4AB462; color: white; border: none; font-weight: 600; cursor: pointer;"><?php echo e($page); ?></button>
                    <?php else: ?>
                        <a href="<?php echo e($url); ?>" style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #4AB462; background: white; color: #4AB462; display: flex; align-items: center; justify-content: center; text-decoration: none;"><?php echo e($page); ?></a>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php if($uang_muka->hasMorePages()): ?>
                    <a href="<?php echo e($uang_muka->nextPageUrl()); ?>" style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #4AB462; background: white; color: #4AB462; display: flex; align-items: center; justify-content: center; text-decoration: none;"><i class="fas fa-angle-right"></i></a>
                <?php else: ?>
                    <button disabled style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: #F3F4F6; color: #9CA3AF; cursor: not-allowed;"><i class="fas fa-angle-right"></i></button>
                <?php endif; ?>
            </div>
        </div>
    </div>

    
    <button style="width: 100%; background: #6F2DA8; color: white; border: none; padding: 18px; border-radius: 15px; font-size: 16px; font-weight: 700; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 12px; margin-top: 10px; margin-bottom: 20px;" onclick="window.print()">
        <i class="fas fa-file-pdf" style="font-size: 20px;"></i> EXPORT PDF
    </button>

</div>


<div id="modalForm" style="display: none; position: fixed; z-index: 9998; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); backdrop-filter: blur(3px); align-items: center; justify-content: center; overflow-y: auto; padding: 20px;">
    <div style="background: white; border-radius: 20px; width: 700px; max-width: 95%; max-height: 90vh; overflow-y: auto; box-shadow: 0 15px 30px rgba(0,0,0,0.15);" id="modalContent"></div>
</div>


<div id="modalHapus" style="display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); backdrop-filter: blur(3px); align-items: center; justify-content: center;">
    <div style="background: white; padding: 25px; border-radius: 20px; width: 320px; text-align: center;">
        <div style="color: #E35D5D; font-size: 40px; margin-bottom: 10px;"><i class="fas fa-trash-alt"></i></div>
        <h2 style="margin: 0; font-size: 18px; color: #111827; font-weight: 700;">Hapus Data?</h2>
        <p style="color: #6B7280; font-size: 13px; margin: 8px 0 20px 0;" id="pesanHapus">Apakah Anda yakin ingin menghapus data ini?</p>
        <div style="display: flex; gap: 10px; justify-content: center;">
            <button onclick="tutupModalHapus()" style="flex: 1; padding: 10px; border-radius: 10px; border: 1px solid #E5E7EB; background: white; font-weight: 600; font-size: 13px; cursor: pointer;">Batal</button>
            <form id="formHapus" method="POST" style="flex: 1;">
                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                <button type="submit" style="width: 100%; padding: 10px; border-radius: 10px; border: none; background: #E35D5D; color: white; font-weight: 600; font-size: 13px; cursor: pointer;">Ya, Hapus</button>
            </form>
        </div>
    </div>
</div>

<script>
    function changePerPage(value, pageName) {
        let url = new URL(window.location.href);
        url.searchParams.set('per_page_' + pageName, value);
        url.searchParams.set(pageName, 1);
        window.location.href = url.toString();
    }

    function bukaModalCreate() {
        fetch("<?php echo e(route($role . '.laporan-keuangan.create')); ?>")
            .then(r => r.text())
            .then(html => {
                document.getElementById('modalContent').innerHTML = html;
                document.getElementById('modalForm').style.display = 'flex';
                setTimeout(() => pasangEventHandler(), 150);
            });
    }

    function tutupModalForm() {
        document.getElementById('modalForm').style.display = 'none';
        document.getElementById('modalContent').innerHTML = '';
    }

    document.getElementById('modalForm').addEventListener('click', function(e) { if (e.target === this) tutupModalForm(); });

    function pasangEventHandler() {
        const mc = document.getElementById('modalContent');
        if (!mc) return;
        const form = mc.querySelector('#mainForm');
        const btnKeluar = mc.querySelector('#btnKeluar');
        const btnSimpan = mc.querySelector('#btnSimpan');
        const modalBatal = mc.querySelector('#modalBatal');
        const modalPindah = mc.querySelector('#modalPindahHalaman');
        const modalSukses = mc.querySelector('#modalSukses');
        const btnTidakBatal = mc.querySelector('#btnTidakBatal');
        const btnYaKeluar = mc.querySelector('#btnYaKeluar');
        const btnTidakPindah = mc.querySelector('#btnTidakPindah');
        const btnYaPindah = mc.querySelector('#btnYaPindah');
        const btnOkSukses = mc.querySelector('#btnOkSukses');
        const alertError = mc.querySelector('#alertError');
        const alertErrorText = mc.querySelector('#alertErrorText');
        const pesanSukses = mc.querySelector('#pesanSukses');
        let formChanged = false, formSubmitted = false;

        if (form) {
            form.querySelectorAll('input, select, textarea').forEach(el => {
                el.addEventListener('input', () => { if (!formSubmitted) formChanged = true; });
                el.addEventListener('change', () => { if (!formSubmitted) formChanged = true; });
            });
        }
        if (btnKeluar) btnKeluar.addEventListener('click', function(e) {
            e.preventDefault();
            if (formChanged && !formSubmitted) { if (modalPindah) modalPindah.style.display = 'flex'; }
            else { if (modalBatal) modalBatal.style.display = 'flex'; }
        });
        if (btnTidakBatal) btnTidakBatal.addEventListener('click', () => { if (modalBatal) modalBatal.style.display = 'none'; });
        if (btnYaKeluar) btnYaKeluar.addEventListener('click', () => { formChanged = false; if (modalBatal) modalBatal.style.display = 'none'; tutupModalForm(); });
        if (modalBatal) modalBatal.addEventListener('click', e => { if (e.target === modalBatal) modalBatal.style.display = 'none'; });
        if (btnTidakPindah) btnTidakPindah.addEventListener('click', () => { if (modalPindah) modalPindah.style.display = 'none'; });
        if (btnYaPindah) btnYaPindah.addEventListener('click', () => { formChanged = false; if (modalPindah) modalPindah.style.display = 'none'; tutupModalForm(); });
        if (modalPindah) modalPindah.addEventListener('click', e => { if (e.target === modalPindah) modalPindah.style.display = 'none'; });
        if (btnOkSukses) btnOkSukses.addEventListener('click', () => { if (modalSukses) modalSukses.style.display = 'none'; tutupModalForm(); window.location.reload(); });
        if (modalSukses) modalSukses.addEventListener('click', e => { if (e.target === modalSukses) { modalSukses.style.display = 'none'; tutupModalForm(); window.location.reload(); } });

        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const fd = new FormData(form);
                const btn = btnSimpan;
                const orig = btn ? btn.innerHTML : 'Simpan';
                if (btn) { btn.disabled = true; btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...'; }
                fetch(form.action, {
                    method: 'POST', body: fd,
                    headers: { 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '', 'Accept': 'application/json' }
                })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        formChanged = false; formSubmitted = true;
                        if (pesanSukses) pesanSukses.textContent = data.message || 'Data berhasil disimpan.';
                        if (modalSukses) modalSukses.style.display = 'flex';
                    } else {
                        let msg = data.message || 'Gagal';
                        if (data.errors) { msg = ''; for (let f in data.errors) msg += data.errors[f].join('\n') + '\n'; }
                        if (alertError && alertErrorText) { alertErrorText.textContent = msg; alertError.style.display = 'flex'; setTimeout(() => alertError.style.display = 'none', 5000); }
                        if (btn) { btn.disabled = false; btn.innerHTML = orig; }
                    }
                })
                .catch(err => {
                    if (alertError && alertErrorText) { alertErrorText.textContent = 'Error: ' + err.message; alertError.style.display = 'flex'; setTimeout(() => alertError.style.display = 'none', 5000); }
                    if (btn) { btn.disabled = false; btn.innerHTML = orig; }
                });
            });
        }
    }

    document.getElementById('searchInput').addEventListener('keyup', function() {
        let v = this.value.toLowerCase();
        ['tbodyPemasukan','tbodyPengeluaran','tbodyPiutang','tbodyUangMuka'].forEach(id => {
            document.querySelectorAll('#' + id + ' tr').forEach(row => {
                if (row.cells) {
                    let txt = id === 'tbodyPemasukan' || id === 'tbodyPengeluaran' ? (row.cells[2]?.innerText||'') : ((row.cells[2]?.innerText||'') + ' ' + (row.cells[3]?.innerText||''));
                    row.style.display = txt.toLowerCase().includes(v) ? '' : 'none';
                }
            });
        });
    });

    function bukaModalHapus(url, nama) {
        document.getElementById('formHapus').action = url;
        document.getElementById('pesanHapus').innerHTML = `Apakah Anda yakin ingin menghapus data <strong>${nama}</strong>?`;
        document.getElementById('modalHapus').style.display = 'flex';
    }
    function tutupModalHapus() { document.getElementById('modalHapus').style.display = 'none'; }
    document.getElementById('modalHapus').addEventListener('click', function(e) { if (e.target === this) tutupModalHapus(); });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Privat-Bimbel\resources\views/dashboard/shared/laporan-keuangan/laporan-keuangan.blade.php ENDPATH**/ ?>