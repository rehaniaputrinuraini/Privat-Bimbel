@extends('layouts.app')

@section('title', 'Kelola Tentor')

@section('content')
<div style="width: 100%;">
    
    {{-- HEADER --}}
    <div style="margin-bottom: 25px;">
        <p style="color: #374151; font-size: 13px; margin: 0 0 4px 0;">
            {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}
        </p>
        <h1 style="font-size: 26px; font-weight: 700; color: #111827; margin: 0;">Kelola Tentor</h1>
        <p style="color: #374151; font-size: 14px; margin: 4px 0 0 0;">Manajemen Data Tentor</p>
    </div>

    {{-- ACTIONS BAR --}}
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; gap: 15px;">
        <div style="display: flex; align-items: center; gap: 12px; flex: 1;">
            <div style="position: relative; width: 300px;">
                <i class="fas fa-search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #9CA3AF;"></i>
                <input type="text" id="searchInput" placeholder="Cari Nama Tentor..." 
                       style="width: 100%; padding: 10px 15px 10px 45px; border-radius: 12px; border: 1px solid #E5E7EB; outline: none; background: white; font-size: 14px;">
            </div>
        </div>
        
        <button onclick="bukaModalCreate()" style="background-color: #4D0B87; color: white; border: none; padding: 12px 25px; border-radius: 12px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 10px; font-size: 14px; box-shadow: 0 4px 6px rgba(77,11,135,0.2);">
            <i class="fas fa-plus"></i> Tambah
        </button>
    </div>

    {{-- SESSION SUCCESS --}}
    @if(session('success'))
        <div style="background: #D1FAE5; color: #065F46; padding: 12px; border-radius: 10px; margin-bottom: 20px;">{{ session('success') }}</div>
    @endif

    {{-- TABEL --}}
    <div style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.08); border: 1px solid #F3F4F6;">
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 13px; white-space: nowrap;">
                <thead>
                    <tr style="background: #F3E8FF; color: #111827;">
                        <th style="padding: 15px; text-align: center; width: 40px;">No</th>
                        <th style="padding: 15px; width: 80px;">ID</th>
                        <th style="padding: 15px; width: 150px;">Nama</th>
                        <th style="padding: 15px; max-width: 100px;">Alamat</th>
                        <th style="padding: 15px; width: 100px;">No HP</th>
                        <th style="padding: 15px; width: 80px;">Mapel</th>
                        <th style="padding: 15px; text-align: center; width: 60px;">Grade</th>
                        <th style="padding: 15px; width: 100px;">HR SD</th>
                        <th style="padding: 15px; width: 100px;">HR SMP</th>
                        <th style="padding: 15px; width: 100px;">HR SMA</th>
                        <th style="padding: 15px; width: 100px;">Makan</th>
                        <th style="padding: 15px; width: 100px;">Transport</th>
                        <th style="padding: 15px; width: 150px;">Email</th>
                        <th style="padding: 15px; width: 100px;">Username</th>
                        <th style="padding: 15px; text-align: center; width: 170px;">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tableBody" style="color: #374151;">
                    @forelse($tentors as $index => $t)
                    <tr style="border-bottom: 1px solid #F3F4F6;">
                        <td style="padding: 15px; text-align: center;">{{ $tentors->firstItem() + $index }}</td>
                        <td style="padding: 15px;">TE{{ str_pad($t->id_pegawai, 4, '0', STR_PAD_LEFT) }}</td>
                        <td style="padding: 15px; max-width: 150px; overflow: hidden; text-overflow: ellipsis;">{{ $t->nama_lengkap }}</td>
                        <td style="padding: 15px; max-width: 100px; overflow: hidden; text-overflow: ellipsis;" title="{{ $t->alamat }}">{{ $t->alamat ?? '-' }}</td>
                        <td style="padding: 15px;">{{ $t->no_hp ?? '-' }}</td>
                        <td style="padding: 15px;">{{ $t->mapel ?? '-' }}</td>
                        <td style="padding: 15px; text-align: center;">{{ $t->grade ?? '-' }}</td>
                        <td style="padding: 15px;">Rp {{ number_format($t->hr_sd ?? 0, 0, ',', '.') }}</td>
                        <td style="padding: 15px;">Rp {{ number_format($t->hr_smp ?? 0, 0, ',', '.') }}</td>
                        <td style="padding: 15px;">Rp {{ number_format($t->hr_sma ?? 0, 0, ',', '.') }}</td>
                        <td style="padding: 15px;">Rp {{ number_format($t->uang_makan ?? 0, 0, ',', '.') }}</td>
                        <td style="padding: 15px;">Rp {{ number_format($t->uang_transport ?? 0, 0, ',', '.') }}</td>
                        <td style="padding: 15px; max-width: 150px; overflow: hidden; text-overflow: ellipsis;">{{ $t->user->email ?? '-' }}</td>
                        <td style="padding: 15px;">{{ $t->user->username ?? '-' }}</td>
                        <td style="padding: 15px; white-space: nowrap;">
                            <div style="display: flex; gap: 5px; justify-content: center;">
                                <button onclick="bukaModalEdit({{ $t->id_pegawai }})" style="background: #5EB37E; color: white; padding: 6px 10px; border-radius: 6px; border: none; cursor: pointer; font-size: 11px; white-space: nowrap;"><i class="far fa-edit"></i> Edit</button>
                                <button onclick="bukaModalPassword({{ $t->id_pegawai }}, '{{ $t->nama_lengkap }}')" style="background: #F59E0B; color: white; padding: 6px 10px; border-radius: 6px; border: none; cursor: pointer; font-size: 11px; white-space: nowrap;"><i class="fas fa-key"></i> Password</button>
                                <button onclick="bukaModalHapus('{{ $t->id_pegawai }}', '{{ $t->nama_lengkap }}')" style="background: #E35D5D; color: white; padding: 6px 10px; border-radius: 6px; border: none; cursor: pointer; font-size: 11px; white-space: nowrap;"><i class="fas fa-trash"></i> Hapus</button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="15" style="padding: 40px; text-align: center; color: #9CA3AF;"><i class="fas fa-database" style="font-size: 40px; margin-bottom: 10px; display: block;"></i>Belum ada data tentor.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    {{-- PAGINATION (SAMA SEPERTI ADMIN) --}}
    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px; padding: 0 5px;">
        <div style="display: flex; align-items: center; gap: 10px;">
            <select id="pageSelect" style="padding: 8px 12px; border-radius: 10px; border: 1px solid #E5E7EB; color: #374151; font-size: 13px; background: white; outline: none; cursor: pointer;">
                <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10 baris</option>
                <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 baris</option>
                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 baris</option>
            </select>
            <span style="color: #374151; font-size: 13px;">Menampilkan {{ $tentors->count() }} data</span>
        </div>
        <div style="display: flex; gap: 5px;">
            <button onclick="location.href='{{ $tentors->url(1) }}'" style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; cursor: pointer;" {{ $tentors->onFirstPage() ? 'disabled' : '' }}><i class="fas fa-angle-double-left"></i></button>
            <button onclick="location.href='{{ $tentors->previousPageUrl() }}'" style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; cursor: pointer;" {{ $tentors->onFirstPage() ? 'disabled' : '' }}><i class="fas fa-angle-left"></i></button>
            <button style="width: 35px; height: 35px; border-radius: 8px; background: #4D0B87; color: white; border: none; font-weight: 600; cursor: pointer;">1</button>
            <button onclick="location.href='{{ $tentors->nextPageUrl() }}'" style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; cursor: pointer;" {{ $tentors->hasMorePages() ? '' : 'disabled' }}><i class="fas fa-angle-right"></i></button>
        </div>
    </div>

