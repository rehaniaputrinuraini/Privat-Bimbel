<div style="padding: 24px; font-family: 'Poppins', sans-serif; background: #FFFFFF; border-radius: 16px;">

    
    <div style="margin-bottom: 22px; padding-bottom: 14px; border-bottom: 1.5px solid #F3F4F6;">
        <h2 style="font-size: 19px; font-weight: 700; color: #111827; margin: 0;">Input Pemasukan Lain</h2>
        <p style="color: #9CA3AF; font-size: 12px; margin: 3px 0 0 0;">Form pemasukan non-murid (Donasi, Sponsor, dll)</p>
    </div>

    
    <div id="alertError" style="display: none; background: #FEE2E2; color: #991B1B; padding: 12px 15px; border-radius: 10px; margin-bottom: 15px; align-items: center; gap: 10px;">
        <i class="fas fa-exclamation-circle" style="font-size: 18px; flex-shrink: 0;"></i>
        <span id="alertErrorText"></span>
    </div>

    <form id="mainForm" action="<?php echo e(route($role . '.pembayaran.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>

        <input type="hidden" name="kategori_pemasukan" value="lainnya">

        
        <div style="margin-bottom: 15px;">
            <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 6px;">
                Tanggal <span style="color: #EF4444;">*</span>
            </label>
            <input type="date" name="tanggal_lainnya" id="tanggal_lainnya" value="<?php echo e(date('Y-m-d')); ?>"
                   style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: #FFFFFF; outline: none; font-size: 14px; font-family: 'Poppins', sans-serif; color: #374151; box-sizing: border-box;">
        </div>

        
        <div style="margin-bottom: 15px;">
            <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 6px;">
                Jenis <span style="color: #EF4444;">*</span>
            </label>
            <select name="jenis_pembayaran_lainnya" id="jenis_pembayaran_lainnya"
                    style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: #FFFFFF; outline: none; font-size: 14px; font-family: 'Poppins', sans-serif; cursor: pointer; color: #374151;">
                <option value="">Pilih Jenis</option>
                <option value="Tunai">Tunai</option>
                <option value="Transfer">Transfer</option>
            </select>
        </div>

        
        <div style="margin-bottom: 15px;">
            <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 6px;">
                Sumber Pemasukan <span style="color: #EF4444;">*</span>
            </label>
            <input type="text" name="sumber_pemasukan" id="sumber_pemasukan" placeholder="Contoh: Donasi, Sponsor, Hibah, dll"
                   style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: #FFFFFF; outline: none; font-size: 14px; font-family: 'Poppins', sans-serif; color: #374151; box-sizing: border-box;">
        </div>

        
        <div style="margin-bottom: 15px;">
            <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 6px;">
                Total <span style="color: #EF4444;">*</span>
            </label>
            <input type="text" name="total_pembayaran_lainnya" id="total_pembayaran_lainnya" placeholder="Masukkan Total"
                   oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                   style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: #FFFFFF; outline: none; font-size: 14px; font-family: 'Poppins', sans-serif; color: #374151; box-sizing: border-box;">
        </div>

        
        <div style="margin-bottom: 5px;">
            <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 6px;">
                Keterangan
            </label>
            <textarea name="keterangan_lainnya" id="keterangan_lainnya" rows="3" placeholder="Masukkan Keterangan (opsional)"
                      style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: #FFFFFF; outline: none; font-size: 14px; resize: vertical; font-family: 'Poppins', sans-serif; color: #374151; box-sizing: border-box;"></textarea>
        </div>

        
        <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 28px; padding-top: 16px; border-top: 1.5px solid #F3F4F6;">
            <button type="button" id="btnKeluar"
                    style="padding: 11px 40px; border: 1.5px solid #F59E0B; color: #F59E0B; border-radius: 10px; font-weight: 600; font-size: 15px; background: #FFFFFF; cursor: pointer; font-family: 'Poppins', sans-serif;">
                Keluar
            </button>
            <button type="submit" id="btnSimpan"
                    style="padding: 11px 40px; border: none; background: #F59E0B; color: white; border-radius: 10px; font-weight: 600; font-size: 15px; cursor: pointer; font-family: 'Poppins', sans-serif; box-shadow: 0 4px 10px rgba(245,158,11,0.25);">
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
        <p style="color: #6B7280; font-size: 13px; margin: 8px 0 22px 0;" id="pesanSukses">Pemasukan berhasil disimpan.</p>
        <button type="button" id="btnOkSukses"
                style="width: 100%; padding: 11px; border-radius: 10px; border: none; background: #10B981; color: white; font-weight: 600; font-size: 14px; cursor: pointer; font-family: 'Poppins', sans-serif;">OK</button>
    </div>
</div>

<script>
(function () {
    const form           = document.querySelector('#mainForm');
    const btnKeluar      = document.querySelector('#btnKeluar');
    const btnSimpan      = document.querySelector('#btnSimpan');
    const alertError     = document.querySelector('#alertError');
    const alertErrorText = document.querySelector('#alertErrorText');
    const pesanSukses    = document.querySelector('#pesanSukses');

    const modalBatal     = document.querySelector('#modalBatal');
    const modalPindah    = document.querySelector('#modalPindahHalaman');
    const modalSukses    = document.querySelector('#modalSukses');
    const btnTidakBatal  = document.querySelector('#btnTidakBatal');
    const btnYaKeluar    = document.querySelector('#btnYaKeluar');
    const btnTidakPindah = document.querySelector('#btnTidakPindah');
    const btnYaPindah    = document.querySelector('#btnYaPindah');
    const btnOkSukses    = document.querySelector('#btnOkSukses');

    let formChanged  = false;
    let formSubmitted = false;

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
    modalBatal?.addEventListener('click', e => { if (e.target === modalBatal) modalBatal.style.display = 'none'; });

    btnTidakPindah?.addEventListener('click', () => modalPindah.style.display = 'none');
    btnYaPindah?.addEventListener('click', () => { formChanged = false; modalPindah.style.display = 'none'; tutupModal(); });
    modalPindah?.addEventListener('click', e => { if (e.target === modalPindah) modalPindah.style.display = 'none'; });

    btnOkSukses?.addEventListener('click', () => { modalSukses.style.display = 'none'; tutupModal(); window.location.reload(); });
    modalSukses?.addEventListener('click', e => { if (e.target === modalSukses) { modalSukses.style.display = 'none'; tutupModal(); window.location.reload(); } });

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
                    if (pesanSukses) pesanSukses.textContent = data.message || 'Pemasukan berhasil disimpan.';
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
})();
</script><?php /**PATH C:\xampp\htdocs\Privat-Bimbel\resources\views/dashboard/shared/pembayaran/create-pemasukan-lain.blade.php ENDPATH**/ ?>