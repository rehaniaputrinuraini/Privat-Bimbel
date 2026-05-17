<div style="padding: 20px; font-family: 'Poppins', sans-serif;">
    <div style="margin-bottom: 20px; padding-bottom: 14px; border-bottom: 1.5px solid #F3F4F6;">
        <h2 style="font-size: 19px; font-weight: 700; color: #111827; margin: 0;">Edit Periode</h2>
        <p style="color: #9CA3AF; font-size: 12px; margin: 2px 0 0 0;">Perbarui data periode</p>
    </div>

    <div id="alertError" style="display: none; background: #FEE2E2; color: #991B1B; padding: 12px 15px; border-radius: 10px; margin-bottom: 15px; align-items: center; gap: 10px;">
        <i class="fas fa-exclamation-circle" style="font-size: 18px;"></i>
        <span id="alertErrorText"></span>
    </div>

    <form id="mainForm" action="{{ route($role . '.master-data.periode.update', ['hashId' => hash_id($periode->id_periode)]) }}" method="POST">
        @csrf
        @method('PUT')

        <div style="margin-bottom: 15px;">
            <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 6px;">ID Periode</label>
            <input type="text" value="PR{{ str_pad($periode->id_periode, 4, '0', STR_PAD_LEFT) }}" readonly 
                   style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: #F3F4F6; outline: none; color: #6B7280; font-size: 14px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 6px;">Tahun Periode <span style="color: #EF4444;">*</span></label>
            <input type="text" name="tahun_periode" value="{{ old('tahun_periode', $periode->tahun_periode) }}" required maxlength="9"
                   placeholder="Contoh: 2024/2025"
                   style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: #FFFFFF; outline: none; font-size: 14px;">
        </div>

        {{-- 🔥 PERBAIKAN: Format tanggal ke Y-m-d untuk input type date --}}
        <div style="margin-bottom: 15px;">
            <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 6px;">Tanggal Mulai <span style="color: #EF4444;">*</span></label>
            <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai', $periode->tanggal_mulai ? date('Y-m-d', strtotime($periode->tanggal_mulai)) : '') }}" required
                   style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: #FFFFFF; outline: none; font-size: 14px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 6px;">Tanggal Selesai <span style="color: #EF4444;">*</span></label>
            <input type="date" name="tanggal_selesai" value="{{ old('tanggal_selesai', $periode->tanggal_selesai ? date('Y-m-d', strtotime($periode->tanggal_selesai)) : '') }}" required
                   style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: #FFFFFF; outline: none; font-size: 14px;">
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 20px; margin-top: 30px; padding-top: 16px; border-top: 1.5px solid #F3F4F6;">
            <button type="button" id="btnKeluar"
                    style="padding: 10px 45px; border: 1.5px solid #4D0B87; color: #4D0B87; border-radius: 10px; font-weight: 600; font-size: 16px; background: #FFFFFF; cursor: pointer;">
                Keluar
            </button>
            <button type="submit" id="btnUpdate"
                    style="padding: 10px 45px; border: none; background: #4D0B87; color: white; border-radius: 10px; font-weight: 600; font-size: 16px; cursor: pointer; box-shadow: 0 4px 6px rgba(77,11,135,0.2);">
                Simpan
            </button>
        </div>
    </form>
</div>

{{-- MODALS --}}
<div id="modalBatal" style="display: none; position: fixed; z-index: 99999; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); backdrop-filter: blur(3px); align-items: center; justify-content: center;">
    <div style="background: white; padding: 25px; border-radius: 20px; width: 320px; text-align: center; box-shadow: 0 15px 30px rgba(0,0,0,0.15);">
        <div style="color: #F59E0B; font-size: 40px; margin-bottom: 10px;"><i class="fas fa-exclamation-triangle"></i></div>
        <h2 style="margin: 0; font-size: 18px; color: #111827; font-weight: 700;">Batalkan?</h2>
        <p style="color: #6B7280; font-size: 13px; margin: 8px 0 20px 0;">Perubahan tidak akan disimpan.</p>
        <div style="display: flex; gap: 10px; justify-content: center;">
            <button type="button" id="btnTidakBatal" style="flex: 1; padding: 10px; border-radius: 10px; border: 1px solid #E5E7EB; background: white; color: #374151; font-weight: 600; font-size: 13px; cursor: pointer;">Tidak</button>
            <button type="button" id="btnYaKeluar" style="flex: 1; padding: 10px; border-radius: 10px; border: none; background: #EF4444; color: white; font-weight: 600; font-size: 13px; cursor: pointer;">Ya, Keluar</button>
        </div>
    </div>
</div>

<div id="modalPindahHalaman" style="display: none; position: fixed; z-index: 10000; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); backdrop-filter: blur(3px); align-items: center; justify-content: center;">
    <div style="background: white; padding: 25px; border-radius: 20px; width: 320px; text-align: center; box-shadow: 0 15px 30px rgba(0,0,0,0.15);">
        <div style="color: #F59E0B; font-size: 40px; margin-bottom: 10px;"><i class="fas fa-exclamation-triangle"></i></div>
        <h2 style="margin: 0; font-size: 18px; color: #111827; font-weight: 700;">Perubahan Belum Disimpan</h2>
        <p style="color: #6B7280; font-size: 13px; margin: 8px 0 20px 0;">Ada data yang belum disimpan.</p>
        <div style="display: flex; gap: 10px; justify-content: center;">
            <button type="button" id="btnTidakPindah" style="flex: 1; padding: 10px; border-radius: 10px; border: 1px solid #E5E7EB; background: white; font-weight: 600; font-size: 13px; cursor: pointer;">Tidak</button>
            <button type="button" id="btnYaPindah" style="flex: 1; padding: 10px; border-radius: 10px; border: none; background: #EF4444; color: white; font-weight: 600; font-size: 13px; cursor: pointer;">Ya, Keluar</button>
        </div>
    </div>
