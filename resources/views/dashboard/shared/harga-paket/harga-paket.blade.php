@extends('layouts.app')

@section('title', 'Harga Paket')

@section('content')
<div style="width: 100%;">
    
    {{-- HEADER HALAMAN --}}
    <div style="margin-bottom: 25px;">
        <p style="color: #374151; font-size: 13px; margin: 0 0 4px 0;">
            {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}
        </p>
        <h1 style="font-size: 26px; font-weight: 700; color: #111827; margin: 0; letter-spacing: -0.5px; line-height: 1.2;">
            Harga Paket
        </h1>
        <p style="color: #374151; font-size: 14px; margin: 4px 0 0 0;">Manajemen Harga Paket</p>
    </div>

    {{-- ACTIONS BAR --}}
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; gap: 15px;">
        <div style="display: flex; align-items: center; gap: 12px; flex: 1;">
            <div style="position: relative; width: 300px;">
                <i class="fas fa-search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #9CA3AF;"></i>
                <input type="text" id="searchInput" placeholder="Cari ID atau Tingkat..." 
                       style="width: 100%; padding: 10px 15px 10px 45px; border-radius: 12px; border: 1px solid #E5E7EB; outline: none; background: white; font-size: 14px; color: #374151;">
            </div>
        </div>
        
        <a href="{{ route($role . '.harga-paket.create') }}" style="text-decoration: none;">
            <button style="background-color: #4D0B87; color: white; border: none; padding: 12px 25px; border-radius: 12px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 10px; font-size: 14px; transition: 0.3s; box-shadow: 0 4px 6px rgba(77, 11, 135, 0.2);">
                <i class="fas fa-plus"></i> Tambah
            </button>
        </a>
    </div>

    {{-- SESSION SUCCESS --}}
    @if(session('success'))
        <div style="background: #D1FAE5; color: #065F46; padding: 12px; border-radius: 10px; margin-bottom: 20px;">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    {{-- TABEL UTAMA --}}
    <div style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.08); border: 1px solid #F3F4F6;">
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 13px;">
                <thead>
                    <tr style="background: #F3E8FF; color: #111827;">
                        <th style="padding: 15px; font-weight: 700; width: 60px;">No</th>
                        <th style="padding: 15px; font-weight: 700; width: 120px;">ID</th>
                        <th style="padding: 15px; font-weight: 700; width: 150px;">Harga Paket</th>
                        <th style="padding: 15px; font-weight: 700; width: 180px;">Tingkat</th>
                        <th style="padding: 15px; font-weight: 700; width: 150px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tableBody" style="color: #374151;">
                    @forelse($paket as $index => $item)
                    <tr style="border-bottom: 1px solid #F3F4F6; transition: 0.2s;" onmouseover="this.style.background='#F9FAFB'" onmouseout="this.style.background='transparent'">
                        <td style="padding: 15px;">{{ $loop->iteration }}</td>
                        <td style="padding: 15px;">PK{{ str_pad($item->id_paket, 4, '0', STR_PAD_LEFT) }}</td>
                        <td style="padding: 15px;">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                        <td style="padding: 15px;">{{ $item->tingkat }}</td>
                        <td style="padding: 15px; text-align: center;">
                            <div style="display: flex; gap: 8px; justify-content: center;">
                                <a href="{{ route($role . '.harga-paket.edit', $item->id_paket) }}" 
                                   style="background: #5EB37E; color: white; padding: 6px 12px; border-radius: 6px; text-decoration: none; display: inline-flex; align-items: center; gap: 5px; font-size: 12px;">
                                    <i class="far fa-edit"></i> Edit
                                </a>
                                <button type="button" 
                                        onclick="bukaModalHapus('{{ $item->id_paket }}', 'PK{{ str_pad($item->id_paket, 4, '0', STR_PAD_LEFT) }}')" 
                                        style="background: #E35D5D; color: white; padding: 6px 12px; border-radius: 6px; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 5px; font-size: 12px;">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="padding: 40px; text-align: center; color: #9CA3AF;">
                            <i class="fas fa-database" style="font-size: 40px; margin-bottom: 10px; display: block;"></i>
                            Belum ada data harga paket. Silakan tambah data baru.
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
            <select id="pageSelect" style="padding: 8px 12px; border-radius: 10px; border: 1px solid #E5E7EB; color: #374151; font-size: 13px; background: white; outline: none; cursor: pointer;">
                <option value="10">10 baris</option>
                <option value="25">25 baris</option>
                <option value="50">50 baris</option>
            </select>
            <span style="color: #374151; font-size: 13px;">Menampilkan {{ $paket->count() }} data</span>
        </div>

        <div style="display: flex; gap: 5px;">
            <button style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; cursor: pointer;"><i class="fas fa-angle-double-left"></i></button>
            <button style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; cursor: pointer;"><i class="fas fa-angle-left"></i></button>
            <button style="width: 35px; height: 35px; border-radius: 8px; background: #4D0B87; color: white; border: none; font-weight: 600; cursor: pointer;">1</button>
            <button style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; cursor: pointer;"><i class="fas fa-angle-right"></i></button>
        </div>
    </div>

</div>

{{-- MODAL KONFIRMASI HAPUS --}}
<div id="modalHapus" style="display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); backdrop-filter: blur(3px); align-items: center; justify-content: center;">
    <div style="background: white; padding: 25px; border-radius: 20px; width: 320px; text-align: center; box-shadow: 0 15px 30px rgba(0,0,0,0.15); font-family: 'Poppins', sans-serif;">
        <div style="color: #E35D5D; font-size: 40px; margin-bottom: 10px;"><i class="fas fa-trash-alt"></i></div>
        <h2 style="margin: 0; font-size: 18px; color: #111827; font-weight: 700;">Hapus Data?</h2>
        <p style="color: #6B7280; font-size: 13px; margin: 8px 0 20px 0;" id="pesanHapus">Apakah Anda yakin ingin menghapus data paket ini?</p>
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
            if(row.cells && row.cells.length >= 4) {
                let id = row.cells[1]?.innerText.toLowerCase() || '';
                let tingkat = row.cells[3]?.innerText.toLowerCase() || '';
                if(id.includes(searchValue) || tingkat.includes(searchValue)) {
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
        let url = "{{ route($role . '.harga-paket.destroy', ':id') }}";
        url = url.replace(':id', id);
        form.action = url;
        
        let pesan = document.getElementById('pesanHapus');
        pesan.innerHTML = `Apakah Anda yakin ingin menghapus data paket <strong>${nama}</strong>? Data yang dihapus tidak dapat dikembalikan.`;
        
        document.getElementById('modalHapus').style.display = 'flex';
    }

    function tutupModalHapus() {
        document.getElementById('modalHapus').style.display = 'none';
    }
</script>
@endsection