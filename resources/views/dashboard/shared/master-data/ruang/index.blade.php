@extends('layouts.app')

@section('title', 'Daftar Ruang')

@section('content')
<div style="width: 100%;">
    
    {{-- HEADER HALAMAN --}}
    <div style="margin-bottom: 25px;">
        <p style="color: #374151; font-size: 13px; margin: 0 0 4px 0;">
            {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}
        </p>
        <h1 style="font-size: 26px; font-weight: 700; color: #111827; margin: 0;">Daftar Ruang</h1>
        <p style="color: #374151; font-size: 14px; margin: 4px 0 0 0;">Manajemen Data Ruangan Bimbel</p>
    </div>

    {{-- SESSION SUCCESS --}}
    @if(session('success'))
        <div style="background: #D1FAE5; color: #065F46; padding: 12px; border-radius: 10px; margin-bottom: 20px;">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    {{-- ACTIONS BAR --}}
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; gap: 15px;">
        <div style="display: flex; align-items: center; gap: 12px; flex: 1;">
            <div style="position: relative; width: 300px;">
                <i class="fas fa-search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #9CA3AF;"></i>
                <input type="text" id="searchInput" placeholder="Cari Nama Ruang..." 
                       style="width: 100%; padding: 10px 15px 10px 45px; border-radius: 12px; border: 1px solid #E5E7EB; outline: none; background: white; font-size: 14px;">
            </div>
        </div>
        
        <button onclick="bukaModalCreate()" style="background-color: #4D0B87; color: white; border: none; padding: 12px 25px; border-radius: 12px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 10px; font-size: 14px; box-shadow: 0 4px 6px rgba(77,11,135,0.2);">
            <i class="fas fa-plus"></i> Tambah
        </button>
    </div>

    {{-- TABEL --}}
    <div style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.08); border: 1px solid #F3F4F6;">
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 13px;">
                <thead>
                    <tr style="background: #F3E8FF; color: #111827;">
                        <th style="padding: 15px; text-align: center; width: 50px;">No</th>
                        <th style="padding: 15px; text-align: center;">Nama Ruang</th>
                        <th style="padding: 15px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tableBody" style="color: #374151;">
                    @forelse($ruang as $index => $item)
                    <tr style="border-bottom: 1px solid #F3F4F6;">
                        <td style="padding: 15px; text-align: center;">{{ $ruang->firstItem() + $index }}</td>
                        <td style="padding: 15px; text-align: center;">{{ $item->nama_ruang }}</td>
                        <td style="padding: 15px; text-align: center;">
                            <div style="display: flex; gap: 8px; justify-content: center;">
                                <button onclick="bukaModalEdit({{ $item->id_ruang }})" 
                                   style="background: #5EB37E; color: white; padding: 6px 12px; border-radius: 6px; border: none; cursor: pointer; font-size: 12px; white-space: nowrap;">
                                    <i class="far fa-edit"></i> Edit
                                </button>
                                <button type="button" onclick="bukaModalHapus('{{ $item->id_ruang }}', '{{ $item->nama_ruang }}')" 
                                        style="background: #E35D5D; color: white; padding: 6px 12px; border-radius: 6px; border: none; cursor: pointer; font-size: 12px; white-space: nowrap;">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" style="padding: 40px; text-align: center; color: #9CA3AF;">
                            <i class="fas fa-door-open" style="font-size: 40px; margin-bottom: 10px; display: block;"></i>
                            Belum ada data ruang.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    {{-- PAGINATION --}}
    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px; padding: 0 5px;">
        <div style="display: flex; align-items: center; gap: 10px;">
            <select id="pageSelect" style="padding: 8px 12px; border-radius: 10px; border: 1px solid #E5E7EB; color: #374151; font-size: 13px; background: white; outline: none; cursor: pointer;">
                <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10 baris</option>
                <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 baris</option>
                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 baris</option>
            </select>
            <span style="color: #374151; font-size: 13px;">Menampilkan {{ $ruang->total() ?? 0 }} data</span>
        </div>

        <div style="display: flex; gap: 5px;">
            @if ($ruang->onFirstPage())
                <button disabled style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: #F3F4F6; color: #9CA3AF; cursor: not-allowed;"><i class="fas fa-angle-double-left"></i></button>
                <button disabled style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: #F3F4F6; color: #9CA3AF; cursor: not-allowed;"><i class="fas fa-angle-left"></i></button>
            @else
                <a href="{{ $ruang->url(1) }}&per_page={{ request('per_page', 10) }}" style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; display: flex; align-items: center; justify-content: center; text-decoration: none;"><i class="fas fa-angle-double-left"></i></a>
                <a href="{{ $ruang->previousPageUrl() }}&per_page={{ request('per_page', 10) }}" style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; display: flex; align-items: center; justify-content: center; text-decoration: none;"><i class="fas fa-angle-left"></i></a>
            @endif

            @php $start = max(1, $ruang->currentPage() - 2); $end = min($ruang->lastPage(), $ruang->currentPage() + 2); @endphp
            @for ($i = $start; $i <= $end; $i++)
                @if ($i == $ruang->currentPage())
                    <button style="width: 35px; height: 35px; border-radius: 8px; background: #4D0B87; color: white; border: none; font-weight: 600;">{{ $i }}</button>
                @else
                    <a href="{{ $ruang->url($i) }}&per_page={{ request('per_page', 10) }}" style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; display: flex; align-items: center; justify-content: center; text-decoration: none;">{{ $i }}</a>
                @endif
            @endfor

            @if ($ruang->hasMorePages())
                <a href="{{ $ruang->nextPageUrl() }}&per_page={{ request('per_page', 10) }}" style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; display: flex; align-items: center; justify-content: center; text-decoration: none;"><i class="fas fa-angle-right"></i></a>
            @else
                <button disabled style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: #F3F4F6; color: #9CA3AF; cursor: not-allowed;"><i class="fas fa-angle-right"></i></button>
            @endif
        </div>
    </div>

