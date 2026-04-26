@extends('layouts.app')

@section('title', 'Riwayat Pembayaran')

@section('content')
<div style="width: 100%;">

    <div style="margin-bottom: 25px;">
        <p style="color: #374151; font-size: 13px; margin: 0 0 4px 0;">{{ \Carbon\Carbon::now()->translatedFormat('F Y') }}</p>
        <h1 style="font-size: 26px; font-weight: 700; color: #111827; margin: 0;">Riwayat Pembayaran</h1>
        <p style="color: #374151; font-size: 14px; margin: 4px 0 0 0;">Riwayat Pembayaran Murid</p>
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
            <input type="text" id="searchRiwayat" placeholder="Cari Nama Murid..." style="width: 100%; padding: 12px 15px 12px 45px; border-radius: 12px; border: 1px solid #E5E7EB; background: #F9FAFB; font-size: 14px;">
        </div>
        <div style="display: flex; gap: 12px; flex-wrap: wrap;">
            <select id="filterPaketRiwayat" style="flex: 1; padding: 10px 14px; border-radius: 12px; border: 1px solid #E5E7EB; background: #F9FAFB; font-size: 13px;">
                <option value="">Status Paket</option>
                @foreach($paketList as $paket)<option value="{{ $paket->tingkat }}">{{ $paket->tingkat }}</option>@endforeach
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
                @forelse($riwayat as $index => $r)
                <tr style="border-bottom: 1px solid #F3F4F6;">
                    <td style="padding: 15px;">{{ $riwayat->firstItem() + $index }}</td>
                    <td style="padding: 15px;">{{ $r->tanggal }}</td>
                    <td style="padding: 15px;">{{ $r->nama_murid }}</td>
                    <td style="padding: 15px;">{{ $r->paket_awal }}</td>
                    <td style="padding: 15px;">{{ $r->paket_selanjutnya }}</td>
                    <td style="padding: 15px;">{{ $r->bulan_dibayar }}</td>
                    <td style="padding: 15px;">{{ $r->jenis_pembayaran ?? '-' }}</td>
                    <td style="padding: 15px; text-align: center; font-weight: 700; color: #4D0B87;">{{ $r->total_bayar }}</td>
                    <td style="padding: 15px;">{{ $r->keterangan }}</td>
                </tr>
                @empty
                <tr><td colspan="9" style="padding: 40px; text-align: center; color: #9CA3AF;">Belum ada riwayat pembayaran</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- PAGINATION --}}
    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px; padding: 0 5px;">
        <div style="display: flex; align-items: center; gap: 10px;">
            <select id="pageSelect" style="padding: 8px 12px; border-radius: 10px; border: 1px solid #E5E7EB; color: #374151; font-size: 13px; background: white; outline: none; cursor: pointer;">
                <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10 baris</option>
                <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 baris</option>
                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 baris</option>
            </select>
            <span style="color: #374151; font-size: 13px;">Menampilkan {{ $riwayat->total() ?? 0 }} data</span>
        </div>
        <div style="display: flex; gap: 5px;">
            @if ($riwayat->onFirstPage())
                <button disabled style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: #F3F4F6; color: #9CA3AF; cursor: not-allowed;"><i class="fas fa-angle-double-left"></i></button>
                <button disabled style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: #F3F4F6; color: #9CA3AF; cursor: not-allowed;"><i class="fas fa-angle-left"></i></button>
            @else
                <a href="{{ $riwayat->url(1) }}&per_page={{ request('per_page', 10) }}" style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; display: flex; align-items: center; justify-content: center; text-decoration: none;"><i class="fas fa-angle-double-left"></i></a>
                <a href="{{ $riwayat->previousPageUrl() }}&per_page={{ request('per_page', 10) }}" style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; display: flex; align-items: center; justify-content: center; text-decoration: none;"><i class="fas fa-angle-left"></i></a>
            @endif
            @php $start = max(1, $riwayat->currentPage() - 2); $end = min($riwayat->lastPage(), $riwayat->currentPage() + 2); @endphp
            @for ($i = $start; $i <= $end; $i++)
                @if ($i == $riwayat->currentPage())
                    <button style="width: 35px; height: 35px; border-radius: 8px; background: #4D0B87; color: white; border: none; font-weight: 600;">{{ $i }}</button>
                @else
                    <a href="{{ $riwayat->url($i) }}&per_page={{ request('per_page', 10) }}" style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; display: flex; align-items: center; justify-content: center; text-decoration: none;">{{ $i }}</a>
                @endif
            @endfor
            @if ($riwayat->hasMorePages())
                <a href="{{ $riwayat->nextPageUrl() }}&per_page={{ request('per_page', 10) }}" style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; display: flex; align-items: center; justify-content: center; text-decoration: none;"><i class="fas fa-angle-right"></i></a>
            @else
                <button disabled style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: #F3F4F6; color: #9CA3AF; cursor: not-allowed;"><i class="fas fa-angle-right"></i></button>
            @endif
        </div>
    </div>

