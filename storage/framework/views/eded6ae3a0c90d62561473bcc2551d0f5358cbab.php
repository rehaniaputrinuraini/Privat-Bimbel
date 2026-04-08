

<?php $__env->startSection('title', 'Kelola Tentor'); ?>

<?php $__env->startSection('content'); ?>
<div style="width: 100%;">
    
    
    <div style="margin-bottom: 25px;">
        <p style="color: #374151; font-size: 13px; margin: 0 0 4px 0;">
            <?php echo e(\Carbon\Carbon::now()->translatedFormat('F Y')); ?>

        </p>
        <h1 style="font-size: 26px; font-weight: 700; color: #111827; margin: 0; letter-spacing: -0.5px; line-height: 1.2;">
            Kelola Tentor
        </h1>
        <p style="color: #374151; font-size: 14px; margin: 4px 0 0 0;">Manajemen Data Tentor</p>
    </div>

    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; gap: 15px;">
        <div style="display: flex; align-items: center; gap: 12px; flex: 1;">
            <div style="position: relative; width: 300px;">
                <i class="fas fa-search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #9CA3AF;"></i>
                <input type="text" id="searchInput" placeholder="Cari Nama Tentor..." 
                       style="width: 100%; padding: 10px 15px 10px 45px; border-radius: 12px; border: 1px solid #E5E7EB; outline: none; background: white; font-size: 14px; color: #374151;">
            </div>
        </div>
        
        <a href="<?php echo e(route('superadmin.kelola-tentor.create')); ?>" style="text-decoration: none;">
            <button style="background-color: #4D0B87; color: white; border: none; padding: 12px 25px; border-radius: 12px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 10px; font-size: 14px; transition: 0.3s; box-shadow: 0 4px 6px rgba(77, 11, 135, 0.2);">
                <i class="fas fa-plus"></i> Tambah
            </button>
        </a>
    </div>

    
    <?php if(session('success')): ?>
        <div style="background: #D1FAE5; color: #065F46; padding: 12px; border-radius: 10px; margin-bottom: 20px;">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    
    <div style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.08); border: 1px solid #F3F4F6;">
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 13px; white-space: nowrap;">
                <thead>
                    <tr style="background: #F3E8FF; color: #111827;">
                        <th style="padding: 15px; font-weight: 700; text-align: center; width: 50px;">No</th>
                        <th style="padding: 15px; font-weight: 700;">ID</th>
                        <th style="padding: 15px; font-weight: 700;">Nama Lengkap</th>
                        <th style="padding: 15px; font-weight: 700;">Alamat</th>
                        <th style="padding: 15px; font-weight: 700;">No HP</th>
                        <th style="padding: 15px; font-weight: 700;">Mapel</th>
                        <th style="padding: 15px; font-weight: 700; text-align: center;">Grade</th>
                        <th style="padding: 15px; font-weight: 700;">HR SD</th>
                        <th style="padding: 15px; font-weight: 700;">HR SMP</th>
                        <th style="padding: 15px; font-weight: 700;">HR SMA</th>
                        <th style="padding: 15px; font-weight: 700;">Uang Makan</th>
                        <th style="padding: 15px; font-weight: 700;">Transport</th>
                        <th style="padding: 15px; font-weight: 700;">Email</th>
                        <th style="padding: 15px; font-weight: 700;">Username</th>
                        <th style="padding: 15px; font-weight: 700; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tableBody" style="color: #374151;">
                    <?php $__empty_1 = true; $__currentLoopData = $tentors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr style="border-bottom: 1px solid #F3F4F6; transition: 0.2s;" onmouseover="this.style.background='#F9FAFB'" onmouseout="this.style.background='transparent'">
                        <td style="padding: 15px; text-align: center;"><?php echo e($tentors->firstItem() + $index); ?></td>
                        <td style="padding: 15px;">TE<?php echo e(str_pad($t->id_tentor, 4, '0', STR_PAD_LEFT)); ?></td>
                        <td style="padding: 15px;"><?php echo e($t->nama_lengkap_tentor); ?></td>
                        <td style="padding: 15px;"><?php echo e($t->alamat_tentor ?? '-'); ?></td>
                        <td style="padding: 15px;"><?php echo e($t->no_hp_tentor ?? '-'); ?></td>
                        <td style="padding: 15px;"><?php echo e($t->mapel ?? '-'); ?></td>
                        <td style="padding: 15px; text-align: center;"><?php echo e($t->grade ?? '-'); ?></td>
                        <td style="padding: 15px;">Rp <?php echo e(number_format($t->hr_sd ?? 0, 0, ',', '.')); ?></td>
                        <td style="padding: 15px;">Rp <?php echo e(number_format($t->hr_smp ?? 0, 0, ',', '.')); ?></td>
                        <td style="padding: 15px;">Rp <?php echo e(number_format($t->hr_sma ?? 0, 0, ',', '.')); ?></td>
                        <td style="padding: 15px;">Rp <?php echo e(number_format($t->uang_makan ?? 0, 0, ',', '.')); ?></td>
                        <td style="padding: 15px;">Rp <?php echo e(number_format($t->uang_transport ?? 0, 0, ',', '.')); ?></td>
                        <td style="padding: 15px;"><?php echo e($t->user->email ?? '-'); ?></td>
                        <td style="padding: 15px;"><?php echo e($t->user->username ?? '-'); ?></td>
                        <td style="padding: 15px;">
                            <div style="display: flex; gap: 8px; justify-content: center;">
                                <a href="<?php echo e(route('superadmin.kelola-tentor.edit', $t->id_tentor)); ?>" 
                                   style="background: #5EB37E; color: white; padding: 6px 12px; border-radius: 6px; text-decoration: none; display: flex; align-items: center; gap: 5px; font-size: 12px;">
                                    <i class="far fa-edit"></i> Edit
                                </a>
                                <button type="button" 
                                        onclick="bukaModalHapus('<?php echo e($t->id_tentor); ?>', '<?php echo e($t->nama_lengkap_tentor); ?>')" 
                                        style="background: #E35D5D; color: white; padding: 6px 12px; border-radius: 6px; border: none; cursor: pointer; display: flex; align-items: center; gap: 5px; font-size: 12px;">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="15" style="padding: 40px; text-align: center; color: #9CA3AF;">
                            <i class="fas fa-database" style="font-size: 40px; margin-bottom: 10px; display: block;"></i>
                            Belum ada data tentor. Silakan tambah data baru.
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px; padding: 0 5px;">
        <div style="display: flex; align-items: center; gap: 10px;">
            <select id="pageSelect" style="padding: 8px 12px; border-radius: 10px; border: 1px solid #E5E7EB; color: #374151; font-size: 13px; background: white; outline: none; cursor: pointer; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                <option value="10">10 baris</option>
                <option value="25">25 baris</option>
                <option value="50">50 baris</option>
            </select>
            <span style="color: #374151; font-size: 13px;">Menampilkan <?php echo e($tentors->total()); ?> data</span>
        </div>

        <div class="pagination-container" style="display: flex; gap: 5px;">
            <?php if($tentors->onFirstPage()): ?>
                <button disabled style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: #F9FAFB; color: #D1D5DB; cursor: not-allowed;">
                    <i class="fas fa-angle-double-left"></i>
                </button>
                <button disabled style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: #F9FAFB; color: #D1D5DB; cursor: not-allowed;">
                    <i class="fas fa-angle-left"></i>
                </button>
            <?php else: ?>
                <a href="<?php echo e($tentors->url(1)); ?>" style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; cursor: pointer; display: flex; align-items: center; justify-content: center; text-decoration: none;">
                    <i class="fas fa-angle-double-left"></i>
                </a>
                <a href="<?php echo e($tentors->previousPageUrl()); ?>" style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; cursor: pointer; display: flex; align-items: center; justify-content: center; text-decoration: none;">
                    <i class="fas fa-angle-left"></i>
                </a>
            <?php endif; ?>

            <?php
                $currentPage = $tentors->currentPage();
                $lastPage = $tentors->lastPage();
                $start = max(1, $currentPage - 1);
                $end = min($lastPage, $currentPage + 1);
                
                if ($start > 1) {
                    echo '<a href="'.$tentors->url(1).'" style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; cursor: pointer; display: flex; align-items: center; justify-content: center; text-decoration: none;">1</a>';
                    if ($start > 2) {
                        echo '<span style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;">...</span>';
                    }
                }
                
                for ($i = $start; $i <= $end; $i++) {
                    if ($i == $currentPage) {
                        echo '<button style="width: 35px; height: 35px; border-radius: 8px; background: #4D0B87; color: white; border: none; font-weight: 600; cursor: pointer;">'.$i.'</button>';
                    } else {
                        echo '<a href="'.$tentors->url($i).'" style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; cursor: pointer; display: flex; align-items: center; justify-content: center; text-decoration: none;">'.$i.'</a>';
                    }
                }
                
                if ($end < $lastPage) {
                    if ($end < $lastPage - 1) {
                        echo '<span style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;">...</span>';
                    }
                    echo '<a href="'.$tentors->url($lastPage).'" style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; cursor: pointer; display: flex; align-items: center; justify-content: center; text-decoration: none;">'.$lastPage.'</a>';
                }
            ?>

            <?php if($tentors->hasMorePages()): ?>
                <a href="<?php echo e($tentors->nextPageUrl()); ?>" style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; cursor: pointer; display: flex; align-items: center; justify-content: center; text-decoration: none;">
                    <i class="fas fa-angle-right"></i>
                </a>
                <a href="<?php echo e($tentors->url($lastPage)); ?>" style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; cursor: pointer; display: flex; align-items: center; justify-content: center; text-decoration: none;">
                    <i class="fas fa-angle-double-right"></i>
                </a>
            <?php else: ?>
                <button disabled style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: #F9FAFB; color: #D1D5DB; cursor: not-allowed;">
                    <i class="fas fa-angle-right"></i>
                </button>
                <button disabled style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: #F9FAFB; color: #D1D5DB; cursor: not-allowed;">
                    <i class="fas fa-angle-double-right"></i>
                </button>
            <?php endif; ?>
        </div>
    </div>

