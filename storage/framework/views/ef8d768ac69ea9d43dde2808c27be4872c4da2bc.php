

<?php $__env->startSection('title', 'Riwayat Presensi'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .table thead th {
        white-space: nowrap;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div style="width: 100%;">
    
    
    <div style="margin-bottom: 25px;">
        <p style="color: #374151; font-size: 13px; margin: 0 0 4px 0;">
            <?php echo e(\Carbon\Carbon::now()->translatedFormat('F Y')); ?>

        </p>
        <h1 style="font-size: 26px; font-weight: 700; color: #111827; margin: 0; letter-spacing: -0.5px; line-height: 1.2;">
            Riwayat Presensi
        </h1>
        <p style="color: #374151; font-size: 14px; margin: 4px 0 0 0;">Lihat Riwayat Presensi Semua Tentor</p>
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

    
    <form method="GET" action="<?php echo e(route($role . '.kelola-presensi')); ?>" id="filterForm">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; gap: 15px;">
            <div style="display: flex; align-items: center; gap: 12px; flex: 1; flex-wrap: wrap;">
                
                
                <div style="position: relative; width: 300px;">
                    <i class="fas fa-search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #9CA3AF;"></i>
                    <input type="text" id="liveSearchInput" placeholder="Cari Nama Tentor..."
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
                    <?php $__currentLoopData = $tahunList ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $th): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($th); ?>" <?php echo e(($tahun ?? '') == $th ? 'selected' : ''); ?>><?php echo e($th); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                
                
                <?php if(($bulan ?? '') || ($tahun ?? '')): ?>
                    <a href="<?php echo e(route($role . '.kelola-presensi')); ?>" style="padding: 10px 15px; border-radius: 12px; background: #F3F4F6; color: #374151; text-decoration: none; font-size: 13px;">
                        <i class="fas fa-times"></i> Reset
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </form>

    
    <div style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.08); border: 1px solid #F3F4F6;">
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 13px; white-space: nowrap;">
                <thead>
                    <tr style="background: #F3E8FF; color: #111827;">
                        <th style="padding: 15px; font-weight: 700; width: 40px;">No</th>
                        <th style="padding: 15px; font-weight: 700;">Nama Tentor</th>
                        <th style="padding: 15px; font-weight: 700;">Tanggal</th>
                        <th style="padding: 15px; font-weight: 700;">Masuk</th>
                        <th style="padding: 15px; font-weight: 700;">Keluar</th>
                        <th style="padding: 15px; font-weight: 700;">Kelas</th>
                        <th style="padding: 15px; font-weight: 700;">Jenjang</th>
                        <th style="padding: 15px; font-weight: 700; text-align: center;">Status Kehadiran Murid</th>
                        <th style="padding: 15px; font-weight: 700; text-align: right;">Honor Dasar</th>
                        <th style="padding: 15px; font-weight: 700; text-align: center;">Potongan</th>
                        <th style="padding: 15px; font-weight: 700; text-align: right;">Honor Akhir</th>
                        <th style="padding: 15px; font-weight: 700; text-align: right;">Uang Makan</th>
                        <th style="padding: 15px; font-weight: 700; text-align: right;">Transport</th>
                        <th style="padding: 15px; font-weight: 700; text-align: right;">Total Honor</th>
                        <th style="padding: 15px; font-weight: 700; text-align: center;">Ket</th>
                        <th style="padding: 15px; font-weight: 700; text-align: center;">Foto</th>
                        <th style="padding: 15px; font-weight: 700; text-align: center;">Verif</th>
                        <th style="padding: 15px; font-weight: 700; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tableBody" style="color: #374151;">
                    <?php $__empty_1 = true; $__currentLoopData = $presensi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $statusText = $item->status_murid == 'hadir' ? 'Hadir' : 'Tidak Hadir';
                        $statusClass = $item->status_murid == 'hadir' 
                            ? 'background: #E1F7E3; color: #0E7490;' 
                            : 'background: #FEE2E2; color: #EF4444;';
                        $jamMasuk = $item->jam_masuk ? \Carbon\Carbon::parse($item->jam_masuk)->format('H:i') : '-';
                        $jamKeluar = $item->jam_keluar ? \Carbon\Carbon::parse($item->jam_keluar)->format('H:i') : '-';
                        
                        $honorPerJam = 0;
                        switch ($item->jenjang) {
                            case 'SD':
                                $honorPerJam = $item->tentor->hr_sd ?? 90000;
                                break;
                            case 'SMP':
                                $honorPerJam = $item->tentor->hr_smp ?? 100000;
                                break;
                            case 'SMA':
                                $honorPerJam = $item->tentor->hr_sma ?? 110000;
                                break;
                        }
                        
                        $jamMengajar = $item->jam_mengajar ?? 1;
                        $honorDasar = $honorPerJam * $jamMengajar;
                        
                        if ($item->status_murid == 'tidak hadir') {
                            $potongan = $honorDasar * 0.5;
                            $honorAkhir = $honorDasar * 0.5;
                        } else {
                            $potongan = 0;
                            $honorAkhir = $honorDasar;
                        }
                        
                        $uangMakan = $item->tentor->uang_makan ?? 0;
                        $transport = $item->tentor->uang_transport ?? 0;
                        $totalHonorItem = $honorAkhir + $uangMakan + $transport;
                    ?>
                    <tr style="border-bottom: 1px solid #F3F4F6; transition: 0.2s;" onmouseover="this.style.background='#F9FAFB'" onmouseout="this.style.background='transparent'">
                        <td style="padding: 15px;"><?php echo e($presensi->firstItem() + $index); ?></td>
                        <td style="padding: 15px;"><?php echo e($item->tentor->nama_lengkap_tentor ?? '-'); ?></td>
                        <td style="padding: 15px;"><?php echo e(\Carbon\Carbon::parse($item->tanggal)->format('d/m/Y')); ?></td>
                        <td style="padding: 15px;"><?php echo e($jamMasuk); ?></td>
                        <td style="padding: 15px;"><?php echo e($jamKeluar); ?></td>
                        <td style="padding: 15px;"><?php echo e($item->kelas ?? '-'); ?></td>
                        <td style="padding: 15px;"><?php echo e($item->jenjang ?? '-'); ?></td>
                        <td style="padding: 15px; text-align: center;">
                            <span style="padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; <?php echo e($statusClass); ?>">
                                <?php echo e($statusText); ?>

                            </span>
                        </td>
                        <td style="padding: 15px; text-align: right;">Rp <?php echo e(number_format($honorDasar, 0, ',', '.')); ?></td>
                        <td style="padding: 15px; text-align: center;">
                            <?php if($item->status_murid == 'tidak hadir'): ?>
                                <span style="color: #EF4444; font-size: 11px;">-50%</span>
                                <br>
                                <span style="color: #EF4444; font-size: 11px;">(Rp <?php echo e(number_format($potongan, 0, ',', '.')); ?>)</span>
                            <?php else: ?>
                                <span style="color: #10B981;">-</span>
                            <?php endif; ?>
                        </td>
                        <td style="padding: 15px; text-align: right; font-weight: 600; color: #4D0B87;">Rp <?php echo e(number_format($honorAkhir, 0, ',', '.')); ?></td>
                        <td style="padding: 15px; text-align: right;">Rp <?php echo e(number_format($uangMakan, 0, ',', '.')); ?></td>
                        <td style="padding: 15px; text-align: right;">Rp <?php echo e(number_format($transport, 0, ',', '.')); ?></td>
                        <td style="padding: 15px; text-align: right; font-weight: 700; color: #111827;">Rp <?php echo e(number_format($totalHonorItem, 0, ',', '.')); ?></td>
                        <td style="padding: 15px; text-align: center; max-width: 100px; overflow: hidden; text-overflow: ellipsis;" title="<?php echo e($item->keterangan ?? ''); ?>">
                            <?php echo e(Str::limit($item->keterangan, 10) ?? '-'); ?>

                        </td>
                        <td style="padding: 15px; text-align: center;">
                            <?php if($item->bukti_foto): ?>
                                <a href="<?php echo e(route($role . '.kelola-presensi.download', $item->id_presensi)); ?>" 
                                   style="background: #F3E8FF; color: #4D0B87; width: 30px; height: 30px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; text-decoration: none;">
                                    <i class="fas fa-download"></i>
                                </a>
                            <?php else: ?>
                                <span style="color: #9CA3AF;">-</span>
                            <?php endif; ?>
                        </td>
                        <td style="padding: 15px; text-align: center;">
                            <?php if($role == 'superadmin' || $role == 'admin'): ?>
                                <form method="POST" action="<?php echo e(route($role . '.kelola-presensi.' . ($item->verifikasi_kehadiran ? 'unverify' : 'verify'), $item->id_presensi)); ?>" style="display: inline;">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" style="background: none; border: none; cursor: pointer;">
                                        <input type="checkbox" <?php echo e($item->verifikasi_kehadiran ? 'checked' : ''); ?> 
                                               style="accent-color: #4D0B87; width: 18px; height: 18px; pointer-events: none;">
                                    </button>
                                </form>
                            <?php else: ?>
                                <input type="checkbox" <?php echo e($item->verifikasi_kehadiran ? 'checked' : ''); ?> 
                                       style="accent-color: #4D0B87; width: 18px; height: 18px;" disabled>
                            <?php endif; ?>
                        </td>
                        <td style="padding: 15px; text-align: center;">
                            <?php if($role == 'superadmin'): ?>
                                <button type="button" 
                                        onclick="bukaModalHapus(<?php echo e($item->id_presensi); ?>, '<?php echo e(addslashes($item->tentor->nama_lengkap_tentor ?? 'Tentor')); ?>', '<?php echo e(\Carbon\Carbon::parse($item->tanggal)->format('d F Y')); ?>')" 
                                        style="background: #E35D5D; color: white; padding: 6px 10px; border-radius: 6px; border: none; cursor: pointer; font-size: 11px;">
                                    <i class="fas fa-trash"></i>
                                </button>
                            <?php else: ?>
                                <span style="color: #9CA3AF; font-size: 11px;">-</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="18" style="padding: 40px; text-align: center; color: #9CA3AF;">
                            <i class="fas fa-calendar-alt" style="font-size: 40px; margin-bottom: 10px; display: block;"></i>
                            Belum ada data presensi
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    
    <?php if($presensi->count() > 0): ?>
    <div style="padding: 15px 30px; display: flex; justify-content: flex-end; align-items: center; background: #F9FAFB; border-top: 2px solid #F3F4F6; border-radius: 0 0 20px 20px;">
        <span style="font-size: 15px; font-weight: 700; color: #374151; margin-right: 15px;">Total Honor Bulan Ini :</span>
        <div style="background: #10B981; color: white; padding: 10px 25px; border-radius: 12px; font-size: 17px; font-weight: 800; box-shadow: 0 4px 10px rgba(16, 185, 129, 0.2);">
            Rp <?php echo e(number_format($totalHonor ?? 0, 0, ',', '.')); ?>

        </div>
    </div>
    <?php endif; ?>

    
    <?php if($presensi->count() > 0): ?>
    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px; padding: 0 5px;">
        <div style="display: flex; align-items: center; gap: 10px;">
            <select id="perPageSelect" style="padding: 8px 12px; border-radius: 10px; border: 1px solid #E5E7EB; color: #374151; font-size: 13px; background: white; outline: none; cursor: pointer;">
                <option value="10" <?php echo e(request('perPage', 10) == 10 ? 'selected' : ''); ?>>10 baris</option>
                <option value="25" <?php echo e(request('perPage', 10) == 25 ? 'selected' : ''); ?>>25 baris</option>
                <option value="50" <?php echo e(request('perPage', 10) == 50 ? 'selected' : ''); ?>>50 baris</option>
            </select>
            <span style="color: #374151; font-size: 13px;">
                Menampilkan <?php echo e($presensi->total()); ?> data
            </span>
        </div>

        <div style="display: flex; gap: 5px;">
            <?php if($presensi->onFirstPage()): ?>
                <button style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: #F3F4F6; color: #9CA3AF; cursor: not-allowed;" disabled>
                    <i class="fas fa-angle-double-left"></i>
                </button>
            <?php else: ?>
                <a href="<?php echo e($presensi->url(1)); ?>&<?php echo e(http_build_query(request()->except('page'))); ?>" 
                   style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; display: flex; align-items: center; justify-content: center; text-decoration: none;">
                    <i class="fas fa-angle-double-left"></i>
                </a>
            <?php endif; ?>

            <?php if($presensi->onFirstPage()): ?>
                <button style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: #F3F4F6; color: #9CA3AF; cursor: not-allowed;" disabled>
                    <i class="fas fa-angle-left"></i>
                </button>
            <?php else: ?>
                <a href="<?php echo e($presensi->previousPageUrl()); ?>&<?php echo e(http_build_query(request()->except('page'))); ?>" 
                   style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; display: flex; align-items: center; justify-content: center; text-decoration: none;">
                    <i class="fas fa-angle-left"></i>
                </a>
            <?php endif; ?>

            <button style="width: 35px; height: 35px; border-radius: 8px; background: #4D0B87; color: white; border: none; font-weight: 600; cursor: default;">
                <?php echo e($presensi->currentPage()); ?>

            </button>

            <?php if($presensi->hasMorePages()): ?>
                <a href="<?php echo e($presensi->nextPageUrl()); ?>&<?php echo e(http_build_query(request()->except('page'))); ?>" 
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