</div>

{{-- MODAL FORM --}}
<div id="modalForm" style="display: none; position: fixed; z-index: 9998; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); backdrop-filter: blur(3px); align-items: center; justify-content: center; overflow-y: auto; padding: 20px;">
    <div style="background: white; border-radius: 20px; width: 750px; max-width: 95%; max-height: 90vh; overflow-y: auto; box-shadow: 0 15px 30px rgba(0,0,0,0.15);" id="modalContent"></div>
</div>

{{-- MODAL HAPUS --}}
<div id="modalHapus" style="display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); backdrop-filter: blur(3px); align-items: center; justify-content: center;">
    <div style="background: white; padding: 25px; border-radius: 20px; width: 320px; text-align: center; box-shadow: 0 15px 30px rgba(0,0,0,0.15); font-family: 'Poppins', sans-serif;">
        <div style="color: #E35D5D; font-size: 40px; margin-bottom: 10px;"><i class="fas fa-trash-alt"></i></div>
        <h2 style="margin: 0; font-size: 18px; color: #111827; font-weight: 700;">Hapus Tentor?</h2>
        <p style="color: #6B7280; font-size: 13px; margin: 8px 0 20px 0;" id="pesanHapus"></p>
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
    // ========== BUKA MODAL ==========
    function bukaModalCreate() {
        fetch("{{ route('superadmin.kelola-tentor.create') }}")
            .then(r => r.text())
            .then(html => {
                document.getElementById('modalContent').innerHTML = html;
                document.getElementById('modalForm').style.display = 'flex';
                setTimeout(() => pasangEventHandler(), 150);
            });
    }

    function bukaModalEdit(id) {
        fetch("{{ route('superadmin.kelola-tentor.edit', '') }}/" + id)
            .then(r => r.text())
            .then(html => {
                document.getElementById('modalContent').innerHTML = html;
                document.getElementById('modalForm').style.display = 'flex';
                setTimeout(() => pasangEventHandler(), 150);
            });
    }

    function tutupModalForm() {
        document.getElementById('modalForm').style.display = 'none';
        document.getElementById('modalContent').innerHTML = '';
    }

    document.getElementById('modalForm').addEventListener('click', function(e) { if (e.target === this) tutupModalForm(); });

    // ========== PASANG EVENT HANDLER ==========
    function pasangEventHandler() {
        const mc = document.getElementById('modalContent');
        if (!mc) return;

        const form = mc.querySelector('#mainForm');
        const btnKeluar = mc.querySelector('#btnKeluar');
        const btnSimpan = mc.querySelector('#btnSimpan');
        const btnUpdate = mc.querySelector('#btnUpdate');
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
            form.querySelectorAll('input:not([readonly]), select, textarea').forEach(el => {
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
                const btn = btnSimpan || btnUpdate;
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
                        if (pesanSukses) pesanSukses.textContent = data.message || 'Data berhasil disimpan.';
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
    }

    // ========== PAGE SELECT ==========
    document.getElementById('pageSelect').addEventListener('change', function() {
        let url = new URL(window.location.href);
        url.searchParams.set('per_page', this.value);
        window.location.href = url.toString();
    });

    // ========== SEARCH ==========
    document.getElementById('searchInput').addEventListener('keyup', function() {
        let v = this.value.toLowerCase();
        document.querySelectorAll('#tableBody tr').forEach(r => { if (r.cells && r.cells.length >= 3) r.style.display = r.cells[2]?.innerText.toLowerCase().includes(v) ? '' : 'none'; });
    });

    // ========== MODAL HAPUS ==========
    function bukaModalHapus(id, nama) {
        document.getElementById('formHapus').action = "{{ route('superadmin.kelola-tentor.destroy', '') }}/" + id;
        document.getElementById('pesanHapus').innerHTML = `Yakin ingin menghapus data tentor <strong>${nama}</strong>?`;
        document.getElementById('modalHapus').style.display = 'flex';
    }
    function tutupModalHapus() { document.getElementById('modalHapus').style.display = 'none'; }
    document.getElementById('modalHapus').addEventListener('click', function(e) { if (e.target === this) tutupModalHapus(); });
</script>
@endsection