<div style="padding: 20px; font-family: 'Poppins', sans-serif; background: #FFFFFF; border-radius: 16px;">
    
    <div style="margin-bottom: 20px; padding-bottom: 14px; border-bottom: 1.5px solid #F3F4F6;">
        <h2 style="font-size: 19px; font-weight: 700; color: #111827; margin: 0;">Input Pembayaran</h2>
        <p style="color: #9CA3AF; font-size: 12px; margin: 2px 0 0 0;">Lengkapi form pembayaran</p>
    </div>

    <div id="alertError" style="display: none; background: #FEE2E2; color: #991B1B; padding: 12px 15px; border-radius: 10px; margin-bottom: 15px; align-items: center; gap: 10px;">
        <i class="fas fa-exclamation-circle" style="font-size: 18px;"></i>
        <span id="alertErrorText"></span>
    </div>

    <form id="mainForm" action="<?php echo e(route($role . '.pembayaran.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>

        <div style="margin-bottom: 15px;">
            <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 6px;">Tanggal <span style="color: #EF4444;">*</span></label>
            <input type="date" name="tanggal" id="tanggal" required value="<?php echo e(date('Y-m-d')); ?>"
                   style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: #FFFFFF; outline: none; font-size: 14px; font-family: 'Poppins', sans-serif;">
        </div>

        <div style="margin-bottom: 15px;">
            <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 6px;">Jenis Pembayaran <span style="color: #EF4444;">*</span></label>
            <select name="jenis_pembayaran" id="jenis_pembayaran" required 
                    style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: #FFFFFF; outline: none; font-size: 14px; font-family: 'Poppins', sans-serif; cursor: pointer;">
                <option value="">Pilih Jenis Pembayaran</option>
                <option value="Tunai">Tunai</option>
                <option value="Transfer">Transfer</option>
            </select>
        </div>

        <div style="margin-bottom: 15px; position: relative;">
            <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 6px;">Nama Murid <span style="color: #EF4444;">*</span></label>
            <input type="text" id="searchMurid" name="search_murid" placeholder="Ketik nama murid..." autocomplete="off" required
                   style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: #FFFFFF; outline: none; font-size: 14px; font-family: 'Poppins', sans-serif;">
            <div id="autocompleteResult" style="position: absolute; z-index: 1000; background: white; border: 1px solid #E5E7EB; border-radius: 12px; width: 100%; max-height: 200px; overflow-y: auto; margin-top: 5px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); display: none; font-family: 'Poppins', sans-serif;"></div>
            <input type="hidden" name="id_murid" id="id_murid" required>
            <small style="color: #9CA3AF; font-size: 12px;">Ketik minimal 2 huruf untuk mencari murid</small>
        </div>

        <div id="infoStatusMurid" style="display: none;"></div>

        <div style="margin-bottom: 15px;">
            <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 6px;">Paket Awal (Pendaftaran)</label>
            <input type="text" id="paket_awal_display" readonly value="Rp 100.000"
                   style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: #F3F4F6; color: #6B7280; font-size: 14px; font-family: 'Poppins', sans-serif;">
            <input type="hidden" name="paket_awal" id="paket_awal" value="100000">
        </div>

        <div style="margin-bottom: 15px;">
            <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 6px;">Paket Belajar</label>
            <select name="paket_selanjutnya" id="paket_selanjutnya" 
                    style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: #FFFFFF; outline: none; font-size: 14px; font-family: 'Poppins', sans-serif; cursor: pointer;">
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

        <div id="bulanGroup" style="margin-bottom: 15px;">
            <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 6px;">Untuk Bulan</label>
            <select name="bulan_dibayar" id="bulan_dibayar" style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: #FFFFFF; outline: none; font-size: 14px; font-family: 'Poppins', sans-serif; cursor: pointer;">
                <option value="">Pilih Bulan</option>
                <option value="1">Januari</option><option value="2">Februari</option><option value="3">Maret</option>
                <option value="4">April</option><option value="5">Mei</option><option value="6">Juni</option>
                <option value="7">Juli</option><option value="8">Agustus</option><option value="9">September</option>
                <option value="10">Oktober</option><option value="11">November</option><option value="12">Desember</option>
            </select>
        </div>

        <div style="margin-bottom: 15px;">
            <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 6px;">Total Pembayaran <span style="color: #EF4444;">*</span></label>
            <input type="text" name="total_pembayaran" id="total_pembayaran" placeholder="Masukkan Total Pembayaran" required 
                   oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                   style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: #FFFFFF; outline: none; font-size: 14px; font-family: 'Poppins', sans-serif;">
        </div>

        <div id="previewStatus" style="margin-bottom: 15px; padding: 12px 15px; border-radius: 10px; display: none;"></div>

        <div style="margin-bottom: 15px;">
            <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 6px;">Keterangan</label>
            <textarea name="keterangan" id="keterangan" rows="3" placeholder="Masukkan Keterangan" 
                      style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: #FFFFFF; outline: none; font-size: 14px; resize: vertical; font-family: 'Poppins', sans-serif;"></textarea>
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 20px; margin-top: 30px; padding-top: 16px; border-top: 1.5px solid #F3F4F6;">
            <button type="button" id="btnKeluar" style="padding: 10px 45px; border: 1.5px solid #4D0B87; color: #4D0B87; border-radius: 10px; font-weight: 600; font-size: 16px; background: #FFFFFF; cursor: pointer;">Keluar</button>
            <button type="submit" id="btnSimpan" style="padding: 10px 45px; border: none; background: #4D0B87; color: white; border-radius: 10px; font-weight: 600; font-size: 16px; cursor: pointer; box-shadow: 0 4px 6px rgba(77, 11, 135, 0.2);">Simpan</button>
        </div>
    </form>