<div id="modalHapus" style="display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); backdrop-filter: blur(3px); align-items: center; justify-content: center;">
    <div style="background: white; padding: 25px; border-radius: 20px; width: 320px; text-align: center; box-shadow: 0 15px 30px rgba(0,0,0,0.15); font-family: 'Poppins', sans-serif;">
        <div style="color: #E35D5D; font-size: 40px; margin-bottom: 10px;"><i class="fas fa-trash-alt"></i></div>
        <h2 style="margin: 0; font-size: 18px; color: #111827; font-weight: 700;">Hapus Data?</h2>
        <p style="color: #6B7280; font-size: 13px; margin: 8px 0 20px 0;" id="pesanHapus">Apakah Anda yakin ingin menghapus data presensi ini?</p>
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
    // Live Search
    const liveSearchInput = document.getElementById('liveSearchInput');
    const tableBody = document.getElementById('tableBody');
    
    liveSearchInput?.addEventListener('keyup', function() {
        const searchValue = this.value.toLowerCase();
        const rows = tableBody.querySelectorAll('tr');
        
        rows.forEach(row => {
            if (row.cells && row.cells.length >= 2) {
                const nama = row.cells[1]?.innerText.toLowerCase() || '';
                if (nama.includes(searchValue)) {
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

    function bukaModalHapus(id, nama, tanggal) {
        let form = document.getElementById('formHapus');
        let url = "<?php echo e(route('superadmin.kelola-presensi.destroy', ':id')); ?>";
        url = url.replace(':id', id);
        form.action = url;
        
        let pesan = document.getElementById('pesanHapus');
        pesan.innerHTML = `Apakah Anda yakin ingin menghapus data presensi <strong>${nama}</strong><br>tanggal <strong>${tanggal}</strong>?`;
        
        document.getElementById('modalHapus').style.display = 'flex';
    }

    function tutupModalHapus() {
        document.getElementById('modalHapus').style.display = 'none';
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Privat-Bimbel\resources\views/dashboard/shared/riwayat presensi/riwayat-presensi.blade.php ENDPATH**/ ?>