</div>

{{-- MODAL FORM --}}
<div id="modalForm" style="display: none; position: fixed; z-index: 9998; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); backdrop-filter: blur(3px); align-items: center; justify-content: center; overflow-y: auto;">
    <div style="background: white; border-radius: 20px; width: 550px; max-width: 95%; max-height: 90vh; overflow-y: auto; box-shadow: 0 15px 30px rgba(0,0,0,0.15);" id="modalContent"></div>
</div>

{{-- MODAL HAPUS --}}
<div id="modalHapus" style="display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); backdrop-filter: blur(3px); align-items: center; justify-content: center;">
    <div style="background: white; padding: 25px; border-radius: 20px; width: 380px; text-align: center; box-shadow: 0 15px 30px rgba(0,0,0,0.15); font-family: 'Poppins', sans-serif;">
        <div style="color: #E35D5D; font-size: 40px; margin-bottom: 10px;"><i class="fas fa-trash-alt"></i></div>
        <h2 style="margin: 0; font-size: 18px; color: #111827; font-weight: 700;">Hapus Ruang?</h2>
        <p style="color: #6B7280; font-size: 12px; margin: 8px 0 20px 0; line-height: 1.5;" id="pesanHapus"></p>
        <div style="display: flex; gap: 10px; justify-content: center;">
            <button onclick="tutupModalHapus()" style="flex: 1; padding: 10px; border-radius: 10px; border: 1px solid #E5E7EB; background: white; font-weight: 600; font-size: 13px; cursor: pointer;">Batal</button>
            <form id="formHapus" method="POST" style="flex: 1;">
                @csrf @method('DELETE')
                <button type="submit" style="width: 100%; padding: 10px; border-radius: 10px; border: none; background: #E35D5D; color: white; font-weight: 600; font-size: 13px; cursor: pointer;">Ya, Hapus</button>
            </form>
        </div>
    </div>
</div>