</div>


<div id="modalHapus" style="display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); backdrop-filter: blur(3px); align-items: center; justify-content: center;">
    <div style="background: white; padding: 25px; border-radius: 20px; width: 320px; text-align: center; box-shadow: 0 15px 30px rgba(0,0,0,0.15); font-family: 'Poppins', sans-serif;">
        <div style="color: #E35D5D; font-size: 40px; margin-bottom: 10px;"><i class="fas fa-trash-alt"></i></div>
        <h2 style="margin: 0; font-size: 18px; color: #111827; font-weight: 700;">Hapus Tentor?</h2>
        <p style="color: #6B7280; font-size: 13px; margin: 8px 0 20px 0;" id="pesanHapus">Apakah Anda yakin ingin menghapus data tentor ini?</p>
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
    // Live search (hanya berdasarkan NAMA)
    document.getElementById('searchInput').addEventListener('keyup', function() {
        let searchValue = this.value.toLowerCase();
        let rows = document.querySelectorAll('#tableBody tr');
        
        rows.forEach(row => {
            if(row.cells && row.cells.length >= 3) {
                let nama = row.cells[2]?.innerText.toLowerCase() || '';
                if(nama.includes(searchValue)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            }
        });
    });

    // Modal Hapus dengan efek blur
    function bukaModalHapus(id, nama) {
        let form = document.getElementById('formHapus');
        let url = "<?php echo e(route('superadmin.kelola-tentor.destroy', ':id')); ?>";
        url = url.replace(':id', id);
        form.action = url;
        
        let pesan = document.getElementById('pesanHapus');
        pesan.innerHTML = `Apakah Anda yakin ingin menghapus data tentor <strong>${nama}</strong>? Data yang dihapus tidak dapat dikembalikan.`;
        
        document.getElementById('modalHapus').style.display = 'flex';
    }

    function tutupModalHapus() {
        document.getElementById('modalHapus').style.display = 'none';
    }

    // Page Select (show entries)
    document.getElementById('pageSelect').addEventListener('change', function() {
        let perPage = this.value;
        let url = new URL(window.location.href);
        url.searchParams.set('per_page', perPage);
        window.location.href = url.toString();
    });

    // Set selected value on page load
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const perPage = urlParams.get('per_page');
        if (perPage && document.getElementById('pageSelect')) {
            document.getElementById('pageSelect').value = perPage;
        }
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Privat-Bimbel\resources\views/dashboard/superadmin/kelola-tentor/kelola-tentor.blade.php ENDPATH**/ ?>