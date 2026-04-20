

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

        <a href="<?php echo e(route($role . '.laporan-keuangan.create')); ?>" style="text-decoration: none;">
            <button style="background-color: #4D0B87; color: white; border: none; padding: 12px 25px; border-radius: 12px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 10px; font-size: 14px;">
                <i class="fas fa-plus"></i> Tambah Manual
            </button>
        </a>
    </div>

    
    <div class="table-container" style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.08); border: 1px solid #F3F4F6; margin-bottom: 25px;">
        <div style="padding: 20px 20px 15px;">
            <h4 style="margin: 0; font-size: 15px; font-weight: 700; color: #111827;">Riwayat Pemasukan</h4>
        </div>
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 13px; white-space: nowrap;">
                <thead>
                    <tr style="background: #A2B9EE; color: #111827;">
                        <th style="padding: 15px; font-weight: 700; text-align: center; width: 50px;">No</th>
                        <th style="padding: 15px; font-weight: 700;">Tanggal</th>
                        <th style="padding: 15px; font-weight: 700;">Rincian</th>
                        <th style="padding: 15px; font-weight: 700;">Jenis Pembayaran</th>
                        <th style="padding: 15px; font-weight: 700; text-align: right;">Jumlah</th>
                        <th style="padding: 15px; font-weight: 700; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tbodyPemasukan" style="color: #374151;">
                    <?php $__empty_1 = true; $__currentLoopData = $pemasukan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr style="border-bottom: 1px solid #F3F4F6; background: #F0F4FF;">
                        <td style="padding: 15px; text-align: center;"><?php echo e($loop->iteration); ?></td>
                        <td style="padding: 15px;"><?php echo e($p->tanggal ? \Carbon\Carbon::parse($p->tanggal)->translatedFormat('d M Y') : '-'); ?></td>
                        <td style="padding: 15px;">
                            <?php echo e($p->rincian); ?>

                            <?php if($p->sumber == 'pendaftaran'): ?>
                                <span style="background: #4472DF; color: white; padding: 2px 8px; border-radius: 20px; font-size: 10px; margin-left: 8px;">Auto</span>
                            <?php else: ?>
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
        <div style="display: flex; justify-content: space-between; padding: 15px 20px; background: #F9FAFB; border-top: 1px solid #F3F4F6;">
            <span style="font-size: 14px; font-weight: 700; color: #111827;">Total Pemasukan</span>
            <span style="font-size: 15px; font-weight: 800; color: #4472DF;">Rp <?php echo e(number_format($totalPemasukan, 0, ',', '.')); ?></span>
        </div>
    </div>

    
    <div class="table-container" style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.08); border: 1px solid #F3F4F6; margin-bottom: 25px;">
        <div style="padding: 20px 20px 15px;">
            <h4 style="margin: 0; font-size: 15px; font-weight: 700; color: #111827;">Riwayat Pengeluaran</h4>
        </div>
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 13px; white-space: nowrap;">
                <thead>
                    <tr style="background: #EEA2A2; color: #111827;">
                        <th style="padding: 15px; font-weight: 700; text-align: center; width: 50px;">No</th>
                        <th style="padding: 15px; font-weight: 700;">Tanggal</th>
                        <th style="padding: 15px; font-weight: 700;">Rincian</th>
                        <th style="padding: 15px; font-weight: 700;">Jenis Pembayaran</th>
                        <th style="padding: 15px; font-weight: 700; text-align: right;">Jumlah</th>
                        <th style="padding: 15px; font-weight: 700; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tbodyPengeluaran" style="color: #374151;">
                    <?php $__empty_1 = true; $__currentLoopData = $pengeluaran; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr style="border-bottom: 1px solid #F3F4F6; background: #FFF0F0;">
                        <td style="padding: 15px; text-align: center;"><?php echo e($loop->iteration); ?></td>
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
        <div style="display: flex; justify-content: space-between; padding: 15px 20px; background: #F9FAFB; border-top: 1px solid #F3F4F6;">
            <span style="font-size: 14px; font-weight: 700; color: #111827;">Total Pengeluaran</span>
            <span style="font-size: 15px; font-weight: 800; color: #D74E4E;">Rp <?php echo e(number_format($totalPengeluaran, 0, ',', '.')); ?></span>
        </div>
    </div>

    
    <div class="table-container" style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.08); border: 1px solid #F3F4F6; margin-bottom: 25px;">
        <div style="padding: 20px 20px 15px;">
            <h4 style="margin: 0; font-size: 15px; font-weight: 700; color: #111827;">Riwayat Piutang (Tunggakan)</h4>
        </div>
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 13px; white-space: nowrap;">
                <thead>
                    <tr style="background: #EEDCA2; color: #111827;">
                        <th style="padding: 15px; font-weight: 700; text-align: center; width: 50px;">No</th>
                        <th style="padding: 15px; font-weight: 700;">Tanggal</th>
                        <th style="padding: 15px; font-weight: 700;">Nama Murid</th>
                        <th style="padding: 15px; font-weight: 700;">Bulan Tagihan</th>
                        <th style="padding: 15px; font-weight: 700; text-align: right;">Jumlah</th>
                        <th style="padding: 15px; font-weight: 700; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tbodyPiutang" style="color: #374151;">
                    <?php $__empty_1 = true; $__currentLoopData = $piutang; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr style="border-bottom: 1px solid #F3F4F6; background: #FFFDF0;">
                        <td style="padding: 15px; text-align: center;"><?php echo e($loop->iteration); ?></td>
                        <td style="padding: 15px;"><?php echo e($p->tanggal ? \Carbon\Carbon::parse($p->tanggal)->translatedFormat('d M Y') : '-'); ?></td>
                        <td style="padding: 15px;">
                            <?php echo e($p->nama_murid ?? '-'); ?>

                            <span style="background: #E7C255; color: white; padding: 2px 8px; border-radius: 20px; font-size: 10px; margin-left: 8px;">Auto</span>
                        </td>
                        <td style="padding: 15px;"><?php echo e($p->bulan_periode ?? '-'); ?></td>
                        <td style="padding: 15px; text-align: right; font-weight: 700; color: #E7C255;">Rp <?php echo e(number_format($p->jumlah, 0, ',', '.')); ?></td>
                        <td style="padding: 15px; text-align: center;">
                            <button type="button" onclick="bukaModalHapus('<?php echo e(route($role . '.laporan-keuangan.destroy', $p->id)); ?>', '<?php echo e(addslashes($p->nama_murid)); ?> - <?php echo e(addslashes($p->bulan_periode)); ?>')" 
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
        <div style="display: flex; justify-content: space-between; padding: 15px 20px; background: #F9FAFB; border-top: 1px solid #F3F4F6;">
            <span style="font-size: 14px; font-weight: 700; color: #111827;">Total Piutang</span>
            <span style="font-size: 15px; font-weight: 800; color: #E7C255;">Rp <?php echo e(number_format($totalPiutang, 0, ',', '.')); ?></span>
        </div>
    </div>

    
    <div class="table-container" style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.08); border: 1px solid #F3F4F6; margin-bottom: 25px;">
        <div style="padding: 20px 20px 15px;">
            <h4 style="margin: 0; font-size: 15px; font-weight: 700; color: #111827;">Riwayat Uang Muka</h4>
        </div>
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 13px; white-space: nowrap;">
                <thead>
                    <tr style="background: #A2EEB9; color: #111827;">
                        <th style="padding: 15px; font-weight: 700; text-align: center; width: 50px;">No</th>
                        <th style="padding: 15px; font-weight: 700;">Tanggal</th>
                        <th style="padding: 15px; font-weight: 700;">Nama Murid</th>
                        <th style="padding: 15px; font-weight: 700;">Periode</th>
                        <th style="padding: 15px; font-weight: 700; text-align: right;">Jumlah</th>
                        <th style="padding: 15px; font-weight: 700; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tbodyUangMuka" style="color: #374151;">
                    <?php $__empty_1 = true; $__currentLoopData = $uang_muka; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr style="border-bottom: 1px solid #F3F4F6; background: #F0FFF4;">
                        <td style="padding: 15px; text-align: center;"><?php echo e($loop->iteration); ?></td>
                        <td style="padding: 15px;"><?php echo e($u->tanggal ? \Carbon\Carbon::parse($u->tanggal)->translatedFormat('d M Y') : '-'); ?></td>
                        <td style="padding: 15px;">
                            <?php echo e($u->nama_murid ?? '-'); ?>

                            <span style="background: #4AB462; color: white; padding: 2px 8px; border-radius: 20px; font-size: 10px; margin-left: 8px;">Auto</span>
                        </td>
                        <td style="padding: 15px;"><?php echo e($u->bulan_periode ?? '-'); ?></td>
                        <td style="padding: 15px; text-align: right; font-weight: 700; color: #4AB462;">Rp <?php echo e(number_format($u->jumlah, 0, ',', '.')); ?></td>
                        <td style="padding: 15px; text-align: center;">
                            <button type="button" onclick="bukaModalHapus('<?php echo e(route($role . '.laporan-keuangan.destroy', $u->id)); ?>', '<?php echo e(addslashes($u->nama_murid)); ?> - <?php echo e(addslashes($u->bulan_periode)); ?>')" 
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
        <div style="display: flex; justify-content: space-between; padding: 15px 20px; background: #F9FAFB; border-top: 1px solid #F3F4F6;">
            <span style="font-size: 14px; font-weight: 700; color: #111827;">Total Uang Muka</span>
            <span style="font-size: 15px; font-weight: 800; color: #4AB462;">Rp <?php echo e(number_format($totalUangMuka, 0, ',', '.')); ?></span>
        </div>
    </div>

    
    <button style="width: 100%; background: #6F2DA8; color: white; border: none; padding: 18px; border-radius: 15px; font-size: 16px; font-weight: 700; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 12px; margin-top: 10px; margin-bottom: 20px;" onclick="window.print()">
        <i class="fas fa-file-pdf" style="font-size: 20px;"></i> EXPORT PDF
    </button>

