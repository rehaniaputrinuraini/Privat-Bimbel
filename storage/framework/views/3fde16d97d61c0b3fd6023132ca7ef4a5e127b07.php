

<?php $__env->startSection('title', 'Input Pembayaran'); ?>

<?php $__env->startSection('content'); ?>
<style>
    .autocomplete-items {
        position: absolute;
        z-index: 1000;
        background: white;
        border: 1px solid #E5E7EB;
        border-radius: 12px;
        width: calc(100% - 30px);
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
    .info-error {
        background: #FEE2E2;
        color: #EF4444;
        border-left: 4px solid #EF4444;
    }
</style>

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
                <input type="text" name="paket_awal_display" id="paket_awal_display" readonly 
                       style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #F3F4F6; color: #6B7280; font-size: 14px;">
                <input type="hidden" name="paket_awal" id="paket_awal">
            </div>

            
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Paket Belajar <span style="color: red;">*</span></label>
                <select name="paket_selanjutnya" id="paket_selanjutnya" required 
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
                <small style="color: #9CA3AF; font-size: 12px;">Kosongkan jika ini pembayaran pendaftaran</small>
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
    // ========== UNSAVED CHANGES WARNING ==========
    let formChanged = false;
    let pendingUrl = null;
    const form = document.getElementById('mainForm');
    
    if (form) {
        const inputs = form.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            input.addEventListener('change', () => formChanged = true);
            input.addEventListener('keyup', () => formChanged = true);
        });
        form.addEventListener('submit', () => formChanged = false);
    }
    
    function bukaModalBatal() { 
        if (formChanged) {
            document.getElementById('modalPindahHalaman').style.display = 'flex';
            document.getElementById('confirmPindahBtn').onclick = function() {
                formChanged = false;
                window.location.href = "<?php echo e(route($role . '.pembayaran')); ?>";
            };
        } else {
            document.getElementById('modalBatal').style.display = 'flex';
            document.getElementById('confirmKeluarLink').href = "<?php echo e(route($role . '.pembayaran')); ?>";
        }
    }
    
    function tutupModalBatal() { document.getElementById('modalBatal').style.display = 'none'; }
    function tutupModalPindah() { document.getElementById('modalPindahHalaman').style.display = 'none'; pendingUrl = null; }
    
    // Autocomplete Murid
    const searchInput = document.getElementById('searchMurid');
    const autocompleteDiv = document.getElementById('autocompleteResult');
    const idHidden = document.getElementById('id_murid');
    
    searchInput.addEventListener('input', function() {
        const query = this.value.trim();
        if (query.length < 2) {
            autocompleteDiv.style.display = 'none';
            idHidden.value = '';
            return;
        }
        
        fetch(`/search-murid?q=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
                if (data.length > 0) {
                    autocompleteDiv.innerHTML = data.map(murid => `
                        <div class="autocomplete-item" data-id="${murid.id_murid}" data-paket-awal="${murid.paket_awal}" data-pilihan-paket="${murid.pilihan_paket || ''}">
                            <strong>${murid.nama_lengkap_murid}</strong><br>
                            <small>Kelas: ${murid.kelas} | Paket: ${murid.pilihan_paket || '-'}</small>
                        </div>
                    `).join('');
                    autocompleteDiv.style.display = 'block';
                    
                    document.querySelectorAll('.autocomplete-item').forEach(item => {
                        item.addEventListener('click', function() {
                            searchInput.value = this.querySelector('strong').innerText;
                            idHidden.value = this.dataset.id;
                            autocompleteDiv.style.display = 'none';
                            cekStatusPembayaran(this.dataset.id);
                        });
                    });
                } else {
                    autocompleteDiv.innerHTML = '<div class="autocomplete-item" style="color: #9CA3AF;">Murid tidak ditemukan</div>';
                    autocompleteDiv.style.display = 'block';
                    idHidden.value = '';
                }
            });
    });
    
    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !autocompleteDiv.contains(e.target)) {
            autocompleteDiv.style.display = 'none';
        }
    });
    
    function cekStatusPembayaran(idMurid) {
        fetch(`/cek-status-pembayaran/${idMurid}`)
            .then(response => response.json())
            .then(data => {
                const infoDiv = document.getElementById('infoStatusMurid');
                const paketSelanjutnya = document.getElementById('paket_selanjutnya');
                const totalBayarInput = document.getElementById('total_pembayaran');
                const paketAwalDisplay = document.getElementById('paket_awal_display');
                const paketAwalHidden = document.getElementById('paket_awal');
                const bulanGroup = document.getElementById('bulanGroup');
                
                if (!data.sudah_bayar_pendaftaran) {
                    infoDiv.innerHTML = `<div class="info-box info-pendaftaran"><i class="fas fa-exclamation-triangle"></i> <strong>Pendaftaran Baru!</strong><br>Murid ini WAJIB membayar biaya pendaftaran sebesar Rp ${new Intl.NumberFormat('id-ID').format(data.paket_awal)} terlebih dahulu.</div>`;
                    infoDiv.style.display = 'block';
                    paketAwalDisplay.value = 'Rp ' + new Intl.NumberFormat('id-ID').format(data.paket_awal);
                    paketAwalHidden.value = data.paket_awal;
                    paketSelanjutnya.disabled = true;
                    bulanGroup.style.display = 'none';
                    totalBayarInput.value = data.paket_awal;
                    document.getElementById('infoHarga').style.display = 'none';
                    document.getElementById('previewStatus').style.display = 'none';
                } else {
                    paketAwalDisplay.value = 'Rp ' + new Intl.NumberFormat('id-ID').format(data.paket_awal);
                    paketAwalHidden.value = data.paket_awal;
                    infoDiv.innerHTML = `<div class="info-box info-bulanan"><i class="fas fa-check-circle"></i> <strong>Sudah Terdaftar!</strong><br>Silakan lanjutkan pembayaran bulanan.</div>`;
                    infoDiv.style.display = 'block';
                    paketSelanjutnya.disabled = false;
                    bulanGroup.style.display = 'block';
                    
                    if (data.pilihan_paket && data.pilihan_paket !== '') {
                        paketSelanjutnya.value = data.pilihan_paket;
                        const selectedOption = paketSelanjutnya.options[paketSelanjutnya.selectedIndex];
                        const harga = selectedOption?.dataset?.harga || 0;
                        totalBayarInput.value = harga;
                        document.getElementById('infoHarga').style.display = 'block';
                        document.getElementById('hargaPaketValue').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(harga);
                        updatePreviewStatus();
                    }
                }
            });
    }
    
    function updatePreviewStatus() {
        const paketSelanjutnya = document.getElementById('paket_selanjutnya').value;
        const totalBayar = parseInt(document.getElementById('total_pembayaran').value) || 0;
        const previewDiv = document.getElementById('previewStatus');
        const infoHargaDiv = document.getElementById('infoHarga');
        
        if (!paketSelanjutnya || !totalBayar || totalBayar <= 0) {
            previewDiv.style.display = 'none';
            return;
        }
        
        const selectedOption = document.getElementById('paket_selanjutnya').options[document.getElementById('paket_selanjutnya').selectedIndex];
        const hargaPerBulan = parseInt(selectedOption?.dataset?.harga) || 0;
        
        if (hargaPerBulan > 0) {
            document.getElementById('hargaPaketValue').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(hargaPerBulan);
            infoHargaDiv.style.display = 'block';
            
            let statusText = '', statusColor = '', statusBg = '';
            if (totalBayar >= hargaPerBulan) {
                const kelebihan = totalBayar - hargaPerBulan;
                if (kelebihan > 0) {
                    statusText = `✅ Lunas + Uang Muka Rp ${new Intl.NumberFormat('id-ID').format(kelebihan)} untuk bulan depan`;
                } else {
                    statusText = `✅ Lunas - Pembayaran untuk 1 bulan penuh`;
                }
                statusColor = '#0E7490'; statusBg = '#E1F7E3';
            } else {
                const sisa = hargaPerBulan - totalBayar;
                statusText = `⚠️ Uang Muka - Masih kurang Rp ${new Intl.NumberFormat('id-ID').format(sisa)} untuk lunas 1 bulan`;
                statusColor = '#92400E'; statusBg = '#FEF3C7';
            }
            
            previewDiv.innerHTML = `<div style="display: flex; align-items: center; gap: 10px;"><i class="fas fa-calculator"></i><div><strong>Preview Status:</strong><br><span style="color: ${statusColor};">${statusText}</span></div></div>`;
            previewDiv.style.background = statusBg;
            previewDiv.style.display = 'block';
        } else {
            infoHargaDiv.style.display = 'none';
            previewDiv.style.display = 'none';
        }
    }
    
    document.getElementById('paket_selanjutnya').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const harga = parseInt(selectedOption?.dataset?.harga) || 0;
        const totalBayarInput = document.getElementById('total_pembayaran');
        
        if (harga > 0) {
            totalBayarInput.value = harga;
            updatePreviewStatus();
        }
    });
    
    document.getElementById('total_pembayaran').addEventListener('input', updatePreviewStatus);
    
    if (!document.getElementById('tanggal').value) {
        document.getElementById('tanggal').value = new Date().toISOString().split('T')[0];
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Privat-Bimbel\resources\views/dashboard/shared/pembayaran/create-pembayaran.blade.php ENDPATH**/ ?>