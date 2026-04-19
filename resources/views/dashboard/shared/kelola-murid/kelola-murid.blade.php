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

            {{-- FILTER PAKET - AMBIL DARI tr_paket --}}
            <select id="filterPaket" style="padding: 10px 12px; border-radius: 12px; border: 1px solid #E5E7EB; color: #374151; font-size: 13px; min-width: 160px; background: white; outline: none; cursor: pointer;">
                <option value="">--- Pilihan Paket ---</option>
                @php
                    // Ambil paket unik dari data yang ditampilkan
                    $paketList = [];
                    foreach($murids as $m) {
                        $paket = $m->transaksiPaket()->orderBy('created_at', 'desc')->first();
                        if($paket && $paket->paket) {
                            $paketList[$paket->paket->tingkat] = $paket->paket->tingkat;
                        }
                    }
                    sort($paketList);
                @endphp
                @foreach($paketList as $paket)
                    <option value="{{ $paket }}">{{ $paket }}</option>
                @endforeach
            </select>

            <select id="filterTahun" style="padding: 10px 12px; border-radius: 12px; border: 1px solid #E5E7EB; color: #374151; font-size: 13px; min-width: 160px; background: white; outline: none; cursor: pointer;">
                <option value="">--- Tahun Masuk ---</option>
                @php
                    $tahunList = $murids->pluck('tahun_masuk')->unique()->sort()->filter();
                @endphp
                @foreach($tahunList as $tahun)
                    <option value="{{ $tahun }}">{{ $tahun }}</option>
                @endforeach
            </select>
        </div>
        
        <a href="{{ route($role . '.murid.create') }}" style="text-decoration: none;">
            <button style="background-color: #4D0B87; color: white; border: none; padding: 12px 25px; border-radius: 12px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 10px; font-size: 14px; transition: 0.3s; box-shadow: 0 4px 6px rgba(77, 11, 135, 0.2);">
                <i class="fas fa-plus"></i> Tambah
            </button>
        </a>
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
                        <th style="padding: 15px; font-weight: 700; text-align: center;">Tahun Masuk</th>
                        <th style="padding: 15px; font-weight: 700; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tableBody" style="color: #374151;">
                    @forelse($murids as $index => $m)
                    <tr style="border-bottom: 1px solid #F3F4F6; transition: 0.2s;" onmouseover="this.style.background='#F9FAFB'" onmouseout="this.style.background='transparent'">
                        <td style="padding: 15px;">{{ $loop->iteration }}</td>
                        <td style="padding: 15px; font-weight: 500;">{{ $m->nama_lengkap }}</td>
                        <td style="padding: 15px;">
                            @php
                                // Ambil kelas TERBARU berdasarkan created_at
                                $kelasTerbaru = $m->transaksiKelas()
                                    ->orderBy('created_at', 'desc')
                                    ->first();
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
                                // Ambil paket TERBARU berdasarkan created_at
                                $paketTerbaru = $m->transaksiPaket()
                                    ->orderBy('created_at', 'desc')
                                    ->first();
                            @endphp
                            {{ $paketTerbaru && $paketTerbaru->paket ? $paketTerbaru->paket->tingkat : '-' }}
                        </td>
                        <td style="padding: 15px; text-align: center;">{{ $m->tahun_masuk ?? date('Y') }}</td>
                        <td style="padding: 15px; text-align: center;">
                            <div style="display: flex; gap: 8px; justify-content: center;">
                                <a href="{{ route($role . '.murid.edit', $m->id_murid) }}" 
                                   style="background: #5EB37E; color: white; padding: 6px 12px; border-radius: 6px; text-decoration: none; display: inline-flex; align-items: center; gap: 5px; font-size: 12px; white-space: nowrap;">
                                    <i class="far fa-edit"></i> Edit
                                </a>
                                <button type="button" 
                                        onclick="bukaModalHapus('{{ $m->id_murid }}', '{{ $m->nama_lengkap }}')" 
                                        style="background: #E35D5D; color: white; padding: 6px 12px; border-radius: 6px; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 5px; font-size: 12px; white-space: nowrap;">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="11" style="padding: 40px; text-align: center; color: #9CA3AF;">
                            <i class="fas fa-database" style="font-size: 40px; margin-bottom: 10px; display: block;"></i>
                            Belum ada data murid. Silakan tambah data baru.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    {{-- PAGINATION & SHOW ENTRIES --}}
    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px; padding: 0 5px;">
        <div style="display: flex; align-items: center; gap: 10px;">
            <span style="color: #374151; font-size: 13px;">Total: {{ $murids->count() }} murid</span>
        </div>
    </div>

</div>

{{-- MODAL KONFIRMASI HAPUS --}}
<div id="modalHapus" style="display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); backdrop-filter: blur(3px); align-items: center; justify-content: center;">
    <div style="background: white; padding: 25px; border-radius: 20px; width: 320px; text-align: center; box-shadow: 0 15px 30px rgba(0,0,0,0.15); font-family: 'Poppins', sans-serif;">
        <div style="color: #E35D5D; font-size: 40px; margin-bottom: 10px;"><i class="fas fa-trash-alt"></i></div>
        <h2 style="margin: 0; font-size: 18px; color: #111827; font-weight: 700;">Hapus Data?</h2>
        <p style="color: #6B7280; font-size: 13px; margin: 8px 0 20px 0;" id="pesanHapus">Apakah Anda yakin ingin menghapus data murid ini?</p>
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
    // Live search
    document.getElementById('searchInput').addEventListener('keyup', function() {
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

    // Filter Paket
    document.getElementById('filterPaket').addEventListener('change', function() {
        let filterValue = this.value;
        let rows = document.querySelectorAll('#tableBody tr');
        
        rows.forEach(row => {
            if(row.cells && row.cells.length >= 9) {
                let paket = row.cells[8]?.innerText.trim() || '';
                if(filterValue === '' || paket === filterValue) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            }
        });
    });

    // Filter Tahun
    document.getElementById('filterTahun').addEventListener('change', function() {
        let filterValue = this.value;
        let rows = document.querySelectorAll('#tableBody tr');
        
        rows.forEach(row => {
            if(row.cells && row.cells.length >= 10) {
                let tahun = row.cells[9]?.innerText.trim() || '';
                if(filterValue === '' || tahun === filterValue) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            }
        });
    });

    // Modal Hapus
    function bukaModalHapus(id, nama) {
        let form = document.getElementById('formHapus');
        let url = "{{ route($role . '.murid.destroy', ':id') }}";
        url = url.replace(':id', id);
        form.action = url;
        
        let pesan = document.getElementById('pesanHapus');
        pesan.innerHTML = `Apakah Anda yakin ingin menghapus data murid <strong>${nama}</strong>? Data yang dihapus tidak dapat dikembalikan.`;
        
        document.getElementById('modalHapus').style.display = 'flex';
    }

    function tutupModalHapus() {
        document.getElementById('modalHapus').style.display = 'none';
    }
</script>
@endsection