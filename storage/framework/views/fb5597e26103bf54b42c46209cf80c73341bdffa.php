
<div style="padding: 25px;">

    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 2px solid #F3E8FF; padding-bottom: 15px;">
        <h3 style="font-size: 18px; font-weight: 700; color: #111827; margin: 0;">
            <i class="fas fa-money-bill-wave" style="color: #4D0B87; margin-right: 8px;"></i> Detail Penggajian
        </h3>
        <button onclick="tutupModalDetailGaji()"
                style="background: #FEE2E2; color: #EF4444; border: none; width: 32px; height: 32px; border-radius: 50%; cursor: pointer; font-size: 16px; display: flex; align-items: center; justify-content: center;">
            <i class="fas fa-times"></i>
        </button>
    </div>

    
    <div style="background: #F9FAFB; border-radius: 12px; padding: 20px; margin-bottom: 20px;">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
            <div>
                <p style="color: #6B7280; font-size: 12px; margin: 0 0 2px 0;">Nama Tentor</p>
                <p style="color: #111827; font-weight: 600; font-size: 15px; margin: 0;"><?php echo e($tentor->nama_lengkap); ?></p>
            </div>
            <div>
                <p style="color: #6B7280; font-size: 12px; margin: 0 0 2px 0;">Periode Gaji</p>
                <p style="color: #111827; font-weight: 600; font-size: 15px; margin: 0;"><?php echo e($namaBulan); ?> <?php echo e($tahun); ?></p>
            </div>
            <div>
                <p style="color: #6B7280; font-size: 12px; margin: 0 0 2px 0;">Mapel</p>
                <p style="color: #111827; font-weight: 600; font-size: 15px; margin: 0;"><?php echo e($tentor->mapel ?? '-'); ?></p>
            </div>
            <div>
                <p style="color: #6B7280; font-size: 12px; margin: 0 0 2px 0;">Grade</p>
                <p style="color: #111827; font-weight: 600; font-size: 15px; margin: 0;"><?php echo e($tentor->grade ?? '-'); ?></p>
            </div>
        </div>
    </div>

    
    <div style="background: #F9FAFB; border-radius: 12px; padding: 20px; margin-bottom: 20px;">
        <h4 style="font-size: 15px; font-weight: 700; color: #111827; margin: 0 0 15px 0;">
            <i class="fas fa-calendar-check" style="color: #4D0B87; margin-right: 6px;"></i> Rincian Honor per Hari
        </h4>

        <div style="overflow-x: auto; border-radius: 10px; border: 1px solid #E5E7EB;">
            <table style="width: 100%; border-collapse: collapse; font-size: 12px; font-family: 'Poppins', sans-serif;">
                <thead>
                    <tr style="background: #F3E8FF;">
                        <th style="padding: 8px 10px; text-align: center;">No</th>
                        <th style="padding: 8px 10px; text-align: center;">Tanggal</th>
                        <th style="padding: 8px 10px; text-align: center;">Hari</th>
                        <th style="padding: 8px 10px; text-align: left;">Murid</th>
                        <th style="padding: 8px 10px; text-align: center;">Status</th>
                        <th style="padding: 8px 10px; text-align: right;">Honor</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $detailPresensi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr style="border-bottom: 1px solid #F3F4F6; <?php echo e($i % 2 == 0 ? 'background: #FAFAFA;' : ''); ?>">
                        <td style="padding: 8px 10px; text-align: center; vertical-align: top;"><?php echo e($i + 1); ?></td>
                        <td style="padding: 8px 10px; text-align: center; vertical-align: top; font-weight: 500;"><?php echo e($d->tanggal); ?></td>
                        <td style="padding: 8px 10px; text-align: center; vertical-align: top; color: #6B7280;"><?php echo e($d->hari); ?></td>
                        <td style="padding: 8px 10px; text-align: left; vertical-align: top;">
                            <?php $__currentLoopData = $d->murid_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div style="margin-bottom: 3px;">
                                    <strong><?php echo e($m['nama_murid']); ?></strong>
                                    <small style="color: #9CA3AF;">(<?php echo e($m['kelas']); ?>)</small>
                                    <br>
                                    <small style="color: <?php echo e($m['status'] == 'Hadir' ? '#10B981' : '#EF4444'); ?>;">
                                        <?php echo e($m['status']); ?>

                                    </small>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </td>
                        <td style="padding: 8px 10px; text-align: center; vertical-align: top;">
                            <?php if($d->status == 'Hadir'): ?>
                                <span style="background:#D1FAE5;color:#065F46;padding:3px 8px;border-radius:20px;font-size:11px;font-weight:600;">Hadir</span>
                            <?php elseif(str_contains($d->status, '50%')): ?>
                                <span style="background:#FEF3C7;color:#92400E;padding:3px 8px;border-radius:20px;font-size:11px;font-weight:600;">Tidak Hadir</span>
                            <?php else: ?>
                                <span style="background:#FEE2E2;color:#991B1B;padding:3px 8px;border-radius:20px;font-size:11px;font-weight:600;">Alpha</span>
                            <?php endif; ?>
                        </td>
                        <td style="padding: 8px 10px; text-align: right; vertical-align: top; font-weight: 600; <?php echo e($d->honor > 0 ? 'color:#10B981;' : 'color:#EF4444;'); ?>">
                            Rp <?php echo e(number_format($d->honor, 0, ',', '.')); ?>

                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
                <tfoot>
                    <tr style="background: #F3E8FF; font-weight: 700;">
                        <td colspan="5" style="padding: 10px; text-align: right;">Total Honor (<?php echo e($hariHadir); ?> Hari)</td>
                        <td style="padding: 10px; text-align: right; color: #4D0B87; font-size: 14px;">Rp <?php echo e(number_format($totalHonor, 0, ',', '.')); ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    
    <div style="background: #F9FAFB; border-radius: 12px; padding: 20px; margin-bottom: 20px;">
        <h4 style="font-size: 15px; font-weight: 700; color: #111827; margin: 0 0 15px 0;">
            <i class="fas fa-calculator" style="color: #4D0B87; margin-right: 6px;"></i> Ringkasan Gaji
        </h4>

        <div style="display: flex; flex-direction: column; gap: 10px;">
            
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px 15px; background: white; border-radius: 8px; border: 1px solid #E5E7EB;">
                <span style="font-weight: 500; color: #374151;">Total Honor</span>
                <span style="font-weight: 700; color: #4D0B87;">Rp <?php echo e(number_format($totalHonor, 0, ',', '.')); ?></span>
            </div>

            
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px 15px; background: white; border-radius: 8px; border: 1px solid #E5E7EB;">
                <div>
                    <span style="font-weight: 500; color: #374151;">Uang Makan</span>
                    <br><small style="color: #9CA3AF;">Rp <?php echo e(number_format($uangMakanPerHari, 0, ',', '.')); ?> × <?php echo e($hariHadir); ?> hari</small>
                </div>
                <span style="font-weight: 700; color: #F59E0B;">Rp <?php echo e(number_format($totalUangMakan, 0, ',', '.')); ?></span>
            </div>

            
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px 15px; background: white; border-radius: 8px; border: 1px solid #E5E7EB;">
                <div>
                    <span style="font-weight: 500; color: #374151;">Uang Transport</span>
                    <br><small style="color: #9CA3AF;">Rp <?php echo e(number_format($uangTransportPerHari, 0, ',', '.')); ?> × <?php echo e($hariHadir); ?> hari</small>
                </div>
                <span style="font-weight: 700; color: #3B82F6;">Rp <?php echo e(number_format($totalUangTransport, 0, ',', '.')); ?></span>
            </div>

            
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 15px; background: #4D0B87; border-radius: 10px; margin-top: 5px;">
                <span style="font-weight: 700; color: white; font-size: 16px;">TOTAL GAJI</span>
                <span style="font-weight: 700; color: white; font-size: 18px;">Rp <?php echo e(number_format($totalGaji, 0, ',', '.')); ?></span>
            </div>

            
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px 15px; background: white; border-radius: 8px; border: 1px solid #E5E7EB;">
                <span style="font-weight: 500; color: #374151;">Status</span>
                <?php if($sudahDibayar): ?>
                    <span style="background:#D1FAE5;color:#065F46;padding:5px 12px;border-radius:20px;font-size:12px;font-weight:600;">✅ Sudah Dibayar</span>
                <?php else: ?>
                    <span style="background:#FEF3C7;color:#92400E;padding:5px 12px;border-radius:20px;font-size:12px;font-weight:600;">⏳ Belum Dibayar</span>
                <?php endif; ?>
            </div>
        </div>
    </div>

    
    <div style="text-align: right; margin-top: 10px;">
        <button onclick="tutupModalDetailGaji()"
                style="background: #E5E7EB; color: #374151; border: none; padding: 10px 24px; border-radius: 10px; cursor: pointer; font-weight: 600; font-size: 13px; font-family: 'Poppins', sans-serif;">
            <i class="fas fa-times"></i> Tutup
        </button>
    </div>

</div><?php /**PATH C:\xampp\htdocs\Privat-Bimbel\resources\views/dashboard/shared/transaksi/detail-penggajian.blade.php ENDPATH**/ ?>