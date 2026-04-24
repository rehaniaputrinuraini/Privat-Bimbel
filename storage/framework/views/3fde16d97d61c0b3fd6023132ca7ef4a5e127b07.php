

<?php $__env->startSection('title', 'Input Pembayaran'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .autocomplete-items {
        position: absolute;
        z-index: 1000;
        background: white;
        border: 1px solid #E5E7EB;
        border-radius: 12px;
        width: 100%;
        max-height: 250px;
        overflow-y: auto;
        margin-top: 5px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        font-family: 'Poppins', sans-serif;
    }
    .autocomplete-item {
        padding: 12px 15px;
        cursor: pointer;
        border-bottom: 1px solid #F3F4F6;
        transition: 0.2s;
    }
    .autocomplete-item:hover {
        background-color: #F3E8FF;
    }
    .info-box {
        padding: 12px 15px;
        border-radius: 10px;
        margin-bottom: 15px;
        font-size: 14px;
    }
    .info-pendaftaran {
        background: #FEF3C7;
        color: #92400E;
        border-left: 4px solid #F59E0B;
    }
    .info-bulanan {
        background: #E0E7FF;
        color: #1E40AF;
        border-left: 4px solid #4D0B87;
    }
    select:disabled {
        background: #F3F4F6;
        color: #9CA3AF;
        cursor: not-allowed;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div style="padding: 10px; font-family: 'Poppins', sans-serif;">
    <h1 style="font-size: 20px; font-weight: 700; color: #111827; margin-bottom: 20px;">Input Pembayaran</h1>

    <?php if($errors->any()): ?>
        <div style="background: #FEE2E2; color: #EF4444; padding: 12px; border-radius: 10px; margin-bottom: 20px;">
            <i class="fas fa-exclamation-circle"></i> <?php echo e($errors->first()); ?>

        </div>
    <?php endif; ?>

    <?php if(session('success')): ?>
        <div style="background: #D1FAE5; color: #065F46; padding: 12px; border-radius: 10px; margin-bottom: 20px;">
            <i class="fas fa-check-circle"></i> <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <div style="background: #F9FAFB; border-radius: 15px; padding: 30px; border: 1.5px solid #E5E7EB; box-shadow: 0 4px 10px rgba(0,0,0,0.02);">
        <form action="<?php echo e(route($role . '.pembayaran.store')); ?>" method="POST" id="mainForm">
            <?php echo csrf_field(); ?>

            
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Tanggal <span style="color: red;">*</span></label>
                <input type="date" name="tanggal" id="tanggal" required value="<?php echo e(date('Y-m-d')); ?>"
                       style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none; font-size: 14px;">
            </div>

            
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Jenis Pembayaran <span style="color: red;">*</span></label>
                <select name="jenis_pembayaran" id="jenis_pembayaran" required 
                        style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none; font-size: 14px;">
                    <option value="">Pilih Jenis Pembayaran</option>
                    <option value="Tunai">Tunai</option>
                    <option value="Transfer">Transfer</option>
                </select>
            </div>

            
            <div style="margin-bottom: 15px; position: relative;">
                <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Nama Murid <span style="color: red;">*</span></label>
                <input type="text" id="searchMurid" name="search_murid" 
                       placeholder="Ketik nama murid..." autocomplete="off" required
                       style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none; font-size: 14px;">
                <div id="autocompleteResult" class="autocomplete-items" style="display: none;"></div>
                <input type="hidden" name="id_murid" id="id_murid" required>
                <small style="color: #9CA3AF; font-size: 12px;">Ketik minimal 2 huruf untuk mencari murid</small>
            </div>

            <div id="infoStatusMurid" style="display: none;"></div>

            
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Paket Awal (Pendaftaran)</label>
                <input type="text" id="paket_awal_display" readonly 
                       value="Rp 100.000"
                       style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #F3F4F6; color: #6B7280; font-size: 14px;">
                <input type="hidden" name="paket_awal" id="paket_awal" value="100000">
            </div>

            
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Paket Belajar <span style="color: red;">*</span></label>
                <select name="paket_selanjutnya" id="paket_selanjutnya" 
                        style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none; font-size: 14px;">
                    <option value="">Pilih Paket</option>
                    <?php $__currentLoopData = $pakets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($paket->tingkat); ?>" data-harga="<?php echo e($paket->harga); ?>">
                            <?php echo e($paket->tingkat); ?> - Rp <?php echo e(number_format($paket->harga, 0, ',', '.')); ?> / bulan
                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            
            <div id="infoHarga" style="margin-bottom: 15px; padding: 12px 15px; background: #E0E7FF; border-radius: 10px; display: none;">
                <i class="fas fa-info-circle"></i> Harga: <strong id="hargaPaketValue">Rp 0</strong> / bulan
            </div>

            
            <div id="bulanGroup" style="margin-bottom: 15px; display: none;">
                <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Untuk Bulan</label>
                <select name="bulan_dibayar" id="bulan_dibayar" style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none; font-size: 14px;">
                    <option value="">Pilih Bulan</option>
                    <option value="1">Januari</option>
                    <option value="2">Februari</option>
                    <option value="3">Maret</option>
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
            </div>

            
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Total Pembayaran <span style="color: red;">*</span></label>
                <input type="text" inputmode="numeric" name="total_pembayaran" id="total_pembayaran" placeholder="Masukkan Total Pembayaran" required 
                       onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                       oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                       style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none; font-size: 14px;">
            </div>

            
            <div id="previewStatus" style="margin-bottom: 15px; padding: 12px 15px; border-radius: 10px; display: none;"></div>

            
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Keterangan</label>
                <textarea name="keterangan" id="keterangan" rows="3" placeholder="Masukkan Keterangan" 
                          style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none; font-size: 14px; resize: vertical; font-family: 'Poppins', sans-serif;"></textarea>
            </div>

            
            <div style="display: flex; justify-content: flex-end; gap: 20px; margin-top: 30px;">
                <button type="button" onclick="bukaModalBatal()" 
                        style="padding: 10px 45px; border: 1.5px solid #4D0B87; color: #4D0B87; border-radius: 10px; font-weight: 600; font-size: 16px; background: #FFFFFF; cursor: pointer;">
                    Keluar
                </button>
                <button type="submit" 
                        style="padding: 10px 45px; border: none; background: #4D0B87; color: white; border-radius: 10px; font-weight: 600; font-size: 16px; cursor: pointer; box-shadow: 0 4px 6px rgba(77, 11, 135, 0.2);">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>


<div id="modalBatal" style="display: none; position: fixed; z-index: 99999; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); backdrop-filter: blur(3px); align-items: center; justify-content: center; font-family: 'Poppins', sans-serif;">
    <div style="background: white; padding: 25px; border-radius: 20px; width: 320px; text-align: center; box-shadow: 0 15px 30px rgba(0,0,0,0.15);">
        <div style="color: #F59E0B; font-size: 40px; margin-bottom: 10px;"><i class="fas fa-exclamation-triangle"></i></div>
        <h2 style="margin: 0; font-size: 18px; font-weight: 700; color: #111827;">Batalkan?</h2>
        <p style="color: #6B7280; font-size: 13px; margin: 8px 0 20px 0;">Data yang Anda masukkan tidak akan disimpan. Yakin ingin keluar?</p>
        <div style="display: flex; gap: 10px; justify-content: center;">
            <button onclick="tutupModalBatal()" style="flex: 1; padding: 10px; border-radius: 10px; border: 1px solid #E5E7EB; background: white; color: #374151; font-weight: 600; font-size: 13px; cursor: pointer;">Tidak</button>
            <a href="#" id="confirmKeluarLink" style="flex: 1; text-decoration: none;">
                <button type="button" style="width: 100%; padding: 10px; border-radius: 10px; border: none; background: #EF4444; color: white; font-weight: 600; font-size: 13px; cursor: pointer;">Ya, Keluar</button>
            </a>
        </div>
    </div>
</div>


<div id="modalPindahHalaman" style="display: none; position: fixed; z-index: 10000; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); backdrop-filter: blur(3px); align-items: center; justify-content: center; font-family: 'Poppins', sans-serif;">
    <div style="background: white; padding: 25px; border-radius: 20px; width: 320px; text-align: center; box-shadow: 0 15px 30px rgba(0,0,0,0.15);">
        <div style="color: #F59E0B; font-size: 40px; margin-bottom: 10px;"><i class="fas fa-exclamation-triangle"></i></div>
        <h2 style="margin: 0; font-size: 18px; font-weight: 700; color: #111827;">Perubahan Belum Disimpan</h2>
        <p style="color: #6B7280; font-size: 13px; margin: 8px 0 20px 0;">Ada data yang belum disimpan. Yakin ingin meninggalkan halaman ini?</p>
        <div style="display: flex; gap: 10px; justify-content: center;">
            <button onclick="tutupModalPindah()" style="flex: 1; padding: 10px; border-radius: 10px; border: 1px solid #E5E7EB; background: white; color: #374151; font-weight: 600; font-size: 13px; cursor: pointer;">Tidak</button>
            <button id="confirmPindahBtn" style="flex: 1; padding: 10px; border-radius: 10px; border: none; background: #EF4444; color: white; font-weight: 600; font-size: 13px; cursor: pointer;">Ya, Keluar</button>
        </div>
    </div>
</div>

<script>
    let formChanged = false;
    const form = document.getElementById('mainForm');
    if (form) {
        form.querySelectorAll('input, select, textarea').forEach(i => {
            i.addEventListener('change', () => formChanged = true);
            i.addEventListener('keyup', () => formChanged = true);
        });
        form.addEventListener('submit', () => formChanged = false);
    }
    
    function bukaModalBatal() { 
        if (formChanged) {
            document.getElementById('modalPindahHalaman').style.display = 'flex';
            document.getElementById('confirmPindahBtn').onclick = () => {
                formChanged = false;
                window.location.href = "<?php echo e(route($role . '.pembayaran.tagihan')); ?>";
            };
        } else {
            document.getElementById('modalBatal').style.display = 'flex';
            document.getElementById('confirmKeluarLink').href = "<?php echo e(route($role . '.pembayaran.tagihan')); ?>";
        }
    }
    function tutupModalBatal() { document.getElementById('modalBatal').style.display = 'none'; }
    function tutupModalPindah() { document.getElementById('modalPindahHalaman').style.display = 'none'; }
    
    // Autocomplete
    const searchInput = document.getElementById('searchMurid');
    const autocompleteDiv = document.getElementById('autocompleteResult');
    const idHidden = document.getElementById('id_murid');
    
    searchInput.addEventListener('input', function() {
        const query = this.value.trim();
        if (query.length < 2) {
            autocompleteDiv.style.display = 'none';
            return;
        }
        fetch(`/search-murid?q=${encodeURIComponent(query)}`)
            .then(r => r.json())
            .then(data => {
                if (data.length) {
                    autocompleteDiv.innerHTML = data.map(m => `
                        <div class="autocomplete-item" data-id="${m.id_murid}">
                            <strong>${m.nama_lengkap}</strong><br>
                            <small>Asal: ${m.asal_sekolah || '-'} | HP: ${m.no_hp || '-'}</small>
                        </div>
                    `).join('');
                    autocompleteDiv.style.display = 'block';
                    document.querySelectorAll('.autocomplete-item').forEach(item => {
                        item.addEventListener('click', function() {
                            searchInput.value = this.querySelector('strong').innerText;
                            idHidden.value = this.dataset.id;
                            autocompleteDiv.style.display = 'none';
                            cekStatus(this.dataset.id);
                        });
                    });
                } else {
                    autocompleteDiv.innerHTML = '<div class="autocomplete-item">Tidak ditemukan</div>';
                    autocompleteDiv.style.display = 'block';
                }
            });
    });
    
    document.addEventListener('click', e => {
        if (!searchInput.contains(e.target) && !autocompleteDiv.contains(e.target)) {
            autocompleteDiv.style.display = 'none';
        }
    });
    
    function cekStatus(id) {
        fetch(`/cek-status-pembayaran/${id}`)
            .then(r => r.json())
            .then(d => {
                const info = document.getElementById('infoStatusMurid');
                const paketSelect = document.getElementById('paket_selanjutnya');
                const totalInput = document.getElementById('total_pembayaran');
                const bulanGroup = document.getElementById('bulanGroup');
                const infoHarga = document.getElementById('infoHarga');
                const preview = document.getElementById('previewStatus');
                
                if (!d.sudah_bayar_pendaftaran) {
                    info.innerHTML = `<div class="info-box info-pendaftaran"><i class="fas fa-exclamation-triangle"></i> <strong>Pendaftaran Baru!</strong><br>Murid ini WAJIB membayar biaya pendaftaran sebesar Rp 100.000 terlebih dahulu.</div>`;
                    info.style.display = 'block';
                    paketSelect.disabled = true;
                    paketSelect.value = '';
                    bulanGroup.style.display = 'none';
                    totalInput.value = '100000';
                    infoHarga.style.display = 'none';
                    preview.style.display = 'none';
                } else {
                    info.innerHTML = `<div class="info-box info-bulanan"><i class="fas fa-check-circle"></i> <strong>Sudah Terdaftar!</strong><br>Silakan lanjutkan pembayaran bulanan.</div>`;
                    info.style.display = 'block';
                    paketSelect.disabled = false;
                    bulanGroup.style.display = 'block';
                    
                    if (d.paket_aktif) {
                        paketSelect.value = d.paket_aktif;
                        const opt = paketSelect.options[paketSelect.selectedIndex];
                        const harga = parseInt(opt?.dataset?.harga) || 0;
                        totalInput.value = harga;
                        infoHarga.style.display = 'block';
                        document.getElementById('hargaPaketValue').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(harga);
                        updatePreview();
                    }
                    if (d.bulan_tunggakan) {
                        document.getElementById('bulan_dibayar').value = d.bulan_tunggakan;
                    }
                }
            });
    }
    
    function updatePreview() {
        const paket = document.getElementById('paket_selanjutnya').value;
        const total = parseInt(document.getElementById('total_pembayaran').value) || 0;
        const preview = document.getElementById('previewStatus');
        const infoHarga = document.getElementById('infoHarga');
        
        if (!paket || total <= 0) {
            preview.style.display = 'none';
            return;
        }
        
        const opt = document.getElementById('paket_selanjutnya').options[document.getElementById('paket_selanjutnya').selectedIndex];
        const harga = parseInt(opt?.dataset?.harga) || 0;
        
        if (harga > 0) {
            document.getElementById('hargaPaketValue').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(harga);
            infoHarga.style.display = 'block';
            
            let text = '', color = '', bg = '';
            if (total >= harga) {
                const lebih = total - harga;
                text = lebih > 0 ? `✅ Lunas + Uang Muka Rp ${new Intl.NumberFormat('id-ID').format(lebih)}` : `✅ Lunas - Pembayaran penuh`;
                color = '#0E7490'; bg = '#E1F7E3';
            } else {
                const kurang = harga - total;
                text = `⚠️ Uang Muka - Kurang Rp ${new Intl.NumberFormat('id-ID').format(kurang)}`;
                color = '#92400E'; bg = '#FEF3C7';
            }
            preview.innerHTML = `<div><strong>Preview:</strong><br><span style="color:${color};">${text}</span></div>`;
            preview.style.background = bg;
            preview.style.display = 'block';
        }
    }
    
    document.getElementById('paket_selanjutnya').addEventListener('change', function() {
        const harga = parseInt(this.options[this.selectedIndex]?.dataset?.harga) || 0;
        if (harga > 0) {
            document.getElementById('total_pembayaran').value = harga;
            updatePreview();
        }
    });
    
    document.getElementById('total_pembayaran').addEventListener('input', updatePreview);
    document.getElementById('tanggal').value = new Date().toISOString().split('T')[0];
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Privat-Bimbel\resources\views/dashboard/shared/pembayaran/create-pembayaran.blade.php ENDPATH**/ ?>