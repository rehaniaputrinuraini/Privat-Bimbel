@extends('layouts.app')

@section('title', 'Data Tentor')

@section('content')
<div style="width: 100%;">
    
    {{-- HEADER HALAMAN --}}
    <div style="margin-bottom: 25px;">
        <p style="color: #374151; font-size: 13px; margin: 0 0 4px 0;">
            {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}
        </p>
        <h1 style="font-size: 26px; font-weight: 700; color: #111827; margin: 0; letter-spacing: -0.5px; line-height: 1.2;">
            Data Tentor
        </h1>
        <p style="color: #374151; font-size: 14px; margin: 4px 0 0 0;">Manajemen Data dan Honorarium Tentor Bimbel Privat</p>
    </div>

    {{-- SESSION SUCCESS --}}
    @if(session('success'))
        <div style="background: #D1FAE5; color: #065F46; padding: 12px; border-radius: 10px; margin-bottom: 20px;">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    {{-- ACTIONS BAR (HANYA SEARCH) --}}
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; gap: 15px;">
        <div style="display: flex; align-items: center; gap: 12px; flex: 1;">
            <div style="position: relative; width: 300px;">
                <i class="fas fa-search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #9CA3AF;"></i>
                <input type="text" id="searchInput" placeholder="Cari Nama atau ID Tentor..." 
                       style="width: 100%; padding: 10px 15px 10px 45px; border-radius: 12px; border: 1px solid #E5E7EB; outline: none; background: white; font-size: 14px; color: #374151;">
            </div>
        </div>
    </div>

    {{-- TABEL UTAMA --}}
    <div style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.08); border: 1px solid #F3F4F6;">
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 13px; white-space: nowrap;">
                <thead>
                    <tr style="background: #F3E8FF; color: #111827;">
                        <th style="padding: 15px; font-weight: 700; width: 50px; text-align: center;">No</th>
                        <th style="padding: 15px; font-weight: 700;">ID</th>
                        <th style="padding: 15px; font-weight: 700;">Nama Lengkap</th>
                        <th style="padding: 15px; font-weight: 700;">Alamat</th>
                        <th style="padding: 15px; font-weight: 700;">No HP</th>
                        <th style="padding: 15px; font-weight: 700;">Mapel</th>
                        <th style="padding: 15px; font-weight: 700; text-align: center;">Grade</th>
                        <th style="padding: 15px; font-weight: 700; text-align: right;">HR SD</th>
                        <th style="padding: 15px; font-weight: 700; text-align: right;">HR SMP</th>
                        <th style="padding: 15px; font-weight: 700; text-align: right;">HR SMA</th>
                        <th style="padding: 15px; font-weight: 700; text-align: right;">Uang Makan</th>
                        <th style="padding: 15px; font-weight: 700; text-align: right;">Transport</th>
                    </tr>
                </thead>
                <tbody id="tableBody" style="color: #374151;">
                    @forelse($tentors as $index => $t)
                    <tr style="border-bottom: 1px solid #F3F4F6; transition: 0.2s;" onmouseover="this.style.background='#F9FAFB'" onmouseout="this.style.background='transparent'">
                        <td style="padding: 15px; text-align: center;">{{ $tentors->firstItem() + $index }}</td>
                        <td style="padding: 15px; font-weight: 500;">TE{{ str_pad($t->id_pegawai, 4, '0', STR_PAD_LEFT) }}</td>
                        <td style="padding: 15px;">{{ $t->nama_lengkap ?? '-' }}</td>
                        <td style="padding: 15px;">{{ $t->alamat ?? '-' }}</td>
                        <td style="padding: 15px;">{{ $t->no_hp ?? '-' }}</td>
                        <td style="padding: 15px;">{{ $t->mapel ?? '-' }}</td>
                        <td style="padding: 15px; text-align: center;">
                            @if($t->grade == 'A')
                                <span style="background: #FEF3C7; color: #92400E; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 600;">Grade A</span>
                            @elseif($t->grade == 'B')
                                <span style="background: #E0E7FF; color: #3730A3; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 600;">Grade B</span>
                            @else
                                <span style="color: #9CA3AF;">-</span>
                            @endif
                        </td>
                        <td style="padding: 15px; text-align: right;">Rp {{ number_format($t->hr_sd ?? 0, 0, ',', '.') }}</td>
                        <td style="padding: 15px; text-align: right;">Rp {{ number_format($t->hr_smp ?? 0, 0, ',', '.') }}</td>
                        <td style="padding: 15px; text-align: right;">Rp {{ number_format($t->hr_sma ?? 0, 0, ',', '.') }}</td>
                        <td style="padding: 15px; text-align: right;">Rp {{ number_format($t->uang_makan ?? 0, 0, ',', '.') }}</td>
                        <td style="padding: 15px; text-align: right;">Rp {{ number_format($t->uang_transport ?? 0, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="12" style="padding: 40px; text-align: center; color: #9CA3AF;">
                            <i class="fas fa-database" style="font-size: 40px; margin-bottom: 10px; display: block;"></i>
                            Belum ada data tentor.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    {{-- ── PAGINATION & SHOW ENTRIES ── --}}
    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px; padding: 0 5px;">
        <div style="display: flex; align-items: center; gap: 10px;">
            <select id="pageSelect" style="padding: 8px 12px; border-radius: 10px; border: 1px solid #E5E7EB; color: #374151; font-size: 13px; background: white; outline: none; cursor: pointer; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                <option value="10">10 baris</option>
                <option value="25">25 baris</option>
                <option value="50">50 baris</option>
            </select>
            <span style="color: #374151; font-size: 13px;">Menampilkan {{ $tentors->count() }} data</span>
        </div>

        <div style="display: flex; gap: 5px;">
            <button style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; cursor: pointer;"><i class="fas fa-angle-double-left"></i></button>
            <button style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; cursor: pointer;"><i class="fas fa-angle-left"></i></button>
            <button style="width: 35px; height: 35px; border-radius: 8px; background: #4D0B87; color: white; border: none; font-weight: 600; cursor: pointer;">1</button>
            <button style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; cursor: pointer;"><i class="fas fa-angle-right"></i></button>
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

    // Page Select (show entries)
    document.getElementById('pageSelect')?.addEventListener('change', function() {
        let perPage = this.value;
        let url = new URL(window.location.href);
        url.searchParams.set('per_page', perPage);
        url.searchParams.delete('page');
        window.location.href = url.toString();
    });
</script>
@endsection