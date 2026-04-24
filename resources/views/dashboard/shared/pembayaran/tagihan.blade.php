@extends('layouts.app')

@section('title', 'Tagihan Murid')

@push('styles')
<style>
    .filter-select {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%239CA3AF' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 14px center;
        padding-right: 38px !important;
    }
</style>
@endpush

@section('content')
<div style="width: 100%;">

    {{-- HEADER --}}
    <div style="margin-bottom: 25px;">
        <p style="color: #374151; font-size: 13px; margin: 0 0 4px 0;">
            {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}
        </p>
        <h1 style="font-size: 26px; font-weight: 700; color: #111827; margin: 0;">Tagihan Murid</h1>
        <p style="color: #374151; font-size: 14px; margin: 4px 0 0 0;">Kelola Tagihan Pembayaran Murid</p>
    </div>

    {{-- TOMBOL TAMBAH --}}
    <div style="display: flex; justify-content: flex-end; margin-bottom: 25px;">
        <a href="{{ route($role . '.pembayaran.create') }}" style="text-decoration: none;">
            <button style="background-color: #4D0B87; color: white; border: none; padding: 12px 25px; border-radius: 12px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-plus"></i> Input Pembayaran Murid
            </button>
        </a>
    </div>

    {{-- FILTER --}}
    <div style="background: white; border-radius: 16px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.06); margin-bottom: 20px;">
        <div style="position: relative; margin-bottom: 12px;">
            <i class="fas fa-search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #9CA3AF;"></i>
            <input type="text" id="searchTagihan" placeholder="Cari Nama Murid..."
                   style="width: 100%; padding: 12px 15px 12px 45px; border-radius: 12px; border: 1px solid #E5E7EB; background: #F9FAFB; font-size: 14px;">
        </div>
        <div style="display: flex; gap: 12px; flex-wrap: wrap;">
            <select id="filterPaket" class="filter-select" style="flex: 1; padding: 10px 14px; border-radius: 12px; border: 1px solid #E5E7EB; background: #F9FAFB;">
                <option value="">Status Paket</option>
                @foreach($paketList as $paket)
                    <option value="{{ $paket->tingkat }}">{{ $paket->tingkat }}</option>
                @endforeach
            </select>
            <select id="filterPembayaran" class="filter-select" style="flex: 1; padding: 10px 14px; border-radius: 12px; border: 1px solid #E5E7EB; background: #F9FAFB;">
                <option value="">Status Pembayaran Bulan Ini</option>
                <option value="Lunas">Lunas</option>
                <option value="Belum">Belum</option>
            </select>
            <select id="filterTagihan" class="filter-select" style="flex: 1; padding: 10px 14px; border-radius: 12px; border: 1px solid #E5E7EB; background: #F9FAFB;">
                <option value="">Status Tagihan</option>
                <option value="Lunas">Lunas</option>
                <option value="Tunggak">Tunggak</option>
                <option value="Uang Muka">Uang Muka</option>
            </select>
        </div>
    </div>

    {{-- TABEL --}}
    <div style="background: white; border-radius: 20px; overflow-x: auto; box-shadow: 0 4px 15px rgba(0,0,0,0.08);">
        <table style="width: 100%; border-collapse: collapse; font-size: 13px; white-space: nowrap;">
            <thead>
                <tr style="background: #F3E8FF;">
                    <th style="padding: 15px;">No</th>
                    <th style="padding: 15px;">Nama Murid</th>
                    <th style="padding: 15px;">Kelas</th>
                    <th style="padding: 15px;">Status Paket</th>
                    <th style="padding: 15px; text-align: center;">Status Pendaftaran</th>
                    <th style="padding: 15px; text-align: center;">Status Pembayaran</th>
                    <th style="padding: 15px; text-align: center;">Status Tagihan</th>
                    <th style="padding: 15px; text-align: center;">Tagihan Bulan</th>
                    <th style="padding: 15px; text-align: center;">Total Piutang</th>
                    <th style="padding: 15px; text-align: center;">Uang Muka</th>
                </tr>
            </thead>
            <tbody id="tagihanTableBody">
                @forelse($tagihan as $index => $t)
                <tr style="border-bottom: 1px solid #F3F4F6;">
                    <td style="padding: 15px;">{{ $index + 1 }}</td>
                    <td style="padding: 15px;">{{ $t->nama_murid }}</td>
                    <td style="padding: 15px;">{{ $t->kelas ?? '-' }}</td>
                    <td style="padding: 15px;">{{ $t->paket ?? '-' }}</td>
                    <td style="padding: 15px; text-align: center;">
                        @if($t->status_pendaftaran == 'Lunas')
                            <span style="padding: 5px 12px; border-radius: 20px; background: #E1F7E3; color: #0E7490;">Lunas</span>
                        @else
                            <span style="padding: 5px 12px; border-radius: 20px; background: #FEE2E2; color: #EF4444;">Belum</span>
                        @endif
                    </td>
                    <td style="padding: 15px; text-align: center;">
                        @if($t->status_pembayaran == 'Lunas')
                            <span style="padding: 5px 12px; border-radius: 20px; background: #E1F7E3; color: #0E7490;">Lunas</span>
                        @elseif($t->status_pembayaran == 'Belum')
                            <span style="padding: 5px 12px; border-radius: 20px; background: #FEE2E2; color: #EF4444;">Belum</span>
                        @else
                            <span style="padding: 5px 12px; border-radius: 20px; background: #F3F4F6; color: #6B7280;">-</span>
                        @endif
                    </td>
                    <td style="padding: 15px; text-align: center;">
                        @if($t->status_tagihan == 'Lunas')
                            <span style="padding: 5px 12px; border-radius: 20px; background: #E1F7E3; color: #0E7490;">Lunas</span>
                        @elseif($t->status_tagihan == 'Tunggak')
                            <span style="padding: 5px 12px; border-radius: 20px; background: #FEF3C7; color: #92400E;">Tunggak</span>
                        @elseif($t->status_tagihan == 'Uang Muka')
                            <span style="padding: 5px 12px; border-radius: 20px; background: #E0E7FF; color: #4338CA;">Uang Muka</span>
                        @else
                            <span style="padding: 5px 12px; border-radius: 20px; background: #F3F4F6; color: #6B7280;">-</span>
                        @endif
                    </td>
                    <td style="padding: 15px; text-align: center;">{{ $t->tagihan_bulan ?? '-' }}</td>
                    <td style="padding: 15px; text-align: center; {{ $t->total_piutang != '-' ? 'font-weight:700;color:#EF4444;' : '' }}">{{ $t->total_piutang ?? '-' }}</td>
                    <td style="padding: 15px; text-align: center;">{{ $t->uang_muka ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" style="padding: 40px; text-align: center; color: #9CA3AF;">Belum ada data tagihan</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

<script>
    function filterTagihan() {
        const search = document.getElementById('searchTagihan')?.value.toLowerCase() || '';
        const filterPaket = document.getElementById('filterPaket')?.value || '';
        const filterPembayaran = document.getElementById('filterPembayaran')?.value || '';
        const filterTagihanStatus = document.getElementById('filterTagihan')?.value || '';
        
        const rows = document.querySelectorAll('#tagihanTableBody tr');
        rows.forEach(row => {
            if (!row.cells || row.cells.length < 10) return;
            const nama = row.cells[1]?.innerText.toLowerCase() || '';
            const paket = row.cells[3]?.innerText || '';
            const statusPembayaran = row.cells[5]?.innerText.trim() || '';
            const statusTagihan = row.cells[6]?.innerText.trim() || '';
            
            let show = true;
            if (search && !nama.includes(search)) show = false;
            if (filterPaket && paket !== filterPaket) show = false;
            if (filterPembayaran && statusPembayaran !== filterPembayaran) show = false;
            if (filterTagihanStatus) {
                if (filterTagihanStatus === 'Tunggak' && statusTagihan !== 'Tunggak') show = false;
                else if (filterTagihanStatus === 'Uang Muka' && statusTagihan !== 'Uang Muka') show = false;
                else if (filterTagihanStatus === 'Lunas' && statusTagihan !== 'Lunas') show = false;
            }
            row.style.display = show ? '' : 'none';
        });
    }
    
    document.getElementById('searchTagihan')?.addEventListener('keyup', filterTagihan);
    document.getElementById('filterPaket')?.addEventListener('change', filterTagihan);
    document.getElementById('filterPembayaran')?.addEventListener('change', filterTagihan);
    document.getElementById('filterTagihan')?.addEventListener('change', filterTagihan);
</script>
@endsection