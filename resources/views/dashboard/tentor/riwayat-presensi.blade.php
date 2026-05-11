@extends('layouts.app')

@section('title', 'Riwayat Presensi')

@section('content')
<div style="width: 100%;">
    
    {{-- HEADER --}}
    <div style="margin-bottom: 25px;">
        <p style="color: #374151; font-size: 13px; margin: 0 0 4px 0;">
            {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}
        </p>
        <h1 style="font-size: 26px; font-weight: 700; color: #111827; margin: 0; letter-spacing: -0.5px; line-height: 1.2;">
            Riwayat Presensi
        </h1>
        <p style="color: #374151; font-size: 14px; margin: 4px 0 0 0;">Lihat riwayat kehadiran mengajar Anda setiap bulannya</p>
    </div>

    {{-- FILTER FORM -- DEFAULT BULAN & TAHUN SAAT INI --}}
    <form method="GET" action="{{ route('tentor.riwayat-presensi') }}" id="filterForm">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; gap: 15px;">
            <div style="display: flex; align-items: center; gap: 12px; flex: 1; flex-wrap: wrap;">
                
                {{-- SEARCH BAR --}}
                <div style="position: relative; width: 300px;">
                    <i class="fas fa-search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #9CA3AF;"></i>
                    <input type="text" id="liveSearchInput" name="search" value="{{ $search ?? '' }}" placeholder="Cari Kelas, Ruang, Status..."
                           style="width: 100%; padding: 10px 15px 10px 45px; border-radius: 12px; border: 1px solid #E5E7EB; outline: none; background: white; font-size: 14px; color: #374151;">
                </div>

                {{-- FILTER BULAN -- DEFAULT BULAN SAAT INI --}}
                <select name="bulan" style="padding: 10px 12px; border-radius: 12px; border: 1px solid #E5E7EB; color: #374151; font-size: 13px; min-width: 140px; background: white; outline: none; cursor: pointer;" onchange="this.form.submit()">
                    @php
                        $bulanSekarang = date('n');
                        $requestBulan = request('bulan');
                    @endphp
                    @for($i = 1; $i <= 12; $i++)
                        @php
                            $selected = false;
                            if ($requestBulan) {
                                $selected = ($requestBulan == $i);
                            } else {
                                $selected = ($bulanSekarang == $i);
                            }
                        @endphp
                        <option value="{{ $i }}" {{ $selected ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                        </option>
                    @endfor
                </select>

                {{-- FILTER TAHUN -- DEFAULT TAHUN SAAT INI --}}
                <select name="tahun" style="padding: 10px 12px; border-radius: 12px; border: 1px solid #E5E7EB; color: #374151; font-size: 13px; min-width: 100px; background: white; outline: none; cursor: pointer;" onchange="this.form.submit()">
                    @php
                        $tahunSekarang = date('Y');
                        $requestTahun = request('tahun');
                        $tahunMulai = $tahunSekarang - 2;
                        $tahunAkhir = $tahunSekarang + 1;
                    @endphp
                    @for($year = $tahunMulai; $year <= $tahunAkhir; $year++)
                        @php
                            $selected = false;
                            if ($requestTahun) {
                                $selected = ($requestTahun == $year);
                            } else {
                                $selected = ($tahunSekarang == $year);
                            }
                        @endphp
                        <option value="{{ $year }}" {{ $selected ? 'selected' : '' }}>{{ $year }}</option>
                    @endfor
                </select>
                
                {{-- RESET BUTTON --}}
                @if(request('bulan') || request('tahun') || request('search'))
                    <a href="{{ route('tentor.riwayat-presensi') }}" style="padding: 10px 15px; border-radius: 12px; background: #F3F4F6; color: #374151; text-decoration: none; font-size: 13px;">
                        <i class="fas fa-times"></i> Reset
                    </a>
                @endif
            </div>
        </div>
        
        <input type="hidden" name="perPage" id="perPageInput" value="{{ request('perPage', 10) }}">
    </form>

    {{-- TABEL RIWAYAT --}}
    <div style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.08); border: 1px solid #F3F4F6;">
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 13px; white-space: nowrap;">
                <thead>
                    <tr style="background: #F3E8FF; color: #111827;">
                        <th style="padding: 15px; font-weight: 700; width: 50px;">No</th>
                        <th style="padding: 15px; font-weight: 700;">Tanggal</th>
                        <th style="padding: 15px; font-weight: 700;">Kelas</th>
                        <th style="padding: 15px; font-weight: 700;">Ruang</th>
                        <th style="padding: 15px; font-weight: 700;">Jam Masuk</th>
                        <th style="padding: 15px; font-weight: 700;">Jam Keluar</th>
                        <th style="padding: 15px; font-weight: 700; text-align: center;">Status Murid</th>
                    </tr>
                </thead>
                <tbody id="tableBody" style="color: #374151;">
                    @forelse($riwayat as $index => $item)
                        @php
                            $namaKelas = $item->kelas ? $item->kelas->jenjang . ' - ' . $item->kelas->nama_kelas : '-';
                            $namaRuang = $item->ruang ? $item->ruang->nama_ruang : '-';
                            
                            $statusText = $item->murid_hadir == 'Hadir' ? 'Hadir' : 'Tidak Hadir';
                            $statusClass = $item->murid_hadir == 'Hadir' 
                                ? 'background: #D1FAE5; color: #065F46;' 
                                : 'background: #FEE2E2; color: #991B1B;';
                            
                            $jamMasuk = $item->jam_mulai ? \Carbon\Carbon::parse($item->jam_mulai)->format('H:i') : '-';
                            $jamKeluar = $item->jam_selesai ? \Carbon\Carbon::parse($item->jam_selesai)->format('H:i') : '-';
                        @endphp
                        <tr style="border-bottom: 1px solid #F3F4F6; transition: 0.2s;" onmouseover="this.style.background='#F9FAFB'" onmouseout="this.style.background='transparent'">
                            <td style="padding: 15px;">{{ $riwayat->firstItem() + $index }}</td>
                            <td style="padding: 15px;">{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}</td>
                            <td style="padding: 15px;">{{ $namaKelas }}</td>
                            <td style="padding: 15px;">{{ $namaRuang }}</td>
                            <td style="padding: 15px;">{{ $jamMasuk }}</td>
                            <td style="padding: 15px;">{{ $jamKeluar }}</td>
                            <td style="padding: 15px; text-align: center;">
                                <span style="padding: 5px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; {{ $statusClass }}">
                                    {{ $statusText }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="padding: 40px; text-align: center; color: #9CA3AF;">
                                <i class="fas fa-calendar-alt" style="font-size: 40px; margin-bottom: 10px; display: block;"></i>
                                @if(isset($error) && $error)
                                    {{ $error }}
                                @else
                                    Belum ada data presensi
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    {{-- PAGINATION --}}
    @if($riwayat->count() > 0)
    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px; padding: 0 5px;">
        <div style="display: flex; align-items: center; gap: 10px;">
            <select id="perPageSelect" style="padding: 8px 12px; border-radius: 10px; border: 1px solid #E5E7EB; color: #374151; font-size: 13px; background: white; outline: none; cursor: pointer;">
                <option value="10" {{ request('perPage', 10) == 10 ? 'selected' : '' }}>10 baris</option>
                <option value="25" {{ request('perPage', 10) == 25 ? 'selected' : '' }}>25 baris</option>
                <option value="50" {{ request('perPage', 10) == 50 ? 'selected' : '' }}>50 baris</option>
            </select>
            <span style="color: #374151; font-size: 13px;">
                Menampilkan {{ $riwayat->total() }} data
            </span>
        </div>

        {{-- PAGINATION LINKS --}}
        <div style="display: flex; gap: 5px;">
            {{-- First Page --}}
            @if($riwayat->onFirstPage())
                <button style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: #F3F4F6; color: #9CA3AF; cursor: not-allowed;" disabled>
                    <i class="fas fa-angle-double-left"></i>
                </button>
            @else
                <a href="{{ $riwayat->url(1) }}" 
                   style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; display: flex; align-items: center; justify-content: center; text-decoration: none;">
                    <i class="fas fa-angle-double-left"></i>
                </a>
            @endif

            {{-- Previous Page --}}
            @if($riwayat->onFirstPage())
                <button style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: #F3F4F6; color: #9CA3AF; cursor: not-allowed;" disabled>
                    <i class="fas fa-angle-left"></i>
                </button>
            @else
                <a href="{{ $riwayat->previousPageUrl() }}" 
                   style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; display: flex; align-items: center; justify-content: center; text-decoration: none;">
                    <i class="fas fa-angle-left"></i>
                </a>
            @endif

            {{-- Current Page --}}
            <button style="width: 35px; height: 35px; border-radius: 8px; background: #4D0B87; color: white; border: none; font-weight: 600; cursor: default;">
                {{ $riwayat->currentPage() }}
            </button>

            {{-- Next Page --}}
            @if($riwayat->hasMorePages())
                <a href="{{ $riwayat->nextPageUrl() }}" 
                   style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; display: flex; align-items: center; justify-content: center; text-decoration: none;">
                    <i class="fas fa-angle-right"></i>
                </a>
            @else
                <button style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: #F3F4F6; color: #9CA3AF; cursor: not-allowed;" disabled>
                    <i class="fas fa-angle-right"></i>
                </button>
            @endif

            {{-- Last Page --}}
            @if($riwayat->hasMorePages())
                <a href="{{ $riwayat->url($riwayat->lastPage()) }}" 
                   style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; display: flex; align-items: center; justify-content: center; text-decoration: none;">
                    <i class="fas fa-angle-double-right"></i>
                </a>
            @else
                <button style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: #F3F4F6; color: #9CA3AF; cursor: not-allowed;" disabled>
                    <i class="fas fa-angle-double-right"></i>
                </button>
            @endif
        </div>
    </div>
    @endif

</div>

<script>
    // Live Search dengan debounce (500ms)
    let timeout = null;
    const liveSearchInput = document.getElementById('liveSearchInput');
    const filterForm = document.getElementById('filterForm');
    
    liveSearchInput?.addEventListener('keyup', function() {
        clearTimeout(timeout);
        timeout = setTimeout(() => {
            filterForm.submit();
        }, 500);
    });

    // Pagination Show Entries
    document.getElementById('perPageSelect')?.addEventListener('change', function() {
        document.getElementById('perPageInput').value = this.value;
        filterForm.submit();
    });
</script>
@endsection