</div>

<div id="modalSukses" style="display: none; position: fixed; z-index: 99999; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); backdrop-filter: blur(3px); align-items: center; justify-content: center;">
    <div style="background: white; padding: 25px; border-radius: 20px; width: 320px; text-align: center; box-shadow: 0 15px 30px rgba(0,0,0,0.15);">
        <div style="color: #10B981; font-size: 50px; margin-bottom: 10px;"><i class="fas fa-check-circle"></i></div>
        <h2 style="margin: 0; font-size: 18px; color: #111827; font-weight: 700;">Berhasil!</h2>
        <p style="color: #6B7280; font-size: 13px; margin: 8px 0 20px 0;" id="pesanSukses">Data berhasil diupdate.</p>
        <button type="button" id="btnOkSukses" style="width: 100%; padding: 10px; border-radius: 10px; border: none; background: #10B981; color: white; font-weight: 600; font-size: 13px; cursor: pointer;">OK</button>
    </div>
</div>

<script>
(function() {
    const form = document.querySelector('#mainForm');
    const btnKeluar = document.querySelector('#btnKeluar');
    const btnUpdate = document.querySelector('#btnUpdate');
    const alertError = document.querySelector('#alertError');
    const alertErrorText = document.querySelector('#alertErrorText');
    const modalBatal = document.querySelector('#modalBatal');
    const modalPindah = document.querySelector('#modalPindahHalaman');
    const modalSukses = document.querySelector('#modalSukses');
    const btnTidakBatal = document.querySelector('#btnTidakBatal');
    const btnYaKeluar = document.querySelector('#btnYaKeluar');
    const btnTidakPindah = document.querySelector('#btnTidakPindah');
    const btnYaPindah = document.querySelector('#btnYaPindah');
    const btnOkSukses = document.querySelector('#btnOkSukses');
    const pesanSukses = document.querySelector('#pesanSukses');

    let formChanged = false;
    let formSubmitted = false;

    if (form) {
        form.querySelectorAll('input, select, textarea').forEach(el => {
            el.addEventListener('input', () => { if (!formSubmitted) formChanged = true; });
            el.addEventListener('change', () => { if (!formSubmitted) formChanged = true; });
        });
    }

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

    if (btnTidakBatal) btnTidakBatal.addEventListener('click', () => { if (modalBatal) modalBatal.style.display = 'none'; });
    if (btnYaKeluar) btnYaKeluar.addEventListener('click', () => { formChanged = false; if (modalBatal) modalBatal.style.display = 'none'; tutupModal(); });
    if (btnTidakPindah) btnTidakPindah.addEventListener('click', () => { if (modalPindah) modalPindah.style.display = 'none'; });
    if (btnYaPindah) btnYaPindah.addEventListener('click', () => { formChanged = false; if (modalPindah) modalPindah.style.display = 'none'; tutupModal(); });
    if (btnOkSukses) btnOkSukses.addEventListener('click', () => { if (modalSukses) modalSukses.style.display = 'none'; tutupModal(); window.location.reload(); });

    function tutupModal() {
        const mf = document.getElementById('modalForm');
        if (mf) mf.style.display = 'none';
        const cont = document.getElementById('modalContent');
        if (cont) cont.innerHTML = '';
    }

    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const tanggalMulai = document.querySelector('input[name="tanggal_mulai"]').value;
            const tanggalSelesai = document.querySelector('input[name="tanggal_selesai"]').value;

            if (tanggalMulai && tanggalSelesai && tanggalMulai >= tanggalSelesai) {
                if (alertError && alertErrorText) {
                    alertErrorText.textContent = 'Tanggal Selesai harus setelah Tanggal Mulai!';
                    alertError.style.display = 'flex';
                    setTimeout(() => alertError.style.display = 'none', 5000);
                }
                return;
            }

            const orig = btnUpdate.innerHTML;
            btnUpdate.disabled = true;
            btnUpdate.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';

            const fd = new FormData(form);
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
                    if (pesanSukses) pesanSukses.textContent = data.message || 'Data berhasil diupdate.';
                    if (modalSukses) modalSukses.style.display = 'flex';
                } else {
                    let msg = data.message || 'Gagal menyimpan data.';
                    if (data.errors) msg = Object.values(data.errors).flat().join('\n');
                    if (alertError && alertErrorText) {
                        alertErrorText.textContent = msg;
                        alertError.style.display = 'flex';
                        setTimeout(() => alertError.style.display = 'none', 5000);
                    }
                    btnUpdate.disabled = false;
                    btnUpdate.innerHTML = orig;
                }
            })
            .catch(err => {
                if (alertError && alertErrorText) {
                    alertErrorText.textContent = 'Error: ' + err.message;
                    alertError.style.display = 'flex';
                    setTimeout(() => alertError.style.display = 'none', 5000);
                }
                btnUpdate.disabled = false;
                btnUpdate.innerHTML = orig;
            });
        });
    }
})();
</script>