</div>


<div id="modalBatal" style="display: none; position: fixed; z-index: 99999; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); backdrop-filter: blur(3px); align-items: center; justify-content: center; font-family: 'Poppins', sans-serif;">
    <div style="background: white; padding: 25px; border-radius: 20px; width: 320px; text-align: center; box-shadow: 0 15px 30px rgba(0,0,0,0.15);">
        <div style="color: #F59E0B; font-size: 40px; margin-bottom: 10px;"><i class="fas fa-exclamation-triangle"></i></div>
        <h2 style="margin: 0; font-size: 18px; font-weight: 700; color: #111827;">Batalkan?</h2>
        <p style="color: #6B7280; font-size: 13px; margin: 8px 0 20px 0;">Data yang Anda masukkan tidak akan disimpan.</p>
        <div style="display: flex; gap: 10px; justify-content: center;">
            <button type="button" id="btnTidakBatal" style="flex: 1; padding: 10px; border-radius: 10px; border: 1px solid #E5E7EB; background: white; color: #374151; font-weight: 600; font-size: 13px; cursor: pointer;">Tidak</button>
            <button type="button" id="btnYaKeluar" style="flex: 1; padding: 10px; border-radius: 10px; border: none; background: #EF4444; color: white; font-weight: 600; font-size: 13px; cursor: pointer;">Ya, Keluar</button>
        </div>
    </div>
</div>


<div id="modalPindahHalaman" style="display: none; position: fixed; z-index: 10000; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); backdrop-filter: blur(3px); align-items: center; justify-content: center; font-family: 'Poppins', sans-serif;">
    <div style="background: white; padding: 25px; border-radius: 20px; width: 320px; text-align: center; box-shadow: 0 15px 30px rgba(0,0,0,0.15);">
        <div style="color: #F59E0B; font-size: 40px; margin-bottom: 10px;"><i class="fas fa-exclamation-triangle"></i></div>
        <h2 style="margin: 0; font-size: 18px; font-weight: 700; color: #111827;">Perubahan Belum Disimpan</h2>
        <p style="color: #6B7280; font-size: 13px; margin: 8px 0 20px 0;">Ada data yang belum disimpan.</p>
        <div style="display: flex; gap: 10px; justify-content: center;">
            <button type="button" id="btnTidakPindah" style="flex: 1; padding: 10px; border-radius: 10px; border: 1px solid #E5E7EB; background: white; font-weight: 600; font-size: 13px; cursor: pointer;">Tidak</button>
            <button type="button" id="btnYaPindah" style="flex: 1; padding: 10px; border-radius: 10px; border: none; background: #EF4444; color: white; font-weight: 600; font-size: 13px; cursor: pointer;">Ya, Keluar</button>
        </div>
    </div>
</div>


<div id="modalSukses" style="display: none; position: fixed; z-index: 99999; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); backdrop-filter: blur(3px); align-items: center; justify-content: center; font-family: 'Poppins', sans-serif;">
    <div style="background: white; padding: 25px; border-radius: 20px; width: 320px; text-align: center; box-shadow: 0 15px 30px rgba(0,0,0,0.15);">
        <div style="color: #10B981; font-size: 50px; margin-bottom: 10px;"><i class="fas fa-check-circle"></i></div>
        <h2 style="margin: 0; font-size: 18px; font-weight: 700; color: #111827;">Berhasil!</h2>
        <p style="color: #6B7280; font-size: 13px; margin: 8px 0 20px 0;" id="pesanSukses">Pembayaran berhasil disimpan.</p>
        <button type="button" id="btnOkSukses" style="width: 100%; padding: 10px; border-radius: 10px; border: none; background: #10B981; color: white; font-weight: 600; font-size: 13px; cursor: pointer;">OK</button>
    </div>
</div><?php /**PATH C:\xampp\htdocs\Privat-Bimbel\resources\views/dashboard/shared/pembayaran/create-pembayaran.blade.php ENDPATH**/ ?>