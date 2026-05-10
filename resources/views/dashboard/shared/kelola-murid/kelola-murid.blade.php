@extends('layouts.app')

@section('title', 'Kelola Murid')

@section('content')
<div style="width: 100%;">
    
    {{-- HEADER HALAMAN --}}
    <div style="margin-bottom: 25px;">
        <p style="color: #374151; font-size: 13px; margin: 0 0 4px 0;">
            {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}
        </p>
        <h1 style="font-size: 26px; font-weight: 700; color: #111827; margin: 0; letter-spacing: -0.5px; line-height: 1.2;">
            Kelola Murid
        </h1>
        <p style="color: #374151; font-size: 14px; margin: 4px 0 0 0;">Manajemen Data Murid</p>
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
                <input type="text" id="searchInput" placeholder="Cari Nama Murid..." 
                       style="width: 100%; padding: 10px 15px 10px 45px; border-radius: 12px; border: 1px solid #E5E7EB; outline: none; background: white; font-size: 14px; color: #374151;">
            </div>

            <select id="filterPaket" style="padding: 10px 12px; border-radius: 12px; border: 1px solid #E5E7EB; color: #374151; font-size: 13px; min-width: 160px; background: white; outline: none; cursor: pointer;">
                <option value="">Semua Paket</option>
                @foreach($paketList as $paket)
                    <option value="{{ $paket }}">{{ $paket }}</option>
                @endforeach
            </select>

            <select id="filterTahun" style="padding: 10px 12px; border-radius: 12px; border: 1px solid #E5E7EB; color: #374151; font-size: 13px; min-width: 160px; background: white; outline: none; cursor: pointer;">
            <option value="">Semua Periode</option>
            @foreach($tahunPeriodeList as $tahunPeriode)
                <option value="{{ $tahunPeriode }}" {{ $tahunPeriode == ($periodeAktif->tahun_periode ?? '') ? 'selected' : '' }}>{{ $tahunPeriode }}</option>
            @endforeach
        </select>
        </div>
        
        <button onclick="bukaModalCreate()" style="background-color: #4D0B87; color: white; border: none; padding: 12px 25px; border-radius: 12px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 10px; font-size: 14px; transition: 0.3s; box-shadow: 0 4px 6px rgba(77, 11, 135, 0.2);">
            <i class="fas fa-plus"></i> Tambah
        </button>
    </div>

    {{-- TABEL MURID --}}
    <div style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.08); border: 1px solid #F3F4F6;">
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 13px; white-space: nowrap;">
                <thead>
                    <tr style="background: #F3E8FF; color: #111827;">
                        <th style="padding: 15px; font-weight: 700; width: 50px;">No</th>
                        <th style="padding: 15px; font-weight: 700;">Nama Lengkap</th>
                        <th style="padding: 15px; font-weight: 700;">Kelas</th>
                        <th style="padding: 15px; font-weight: 700;">Asal Sekolah</th>
                        <th style="padding: 15px; font-weight: 700;">Alamat</th>
                        <th style="padding: 15px; font-weight: 700;">No HP Siswa</th>
                        <th style="padding: 15px; font-weight: 700;">Nama Orang Tua</th>
                        <th style="padding: 15px; font-weight: 700;">No HP Ortu</th>
                        <th style="padding: 15px; font-weight: 700;">Paket</th>
                        <th style="padding: 15px; font-weight: 700; text-align: center;">Tahun Periode</th>
                        <th style="padding: 15px; font-weight: 700; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tableBody" style="color: #374151;">
                    @forelse($murids as $index => $m)
                    @php
                        $sudahDiPeriodeAktif = false;
                        if($periodeAktif) {
                            $sudahDiPeriodeAktif = $m->transaksiPaket()
                                ->where('id_periode', $periodeAktif->id_periode)
                                ->exists();
                        }
                    @endphp
                    <tr style="border-bottom: 1px solid #F3F4F6; transition: 0.2s;" onmouseover="this.style.background='#F9FAFB'" onmouseout="this.style.background='transparent'">
                        <td style="padding: 15px;">{{ $murids->firstItem() + $index }}</td>
                        <td style="padding: 15px; font-weight: 500;">{{ $m->nama_lengkap }}</td>
                        <td style="padding: 15px;">
                            @php
                                $kelasTerbaru = $m->transaksiKelas()->orderBy('created_at', 'desc')->first();
                            @endphp
                            {{ $kelasTerbaru && $kelasTerbaru->kelas ? $kelasTerbaru->kelas->jenjang . ' - ' . $kelasTerbaru->kelas->nama_kelas : '-' }}
                        </td>
                        <td style="padding: 15px;">{{ $m->asal_sekolah ?? '-' }}</td>
                        <td style="padding: 15px; max-width: 150px; overflow: hidden; text-overflow: ellipsis;" title="{{ $m->alamat }}">{{ $m->alamat ?? '-' }}</td>
                        <td style="padding: 15px;">{{ $m->no_hp ?? '-' }}</td>
                        <td style="padding: 15px;">{{ $m->nama_orang_tua ?? '-' }}</td>
                        <td style="padding: 15px;">{{ $m->no_hp_orang_tua ?? '-' }}</td>
                        <td style="padding: 15px;">
                            @php
                                $paketTerbaru = $m->transaksiPaket()->orderBy('id_paket_murid', 'desc')->first();
                            @endphp
                            {{ $paketTerbaru && $paketTerbaru->paket ? $paketTerbaru->paket->tingkat : '-' }}
                        </td>
                        <td style="padding: 15px; text-align: center;">{{ $m->tahun_periode }}</td>
                        <td style="padding: 15px; text-align: center;">
                            <div style="display: flex; gap: 3px; justify-content: center; flex-wrap: nowrap;">
                                <button onclick="bukaModalEdit({{ $m->id_murid }})" 
                                   style="background: #5EB37E; color: white; padding: 4px 7px; border-radius: 5px; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 4px; font-size: 10px; white-space: nowrap;">
                                    <i class="far fa-edit"></i> Edit
                                </button>
                                
                                @if($periodeAktif && !$sudahDiPeriodeAktif)
                                <button onclick="bukaModalLanjutPeriode({{ $m->id_murid }}, '{{ $m->nama_lengkap }}')" 
                                        style="background: #F59E0B; color: white; padding: 4px 7px; border-radius: 5px; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 4px; font-size: 10px; white-space: nowrap;">
                                    <i class="fas fa-arrow-right"></i> Lanjut
                                </button>
                                @endif
                                
                                <button type="button" onclick="bukaModalHapus('{{ $m->id_murid }}', '{{ $m->nama_lengkap }}')" 
                                        style="background: #E35D5D; color: white; padding: 4px 7px; border-radius: 5px; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 4px; font-size: 10px; white-space: nowrap;">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="11" style="padding: 40px; text-align: center; color: #9CA3AF;">
                            <i class="fas fa-database" style="font-size: 40px; margin-bottom: 10px; display: block;"></i>
                            Belum ada data murid.
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
            <span style="color: #374151; font-size: 13px;">Menampilkan {{ $murids->total() ?? 0 }} data</span>
        </div>
        <div style="display: flex; gap: 5px;">
            @if ($murids->onFirstPage())
                <button disabled style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: #F3F4F6; color: #9CA3AF; cursor: not-allowed;"><i class="fas fa-angle-double-left"></i></button>
                <button disabled style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: #F3F4F6; color: #9CA3AF; cursor: not-allowed;"><i class="fas fa-angle-left"></i></button>
            @else
                <a href="{{ $murids->url(1) }}&per_page={{ request('per_page', 10) }}" style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; display: flex; align-items: center; justify-content: center; text-decoration: none;"><i class="fas fa-angle-double-left"></i></a>
                <a href="{{ $murids->previousPageUrl() }}&per_page={{ request('per_page', 10) }}" style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; display: flex; align-items: center; justify-content: center; text-decoration: none;"><i class="fas fa-angle-left"></i></a>
            @endif

            @php $start = max(1, $murids->currentPage() - 2); $end = min($murids->lastPage(), $murids->currentPage() + 2); @endphp
            @for ($i = $start; $i <= $end; $i++)
                @if ($i == $murids->currentPage())
                    <button style="width: 35px; height: 35px; border-radius: 8px; background: #4D0B87; color: white; border: none; font-weight: 600;">{{ $i }}</button>
                @else
                    <a href="{{ $murids->url($i) }}&per_page={{ request('per_page', 10) }}" style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; display: flex; align-items: center; justify-content: center; text-decoration: none;">{{ $i }}</a>
                @endif
            @endfor

            @if ($murids->hasMorePages())
                <a href="{{ $murids->nextPageUrl() }}&per_page={{ request('per_page', 10) }}" style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; display: flex; align-items: center; justify-content: center; text-decoration: none;"><i class="fas fa-angle-right"></i></a>
            @else
                <button disabled style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: #F3F4F6; color: #9CA3AF; cursor: not-allowed;"><i class="fas fa-angle-right"></i></button>
            @endif
        </div>
    </div>

