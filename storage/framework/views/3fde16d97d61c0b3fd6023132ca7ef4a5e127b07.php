<div style="padding: 24px; font-family: 'Poppins', sans-serif; background: #FFFFFF; border-radius: 16px;">

    
    <div style="margin-bottom: 22px; padding-bottom: 14px; border-bottom: 1.5px solid #F3F4F6;">
        <h2 style="font-size: 19px; font-weight: 700; color: #111827; margin: 0;">Input Pembayaran Murid</h2>
        <p style="color: #9CA3AF; font-size: 12px; margin: 3px 0 0 0;">Form pembayaran untuk murid</p>
    </div>

    
    <div id="alertError" style="display: none; background: #FEE2E2; color: #991B1B; padding: 12px 15px; border-radius: 10px; margin-bottom: 15px; align-items: center; gap: 10px;">
        <i class="fas fa-exclamation-circle" style="font-size: 18px; flex-shrink: 0;"></i>
        <span id="alertErrorText"></span>
    </div>

    <form id="mainForm" action="<?php echo e(route($role . '.pembayaran.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>

        <input type="hidden" name="kategori_pemasukan" value="murid">

        
        <div style="margin-bottom: 15px;">
            <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 6px;">
                Tanggal <span style="color: #EF4444;">*</span>
            </label>
            <input type="date" name="tanggal" id="tanggal" value="<?php echo e(date('Y-m-d')); ?>"
                   style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: #FFFFFF; outline: none; font-size: 14px; font-family: 'Poppins', sans-serif; color: #374151; box-sizing: border-box;">
        </div>

        
        <div style="margin-bottom: 15px;">
            <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 6px;">
                Jenis Pembayaran <span style="color: #EF4444;">*</span>
            </label>
            <select name="jenis_pembayaran" id="jenis_pembayaran"
                    style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: #FFFFFF; outline: none; font-size: 14px; font-family: 'Poppins', sans-serif; cursor: pointer; color: #374151;">
                <option value="">Pilih Jenis Pembayaran</option>
                <option value="Tunai">Tunai</option>
                <option value="Transfer">Transfer</option>
            </select>
        </div>

        
        <div style="margin-bottom: 15px; position: relative;">
            <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 6px;">
                Nama Murid <span style="color: #EF4444;">*</span>
            </label>
            <input type="text" id="searchMurid" name="search_murid" placeholder="Ketik nama murid..." autocomplete="off"
                   style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: #FFFFFF; outline: none; font-size: 14px; font-family: 'Poppins', sans-serif; color: #374151; box-sizing: border-box;">
            <div id="autocompleteResult"
                 style="position: absolute; z-index: 1000; background: white; border: 1px solid #E5E7EB; border-radius: 12px; width: 100%; max-height: 200px; overflow-y: auto; margin-top: 5px; box-shadow: 0 4px 12px rgba(0,0,0,0.12); display: none; font-family: 'Poppins', sans-serif;"></div>
            <input type="hidden" name="id_murid" id="id_murid">
            <small style="color: #9CA3AF; font-size: 12px;">Ketik minimal 2 huruf untuk mencari murid</small>
        </div>

        
        <div id="infoStatusMurid" style="display: none; margin-bottom: 15px;"></div>

        
        <div style="margin-bottom: 15px;">
            <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 6px;">
                Paket Awal (Pendaftaran)
            </label>
            <input type="text" id="paket_awal_display" readonly value="Rp 100.000"
                   style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: #F3F4F6; color: #6B7280; font-size: 14px; font-family: 'Poppins', sans-serif; box-sizing: border-box;">
            <input type="hidden" name="paket_awal" id="paket_awal" value="100000">
        </div>

        
        <div style="margin-bottom: 15px;">
            <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 6px;">
                Paket Belajar
            </label>
            <select name="paket_selanjutnya" id="paket_selanjutnya"
                    style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: #FFFFFF; outline: none; font-size: 14px; font-family: 'Poppins', sans-serif; cursor: pointer; color: #374151;">
                <option value="">Pilih Paket</option>
                <?php $__currentLoopData = $pakets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($paket->tingkat); ?>" data-harga="<?php echo e($paket->harga); ?>">
                        <?php echo e($paket->tingkat); ?> — Rp <?php echo e(number_format($paket->harga, 0, ',', '.')); ?> / bulan
                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        
        <div id="infoHarga" style="margin-bottom: 15px; padding: 12px 15px; background: #E0E7FF; border-radius: 10px; display: none; color: #3730A3; font-size: 13px;">
            <i class="fas fa-info-circle"></i> Harga: <strong id="hargaPaketValue">Rp 0</strong> / bulan
        </div>

        
        <div style="margin-bottom: 15px;">
            <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 6px;">
                Total Pembayaran <span style="color: #EF4444;">*</span>
            </label>
            <input type="text" name="total_pembayaran" id="total_pembayaran" placeholder="Masukkan Total Pembayaran"
                   oninput="this.value = this.value.replace(/[^0-9]/g, ''); updatePreview();"
                   style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: #FFFFFF; outline: none; font-size: 14px; font-family: 'Poppins', sans-serif; color: #374151; box-sizing: border-box;">
        </div>

        
        <div id="previewStatus" style="margin-bottom: 15px; padding: 12px 15px; border-radius: 10px; display: none; font-size: 13px;"></div>

        
        <div style="margin-bottom: 5px;">
            <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 6px;">
                Keterangan
            </label>
            <textarea name="keterangan" id="keterangan" rows="3" placeholder="Masukkan Keterangan (opsional)"
                      style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: #FFFFFF; outline: none; font-size: 14px; resize: vertical; font-family: 'Poppins', sans-serif; color: #374151; box-sizing: border-box;"></textarea>
        </div>

        
        <input type="hidden" name="bulan_dibayar" id="bulan_dibayar" value="">

        
        <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 28px; padding-top: 16px; border-top: 1.5px solid #F3F4F6;">
            <button type="button" id="btnKeluar"
                    style="padding: 11px 40px; border: 1.5px solid #4D0B87; color: #4D0B87; border-radius: 10px; font-weight: 600; font-size: 15px; background: #FFFFFF; cursor: pointer; font-family: 'Poppins', sans-serif;">
                Keluar
            </button>
            <button type="submit" id="btnSimpan"
                    style="padding: 11px 40px; border: none; background: #4D0B87; color: white; border-radius: 10px; font-weight: 600; font-size: 15px; cursor: pointer; font-family: 'Poppins', sans-serif; box-shadow: 0 4px 10px rgba(77,11,135,0.25);">
                Simpan
            </button>
        </div>
    </form>
