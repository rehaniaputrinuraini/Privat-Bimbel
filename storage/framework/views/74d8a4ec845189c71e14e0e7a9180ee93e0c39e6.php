

<?php $__env->startSection('title', 'Penggajian'); ?>

<?php $__env->startSection('content'); ?>
<div style="width: 100%;">

    
    <div style="margin-bottom: 25px;">
        <p style="color: #374151; font-size: 13px; margin: 0 0 4px 0;"><?php echo e(\Carbon\Carbon::now()->translatedFormat('F Y')); ?></p>
        <h1 style="font-size: 26px; font-weight: 700; color: #111827; margin: 0;">Penggajian</h1>
        <p style="color: #374151; font-size: 14px; margin: 4px 0 0 0;">Kelola Gaji Tentor Berdasarkan Honor Akhir Presensi</p>
    </div>

    <?php if(session('success')): ?>
        <div style="background: #D1FAE5; color: #065F46; padding: 12px; border-radius: 10px; margin-bottom: 20px;"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    
    <div style="background: white; border-radius: 16px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.06); margin-bottom: 20px;">
        <div style="display: flex; gap: 12px; flex-wrap: wrap; align-items: center;">
            <select id="filterBulan" onchange="filterGaji()"
                    style="flex: 1; min-width: 130px; padding: 10px 14px; border-radius: 12px; border: 1px solid #E5E7EB; background: #F9FAFB; font-size: 13px; font-family: 'Poppins', sans-serif; outline: none; cursor: pointer;">
                <option value="">Semua Bulan</option>
                <?php for($i=1; $i<=12; $i++): ?>
                    <option value="<?php echo e($i); ?>" <?php echo e(($bulan == $i || (!request('bulan') && date('n') == $i)) ? 'selected' : ''); ?>><?php echo e(Carbon\Carbon::create()->month($i)->translatedFormat('F')); ?></option>
                <?php endfor; ?>
            </select>
            <select id="filterTahun" onchange="filterGaji()"
                    style="flex: 1; min-width: 100px; padding: 10px 14px; border-radius: 12px; border: 1px solid #E5E7EB; background: #F9FAFB; font-size: 13px; font-family: 'Poppins', sans-serif; outline: none; cursor: pointer;">
                <option value="">Semua Tahun</option>
                <?php for($i=date('Y'); $i>=2020; $i--): ?>
                    <option value="<?php echo e($i); ?>" <?php echo e(($tahun == $i || (!request('tahun') && date('Y') == $i)) ? 'selected' : ''); ?>><?php echo e($i); ?></option>
                <?php endfor; ?>
            </select>
            <select id="filterPeriode" onchange="filterGaji()"
                    style="flex: 1; min-width: 130px; padding: 10px 14px; border-radius: 12px; border: 1px solid #E5E7EB; background: #F9FAFB; font-size: 13px; font-family: 'Poppins', sans-serif; outline: none; cursor: pointer;">
                <option value="">Semua Periode</option>
                <?php $__currentLoopData = $periodeList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $periode): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($periode->tahun_periode); ?>" <?php echo e(($periodeAktif && $periodeAktif->tahun_periode == $periode->tahun_periode) ? 'selected' : ''); ?>><?php echo e($periode->tahun_periode); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
    </div>

    
    <div style="background: white; border-radius: 20px; overflow-x: auto; box-shadow: 0 4px 15px rgba(0,0,0,0.08);">
        <table style="width: 100%; border-collapse: collapse; font-size: 13px; white-space: nowrap; font-family: 'Poppins', sans-serif;">
            <thead><tr style="background: #F3E8FF;">
                <th style="padding: 15px; text-align: center;">No</th>
                <th style="padding: 15px;">Nama Tentor</th>
                <th style="padding: 15px;">Mapel</th>
                <th style="padding: 15px; text-align: center;">Grade</th>
                <th style="padding: 15px; text-align: center;">Sesi</th>
                <th style="padding: 15px; text-align: right;">Total Honor</th>
                <th style="padding: 15px; text-align: right;">Uang Makan</th>
                <th style="padding: 15px; text-align: right;">Transport</th>
                <th style="padding: 15px; text-align: right;">Total Gaji</th>
                <th style="padding: 15px; text-align: center;">Status</th>
                <th style="padding: 15px; text-align: center;">Aksi</th>
            </tr></thead>
            <tbody id="tableBody">
                <?php $__empty_1 = true; $__currentLoopData = $penggajian; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr style="border-bottom: 1px solid #F3F4F6;">
                    <td style="padding: 15px; text-align: center;"><?php echo e($penggajian->firstItem() + $index); ?></td>
                    <td style="padding: 15px;"><?php echo e($item->nama); ?></td>
                    <td style="padding: 15px;"><?php echo e($item->mapel); ?></td>
                    <td style="padding: 15px; text-align: center;"><?php echo e($item->grade); ?></td>
                    <td style="padding: 15px; text-align: center;">
                        <?php echo e($item->jumlah_sesi); ?> Sesi (<?php echo e($item->hari_hadir); ?> Hari)
                        <br><small style="color:#9CA3AF;"><?php echo e($item->daftar_tanggal); ?></small>
                    </td>
                    <td style="padding: 15px; text-align: right; font-weight: 600; color: #4D0B87;">Rp <?php echo e(number_format($item->total_honor, 0, ',', '.')); ?></td>
                    <td style="padding: 15px; text-align: right;">
                        Rp <?php echo e(number_format($item->uang_makan, 0, ',', '.')); ?>

                        <br><small style="color:#9CA3AF;">(Rp <?php echo e(number_format($item->uang_makan_per_hari, 0, ',', '.')); ?> × <?php echo e($item->hari_hadir); ?> hari)</small>
                    </td>
                    <td style="padding: 15px; text-align: right;">
                        Rp <?php echo e(number_format($item->uang_transport, 0, ',', '.')); ?>

                        <br><small style="color:#9CA3AF;">(Rp <?php echo e(number_format($item->uang_transport_per_hari, 0, ',', '.')); ?> × <?php echo e($item->hari_hadir); ?> hari)</small>
                    </td>
                    <td style="padding: 15px; text-align: right; font-weight: 700; color: #4D0B87;">Rp <?php echo e(number_format($item->total_gaji, 0, ',', '.')); ?></td>
                    <td style="padding: 15px; text-align: center;">
                        <?php if($item->sudah_dibayar): ?>
                            <span style="background:#D1FAE5;color:#065F46;padding:4px 10px;border-radius:20px;font-size:11px;font-weight:600;">Sudah Dibayar</span>
                        <?php else: ?>
                            <span style="background:#FEF3C7;color:#92400E;padding:4px 10px;border-radius:20px;font-size:11px;font-weight:600;">Belum Dibayar</span>
                        <?php endif; ?>
                    </td>
                    <td style="padding: 15px; text-align: center;">
                        <div style="display: flex; gap: 6px; justify-content: center; align-items: center;">
                            
                            <button onclick="bukaDetailPenggajian(<?php echo e($item->id_pegawai); ?>)"
                                    style="background: #4D0B87; color: white; border: none; padding: 6px 10px; border-radius: 6px; cursor: pointer; font-size: 11px; font-weight: 600; font-family: 'Poppins', sans-serif; white-space: nowrap;">
                                <i class="fas fa-eye"></i> Detail
                            </button>
                            
                            <?php if(!$item->sudah_dibayar): ?>
                                <button type="button" onclick="klikBayar('<?php echo e($item->id_pegawai); ?>', '<?php echo e($item->nama); ?>', <?php echo e($item->total_gaji); ?>, <?php echo e($item->jumlah_sesi); ?>)" 
                                        style="background: #10B981; color: white; padding: 6px 10px; border-radius: 6px; border: none; cursor: pointer; font-size: 11px; font-weight: 600; white-space: nowrap; font-family: 'Poppins', sans-serif;">
                                    <i class="fas fa-money-bill-wave"></i> Bayar
                                </button>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="11" style="padding: 50px; text-align: center; color: #9CA3AF;">Pilih bulan dan tahun untuk melihat data gaji</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px; padding: 0 5px; margin-bottom: 40px;">
        <div style="display: flex; align-items: center; gap: 10px;">
            <select id="pageSelect" style="padding: 8px 12px; border-radius: 10px; border: 1px solid #E5E7EB; color: #374151; font-size: 13px; background: white; outline: none; cursor: pointer; font-family: 'Poppins', sans-serif;">
                <option value="10" <?php echo e(request('per_page', 10) == 10 ? 'selected' : ''); ?>>10 baris</option>
                <option value="25" <?php echo e(request('per_page') == 25 ? 'selected' : ''); ?>>25 baris</option>
                <option value="50" <?php echo e(request('per_page') == 50 ? 'selected' : ''); ?>>50 baris</option>
            </select>
            <span style="color: #374151; font-size: 13px;">Menampilkan <?php echo e($penggajian->total() ?? 0); ?> data</span>
        </div>
        <div style="display: flex; gap: 5px;">
            <?php if($penggajian->onFirstPage()): ?>
                <button disabled style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: #F3F4F6; color: #9CA3AF; cursor: not-allowed;"><i class="fas fa-angle-double-left"></i></button>
                <button disabled style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: #F3F4F6; color: #9CA3AF; cursor: not-allowed;"><i class="fas fa-angle-left"></i></button>
            <?php else: ?>
                <a href="<?php echo e(request()->fullUrlWithQuery(['page' => 1])); ?>" style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; display: flex; align-items: center; justify-content: center; text-decoration: none;"><i class="fas fa-angle-double-left"></i></a>
                <a href="<?php echo e(request()->fullUrlWithQuery(['page' => $penggajian->currentPage() - 1])); ?>" style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; display: flex; align-items: center; justify-content: center; text-decoration: none;"><i class="fas fa-angle-left"></i></a>
            <?php endif; ?>

            <?php $start = max(1, $penggajian->currentPage() - 2); $end = min($penggajian->lastPage(), $penggajian->currentPage() + 2); ?>
            <?php for($i = $start; $i <= $end; $i++): ?>
                <?php if($i == $penggajian->currentPage()): ?>
                    <button style="width: 35px; height: 35px; border-radius: 8px; background: #4D0B87; color: white; border: none; font-weight: 600; cursor: pointer;"><?php echo e($i); ?></button>
                <?php else: ?>
                    <a href="<?php echo e(request()->fullUrlWithQuery(['page' => $i])); ?>" style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; display: flex; align-items: center; justify-content: center; text-decoration: none;"><?php echo e($i); ?></a>
                <?php endif; ?>
            <?php endfor; ?>

            <?php if($penggajian->hasMorePages()): ?>
                <a href="<?php echo e(request()->fullUrlWithQuery(['page' => $penggajian->currentPage() + 1])); ?>" style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; display: flex; align-items: center; justify-content: center; text-decoration: none;"><i class="fas fa-angle-right"></i></a>
            <?php else: ?>
                <button disabled style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: #F3F4F6; color: #9CA3AF; cursor: not-allowed;"><i class="fas fa-angle-right"></i></button>
            <?php endif; ?>
        </div>
    </div>