</div>

{{-- MODAL FORM (Create/Edit) --}}
<div id="modalForm" style="display: none; position: fixed; z-index: 9998; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); backdrop-filter: blur(3px); align-items: center; justify-content: center; overflow-y: auto;">
    <div style="background: white; border-radius: 20px; width: 700px; max-width: 95%; max-height: 90vh; overflow-y: auto; box-shadow: 0 15px 30px rgba(0,0,0,0.15);" id="modalContent">
    </div>
</div>

{{-- MODAL KONFIRMASI HAPUS --}}
<div id="modalHapus" style="display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); backdrop-filter: blur(3px); align-items: center; justify-content: center;">
    <div style="background: white; padding: 25px; border-radius: 20px; width: 380px; text-align: center; box-shadow: 0 15px 30px rgba(0,0,0,0.15); font-family: 'Poppins', sans-serif;">
        <div style="color: #E35D5D; font-size: 40px; margin-bottom: 10px;"><i class="fas fa-trash-alt"></i></div>
        <h2 style="margin: 0; font-size: 18px; color: #111827; font-weight: 700;">Hapus Data?</h2>
        <p style="color: #6B7280; font-size: 12px; margin: 8px 0 20px 0; line-height: 1.5;" id="pesanHapus">Apakah Anda yakin ingin menghapus data murid ini?</p>
        <div style="display: flex; gap: 10px; justify-content: center;">
            <button onclick="tutupModalHapus()" style="flex: 1; padding: 10px; border-radius: 10px; border: 1px solid #E5E7EB; background: white; font-weight: 600; font-size: 13px; cursor: pointer;">Batal</button>
            <form id="formHapus" method="POST" style="flex: 1;">
                @csrf @method('DELETE')
                <button type="submit" style="width: 100%; padding: 10px; border-radius: 10px; border: none; background: #E35D5D; color: white; font-weight: 600; font-size: 13px; cursor: pointer;">Ya, Hapus</button>
            </form>
        </div>
    </div>
