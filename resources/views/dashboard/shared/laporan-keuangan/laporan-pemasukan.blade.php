@extends('layouts.app')

@section('title', 'Laporan Pemasukan')

@push('styles')
<style>
    .filter-select {
        -webkit-appearance: none; -moz-appearance: none; appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='10' viewBox='0 0 24 24' fill='none' stroke='%236B7280' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
        background-repeat: no-repeat; background-position: right 12px center; background-size: 12px 12px; padding-right: 36px !important;
    }
    .table-pemasukan th {
        background: #A2B9EE; color: #111827; font-weight: 700; padding: 14px 12px; font-size: 12px; text-align: center;
        border: 1px solid #D1D5DB;
    }
    .table-pemasukan td {
        padding: 12px; font-size: 12px; text-align: center; border: 1px solid #E5E7EB;
    }
    .table-pemasukan tbody tr:hover {
        background: #F0F4FF !important;
    }
</style>
@endpush

@section('content')
<div style="width: 100%;">

    @php $role = $role ?? (Auth::user()->peran); @endphp

    <div style="margin-bottom: 25px;">
        <p style="color: #374151; font-size: 13px; margin: 0 0 4px 0;">{{ \Carbon\Carbon::now()->translatedFormat('F Y') }}</p>
        <h1 style="font-size: 26px; font-weight: 700; color: #111827; margin: 0;">Laporan Pemasukan</h1>
        <p style="color: #374151; font-size: 14px; margin: 4px 0 0 0;">Data Pemasukan Murid & Manual</p>
    </div>

    @if(session('success'))
        <div style="background: #D1FAE5; color: #065F46; padding: 12px; border-radius: 10px; margin-bottom: 20px;">{{ session('success') }}</div>
    @endif

    {{-- 2 CARD --}}
    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-bottom: 30px;">
        <div style="background: white; padding: 20px; border-radius: 15px; border-left: 8px solid #4472DF; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
            <p style="margin: 0; color: #4472DF; font-weight: 700; font-size: 13px;">Total Pemasukan Murid</p>
            <h3 style="margin: 10px 0 0; font-size: 20px; font-weight: 800; color: #4472DF;">Rp {{ number_format($totalMurid, 0, ',', '.') }}</h3>
        </div>
        <div style="background: white; padding: 20px; border-radius: 15px; border-left: 8px solid #4AB462; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
            <p style="margin: 0; color: #4AB462; font-weight: 700; font-size: 13px;">Total Pemasukan Manual</p>
            <h3 style="margin: 10px 0 0; font-size: 20px; font-weight: 800; color: #4AB462;">Rp {{ number_format($totalManual, 0, ',', '.') }}</h3>
        </div>
    </div>

    {{-- FILTER BAR + EXPORT PDF --}}
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; gap: 12px; flex-wrap: wrap;">
        <form method="GET" action="{{ route($role . '.laporan-keuangan.pemasukan') }}" style="display: flex; gap: 12px; flex-wrap: wrap; flex: 1;">
            <select name="bulan" class="filter-select" style="padding: 10px 12px; border-radius: 12px; border: 1px solid #E5E7EB; font-size: 13px; background: white; cursor: pointer;" onchange="this.form.submit()">
                <option value="">— Bulan —</option>
                @foreach($bulanList as $key => $b)
                    @if($key > 0)<option value="{{ $key }}" {{ $filterBulan == $key ? 'selected' : '' }}>{{ $b }}</option>@endif
                @endforeach
            </select>
            <select name="tahun" class="filter-select" style="padding: 10px 12px; border-radius: 12px; border: 1px solid #E5E7EB; font-size: 13px; background: white; cursor: pointer;" onchange="this.form.submit()">
                <option value="">— Tahun —</option>
                @foreach($tahunList as $t)
                    <option value="{{ $t }}" {{ $filterTahun == $t ? 'selected' : '' }}>{{ $t }}</option>
                @endforeach
            </select>
            <select name="periode" class="filter-select" style="padding: 10px 12px; border-radius: 12px; border: 1px solid #E5E7EB; font-size: 13px; background: white; cursor: pointer;" onchange="this.form.submit()">
                <option value="">— Periode —</option>
                @foreach($periodeList as $p)
                    <option value="{{ $p->id_periode }}" {{ $filterPeriode == $p->id_periode ? 'selected' : '' }}>{{ $p->tahun_periode }}</option>
                @endforeach
            </select>
            @if($filterBulan || $filterTahun || $filterPeriode)
                <a href="{{ route($role . '.laporan-keuangan.pemasukan') }}" style="padding: 10px 15px; background: #F3F4F6; color: #374151; border-radius: 12px; text-decoration: none; font-size: 13px; display: flex; align-items: center; gap: 5px;">
                    <i class="fas fa-times"></i> Reset
                </a>
            @endif
        </form>

        <button onclick="window.print()" style="background: #DC2626; color: white; border: none; padding: 11px 20px; border-radius: 12px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 8px; font-size: 13px; white-space: nowrap; box-shadow: 0 2px 8px rgba(220,38,38,0.2);">
            <i class="fas fa-file-pdf" style="font-size: 16px;"></i> Export PDF
        </button>
    </div>

    {{-- TABEL --}}
    <div style="background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.08); border: 1px solid #F3F4F6;">
        <div style="overflow-x: auto;">
            <table class="table-pemasukan" style="width: 100%; border-collapse: collapse; white-space: nowrap;">
                <thead>
                    <tr>
                        <th style="width: 45px;">NO</th>
                        <th style="width: 110px;">TANGGAL</th>
                        <th style="width: 100px;">KATEGORI</th>
                        <th>KETERANGAN</th>
                        <th style="width: 160px;">PEMASUKAN</th>
                    </tr>
                </thead>
                <tbody style="color: #374151;">
                    @php $totalPemasukanTabel = 0; @endphp
                    @forelse($transaksi as $index => $t)
                    @php $totalPemasukanTabel += $t->jumlah; @endphp
                    <tr>
                        <td>{{ $transaksi->firstItem() + $index }}</td>
                        <td>{{ $t->tanggal ? \Carbon\Carbon::parse($t->tanggal)->format('d-m-Y') : '-' }}</td>
                        <td>
                            @if($t->sumber == 'Murid')
                                <span style="background: #D1FAE5; color: #065F46; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 600;">Siswa</span>
                            @else
                                <span style="background: #E0E7FF; color: #4338CA; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 600;">Manual</span>
                            @endif
                        </td>
                        <td style="text-align: left;">{{ $t->keterangan }}</td>
                        <td style="text-align: right; font-weight: 600; color: #059669;">Rp {{ number_format($t->jumlah, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="5" style="padding: 40px; text-align: center; color: #9CA3AF;">Belum ada data pemasukan</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- TOTAL --}}
        <div style="display: flex; justify-content: space-between; padding: 14px 20px; background: #F9FAFB; border-top: 2px solid #E5E7EB; font-weight: 700; font-size: 14px;">
            <span>TOTAL</span>
            <span style="color: #059669;">Rp {{ number_format($totalPemasukanTabel, 0, ',', '.') }}</span>
        </div>

        {{-- PAGINATION --}}
        <div style="display: flex; justify-content: space-between; align-items: center; padding: 10px 20px; background: #F9FAFB; border-top: 1px solid #E5E7EB;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <select id="pageSelect" style="padding: 8px 12px; border-radius: 10px; border: 1px solid #E5E7EB; color: #374151; font-size: 13px; background: white; outline: none; cursor: pointer;">
                    <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10 baris</option>
                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 baris</option>
                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 baris</option>
                </select>
                <span style="color: #374151; font-size: 13px;">Menampilkan {{ $transaksi->total() ?? 0 }} data</span>
            </div>
            <div style="display: flex; gap: 5px;">
                @if ($transaksi->onFirstPage())
                    <button disabled style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: #F3F4F6; color: #9CA3AF; cursor: not-allowed;"><i class="fas fa-angle-double-left"></i></button>
                    <button disabled style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: #F3F4F6; color: #9CA3AF; cursor: not-allowed;"><i class="fas fa-angle-left"></i></button>
                @else
                    <a href="{{ request()->fullUrlWithQuery(['page' => 1]) }}" style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #4472DF; background: white; color: #4472DF; display: flex; align-items: center; justify-content: center; text-decoration: none;"><i class="fas fa-angle-double-left"></i></a>
                    <a href="{{ request()->fullUrlWithQuery(['page' => $transaksi->currentPage() - 1]) }}" style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #4472DF; background: white; color: #4472DF; display: flex; align-items: center; justify-content: center; text-decoration: none;"><i class="fas fa-angle-left"></i></a>
                @endif

                @php $start = max(1, $transaksi->currentPage() - 2); $end = min($transaksi->lastPage(), $transaksi->currentPage() + 2); @endphp
                @for ($i = $start; $i <= $end; $i++)
                    @if ($i == $transaksi->currentPage())
                        <button style="width: 35px; height: 35px; border-radius: 8px; background: #4472DF; color: white; border: none; font-weight: 600; cursor: pointer;">{{ $i }}</button>
                    @else
                        <a href="{{ request()->fullUrlWithQuery(['page' => $i]) }}" style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #4472DF; background: white; color: #4472DF; display: flex; align-items: center; justify-content: center; text-decoration: none;">{{ $i }}</a>
                    @endif
                @endfor

                @if ($transaksi->hasMorePages())
                    <a href="{{ request()->fullUrlWithQuery(['page' => $transaksi->currentPage() + 1]) }}" style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #4472DF; background: white; color: #4472DF; display: flex; align-items: center; justify-content: center; text-decoration: none;"><i class="fas fa-angle-right"></i></a>
                @else
                    <button disabled style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: #F3F4F6; color: #9CA3AF; cursor: not-allowed;"><i class="fas fa-angle-right"></i></button>
                @endif
            </div>
        </div>
    </div>

</div>

<script>
    document.getElementById('pageSelect')?.addEventListener('change', function() {
        let url = new URL(window.location.href);
        url.searchParams.set('per_page', this.value);
        url.searchParams.delete('page');
        window.location.href = url.toString();
    });
</script>
@endsection