@extends('layouts.app')

@section('title', 'Riwayat Presensi')

@section('content')
<div style="width: 100%;">
    
    {{-- HEADER HALAMAN --}}
    <div style="margin-bottom: 25px;">
        <p style="color: #374151; font-size: 13px; margin: 0 0 4px 0;">
            {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}
        </p>
        <h1 style="font-size: 26px; font-weight: 700; color: #111827; margin: 0; letter-spacing: -0.5px; line-height: 1.2;">
            Riwayat Presensi
        </h1>
        <p style="color: #374151; font-size: 14px; margin: 4px 0 0 0;">Lihat Riwayat Presensi Semua Tentor</p>
    </div>

    {{-- SESSION MESSAGES --}}
    @if(session('success'))
        <div style="background: #D1FAE5; color: #065F46; padding: 12px; border-radius: 10px; margin-bottom: 20px;">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div style="background: #FEE2E2; color: #EF4444; padding: 12px; border-radius: 10px; margin-bottom: 20px;">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        </div>
    @endif

    {{-- FORM FILTER --}}
    <form method="GET" action="{{ route($role . '.kelola-presensi') }}" id="filterForm">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; gap: 15px;">
            <div style="display: flex; align-items: center; gap: 12px; flex: 1;">
                {{-- Search Bar --}}
                <div style="position: relative; width: 300px;">
                    <i class="fas fa-search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #9CA3AF;"></i>
                    <input type="text" name="search" placeholder="Cari Nama Tentor..." value="{{ $search ?? '' }}"
                           style="width: 100%; padding: 10px 15px 10px 45px; border-radius: 12px; border: 1px solid #E5E7EB; outline: none; background: white; font-size: 14px; color: #374151;">
                </div>

                {{-- Filter Bulan --}}
                <select name="bulan" style="padding: 10px 12px; border-radius: 12px; border: 1px solid #E5E7EB; color: #374151; font-size: 13px; min-width: 140px; background: white; outline: none; cursor: pointer;" onchange="this.form.submit()">
                    <option value="">--- Pilih Bulan ---</option>
                    <option value="1" {{ ($bulan ?? '') == '1' ? 'selected' : '' }}>Januari</option>
                    <option value="2" {{ ($bulan ?? '') == '2' ? 'selected' : '' }}>Februari</option>
                    <option value="3" {{ ($bulan ?? '') == '3' ? 'selected' : '' }}>Maret</option>
                    <option value="4" {{ ($bulan ?? '') == '4' ? 'selected' : '' }}>April</option>
                    <option value="5" {{ ($bulan ?? '') == '5' ? 'selected' : '' }}>Mei</option>
                    <option value="6" {{ ($bulan ?? '') == '6' ? 'selected' : '' }}>Juni</option>
                    <option value="7" {{ ($bulan ?? '') == '7' ? 'selected' : '' }}>Juli</option>
                    <option value="8" {{ ($bulan ?? '') == '8' ? 'selected' : '' }}>Agustus</option>
                    <option value="9" {{ ($bulan ?? '') == '9' ? 'selected' : '' }}>September</option>
                    <option value="10" {{ ($bulan ?? '') == '10' ? 'selected' : '' }}>Oktober</option>
                    <option value="11" {{ ($bulan ?? '') == '11' ? 'selected' : '' }}>November</option>
                    <option value="12" {{ ($bulan ?? '') == '12' ? 'selected' : '' }}>Desember</option>
                </select>

                {{-- Filter Tahun --}}
                <select name="tahun" style="padding: 10px 12px; border-radius: 12px; border: 1px solid #E5E7EB; color: #374151; font-size: 13px; min-width: 100px; background: white; outline: none; cursor: pointer;" onchange="this.form.submit()">
                    <option value="">--- Tahun ---</option>
                    @php $currentYear = date('Y'); @endphp
                    @for($year = $currentYear - 2; $year <= $currentYear + 1; $year++)
                        <option value="{{ $year }}" {{ ($tahun ?? '') == $year ? 'selected' : '' }}>{{ $year }}</option>
                    @endfor
                </select>
                
                {{-- Reset Filter --}}
                @if(($bulan ?? '') || ($tahun ?? '') || ($search ?? ''))
                    <a href="{{ route($role . '.kelola-presensi') }}" style="padding: 10px 15px; border-radius: 12px; background: #F3F4F6; color: #374151; text-decoration: none; font-size: 13px;">Reset</a>
                @endif
            </div>
        </div>
    </form>

    {{-- TABEL UTAMA --}}
    <div style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.08); border: 1px solid #F3F4F6;">
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 13px;">
                <thead>
                    <tr style="background: #F3E8FF; color: #111827;">
                        <th style="padding: 15px; font-weight: 700; width: 50px;">No</th>
                        <th style="padding: 15px; font-weight: 700;">Nama Tentor</th>
                        <th style="padding: 15px; font-weight: 700;">Tanggal</th>
                        <th style="padding: 15px; font-weight: 700;">Jam Masuk</th>
                        <th style="padding: 15px; font-weight: 700;">Jam Keluar</th>
                        <th style="padding: 15px; font-weight: 700;">Kelas</th>
                        <th style="padding: 15px; font-weight: 700; text-align: center;">Status</th>
                        <th style="padding: 15px; font-weight: 700;">Honor</th>
                        <th style="padding: 15px; font-weight: 700;">Makan</th>
                        <th style="padding: 15px; font-weight: 700;">Transport</th>
                        <th style="padding: 15px; font-weight: 700; text-align: center;">Bukti</th>
                        <th style="padding: 15px; font-weight: 700; text-align: center;">Verifikasi</th>
                        <th style="padding: 15px; font-weight: 700; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tableBody" style="color: #374151;">
                    @forelse($presensi as $index => $item)
                    @php
                        $statusText = $item->status_murid == 'hadir' ? 'Hadir' : 'Tidak Hadir';
                        $statusClass = $item->status_murid == 'hadir' 
                            ? 'background: #E1F7E3; color: #0E7490;' 
                            : 'background: #FEE2E2; color: #EF4444;';
                        $jamMasuk = $item->jam_masuk ? \Carbon\Carbon::parse($item->jam_masuk)->format('H:i') : '-';
                        $jamKeluar = $item->jam_keluar ? \Carbon\Carbon::parse($item->jam_keluar)->format('H:i') : '-';
                        $honor = $item->total_honor ? 'Rp ' . number_format($item->total_honor, 0, ',', '.') : 'Rp 0';
                        $uangMakan = $item->uang_makan ? 'Rp ' . number_format($item->uang_makan, 0, ',', '.') : 'Rp 0';
                        $transport = $item->transport ? 'Rp ' . number_format($item->transport, 0, ',', '.') : 'Rp 0';
                    @endphp
                    <tr style="border-bottom: 1px solid #F3F4F6; transition: 0.2s;" onmouseover="this.style.background='#F9FAFB'" onmouseout="this.style.background='transparent'">
                        <td style="padding: 15px;">{{ $presensi->firstItem() + $index }}</td>
                        <td style="padding: 15px;">{{ $item->tentor->nama_lengkap_tentor ?? '-' }}</td>
                        <td style="padding: 15px;">{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}</td>
                        <td style="padding: 15px;">{{ $jamMasuk }}</td>
                        <td style="padding: 15px;">{{ $jamKeluar }}</td>
                        <td style="padding: 15px;">{{ $item->kelas ?? '-' }}</td>
                        <td style="padding: 15px; text-align: center;">
                            <span style="padding: 5px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; {{ $statusClass }}">
                                {{ $statusText }}
                            </span>
                        </td>
                        <td style="padding: 15px;">{{ $honor }}</td>
                        <td style="padding: 15px;">{{ $uangMakan }}</td>
                        <td style="padding: 15px;">{{ $transport }}</td>
                        <td style="padding: 15px; text-align: center;">
                            @if($item->bukti_foto)
                                <a href="{{ route($role . '.kelola-presensi.download', $item->id_presensi) }}" 
                                   style="background: #F3E8FF; border: none; color: #4D0B87; width: 32px; height: 32px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; text-decoration: none;">
                                    <i class="fas fa-file-download"></i>
                                </a>
                            @else
                                <span style="color: #9CA3AF;">-</span>
                            @endif
                        </td>
                        <td style="padding: 15px; text-align: center;">
                            @if($role == 'superadmin' || $role == 'admin')
                                <form method="POST" action="{{ route($role . '.kelola-presensi.' . ($item->verifikasi_kehadiran ? 'unverify' : 'verify'), $item->id_presensi) }}" style="display: inline;">
                                    @csrf
                                    <button type="submit" style="background: none; border: none; cursor: pointer;">
                                        <input type="checkbox" {{ $item->verifikasi_kehadiran ? 'checked' : '' }} 
                                               style="accent-color: #4D0B87; width: 18px; height: 18px; cursor: pointer; pointer-events: none;">
                                    </button>
                                </form>
                            @else
                                <input type="checkbox" {{ $item->verifikasi_kehadiran ? 'checked' : '' }} 
                                       style="accent-color: #4D0B87; width: 18px; height: 18px;" disabled>
                            @endif
                        </td>
                        <td style="padding: 15px; text-align: center;">
                            @if($role == 'superadmin')
                                <button type="button" 
                                        onclick="bukaModalHapus({{ $item->id_presensi }}, '{{ addslashes($item->tentor->nama_lengkap_tentor ?? 'Tentor') }}', '{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}')" 
                                        style="background: #E35D5D; color: white; padding: 6px 12px; border-radius: 6px; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 5px; font-size: 12px;">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            @else
                                <span style="color: #9CA3AF; font-size: 11px;">Read only</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="13" style="padding: 40px; text-align: center; color: #9CA3AF;">
                            <i class="fas fa-calendar-alt" style="font-size: 40px; margin-bottom: 10px; display: block;"></i>
                            Belum ada data presensi
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    {{-- PAGINATION & SHOW ENTRIES --}}
    @if($presensi->count() > 0)
    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px; padding: 0 5px;">
        <div style="display: flex; align-items: center; gap: 10px;">
            <span style="color: #374151; font-size: 13px;">Menampilkan {{ $presensi->firstItem() }} - {{ $presensi->lastItem() }} dari {{ $presensi->total() }} data</span>
        </div>

        <div>
            {{ $presensi->appends(request()->query())->links('pagination::simple-bootstrap-4') }}
        </div>
    </div>
    @endif