</div>


<div id="modalDetailGaji"
     style="display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); backdrop-filter: blur(3px); align-items: center; justify-content: center; overflow-y: auto; padding: 20px; box-sizing: border-box;">
    <div style="background: white; border-radius: 20px; width: 700px; max-width: 95%; max-height: 90vh; overflow-y: auto; box-shadow: 0 15px 30px rgba(0,0,0,0.15);" id="modalDetailGajiContent"></div>
</div>


<div id="modalPeringatan" style="display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); backdrop-filter: blur(3px); align-items: center; justify-content: center;">
    <div style="background: white; padding: 25px; border-radius: 20px; width: 380px; text-align: center; box-shadow: 0 15px 30px rgba(0,0,0,0.15); font-family: 'Poppins', sans-serif;">
        <div style="color: #F59E0B; font-size: 40px; margin-bottom: 10px;"><i class="fas fa-exclamation-triangle"></i></div>
        <h2 style="margin: 0; font-size: 18px; color: #111827; font-weight: 700;">Tidak Dapat Membayar</h2>
        <p style="color: #6B7280; font-size: 12px; margin: 8px 0 20px 0; line-height: 1.5;" id="pesanPeringatan"></p>
        <button onclick="tutupModalPeringatan()" style="width: 100%; padding: 10px; border-radius: 10px; border: none; background: #4D0B87; color: white; font-weight: 600; font-size: 13px; cursor: pointer;">Mengerti</button>
    </div>
