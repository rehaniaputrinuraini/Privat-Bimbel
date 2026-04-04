{{-- =============================================
     Dashboard Tentor - Riwayat Presensi (FINAL SYNC)
     File: resources/views/dashboard/tentor/riwayat.blade.php
============================================= --}}

@extends('layouts.app')

@section('content')
{{-- 
    INFO: Mengandalkan .content-wrapper bawaan (otomatis 25px). 
    Tanpa div padding tambahan agar sejajar lurus dengan sidebar.
--}}
<div style="width: 100%;">

    {{-- ── 1. HEADER HALAMAN (Hirarki Visual Sync) ── --}}
    <div style="margin-bottom: 25px;">
        <p style="color: #6B7280; font-size: 13px; margin: 0 0 4px 0;">
            {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}
        </p>
        <h1 style="font-size: 26px; font-weight: 700; color: #111827; margin: 0; letter-spacing: -0.5px; line-height: 1.2;">
            Riwayat Presensi
        </h1>
        <p style="color: #6B7280; font-size: 14px; margin: 4px 0 0 0;">Lihat riwayat kehadiran mengajar Anda setiap bulannya.</p>
    </div>

    {{-- ── 2. FILTER AREA ── --}}
    <div class="filter-card">
        <div class="filter-group">
            <label>Filter Bulan</label>
            <div class="filter-controls">
                <div style="position: relative; flex: 1; max-width: 400px;">
                    <select class="form-control-custom select-bulan">
                        <option value="Maret">Maret 2026</option>
                        <option value="April" selected>April 2026</option>
                        <option value="Mei">Mei 2026</option>
                    </select>
                    <i class="fas fa-chevron-down" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); color: #9CA3AF; pointer-events: none; font-size: 12px;"></i>
                </div>
                <button type="button" class="btn-cari">
                    <i class="fas fa-search" style="margin-right: 8px;"></i> Cari
                </button>
            </div>
        </div>
    </div>

    {{-- ── 3. TABLE AREA (Shadow & Master Style) ── --}}
    <div class="table-card">
        <div style="overflow-x: auto;">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th style="width: 180px;">Tanggal</th>
                        <th>Kelas</th>
                        <th>Jam Masuk</th>
                        <th>Jam Keluar</th>
                        <th style="width: 150px;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Data Dummy 1 --}}
                    <tr>
                        <td style="font-weight: 600; color: #111827;">11 April 2026</td>
                        <td><span class="badge-kelas">12-A</span></td>
                        <td>19:00</td>
                        <td>20:30</td>
                        <td><span class="badge badge-hadir">Hadir</span></td>
                    </tr>
                    {{-- Data Dummy 2 --}}
                    <tr>
                        <td style="font-weight: 600; color: #111827;">10 April 2026</td>
                        <td><span class="badge-kelas">6-G</span></td>
                        <td>19:00</td>
                        <td>-</td>
                        <td><span class="badge badge-tidak-hadir">Tidak Hadir</span></td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- ── 4. PAGINATION SYNC ── --}}
        <div class="table-footer">
            <div style="color: #6B7280; font-size: 13px;">
                Menampilkan 2 baris data
            </div>
            <div class="pagination-group">
                <button class="page-btn"><i class="fas fa-angle-left"></i></button>
                <button class="page-btn active">1</button>
                <button class="page-btn"><i class="fas fa-angle-right"></i></button>
            </div>
        </div>
    </div>
</div>

<style>
    /* Global Card Style (Sync with Master) */
    .filter-card, .table-card {
        background: #fff;
        border-radius: 20px;
        padding: 25px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        margin-bottom: 25px;
        border: 1px solid #F3F4F6;
    }

    /* Filter Styling */
    .filter-group label {
        display: block;
        font-weight: 700;
        font-size: 12px;
        color: #374151;
        margin-bottom: 10px;
        text-transform: uppercase;
    }
    .filter-controls { display: flex; gap: 15px; }
    
    .form-control-custom {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #E5E7EB;
        border-radius: 12px;
        outline: none;
        color: #4B5563;
        font-size: 14px;
        appearance: none;
        background: #fff;
    }

    .btn-cari {
        background-color: #4D0B87;
        color: white;
        border: none;
        padding: 0 35px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 14px;
        cursor: pointer;
        transition: 0.3s;
    }
    .btn-cari:hover { opacity: 0.9; }

    /* Table Styling (Identik Riwayat Admin) */
    .table-custom { width: 100%; border-collapse: collapse; text-align: center; }
    .table-custom thead { background-color: #F3E8FF; }
    .table-custom th {
        padding: 18px 15px;
        font-size: 13px;
        font-weight: 700;
        color: #111827;
    }
    .table-custom td {
        padding: 18px 15px;
        font-size: 13px;
        border-bottom: 1px solid #F3F4F6;
        color: #4B5563;
    }

    /* Badges & Labels */
    .badge-kelas {
        background: #E0E7FF;
        color: #4338CA;
        padding: 5px 12px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 11px;
    }
    .badge {
        padding: 6px 15px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 11px;
        display: inline-block;
        min-width: 90px;
    }
    .badge-hadir { background-color: #DCFCE7; color: #166534; }
    .badge-tidak-hadir { background-color: #FEE2E2; color: #991B1B; }

    /* Pagination */
    .table-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 25px;
    }
    .pagination-group { display: flex; gap: 5px; }
    .page-btn {
        width: 35px;
        height: 35px;
        border-radius: 8px;
        border: 1px solid #E5E7EB;
        background: white;
        color: #6B7280;
        cursor: pointer;
        font-size: 13px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: 0.3s;
    }
    .page-btn.active {
        background: #4D0B87;
        color: white;
        border: none;
        font-weight: 600;
    }
</style>
@endsection