

<?php $__env->startSection('title', 'Riwayat Presensi'); ?>

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

    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; gap: 15px;">
        <div style="display: flex; align-items: center; gap: 12px; flex: 1;">
            
            <div style="position: relative; width: 300px;">
                <i class="fas fa-search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #9CA3AF;"></i>
                <input type="text" placeholder="Cari Nama Tentor..." 
                       style="width: 100%; padding: 10px 15px 10px 45px; border-radius: 12px; border: 1px solid #E5E7EB; outline: none; background: white; font-size: 14px; color: #374151;">
            </div>

            
            <select style="padding: 10px 12px; border-radius: 12px; border: 1px solid #E5E7EB; color: #374151; font-size: 13px; min-width: 140px; background: white; outline: none; cursor: pointer;">
                <option value="">--- Pilih Bulan ---</option>
                <option value="1">Januari</option>
                <option value="2">Februari</option>
                <option value="3" selected>Maret</option>
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

            
            <select style="padding: 10px 12px; border-radius: 12px; border: 1px solid #E5E7EB; color: #374151; font-size: 13px; min-width: 100px; background: white; outline: none; cursor: pointer;">
                <option value="">--- Tahun ---</option>
                <option value="2024">2024</option>
                <option value="2025">2025</option>
                <option value="2026" selected>2026</option>
            </select>
        </div>
    </div>

    
    <div style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.08); border: 1px solid #F3F4F6;">
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 13px; white-space: nowrap;">
                <thead>
                    <tr style="background: #F3E8FF; color: #111827;">
                        <th style="padding: 15px; font-weight: 700; width: 50px;">No</th>
                        <th style="padding: 15px; font-weight: 700;">Nama Tentor</th>
                        <th style="padding: 15px; font-weight: 700;">Tanggal</th>
                        <th style="padding: 15px; font-weight: 700;">Jam Masuk</th>
                        <th style="padding: 15px; font-weight: 700;">Jam Keluar</th>
                        <th style="padding: 15px; font-weight: 700;">Kelas</th>
                        <th style="padding: 15px; font-weight: 700; text-align: center;">Status</th>
                        <th style="padding: 15px; font-weight: 700;">Honor</th>
                        <th style="padding: 15px; font-weight: 700;">Makan</th>
                        <th style="padding: 15px; font-weight: 700;">Transport</th>
                        <th style="padding: 15px; font-weight: 700; text-align: center;">Bukti</th>
                        <th style="padding: 15px; font-weight: 700; text-align: center;">Verifikasi</th>
                        <th style="padding: 15px; font-weight: 700; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody style="color: #374151;">
                    <?php
                        $presensi = [
                            ['no' => 1, 'nama' => 'Sari Putri', 'tgl' => '09 Mar 2026', 'jam_masuk' => '14:00', 'jam_keluar' => '17:00', 'kelas' => '9A', 'status' => 'Hadir', 'honor' => '30.000', 'makan' => '10.000', 'transport' => '10.000', 'verif' => false],
                            ['no' => 2, 'nama' => 'Dwi Rahayu', 'tgl' => '10 Mar 2026', 'jam_masuk' => '14:00', 'jam_keluar' => '-', 'kelas' => '9A', 'status' => 'Tidak Hadir', 'honor' => '15.000', 'makan' => '-', 'transport' => '10.000', 'verif' => true],
                            ['no' => 3, 'nama' => 'Rahma Tyas', 'tgl' => '11 Mar 2026', 'jam_masuk' => '14:00', 'jam_keluar' => '17:00', 'kelas' => '9A', 'status' => 'Hadir', 'honor' => '30.000', 'makan' => '10.000', 'transport' => '-', 'verif' => true],
                        ];
                    ?>

                    <?php $__currentLoopData = $presensi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr style="border-bottom: 1px solid #F3F4F6; transition: 0.2s;" onmouseover="this.style.background='#F9FAFB'" onmouseout="this.style.background='transparent'">
                        <td style="padding: 15px;"><?php echo e($p['no']); ?></td>
                        <td style="padding: 15px;"><?php echo e($p['nama']); ?></td>   
                        <td style="padding: 15px;"><?php echo e($p['tgl']); ?></td>
                        <td style="padding: 15px;"><?php echo e($p['jam_masuk']); ?></td>
                        <td style="padding: 15px;"><?php echo e($p['jam_keluar']); ?></td>
                        <td style="padding: 15px;"><?php echo e($p['kelas']); ?></td>
                        <td style="padding: 15px; text-align: center;">
                            <span style="padding: 5px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; 
                                background: <?php echo e($p['status'] == 'Hadir' ? '#E1F7E3' : '#FEE2E2'); ?>; 
                                color: <?php echo e($p['status'] == 'Hadir' ? '#0E7490' : '#EF4444'); ?>;">
                                <?php echo e($p['status']); ?>

                            </span>
                        </td>
                        <td style="padding: 15px;">Rp <?php echo e($p['honor']); ?></td>
                        <td style="padding: 15px;"><?php echo e($p['makan'] == '-' ? '-' : 'Rp '.$p['makan']); ?></td>
                        <td style="padding: 15px;"><?php echo e($p['transport'] == '-' ? '-' : 'Rp '.$p['transport']); ?></td>
                        <td style="padding: 15px; text-align: center;">
                            <button title="Download Bukti" style="background: #F3E8FF; border: none; color: #4D0B87; width: 32px; height: 32px; border-radius: 8px; cursor: pointer;">
                                <i class="fas fa-file-download"></i>
                            </button>
                        </td>
                        <td style="padding: 15px; text-align: center;">
                            <input type="checkbox" <?php echo e($p['verif'] ? 'checked' : ''); ?> 
                                   style="accent-color: #4D0B87; width: 18px; height: 18px; cursor: pointer;">
                        </td>
                        <td style="padding: 15px; text-align: center;">
                            <button type="button" onclick="return confirm('Hapus data presensi <?php echo e($p['nama']); ?> tanggal <?php echo e($p['tgl']); ?>?')" 
                                    style="background: #E35D5D; color: white; padding: 6px 12px; border-radius: 6px; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 5px; font-size: 12px;">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
    
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px; padding: 0 5px;">
        <div style="display: flex; align-items: center; gap: 10px;">
            <select style="padding: 8px 12px; border-radius: 10px; border: 1px solid #E5E7EB; color: #374151; font-size: 13px; background: white; outline: none; cursor: pointer;">
                <option value="10">10 baris</option>
                <option value="25">25 baris</option>
                <option value="50">50 baris</option>
            </select>
            <span style="color: #374151; font-size: 13px;">Menampilkan <?php echo e(count($presensi)); ?> data</span>
        </div>

        <div style="display: flex; gap: 5px;">
            <button style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; cursor: pointer;"><i class="fas fa-angle-double-left"></i></button>
            <button style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; cursor: pointer;"><i class="fas fa-angle-left"></i></button>
            <button style="width: 35px; height: 35px; border-radius: 8px; background: #4D0B87; color: white; border: none; font-weight: 600; cursor: pointer;">1</button>
            <button style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; cursor: pointer;"><i class="fas fa-angle-right"></i></button>
        </div>
    </div>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Privat-Bimbel\resources\views/dashboard/shared/riwayat presensi/riwayat-presensi.blade.php ENDPATH**/ ?>