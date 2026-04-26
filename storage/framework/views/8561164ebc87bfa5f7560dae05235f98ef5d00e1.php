

<?php $__env->startSection('title', 'Riwayat Pembayaran'); ?>

<?php $__env->startSection('content'); ?>
<div style="width: 100%;">

    <div style="margin-bottom: 25px;">
        <p style="color: #374151; font-size: 13px; margin: 0 0 4px 0;"><?php echo e(\Carbon\Carbon::now()->translatedFormat('F Y')); ?></p>
        <h1 style="font-size: 26px; font-weight: 700; color: #111827; margin: 0;">Riwayat Pembayaran</h1>
        <p style="color: #374151; font-size: 14px; margin: 4px 0 0 0;">Riwayat Pembayaran Murid</p>
    </div>

    <div style="display: flex; justify-content: flex-end; margin-bottom: 25px;">
        <button onclick="bukaModalCreate()" style="background-color: #4D0B87; color: white; border: none; padding: 12px 25px; border-radius: 12px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 10px; font-size: 14px; box-shadow: 0 4px 6px rgba(77, 11, 135, 0.2);">
            <i class="fas fa-plus"></i> Input Pembayaran Murid
        </button>
    </div>

    <?php if(session('success')): ?>
        <div style="background: #D1FAE5; color: #065F46; padding: 12px; border-radius: 10px; margin-bottom: 20px;"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <div style="background: white; border-radius: 16px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.06); margin-bottom: 20px;">
        <div style="position: relative; margin-bottom: 12px;">
            <i class="fas fa-search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #9CA3AF;"></i>
            <input type="text" id="searchRiwayat" placeholder="Cari Nama Murid..." style="width: 100%; padding: 12px 15px 12px 45px; border-radius: 12px; border: 1px solid #E5E7EB; background: #F9FAFB; font-size: 14px;">
        </div>
        <div style="display: flex; gap: 12px; flex-wrap: wrap;">
            <select id="filterPaketRiwayat" style="flex: 1; padding: 10px 14px; border-radius: 12px; border: 1px solid #E5E7EB; background: #F9FAFB; font-size: 13px;">
                <option value="">Status Paket</option>
                <?php $__currentLoopData = $paketList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($paket->tingkat); ?>"><?php echo e($paket->tingkat); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <select id="filterJenisPembayaran" style="flex: 1; padding: 10px 14px; border-radius: 12px; border: 1px solid #E5E7EB; background: #F9FAFB; font-size: 13px;">
                <option value="">Jenis Pembayaran</option>
                <option value="Tunai">Tunai</option><option value="Transfer">Transfer</option>
            </select>
            <select id="filterBulan" style="flex: 1; padding: 10px 14px; border-radius: 12px; border: 1px solid #E5E7EB; background: #F9FAFB; font-size: 13px;">
                <option value="">Pilih Bulan</option>
                <option value="1">Januari</option><option value="2">Februari</option><option value="3">Maret</option>
                <option value="4">April</option><option value="5">Mei</option><option value="6">Juni</option>
                <option value="7">Juli</option><option value="8">Agustus</option><option value="9">September</option>
                <option value="10">Oktober</option><option value="11">November</option><option value="12">Desember</option>
            </select>
            <select id="filterTahunRiwayat" style="flex: 1; padding: 10px 14px; border-radius: 12px; border: 1px solid #E5E7EB; background: #F9FAFB; font-size: 13px;">
                <option value="">Pilih Tahun</option>
            </select>
        </div>
    </div>

    <div style="background: white; border-radius: 20px; overflow-x: auto; box-shadow: 0 4px 15px rgba(0,0,0,0.08);">
        <table style="width: 100%; border-collapse: collapse; font-size: 13px; white-space: nowrap;">
            <thead><tr style="background: #F3E8FF;">
                <th style="padding: 15px;">No</th><th style="padding: 15px;">Tanggal</th><th style="padding: 15px;">Nama Murid</th>
                <th style="padding: 15px;">Paket Awal</th><th style="padding: 15px;">Paket Belajar</th>
                <th style="padding: 15px;">Untuk Bulan</th><th style="padding: 15px;">Jenis</th>
                <th style="padding: 15px; text-align: center;">Total Bayar</th><th style="padding: 15px;">Keterangan</th>
            </tr></thead>
            <tbody id="riwayatTableBody">
                <?php $__empty_1 = true; $__currentLoopData = $riwayat; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr style="border-bottom: 1px solid #F3F4F6;">
                    <td style="padding: 15px;"><?php echo e($index + 1); ?></td>
                    <td style="padding: 15px;"><?php echo e($r->tanggal); ?></td>
                    <td style="padding: 15px;"><?php echo e($r->nama_murid); ?></td>
                    <td style="padding: 15px;"><?php echo e($r->paket_awal); ?></td>
                    <td style="padding: 15px;"><?php echo e($r->paket_selanjutnya); ?></td>
                    <td style="padding: 15px;"><?php echo e($r->bulan_dibayar); ?></td>
                    <td style="padding: 15px;"><?php echo e($r->jenis_pembayaran ?? '-'); ?></td>
                    <td style="padding: 15px; text-align: center; font-weight: 700; color: #4D0B87;"><?php echo e($r->total_bayar); ?></td>
                    <td style="padding: 15px;"><?php echo e($r->keterangan); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="9" style="padding: 40px; text-align: center; color: #9CA3AF;">Belum ada riwayat pembayaran</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>


