

<?php $__env->startSection('title', 'Kelola Admin'); ?>

<?php $__env->startSection('content'); ?>
<div style="width: 100%;">
    
    
    <div style="margin-bottom: 25px;">
        <p style="color: #374151; font-size: 13px; margin: 0 0 4px 0;">
            <?php echo e(\Carbon\Carbon::now()->translatedFormat('F Y')); ?>

        </p>
        <h1 style="font-size: 26px; font-weight: 700; color: #111827; margin: 0; letter-spacing: -0.5px; line-height: 1.2;">
            Kelola Admin
        </h1>
        <p style="color: #374151; font-size: 14px; margin: 4px 0 0 0;">Manajemen Data dan Akun Administrator Sistem</p>
    </div>

    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; gap: 15px;">
        <div style="display: flex; align-items: center; gap: 12px; flex: 1;">
            <div style="position: relative; width: 300px;">
                <i class="fas fa-search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #9CA3AF;"></i>
                <input type="text" id="searchInput" placeholder="Cari Nama Admin..." 
                       style="width: 100%; padding: 10px 15px 10px 45px; border-radius: 12px; border: 1px solid #E5E7EB; outline: none; background: white; font-size: 14px; color: #374151;">
            </div>
        </div>
        
        <button onclick="bukaModalCreate()" style="background-color: #4D0B87; color: white; border: none; padding: 12px 25px; border-radius: 12px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 10px; font-size: 14px; transition: 0.3s; box-shadow: 0 4px 6px rgba(77, 11, 135, 0.2);">
            <i class="fas fa-plus"></i> Tambah
        </button>
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
                    <th style="padding: 15px; font-weight: 700; text-align: center; width: 40px;">No</th>
                    <th style="padding: 15px; font-weight: 700; width: 80px;">ID</th>
                    <th style="padding: 15px; font-weight: 700; width: 130px;">Nama Lengkap</th>
                    <th style="padding: 15px; font-weight: 700; max-width: 100px;">Alamat</th>
                    <th style="padding: 15px; font-weight: 700; width: 100px;">No HP</th>
                    <th style="padding: 15px; font-weight: 700; width: 110px;">Gaji Pokok</th>
                    <th style="padding: 15px; font-weight: 700; width: 150px;">Email</th>
                    <th style="padding: 15px; font-weight: 700; width: 90px;">Username</th>
                    <th style="padding: 15px; font-weight: 700; text-align: center; width: 70px;">Status</th>
                    <th style="padding: 15px; font-weight: 700; text-align: center; width: 185px;">Aksi</th>
                </tr>
            </thead>
            <tbody id="tableBody" style="color: #374151;">
                <?php $__empty_1 = true; $__currentLoopData = $admin; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr style="border-bottom: 1px solid #F3F4F6; transition: 0.2s;" onmouseover="this.style.background='#F9FAFB'" onmouseout="this.style.background='transparent'">
                    <td style="padding: 15px; text-align: center;"><?php echo e($admin->firstItem() + $index); ?></td>
                    <td style="padding: 15px;">AD<?php echo e(str_pad($item->id_user, 4, '0', STR_PAD_LEFT)); ?></td>
                    <td style="padding: 15px; max-width: 130px; overflow: hidden; text-overflow: ellipsis;"><?php echo e($item->pegawai->nama_lengkap ?? '-'); ?></td>
                    <td style="padding: 15px; max-width: 100px; overflow: hidden; text-overflow: ellipsis;" title="<?php echo e($item->pegawai->alamat ?? '-'); ?>"><?php echo e($item->pegawai->alamat ?? '-'); ?></td>
                    <td style="padding: 15px;"><?php echo e($item->pegawai->no_hp ?? '-'); ?></td>
                    <td style="padding: 15px;">
                        <?php if($item->pegawai && $item->pegawai->gaji_pokok): ?>
                            Rp <?php echo e(number_format($item->pegawai->gaji_pokok, 0, ',', '.')); ?>

                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                    <td style="padding: 15px; max-width: 150px; overflow: hidden; text-overflow: ellipsis;"><?php echo e($item->email); ?></td>
                    <td style="padding: 15px;"><?php echo e($item->username); ?></td>
                    <td style="padding: 15px; text-align: center;">
                        <?php if($item->status == 1): ?>
                            <span style="padding: 5px 12px; border-radius: 20px; background: #E1F7E3; color: #0E7490; font-size: 11px;">Aktif</span>
                        <?php else: ?>
                            <span style="padding: 5px 12px; border-radius: 20px; background: #FEE2E2; color: #EF4444; font-size: 11px;">Nonaktif</span>
                        <?php endif; ?>
                    </td>
                    <td style="padding: 15px; white-space: nowrap;">
                    <div style="display: flex; gap: 4px; justify-content: center; flex-wrap: nowrap;">
                        <button onclick="bukaModalEdit(<?php echo e($item->id_user); ?>)" 
                        style="background: #5EB37E; color: white; padding: 5px 8px; border-radius: 6px; border: none; cursor: pointer; font-size: 10px; white-space: nowrap;">
                            <i class="far fa-edit"></i> Edit
                        </button>
                        <button onclick="bukaModalPassword(<?php echo e($item->id_user); ?>, '<?php echo e($item->pegawai->nama_lengkap ?? $item->username); ?>')" 
                        style="background: #F59E0B; color: white; padding: 5px 8px; border-radius: 6px; border: none; cursor: pointer; font-size: 10px; white-space: nowrap;">
                            <i class="fas fa-key"></i> Password
                        </button>
                        <button type="button" onclick="bukaModalHapus('<?php echo e($item->id_user); ?>', '<?php echo e($item->pegawai->nama_lengkap ?? $item->username); ?>')" 
                                style="background: #E35D5D; color: white; padding: 5px 8px; border-radius: 6px; border: none; cursor: pointer; font-size: 10px; white-space: nowrap;">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                        <button type="button" onclick="bukaModalToggle('<?php echo e($item->id_user); ?>', '<?php echo e($item->pegawai->nama_lengkap ?? $item->username); ?>', '<?php echo e($item->status); ?>')" 
                                style="background: <?php echo e($item->status == 1 ? '#EF4444' : '#10B981'); ?>; color: white; padding: 5px 8px; border-radius: 6px; border: none; cursor: pointer; font-size: 10px; white-space: nowrap;">
                            <i class="fas <?php echo e($item->status == 1 ? 'fa-ban' : 'fa-check'); ?>"></i> <?php echo e($item->status == 1 ? 'Nonaktifkan' : 'Aktifkan'); ?>

                        </button>
                    </div>
                </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="10" style="padding: 40px; text-align: center; color: #9CA3AF;">
                        <i class="fas fa-database" style="font-size: 40px; margin-bottom: 10px; display: block;"></i>
                        Belum ada data admin. Silakan tambah data baru.
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
    
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px; padding: 0 5px;">
        <div style="display: flex; align-items: center; gap: 10px;">
            <select id="pageSelect" style="padding: 8px 12px; border-radius: 10px; border: 1px solid #E5E7EB; color: #374151; font-size: 13px; background: white; outline: none; cursor: pointer;">
                <option value="10" <?php echo e(request('per_page', 10) == 10 ? 'selected' : ''); ?>>10 baris</option>
                <option value="25" <?php echo e(request('per_page') == 25 ? 'selected' : ''); ?>>25 baris</option>
                <option value="50" <?php echo e(request('per_page') == 50 ? 'selected' : ''); ?>>50 baris</option>
            </select>
            <span style="color: #374151; font-size: 13px;">Menampilkan <?php echo e($admin->total() ?? 0); ?> data</span>
        </div>
        <div style="display: flex; gap: 5px;">
            <?php if($admin->onFirstPage()): ?>
                <button disabled style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: #F3F4F6; color: #9CA3AF; cursor: not-allowed;"><i class="fas fa-angle-double-left"></i></button>
                <button disabled style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: #F3F4F6; color: #9CA3AF; cursor: not-allowed;"><i class="fas fa-angle-left"></i></button>
            <?php else: ?>
                <a href="<?php echo e($admin->url(1)); ?>&per_page=<?php echo e(request('per_page', 10)); ?>" style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; display: flex; align-items: center; justify-content: center; text-decoration: none;"><i class="fas fa-angle-double-left"></i></a>
                <a href="<?php echo e($admin->previousPageUrl()); ?>&per_page=<?php echo e(request('per_page', 10)); ?>" style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; display: flex; align-items: center; justify-content: center; text-decoration: none;"><i class="fas fa-angle-left"></i></a>
            <?php endif; ?>

            <?php $start = max(1, $admin->currentPage() - 2); $end = min($admin->lastPage(), $admin->currentPage() + 2); ?>
            <?php for($i = $start; $i <= $end; $i++): ?>
                <?php if($i == $admin->currentPage()): ?>
                    <button style="width: 35px; height: 35px; border-radius: 8px; background: #4D0B87; color: white; border: none; font-weight: 600; cursor: pointer;"><?php echo e($i); ?></button>
                <?php else: ?>
                    <a href="<?php echo e($admin->url($i)); ?>&per_page=<?php echo e(request('per_page', 10)); ?>" style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; display: flex; align-items: center; justify-content: center; text-decoration: none;"><?php echo e($i); ?></a>
                <?php endif; ?>
            <?php endfor; ?>

            <?php if($admin->hasMorePages()): ?>
                <a href="<?php echo e($admin->nextPageUrl()); ?>&per_page=<?php echo e(request('per_page', 10)); ?>" style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; display: flex; align-items: center; justify-content: center; text-decoration: none;"><i class="fas fa-angle-right"></i></a>
            <?php else: ?>
                <button disabled style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: #F3F4F6; color: #9CA3AF; cursor: not-allowed;"><i class="fas fa-angle-right"></i></button>
            <?php endif; ?>
        </div>
    </div>