</div>


<div id="modalBayar" style="display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); backdrop-filter: blur(3px); align-items: center; justify-content: center;">
    <div style="background: white; padding: 25px; border-radius: 20px; width: 380px; text-align: center; box-shadow: 0 15px 30px rgba(0,0,0,0.15); font-family: 'Poppins', sans-serif;">
        <div style="color: #F59E0B; font-size: 40px; margin-bottom: 10px;"><i class="fas fa-money-bill-wave"></i></div>
        <h2 style="margin: 0; font-size: 18px; color: #111827; font-weight: 700;">Bayar Gaji?</h2>
        <p style="color: #6B7280; font-size: 12px; margin: 8px 0 20px 0; line-height: 1.5;" id="pesanBayar"></p>
        <div style="display: flex; gap: 10px; justify-content: center;">
            <button onclick="tutupModalBayar()" style="flex: 1; padding: 10px; border-radius: 10px; border: 1px solid #E5E7EB; background: white; font-weight: 600; font-size: 13px; cursor: pointer;">Batal</button>
            <button type="button" id="btnKonfirmasiBayar" onclick="konfirmasiBayar()" style="flex: 1; padding: 10px; border-radius: 10px; border: none; background: #10B981; color: white; font-weight: 600; font-size: 13px; cursor: pointer;">Ya, Bayar</button>
        </div>
    </div>
