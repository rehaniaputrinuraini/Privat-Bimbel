

<?php $__env->startSection('title', 'Daftar Periode'); ?>

<?php $__env->startSection('content'); ?>
<div style="width: 100%;">
    
    
    <div style="margin-bottom: 25px;">
        <p style="color: #374151; font-size: 13px; margin: 0 0 4px 0;">
            <?php echo e(\Carbon\Carbon::now()->translatedFormat('F Y')); ?>

        </p>
        <h1 style="font-size: 26px; font-weight: 700; color: #111827; margin: 0; letter-spacing: -0.5px; line-height: 1.2;">
            Daftar Periode
        </h1>
        <p style="color: #374151; font-size: 14px; margin: 4px 0 0 0;">Manajemen Periode Tahun Ajaran</p>
    </div>

    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; gap: 15px;">
        <div style="display: flex; align-items: center; gap: 12px; flex: 1;">
            <div style="position: relative; width: 300px;">
                <i class="fas fa-search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #9CA3AF;"></i>
                <input type="text" id="searchInput" placeholder="Cari Tahun Periode..." 
                       style="width: 100%; padding: 10px 15px 10px 45px; border-radius: 12px; border: 1px solid #E5E7EB; outline: none; background: white; font-size: 14px; color: #374151;">
            </div>
        </div>
        
        <a href="<?php echo e(route($role . '.master-data.periode.create')); ?>" style="text-decoration: none;">
            <button style="background-color: #4D0B87; color: white; border: none; padding: 12px 25px; border-radius: 12px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 10px; font-size: 14px; transition: 0.3s; box-shadow: 0 4px 6px rgba(77, 11, 135, 0.2);">
                <i class="fas fa-plus"></i> Tambah
            </button>
        </a>
    </div>

    
    <?php if(session('success_periode')): ?>
        <div style="background: #D1FAE5; color: #065F46; padding: 12px; border-radius: 10px; margin-bottom: 20px;">
            <i class="fas fa-check-circle"></i> <?php echo e(session('success_periode')); ?>

        </div>
    <?php endif; ?>

    
    <div style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.08); border: 1px solid #F3F4F6;">
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 13px;">
                <thead>
                    <tr style="background: #F3E8FF; color: #111827;">
                        <th style="padding: 15px; font-weight: 700; text-align: center; width: 50px;">No</th>
                        <th style="padding: 15px; font-weight: 700; text-align: center;">ID</th>
                        <th style="padding: 15px; font-weight: 700; text-align: center;">Tahun Periode</th>
                        <th style="padding: 15px; font-weight: 700; text-align: center;">Tanggal Mulai</th>
                        <th style="padding: 15px; font-weight: 700; text-align: center;">Tanggal Selesai</th>
                        <th style="padding: 15px; font-weight: 700; text-align: center;">Status</th>
                        <th style="padding: 15px; font-weight: 700; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tableBody" style="color: #374151;">
                    <?php $__empty_1 = true; $__currentLoopData = $periode; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr style="border-bottom: 1px solid #F3F4F6; transition: 0.2s;" onmouseover="this.style.background='#F9FAFB'" onmouseout="this.style.background='transparent'">
                        <td style="padding: 15px; text-align: center;"><?php echo e($loop->iteration); ?></td>
                        <td style="padding: 15px; text-align: center;">PR<?php echo e(str_pad($item->id_periode, 4, '0', STR_PAD_LEFT)); ?></td>
                        <td style="padding: 15px; text-align: center;"><?php echo e($item->tahun_periode); ?></td>
                        <td style="padding: 15px; text-align: center;"><?php echo e($item->tanggal_mulai ? date('d/m/Y', strtotime($item->tanggal_mulai)) : '-'); ?></td>
                        <td style="padding: 15px; text-align: center;"><?php echo e($item->tanggal_selesai ? date('d/m/Y', strtotime($item->tanggal_selesai)) : '-'); ?></td>
                        <td style="padding: 15px; text-align: center;">
                            <?php
                                $sekarang = date('Y-m-d');
                                $aktif = ($item->tanggal_mulai <= $sekarang && $item->tanggal_selesai >= $sekarang);
                            ?>
                            <?php if($aktif): ?>
                                <span style="background: #D1FAE5; color: #065F46; padding: 4px 10px; border-radius: 20px; font-size: 12px;">Aktif</span>
                            <?php else: ?>
                                <span style="background: #F3F4F6; color: #6B7280; padding: 4px 10px; border-radius: 20px; font-size: 12px;">Nonaktif</span>
                            <?php endif; ?>
                        </td>
                        <td style="padding: 15px; text-align: center;">
                            <div style="display: flex; gap: 8px; justify-content: center;">
                                <a href="<?php echo e(route($role . '.master-data.periode.edit', $item->id_periode)); ?>" 
                                   style="background: #5EB37E; color: white; padding: 6px 12px; border-radius: 6px; text-decoration: none; display: flex; align-items: center; gap: 5px; font-size: 12px;">
                                    <i class="far fa-edit"></i> Edit
                                </a>
                                <button type="button" 
                                        onclick="bukaModalHapus('<?php echo e($item->id_periode); ?>', '<?php echo e($item->tahun_periode); ?>')" 
                                        style="background: #E35D5D; color: white; padding: 6px 12px; border-radius: 6px; border: none; cursor: pointer; display: flex; align-items: center; gap: 5px; font-size: 12px;">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" style="padding: 40px; text-align: center; color: #9CA3AF;">
                            <i class="fas fa-calendar-alt" style="font-size: 40px; margin-bottom: 10px; display: block;"></i>
                            Belum ada data periode. Silakan tambah data baru.
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px; padding: 0 5px;">
        <div style="display: flex; align-items: center; gap: 10px;">
            <span style="color: #374151; font-size: 13px;">
                Menampilkan <?php echo e($periode->total() ?? 0); ?> data
            </span>
        </div>
        <div style="display: flex; gap: 5px;">
            <?php if($periode->onFirstPage()): ?>
                <button disabled style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: #F3F4F6; color: #9CA3AF; cursor: not-allowed;">
                    <i class="fas fa-angle-double-left"></i>
                </button>
                <button disabled style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: #F3F4F6; color: #9CA3AF; cursor: not-allowed;">
                    <i class="fas fa-angle-left"></i>
                </button>
            <?php else: ?>
                <a href="<?php echo e($periode->url(1)); ?>" style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; display: flex; align-items: center; justify-content: center; text-decoration: none;">
                    <i class="fas fa-angle-double-left"></i>
                </a>
                <a href="<?php echo e($periode->previousPageUrl()); ?>" style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; display: flex; align-items: center; justify-content: center; text-decoration: none;">
                    <i class="fas fa-angle-left"></i>
                </a>
            <?php endif; ?>

            <?php $__currentLoopData = $periode->getUrlRange(1, $periode->lastPage()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($page == $periode->currentPage()): ?>
                    <button style="width: 35px; height: 35px; border-radius: 8px; background: #4D0B87; color: white; border: none; font-weight: 600; cursor: pointer;"><?php echo e($page); ?></button>
                <?php else: ?>
                    <a href="<?php echo e($url); ?>" style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; display: flex; align-items: center; justify-content: center; text-decoration: none;"><?php echo e($page); ?></a>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <?php if($periode->hasMorePages()): ?>
                <a href="<?php echo e($periode->nextPageUrl()); ?>" style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; display: flex; align-items: center; justify-content: center; text-decoration: none;">
                    <i class="fas fa-angle-right"></i>
                </a>
            <?php else: ?>
                <button disabled style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: #F3F4F6; color: #9CA3AF; cursor: not-allowed;">
                    <i class="fas fa-angle-right"></i>
                </button>
            <?php endif; ?>
        </div>
    </div>

</div>


<div id="modalHapus" style="display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); backdrop-filter: blur(3px); align-items: center; justify-content: center;">
    <div style="background: white; padding: 25px; border-radius: 20px; width: 320px; text-align: center; box-shadow: 0 15px 30px rgba(0,0,0,0.15); font-family: 'Poppins', sans-serif;">
        <div style="color: #E35D5D; font-size: 40px; margin-bottom: 10px;"><i class="fas fa-trash-alt"></i></div>
        <h2 style="margin: 0; font-size: 18px; color: #111827; font-weight: 700;">Hapus Periode?</h2>
        <p style="color: #6B7280; font-size: 13px; margin: 8px 0 20px 0;" id="pesanHapus">Apakah Anda yakin ingin menghapus data periode ini?</p>
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
    document.getElementById('searchInput').addEventListener('keyup', function() {
        let val = this.value.toLowerCase();
        document.querySelectorAll('#tableBody tr').forEach(row => {
            let text = row.innerText.toLowerCase();
            row.style.display = text.includes(val) ? '' : 'none';
        });
    });

    function bukaModalHapus(id, nama) {
        let form = document.getElementById('formHapus');
        form.action = "<?php echo e(route($role . '.master-data.periode.destroy', '')); ?>/" + id;
        document.getElementById('pesanHapus').innerHTML = `Apakah Anda yakin ingin menghapus data <strong>${nama}</strong>? Data yang dihapus tidak dapat dikembalikan.`;
        document.getElementById('modalHapus').style.display = 'flex';
    }
    function tutupModalHapus() {
        document.getElementById('modalHapus').style.display = 'none';
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Privat-Bimbel\resources\views/dashboard/shared/master-data/periode/index.blade.php ENDPATH**/ ?>