</div>


<div id="modalForm" style="display: none; position: fixed; z-index: 9998; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); backdrop-filter: blur(3px); align-items: center; justify-content: center; overflow-y: auto; padding: 20px;">
    <div style="background: white; border-radius: 20px; width: 700px; max-width: 95%; max-height: 90vh; overflow-y: auto; box-shadow: 0 15px 30px rgba(0,0,0,0.15);" id="modalContent"></div>
</div>


<div id="modalHapus" style="display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); backdrop-filter: blur(3px); align-items: center; justify-content: center;">
    <div style="background: white; padding: 25px; border-radius: 20px; width: 380px; text-align: center; box-shadow: 0 15px 30px rgba(0,0,0,0.15); font-family: 'Poppins', sans-serif;">
        <div style="color: #E35D5D; font-size: 40px; margin-bottom: 10px;"><i class="fas fa-trash-alt"></i></div>
        <h2 style="margin: 0; font-size: 18px; color: #111827; font-weight: 700;">Hapus Admin?</h2>
        <p style="color: #6B7280; font-size: 12px; margin: 8px 0 20px 0; line-height: 1.5;" id="pesanHapus">Apakah Anda yakin ingin menghapus data admin ini?</p>
        <div style="display: flex; gap: 10px; justify-content: center;">
            <button onclick="tutupModalHapus()" style="flex: 1; padding: 10px; border-radius: 10px; border: 1px solid #E5E7EB; background: white; font-weight: 600; font-size: 13px; cursor: pointer;">Batal</button>
            <form id="formHapus" method="POST" style="flex: 1;">
                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                <button type="submit" style="width: 100%; padding: 10px; border-radius: 10px; border: none; background: #E35D5D; color: white; font-weight: 600; font-size: 13px; cursor: pointer;">Ya, Hapus</button>
            </form>
        </div>
    </div>
