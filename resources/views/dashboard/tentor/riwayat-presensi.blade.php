@extends('layouts.app')

@section('content')
<div class="riwayat-container">
    {{-- Header Halaman --}}
    <div class="dashboard-header" style="margin-bottom: 24px;">
        <div class="month" style="font-size: 13px; color: #888; font-weight: 500;">
            {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}
        </div>
        <h1 style="font-size: 26px; font-weight: 800; color: #1a1a2e; margin-bottom: 4px;">Riwayat Presensi</h1>
        <p style="font-size: 13px; color: #888;">Lihat Riwayat Kehadiran Mengajar Anda</p>
    </div>

    {{-- Filter Bulan --}}
    <div class="filter-card">
        <div class="filter-group">
            <label>Filter Bulan</label>
            <div class="filter-controls">
                <select class="form-control-custom select-bulan">
                    <option value="Maret">Maret</option>
                    <option value="April" selected>April</option>
                </select>
                <button type="button" class="btn-cari">Cari</button>
            </div>
        </div>
    </div>

    {{-- Tabel Riwayat --}}
    <div class="table-card">
        <table class="table-custom">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Kelas</th>
                    <th>Jam Masuk</th>
                    <th>Jam Keluar</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                {{-- Data Dummy 1 --}}
                <tr>
                    <td>11 Maret 2026</td>
                    <td>12-A</td>
                    <td>19.00</td>
                    <td>24.00</td>
                    <td><span class="badge badge-hadir">Hadir</span></td>
                </tr>
                {{-- Data Dummy 2 --}}
                <tr>
                    <td>10 Maret 2026</td>
                    <td>6-G</td>
                    <td>19.00</td>
                    <td>24.00</td>
                    <td><span class="badge badge-tidak-hadir">Tidak Hadir</span></td>
                </tr>
            </tbody>
        </table>

        {{-- Footer Tabel & Pagination --}}
        <div class="table-footer">
            <div class="rows-per-page">
                <select class="form-control-custom">
                    <option>10 baris</option>
                    <option>20 baris</option>
                </select>
            </div>
            <div class="pagination">
                <button class="page-btn"><i class="fas fa-angle-double-left"></i></button>
                <button class="page-btn"><i class="fas fa-angle-left"></i></button>
                <button class="page-btn active">1</button>
                <button class="page-btn"><i class="fas fa-angle-right"></i></button>
            </div>
        </div>
    </div>
</div>

<style>
    /* Global Card Style */
    .filter-card, .table-card {
        background: #fff;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        margin-bottom: 24px;
    }

    /* Filter Styling */
    .filter-group label {
        display: block;
        font-weight: 700;
        font-size: 14px;
        margin-bottom: 12px;
    }
    .filter-controls {
        display: flex;
        gap: 12px;
    }
    .select-bulan {
        width: 100%;
        max-width: 600px;
        padding: 10px 15px;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        outline: none;
        color: #666;
    }
    .btn-cari {
        background-color: #4b1a8d; /* Warna ungu sesuai desain */
        color: white;
        border: none;
        padding: 0 40px;
        border-radius: 10px;
        font-weight: bold;
        cursor: pointer;
    }

    /* Table Styling */
    .table-custom {
        width: 100%;
        border-collapse: collapse;
        text-align: center;
    }
    .table-custom thead {
        background-color: #f3e8ff; /* Ungu muda transparan */
    }
    .table-custom th {
        padding: 15px;
        font-size: 14px;
        font-weight: 700;
        color: #1a1a2e;
    }
    .table-custom td {
        padding: 20px 15px;
        font-size: 13px;
        border-bottom: 1px solid #f3f4f6;
        color: #4b5563;
    }

    /* Badges */
    .badge {
        padding: 8px 24px;
        border-radius: 10px;
        font-weight: 600;
        display: inline-block;
    }
    .badge-hadir {
        background-color: #bbf7d0; /* Hijau muda */
        color: #166534;
    }
    .badge-tidak-hadir {
        background-color: #fee2e2; /* Merah muda */
        color: #991b1b;
    }

    /* Pagination */
    .table-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 24px;
    }
    .page-btn {
        background: #f3f4f6;
        border: none;
        padding: 8px 12px;
        margin: 0 2px;
        border-radius: 6px;
        cursor: pointer;
        color: #666;
    }
    .page-btn.active {
        background: #4b1a8d;
        color: white;
    }
</style>
@endsection