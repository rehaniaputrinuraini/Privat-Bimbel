
<div style="padding: 25px;">
    
    
    <div style="margin-bottom: 20px; padding-bottom: 15px; border-bottom: 2px solid #F3E8FF;">
        <h3 style="font-size: 18px; font-weight: 700; color: #111827; margin: 0;">
            <i class="fas fa-receipt" style="color: #4D0B87; margin-right: 8px;"></i> Detail Pembayaran Murid
        </h3>
    </div>
    
    
    <div style="background: #F9FAFB; border-radius: 12px; padding: 20px; margin-bottom: 20px;">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
            <div>
                <p style="color: #6B7280; font-size: 12px; margin: 0 0 2px 0;">Nama Murid</p>
                <p style="color: #111827; font-weight: 600; font-size: 15px; margin: 0;"><?php echo e($murid->nama_lengkap); ?></p>
            </div>
            <div>
                <p style="color: #6B7280; font-size: 12px; margin: 0 0 2px 0;">Kelas</p>
                <p style="color: #111827; font-weight: 600; font-size: 15px; margin: 0;"><?php echo e($namaKelas); ?></p>
            </div>
            <div>
                <p style="color: #6B7280; font-size: 12px; margin: 0 0 2px 0;">Paket</p>
                <p style="color: #111827; font-weight: 600; font-size: 15px; margin: 0;"><?php echo e($namaPaket); ?></p>
            </div>
            <div>
                <p style="color: #6B7280; font-size: 12px; margin: 0 0 2px 0;">Harga Paket/Bulan</p>
                <p style="color: #111827; font-weight: 600; font-size: 15px; margin: 0;">Rp <?php echo e(number_format($hargaPerBulan, 0, ',', '.')); ?></p>
            </div>
            <div>
                <p style="color: #6B7280; font-size: 12px; margin: 0 0 2px 0;">Total Pembayaran</p>
                <p style="color: #4D0B87; font-weight: 700; font-size: 15px; margin: 0;">Rp <?php echo e(number_format($totalBayar, 0, ',', '.')); ?></p>
            </div>
        </div>
    </div>

    
    <div style="background: #F9FAFB; border-radius: 12px; padding: 20px; margin-bottom: 20px;">
        <h4 style="font-size: 15px; font-weight: 700; color: #111827; margin: 0 0 15px 0;">
            <i class="fas fa-info-circle" style="color: #4D0B87; margin-right: 6px;"></i> Status
        </h4>
        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 12px;">
            
            <div style="text-align: center; padding: 12px; background: white; border-radius: 8px; border: 1px solid #E5E7EB;">
                <p style="color: #6B7280; font-size: 11px; margin: 0 0 4px 0;">Pendaftaran</p>
                <?php if($sudahBayarPendaftaran): ?>
                    <span style="padding:4px 10px;border-radius:20px;background:#D1FAE5;color:#065F46;font-size:11px;font-weight:600;">Lunas</span>
                <?php else: ?>
                    <span style="padding:4px 10px;border-radius:20px;background:#FEE2E2;color:#EF4444;font-size:11px;font-weight:600;">Belum</span>
                <?php endif; ?>
            </div>
            
            <div style="text-align: center; padding: 12px; background: white; border-radius: 8px; border: 1px solid #E5E7EB;">
                <p style="color: #6B7280; font-size: 11px; margin: 0 0 4px 0;">Pembayaran SPP</p>
                <span style="padding:4px 10px;border-radius:20px;background:#D1FAE5;color:#065F46;font-size:11px;font-weight:600;"><?php echo e($jumlahBayarSPP ?? 0); ?>x Bayar</span>
            </div>
            
            <div style="text-align: center; padding: 12px; background: white; border-radius: 8px; border: 1px solid #E5E7EB;">
                <p style="color: #6B7280; font-size: 11px; margin: 0 0 4px 0;">Status Tagihan</p>
                <?php if($statusTagihan == 'Lunas'): ?>
                    <span style="padding:4px 10px;border-radius:20px;background:#D1FAE5;color:#065F46;font-size:11px;font-weight:600;">Lunas</span>
                <?php elseif($statusTagihan == 'Uang Muka'): ?>
                    <span style="padding:4px 10px;border-radius:20px;background:#E0E7FF;color:#4338CA;font-size:11px;font-weight:600;">Uang Muka</span>
                <?php elseif($statusTagihan == 'Tunggak'): ?>
                    <span style="padding:4px 10px;border-radius:20px;background:#FEF3C7;color:#92400E;font-size:11px;font-weight:600;">Tunggak</span>
                <?php else: ?>
                    <span style="padding:4px 10px;border-radius:20px;background:#FEE2E2;color:#991B1B;font-size:11px;font-weight:600;">Belum Daftar</span>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    
    <h4 style="font-size: 15px; font-weight: 700; color: #111827; margin: 0 0 12px 0;">
        <i class="fas fa-history" style="color: #4D0B87; margin-right: 6px;"></i> Riwayat Pembayaran
    </h4>
    
    <?php if($riwayatPembayaran->count() > 0): ?>
        <div style="overflow-x: auto; border-radius: 12px; border: 1px solid #E5E7EB;">
            <table style="width: 100%; border-collapse: collapse; font-size: 13px; font-family: 'Poppins', sans-serif;">
                <thead>
                    <tr style="background: #F3E8FF;">
                        <th style="padding: 10px 14px; text-align: center;">No</th>
                        <th style="padding: 10px 14px; text-align: left;">Tanggal</th>
                        <th style="padding: 10px 14px; text-align: left;">Jenis</th>
                        <th style="padding: 10px 14px; text-align: right;">Jumlah</th>
                        <th style="padding: 10px 14px; text-align: left;">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $riwayatPembayaran; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr style="border-bottom: 1px solid #F3F4F6; <?php echo e($i % 2 == 0 ? 'background: #FAFAFA;' : ''); ?>">
                        <td style="padding: 10px 14px; text-align: center;"><?php echo e($i + 1); ?></td>
                        <td style="padding: 10px 14px;"><?php echo e($r->tanggal); ?></td>
                        <td style="padding: 10px 14px;"><?php echo e($r->jenis_pembayaran); ?></td>
                        <td style="padding: 10px 14px; text-align: right; font-weight: 600; color: #10B981;"><?php echo e($r->jumlah); ?></td>
                        <td style="padding: 10px 14px; color: #6B7280;"><?php echo e($r->keterangan); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div style="text-align: center; padding: 30px; color: #9CA3AF; font-size: 14px;">
            <i class="fas fa-inbox" style="font-size: 32px; display: block; margin-bottom: 8px; opacity: .4;"></i>
            Belum ada riwayat pembayaran
        </div>
    <?php endif; ?>
    
    
    <div style="text-align: right; margin-top: 20px;">
        <button onclick="tutupModalDetail()" 
                style="padding: 11px 40px; border: 1.5px solid #4D0B87; color: #4D0B87; border-radius: 10px; font-weight: 600; font-size: 15px; background: #FFFFFF; cursor: pointer; font-family: 'Poppins', sans-serif;">
            Tutup
        </button>
    </div>
    
</div><?php /**PATH C:\xampp\htdocs\Privat-Bimbel\resources\views/dashboard/shared/transaksi/detail-pembayaran.blade.php ENDPATH**/ ?>