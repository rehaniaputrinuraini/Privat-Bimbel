@extends('layouts.app')

@section('title', 'Tagihan Murid')

@section('content')
<div style="width: 100%;">

    <div style="margin-bottom: 25px;">
        <p style="color: #374151; font-size: 13px; margin: 0 0 4px 0;">{{ \Carbon\Carbon::now()->translatedFormat('F Y') }}</p>
        <h1 style="font-size: 26px; font-weight: 700; color: #111827; margin: 0;">Tagihan Murid</h1>
        <p style="color: #374151; font-size: 14px; margin: 4px 0 0 0;">Kelola Tagihan Pembayaran Murid</p>
    </div>

    <div style="display: flex; justify-content: flex-end; margin-bottom: 25px;">
        <button onclick="bukaModalCreate()" style="background-color: #4D0B87; color: white; border: none; padding: 12px 25px; border-radius: 12px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 10px; font-size: 14px; box-shadow: 0 4px 6px rgba(77, 11, 135, 0.2);">
            <i class="fas fa-plus"></i> Input Pembayaran Murid
        </button>
    </div>

    @if(session('success'))
        <div style="background: #D1FAE5; color: #065F46; padding: 12px; border-radius: 10px; margin-bottom: 20px;">{{ session('success') }}</div>
    @endif

    <div style="background: white; border-radius: 16px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.06); margin-bottom: 20px;">
        <div style="position: relative; margin-bottom: 12px;">
            <i class="fas fa-search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #9CA3AF;"></i>
            <input type="text" id="searchTagihan" placeholder="Cari Nama Murid..." style="width: 100%; padding: 12px 15px 12px 45px; border-radius: 12px; border: 1px solid #E5E7EB; background: #F9FAFB; font-size: 14px;">
        </div>
        <div style="display: flex; gap: 12px; flex-wrap: wrap;">
            <select id="filterPaket" style="flex: 1; padding: 10px 14px; border-radius: 12px; border: 1px solid #E5E7EB; background: #F9FAFB; font-size: 13px;">
                <option value="">Status Paket</option>
                @foreach($paketList as $paket)<option value="{{ $paket->tingkat }}">{{ $paket->tingkat }}</option>@endforeach
            </select>
            <select id="filterPembayaran" style="flex: 1; padding: 10px 14px; border-radius: 12px; border: 1px solid #E5E7EB; background: #F9FAFB; font-size: 13px;">
                <option value="">Status Pembayaran</option>
                <option value="Lunas">Lunas</option><option value="Belum">Belum</option>
            </select>
            <select id="filterTagihan" style="flex: 1; padding: 10px 14px; border-radius: 12px; border: 1px solid #E5E7EB; background: #F9FAFB; font-size: 13px;">
                <option value="">Status Tagihan</option>
                <option value="Lunas">Lunas</option><option value="Tunggak">Tunggak</option><option value="Uang Muka">Uang Muka</option>
            </select>
        </div>
    </div>

    <div style="background: white; border-radius: 20px; overflow-x: auto; box-shadow: 0 4px 15px rgba(0,0,0,0.08);">
        <table style="width: 100%; border-collapse: collapse; font-size: 13px; white-space: nowrap;">
            <thead><tr style="background: #F3E8FF;">
                <th style="padding: 15px;">No</th><th style="padding: 15px;">Nama Murid</th><th style="padding: 15px;">Kelas</th>
                <th style="padding: 15px;">Status Paket</th><th style="padding: 15px; text-align: center;">Pendaftaran</th>
                <th style="padding: 15px; text-align: center;">Pembayaran</th><th style="padding: 15px; text-align: center;">Tagihan</th>
                <th style="padding: 15px; text-align: center;">Tagihan Bulan</th><th style="padding: 15px; text-align: center;">Total Piutang</th>
                <th style="padding: 15px; text-align: center;">Uang Muka</th>
            </tr></thead>
            <tbody id="tagihanTableBody">
                @forelse($tagihan as $index => $t)
                <tr style="border-bottom: 1px solid #F3F4F6;">
                    <td style="padding: 15px;">{{ $index + 1 }}</td>
                    <td style="padding: 15px;">{{ $t->nama_murid }}</td>
                    <td style="padding: 15px;">{{ $t->kelas ?? '-' }}</td>
                    <td style="padding: 15px;">{{ $t->paket ?? '-' }}</td>
                    <td style="padding: 15px; text-align: center;">{!! $t->status_pendaftaran == 'Lunas' ? '<span style="padding:5px 12px;border-radius:20px;background:#E1F7E3;color:#0E7490;">Lunas</span>' : '<span style="padding:5px 12px;border-radius:20px;background:#FEE2E2;color:#EF4444;">Belum</span>' !!}</td>
                    <td style="padding: 15px; text-align: center;">{!! $t->status_pembayaran == 'Lunas' ? '<span style="padding:5px 12px;border-radius:20px;background:#E1F7E3;color:#0E7490;">Lunas</span>' : ($t->status_pembayaran == 'Belum' ? '<span style="padding:5px 12px;border-radius:20px;background:#FEE2E2;color:#EF4444;">Belum</span>' : '-') !!}</td>
                    <td style="padding: 15px; text-align: center;">{!! $t->status_tagihan == 'Lunas' ? '<span style="padding:5px 12px;border-radius:20px;background:#E1F7E3;color:#0E7490;">Lunas</span>' : ($t->status_tagihan == 'Tunggak' ? '<span style="padding:5px 12px;border-radius:20px;background:#FEF3C7;color:#92400E;">Tunggak</span>' : ($t->status_tagihan == 'Uang Muka' ? '<span style="padding:5px 12px;border-radius:20px;background:#E0E7FF;color:#4338CA;">Uang Muka</span>' : '-')) !!}</td>
                    <td style="padding: 15px; text-align: center;">{{ $t->tagihan_bulan ?? '-' }}</td>
                    <td style="padding: 15px; text-align: center; {{ $t->total_piutang != '-' ? 'font-weight:700;color:#EF4444;' : '' }}">{{ $t->total_piutang ?? '-' }}</td>
                    <td style="padding: 15px; text-align: center;">{{ $t->uang_muka ?? '-' }}</td>
                </tr>
                @empty
                <tr><td colspan="10" style="padding: 40px; text-align: center; color: #9CA3AF;">Belum ada data tagihan</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