</div>

{{-- MODAL KONFIRMASI HAPUS (SESUAI DESAIN HARGA PAKET) --}}
<div id="modalHapus" style="display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); backdrop-filter: blur(3px); align-items: center; justify-content: center;">
    <div style="background: white; padding: 25px; border-radius: 20px; width: 320px; text-align: center; box-shadow: 0 15px 30px rgba(0,0,0,0.15); font-family: 'Poppins', sans-serif;">
        <div style="color: #E35D5D; font-size: 40px; margin-bottom: 10px;"><i class="fas fa-trash-alt"></i></div>
        <h2 style="margin: 0; font-size: 18px; color: #111827; font-weight: 700;">Hapus Data?</h2>
        <p style="color: #6B7280; font-size: 13px; margin: 8px 0 20px 0;" id="pesanHapus">Apakah Anda yakin ingin menghapus data presensi ini?</p>
        <div style="display: flex; gap: 10px; justify-content: center;">
            <button onclick="tutupModalHapus()" style="flex: 1; padding: 10px; border-radius: 10px; border: 1px solid #E5E7EB; background: white; font-weight: 600; font-size: 13px; cursor: pointer;">Batal</button>
            <form id="formHapus" method="POST" style="flex: 1;">
                @csrf
                @method('DELETE')
                <button type="submit" style="width: 100%; padding: 10px; border-radius: 10px; border: none; background: #E35D5D; color: white; font-weight: 600; font-size: 13px; cursor: pointer;">Ya, Hapus</button>
            </form>
        </div>
    </div>
