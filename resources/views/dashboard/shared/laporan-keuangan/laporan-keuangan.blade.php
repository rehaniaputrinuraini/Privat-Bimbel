@extends('layouts.app')

@section('title', 'Laporan Keuangan')

@section('content')
<div style="width: 100%;">

    {{-- HEADER --}}
    <div style="margin-bottom: 25px;">
        <p style="color: #374151; font-size: 13px; margin: 0 0 4px 0;">{{ \Carbon\Carbon::now()->translatedFormat('F Y') }}</p>
        <h1 style="font-size: 26px; font-weight: 700; color: #111827; margin: 0;">Laporan Keuangan</h1>
        <p style="color: #374151; font-size: 14px; margin: 4px 0 0 0;">Rekap Semua Transaksi Keuangan</p>
    </div>

    {{-- TOTAL CARDS --}}
    <div style="display: flex; gap: 15px; margin-bottom: 20px; flex-wrap: wrap;">
        <div style="flex: 1; min-width: 200px; background: white; border-radius: 16px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.06);">
            <p style="color: #6B7280; font-size: 12px; margin: 0;">Total Pemasukan</p>
            <h3 style="color: #10B981; font-size: 22px; margin: 5px 0 0;">Rp {{ number_format($totalPemasukan ?? 0, 0, ',', '.') }}</h3>
        </div>
        <div style="flex: 1; min-width: 200px; background: white; border-radius: 16px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.06);">
            <p style="color: #6B7280; font-size: 12px; margin: 0;">Total Pengeluaran</p>
            <h3 style="color: #EF4444; font-size: 22px; margin: 5px 0 0;">Rp {{ number_format($totalPengeluaran ?? 0, 0, ',', '.') }}</h3>
        </div>
        <div style="flex: 1; min-width: 200px; background: white; border-radius: 16px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.06);">
            <p style="color: #6B7280; font-size: 12px; margin: 0;">Saldo</p>
            <h3 style="color: {{ ($totalPemasukan - $totalPengeluaran) >= 0 ? '#4D0B87' : '#EF4444' }}; font-size: 22px; margin: 5px 0 0;">
                Rp {{ number_format(($totalPemasukan ?? 0) - ($totalPengeluaran ?? 0), 0, ',', '.') }}
            </h3>
        </div>
    </div>

    {{-- FILTER --}}
    <div style="background: white; border-radius: 16px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.06); margin-bottom: 20px;">
        <div style="display: flex; gap: 12px; flex-wrap: wrap; align-items: center;">
            <div style="position: relative; flex: 2; min-width: 200px;">
                <i class="fas fa-search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #9CA3AF;"></i>
                <input type="text" id="searchLaporan" placeholder="Cari Keterangan..."
                       style="width: 100%; padding: 10px 15px 10px 45px; border-radius: 12px; border: 1px solid #E5E7EB; background: #F9FAFB; font-size: 14px; font-family: 'Poppins', sans-serif; outline: none;">
            </div>
            
            <select id="filterKategori" onchange="filterLaporan()"
                    style="flex: 1; min-width: 150px; padding: 10px 14px; border-radius: 12px; border: 1px solid #E5E7EB; background: #F9FAFB; font-size: 13px; font-family: 'Poppins', sans-serif; outline: none; cursor: pointer;">
                <option value="">Semua Kategori</option>
                <option value="Pembayaran Murid" {{ request('kategori') == 'Pembayaran Murid' ? 'selected' : '' }}>Pembayaran Murid</option>
                <option value="Pemasukan Lainnya" {{ request('kategori') == 'Pemasukan Lainnya' ? 'selected' : '' }}>Pemasukan Lainnya</option>
                <option value="Pengeluaran Lainnya" {{ request('kategori') == 'Pengeluaran Lainnya' ? 'selected' : '' }}>Pengeluaran Lainnya</option>
                <option value="Penggajian" {{ request('kategori') == 'Penggajian' ? 'selected' : '' }}>Penggajian</option>
            </select>
        </div>
        
        <div style="display: flex; gap: 12px; flex-wrap: wrap; align-items: center; margin-top: 15px;">
            {{-- Tombol Toggle Per Bulan / Per Periode --}}
            <div style="display: flex; background: #F3F4F6; border-radius: 12px; padding: 4px;">
                <button type="button" id="btnBulan" onclick="setTipe('bulan')" 
                        style="padding: 8px 20px; border-radius: 10px; border: none; font-weight: 600; font-size: 13px; cursor: pointer; transition: 0.3s; {{ $tipe == 'bulan' ? 'background: #4D0B87; color: white;' : 'background: transparent; color: #6B7280;' }}">
                    <i class="fas fa-calendar-alt"></i> Per Bulan
                </button>
                <button type="button" id="btnPeriode" onclick="setTipe('periode')" 
                        style="padding: 8px 20px; border-radius: 10px; border: none; font-weight: 600; font-size: 13px; cursor: pointer; transition: 0.3s; {{ $tipe == 'periode' ? 'background: #4D0B87; color: white;' : 'background: transparent; color: #6B7280;' }}">
                    <i class="fas fa-calendar-week"></i> Per Periode
                </button>
            </div>
            
            {{-- Filter Per Bulan --}}
            <div id="filterBulanDiv" style="display: {{ $tipe == 'bulan' ? 'flex' : 'none' }}; gap: 12px; flex-wrap: wrap; align-items: center;">
                <select id="filterBulan" onchange="filterLaporan()"
                        style="flex: 1; min-width: 120px; padding: 10px 14px; border-radius: 12px; border: 1px solid #E5E7EB; background: #F9FAFB; font-size: 13px; font-family: 'Poppins', sans-serif; outline: none; cursor: pointer;">
                    @foreach($bulanTersedia as $b)
                        <option value="{{ $b }}" {{ $bulan == $b ? 'selected' : '' }}>{{ Carbon\Carbon::create()->month($b)->translatedFormat('F') }}</option>
                    @endforeach
                </select>
                
                <select id="filterTahun" onchange="filterLaporan()"
                        style="flex: 1; min-width: 100px; padding: 10px 14px; border-radius: 12px; border: 1px solid #E5E7EB; background: #F9FAFB; font-size: 13px; font-family: 'Poppins', sans-serif; outline: none; cursor: pointer;">
                    @foreach($tahunTersedia as $t)
                        <option value="{{ $t }}" {{ $tahun == $t ? 'selected' : '' }}>{{ $t }}</option>
                    @endforeach
                </select>
            </div>
            
            {{-- Filter Per Periode --}}
            <div id="filterPeriodeDiv" style="display: {{ $tipe == 'periode' ? 'flex' : 'none' }}; gap: 12px;">
                <select id="filterPeriode" onchange="filterLaporan()"
                        style="flex: 1; min-width: 150px; padding: 10px 14px; border-radius: 12px; border: 1px solid #E5E7EB; background: #F9FAFB; font-size: 13px; font-family: 'Poppins', sans-serif; outline: none; cursor: pointer;">
                    @foreach($periodeTersedia as $p)
                        <option value="{{ $p }}" {{ $periode == $p ? 'selected' : '' }}>{{ $p }}</option>
                    @endforeach
                </select>
            </div>
            
            {{-- TOMBOL EXPORT PDF --}}
            <button onclick="exportToPDF()" 
                    style="background: #4D0B87; color: white; border: none; padding: 10px 20px; border-radius: 12px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 8px; font-size: 13px; transition: 0.3s;">
                <i class="fas fa-file-pdf"></i> Export PDF
            </button>
        </div>
    </div>

    {{-- TABEL --}}
    <div style="background: white; border-radius: 20px; overflow-x: auto; box-shadow: 0 4px 15px rgba(0,0,0,0.08);">
        <table style="width: 100%; border-collapse: collapse; font-size: 13px; white-space: nowrap; font-family: 'Poppins', sans-serif;">
            <thead>
                <tr style="background: #F3E8FF;">
                    <th style="padding: 15px; text-align: center; width: 40px;">No</th>
                    <th style="padding: 15px; width: 100px;">Tanggal</th>
                    <th style="padding: 15px; width: 140px;">Kategori</th>
                    <th style="padding: 15px; min-width: 200px;">Keterangan</th>
                    <th style="padding: 15px; text-align: right; width: 150px;">Pemasukan</th>
                    <th style="padding: 15px; text-align: right; width: 150px;">Pengeluaran</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                @forelse($laporan as $index => $item)
                <tr style="border-bottom: 1px solid #F3F4F6;">
                    <td style="padding: 15px; text-align: center;">{{ $laporan->firstItem() + $index }}</td>
                    <td style="padding: 15px;">{{ $item->tanggal }}</td>
                    <td style="padding: 15px;">
                        @php
                            $badgeColors = [
                                'Pembayaran Murid' => ['bg' => '#E0E7FF', 'color' => '#1E40AF'],
                                'Pemasukan Lainnya' => ['bg' => '#D1FAE5', 'color' => '#065F46'],
                                'Pengeluaran Lainnya' => ['bg' => '#FEE2E2', 'color' => '#991B1B'],
                                'Penggajian' => ['bg' => '#FEF3C7', 'color' => '#92400E'],
                            ];
                            $badge = $badgeColors[$item->kategori] ?? ['bg' => '#F3F4F6', 'color' => '#6B7280'];
                        @endphp
                        <span style="background:{{ $badge['bg'] }};color:{{ $badge['color'] }};padding:4px 10px;border-radius:20px;font-size:11px;white-space:nowrap;">{{ $item->kategori }}</span>
                    </td>
                    <td style="padding: 15px; max-width: 250px; overflow: hidden; text-overflow: ellipsis;">{{ $item->keterangan }}</td>
                    <td style="padding: 15px; text-align: right; {{ $item->pemasukan > 0 ? 'font-weight:700;color:#10B981;' : 'color:#9CA3AF;' }}">
                        {{ $item->pemasukan > 0 ? 'Rp '.number_format($item->pemasukan, 0, ',', '.') : '-' }}
                    </td>
                    <td style="padding: 15px; text-align: right; {{ $item->pengeluaran > 0 ? 'font-weight:700;color:#EF4444;' : 'color:#9CA3AF;' }}">
                        {{ $item->pengeluaran > 0 ? 'Rp '.number_format($item->pengeluaran, 0, ',', '.') : '-' }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="padding: 50px; text-align: center; color: #9CA3AF;">Belum ada data laporan</td>
                </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr style="background: #F3E8FF; font-weight: 700;">
                    <td colspan="4" style="padding: 15px; text-align: right;">TOTAL</td>
                    <td style="padding: 15px; text-align: right; color: #10B981;">Rp {{ number_format($totalPemasukan ?? 0, 0, ',', '.') }}</td>
                    <td style="padding: 15px; text-align: right; color: #EF4444;">Rp {{ number_format($totalPengeluaran ?? 0, 0, ',', '.') }}</td>
                </table>
            </tfoot>
        </table>
    </div>

    {{-- PAGINATION --}}
    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px; padding: 0 5px; margin-bottom: 40px;">
        <div style="display: flex; align-items: center; gap: 10px;">
            <select id="pageSelect" onchange="changePage(this.value)"
                    style="padding: 8px 12px; border-radius: 10px; border: 1px solid #E5E7EB; color: #374151; font-size: 13px; background: white; outline: none; cursor: pointer; font-family: 'Poppins', sans-serif;">
                <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10 baris</option>
                <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 baris</option>
                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 baris</option>
            </select>
            <span style="color: #374151; font-size: 13px;">Menampilkan {{ $laporan->total() ?? 0 }} data</span>
        </div>
        <div style="display: flex; gap: 5px;">
            @if ($laporan->onFirstPage())
                <button disabled style="width:35px;height:35px;border-radius:8px;border:1px solid #E5E7EB;background:#F3F4F6;color:#9CA3AF;cursor:not-allowed;"><i class="fas fa-angle-double-left"></i></button>
                <button disabled style="width:35px;height:35px;border-radius:8px;border:1px solid #E5E7EB;background:#F3F4F6;color:#9CA3AF;cursor:not-allowed;"><i class="fas fa-angle-left"></i></button>
            @else
                <a href="{{ $laporan->url(1) }}&per_page={{ request('per_page', 10) }}" style="width:35px;height:35px;border-radius:8px;border:1px solid #E5E7EB;background:white;color:#374151;display:flex;align-items:center;justify-content:center;text-decoration:none;"><i class="fas fa-angle-double-left"></i></a>
                <a href="{{ $laporan->previousPageUrl() }}&per_page={{ request('per_page', 10) }}" style="width:35px;height:35px;border-radius:8px;border:1px solid #E5E7EB;background:white;color:#374151;display:flex;align-items:center;justify-content:center;text-decoration:none;"><i class="fas fa-angle-left"></i></a>
            @endif

            @php $start = max(1, $laporan->currentPage() - 2); $end = min($laporan->lastPage(), $laporan->currentPage() + 2); @endphp
            @for ($i = $start; $i <= $end; $i++)
                @if ($i == $laporan->currentPage())
                    <button style="width:35px;height:35px;border-radius:8px;background:#4D0B87;color:white;border:none;font-weight:600;cursor:pointer;">{{ $i }}</button>
                @else
                    <a href="{{ $laporan->url($i) }}&per_page={{ request('per_page', 10) }}" style="width:35px;height:35px;border-radius:8px;border:1px solid #E5E7EB;background:white;color:#374151;display:flex;align-items:center;justify-content:center;text-decoration:none;">{{ $i }}</a>
                @endif
            @endfor

            @if ($laporan->hasMorePages())
                <a href="{{ $laporan->nextPageUrl() }}&per_page={{ request('per_page', 10) }}" style="width:35px;height:35px;border-radius:8px;border:1px solid #E5E7EB;background:white;color:#374151;display:flex;align-items:center;justify-content:center;text-decoration:none;"><i class="fas fa-angle-right"></i></a>
            @else
                <button disabled style="width:35px;height:35px;border-radius:8px;border:1px solid #E5E7EB;background:#F3F4F6;color:#9CA3AF;cursor:not-allowed;"><i class="fas fa-angle-right"></i></button>
            @endif
        </div>
    </div>

</div>

<script>
    function setTipe(tipe) {
        let url = new URL(window.location.href);
        url.searchParams.set('tipe', tipe);
        url.searchParams.delete('page');
        
        if (tipe == 'bulan') {
            url.searchParams.delete('periode');
            let bulan = document.getElementById('filterBulan')?.value || '';
            let tahun = document.getElementById('filterTahun')?.value || '';
            if (bulan) url.searchParams.set('bulan', bulan);
            if (tahun) url.searchParams.set('tahun', tahun);
        } else {
            url.searchParams.delete('bulan');
            url.searchParams.delete('tahun');
            let periode = document.getElementById('filterPeriode')?.value || '';
            if (periode) url.searchParams.set('periode', periode);
        }
        
        window.location.href = url.toString();
    }

    function filterLaporan() {
        const tipe = '{{ $tipe }}';
        const kategori = document.getElementById('filterKategori').value;
        
        let url = new URL(window.location.href);
        url.searchParams.set('tipe', tipe);
        if (kategori) url.searchParams.set('kategori', kategori); else url.searchParams.delete('kategori');
        
        if (tipe == 'bulan') {
            const bulan = document.getElementById('filterBulan').value;
            const tahun = document.getElementById('filterTahun').value;
            if (bulan) url.searchParams.set('bulan', bulan); else url.searchParams.delete('bulan');
            if (tahun) url.searchParams.set('tahun', tahun); else url.searchParams.delete('tahun');
            url.searchParams.delete('periode');
        } else {
            const periode = document.getElementById('filterPeriode').value;
            if (periode) url.searchParams.set('periode', periode); else url.searchParams.delete('periode');
            url.searchParams.delete('bulan');
            url.searchParams.delete('tahun');
        }
        
        url.searchParams.delete('page');
        window.location.href = url.toString();
    }

    function changePage(perPage) {
        const url = new URL(window.location.href);
        url.searchParams.set('per_page', perPage);
        url.searchParams.delete('page');
        window.location.href = url.toString();
    }

    document.getElementById('searchLaporan')?.addEventListener('keyup', function() {
        const s = this.value.toLowerCase();
        document.querySelectorAll('#tableBody tr').forEach(row => {
            if (!row.cells || row.cells.length < 6) return;
            const ket = row.cells[3]?.innerText.toLowerCase() || '';
            row.style.display = ket.includes(s) ? '' : 'none';
        });
    });

    function exportToPDF() {
        const tipe = '{{ $tipe }}';
        const kategori = document.getElementById('filterKategori').value;
        
        let url = "{{ route($role . '.laporan-keuangan.export-pdf') }}";
        let params = [];
        
        params.push(`tipe=${tipe}`);
        if (kategori) params.push(`kategori=${encodeURIComponent(kategori)}`);
        
        if (tipe == 'bulan') {
            const bulan = document.getElementById('filterBulan').value;
            const tahun = document.getElementById('filterTahun').value;
            if (bulan) params.push(`bulan=${bulan}`);
            if (tahun) params.push(`tahun=${tahun}`);
        } else {
            const periode = document.getElementById('filterPeriode').value;
            if (periode) params.push(`periode=${periode}`);
        }
        
        if (params.length > 0) url += '?' + params.join('&');
        window.open(url, '_blank');
    }
</script>
@endsection