</div>

<script>
    let bayarData = {};

    function filterGaji() {
        const bulan = document.getElementById('filterBulan').value;
        const tahun = document.getElementById('filterTahun').value;
        const periode = document.getElementById('filterPeriode')?.value || '';
        let params = [];
        if (bulan) params.push(`bulan=${bulan}`);
        if (tahun) params.push(`tahun=${tahun}`);
        if (periode) params.push(`periode=${periode}`);
        window.location.href = params.length ? `?${params.join('&')}` : window.location.pathname;
    }

    /* ================================================================
       BUKA MODAL DETAIL PENGGAJIAN
    ================================================================ */
    function bukaDetailPenggajian(idPegawai) {
        const bulan = document.getElementById('filterBulan').value;
        const tahun = document.getElementById('filterTahun').value;
        const url = "<?php echo e(url($role . '/penggajian/detail')); ?>/" + idPegawai + "?bulan=" + bulan + "&tahun=" + tahun;
        
        fetch(url)
            .then(r => r.text())
            .then(html => {
                const cont = document.getElementById('modalDetailGajiContent');
                cont.innerHTML = html;
                document.getElementById('modalDetailGaji').style.display = 'flex';
                cont.querySelectorAll('script').forEach(oldScript => {
                    const newScript = document.createElement('script');
                    newScript.textContent = oldScript.textContent;
                    document.body.appendChild(newScript);
                    document.body.removeChild(newScript);
                });
            })
            .catch(() => alert('Gagal memuat detail penggajian.'));
    }

    function tutupModalDetailGaji() {
        document.getElementById('modalDetailGaji').style.display = 'none';
        document.getElementById('modalDetailGajiContent').innerHTML = '';
    }

    /* ================================================================
       BAYAR GAJI
    ================================================================ */
    function klikBayar(id, nama, total, sesi) {
        const today = new Date();
        const currentMonth = today.getMonth() + 1;
        const currentYear = today.getFullYear();
        const lastDay = new Date(currentYear, currentMonth, 0).getDate();
        const hMin3 = lastDay - 2;
        const isAkhirBulan = today.getDate() >= hMin3;
        
        const filterBulan = parseInt(document.getElementById('filterBulan').value);
        const filterTahun = parseInt(document.getElementById('filterTahun').value);
        const isBulanLalu = (filterTahun < currentYear) || (filterTahun === currentYear && filterBulan < currentMonth);
        const bolehBayar = isAkhirBulan || isBulanLalu;

        if (!bolehBayar) {
            document.getElementById('pesanPeringatan').innerHTML = 
                `Pembayaran gaji <strong>${nama}</strong> hanya bisa dilakukan di <strong>akhir bulan (H-3 s/d akhir bulan)</strong> atau untuk <strong>bulan sebelumnya yang belum dibayar</strong>.`;
            document.getElementById('modalPeringatan').style.display = 'flex';
            return;
        }

        bayarData = { id, nama, total, sesi };
        document.getElementById('pesanBayar').innerHTML = 
            `Apakah Anda <strong>benar-benar yakin</strong> ingin membayar gaji <strong>${nama}</strong> sebesar <strong>Rp ${new Intl.NumberFormat('id-ID').format(total)}</strong> untuk <strong>${sesi} sesi</strong>?<br><br><small style="color:#EF4444;">⚠️ <strong>PERINGATAN:</strong> Pembayaran tidak dapat dibatalkan setelah dikonfirmasi.</small>`;
        document.getElementById('modalBayar').style.display = 'flex';
    }

    function tutupModalPeringatan() { 
        document.getElementById('modalPeringatan').style.display = 'none'; 
    }

    function tutupModalBayar() { 
        document.getElementById('modalBayar').style.display = 'none'; 
    }

    function konfirmasiBayar() {
        const btn = document.getElementById('btnKonfirmasiBayar');
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';

        const bulan = document.getElementById('filterBulan').value;
        const tahun = document.getElementById('filterTahun').value;
        const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

        let url = "<?php echo e(route($role . '.penggajian.bayar', ':id')); ?>";
        url = url.replace(':id', bayarData.id);

        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrf,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                bulan: bulan,
                tahun: tahun,
                total_gaji: bayarData.total,
                jumlah_sesi: bayarData.sesi
            })
        })
        .then(function(response) {
            if (!response.ok) throw new Error('Server error: ' + response.status);
            return response.json();
        })
        .then(function(data) {
            if (data.success) {
                // Download slip gaji
                const urlSlip = "<?php echo e(url($role . '/penggajian/slip')); ?>/" + bayarData.id + "?bulan=" + bulan + "&tahun=" + tahun;
                window.open(urlSlip, '_blank');
                
                // Reload halaman setelah jeda
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            } else {
                alert(data.message || 'Gagal membayar gaji');
                btn.disabled = false;
                btn.innerHTML = 'Ya, Bayar';
            }
        })
        .catch(function(err) {
            alert('Terjadi kesalahan: ' + err.message);
            btn.disabled = false;
            btn.innerHTML = 'Ya, Bayar';
        });
    }

    document.getElementById('pageSelect').addEventListener('change', function() {
        let url = new URL(window.location.href);
        url.searchParams.set('per_page', this.value);
        url.searchParams.delete('page');
        window.location.href = url.toString();
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Privat-Bimbel\resources\views/dashboard/shared/transaksi/penggajian.blade.php ENDPATH**/ ?>