</div>


<div id="modalToggle" style="display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); backdrop-filter: blur(3px); align-items: center; justify-content: center; font-family: 'Poppins', sans-serif;">
    <div style="background: white; padding: 25px; border-radius: 20px; width: 350px; text-align: center; box-shadow: 0 15px 30px rgba(0,0,0,0.15);">
        <div style="font-size: 40px; margin-bottom: 10px;" id="toggleIcon"></div>
        <h2 style="margin: 0; font-size: 18px; color: #111827; font-weight: 700;" id="toggleJudul"></h2>
        <p style="color: #6B7280; font-size: 12px; margin: 8px 0 20px 0; line-height: 1.5;" id="togglePesan"></p>
        <div style="display: flex; gap: 10px; justify-content: center;">
            <button onclick="tutupModalToggle()" style="flex: 1; padding: 10px; border-radius: 10px; border: 1px solid #E5E7EB; background: white; font-weight: 600; font-size: 13px; cursor: pointer;">Batal</button>
            <form id="formToggle" method="POST" style="flex: 1;">
                <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                <button type="submit" style="width: 100%; padding: 10px; border-radius: 10px; border: none; color: white; font-weight: 600; font-size: 13px; cursor: pointer;" id="btnToggle"></button>
            </form>
        </div>
    </div>
