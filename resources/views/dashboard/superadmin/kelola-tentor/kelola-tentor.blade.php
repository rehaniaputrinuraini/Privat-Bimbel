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
                        <th style="padding: 15px; text-align: center; width: 35px;">No</th>
                        <th style="padding: 15px; width: 70px;">ID</th>
                        <th style="padding: 15px; width: 130px;">Nama</th>
                        <th style="padding: 15px; max-width: 80px;">Alamat</th>
                        <th style="padding: 15px; width: 90px;">No HP</th>
                        <th style="padding: 15px; width: 70px;">Mapel</th>
                        <th style="padding: 15px; text-align: center; width: 50px;">Grade</th>
                        <th style="padding: 15px; text-align: center; width: 100px;">Detail Gaji</th>
                        <th style="padding: 15px; width: 130px;">Email</th>
                        <th style="padding: 15px; width: 80px;">Username</th>
                        <th style="padding: 15px; text-align: center; width: 60px;">Status</th>
                        <th style="padding: 15px; text-align: center; width: 175px;">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tableBody" style="color: #374151;">
                    @forelse($tentors as $index => $t)
                    @php
                        $status = $t->user->status ?? 1;
                        $nama = $t->nama_lengkap;
                        $id = $t->id_pegawai;
                        $rowId = 'row_' . $id;
                    @endphp
                    <tr id="{{ $rowId }}" style="border-bottom: 1px solid #F3F4F6;">
                        <td style="padding: 15px; text-align: center;">{{ $tentors->firstItem() + $index }}</td>
                        <td style="padding: 15px;">TE{{ str_pad($id, 4, '0', STR_PAD_LEFT) }}</td>
                        <td style="padding: 15px; max-width: 130px; overflow: hidden; text-overflow: ellipsis;">{{ $nama }}</td>
                        <td style="padding: 15px; max-width: 80px; overflow: hidden; text-overflow: ellipsis;" title="{{ $t->alamat }}">{{ $t->alamat ?? '-' }}</td>
                        <td style="padding: 15px;">{{ $t->no_hp ?? '-' }}</td>
                        <td style="padding: 15px;">{{ $t->mapel ?? '-' }}</td>
                        <td style="padding: 15px; text-align: center;">{{ $t->grade ?? '-' }}</td>
                        <td style="padding: 15px; text-align: center;">
                            <button onclick="toggleDetail('{{ $rowId }}', {{ $id }})" 
                                    style="background: #4D0B87; color: white; border: none; padding: 5px 12px; border-radius: 15px; cursor: pointer; font-size: 11px; font-weight: 600;">
                                <i class="fas fa-chevron-down"></i> Lihat Detail
                            </button>
                        </td>
                        <td style="padding: 15px; max-width: 130px; overflow: hidden; text-overflow: ellipsis;">{{ $t->user->email ?? '-' }}</td>
                        <td style="padding: 15px;">{{ $t->user->username ?? '-' }}</td>
                        <td style="padding: 15px; text-align: center;">
                            @if($status == 1)
                                <span style="padding: 4px 10px; border-radius: 20px; background: #E1F7E3; color: #0E7490; font-size: 10px;">Aktif</span>
                            @else
                                <span style="padding: 4px 10px; border-radius: 20px; background: #FEE2E2; color: #EF4444; font-size: 10px;">Nonaktif</span>
                            @endif
                        </td>
                        <td style="padding: 15px; white-space: nowrap;">
                            <div style="display: flex; gap: 3px; justify-content: center; flex-wrap: nowrap;">
                                <button onclick="bukaModalEdit({{ $id }})" style="background: #5EB37E; color: white; padding: 4px 7px; border-radius: 5px; border: none; cursor: pointer; font-size: 10px; white-space: nowrap;"><i class="far fa-edit"></i> Edit</button>
                                <button onclick="bukaModalPassword({{ $id }}, '{{ $nama }}')" style="background: #F59E0B; color: white; padding: 4px 7px; border-radius: 5px; border: none; cursor: pointer; font-size: 10px; white-space: nowrap;"><i class="fas fa-key"></i> Pass</button>
                                <button onclick="bukaModalHapus('{{ $id }}', '{{ $nama }}')" style="background: #E35D5D; color: white; padding: 4px 7px; border-radius: 5px; border: none; cursor: pointer; font-size: 10px; white-space: nowrap;"><i class="fas fa-trash"></i> Hapus</button>
                                <button onclick="bukaModalToggle('{{ $id }}', '{{ $nama }}', '{{ $status }}')" style="background: {{ $status == 1 ? '#EF4444' : '#10B981' }}; color: white; padding: 4px 7px; border-radius: 5px; border: none; cursor: pointer; font-size: 10px; white-space: nowrap;"><i class="fas {{ $status == 1 ? 'fa-ban' : 'fa-check' }}"></i> {{ $status == 1 ? 'Nonaktif' : 'Aktifkan' }}</button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="12" style="padding: 40px; text-align: center; color: #9CA3AF;"><i class="fas fa-database" style="font-size: 40px; margin-bottom: 10px; display: block;"></i>Belum ada data tentor.</td></tr>
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
            <span style="color: #374151; font-size: 13px;">Menampilkan {{ $tentors->total() ?? 0 }} data</span>
        </div>
        <div style="display: flex; gap: 5px;">
            @if ($tentors->onFirstPage())
                <button disabled style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: #F3F4F6; color: #9CA3AF; cursor: not-allowed;"><i class="fas fa-angle-double-left"></i></button>
                <button disabled style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: #F3F4F6; color: #9CA3AF; cursor: not-allowed;"><i class="fas fa-angle-left"></i></button>
            @else
                <a href="{{ $tentors->url(1) }}&per_page={{ request('per_page', 10) }}" style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; display: flex; align-items: center; justify-content: center; text-decoration: none;"><i class="fas fa-angle-double-left"></i></a>
                <a href="{{ $tentors->previousPageUrl() }}&per_page={{ request('per_page', 10) }}" style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; display: flex; align-items: center; justify-content: center; text-decoration: none;"><i class="fas fa-angle-left"></i></a>
            @endif

            @php $start = max(1, $tentors->currentPage() - 2); $end = min($tentors->lastPage(), $tentors->currentPage() + 2); @endphp
            @for ($i = $start; $i <= $end; $i++)
                @if ($i == $tentors->currentPage())
                    <button style="width: 35px; height: 35px; border-radius: 8px; background: #4D0B87; color: white; border: none; font-weight: 600;">{{ $i }}</button>
                @else
                    <a href="{{ $tentors->url($i) }}&per_page={{ request('per_page', 10) }}" style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; display: flex; align-items: center; justify-content: center; text-decoration: none;">{{ $i }}</a>
                @endif
            @endfor

            @if ($tentors->hasMorePages())
                <a href="{{ $tentors->nextPageUrl() }}&per_page={{ request('per_page', 10) }}" style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; display: flex; align-items: center; justify-content: center; text-decoration: none;"><i class="fas fa-angle-right"></i></a>
            @else
                <button disabled style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: #F3F4F6; color: #9CA3AF; cursor: not-allowed;"><i class="fas fa-angle-right"></i></button>
            @endif
        </div>
    </div>

