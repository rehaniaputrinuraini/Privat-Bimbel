@extends('layouts.app')

@section('title', 'Pembayaran')

@push('styles')
<style>
    .filter-select {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%239CA3AF' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 14px center;
        padding-right: 38px !important;
    }

    .tab-item {
        flex: 1;
        padding: 14px 20px;
        cursor: pointer;
        font-weight: 700;
        font-size: 15px;
        text-align: center;
        position: relative;
        bottom: -2px;
        transition: 0.3s;
        color: #9CA3AF;
    }
</style>
@endpush

@section('content')
<div x-data="{ tab: 'tagihan' }" style="width: 100%;">

    {{-- HEADER HALAMAN --}}
    <div style="margin-bottom: 25px;">
        <p style="color: #374151; font-size: 13px; margin: 0 0 4px 0;">
            {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}
        </p>
        <h1 style="font-size: 26px; font-weight: 700; color: #111827; margin: 0; letter-spacing: -0.5px; line-height: 1.2;">
            Pembayaran
        </h1>
        <p style="color: #374151; font-size: 14px; margin: 4px 0 0 0;">Kelola Pembayaran Murid dan Riwayat Pembayaran</p>
    </div>

    {{-- ACTIONS BAR --}}
    <div style="display: flex; justify-content: flex-end; align-items: center; margin-bottom: 25px;">
        <a href="{{ route($role . '.pembayaran.create') }}" style="text-decoration: none;">
            <button style="background-color: #4D0B87; color: white; border: none; padding: 12px 25px; border-radius: 12px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 10px; font-size: 14px; transition: 0.3s; box-shadow: 0 4px 6px rgba(77, 11, 135, 0.2);">
                <i class="fas fa-plus"></i> Input Pembayaran Murid
            </button>
        </a>
    </div>

    {{-- NAVIGASI TAB --}}
    <div style="display: flex; width: 100%; border-bottom: 2px solid #E5E7EB; margin-bottom: 25px;">
        <div class="tab-item"
             @click="tab = 'tagihan'"
             :style="tab === 'tagihan' ? 'border-bottom: 3px solid #4D0B87; color: #4D0B87;' : 'color: #9CA3AF;'">
            Tagihan Murid
        </div>
        <div class="tab-item"
             @click="tab = 'riwayat'"
             :style="tab === 'riwayat' ? 'border-bottom: 3px solid #4D0B87; color: #4D0B87;' : 'color: #9CA3AF;'">
            Riwayat Pembayaran
        </div>
    </div>

    {{-- TAB 1: TAGIHAN MURID --}}
    <div x-show="tab === 'tagihan'" x-transition:enter.duration.300ms>

        {{-- Filter Card --}}
        <div style="background: white; border-radius: 16px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.06); border: 1px solid #F3F4F6; margin-bottom: 20px;">
            <div style="position: relative; margin-bottom: 12px;">
                <i class="fas fa-search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #9CA3AF;"></i>
                <input type="text" id="searchTagihan" placeholder="Cari Nama Murid..."
                       style="width: 100%; padding: 12px 15px 12px 45px; border-radius: 12px; border: 1px solid #E5E7EB; outline: none; background: #F9FAFB; font-size: 14px; color: #374151;">
            </div>
            <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                <select id="filterPaket" class="filter-select" style="flex: 1; padding: 10px 14px; border-radius: 12px; border: 1px solid #E5E7EB; color: #374151; font-size: 13px; background: #F9FAFB; outline: none; cursor: pointer; min-width: 150px;">
                    <option value="">Status Paket</option>
                    <option value="SD">SD</option>
                    <option value="SMP">SMP</option>
                    <option value="SMA">SMA</option>
                </select>
                <select id="filterPembayaran" class="filter-select" style="flex: 1; padding: 10px 14px; border-radius: 12px; border: 1px solid #E5E7EB; color: #374151; font-size: 13px; background: #F9FAFB; outline: none; cursor: pointer; min-width: 150px;">
                    <option value="">Status Pembayaran</option>
                    <option value="Lunas">Lunas</option>
                    <option value="Belum">Belum</option>
                </select>
                <select id="filterTagihan" class="filter-select" style="flex: 1; padding: 10px 14px; border-radius: 12px; border: 1px solid #E5E7EB; color: #374151; font-size: 13px; background: #F9FAFB; outline: none; cursor: pointer; min-width: 150px;">
                    <option value="">Status Tagihan</option>
                    <option value="Lunas">Lunas</option>
                    <option value="Tunggak">Tunggak</option>
                    <option value="Uang Muka">Uang Muka</option>
                </select>
            </div>
        </div>

        {{-- Tabel Tagihan --}}
        <div style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.08); border: 1px solid #F3F4F6;">
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 13px; white-space: nowrap;">
                    <thead>
                        <tr style="background: #F3E8FF; color: #111827;">
                            <th style="padding: 15px; font-weight: 700; width: 50px;">No</th>
                            <th style="padding: 15px; font-weight: 700;">Nama Lengkap</th>
                            <th style="padding: 15px; font-weight: 700;">Kelas</th>
                            <th style="padding: 15px; font-weight: 700;">Status Paket</th>
                            <th style="padding: 15px; font-weight: 700; text-align: center;">Status Pembayaran</th>
                            <th style="padding: 15px; font-weight: 700; text-align: center;">Status Tagihan</th>
                            <th style="padding: 15px; font-weight: 700; text-align: center;">Total Bulan</th>
                            <th style="padding: 15px; font-weight: 700; text-align: center;">Total Piutang</th>
                            <th style="padding: 15px; font-weight: 700; text-align: center;">Total Uang Muka</th>
                        </tr>
                    </thead>
                    <tbody id="tagihanTableBody" style="color: #374151;">
                        @forelse($tagihan as $index => $t)
                        <tr style="border-bottom: 1px solid #F3F4F6; transition: 0.2s;"
                            onmouseover="this.style.background='#F9FAFB'"
                            onmouseout="this.style.background='transparent'">
                            <td style="padding: 15px;">{{ $index + 1 }}</td>
                            <td style="padding: 15px;">{{ $t->nama }}</td>
                            <td style="padding: 15px;">{{ $t->kelas }}</td>
                            <td style="padding: 15px;">{{ $t->paket }}</td>
                            <td style="padding: 15px; text-align: center;">
                                @if($t->status_pembayaran == 'Lunas')
                                    <span style="padding: 5px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; background: #E1F7E3; color: #0E7490;">Lunas</span>
                                @else
                                    <span style="padding: 5px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; background: #FEE2E2; color: #EF4444;">Belum</span>
                                @endif
                            </td>
                            <td style="padding: 15px; text-align: center;">
                                @if($t->status_tagihan == 'Lunas')
                                    <span style="padding: 5px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; background: #E1F7E3; color: #0E7490;">Lunas</span>
                                @elseif(str_contains($t->status_tagihan, 'Tunggak'))
                                    <span style="padding: 5px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; background: #FEF3C7; color: #92400E;">{{ $t->status_tagihan }}</span>
                                @else
                                    <span style="padding: 5px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; background: #E0E7FF; color: #4338CA;">{{ $t->status_tagihan }}</span>
                                @endif
                            </td>
                            <td style="padding: 15px; text-align: center;">{{ $t->total_bulan }}</td>
                            <td style="padding: 15px; text-align: center; {{ $t->total_piutang != '-' ? 'font-weight: 700; color: #EF4444;' : '' }}">{{ $t->total_piutang }}</td>
                            <td style="padding: 15px; text-align: center;">{{ $t->uang_muka }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" style="padding: 30px; text-align: center; color: #6B7280;">Belum ada data tagihan</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination Tagihan (SAMA PERSIS DENGAN KELOLA ADMIN) --}}
        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px; padding: 0 5px;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <select id="perPageTagihan" style="padding: 8px 12px; border-radius: 10px; border: 1px solid #E5E7EB; color: #374151; font-size: 13px; background: white; outline: none; cursor: pointer; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                    <option value="10">10 baris</option>
                    <option value="25">25 baris</option>
                    <option value="50">50 baris</option>
                </select>
                <span style="color: #374151; font-size: 13px;">Menampilkan {{ $tagihan->count() }} data</span>
            </div>

            <div style="display: flex; gap: 5px;">
                <button class="page-btn-tagihan" data-page="first" style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; cursor: pointer;"><i class="fas fa-angle-double-left"></i></button>
                <button class="page-btn-tagihan" data-page="prev" style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; cursor: pointer;"><i class="fas fa-angle-left"></i></button>
                <button class="page-btn-tagihan active" data-page="1" style="width: 35px; height: 35px; border-radius: 8px; background: #4D0B87; color: white; border: none; font-weight: 600; cursor: pointer;">1</button>
                <button class="page-btn-tagihan" data-page="next" style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; cursor: pointer;"><i class="fas fa-angle-right"></i></button>
            </div>
        </div>

    </div>

    {{-- TAB 2: RIWAYAT PEMBAYARAN --}}
    <div x-show="tab === 'riwayat'" x-transition:enter.duration.300ms>

        {{-- Filter Card --}}
        <div style="background: white; border-radius: 16px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.06); border: 1px solid #F3F4F6; margin-bottom: 20px;">
            <div style="position: relative; margin-bottom: 12px;">
                <i class="fas fa-search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #9CA3AF;"></i>
                <input type="text" id="searchRiwayat" placeholder="Cari Nama Murid..."
                       style="width: 100%; padding: 12px 15px 12px 45px; border-radius: 12px; border: 1px solid #E5E7EB; outline: none; background: #F9FAFB; font-size: 14px; color: #374151;">
            </div>
            <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                <select id="filterPaketRiwayat" class="filter-select" style="flex: 1; padding: 10px 14px; border-radius: 12px; border: 1px solid #E5E7EB; color: #374151; font-size: 13px; background: #F9FAFB; outline: none; cursor: pointer; min-width: 150px;">
                    <option value="">Status Paket</option>
                    <option value="SD">SD</option>
                    <option value="SMP">SMP</option>
                    <option value="SMA">SMA</option>
                </select>
                <select id="filterBulan" class="filter-select" style="flex: 1; padding: 10px 14px; border-radius: 12px; border: 1px solid #E5E7EB; color: #374151; font-size: 13px; background: #F9FAFB; outline: none; cursor: pointer; min-width: 150px;">
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
                <select id="filterTahun" class="filter-select" style="flex: 1; padding: 10px 14px; border-radius: 12px; border: 1px solid #E5E7EB; color: #374151; font-size: 13px; background: #F9FAFB; outline: none; cursor: pointer; min-width: 150px;">
                    <option value="">Pilih Tahun</option>
                    @php
                        $tahunList = $riwayat->pluck('tanggal')->map(function($date) {
                            return explode('/', $date)[2] ?? null;
                        })->filter()->unique()->sort()->values();
                    @endphp
                    @foreach($tahunList as $tahun)
                        <option value="{{ $tahun }}">{{ $tahun }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Tabel Riwayat --}}
        <div style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.08); border: 1px solid #F3F4F6;">
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 13px; white-space: nowrap;">
                    <thead>
                        <tr style="background: #F3E8FF; color: #111827;">
                            <th style="padding: 15px; font-weight: 700; width: 50px;">No</th>
                            <th style="padding: 15px; font-weight: 700;">Tanggal</th>
                            <th style="padding: 15px; font-weight: 700;">Nama Murid</th>
                            <th style="padding: 15px; font-weight: 700;">Paket Awal</th>
                            <th style="padding: 15px; font-weight: 700;">Paket Selanjutnya</th>
                            <th style="padding: 15px; font-weight: 700; text-align: center;">Total Bayar</th>
                            <th style="padding: 15px; font-weight: 700;">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody id="riwayatTableBody" style="color: #374151;">
                        @forelse($riwayat as $index => $r)
                        <tr style="border-bottom: 1px solid #F3F4F6; transition: 0.2s;"
                            onmouseover="this.style.background='#F9FAFB'"
                            onmouseout="this.style.background='transparent'">
                            <td style="padding: 15px;">{{ $index + 1 }}</td>
                            <td style="padding: 15px;">{{ $r->tanggal }}</td>
                            <td style="padding: 15px;">{{ $r->nama_murid }}</td>
                            <td style="padding: 15px;">Rp {{ $r->paket_awal }}</td>
                            <td style="padding: 15px;">{{ $r->paket_selanjutnya }}</td>
                            <td style="padding: 15px; text-align: center; font-weight: 700; color: #4D0B87;">{{ $r->total_bayar }}</td>
                            <td style="padding: 15px;">{{ $r->keterangan }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" style="padding: 30px; text-align: center; color: #6B7280;">Belum ada data riwayat pembayaran</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination Riwayat (SAMA PERSIS DENGAN KELOLA ADMIN) --}}
        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px; padding: 0 5px;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <select id="perPageRiwayat" style="padding: 8px 12px; border-radius: 10px; border: 1px solid #E5E7EB; color: #374151; font-size: 13px; background: white; outline: none; cursor: pointer; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                    <option value="10">10 baris</option>
                    <option value="25">25 baris</option>
                    <option value="50">50 baris</option>
                </select>
                <span style="color: #374151; font-size: 13px;">Menampilkan {{ $riwayat->count() }} data</span>
            </div>

            <div style="display: flex; gap: 5px;">
                <button class="page-btn-riwayat" data-page="first" style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; cursor: pointer;"><i class="fas fa-angle-double-left"></i></button>
                <button class="page-btn-riwayat" data-page="prev" style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; cursor: pointer;"><i class="fas fa-angle-left"></i></button>
                <button class="page-btn-riwayat active" data-page="1" style="width: 35px; height: 35px; border-radius: 8px; background: #4D0B87; color: white; border: none; font-weight: 600; cursor: pointer;">1</button>
                <button class="page-btn-riwayat" data-page="next" style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; cursor: pointer;"><i class="fas fa-angle-right"></i></button>
            </div>
        </div>

    </div>

</div>

<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<script>
    // ========== FILTER TABEL TAGIHAN ==========
    function filterTagihan() {
        const searchValue = document.getElementById('searchTagihan')?.value.toLowerCase() || '';
        const filterPaket = document.getElementById('filterPaket')?.value || '';
        const filterPembayaran = document.getElementById('filterPembayaran')?.value || '';
        const filterTagihanStatus = document.getElementById('filterTagihan')?.value || '';
        
        const rows = document.querySelectorAll('#tagihanTableBody tr');
        let visibleCount = 0;
        
        rows.forEach(row => {
            if (!row.cells || row.cells.length < 9) return;
            
            const nama = row.cells[1]?.innerText.toLowerCase() || '';
            const paket = row.cells[3]?.innerText || '';
            const statusPembayaran = row.cells[4]?.innerText.trim() || '';
            const statusTagihan = row.cells[5]?.innerText.trim() || '';
            
            let show = true;
            
            if (searchValue && !nama.includes(searchValue)) show = false;
            if (filterPaket && paket !== filterPaket) show = false;
            if (filterPembayaran && statusPembayaran !== filterPembayaran) show = false;
            if (filterTagihanStatus) {
                if (filterTagihanStatus === 'Tunggak' && !statusTagihan.includes('Tunggak')) show = false;
                else if (filterTagihanStatus === 'Uang Muka' && statusTagihan !== 'Uang Muka 1 Bln') show = false;
                else if (filterTagihanStatus === 'Lunas' && statusTagihan !== 'Lunas') show = false;
            }
            
            row.style.display = show ? '' : 'none';
            if (show) visibleCount++;
        });
        
        const infoSpan = document.querySelector('#tagihanTableBody').closest('.tab-item') ? 
            document.querySelector('#tagihanCountInfo') : null;
        if (infoSpan) infoSpan.innerText = `Menampilkan ${visibleCount} data`;
    }
    
    // ========== FILTER TABEL RIWAYAT ==========
    function filterRiwayat() {
        const searchValue = document.getElementById('searchRiwayat')?.value.toLowerCase() || '';
        const filterPaket = document.getElementById('filterPaketRiwayat')?.value || '';
        const filterBulan = document.getElementById('filterBulan')?.value || '';
        const filterTahun = document.getElementById('filterTahun')?.value || '';
        
        const rows = document.querySelectorAll('#riwayatTableBody tr');
        let visibleCount = 0;
        
        rows.forEach(row => {
            if (!row.cells || row.cells.length < 7) return;
            
            const nama = row.cells[2]?.innerText.toLowerCase() || '';
            const paket = row.cells[4]?.innerText || '';
            const tanggal = row.cells[1]?.innerText || '';
            
            const parts = tanggal.split('/');
            const bulan = parts[1] ? parseInt(parts[1]) : 0;
            const tahun = parts[2] ? parseInt(parts[2]) : 0;
            
            let show = true;
            
            if (searchValue && !nama.includes(searchValue)) show = false;
            if (filterPaket && paket !== filterPaket) show = false;
            if (filterBulan && bulan !== parseInt(filterBulan)) show = false;
            if (filterTahun && tahun !== parseInt(filterTahun)) show = false;
            
            row.style.display = show ? '' : 'none';
            if (show) visibleCount++;
        });
        
        const infoSpan = document.getElementById('riwayatCountInfo');
        if (infoSpan) infoSpan.innerText = `Menampilkan ${visibleCount} data`;
    }
    
    // ========== PAGINATION CLIENT SIDE (SEDERHANA) ==========
    let tagihanCurrentPage = 1;
    let tagihanPerPage = 10;
    let riwayatCurrentPage = 1;
    let riwayatPerPage = 10;
    
    function updateTagihanPagination() {
        const rows = document.querySelectorAll('#tagihanTableBody tr');
        const totalRows = rows.length;
        const totalPages = Math.ceil(totalRows / tagihanPerPage);
        
        // Sembunyikan semua row dulu
        rows.forEach((row, index) => {
            const start = (tagihanCurrentPage - 1) * tagihanPerPage;
            const end = start + tagihanPerPage;
            if (index >= start && index < end) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
        
        // Update tombol pagination
        const btns = document.querySelectorAll('.page-btn-tagihan');
        btns.forEach(btn => {
            btn.style.background = 'white';
            btn.style.color = '#374151';
            btn.style.border = '1px solid #E5E7EB';
        });
        
        const activeBtn = document.querySelector(`.page-btn-tagihan[data-page="${tagihanCurrentPage}"]`);
        if (activeBtn) {
            activeBtn.style.background = '#4D0B87';
            activeBtn.style.color = 'white';
            activeBtn.style.border = 'none';
        }
        
        // Update info jumlah data yang ditampilkan
        let visibleCount = 0;
        rows.forEach(row => {
            if (row.style.display !== 'none') visibleCount++;
        });
        const infoSpan = document.querySelector('#tagihanTableBody').closest('div').querySelector('.page-btn-tagihan')?.closest('.page-btn-tagihan') ?
            null : document.getElementById('tagihanCountInfo');
        if (infoSpan) infoSpan.innerText = `Menampilkan ${visibleCount} data`;
    }
    
    function updateRiwayatPagination() {
        const rows = document.querySelectorAll('#riwayatTableBody tr');
        const totalRows = rows.length;
        const totalPages = Math.ceil(totalRows / riwayatPerPage);
        
        rows.forEach((row, index) => {
            const start = (riwayatCurrentPage - 1) * riwayatPerPage;
            const end = start + riwayatPerPage;
            if (index >= start && index < end) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
        
        const btns = document.querySelectorAll('.page-btn-riwayat');
        btns.forEach(btn => {
            btn.style.background = 'white';
            btn.style.color = '#374151';
            btn.style.border = '1px solid #E5E7EB';
        });
        
        const activeBtn = document.querySelector(`.page-btn-riwayat[data-page="${riwayatCurrentPage}"]`);
        if (activeBtn) {
            activeBtn.style.background = '#4D0B87';
            activeBtn.style.color = 'white';
            activeBtn.style.border = 'none';
        }
    }
    
    // ========== EVENT LISTENERS ==========
    document.addEventListener('DOMContentLoaded', function() {
        // Tagihan filters
        const searchTagihan = document.getElementById('searchTagihan');
        const filterPaket = document.getElementById('filterPaket');
        const filterPembayaran = document.getElementById('filterPembayaran');
        const filterTagihanStatus = document.getElementById('filterTagihan');
        const perPageTagihan = document.getElementById('perPageTagihan');
        
        if (searchTagihan) searchTagihan.addEventListener('keyup', filterTagihan);
        if (filterPaket) filterPaket.addEventListener('change', filterTagihan);
        if (filterPembayaran) filterPembayaran.addEventListener('change', filterTagihan);
        if (filterTagihanStatus) filterTagihanStatus.addEventListener('change', filterTagihan);
        
        if (perPageTagihan) {
            perPageTagihan.addEventListener('change', function() {
                tagihanPerPage = parseInt(this.value);
                tagihanCurrentPage = 1;
                updateTagihanPagination();
            });
        }
        
        // Riwayat filters
        const searchRiwayat = document.getElementById('searchRiwayat');
        const filterPaketRiwayat = document.getElementById('filterPaketRiwayat');
        const filterBulan = document.getElementById('filterBulan');
        const filterTahun = document.getElementById('filterTahun');
        const perPageRiwayat = document.getElementById('perPageRiwayat');
        
        if (searchRiwayat) searchRiwayat.addEventListener('keyup', filterRiwayat);
        if (filterPaketRiwayat) filterPaketRiwayat.addEventListener('change', filterRiwayat);
        if (filterBulan) filterBulan.addEventListener('change', filterRiwayat);
        if (filterTahun) filterTahun.addEventListener('change', filterRiwayat);
        
        if (perPageRiwayat) {
            perPageRiwayat.addEventListener('change', function() {
                riwayatPerPage = parseInt(this.value);
                riwayatCurrentPage = 1;
                updateRiwayatPagination();
            });
        }
        
        // Pagination button handlers
        document.querySelectorAll('.page-btn-tagihan').forEach(btn => {
            btn.addEventListener('click', function() {
                const page = this.dataset.page;
                const rows = document.querySelectorAll('#tagihanTableBody tr');
                const totalPages = Math.ceil(rows.length / tagihanPerPage);
                
                if (page === 'first') tagihanCurrentPage = 1;
                else if (page === 'prev') tagihanCurrentPage = Math.max(1, tagihanCurrentPage - 1);
                else if (page === 'next') tagihanCurrentPage = Math.min(totalPages, tagihanCurrentPage + 1);
                else tagihanCurrentPage = parseInt(page);
                
                updateTagihanPagination();
            });
        });
        
        document.querySelectorAll('.page-btn-riwayat').forEach(btn => {
            btn.addEventListener('click', function() {
                const page = this.dataset.page;
                const rows = document.querySelectorAll('#riwayatTableBody tr');
                const totalPages = Math.ceil(rows.length / riwayatPerPage);
                
                if (page === 'first') riwayatCurrentPage = 1;
                else if (page === 'prev') riwayatCurrentPage = Math.max(1, riwayatCurrentPage - 1);
                else if (page === 'next') riwayatCurrentPage = Math.min(totalPages, riwayatCurrentPage + 1);
                else riwayatCurrentPage = parseInt(page);
                
                updateRiwayatPagination();
            });
        });
        
        // Initial pagination
        updateTagihanPagination();
        updateRiwayatPagination();
        
        // Fix untuk count info
        const tagihanInfo = document.querySelector('#tagihanTableBody').closest('.tab-item') ? 
            document.querySelector('#tagihanCountInfo') : null;
        if (!tagihanInfo) {
            const newSpan = document.createElement('span');
            newSpan.id = 'tagihanCountInfo';
            newSpan.style.color = '#374151';
            newSpan.style.fontSize = '13px';
            newSpan.innerText = 'Menampilkan data';
            document.querySelector('#tagihanTableBody').closest('div').querySelector('.page-btn-tagihan')?.parentNode?.parentNode?.querySelector('div:first-child')?.appendChild(newSpan);
        }
        
        const riwayatInfo = document.getElementById('riwayatCountInfo');
        if (riwayatInfo) {
            riwayatInfo.innerText = `Menampilkan ${document.querySelectorAll('#riwayatTableBody tr:not([style*="display: none"])').length} data`;
        }
    });
</script>

@endsection