</div>

{{-- MODAL FORM --}}
<div id="modalForm" style="display: none; position: fixed; z-index: 9998; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); backdrop-filter: blur(3px); align-items: center; justify-content: center; overflow-y: auto; padding: 20px;">
    <div style="background: white; border-radius: 20px; width: 750px; max-width: 95%; max-height: 90vh; overflow-y: auto; box-shadow: 0 15px 30px rgba(0,0,0,0.15);" id="modalContent"></div>
</div>

<script>
    function bukaModalCreate() {
        fetch("{{ route($role . '.pembayaran.create') }}").then(r => r.text()).then(html => {
            document.getElementById('modalContent').innerHTML = html;
            document.getElementById('modalForm').style.display = 'flex';
            setTimeout(() => pasangEventHandlerPembayaran(), 150);
        });
    }

    function tutupModalForm() { document.getElementById('modalForm').style.display = 'none'; document.getElementById('modalContent').innerHTML = ''; }
    document.getElementById('modalForm').addEventListener('click', function(e) { if (e.target === this) tutupModalForm(); });

    function pasangEventHandlerPembayaran() {
        const mc = document.getElementById('modalContent');
        if (!mc) return;
        const form = mc.querySelector('#mainForm'), btnKeluar = mc.querySelector('#btnKeluar'), btnSimpan = mc.querySelector('#btnSimpan');
        const modalBatal = mc.querySelector('#modalBatal'), modalPindah = mc.querySelector('#modalPindahHalaman'), modalSukses = mc.querySelector('#modalSukses');
        const btnTidakBatal = mc.querySelector('#btnTidakBatal'), btnYaKeluar = mc.querySelector('#btnYaKeluar');
        const btnTidakPindah = mc.querySelector('#btnTidakPindah'), btnYaPindah = mc.querySelector('#btnYaPindah'), btnOkSukses = mc.querySelector('#btnOkSukses');
        const alertError = mc.querySelector('#alertError'), alertErrorText = mc.querySelector('#alertErrorText'), pesanSukses = mc.querySelector('#pesanSukses');
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

        // AUTOCOMPLETE - SAMA PERSIS DENGAN TAGIHAN
        const searchInput = mc.querySelector('#searchMurid'), autocompleteDiv = mc.querySelector('#autocompleteResult'), idHidden = mc.querySelector('#id_murid');
        if (searchInput) { searchInput.addEventListener('input', function() { const q = this.value.trim(); if (q.length < 2) { autocompleteDiv.style.display = 'none'; return; } fetch('/search-murid?q=' + encodeURIComponent(q)).then(r => r.json()).then(data => { if (data.length) { autocompleteDiv.innerHTML = data.map(m => `<div style="padding:10px 15px;cursor:pointer;border-bottom:1px solid #F3F4F6;" onmouseover="this.style.background='#F3E8FF'" onmouseout="this.style.background='white'" data-id="${m.id_murid}"><strong>${m.nama_lengkap}</strong><br><small>${m.asal_sekolah || '-'} | ${m.no_hp || '-'}</small></div>`).join(''); autocompleteDiv.style.display = 'block'; autocompleteDiv.querySelectorAll('div[data-id]').forEach(item => { item.addEventListener('click', function() { searchInput.value = this.querySelector('strong').innerText; idHidden.value = this.dataset.id; autocompleteDiv.style.display = 'none'; cekStatus(this.dataset.id); }); }); } else { autocompleteDiv.innerHTML = '<div style="padding:10px 15px;">Tidak ditemukan</div>'; autocompleteDiv.style.display = 'block'; } }); }); }
        document.addEventListener('click', function(e) { if (searchInput && !searchInput.contains(e.target) && autocompleteDiv && !autocompleteDiv.contains(e.target)) autocompleteDiv.style.display = 'none'; });

        // CEK STATUS - SAMA PERSIS DENGAN TAGIHAN
        function cekStatus(id) {
            fetch('/cek-status-pembayaran/' + id).then(r => r.json()).then(d => {
                const info = mc.querySelector('#infoStatusMurid'), paketSelect = mc.querySelector('#paket_selanjutnya');
                const totalInput = mc.querySelector('#total_pembayaran'), bulanGroup = mc.querySelector('#bulanGroup');
                const bulanSelect = mc.querySelector('#bulan_dibayar');

                if (bulanSelect) {
                    for (let i = 0; i < bulanSelect.options.length; i++) {
                        bulanSelect.options[i].disabled = false;
                        bulanSelect.options[i].text = bulanSelect.options[i].text.replace(' (Lunas)', '');
                    }
                }

                if (!d.sudah_bayar_pendaftaran) {
                    info.innerHTML = '<div style="padding:12px 15px;border-radius:10px;margin-bottom:15px;background:#FEF3C7;color:#92400E;"><i class="fas fa-exclamation-triangle"></i> <strong>Pendaftaran Baru!</strong><br>Wajib bayar Rp 100.000.</div>';
                    info.style.display = 'block';
                    if (paketSelect) paketSelect.disabled = true;
                    if (bulanGroup) bulanGroup.style.display = 'none';
                    if (totalInput) totalInput.value = '100000';
                } else {
                    info.innerHTML = '<div style="padding:12px 15px;border-radius:10px;margin-bottom:15px;background:#E0E7FF;color:#1E40AF;"><i class="fas fa-check-circle"></i> <strong>Sudah Terdaftar!</strong></div>';
                    info.style.display = 'block';
                    if (paketSelect) { paketSelect.disabled = false; if (d.paket_aktif) { paketSelect.value = d.paket_aktif; const h = parseInt(paketSelect.options[paketSelect.selectedIndex]?.dataset?.harga) || 0; if (totalInput) totalInput.value = h; } }
                    if (bulanGroup) bulanGroup.style.display = 'block';

                    if (d.bulan_lunas && bulanSelect) {
                        d.bulan_lunas.forEach(function(bulan) {
                            for (let i = 0; i < bulanSelect.options.length; i++) {
                                if (parseInt(bulanSelect.options[i].value) === bulan) {
                                    bulanSelect.options[i].disabled = true;
                                    bulanSelect.options[i].text += ' (Lunas)';
                                }
                            }
                        });
                    }

                    if (d.bulan_tunggakan && bulanSelect) {
                        bulanSelect.value = d.bulan_tunggakan;
                    } else if (d.bulan_berikutnya && bulanSelect) {
                        bulanSelect.value = d.bulan_berikutnya;
                    }
                }
            });
        }

        const paketEl = mc.querySelector('#paket_selanjutnya'), totalEl = mc.querySelector('#total_pembayaran');
        if (paketEl) paketEl.addEventListener('change', function() { const h = parseInt(this.options[this.selectedIndex]?.dataset?.harga) || 0; if (h > 0 && totalEl) totalEl.value = h; });
    }

    document.getElementById('pageSelect').addEventListener('change', function() {
        let url = new URL(window.location.href);
        url.searchParams.set('per_page', this.value);
        url.searchParams.delete('page');
        window.location.href = url.toString();
    });

    function filterRiwayat() {
        const s = document.getElementById('searchRiwayat')?.value.toLowerCase() || '';
        const fp = document.getElementById('filterPaketRiwayat')?.value || '';
        const fj = document.getElementById('filterJenisPembayaran')?.value || '';
        const fb = document.getElementById('filterBulan')?.value || '';
        const ft = document.getElementById('filterTahunRiwayat')?.value || '';
        document.querySelectorAll('#riwayatTableBody tr').forEach(row => {
            if (!row.cells || row.cells.length < 9) return;
            const n = row.cells[2]?.innerText.toLowerCase() || '', p = row.cells[4]?.innerText || '';
            const j = row.cells[6]?.innerText || '', tgl = row.cells[1]?.innerText || '';
            const parts = tgl.split('/'), b = parts[1] ? parseInt(parts[1]) : 0, t = parts[2] ? parseInt(parts[2]) : 0;
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
@endsection