</div>

{{-- MODAL FORM --}}
<div id="modalForm" style="display: none; position: fixed; z-index: 9998; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); backdrop-filter: blur(3px); align-items: center; justify-content: center; overflow-y: auto;">
    <div style="background: white; border-radius: 20px; width: 750px; max-width: 95%; max-height: 90vh; overflow-y: auto; box-shadow: 0 15px 30px rgba(0,0,0,0.15);" id="modalContent"></div>
</div>

{{-- MODAL HAPUS --}}
<div id="modalHapus" style="display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); backdrop-filter: blur(3px); align-items: center; justify-content: center;">
    <div style="background: white; padding: 25px; border-radius: 20px; width: 380px; text-align: center; box-shadow: 0 15px 30px rgba(0,0,0,0.15); font-family: 'Poppins', sans-serif;">
        <div style="color: #E35D5D; font-size: 40px; margin-bottom: 10px;"><i class="fas fa-trash-alt"></i></div>
        <h2 style="margin: 0; font-size: 18px; color: #111827; font-weight: 700;">Hapus Tentor?</h2>
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

{{-- MODAL TOGGLE STATUS --}}
<div id="modalToggle" style="display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); backdrop-filter: blur(3px); align-items: center; justify-content: center; font-family: 'Poppins', sans-serif;">
    <div style="background: white; padding: 25px; border-radius: 20px; width: 350px; text-align: center; box-shadow: 0 15px 30px rgba(0,0,0,0.15);">
        <div style="font-size: 40px; margin-bottom: 10px;" id="toggleIcon"></div>
        <h2 style="margin: 0; font-size: 18px; color: #111827; font-weight: 700;" id="toggleJudul"></h2>
        <p style="color: #6B7280; font-size: 12px; margin: 8px 0 20px 0; line-height: 1.5;" id="togglePesan"></p>
        <div style="display: flex; gap: 10px; justify-content: center;">
            <button onclick="tutupModalToggle()" style="flex: 1; padding: 10px; border-radius: 10px; border: 1px solid #E5E7EB; background: white; font-weight: 600; font-size: 13px; cursor: pointer;">Batal</button>
            <form id="formToggle" method="POST" style="flex: 1;">
                @csrf @method('PATCH')
                <button type="submit" style="width: 100%; padding: 10px; border-radius: 10px; border: none; color: white; font-weight: 600; font-size: 13px; cursor: pointer;" id="btnToggle"></button>
            </form>
        </div>
    </div>