</div>


<div id="modalBatal" style="display: none; position: fixed; z-index: 99999; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.45); backdrop-filter: blur(3px); align-items: center; justify-content: center; font-family: 'Poppins', sans-serif;">
    <div style="background: white; padding: 28px 24px; border-radius: 20px; width: 320px; text-align: center; box-shadow: 0 15px 40px rgba(0,0,0,0.18);">
        <div style="color: #F59E0B; font-size: 42px; margin-bottom: 10px;"><i class="fas fa-exclamation-triangle"></i></div>
        <h2 style="margin: 0; font-size: 18px; font-weight: 700; color: #111827;">Batalkan?</h2>
        <p style="color: #6B7280; font-size: 13px; margin: 8px 0 22px 0;">Data yang Anda masukkan tidak akan disimpan.</p>
        <div style="display: flex; gap: 10px; justify-content: center;">
            <button type="button" id="btnTidakBatal"
                    style="flex: 1; padding: 10px; border-radius: 10px; border: 1.5px solid #E5E7EB; background: white; color: #374151; font-weight: 600; font-size: 13px; cursor: pointer; font-family: 'Poppins', sans-serif;">Tidak</button>
            <button type="button" id="btnYaKeluar"
                    style="flex: 1; padding: 10px; border-radius: 10px; border: none; background: #EF4444; color: white; font-weight: 600; font-size: 13px; cursor: pointer; font-family: 'Poppins', sans-serif;">Ya, Keluar</button>
        </div>
    </div>
</div>


<div id="modalPindahHalaman" style="display: none; position: fixed; z-index: 99999; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.45); backdrop-filter: blur(3px); align-items: center; justify-content: center; font-family: 'Poppins', sans-serif;">
    <div style="background: white; padding: 28px 24px; border-radius: 20px; width: 320px; text-align: center; box-shadow: 0 15px 40px rgba(0,0,0,0.18);">
        <div style="color: #F59E0B; font-size: 42px; margin-bottom: 10px;"><i class="fas fa-exclamation-triangle"></i></div>
        <h2 style="margin: 0; font-size: 18px; font-weight: 700; color: #111827;">Perubahan Belum Disimpan</h2>
        <p style="color: #6B7280; font-size: 13px; margin: 8px 0 22px 0;">Ada data yang belum disimpan. Yakin ingin keluar?</p>
        <div style="display: flex; gap: 10px; justify-content: center;">
            <button type="button" id="btnTidakPindah"
                    style="flex: 1; padding: 10px; border-radius: 10px; border: 1.5px solid #E5E7EB; background: white; color: #374151; font-weight: 600; font-size: 13px; cursor: pointer; font-family: 'Poppins', sans-serif;">Tidak</button>
            <button type="button" id="btnYaPindah"
                    style="flex: 1; padding: 10px; border-radius: 10px; border: none; background: #EF4444; color: white; font-weight: 600; font-size: 13px; cursor: pointer; font-family: 'Poppins', sans-serif;">Ya, Keluar</button>
        </div>
    </div>