</div>

<script>
    // Submit ketika search menekan enter
    document.querySelector('input[name="search"]')?.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            document.getElementById('filterForm').submit();
        }
    });

    // Modal Hapus (sama persis dengan harga-paket)
    function bukaModalHapus(id, nama, tanggal) {
        let form = document.getElementById('formHapus');
        let url = "{{ route('superadmin.kelola-presensi.destroy', ':id') }}";
        url = url.replace(':id', id);
        form.action = url;
        
        let pesan = document.getElementById('pesanHapus');
        pesan.innerHTML = `Apakah Anda yakin ingin menghapus data presensi <strong>${nama}</strong><br>tanggal <strong>${tanggal}</strong>? Data yang dihapus tidak dapat dikembalikan.`;
        
        document.getElementById('modalHapus').style.display = 'flex';
    }

    function tutupModalHapus() {
        document.getElementById('modalHapus').style.display = 'none';
    }

    // Live search (filter tabel)
    document.getElementById('searchInput')?.addEventListener('keyup', function() {
        let searchValue = this.value.toLowerCase();
        let rows = document.querySelectorAll('#tableBody tr');
        
        rows.forEach(row => {
            if(row.cells && row.cells.length >= 2) {
                let nama = row.cells[1]?.innerText.toLowerCase() || '';
                if(nama.includes(searchValue)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            }
        });
    });
</script>
@endsection