</div>

<script>
    // ========== BUKA MODAL CREATE ==========
    function bukaModalCreate() {
        fetch("<?php echo e(route('superadmin.kelola-admin.create')); ?>")
            .then(r => r.text())
            .then(html => {
                document.getElementById('modalContent').innerHTML = html;
                document.getElementById('modalForm').style.display = 'flex';
                setTimeout(() => pasangEventHandler(), 150);
            });
    }

    // ========== BUKA MODAL EDIT ==========
    function bukaModalEdit(id) {
        fetch("<?php echo e(route('superadmin.kelola-admin.edit', '')); ?>/" + id)
            .then(r => r.text())
            .then(html => {
                document.getElementById('modalContent').innerHTML = html;
                document.getElementById('modalForm').style.display = 'flex';
                setTimeout(() => pasangEventHandler(), 150);
            });
    }

    // ========== TUTUP MODAL ==========
    function tutupModalForm() {
        document.getElementById('modalForm').style.display = 'none';
        document.getElementById('modalContent').innerHTML = '';
    }

    document.getElementById('modalForm').addEventListener('click', function(e) {
        if (e.target === this) tutupModalForm();
    });

    // ========== PASANG EVENT HANDLER ==========
    function pasangEventHandler() {
        const mc = document.getElementById('modalContent');
        if (!mc) return;

        const form = mc.querySelector('#mainForm');
        const btnKeluar = mc.querySelector('#btnKeluar');
        const btnSimpan = mc.querySelector('#btnSimpan');
        const btnUpdate = mc.querySelector('#btnUpdate');
        const modalBatal = mc.querySelector('#modalBatal');
        const modalPindah = mc.querySelector('#modalPindahHalaman');
        const modalSukses = mc.querySelector('#modalSukses');
        const btnTidakBatal = mc.querySelector('#btnTidakBatal');
        const btnYaKeluar = mc.querySelector('#btnYaKeluar');
        const btnTidakPindah = mc.querySelector('#btnTidakPindah');
        const btnYaPindah = mc.querySelector('#btnYaPindah');
        const btnOkSukses = mc.querySelector('#btnOkSukses');
        const alertError = mc.querySelector('#alertError');
        const alertErrorText = mc.querySelector('#alertErrorText');
        const pesanSukses = mc.querySelector('#pesanSukses');

        let formChanged = false;
        let formSubmitted = false;

        // Deteksi perubahan form
        if (form) {
            form.querySelectorAll('input:not([readonly]), select, textarea').forEach(el => {
                el.addEventListener('input', () => { if (!formSubmitted) formChanged = true; });
                el.addEventListener('change', () => { if (!formSubmitted) formChanged = true; });
            });
        }

        // Tombol Keluar
        if (btnKeluar) {
            btnKeluar.addEventListener('click', function(e) {
                e.preventDefault();
                if (formChanged && !formSubmitted) {
                    if (modalPindah) modalPindah.style.display = 'flex';
                } else {
                    if (modalBatal) modalBatal.style.display = 'flex';
                }
            });
        }

        // Modal Batal
        if (btnTidakBatal) btnTidakBatal.addEventListener('click', () => { if (modalBatal) modalBatal.style.display = 'none'; });
        if (btnYaKeluar) btnYaKeluar.addEventListener('click', () => { formChanged = false; if (modalBatal) modalBatal.style.display = 'none'; tutupModalForm(); });
        if (modalBatal) modalBatal.addEventListener('click', e => { if (e.target === modalBatal) modalBatal.style.display = 'none'; });

        // Modal Pindah
        if (btnTidakPindah) btnTidakPindah.addEventListener('click', () => { if (modalPindah) modalPindah.style.display = 'none'; });
        if (btnYaPindah) btnYaPindah.addEventListener('click', () => { formChanged = false; if (modalPindah) modalPindah.style.display = 'none'; tutupModalForm(); });
        if (modalPindah) modalPindah.addEventListener('click', e => { if (e.target === modalPindah) modalPindah.style.display = 'none'; });

        // Modal Sukses
        if (btnOkSukses) btnOkSukses.addEventListener('click', () => { if (modalSukses) modalSukses.style.display = 'none'; tutupModalForm(); window.location.reload(); });
        if (modalSukses) modalSukses.addEventListener('click', e => { if (e.target === modalSukses) { modalSukses.style.display = 'none'; tutupModalForm(); window.location.reload(); } });

        // Submit Form
        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const fd = new FormData(form);
                const btn = btnSimpan || btnUpdate;
                const orig = btn ? btn.innerHTML : 'Simpan';
                if (btn) { btn.disabled = true; btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...'; }

                fetch(form.action, {
                    method: 'POST',
                    body: fd,
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
                        let msg = data.message || 'Gagal';
                        if (data.errors) { msg = ''; for (let f in data.errors) msg += data.errors[f].join('\n') + '\n'; }
                        if (alertError && alertErrorText) { alertErrorText.textContent = msg; alertError.style.display = 'flex'; setTimeout(() => alertError.style.display = 'none', 5000); }
                        if (btn) { btn.disabled = false; btn.innerHTML = orig; }
                    }
                })
                .catch(err => {
                    if (alertError && alertErrorText) { alertErrorText.textContent = 'Error: ' + err.message; alertError.style.display = 'flex'; setTimeout(() => alertError.style.display = 'none', 5000); }
                    if (btn) { btn.disabled = false; btn.innerHTML = orig; }
                });
            });
        }
    }

    // ========== MODAL UBAH PASSWORD ==========
    function bukaModalPassword(id, nama) {
        const html = `
        <div style="padding:20px;font-family:'Poppins',sans-serif;background:#FFF;border-radius:16px">
            <div style="margin-bottom:20px;padding-bottom:14px;border-bottom:1.5px solid #F3F4F6">
                <h2 style="font-size:19px;font-weight:700;color:#111827;margin:0">Ubah Password</h2>
                <p style="color:#9CA3AF;font-size:12px;margin:2px 0 0 0">${nama}</p>
            </div>
            <div id="alertErrorPass" style="display:none;background:#FEE2E2;color:#991B1B;padding:12px 15px;border-radius:10px;margin-bottom:15px;align-items:center;gap:10px">
                <i class="fas fa-exclamation-circle" style="font-size:18px"></i>
                <span id="alertErrorPassText"></span>
            </div>
            <form id="formPassword">
                <div style="margin-bottom:15px">
                    <label style="display:block;font-weight:600;font-size:14px;color:#374151;margin-bottom:6px">Password Baru <span style="color:#EF4444">*</span></label>
                    <input type="password" id="pass1" required placeholder="Masukkan password baru" style="width:100%;padding:12px 15px;border-radius:12px;border:1.5px solid #E5E7EB;background:#FFF;outline:none;font-size:14px;font-family:'Poppins',sans-serif">
                </div>
                <div style="margin-bottom:15px">
                    <label style="display:block;font-weight:600;font-size:14px;color:#374151;margin-bottom:6px">Konfirmasi Password <span style="color:#EF4444">*</span></label>
                    <input type="password" id="pass2" required placeholder="Konfirmasi password baru" style="width:100%;padding:12px 15px;border-radius:12px;border:1.5px solid #E5E7EB;background:#FFF;outline:none;font-size:14px;font-family:'Poppins',sans-serif">
                </div>
                <div style="display:flex;justify-content:flex-end;gap:20px;margin-top:30px;padding-top:16px;border-top:1.5px solid #F3F4F6">
                    <button type="button" id="btnKeluarPass" style="padding:10px 45px;border:1.5px solid #4D0B87;color:#4D0B87;border-radius:10px;font-weight:600;font-size:16px;background:#FFF;cursor:pointer">Keluar</button>
                    <button type="submit" id="btnSimpanPass" style="padding:10px 45px;border:none;background:#4D0B87;color:#fff;border-radius:10px;font-weight:600;font-size:16px;cursor:pointer;box-shadow:0 4px 6px rgba(77,11,135,0.2)">Simpan</button>
                </div>
            </form>
        </div>
        <div id="modalSuksesPass" style="display:none;position:fixed;z-index:99999;left:0;top:0;width:100%;height:100%;background:rgba(0,0,0,0.4);backdrop-filter:blur(3px);align-items:center;justify-content:center">
            <div style="background:#fff;padding:25px;border-radius:20px;width:320px;text-align:center;box-shadow:0 15px 30px rgba(0,0,0,0.15);font-family:'Poppins',sans-serif">
                <div style="color:#10B981;font-size:50px;margin-bottom:10px"><i class="fas fa-check-circle"></i></div>
                <h2 style="margin:0;font-size:18px;color:#111827;font-weight:700">Berhasil!</h2>
                <p style="color:#6B7280;font-size:13px;margin:8px 0 20px 0">Password berhasil diubah.</p>
                <button type="button" id="btnOkPass" style="width:100%;padding:10px;border-radius:10px;border:none;background:#10B981;color:#fff;font-weight:600;font-size:13px;cursor:pointer">OK</button>
            </div>
        </div>`;
        
        document.getElementById('modalContent').innerHTML = html;
        document.getElementById('modalForm').style.display = 'flex';

        setTimeout(() => {
            const f = document.getElementById('formPassword');
            const eDiv = document.getElementById('alertErrorPass');
            const eTxt = document.getElementById('alertErrorPassText');
            const sDiv = document.getElementById('modalSuksesPass');
            
            document.getElementById('btnKeluarPass').addEventListener('click', () => tutupModalForm());
            
            document.getElementById('btnOkPass').addEventListener('click', () => {
                sDiv.style.display = 'none';
                tutupModalForm();
                window.location.reload();
            });
            
            sDiv.addEventListener('click', function(e) {
                if (e.target === sDiv) {
                    sDiv.style.display = 'none';
                    tutupModalForm();
                    window.location.reload();
                }
            });

            f.addEventListener('submit', function(e) {
                e.preventDefault();
                const p1 = document.getElementById('pass1').value;
                const p2 = document.getElementById('pass2').value;
                const btn = document.getElementById('btnSimpanPass');

                if (p1 !== p2) {
                    eTxt.textContent = 'Konfirmasi password tidak cocok!';
                    eDiv.style.display = 'flex';
                    setTimeout(() => eDiv.style.display = 'none', 3000);
                    return;
                }
                if (p1.length < 6) {
                    eTxt.textContent = 'Password minimal 6 karakter!';
                    eDiv.style.display = 'flex';
                    setTimeout(() => eDiv.style.display = 'none', 3000);
                    return;
                }

                btn.disabled = true;
                btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';

                fetch("<?php echo e(route('superadmin.kelola-admin.updatePassword', '')); ?>/" + id, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ password: p1, password_confirmation: p2 })
                })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        sDiv.style.display = 'flex';
                    } else {
                        eTxt.textContent = data.message || 'Gagal';
                        eDiv.style.display = 'flex';
                        setTimeout(() => eDiv.style.display = 'none', 3000);
                        btn.disabled = false;
                        btn.innerHTML = 'Simpan';
                    }
                })
                .catch(err => {
                    eTxt.textContent = 'Error: ' + err.message;
                    eDiv.style.display = 'flex';
                    setTimeout(() => eDiv.style.display = 'none', 3000);
                    btn.disabled = false;
                    btn.innerHTML = 'Simpan';
                });
            });
        }, 150);
    }

    // ========== MODAL TOGGLE STATUS ==========
    function bukaModalToggle(id, nama, status) {
        document.getElementById('formToggle').action = "<?php echo e(route('superadmin.kelola-admin.toggleStatus', ':id')); ?>".replace(':id', id);
        
        if (status == 1) {
            document.getElementById('toggleIcon').innerHTML = '<i class="fas fa-ban" style="color:#EF4444;"></i>';
            document.getElementById('toggleJudul').textContent = 'Nonaktifkan Admin?';
            document.getElementById('togglePesan').innerHTML = `Apakah Anda yakin ingin <strong>menonaktifkan</strong> admin <strong>${nama}</strong>?<br><small style="color:#EF4444;">Admin tidak akan bisa login sampai diaktifkan kembali.</small>`;
            document.getElementById('btnToggle').textContent = 'Ya, Nonaktifkan';
            document.getElementById('btnToggle').style.background = '#EF4444';
        } else {
            document.getElementById('toggleIcon').innerHTML = '<i class="fas fa-check-circle" style="color:#10B981;"></i>';
            document.getElementById('toggleJudul').textContent = 'Aktifkan Admin?';
            document.getElementById('togglePesan').innerHTML = `Apakah Anda yakin ingin <strong>mengaktifkan</strong> admin <strong>${nama}</strong>?<br><small style="color:#10B981;">Admin akan bisa login kembali.</small>`;
            document.getElementById('btnToggle').textContent = 'Ya, Aktifkan';
            document.getElementById('btnToggle').style.background = '#10B981';
        }
        
        document.getElementById('modalToggle').style.display = 'flex';
    }

    function tutupModalToggle() { document.getElementById('modalToggle').style.display = 'none'; }
    document.getElementById('modalToggle').addEventListener('click', function(e) { if (e.target === this) tutupModalToggle(); });

    // ========== SEARCH ==========
    document.getElementById('searchInput').addEventListener('keyup', function() {
        const v = this.value.toLowerCase();
        document.querySelectorAll('#tableBody tr').forEach(row => {
            if (row.cells && row.cells.length >= 3) {
                row.style.display = row.cells[2]?.innerText.toLowerCase().includes(v) ? '' : 'none';
            }
        });
    });

    // ========== PAGE SELECT ==========
    document.getElementById('pageSelect').addEventListener('change', function() {
        let url = new URL(window.location.href);
        url.searchParams.set('per_page', this.value);
        url.searchParams.delete('page');
        window.location.href = url.toString();
    });

    // ========== MODAL HAPUS ==========
    function bukaModalHapus(id, nama) {
        document.getElementById('formHapus').action = "<?php echo e(route('superadmin.kelola-admin.destroy', ':id')); ?>".replace(':id', id);
        document.getElementById('pesanHapus').innerHTML = `Apakah Anda <strong>benar-benar yakin</strong> ingin menghapus data admin <strong>${nama}</strong>?<br><br><small style="color:#EF4444;">⚠️ <strong>PERINGATAN:</strong> Data akan dihapus <strong>secara permanen</strong> dari database. Semua data yang berhubungan dengan admin ini juga akan <strong>tidak dapat dikembalikan</strong>.</small>`;
        document.getElementById('modalHapus').style.display = 'flex';
    }
    function tutupModalHapus() { document.getElementById('modalHapus').style.display = 'none'; }
    document.getElementById('modalHapus').addEventListener('click', function(e) {
        if (e.target === this) tutupModalHapus();
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Privat-Bimbel\resources\views/dashboard/superadmin/kelola-admin/kelola-admin.blade.php ENDPATH**/ ?>