</div>

<script>
    // ========== TOGGLE DETAIL GAJI ==========
    function toggleDetail(rowId, tentorId) {
        const detailRowId = rowId + '_detail';
        const existingDetail = document.getElementById(detailRowId);
        const btn = document.querySelector(`#${rowId} button`);
        
        if (existingDetail) {
            // Jika sudah ada, hapus
            existingDetail.remove();
            if (btn) {
                btn.innerHTML = '<i class="fas fa-chevron-down"></i> Lihat Detail';
            }
        } else {
            // Ambil data detail dari server
            fetch("{{ route('superadmin.kelola-tentor.detail', '') }}/" + tentorId)
                .then(r => r.json())
                .then(data => {
                    const newRow = document.createElement('tr');
                    newRow.id = detailRowId;
                    newRow.style.backgroundColor = '#F9FAFB';
                    newRow.innerHTML = `
                        <td colspan="12" style="padding: 12px 20px;">
                            <div style="display: flex; gap: 20px; flex-wrap: wrap; font-size: 12px;">
                                <div style="background: #F3E8FF; padding: 8px 15px; border-radius: 8px;">
                                    <strong>HR SD:</strong> Rp ${data.hr_sd ? data.hr_sd.toLocaleString('id-ID') : '0'}
                                </div>
                                <div style="background: #F3E8FF; padding: 8px 15px; border-radius: 8px;">
                                    <strong>HR SMP:</strong> Rp ${data.hr_smp ? data.hr_smp.toLocaleString('id-ID') : '0'}
                                </div>
                                <div style="background: #F3E8FF; padding: 8px 15px; border-radius: 8px;">
                                    <strong>HR SMA:</strong> Rp ${data.hr_sma ? data.hr_sma.toLocaleString('id-ID') : '0'}
                                </div>
                                <div style="background: #E0E7FF; padding: 8px 15px; border-radius: 8px;">
                                    <strong>Uang Makan:</strong> Rp ${data.uang_makan ? data.uang_makan.toLocaleString('id-ID') : '0'}
                                </div>
                                <div style="background: #E0E7FF; padding: 8px 15px; border-radius: 8px;">
                                    <strong>Uang Transport:</strong> Rp ${data.uang_transport ? data.uang_transport.toLocaleString('id-ID') : '0'}
                                </div>
                            </div>
                        </td>
                    `;
                    
                    const currentRow = document.getElementById(rowId);
                    currentRow.insertAdjacentElement('afterend', newRow);
                    
                    if (btn) {
                        btn.innerHTML = '<i class="fas fa-chevron-up"></i> Sembunyikan';
                    }
                })
                .catch(err => console.error('Gagal mengambil detail:', err));
        }
    }

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

    // ========== MODAL UBAH PASSWORD ==========
    function bukaModalPassword(id, nama) {
        const html = `<div style="padding:20px;font-family:'Poppins',sans-serif;background:#FFF;border-radius:16px"><div style="margin-bottom:20px;padding-bottom:14px;border-bottom:1.5px solid #F3F4F6"><h2 style="font-size:19px;font-weight:700;color:#111827;margin:0">Ubah Password</h2><p style="color:#9CA3AF;font-size:12px;margin:2px 0 0 0">${nama}</p></div><div id="alertErrorPass" style="display:none;background:#FEE2E2;color:#991B1B;padding:12px 15px;border-radius:10px;margin-bottom:15px;"><span id="alertErrorPassText"></span></div><form id="formPassword"><div style="margin-bottom:15px"><label>Password Baru <span style="color:#EF4444">*</span></label><input type="password" id="pass1" required style="width:100%;padding:12px;border-radius:12px;border:1.5px solid #E5E7EB;"></div><div style="margin-bottom:15px"><label>Konfirmasi Password <span style="color:#EF4444">*</span></label><input type="password" id="pass2" required style="width:100%;padding:12px;border-radius:12px;border:1.5px solid #E5E7EB;"></div><div style="display:flex;justify-content:flex-end;gap:20px;margin-top:30px;padding-top:16px;border-top:1.5px solid #F3F4F6"><button type="button" id="btnKeluarPass" style="padding:10px 45px;border:1.5px solid #4D0B87;color:#4D0B87;border-radius:10px;font-weight:600;font-size:16px;background:#FFF;cursor:pointer">Keluar</button><button type="submit" id="btnSimpanPass" style="padding:10px 45px;border:none;background:#4D0B87;color:#fff;border-radius:10px;font-weight:600;font-size:16px;cursor:pointer;">Simpan</button></div></form></div><div id="modalSuksesPass" style="display:none;position:fixed;z-index:99999;left:0;top:0;width:100%;height:100%;background:rgba(0,0,0,0.4);backdrop-filter:blur(3px);align-items:center;justify-content:center"><div style="background:#fff;padding:25px;border-radius:20px;width:320px;text-align:center;"><div style="color:#10B981;font-size:50px;margin-bottom:10px"><i class="fas fa-check-circle"></i></div><h2>Berhasil!</h2><p>Password berhasil diubah.</p><button id="btnOkPass" style="width:100%;padding:10px;border-radius:10px;border:none;background:#10B981;color:#fff;font-weight:600;cursor:pointer">OK</button></div></div>`;
        
        document.getElementById('modalContent').innerHTML = html;
        document.getElementById('modalForm').style.display = 'flex';
        setTimeout(() => {
            document.getElementById('btnKeluarPass').addEventListener('click', () => tutupModalForm());
            document.getElementById('btnOkPass').addEventListener('click', () => { document.getElementById('modalSuksesPass').style.display = 'none'; tutupModalForm(); window.location.reload(); });
            document.getElementById('formPassword').addEventListener('submit', function(e) {
                e.preventDefault();
                const p1 = document.getElementById('pass1').value, p2 = document.getElementById('pass2').value;
                const btn = document.getElementById('btnSimpanPass'), eDiv = document.getElementById('alertErrorPass'), eTxt = document.getElementById('alertErrorPassText');
                if (p1 !== p2) { eTxt.textContent = 'Konfirmasi password tidak cocok!'; eDiv.style.display = 'flex'; setTimeout(() => eDiv.style.display = 'none', 3000); return; }
                if (p1.length < 6) { eTxt.textContent = 'Password minimal 6 karakter!'; eDiv.style.display = 'flex'; setTimeout(() => eDiv.style.display = 'none', 3000); return; }
                btn.disabled = true; btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                fetch("{{ route('superadmin.kelola-tentor.updatePassword', '') }}/" + id, { method: 'PUT', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '' }, body: JSON.stringify({ password: p1, password_confirmation: p2 }) })
                .then(r => r.json()).then(data => { if (data.success) { document.getElementById('modalSuksesPass').style.display = 'flex'; } else { eTxt.textContent = data.message || 'Gagal'; eDiv.style.display = 'flex'; btn.disabled = false; btn.innerHTML = 'Simpan'; } })
                .catch(() => { eTxt.textContent = 'Error'; eDiv.style.display = 'flex'; btn.disabled = false; btn.innerHTML = 'Simpan'; });
            });
        }, 150);
    }

    // ========== MODAL TOGGLE STATUS ==========
    function bukaModalToggle(id, nama, status) {
        document.getElementById('formToggle').action = "{{ route('superadmin.kelola-tentor.toggleStatus', ':id') }}".replace(':id', id);
        if (status == 1) {
            document.getElementById('toggleIcon').innerHTML = '<i class="fas fa-ban" style="color:#EF4444;"></i>';
            document.getElementById('toggleJudul').textContent = 'Nonaktifkan Tentor?';
            document.getElementById('togglePesan').innerHTML = `Apakah Anda yakin ingin <strong>menonaktifkan</strong> tentor <strong>${nama}</strong>?<br><small style="color:#EF4444;">Tentor tidak akan bisa login sampai diaktifkan kembali.</small>`;
            document.getElementById('btnToggle').textContent = 'Ya, Nonaktifkan';
            document.getElementById('btnToggle').style.background = '#EF4444';
        } else {
            document.getElementById('toggleIcon').innerHTML = '<i class="fas fa-check-circle" style="color:#10B981;"></i>';
            document.getElementById('toggleJudul').textContent = 'Aktifkan Tentor?';
            document.getElementById('togglePesan').innerHTML = `Apakah Anda yakin ingin <strong>mengaktifkan</strong> tentor <strong>${nama}</strong>?<br><small style="color:#10B981;">Tentor akan bisa login kembali.</small>`;
            document.getElementById('btnToggle').textContent = 'Ya, Aktifkan';
            document.getElementById('btnToggle').style.background = '#10B981';
        }
        document.getElementById('modalToggle').style.display = 'flex';
    }
    function tutupModalToggle() { document.getElementById('modalToggle').style.display = 'none'; }

    // ========== PAGE SELECT ==========
    document.getElementById('pageSelect').addEventListener('change', function() {
        let url = new URL(window.location.href);
        url.searchParams.set('per_page', this.value);
        url.searchParams.delete('page');
        window.location.href = url.toString();
    });

    // ========== SEARCH ==========
    document.getElementById('searchInput').addEventListener('keyup', function() {
        let v = this.value.toLowerCase();
        document.querySelectorAll('#tableBody tr').forEach(r => { 
            if (r.id && r.id.includes('_detail')) return;
            if (r.cells && r.cells.length >= 3) {
                const shouldShow = r.cells[2]?.innerText.toLowerCase().includes(v);
                r.style.display = shouldShow ? '' : 'none';
                // Sembunyikan juga detail row jika ada
                const detailRow = document.getElementById(r.id + '_detail');
                if (detailRow) {
                    detailRow.style.display = shouldShow ? '' : 'none';
                }
            }
        });
    });

    // ========== MODAL HAPUS ==========
    function bukaModalHapus(id, nama) {
        document.getElementById('formHapus').action = "{{ route('superadmin.kelola-tentor.destroy', '') }}/" + id;
        document.getElementById('pesanHapus').innerHTML = `Apakah Anda <strong>benar-benar yakin</strong> ingin menghapus data tentor <strong>${nama}</strong>?<br><br><small style="color:#EF4444;">⚠️ <strong>PERINGATAN:</strong> Data akan dihapus <strong>secara permanen</strong> dari database. Semua data yang berhubungan dengan tentor ini juga akan <strong>tidak dapat dikembalikan</strong>.</small>`;
        document.getElementById('modalHapus').style.display = 'flex';
    }
    function tutupModalHapus() { document.getElementById('modalHapus').style.display = 'none'; }
</script>
@endsection