@extends('layouts.app')

@section('title', 'Riwayat Pembayaran')

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
        <h1 style="font-size: 26px; font-weight: 700; color: #111827; margin: 0;">Riwayat Pembayaran</h1>
        <p style="color: #374151; font-size: 14px; margin: 4px 0 0 0;">Riwayat Pembayaran Murid</p>
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
            <input type="text" id="searchRiwayat" placeholder="Cari Nama Murid..."
                   style="width: 100%; padding: 12px 15px 12px 45px; border-radius: 12px; border: 1px solid #E5E7EB; background: #F9FAFB; font-size: 14px;">
        </div>
        <div style="display: flex; gap: 12px; flex-wrap: wrap;">
            <select id="filterPaketRiwayat" class="filter-select" style="flex: 1; padding: 10px 14px; border-radius: 12px; border: 1px solid #E5E7EB; background: #F9FAFB;">
                <option value="">Status Paket</option>
                @foreach($paketList as $paket)
                    <option value="{{ $paket->tingkat }}">{{ $paket->tingkat }}</option>
                @endforeach
            </select>
            <select id="filterJenisPembayaran" class="filter-select" style="flex: 1; padding: 10px 14px; border-radius: 12px; border: 1px solid #E5E7EB; background: #F9FAFB;">
                <option value="">Jenis Pembayaran</option>
                <option value="Tunai">Tunai</option>
                <option value="Transfer">Transfer</option>
            </select>
            <select id="filterBulan" class="filter-select" style="flex: 1; padding: 10px 14px; border-radius: 12px; border: 1px solid #E5E7EB; background: #F9FAFB;">
                <option value="">Pilih Bulan</option>
                <option value="1">Januari</option>
                <option value="2">Februari</option>
                <option value="3">Maret</option>
                <option value="4">April</option>
                <option value="5">Mei</option>
                <option value="6">Juni</option>
                <option value="7">Juli</option>
                <option value="8">Agustus</option>
                <option value="9">September</option>
                <option value="10">Oktober</option>
                <option value="11">November</option>
                <option value="12">Desember</option>
            </select>
            <select id="filterTahunRiwayat" class="filter-select" style="flex: 1; padding: 10px 14px; border-radius: 12px; border: 1px solid #E5E7EB; background: #F9FAFB;">
                <option value="">Pilih Tahun</option>
            </select>
        </div>
    </div>

    {{-- TABEL --}}
    <div style="background: white; border-radius: 20px; overflow-x: auto; box-shadow: 0 4px 15px rgba(0,0,0,0.08);">
        <table style="width: 100%; border-collapse: collapse; font-size: 13px; white-space: nowrap;">
            <thead>
                <tr style="background: #F3E8FF;">
                    <th style="padding: 15px;">No</th>
                    <th style="padding: 15px;">Tanggal</th>
                    <th style="padding: 15px;">Nama Murid</th>
                    <th style="padding: 15px;">Paket Awal</th>
                    <th style="padding: 15px;">Paket Belajar</th>
                    <th style="padding: 15px;">Untuk Bulan</th>
                    <th style="padding: 15px;">Jenis</th>
                    <th style="padding: 15px; text-align: center;">Total Bayar</th>
                    <th style="padding: 15px;">Keterangan</th>
                </tr>
            </thead>
            <tbody id="riwayatTableBody">
                @forelse($riwayat as $index => $r)
                <tr style="border-bottom: 1px solid #F3F4F6;">
                    <td style="padding: 15px;">{{ $index + 1 }}</td>
                    <td style="padding: 15px;">{{ $r->tanggal }}</td>
                    <td style="padding: 15px;">{{ $r->nama_murid }}</td>
                    <td style="padding: 15px;">{{ $r->paket_awal }}</td>
                    <td style="padding: 15px;">{{ $r->paket_selanjutnya }}</td>
                    <td style="padding: 15px;">{{ $r->bulan_dibayar }}</td>
                    <td style="padding: 15px;">{{ $r->jenis_pembayaran ?? '-' }}</td>
                    <td style="padding: 15px; text-align: center; font-weight: 700; color: #4D0B87;">{{ $r->total_bayar }}</td>
                    <td style="padding: 15px;">{{ $r->keterangan }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" style="padding: 40px; text-align: center; color: #9CA3AF;">Belum ada riwayat pembayaran</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

<script>
    function filterRiwayat() {
        const search = document.getElementById('searchRiwayat')?.value.toLowerCase() || '';
        const filterPaket = document.getElementById('filterPaketRiwayat')?.value || '';
        const filterJenis = document.getElementById('filterJenisPembayaran')?.value || '';
        const filterBulan = document.getElementById('filterBulan')?.value || '';
        const filterTahun = document.getElementById('filterTahunRiwayat')?.value || '';
        
        const rows = document.querySelectorAll('#riwayatTableBody tr');
        rows.forEach(row => {
            if (!row.cells || row.cells.length < 9) return;
            const nama = row.cells[2]?.innerText.toLowerCase() || '';
            const paket = row.cells[4]?.innerText || '';
            const jenis = row.cells[6]?.innerText || '';
            const tgl = row.cells[1]?.innerText || '';
            const parts = tgl.split('/');
            const bulan = parts[1] ? parseInt(parts[1]) : 0;
            const tahun = parts[2] ? parseInt(parts[2]) : 0;
            
            let show = true;
            if (search && !nama.includes(search)) show = false;
            if (filterPaket && paket !== filterPaket) show = false;
            if (filterJenis && jenis !== filterJenis) show = false;
            if (filterBulan && bulan !== parseInt(filterBulan)) show = false;
            if (filterTahun && tahun !== parseInt(filterTahun)) show = false;
            row.style.display = show ? '' : 'none';
        });
    }
    
    document.getElementById('searchRiwayat')?.addEventListener('keyup', filterRiwayat);
    document.getElementById('filterPaketRiwayat')?.addEventListener('change', filterRiwayat);
    document.getElementById('filterJenisPembayaran')?.addEventListener('change', filterRiwayat);
    document.getElementById('filterBulan')?.addEventListener('change', filterRiwayat);
    document.getElementById('filterTahunRiwayat')?.addEventListener('change', filterRiwayat);
    
    // Isi dropdown tahun
    const tahunSelect = document.getElementById('filterTahunRiwayat');
    if (tahunSelect) {
        const tahunSet = new Set();
        document.querySelectorAll('#riwayatTableBody tr').forEach(row => {
            if (row.cells && row.cells[1]) {
                const tgl = row.cells[1].innerText;
                const parts = tgl.split('/');
                if (parts[2]) tahunSet.add(parseInt(parts[2]));
            }
        });
        Array.from(tahunSet).sort().reverse().forEach(tahun => {
            const option = document.createElement('option');
            option.value = tahun;
            option.textContent = tahun;
            tahunSelect.appendChild(option);
        });
    }
</script>
@endsection