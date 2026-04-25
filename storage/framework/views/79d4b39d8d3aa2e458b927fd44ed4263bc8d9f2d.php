

<?php $__env->startSection('title', 'Kelola Murid'); ?>

<?php $__env->startSection('content'); ?>
<div style="width: 100%;">
    
    
    <div style="margin-bottom: 25px;">
        <p style="color: #374151; font-size: 13px; margin: 0 0 4px 0;">
            <?php echo e(\Carbon\Carbon::now()->translatedFormat('F Y')); ?>

        </p>
        <h1 style="font-size: 26px; font-weight: 700; color: #111827; margin: 0; letter-spacing: -0.5px; line-height: 1.2;">
            Kelola Murid
        </h1>
        <p style="color: #374151; font-size: 14px; margin: 4px 0 0 0;">Manajemen Data Murid</p>
    </div>

    
    <?php if(session('success')): ?>
        <div style="background: #D1FAE5; color: #065F46; padding: 12px; border-radius: 10px; margin-bottom: 20px;">
            <i class="fas fa-check-circle"></i> <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; gap: 15px;">
        <div style="display: flex; align-items: center; gap: 12px; flex: 1;">
            <div style="position: relative; width: 300px;">
                <i class="fas fa-search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #9CA3AF;"></i>
                <input type="text" id="searchInput" placeholder="Cari Nama Murid..." 
                       style="width: 100%; padding: 10px 15px 10px 45px; border-radius: 12px; border: 1px solid #E5E7EB; outline: none; background: white; font-size: 14px; color: #374151;">
            </div>

            <select id="filterPaket" style="padding: 10px 12px; border-radius: 12px; border: 1px solid #E5E7EB; color: #374151; font-size: 13px; min-width: 160px; background: white; outline: none; cursor: pointer;">
                <option value="">--- Pilihan Paket ---</option>
                <?php $__currentLoopData = $paketList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($paket); ?>"><?php echo e($paket); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>

            <select id="filterTahun" style="padding: 10px 12px; border-radius: 12px; border: 1px solid #E5E7EB; color: #374151; font-size: 13px; min-width: 160px; background: white; outline: none; cursor: pointer;">
                <option value="">--- Tahun Masuk ---</option>
                <?php
                    $tahunList = $murids->pluck('tahun_masuk')->unique()->sort()->filter();
                ?>
                <?php $__currentLoopData = $tahunList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tahun): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($tahun); ?>"><?php echo e($tahun); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        
        <button onclick="bukaModalCreate()" style="background-color: #4D0B87; color: white; border: none; padding: 12px 25px; border-radius: 12px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 10px; font-size: 14px; transition: 0.3s; box-shadow: 0 4px 6px rgba(77, 11, 135, 0.2);">
            <i class="fas fa-plus"></i> Tambah
        </button>
    </div>

    
    <div style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.08); border: 1px solid #F3F4F6;">
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 13px; white-space: nowrap;">
                <thead>
                    <tr style="background: #F3E8FF; color: #111827;">
                        <th style="padding: 15px; font-weight: 700; width: 50px;">No</th>
                        <th style="padding: 15px; font-weight: 700;">Nama Lengkap</th>
                        <th style="padding: 15px; font-weight: 700;">Kelas</th>
                        <th style="padding: 15px; font-weight: 700;">Asal Sekolah</th>
                        <th style="padding: 15px; font-weight: 700;">Alamat</th>
                        <th style="padding: 15px; font-weight: 700;">No HP Siswa</th>
                        <th style="padding: 15px; font-weight: 700;">Nama Orang Tua</th>
                        <th style="padding: 15px; font-weight: 700;">No HP Ortu</th>
                        <th style="padding: 15px; font-weight: 700;">Paket</th>
                        <th style="padding: 15px; font-weight: 700; text-align: center;">Tahun Masuk</th>
                        <th style="padding: 15px; font-weight: 700; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tableBody" style="color: #374151;">
                    <?php $__empty_1 = true; $__currentLoopData = $murids; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr style="border-bottom: 1px solid #F3F4F6; transition: 0.2s;" onmouseover="this.style.background='#F9FAFB'" onmouseout="this.style.background='transparent'">
                        <td style="padding: 15px;"><?php echo e($loop->iteration); ?></td>
                        <td style="padding: 15px; font-weight: 500;"><?php echo e($m->nama_lengkap); ?></td>
                        <td style="padding: 15px;">
                            <?php
                                $kelasTerbaru = $m->transaksiKelas()->orderBy('created_at', 'desc')->first();
                            ?>
                            <?php echo e($kelasTerbaru && $kelasTerbaru->kelas ? $kelasTerbaru->kelas->jenjang . ' - ' . $kelasTerbaru->kelas->nama_kelas : '-'); ?>

                        </td>
                        <td style="padding: 15px;"><?php echo e($m->asal_sekolah ?? '-'); ?></td>
                        <td style="padding: 15px; max-width: 150px; overflow: hidden; text-overflow: ellipsis;" title="<?php echo e($m->alamat); ?>"><?php echo e($m->alamat ?? '-'); ?></td>
                        <td style="padding: 15px;"><?php echo e($m->no_hp ?? '-'); ?></td>
                        <td style="padding: 15px;"><?php echo e($m->nama_orang_tua ?? '-'); ?></td>
                        <td style="padding: 15px;"><?php echo e($m->no_hp_orang_tua ?? '-'); ?></td>
                        <td style="padding: 15px;">
                            <?php
                                $paketTerbaru = $m->transaksiPaket()->orderBy('id_paket_murid', 'desc')->first();
                            ?>
                            <?php echo e($paketTerbaru && $paketTerbaru->paket ? $paketTerbaru->paket->tingkat : '-'); ?>

                        </td>
                        <td style="padding: 15px; text-align: center;"><?php echo e($m->tahun_masuk ?? date('Y')); ?></td>
                        <td style="padding: 15px; text-align: center;">
                            <div style="display: flex; gap: 8px; justify-content: center;">
                                <button onclick="bukaModalEdit(<?php echo e($m->id_murid); ?>)" 
                                   style="background: #5EB37E; color: white; padding: 6px 12px; border-radius: 6px; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 5px; font-size: 12px; white-space: nowrap;">
                                    <i class="far fa-edit"></i> Edit
                                </button>
                                <button type="button" onclick="bukaModalHapus('<?php echo e($m->id_murid); ?>', '<?php echo e($m->nama_lengkap); ?>')" 
                                        style="background: #E35D5D; color: white; padding: 6px 12px; border-radius: 6px; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 5px; font-size: 12px; white-space: nowrap;">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="11" style="padding: 40px; text-align: center; color: #9CA3AF;">
                            <i class="fas fa-database" style="font-size: 40px; margin-bottom: 10px; display: block;"></i>
                            Belum ada data murid.
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
            <span style="color: #374151; font-size: 13px;">Menampilkan <?php echo e($murids->count()); ?> data</span>
        </div>

        <div style="display: flex; gap: 5px;">
            <button style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; cursor: pointer;"><i class="fas fa-angle-double-left"></i></button>
            <button style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; cursor: pointer;"><i class="fas fa-angle-left"></i></button>
            <button style="width: 35px; height: 35px; border-radius: 8px; background: #4D0B87; color: white; border: none; font-weight: 600; cursor: pointer;">1</button>
            <button style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; cursor: pointer;"><i class="fas fa-angle-right"></i></button>
        </div>
    </div>