</div>


<div id="modalSukses" style="display: none; position: fixed; z-index: 99999; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.45); backdrop-filter: blur(3px); align-items: center; justify-content: center; font-family: 'Poppins', sans-serif;">
    <div style="background: white; padding: 28px 24px; border-radius: 20px; width: 320px; text-align: center; box-shadow: 0 15px 40px rgba(0,0,0,0.18);">
        <div style="color: #10B981; font-size: 52px; margin-bottom: 10px;"><i class="fas fa-check-circle"></i></div>
        <h2 style="margin: 0; font-size: 18px; font-weight: 700; color: #111827;">Berhasil!</h2>
        <p style="color: #6B7280; font-size: 13px; margin: 8px 0 22px 0;" id="pesanSukses">Pembayaran berhasil disimpan.</p>
        <button type="button" id="btnOkSukses"
                style="width: 100%; padding: 11px; border-radius: 10px; border: none; background: #10B981; color: white; font-weight: 600; font-size: 14px; cursor: pointer; font-family: 'Poppins', sans-serif;">OK</button>
    </div>
</div>

<script>
(function () {
    const form            = document.querySelector('#mainForm');
    const btnKeluar       = document.querySelector('#btnKeluar');
    const btnSimpan       = document.querySelector('#btnSimpan');
    const alertError      = document.querySelector('#alertError');
    const alertErrorText  = document.querySelector('#alertErrorText');
    const pesanSukses     = document.querySelector('#pesanSukses');

    const modalBatal      = document.querySelector('#modalBatal');
    const modalPindah     = document.querySelector('#modalPindahHalaman');
    const modalSukses     = document.querySelector('#modalSukses');
    const btnTidakBatal   = document.querySelector('#btnTidakBatal');
    const btnYaKeluar     = document.querySelector('#btnYaKeluar');
    const btnTidakPindah  = document.querySelector('#btnTidakPindah');
    const btnYaPindah     = document.querySelector('#btnYaPindah');
    const btnOkSukses     = document.querySelector('#btnOkSukses');

    const searchInput     = document.querySelector('#searchMurid');
    const autocompleteDiv = document.querySelector('#autocompleteResult');
    const idHidden        = document.querySelector('#id_murid');
    const infoStatus      = document.querySelector('#infoStatusMurid');
    const paketSelect     = document.querySelector('#paket_selanjutnya');
    const totalInput      = document.querySelector('#total_pembayaran');
    const infoHarga       = document.querySelector('#infoHarga');
    const hargaValue      = document.querySelector('#hargaPaketValue');
    const previewStatus   = document.querySelector('#previewStatus');
    const bulanHidden     = document.querySelector('#bulan_dibayar');

    let formChanged  = false;
    let formSubmitted = false;
    let _hargaPaket  = 0;
    let _bulanTagihan = ''; // untuk menyimpan bulan yang harus dibayar

    /* TRACK perubahan */
    if (form) {
        form.querySelectorAll('input, select, textarea').forEach(el => {
            el.addEventListener('input',  () => { if (!formSubmitted) formChanged = true; });
            el.addEventListener('change', () => { if (!formSubmitted) formChanged = true; });
        });
    }

    /* KELUAR */
    btnKeluar?.addEventListener('click', function (e) {
        e.preventDefault();
        if (formChanged && !formSubmitted) {
            modalPindah.style.display = 'flex';
        } else {
            modalBatal.style.display = 'flex';
        }
    });

    btnTidakBatal?.addEventListener('click', () => modalBatal.style.display = 'none');
    btnYaKeluar?.addEventListener('click', () => { formChanged = false; modalBatal.style.display = 'none'; tutupModal(); });

    btnTidakPindah?.addEventListener('click', () => modalPindah.style.display = 'none');
    btnYaPindah?.addEventListener('click', () => { formChanged = false; modalPindah.style.display = 'none'; tutupModal(); });

    btnOkSukses?.addEventListener('click', () => { modalSukses.style.display = 'none'; tutupModal(); window.location.reload(); });

    function tutupModal() {
        const mf = document.getElementById('modalForm');
        if (mf) mf.style.display = 'none';
        const cont = document.getElementById('modalContent');
        if (cont) cont.innerHTML = '';
    }

    /* SUBMIT */
    if (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            if (!idHidden.value) { tampilError('Silakan pilih nama murid terlebih dahulu.'); return; }
            if (!_bulanTagihan && _hargaPaket > 0) { tampilError('Tidak ada tagihan yang perlu dibayar.'); return; }

            // Set bulan hidden
            if (bulanHidden && _bulanTagihan) {
                bulanHidden.value = _bulanTagihan;
            }

            const orig = btnSimpan.innerHTML;
            btnSimpan.disabled = true;
            btnSimpan.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';

            const fd = new FormData(form);
            fetch(form.action, {
                method: 'POST',
                body: fd,
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '', 'Accept': 'application/json' }
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    formChanged = false; formSubmitted = true;
                    if (pesanSukses) pesanSukses.textContent = data.message || 'Pembayaran berhasil disimpan.';
                    modalSukses.style.display = 'flex';
                } else {
                    let msg = data.message || 'Terjadi kesalahan.';
                    if (data.errors) msg = Object.values(data.errors).flat().join('\n');
                    tampilError(msg);
                    btnSimpan.disabled = false; btnSimpan.innerHTML = orig;
                }
            })
            .catch(err => { tampilError('Koneksi gagal: ' + err.message); btnSimpan.disabled = false; btnSimpan.innerHTML = orig; });
        });
    }

    function tampilError(msg) {
        if (alertError && alertErrorText) { alertErrorText.textContent = msg; alertError.style.display = 'flex'; setTimeout(() => alertError.style.display = 'none', 5000); }
    }

    /* AUTOCOMPLETE */
    searchInput?.addEventListener('input', function () {
        const q = this.value.trim();
        if (q.length < 2) { autocompleteDiv.style.display = 'none'; return; }
        fetch('/search-murid?q=' + encodeURIComponent(q))
            .then(r => r.json())
            .then(data => {
                if (data.length) {
                    autocompleteDiv.innerHTML = data.map(m =>
                        `<div style="padding:10px 15px;cursor:pointer;border-bottom:1px solid #F3F4F6;" onmouseover="this.style.background='#F3E8FF'" onmouseout="this.style.background='white'" data-id="${m.id_murid}"><strong style="font-size:14px;">${m.nama_lengkap}</strong><br><small style="color:#9CA3AF;">${m.asal_sekolah || '-'} | ${m.no_hp || '-'}</small></div>`
                    ).join('');
                    autocompleteDiv.style.display = 'block';
                    autocompleteDiv.querySelectorAll('div[data-id]').forEach(item => {
                        item.addEventListener('click', function () {
                            searchInput.value = this.querySelector('strong').innerText;
                            idHidden.value = this.dataset.id;
                            autocompleteDiv.style.display = 'none';
                            cekStatusMurid(this.dataset.id);
                        });
                    });
                } else {
                    autocompleteDiv.innerHTML = '<div style="padding:10px 15px;color:#9CA3AF;">Murid tidak ditemukan</div>';
                    autocompleteDiv.style.display = 'block';
                }
            });
    });

    document.addEventListener('click', function (e) {
        if (searchInput && !searchInput.contains(e.target) && autocompleteDiv && !autocompleteDiv.contains(e.target)) autocompleteDiv.style.display = 'none';
    });

    /* CEK STATUS MURID - OTOMATIS TENTUKAN BULAN TAGIHAN */
    function cekStatusMurid(id) {
        fetch('/cek-status-pembayaran/' + id)
            .then(r => r.json())
            .then(d => {
                if (!d.sudah_bayar_pendaftaran) {
                    // Belum daftar
                    infoStatus.innerHTML = `<div style="padding:12px 15px;border-radius:10px;background:#FEF3C7;color:#92400E;border-left:4px solid #F59E0B;"><strong><i class="fas fa-exclamation-triangle"></i> Pendaftaran Baru!</strong><br><span style="font-size:13px;">Murid ini belum terdaftar. Wajib bayar biaya pendaftaran <strong>Rp 100.000</strong>.</span></div>`;
                    infoStatus.style.display = 'block';
                    if (paketSelect) paketSelect.disabled = true;
                    if (infoHarga) infoHarga.style.display = 'none';
                    if (previewStatus) previewStatus.style.display = 'none';
                    if (totalInput) totalInput.value = '100000';
                    _hargaPaket = 100000;
                    _bulanTagihan = ''; // pendaftaran tidak perlu bulan
                    updatePreview();
                } else {
                    // Sudah terdaftar
                    infoStatus.innerHTML = `<div style="padding:12px 15px;border-radius:10px;background:#D1FAE5;color:#065F46;border-left:4px solid #10B981;"><strong><i class="fas fa-check-circle"></i> Sudah Terdaftar!</strong><br><span style="font-size:13px;">Membayar tagihan bulan <strong>${d.bulan_tunggakan ? getNamaBulan(d.bulan_tunggakan) : 'yang tertunggak'}</strong>.</span></div>`;
                    infoStatus.style.display = 'block';
                    if (paketSelect) paketSelect.disabled = false;
                    
                    // Set paket aktif jika ada
                    if (d.paket_aktif && paketSelect) {
                        paketSelect.value = d.paket_aktif;
                        const selOpt = paketSelect.options[paketSelect.selectedIndex];
                        const h = parseInt(selOpt?.dataset?.harga) || 0;
                        _hargaPaket = h;
                        if (totalInput && h > 0) totalInput.value = h;
                        if (infoHarga && hargaValue && h > 0) { 
                            hargaValue.textContent = 'Rp ' + h.toLocaleString('id-ID'); 
                            infoHarga.style.display = 'block'; 
                        }
                    }
                    
                    // Tentukan bulan tagihan (prioritas: bulan tunggakan, lalu bulan berikutnya)
                    if (d.bulan_tunggakan) {
                        _bulanTagihan = d.bulan_tunggakan;
                    } else if (d.bulan_berikutnya) {
                        _bulanTagihan = d.bulan_berikutnya;
                    } else {
                        _bulanTagihan = new Date().getMonth() + 1;
                    }
                    
                    updatePreview();
                }
            })
            .catch(() => { 
                infoStatus.innerHTML = '<div style="padding:12px 15px;border-radius:10px;background:#FEE2E2;color:#991B1B;">Gagal memuat data murid.</div>'; 
                infoStatus.style.display = 'block'; 
            });
    }
    
    function getNamaBulan(bulan) {
        const nama = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        return nama[bulan - 1] || '';
    }

    /* PAKET CHANGE */
    paketSelect?.addEventListener('change', function () {
        const selOpt = this.options[this.selectedIndex];
        const h = parseInt(selOpt?.dataset?.harga) || 0;
        _hargaPaket = h;
        if (h > 0) { 
            if (totalInput) totalInput.value = h; 
            if (infoHarga && hargaValue) { 
                hargaValue.textContent = 'Rp ' + h.toLocaleString('id-ID'); 
                infoHarga.style.display = 'block'; 
            } 
        } else { 
            if (infoHarga) infoHarga.style.display = 'none'; 
        }
        updatePreview();
    });

    /* PREVIEW */
    window.updatePreview = function () {
        if (!previewStatus || !totalInput) return;
        const total = parseInt(totalInput.value) || 0;
        if (!total || !_hargaPaket) { previewStatus.style.display = 'none'; return; }
        if (total >= _hargaPaket) {
            const lebih = total - _hargaPaket;
            previewStatus.style.background = '#D1FAE5'; previewStatus.style.color = '#065F46'; previewStatus.style.display = 'block';
            previewStatus.innerHTML = `<i class="fas fa-check-circle"></i> <strong>Lunas</strong>` + (lebih > 0 ? ` — Uang Muka <strong>Rp ${lebih.toLocaleString('id-ID')}</strong>` : '');
        } else {
            const kurang = _hargaPaket - total;
            previewStatus.style.background = '#FEF3C7'; previewStatus.style.color = '#92400E'; previewStatus.style.display = 'block';
            previewStatus.innerHTML = `<i class="fas fa-exclamation-triangle"></i> <strong>Kurang Rp ${kurang.toLocaleString('id-ID')}</strong> dari tagihan`;
        }
    };
    totalInput?.addEventListener('input', updatePreview);
})();
</script><?php /**PATH C:\xampp\htdocs\Privat-Bimbel\resources\views/dashboard/shared/pembayaran/create-pembayaran.blade.php ENDPATH**/ ?>