</div>


<div id="modalHapus" style="display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); backdrop-filter: blur(3px); align-items: center; justify-content: center;">
    <div style="background: white; padding: 25px; border-radius: 20px; width: 320px; text-align: center;">
        <div style="color: #E35D5D; font-size: 40px; margin-bottom: 10px;"><i class="fas fa-trash-alt"></i></div>
        <h2 style="margin: 0; font-size: 18px; color: #111827; font-weight: 700;">Hapus Data?</h2>
        <p style="color: #6B7280; font-size: 13px; margin: 8px 0 20px 0;" id="pesanHapus">Apakah Anda yakin ingin menghapus data ini?</p>
        <div style="display: flex; gap: 10px; justify-content: center;">
            <button onclick="tutupModalHapus()" style="flex: 1; padding: 10px; border-radius: 10px; border: 1px solid #E5E7EB; background: white; font-weight: 600; font-size: 13px; cursor: pointer;">Batal</button>
            <form id="formHapus" method="POST" style="flex: 1;">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <button type="submit" style="width: 100%; padding: 10px; border-radius: 10px; border: none; background: #E35D5D; color: white; font-weight: 600; font-size: 13px; cursor: pointer;">Ya, Hapus</button>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('searchInput').addEventListener('keyup', function() {
        let searchValue = this.value.toLowerCase();
        let tbodyIds = ['tbodyPemasukan', 'tbodyPengeluaran', 'tbodyPiutang', 'tbodyUangMuka'];
        
        tbodyIds.forEach(tbodyId => {
            let rows = document.querySelectorAll('#' + tbodyId + ' tr');
            rows.forEach(row => {
                if (row.cells) {
                    let text = '';
                    if (tbodyId === 'tbodyPemasukan' || tbodyId === 'tbodyPengeluaran') {
                        text = row.cells[2]?.innerText.toLowerCase() || '';
                    } else {
                        let namaMurid = row.cells[2]?.innerText.toLowerCase() || '';
                        let bulanPeriode = row.cells[3]?.innerText.toLowerCase() || '';
                        text = namaMurid + ' ' + bulanPeriode;
                    }
                    row.style.display = text.includes(searchValue) ? '' : 'none';
                }
            });
        });
    });

    function bukaModalHapus(url, nama) {
        let form = document.getElementById('formHapus');
        form.action = url;
        
        let pesan = document.getElementById('pesanHapus');
        pesan.innerHTML = `Apakah Anda yakin ingin menghapus data <strong>${nama}</strong>?`;
        
        document.getElementById('modalHapus').style.display = 'flex';
    }

    function tutupModalHapus() {
        document.getElementById('modalHapus').style.display = 'none';
    }

    window.onclick = function(event) {
        const modal = document.getElementById('modalHapus');
        if (event.target === modal) {
            tutupModalHapus();
        }
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\privat-bimbel\resources\views/dashboard/shared/laporan-keuangan/laporan-keuangan.blade.php ENDPATH**/ ?>