</div>


<div id="modalForm" style="display: none; position: fixed; z-index: 9998; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); backdrop-filter: blur(3px); align-items: center; justify-content: center; overflow-y: auto; padding: 20px;">
    <div style="background: white; border-radius: 20px; width: 700px; max-width: 95%; max-height: 90vh; overflow-y: auto; box-shadow: 0 15px 30px rgba(0,0,0,0.15);" id="modalContent">
        
    </div>
</div>


<div id="modalHapus" style="display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); backdrop-filter: blur(3px); align-items: center; justify-content: center;">
    <div style="background: white; padding: 25px; border-radius: 20px; width: 320px; text-align: center; box-shadow: 0 15px 30px rgba(0,0,0,0.15); font-family: 'Poppins', sans-serif;">
        <div style="color: #E35D5D; font-size: 40px; margin-bottom: 10px;"><i class="fas fa-trash-alt"></i></div>
        <h2 style="margin: 0; font-size: 18px; color: #111827; font-weight: 700;">Hapus Data?</h2>
        <p style="color: #6B7280; font-size: 13px; margin: 8px 0 20px 0;" id="pesanHapus">Apakah Anda yakin ingin menghapus data murid ini?</p>
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
    // =============================================
    // BUKA MODAL CREATE
    // =============================================
    function bukaModalCreate() {
        fetch("<?php echo e(route($role . '.murid.create')); ?>")
            .then(r => r.text())
            .then(html => {
                document.getElementById('modalContent').innerHTML = html;
                document.getElementById('modalForm').style.display = 'flex';
                setTimeout(() => pasangEventHandler(), 100);
            });
    }

    // =============================================
    // BUKA MODAL EDIT
    // =============================================
    function bukaModalEdit(id) {
        fetch("<?php echo e(route($role . '.murid.edit', '')); ?>/" + id)
            .then(r => r.text())
            .then(html => {
                document.getElementById('modalContent').innerHTML = html;
                document.getElementById('modalForm').style.display = 'flex';
                setTimeout(() => pasangEventHandler(), 100);
            });
    }

    // =============================================
    // TUTUP MODAL FORM
    // =============================================
    function tutupModalForm() {
        document.getElementById('modalForm').style.display = 'none';
        document.getElementById('modalContent').innerHTML = '';
    }

    document.getElementById('modalForm').addEventListener('click', function(e) {
        if (e.target === this) tutupModalForm();
    });

    // =============================================
    // PASANG EVENT HANDLER UNTUK FORM DI DALAM MODAL
    // =============================================
    function pasangEventHandler() {
        const modalContent = document.getElementById('modalContent');
        if (!modalContent) return;
        
        const form = modalContent.querySelector('form');
        const btnKeluar = modalContent.querySelector('#btnKeluar');
        const btnSimpan = modalContent.querySelector('#btnSimpan');
        const btnUpdate = modalContent.querySelector('#btnUpdate');
        const modalBatal = modalContent.querySelector('#modalBatal');
        const modalPindahHalaman = modalContent.querySelector('#modalPindahHalaman');
        const modalSukses = modalContent.querySelector('#modalSukses');
        const btnTidakBatal = modalContent.querySelector('#btnTidakBatal');
        const btnYaKeluar = modalContent.querySelector('#btnYaKeluar');
        const btnTidakPindah = modalContent.querySelector('#btnTidakPindah');
        const btnYaPindah = modalContent.querySelector('#btnYaPindah');
        const btnOkSukses = modalContent.querySelector('#btnOkSukses');
        const alertError = modalContent.querySelector('#alertError');
        const alertErrorText = modalContent.querySelector('#alertErrorText');
        const pesanSukses = modalContent.querySelector('#pesanSukses');
        
        let formChanged = false;
        let formSubmitted = false;
        
        if (form) {
            const inputs = form.querySelectorAll('input:not([readonly]), select, textarea');
            inputs.forEach(function(input) {
                input.addEventListener('input', function() { if (!formSubmitted) formChanged = true; });
                input.addEventListener('change', function() { if (!formSubmitted) formChanged = true; });
            });
        }
        
        // BUTTON KELUAR
        if (btnKeluar) {
            btnKeluar.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                if (formChanged && !formSubmitted) {
                    if (modalPindahHalaman) modalPindahHalaman.style.display = 'flex';
                } else {
                    if (modalBatal) modalBatal.style.display = 'flex';
                }
            });
        }
        
        // MODAL BATAL
        if (btnTidakBatal) btnTidakBatal.addEventListener('click', () => { if (modalBatal) modalBatal.style.display = 'none'; });
        if (btnYaKeluar) btnYaKeluar.addEventListener('click', () => { formChanged = false; if (modalBatal) modalBatal.style.display = 'none'; tutupModalForm(); });
        if (modalBatal) modalBatal.addEventListener('click', function(e) { if (e.target === modalBatal) modalBatal.style.display = 'none'; });
        
        // MODAL PINDAH
        if (btnTidakPindah) btnTidakPindah.addEventListener('click', () => { if (modalPindahHalaman) modalPindahHalaman.style.display = 'none'; });
        if (btnYaPindah) btnYaPindah.addEventListener('click', () => { formChanged = false; if (modalPindahHalaman) modalPindahHalaman.style.display = 'none'; tutupModalForm(); });
        if (modalPindahHalaman) modalPindahHalaman.addEventListener('click', function(e) { if (e.target === modalPindahHalaman) modalPindahHalaman.style.display = 'none'; });
        
        // MODAL SUKSES
        if (btnOkSukses) btnOkSukses.addEventListener('click', () => { if (modalSukses) modalSukses.style.display = 'none'; tutupModalForm(); window.location.reload(); });
        if (modalSukses) modalSukses.addEventListener('click', function(e) { if (e.target === modalSukses) { modalSukses.style.display = 'none'; tutupModalForm(); window.location.reload(); } });
        
        // SUBMIT FORM
        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(form);
                const submitBtn = btnSimpan || btnUpdate;
                const originalText = submitBtn ? submitBtn.innerHTML : 'Simpan';
                if (submitBtn) { submitBtn.disabled = true; submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...'; }
                
                fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                        'Accept': 'application/json'
                    }
                })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        formChanged = false;
                        formSubmitted = true;
                        if (pesanSukses) pesanSukses.textContent = data.message || 'Data berhasil disimpan.';
                        if (modalSukses) modalSukses.style.display = 'flex';
                    } else {
                        let errorMsg = data.message || 'Gagal menyimpan data';
                        if (data.errors) { errorMsg = ''; for (let field in data.errors) { errorMsg += data.errors[field].join('\n') + '\n'; } }
                        if (alertError && alertErrorText) { alertErrorText.textContent = errorMsg; alertError.style.display = 'flex'; setTimeout(() => { alertError.style.display = 'none'; }, 5000); }
                        if (submitBtn) { submitBtn.disabled = false; submitBtn.innerHTML = originalText; }
                    }
                })
                .catch(err => {
                    if (alertError && alertErrorText) { alertErrorText.textContent = 'Terjadi kesalahan: ' + err.message; alertError.style.display = 'flex'; setTimeout(() => { alertError.style.display = 'none'; }, 5000); }
                    if (submitBtn) { submitBtn.disabled = false; submitBtn.innerHTML = originalText; }
                });
            });
        }
        
        // SELECT KELAS & PAKET
        const kelasSelect = modalContent.querySelector('#id_kelas');
        const paketSelect = modalContent.querySelector('#id_paket');
        const hargaPaket = modalContent.querySelector('#hargaPaket');
        if (kelasSelect && paketSelect) {
            kelasSelect.addEventListener('change', function() {
                const jenjang = this.options[this.selectedIndex]?.getAttribute('data-jenjang');
                if (jenjang) { for (let i = 0; i < paketSelect.options.length; i++) { if (paketSelect.options[i].getAttribute('data-tingkat') === jenjang) { paketSelect.value = paketSelect.options[i].value; paketSelect.dispatchEvent(new Event('change')); break; } } }
            });
            paketSelect.addEventListener('change', function() {
                const harga = this.options[this.selectedIndex]?.getAttribute('data-harga');
                if (harga && hargaPaket) hargaPaket.innerHTML = 'Rp ' + new Intl.NumberFormat('id-ID').format(harga);
            });
            if (paketSelect.value) paketSelect.dispatchEvent(new Event('change'));
        }
    }

    // =============================================
    // SEARCH & FILTER
    // =============================================
    document.getElementById('searchInput').addEventListener('keyup', function() {
        let val = this.value.toLowerCase();
        document.querySelectorAll('#tableBody tr').forEach(row => {
            if (row.cells && row.cells.length >= 2) {
                row.style.display = row.cells[1]?.innerText.toLowerCase().includes(val) ? '' : 'none';
            }
        });
    });

    document.getElementById('filterPaket').addEventListener('change', function() {
        let val = this.value;
        document.querySelectorAll('#tableBody tr').forEach(row => {
            if (row.cells && row.cells.length >= 9) {
                row.style.display = (val === '' || row.cells[8]?.innerText.trim() === val) ? '' : 'none';
            }
        });
    });

    document.getElementById('filterTahun').addEventListener('change', function() {
        let val = this.value;
        document.querySelectorAll('#tableBody tr').forEach(row => {
            if (row.cells && row.cells.length >= 10) {
                row.style.display = (val === '' || row.cells[9]?.innerText.trim() === val) ? '' : 'none';
            }
        });
    });

    // =============================================
    // MODAL HAPUS
    // =============================================
    function bukaModalHapus(id, nama) {
        document.getElementById('formHapus').action = "<?php echo e(route($role . '.murid.destroy', '')); ?>/" + id;
        document.getElementById('pesanHapus').innerHTML = `Yakin ingin menghapus data murid <strong>${nama}</strong>?`;
        document.getElementById('modalHapus').style.display = 'flex';
    }

    function tutupModalHapus() {
        document.getElementById('modalHapus').style.display = 'none';
    }
    
    document.getElementById('modalHapus').addEventListener('click', function(e) {
        if (e.target === this) tutupModalHapus();
    });

    // =============================================
    // PAGE SELECT (PAGINATION)
    // =============================================
    document.getElementById('pageSelect').addEventListener('change', function() {
        let perPage = this.value;
        let url = new URL(window.location.href);
        url.searchParams.set('per_page', perPage);
        window.location.href = url.toString();
    });

    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const perPage = urlParams.get('per_page');
        if (perPage && document.getElementById('pageSelect')) {
            document.getElementById('pageSelect').value = perPage;
        }
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Privat-Bimbel\resources\views/dashboard/shared/kelola-murid/kelola-murid.blade.php ENDPATH**/ ?>