{{-- MODAL FORM --}}
<div id="modalForm" style="display: none; position: fixed; z-index: 9998; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); backdrop-filter: blur(3px); align-items: center; justify-content: center; overflow-y: auto; padding: 20px;">
    <div style="background: white; border-radius: 20px; width: 750px; max-width: 95%; max-height: 90vh; overflow-y: auto; box-shadow: 0 15px 30px rgba(0,0,0,0.15);" id="modalContent"></div>
</div>

<script>
    function bukaModalCreate() {
        fetch("{{ route($role . '.pembayaran.create') }}")
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

        if (form) {
            form.querySelectorAll('input, select, textarea').forEach(el => {
                el.addEventListener('input', () => { if (!formSubmitted) formChanged = true; });
                el.addEventListener('change', () => { if (!formSubmitted) formChanged = true; });
            });
        }

        if (btnKeluar) btnKeluar.addEventListener('click', function(e) {
            e.preventDefault();
            if (formChanged && !formSubmitted) { if (modalPindah) modalPindah.style.display = 'flex'; }
            else { if (modalBatal) modalBatal.style.display = 'flex'; }
        });

        if (btnTidakBatal) btnTidakBatal.addEventListener('click', () => { if (modalBatal) modalBatal.style.display = 'none'; });
        if (btnYaKeluar) btnYaKeluar.addEventListener('click', () => { formChanged = false; if (modalBatal) modalBatal.style.display = 'none'; tutupModalForm(); });
        if (modalBatal) modalBatal.addEventListener('click', e => { if (e.target === modalBatal) modalBatal.style.display = 'none'; });

        if (btnTidakPindah) btnTidakPindah.addEventListener('click', () => { if (modalPindah) modalPindah.style.display = 'none'; });
        if (btnYaPindah) btnYaPindah.addEventListener('click', () => { formChanged = false; if (modalPindah) modalPindah.style.display = 'none'; tutupModalForm(); });
        if (modalPindah) modalPindah.addEventListener('click', e => { if (e.target === modalPindah) modalPindah.style.display = 'none'; });

        if (btnOkSukses) btnOkSukses.addEventListener('click', () => { if (modalSukses) modalSukses.style.display = 'none'; tutupModalForm(); window.location.reload(); });
        if (modalSukses) modalSukses.addEventListener('click', e => { if (e.target === modalSukses) { modalSukses.style.display = 'none'; tutupModalForm(); window.location.reload(); } });

        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const fd = new FormData(form);
                const btn = btnSimpan;
                const orig = btn ? btn.innerHTML : 'Simpan';
                if (btn) { btn.disabled = true; btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...'; }

                fetch(form.action, {
                    method: 'POST', body: fd,
                    headers: { 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '', 'Accept': 'application/json' }
                })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        formChanged = false; formSubmitted = true;
                        if (pesanSukses) pesanSukses.textContent = data.message || 'Pembayaran berhasil disimpan.';
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

        // AUTOCOMPLETE
        const searchInput = mc.querySelector('#searchMurid');
        const autocompleteDiv = mc.querySelector('#autocompleteResult');
        const idHidden = mc.querySelector('#id_murid');
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                const q = this.value.trim();
                if (q.length < 2) { autocompleteDiv.style.display = 'none'; return; }
                fetch('/search-murid?q=' + encodeURIComponent(q))
                    .then(r => r.json())
                    .then(data => {
                        if (data.length) {
                            autocompleteDiv.innerHTML = data.map(m => `<div style="padding:10px 15px;cursor:pointer;border-bottom:1px solid #F3F4F6;" onmouseover="this.style.background='#F3E8FF'" onmouseout="this.style.background='white'" data-id="${m.id_murid}"><strong>${m.nama_lengkap}</strong><br><small>${m.asal_sekolah || '-'} | ${m.no_hp || '-'}</small></div>`).join('');
                            autocompleteDiv.style.display = 'block';
                            autocompleteDiv.querySelectorAll('div[data-id]').forEach(item => {
                                item.addEventListener('click', function() {
                                    searchInput.value = this.querySelector('strong').innerText;
                                    idHidden.value = this.dataset.id;
                                    autocompleteDiv.style.display = 'none';
                                    cekStatus(this.dataset.id);
                                });
                            });
                        } else { autocompleteDiv.innerHTML = '<div style="padding:10px 15px;">Tidak ditemukan</div>'; autocompleteDiv.style.display = 'block'; }
                    });
            });
        }
        document.addEventListener('click', function(e) { if (searchInput && !searchInput.contains(e.target) && autocompleteDiv && !autocompleteDiv.contains(e.target)) autocompleteDiv.style.display = 'none'; });

        function cekStatus(id) {
            fetch('/cek-status-pembayaran/' + id).then(r => r.json()).then(d => {
                const info = mc.querySelector('#infoStatusMurid');
                const paketSelect = mc.querySelector('#paket_selanjutnya');
                const totalInput = mc.querySelector('#total_pembayaran');
                const bulanGroup = mc.querySelector('#bulanGroup');
                if (!d.sudah_bayar_pendaftaran) {
                    info.innerHTML = '<div style="padding:12px 15px;border-radius:10px;margin-bottom:15px;background:#FEF3C7;color:#92400E;"><i class="fas fa-exclamation-triangle"></i> <strong>Pendaftaran Baru!</strong><br>Wajib bayar Rp 100.000.</div>';
                    info.style.display = 'block'; if (paketSelect) paketSelect.disabled = true; if (bulanGroup) bulanGroup.style.display = 'none'; if (totalInput) totalInput.value = '100000';
                } else {
                    info.innerHTML = '<div style="padding:12px 15px;border-radius:10px;margin-bottom:15px;background:#E0E7FF;color:#1E40AF;"><i class="fas fa-check-circle"></i> <strong>Sudah Terdaftar!</strong></div>';
                    info.style.display = 'block'; if (paketSelect) { paketSelect.disabled = false; if (d.paket_aktif) { paketSelect.value = d.paket_aktif; const h = parseInt(paketSelect.options[paketSelect.selectedIndex]?.dataset?.harga) || 0; if (totalInput) totalInput.value = h; } }
                    if (bulanGroup) bulanGroup.style.display = 'block'; if (d.bulan_tunggakan) { const b = mc.querySelector('#bulan_dibayar'); if (b) b.value = d.bulan_tunggakan; }
                }
            });
        }

        const paketEl = mc.querySelector('#paket_selanjutnya');
        const totalEl = mc.querySelector('#total_pembayaran');
        if (paketEl) paketEl.addEventListener('change', function() { const h = parseInt(this.options[this.selectedIndex]?.dataset?.harga) || 0; if (h > 0 && totalEl) totalEl.value = h; });
    }

    // FILTER
    function filterTagihan() {
        const s = document.getElementById('searchTagihan')?.value.toLowerCase() || '';
        const fp = document.getElementById('filterPaket')?.value || '';
        const fby = document.getElementById('filterPembayaran')?.value || '';
        const ftg = document.getElementById('filterTagihan')?.value || '';
        document.querySelectorAll('#tagihanTableBody tr').forEach(row => {
            if (!row.cells || row.cells.length < 10) return;
            const n = row.cells[1]?.innerText.toLowerCase() || '';
            const p = row.cells[3]?.innerText || '';
            const sp = row.cells[5]?.innerText.trim() || '';
            const st = row.cells[6]?.innerText.trim() || '';
            let show = true;
            if (s && !n.includes(s)) show = false;
            if (fp && p !== fp) show = false;
            if (fby && sp !== fby) show = false;
            if (ftg && st !== ftg) show = false;
            row.style.display = show ? '' : 'none';
        });
    }
    document.getElementById('searchTagihan')?.addEventListener('keyup', filterTagihan);
    document.getElementById('filterPaket')?.addEventListener('change', filterTagihan);
    document.getElementById('filterPembayaran')?.addEventListener('change', filterTagihan);
    document.getElementById('filterTagihan')?.addEventListener('change', filterTagihan);
</script>
@endsection