<div id="modalForm" style="display: none; position: fixed; z-index: 9998; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); backdrop-filter: blur(3px); align-items: center; justify-content: center; overflow-y: auto; padding: 20px;">
    <div style="background: white; border-radius: 20px; width: 750px; max-width: 95%; max-height: 90vh; overflow-y: auto; box-shadow: 0 15px 30px rgba(0,0,0,0.15);" id="modalContent"></div>
</div>

<script>
    function bukaModalCreate() {
        fetch("<?php echo e(route($role . '.pembayaran.create')); ?>")
            .then(r => r.text())
            .then(html => {
                document.getElementById('modalContent').innerHTML = html;
                document.getElementById('modalForm').style.display = 'flex';
                setTimeout(() => pasangEventHandlerPembayaran(), 150);
            });
    }

    function tutupModalForm() {
        document.getElementById('modalForm').style.display = 'none';
        document.getElementById('modalContent').innerHTML = '';
    }

    document.getElementById('modalForm').addEventListener('click', function(e) { if (e.target === this) tutupModalForm(); });

    // Copy paste function pasangEventHandlerPembayaran dari tagihan.blade.php
    function pasangEventHandlerPembayaran() {
        const mc = document.getElementById('modalContent');
        if (!mc) return;
        const form = mc.querySelector('#mainForm');
        const btnKeluar = mc.querySelector('#btnKeluar');
        const btnSimpan = mc.querySelector('#btnSimpan');
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
        let formChanged = false, formSubmitted = false;
        if (form) { form.querySelectorAll('input, select, textarea').forEach(el => { el.addEventListener('input', () => { if (!formSubmitted) formChanged = true; }); el.addEventListener('change', () => { if (!formSubmitted) formChanged = true; }); }); }
        if (btnKeluar) btnKeluar.addEventListener('click', function(e) { e.preventDefault(); if (formChanged && !formSubmitted) { if (modalPindah) modalPindah.style.display = 'flex'; } else { if (modalBatal) modalBatal.style.display = 'flex'; } });
        if (btnTidakBatal) btnTidakBatal.addEventListener('click', () => { if (modalBatal) modalBatal.style.display = 'none'; });
        if (btnYaKeluar) btnYaKeluar.addEventListener('click', () => { formChanged = false; if (modalBatal) modalBatal.style.display = 'none'; tutupModalForm(); });
        if (modalBatal) modalBatal.addEventListener('click', e => { if (e.target === modalBatal) modalBatal.style.display = 'none'; });
        if (btnTidakPindah) btnTidakPindah.addEventListener('click', () => { if (modalPindah) modalPindah.style.display = 'none'; });
        if (btnYaPindah) btnYaPindah.addEventListener('click', () => { formChanged = false; if (modalPindah) modalPindah.style.display = 'none'; tutupModalForm(); });
        if (modalPindah) modalPindah.addEventListener('click', e => { if (e.target === modalPindah) modalPindah.style.display = 'none'; });
        if (btnOkSukses) btnOkSukses.addEventListener('click', () => { if (modalSukses) modalSukses.style.display = 'none'; tutupModalForm(); window.location.reload(); });
        if (modalSukses) modalSukses.addEventListener('click', e => { if (e.target === modalSukses) { modalSukses.style.display = 'none'; tutupModalForm(); window.location.reload(); } });
        if (form) { form.addEventListener('submit', function(e) { e.preventDefault(); const fd = new FormData(form); const btn = btnSimpan; const orig = btn ? btn.innerHTML : 'Simpan'; if (btn) { btn.disabled = true; btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...'; } fetch(form.action, { method: 'POST', body: fd, headers: { 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '', 'Accept': 'application/json' } }).then(r => r.json()).then(data => { if (data.success) { formChanged = false; formSubmitted = true; if (pesanSukses) pesanSukses.textContent = data.message || 'Pembayaran berhasil disimpan.'; if (modalSukses) modalSukses.style.display = 'flex'; } else { let msg = data.message || 'Gagal'; if (data.errors) { msg = ''; for (let f in data.errors) msg += data.errors[f].join('\n') + '\n'; } if (alertError && alertErrorText) { alertErrorText.textContent = msg; alertError.style.display = 'flex'; setTimeout(() => alertError.style.display = 'none', 5000); } if (btn) { btn.disabled = false; btn.innerHTML = orig; } } }).catch(err => { if (alertError && alertErrorText) { alertErrorText.textContent = 'Error: ' + err.message; alertError.style.display = 'flex'; setTimeout(() => alertError.style.display = 'none', 5000); } if (btn) { btn.disabled = false; btn.innerHTML = orig; } }); }); }
        const si = mc.querySelector('#searchMurid');
        const ad = mc.querySelector('#autocompleteResult');
        const ih = mc.querySelector('#id_murid');
        if (si) { si.addEventListener('input', function() { const q = this.value.trim(); if (q.length < 2) { ad.style.display = 'none'; return; } fetch('/search-murid?q=' + encodeURIComponent(q)).then(r => r.json()).then(data => { if (data.length) { ad.innerHTML = data.map(m => `<div style="padding:10px 15px;cursor:pointer;border-bottom:1px solid #F3F4F6;" data-id="${m.id_murid}"><strong>${m.nama_lengkap}</strong></div>`).join(''); ad.style.display = 'block'; ad.querySelectorAll('div[data-id]').forEach(item => { item.addEventListener('click', function() { si.value = this.querySelector('strong').innerText; ih.value = this.dataset.id; ad.style.display = 'none'; fetch('/cek-status-pembayaran/' + this.dataset.id).then(r => r.json()).then(d => { const info = mc.querySelector('#infoStatusMurid'); const ps = mc.querySelector('#paket_selanjutnya'); const ti = mc.querySelector('#total_pembayaran'); if (!d.sudah_bayar_pendaftaran) { info.innerHTML = '<div style="padding:12px;background:#FEF3C7;color:#92400E;"><strong>Pendaftaran Baru!</strong></div>'; info.style.display = 'block'; if (ps) ps.disabled = true; if (ti) ti.value = '100000'; } else { info.innerHTML = '<div style="padding:12px;background:#E0E7FF;color:#1E40AF;"><strong>Sudah Terdaftar!</strong></div>'; info.style.display = 'block'; if (ps) { ps.disabled = false; if (d.paket_aktif) { ps.value = d.paket_aktif; if (ti) ti.value = parseInt(ps.options[ps.selectedIndex]?.dataset?.harga) || 0; } } } }); }); }); } else { ad.innerHTML = '<div style="padding:10px;">Tidak ditemukan</div>'; ad.style.display = 'block'; } }); }); }
        document.addEventListener('click', function(e) { if (si && !si.contains(e.target) && ad && !ad.contains(e.target)) ad.style.display = 'none'; });
    }

    function filterRiwayat() {
        const s = document.getElementById('searchRiwayat')?.value.toLowerCase() || '';
        const fp = document.getElementById('filterPaketRiwayat')?.value || '';
        const fj = document.getElementById('filterJenisPembayaran')?.value || '';
        const fb = document.getElementById('filterBulan')?.value || '';
        const ft = document.getElementById('filterTahunRiwayat')?.value || '';
        document.querySelectorAll('#riwayatTableBody tr').forEach(row => {
            if (!row.cells || row.cells.length < 9) return;
            const n = row.cells[2]?.innerText.toLowerCase() || '';
            const p = row.cells[4]?.innerText || '';
            const j = row.cells[6]?.innerText || '';
            const tgl = row.cells[1]?.innerText || '';
            const parts = tgl.split('/');
            const b = parts[1] ? parseInt(parts[1]) : 0;
            const t = parts[2] ? parseInt(parts[2]) : 0;
            let show = true;
            if (s && !n.includes(s)) show = false;
            if (fp && p !== fp) show = false;
            if (fj && j !== fj) show = false;
            if (fb && b !== parseInt(fb)) show = false;
            if (ft && t !== parseInt(ft)) show = false;
            row.style.display = show ? '' : 'none';
        });
    }
    document.getElementById('searchRiwayat')?.addEventListener('keyup', filterRiwayat);
    document.getElementById('filterPaketRiwayat')?.addEventListener('change', filterRiwayat);
    document.getElementById('filterJenisPembayaran')?.addEventListener('change', filterRiwayat);
    document.getElementById('filterBulan')?.addEventListener('change', filterRiwayat);
    document.getElementById('filterTahunRiwayat')?.addEventListener('change', filterRiwayat);
    const ts = document.getElementById('filterTahunRiwayat');
    if (ts) { const tSet = new Set(); document.querySelectorAll('#riwayatTableBody tr').forEach(row => { if (row.cells && row.cells[1]) { const tgl = row.cells[1].innerText; const parts = tgl.split('/'); if (parts[2]) tSet.add(parseInt(parts[2])); } }); Array.from(tSet).sort().reverse().forEach(tahun => { const o = document.createElement('option'); o.value = tahun; o.textContent = tahun; ts.appendChild(o); }); }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Privat-Bimbel\resources\views/dashboard/shared/pembayaran/riwayat.blade.php ENDPATH**/ ?>