<script>
    function bukaModalCreate() {
        fetch("{{ route($role . '.master-data.ruang.create') }}").then(r => r.text()).then(html => {
            document.getElementById('modalContent').innerHTML = html;
            document.getElementById('modalForm').style.display = 'flex';
            setTimeout(() => pasangEventHandler(), 100);
        });
    }

    function bukaModalEdit(id) {
        fetch("{{ route($role . '.master-data.ruang.edit', '') }}/" + id).then(r => r.text()).then(html => {
            document.getElementById('modalContent').innerHTML = html;
            document.getElementById('modalForm').style.display = 'flex';
            setTimeout(() => pasangEventHandler(), 100);
        });
    }

    function tutupModalForm() { 
        document.getElementById('modalForm').style.display = 'none'; 
        document.getElementById('modalContent').innerHTML = ''; 
    }

    // ⛔ TIDAK BISA TUTUP DENGAN KLIK DI LUAR

    function pasangEventHandler() {
        const mc = document.getElementById('modalContent');
        if (!mc) return;
        const form = mc.querySelector('form'), btnKeluar = mc.querySelector('#btnKeluar'), btnSimpan = mc.querySelector('#btnSimpan'), btnUpdate = mc.querySelector('#btnUpdate');
        const modalBatal = mc.querySelector('#modalBatal'), modalPindah = mc.querySelector('#modalPindahHalaman'), modalSukses = mc.querySelector('#modalSukses');
        const btnTidakBatal = mc.querySelector('#btnTidakBatal'), btnYaKeluar = mc.querySelector('#btnYaKeluar');
        const btnTidakPindah = mc.querySelector('#btnTidakPindah'), btnYaPindah = mc.querySelector('#btnYaPindah'), btnOkSukses = mc.querySelector('#btnOkSukses');
        const alertError = mc.querySelector('#alertError'), alertErrorText = mc.querySelector('#alertErrorText'), pesanSukses = mc.querySelector('#pesanSukses');
        let formChanged = false, formSubmitted = false;

        if (form) { form.querySelectorAll('input:not([readonly]), select, textarea').forEach(el => { el.addEventListener('input', () => { if (!formSubmitted) formChanged = true; }); el.addEventListener('change', () => { if (!formSubmitted) formChanged = true; }); }); }
        if (btnKeluar) btnKeluar.addEventListener('click', function(e) { e.preventDefault(); if (formChanged && !formSubmitted) { if (modalPindah) modalPindah.style.display = 'flex'; } else { if (modalBatal) modalBatal.style.display = 'flex'; } });
        if (btnTidakBatal) btnTidakBatal.addEventListener('click', () => { if (modalBatal) modalBatal.style.display = 'none'; });
        if (btnYaKeluar) btnYaKeluar.addEventListener('click', () => { formChanged = false; if (modalBatal) modalBatal.style.display = 'none'; tutupModalForm(); });
        if (modalBatal) modalBatal.addEventListener('click', e => { if (e.target === modalBatal) modalBatal.style.display = 'none'; });
        if (btnTidakPindah) btnTidakPindah.addEventListener('click', () => { if (modalPindah) modalPindah.style.display = 'none'; });
        if (btnYaPindah) btnYaPindah.addEventListener('click', () => { formChanged = false; if (modalPindah) modalPindah.style.display = 'none'; tutupModalForm(); });
        if (modalPindah) modalPindah.addEventListener('click', e => { if (e.target === modalPindah) modalPindah.style.display = 'none'; });
        if (btnOkSukses) btnOkSukses.addEventListener('click', () => { if (modalSukses) modalSukses.style.display = 'none'; tutupModalForm(); window.location.reload(); });
        if (modalSukses) modalSukses.addEventListener('click', e => { if (e.target === modalSukses) { modalSukses.style.display = 'none'; tutupModalForm(); window.location.reload(); } });
        if (form) { form.addEventListener('submit', function(e) { e.preventDefault(); const fd = new FormData(form); const btn = btnSimpan || btnUpdate; const orig = btn ? btn.innerHTML : 'Simpan'; if (btn) { btn.disabled = true; btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...'; } fetch(form.action, { method: 'POST', body: fd, headers: { 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '', 'Accept': 'application/json' } }).then(r => r.json()).then(data => { if (data.success) { formChanged = false; formSubmitted = true; if (pesanSukses) pesanSukses.textContent = data.message || 'Data berhasil disimpan.'; if (modalSukses) modalSukses.style.display = 'flex'; } else { let msg = data.message || 'Gagal'; if (data.errors) { msg = ''; for (let f in data.errors) msg += data.errors[f].join('\n') + '\n'; } if (alertError && alertErrorText) { alertErrorText.textContent = msg; alertError.style.display = 'flex'; setTimeout(() => alertError.style.display = 'none', 5000); } if (btn) { btn.disabled = false; btn.innerHTML = orig; } } }).catch(err => { if (alertError && alertErrorText) { alertErrorText.textContent = 'Error: ' + err.message; alertError.style.display = 'flex'; setTimeout(() => alertError.style.display = 'none', 5000); } if (btn) { btn.disabled = false; btn.innerHTML = orig; } }); }); }
    }

    document.getElementById('searchInput').addEventListener('keyup', function() {
        let v = this.value.toLowerCase();
        document.querySelectorAll('#tableBody tr').forEach(row => { row.style.display = row.innerText.toLowerCase().includes(v) ? '' : 'none'; });
    });

    function bukaModalHapus(id, nama) {
        document.getElementById('formHapus').action = "{{ route($role . '.master-data.ruang.destroy', '') }}/" + id;
        document.getElementById('pesanHapus').innerHTML = `Apakah Anda <strong>benar-benar yakin</strong> ingin menghapus ruang <strong>${nama}</strong>?<br><br><small style="color:#EF4444;">⚠️ <strong>PERINGATAN:</strong> Data akan dihapus <strong>secara permanen</strong> dari database. Jika ruang ini sedang digunakan oleh jadwal atau kelas, data terkait akan <strong>tidak dapat dikembalikan</strong>.</small>`;
        document.getElementById('modalHapus').style.display = 'flex';
    }
    function tutupModalHapus() { document.getElementById('modalHapus').style.display = 'none'; }

    // ⛔ TIDAK BISA TUTUP MODAL HAPUS DENGAN KLIK DI LUAR

    document.getElementById('pageSelect').addEventListener('change', function() {
        let url = new URL(window.location.href);
        url.searchParams.set('per_page', this.value);
        url.searchParams.delete('page');
        window.location.href = url.toString();
    });

    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const perPage = urlParams.get('per_page');
        if (perPage && document.getElementById('pageSelect')) document.getElementById('pageSelect').value = perPage;
    });
</script>
@endsection