</div>

{{-- MODAL LANJUT PERIODE --}}
<div id="modalLanjutPeriode" style="display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); backdrop-filter: blur(3px); align-items: center; justify-content: center; overflow-y: auto;">
    <div style="background: white; border-radius: 20px; width: 500px; max-width: 95%; max-height: 90vh; overflow-y: auto; box-shadow: 0 15px 30px rgba(0,0,0,0.15);" id="modalLanjutContent">
    </div>
</div>

<script>
    // =============================================
    // BUKA MODAL CREATE
    // =============================================
    function bukaModalCreate() {
        fetch("{{ route($role . '.murid.create') }}")
            .then(r => r.text())
            .then(html => {
                document.getElementById('modalContent').innerHTML = html;
                document.getElementById('modalForm').style.display = 'flex';
                setTimeout(() => pasangEventHandler(), 150);
            });
    }

    // =============================================
    // BUKA MODAL EDIT
    // =============================================
    function bukaModalEdit(id) {
        fetch("{{ route($role . '.murid.edit', '') }}/" + id)
            .then(r => r.text())
            .then(html => {
                document.getElementById('modalContent').innerHTML = html;
                document.getElementById('modalForm').style.display = 'flex';
                setTimeout(() => pasangEventHandler(), 150);
            });
    }

    // =============================================
    // TUTUP MODAL FORM
    // =============================================
    function tutupModalForm() {
        document.getElementById('modalForm').style.display = 'none';
        document.getElementById('modalContent').innerHTML = '';
    }

    // =============================================
    // PASANG EVENT HANDLER UNTUK FORM DI DALAM MODAL
    // =============================================
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

        // SELECT KELAS & PAKET
        const kelasSelect = mc.querySelector('#id_kelas');
        const paketSelect = mc.querySelector('#id_paket');
        const hargaPaket = mc.querySelector('#hargaPaket');
        if (kelasSelect && paketSelect) {
            kelasSelect.addEventListener('change', function() {
                const jenjang = this.options[this.selectedIndex]?.getAttribute('data-jenjang');
                if (jenjang) { for (let i = 0; i < paketSelect.options.length; i++) { if (paketSelect.options[i].getAttribute('data-tingkat') === jenjang) { paketSelect.value = paketSelect.options[i].value; paketSelect.dispatchEvent(new Event('change')); break; } } }
            });
            paketSelect.addEventListener('change', function() {
                const harga = this.options[this.selectedIndex]?.getAttribute('data-harga');
                if (harga && hargaPaket) hargaPaket.innerHTML = 'Rp ' + new Intl.NumberFormat('id-ID').format(harga);
            });
            if (paketSelect.value) paketSelect.dispatchEvent(new Event('change'));
        }
    }

    // =============================================
    // SEARCH & FILTER
    // =============================================
    document.getElementById('searchInput').addEventListener('keyup', function() {
        let val = this.value.toLowerCase();
        document.querySelectorAll('#tableBody tr').forEach(row => {
            if (row.cells && row.cells.length >= 2) {
                row.style.display = row.cells[1]?.innerText.toLowerCase().includes(val) ? '' : 'none';
            }
        });
    });

    document.getElementById('filterPaket').addEventListener('change', function() {
        let val = this.value;
        document.querySelectorAll('#tableBody tr').forEach(row => {
            if (row.cells && row.cells.length >= 9) {
                row.style.display = (val === '' || row.cells[8]?.innerText.trim() === val) ? '' : 'none';
            }
        });
    });

    document.getElementById('filterTahun').addEventListener('change', function() {
        let val = this.value;
        document.querySelectorAll('#tableBody tr').forEach(row => {
            if (row.cells && row.cells.length >= 10) {
                row.style.display = (val === '' || row.cells[9]?.innerText.trim() === val) ? '' : 'none';
            }
        });
    });

    // =============================================
    // MODAL HAPUS
    // =============================================
    function bukaModalHapus(id, nama) {
        document.getElementById('formHapus').action = "{{ route($role . '.murid.destroy', '') }}/" + id;
        document.getElementById('pesanHapus').innerHTML = `Apakah Anda <strong>benar-benar yakin</strong> ingin menghapus data murid <strong>${nama}</strong>?<br><br><small style="color:#EF4444;">⚠️ <strong>PERINGATAN:</strong> Data akan dihapus <strong>secara permanen</strong> dari database.</small>`;
        document.getElementById('modalHapus').style.display = 'flex';
    }

    function tutupModalHapus() {
        document.getElementById('modalHapus').style.display = 'none';
    }

    // =============================================
    // MODAL LANJUT PERIODE
    // =============================================
    function bukaModalLanjutPeriode(id, nama) {
        fetch("{{ route($role . '.murid.lanjut-periode-form', '') }}/" + id)
            .then(r => r.text())
            .then(html => {
                document.getElementById('modalLanjutContent').innerHTML = html;
                document.getElementById('modalLanjutPeriode').style.display = 'flex';
                setTimeout(() => pasangEventLanjutPeriode(), 150);
            });
    }

    function tutupModalLanjutPeriode() {
        document.getElementById('modalLanjutPeriode').style.display = 'none';
        document.getElementById('modalLanjutContent').innerHTML = '';
    }

    function pasangEventLanjutPeriode() {
        const formLanjut = document.querySelector('#formLanjutPeriode');
        if (formLanjut) {
            formLanjut.addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(formLanjut);
                const btnLanjut = document.getElementById('btnLanjut');
                if (btnLanjut) { btnLanjut.disabled = true; btnLanjut.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...'; }
                
                fetch(formLanjut.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                        'Accept': 'application/json'
                    }
                })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        tutupModalLanjutPeriode();
                        window.location.reload();
                    } else {
                        alert(data.message || 'Gagal memproses');
                        if (btnLanjut) { btnLanjut.disabled = false; btnLanjut.innerHTML = 'Lanjutkan'; }
                    }
                })
                .catch(err => {
                    alert('Terjadi kesalahan: ' + err.message);
                    if (btnLanjut) { btnLanjut.disabled = false; btnLanjut.innerHTML = 'Lanjutkan'; }
                });
            });
        }
    }

    // =============================================
    // PAGE SELECT (PAGINATION)
    // =============================================
    document.getElementById('pageSelect').addEventListener('change', function() {
        let url = new URL(window.location.href);
        url.searchParams.set('per_page', this.value);
        url.searchParams.delete('page');
        window.location.href = url.toString();
    });
</script>
@endsection