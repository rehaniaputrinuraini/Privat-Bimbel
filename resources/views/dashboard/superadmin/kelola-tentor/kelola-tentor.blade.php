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

    {{-- SESSION SUCCESS --}}
    @if(session('success'))
        <div style="background: #D1FAE5; color: #065F46; padding: 12px; border-radius: 10px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    {{-- ACTIONS BAR (Tanpa Filter Status) --}}
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
        <div style="position: relative; width: 300px;">
            <i class="fas fa-search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #9CA3AF;"></i>
            <input type="text" id="searchInput" placeholder="Cari Nama atau ID Tentor..." 
                   style="width: 100%; padding: 10px 15px 10px 45px; border-radius: 12px; border: 1px solid #E5E7EB; outline: none;">
        </div>
        
        <a href="{{ route('superadmin.kelola-tentor.create') }}">
            <button type="button" style="background-color: #4D0B87; color: white; border: none; padding: 12px 25px; border-radius: 12px; font-weight: 600; cursor: pointer;">
                <i class="fas fa-plus"></i> Tambah
            </button>
        </a>
    </div>

    {{-- TABEL LENGKAP --}}
    <div style="background: white; border-radius: 20px; overflow-x: auto; box-shadow: 0 4px 15px rgba(0,0,0,0.08);">
        <table style="width: 100%; border-collapse: collapse; font-size: 13px; min-width: 1200px;">
            <thead>
                <tr style="background: #F3E8FF;">
                    <th style="padding: 12px; text-align: center;">No</th>
                    <th style="padding: 12px; text-align: center;">ID</th>
                    <th style="padding: 12px;">Nama Lengkap</th>
                    <th style="padding: 12px;">Alamat</th>
                    <th style="padding: 12px;">No HP</th>
                    <th style="padding: 12px;">Mapel</th>
                    <th style="padding: 12px; text-align: center;">Grade</th>
                    <th style="padding: 12px;">HR SD</th>
                    <th style="padding: 12px;">HR SMP</th>
                    <th style="padding: 12px;">HR SMA</th>
                    <th style="padding: 12px;">Uang Makan</th>
                    <th style="padding: 12px;">Transport</th>
                    <th style="padding: 12px;">Email</th>
                    <th style="padding: 12px;">Username</th>
                    <th style="padding: 12px; text-align: center;">Status Akun</th>
                    <th style="padding: 12px; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                @forelse($tentors as $index => $t)
                <tr style="border-bottom: 1px solid #E5E7EB;">
                    <td style="padding: 12px; text-align: center;">{{ $tentors->firstItem() + $index }}</td>
                    <td style="padding: 12px; text-align: center;">TE{{ str_pad($t->id_tentor, 4, '0', STR_PAD_LEFT) }}</td>
                    <td style="padding: 12px;">{{ $t->nama_lengkap_tentor }}</td>
                    <td style="padding: 12px;">{{ $t->alamat_tentor ?? '-' }}</td>
                    <td style="padding: 12px;">{{ $t->no_hp_tentor ?? '-' }}</td>
                    <td style="padding: 12px;">{{ $t->mapel ?? '-' }}</td>
                    <td style="padding: 12px; text-align: center;">{{ $t->grade ?? '-' }}</td>
                    <td style="padding: 12px;">Rp {{ number_format($t->hr_sd ?? 0, 0, ',', '.') }}</td>
                    <td style="padding: 12px;">Rp {{ number_format($t->hr_smp ?? 0, 0, ',', '.') }}</td>
                    <td style="padding: 12px;">Rp {{ number_format($t->hr_sma ?? 0, 0, ',', '.') }}</td>
                    <td style="padding: 12px;">Rp {{ number_format($t->uang_makan ?? 0, 0, ',', '.') }}</td>
                    <td style="padding: 12px;">Rp {{ number_format($t->uang_transport ?? 0, 0, ',', '.') }}</td>
                    <td style="padding: 12px;">{{ $t->user->email ?? '-' }}</td>
                    <td style="padding: 12px;">{{ $t->user->username ?? '-' }}</td>
                    <td style="padding: 12px; text-align: center;">
                        <span style="padding: 4px 12px; border-radius: 20px; font-size: 11px; 
                            {{ ($t->user->status ?? 0) == 1 ? 'background: #D1FAE5; color: #065F46;' : 'background: #FEE2E2; color: #991B1B;' }}">
                            {{ ($t->user->status ?? 0) == 1 ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td style="padding: 12px; text-align: center;">
                        <div style="display: flex; gap: 8px; justify-content: center;">
                            <a href="{{ route('superadmin.kelola-tentor.edit', $t->id_tentor) }}" 
                               style="background: #5EB37E; color: white; padding: 5px 12px; border-radius: 6px; text-decoration: none; font-size: 12px;">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form method="POST" action="{{ route('superadmin.kelola-tentor.destroy', $t->id_tentor) }}" style="display:inline;" onsubmit="return confirm('Yakin hapus data tentor ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" style="background: #E35D5D; color: white; padding: 5px 12px; border-radius: 6px; border: none; cursor: pointer; font-size: 12px;">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="16" style="padding: 40px; text-align: center; color: #9CA3AF;">
                        <i class="fas fa-database" style="font-size: 40px; margin-bottom: 10px; display: block;"></i>
                        Belum ada data tentor.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    {{-- PAGINATION --}}
    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px;">
        <span style="color: #374151; font-size: 13px;">Menampilkan {{ $tentors->firstItem() ?? 0 }}–{{ $tentors->lastItem() ?? 0 }} dari {{ $tentors->total() }} data</span>
        <div>
            {{ $tentors->links() }}
        </div>
    </div>

</div>

<script>
    // Live search
    document.getElementById('searchInput').addEventListener('keyup', function() {
        let searchValue = this.value.toLowerCase();
        let rows = document.querySelectorAll('#tableBody tr');
        
        rows.forEach(row => {
            if(row.cells && row.cells.length >= 3) {
                let id = row.cells[1]?.innerText.toLowerCase() || '';
                let nama = row.cells[2]?.innerText.toLowerCase() || '';
                if(id.includes(searchValue) || nama.includes(searchValue)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            }
        });
    });
</script>
@endsection