



<?php $__env->startSection('title', 'Rekap Gaji Tentor'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .filter-select {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%239CA3AF' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 14px center;
        padding-right: 38px !important;
        appearance: none;
        -webkit-appearance: none;
    }
    
    .status-badge {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        display: inline-block;
    }
    
    .status-sudah {
        background: #E1F7E3;
        color: #0E7490;
    }
    
    .status-belum {
        background: #FEF3C7;
        color: #92400E;
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
            Rekap Gaji Tentor
        </h1>
        <p style="color: #374151; font-size: 14px; margin: 4px 0 0 0;">Kelola dan Cetak Slip Gaji Bulanan</p>
    </div>

    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; gap: 15px; flex-wrap: wrap;">
        <div style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">

            
            <div style="position: relative; width: 250px;">
                <i class="fas fa-search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #9CA3AF;"></i>
                <input type="text" id="searchTentor" placeholder="Cari Nama Tentor..."
                       style="width: 100%; padding: 10px 15px 10px 45px; border-radius: 12px; border: 1px solid #E5E7EB; outline: none; background: white; font-size: 14px; color: #374151;">
            </div>

            
            <select id="filterStatusGaji" class="filter-select" style="padding: 10px 14px; border-radius: 12px; border: 1px solid #E5E7EB; color: #374151; font-size: 13px; min-width: 160px; background: white; outline: none; cursor: pointer;">
                <option value="">Semua Status</option>
                <option value="sudah">Sudah Dibayar</option>
                <option value="belum">Belum Dibayar</option>
            </select>

            
            <select class="filter-select" style="padding: 10px 14px; border-radius: 12px; border: 1px solid #E5E7EB; color: #374151; font-size: 13px; min-width: 140px; background: white; outline: none; cursor: pointer;">
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

            
            <select class="filter-select" style="padding: 10px 14px; border-radius: 12px; border: 1px solid #E5E7EB; color: #374151; font-size: 13px; min-width: 110px; background: white; outline: none; cursor: pointer;">
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
                        <th style="padding: 15px; font-weight: 700; text-align: center; width: 50px;">No</th>
                        <th style="padding: 15px; font-weight: 700;">Nama Tentor</th>
                        <th style="padding: 15px; font-weight: 700;">Hadir</th>
                        <th style="padding: 15px; font-weight: 700;">Honor</th>
                        <th style="padding: 15px; font-weight: 700;">Uang Makan</th>
                        <th style="padding: 15px; font-weight: 700;">Transport</th>
                        <th style="padding: 15px; font-weight: 700;">Total Gaji</th>
                        <th style="padding: 15px; font-weight: 700; text-align: center;">Status</th>
                        <th style="padding: 15px; font-weight: 700; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody style="color: #374151;">
                    <?php
                        $gajis = [
                            ['no' => 1, 'nama' => 'Mas Alvin',     'hadir' => '12 Kali', 'honor' => '1.700.000', 'makan' => '1.700.000', 'trans' => '1.700.000', 'total' => '5.100.000', 'status' => 'belum'],
                            ['no' => 2, 'nama' => 'Rehania Putri', 'hadir' => '6 Kali',  'honor' => '800.000',   'makan' => '800.000',   'trans' => '800.000',   'total' => '2.400.000', 'status' => 'sudah'],
                            ['no' => 3, 'nama' => 'Budi Santoso',  'hadir' => '8 Kali',  'honor' => '1.200.000', 'makan' => '1.200.000', 'trans' => '1.200.000', 'total' => '3.600.000', 'status' => 'belum'],
                        ];
                    ?>

                    <?php $__currentLoopData = $gajis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr style="border-bottom: 1px solid #F3F4F6; transition: 0.2s;"
                        onmouseover="this.style.background='#F9FAFB'"
                        onmouseout="this.style.background='transparent'">
                        <td style="padding: 15px; text-align: center;"><?php echo e($g['no']); ?></td>
                        <td style="padding: 15px; font-weight: 500;"><?php echo e($g['nama']); ?></td>
                        <td style="padding: 15px;"><?php echo e($g['hadir']); ?></td>
                        <td style="padding: 15px;">Rp <?php echo e($g['honor']); ?></td>
                        <td style="padding: 15px;">Rp <?php echo e($g['makan']); ?></td>
                        <td style="padding: 15px;">Rp <?php echo e($g['trans']); ?></td>
                        <td style="padding: 15px; font-weight: 700; color: #4D0B87;">Rp <?php echo e($g['total']); ?></td>
                        
                        
                        <td style="padding: 15px; text-align: center;">
                            <?php if($g['status'] == 'sudah'): ?>
                                <span class="status-badge status-sudah"><i class="fas fa-check-circle" style="margin-right: 5px;"></i> Sudah Dibayar</span>
                            <?php else: ?>
                                <span class="status-badge status-belum"><i class="fas fa-clock" style="margin-right: 5px;"></i> Belum Dibayar</span>
                            <?php endif; ?>
                        </td>
                        
                        
                        <td style="padding: 15px;">
                            <div style="display: flex; gap: 8px; justify-content: center;">
                                
                                
                                <button title="Cetak Slip Gaji"
                                        style="background: #5EB37E; color: white; padding: 8px 12px; border-radius: 8px; border: none; cursor: pointer; display: flex; align-items: center; gap: 5px; font-size: 12px; font-weight: 600; transition: 0.2s;"
                                        onmouseover="this.style.background='#4A9E6A'"
                                        onmouseout="this.style.background='#5EB37E'">
                                    <i class="fas fa-file-invoice"></i> SLIP
                                </button>
                                
                                
                                <?php if($g['status'] == 'belum'): ?>
                                <button title="Bayar Gaji"
                                        onclick="bukaModalBayar('<?php echo e($g['nama']); ?>', '<?php echo e($g['total']); ?>')"
                                        style="background: #4D0B87; color: white; padding: 8px 12px; border-radius: 8px; border: none; cursor: pointer; display: flex; align-items: center; gap: 5px; font-size: 12px; font-weight: 600; transition: 0.2s;"
                                        onmouseover="this.style.background='#3B0868'"
                                        onmouseout="this.style.background='#4D0B87'">
                                    <i class="fas fa-money-bill-wave"></i> BAYAR
                                </button>
                                <?php endif; ?>
                                
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>

        
        <div style="padding: 20px 30px; display: flex; justify-content: space-between; align-items: center; background: #F9FAFB; border-top: 2px solid #F3F4F6;">
            <span style="font-size: 15px; font-weight: 700; color: #374151;">Total Pengeluaran Gaji Bulan Ini :</span>
            <div style="background: #10B981; color: white; padding: 10px 25px; border-radius: 12px; font-size: 17px; font-weight: 800; box-shadow: 0 4px 10px rgba(16, 185, 129, 0.2);">
                Rp 7.500.000
            </div>
        </div>
    </div>

    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px; padding: 0 5px;">
        <div style="display: flex; align-items: center; gap: 10px;">
            <select class="filter-select" style="padding: 8px 12px; border-radius: 10px; border: 1px solid #E5E7EB; color: #374151; font-size: 13px; background: white; outline: none; cursor: pointer; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                <option value="10">10 baris</option>
                <option value="25">25 baris</option>
                <option value="50">50 baris</option>
            </select>
            <span style="color: #374151; font-size: 13px;">Menampilkan <?php echo e(count($gajis)); ?> data</span>
        </div>
        <div style="display: flex; gap: 5px;">
            <button style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; cursor: pointer;"><i class="fas fa-angle-double-left"></i></button>
            <button style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; cursor: pointer;"><i class="fas fa-angle-left"></i></button>
            <button style="width: 35px; height: 35px; border-radius: 8px; background: #4D0B87; color: white; border: none; font-weight: 600; cursor: pointer;">1</button>
            <button style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; cursor: pointer;"><i class="fas fa-angle-right"></i></button>
        </div>
    </div>

</div>


<div id="modalBayarGaji" style="display: none; position: fixed; z-index: 99999; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); backdrop-filter: blur(3px); align-items: center; justify-content: center;">
    <div style="background: white; padding: 30px; border-radius: 24px; width: 400px; text-align: center; box-shadow: 0 20px 40px rgba(0,0,0,0.15);">
        <div style="color: #4D0B87; font-size: 50px; margin-bottom: 15px;">
            <i class="fas fa-hand-holding-usd"></i>
        </div>
        <h2 style="margin: 0 0 10px 0; font-size: 20px; font-weight: 700; color: #111827;">Konfirmasi Pembayaran Gaji</h2>
        <p style="color: #6B7280; font-size: 14px; margin: 0 0 20px 0;" id="modalText">
            Apakah Anda ingin membayar gaji <strong id="namaTentorModal">Mas Alvin</strong> sebesar <strong id="totalGajiModal">Rp 5.100.000</strong>?
        </p>
        <p style="color: #92400E; font-size: 13px; margin: 0 0 20px 0; background: #FEF3C7; padding: 10px; border-radius: 10px;">
            <i class="fas fa-info-circle"></i> Total uang kas akan berkurang dan tercatat di pengeluaran.
        </p>
        <div style="display: flex; gap: 12px; justify-content: center;">
            <button onclick="tutupModalBayar()" 
                    style="flex: 1; padding: 12px; border-radius: 12px; border: 1px solid #E5E7EB; background: white; color: #374151; font-weight: 600; font-size: 14px; cursor: pointer;">
                Batal
            </button>
            <button onclick="prosesBayarGaji()" 
                    style="flex: 1; padding: 12px; border-radius: 12px; border: none; background: #10B981; color: white; font-weight: 600; font-size: 14px; cursor: pointer;">
                <i class="fas fa-check"></i> Ya, Bayar
            </button>
        </div>
    </div>
</div>

<script>
    // Variabel sementara untuk menyimpan data yang akan dibayar
    let selectedNama = '';
    let selectedTotal = '';
    
    function bukaModalBayar(nama, total) {
        selectedNama = nama;
        selectedTotal = total;
        document.getElementById('namaTentorModal').innerText = nama;
        document.getElementById('totalGajiModal').innerText = 'Rp ' + total;
        document.getElementById('modalBayarGaji').style.display = 'flex';
    }
    
    function tutupModalBayar() {
        document.getElementById('modalBayarGaji').style.display = 'none';
    }
    
    function prosesBayarGaji() {
        // Nanti diisi logic backend
        alert('Logic backend akan ditambahkan minggu depan!\n\n' + selectedNama + ' - Rp ' + selectedTotal);
        tutupModalBayar();
    }
    
    // Tutup modal kalau klik di luar
    window.onclick = function(event) {
        const modal = document.getElementById('modalBayarGaji');
        if (event.target == modal) {
            tutupModalBayar();
        }
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\privat-bimbel\resources\views/dashboard/shared/rekap-gaji/rekap-gaji.blade.php ENDPATH**/ ?>