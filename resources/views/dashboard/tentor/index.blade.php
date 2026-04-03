{{-- =============================================
     Dashboard - Tentor
     File: resources/views/dashboard/tentor/index.blade.php
============================================= --}}

@extends('layouts.app')

@push('styles')
<style>
    /* ── DASHBOARD HEADER ── */
    .dashboard-header { margin-bottom: 24px; }
    .dashboard-header .month { font-size: 13px; color: #888; font-weight: 500; margin-bottom: 4px; }
    .dashboard-header h1 { font-size: 26px; font-weight: 800; color: #1a1a2e; margin-bottom: 4px; }
    .dashboard-header p { font-size: 13px; color: #888; }

    /* ── STAT CARDS ── */
    .stats-grid-tentor {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
        margin-bottom: 24px;
    }
    .stat-card-tentor {
        background: #fff;
        border-radius: 16px;
        padding: 28px 24px;
        display: flex;
        align-items: center;
        gap: 18px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.06);
        transition: transform 0.2s, box-shadow 0.2s;
        cursor: default;
    }
    .stat-card-tentor:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.10);
    }
    .stat-card-tentor .s-icon {
        font-size: 2rem;
        color: #1a1a2e;
    }
    .stat-card-tentor .s-info h3 {
        font-size: 24px;
        font-weight: 800;
        color: #1a1a2e;
        margin: 0 0 4px;
    }
    .stat-card-tentor .s-info p {
        font-size: 13px;
        color: #888;
        margin: 0;
        line-height: 1.4;
    }

    /* ── STATUS PANEL ── */
    .status-panel {
        background: #f0ebff;
        border-radius: 16px;
        padding: 18px 24px;
        display: flex;
        align-items: center;
        gap: 32px;
        margin-bottom: 16px;
        flex-wrap: wrap;
    }
    .status-item {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 14px;
        font-weight: 500;
        color: #1a1a2e;
    }
    .status-dot {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        flex-shrink: 0;
        box-shadow: 0 2px 6px rgba(0,0,0,0.2);
    }
    .dot-red    { background: #e53935; }
    .dot-yellow { background: #f5c518; }
    .dot-green  { background: #34a853; }

    /* ── ALERT ── */
    .alert-presensi {
        font-size: 14px;
        font-weight: 600;
        color: #e53935;
        padding: 4px 0 0 2px;
    }

    /* ── RESPONSIVE ── */
    @media (max-width: 640px) {
        .stats-grid-tentor { grid-template-columns: 1fr; }
        .status-panel { gap: 16px; }
    }
</style>
@endpush

@section('content')

    {{-- ── DASHBOARD HEADER ── --}}
    <div class="dashboard-header">
        <div class="month">{{ \Carbon\Carbon::now()->translatedFormat('F Y') }}</div>
        <h1>Dashboard Tentor</h1>
        <p>Selamat Datang di Sistem Manajemen Bimbel Privat</p>
    </div>

    {{-- ── STAT CARDS ── --}}
    <div class="stats-grid-tentor">

        <div class="stat-card-tentor">
            <div class="s-icon">
                <i class="fas fa-person-chalkboard"></i>
            </div>
            <div class="s-info">
                <h3>{{ $total_hadir }} Kali</h3>
                <p>Total Hadir Bulan Ini</p>
            </div>
        </div>

        <div class="stat-card-tentor">
            <div class="s-icon">
                <i class="fas fa-clock"></i>
            </div>
            <div class="s-info">
                <h3>{{ $total_jam }} Jam</h3>
                <p>Total Jam Mengajar Bulan Ini</p>
            </div>
        </div>

    </div>
    {{-- end stats-grid-tentor --}}

    {{-- ── STATUS PRESENSI ── --}}
    <div class="status-panel">
        <div class="status-item">
            <div class="status-dot dot-red"></div>
            <span>Belum Presensi</span>
        </div>
        <div class="status-item">
            <div class="status-dot dot-yellow"></div>
            <span>Sedang Mengajar</span>
        </div>
        <div class="status-item">
            <div class="status-dot dot-green"></div>
            <span>Selesai</span>
        </div>
    </div>

    {{-- ── ALERT STATUS HARI INI ── --}}
    @if($status_hari_ini === 'belum')
        <p class="alert-presensi">
            <i class="fas fa-circle-exclamation"></i>
            Silahkan lakukan presensi masuk terlebih dahulu
        </p>
    @elseif($status_hari_ini === 'mengajar')
        <p class="alert-presensi" style="color: #f5c518;">
            <i class="fas fa-circle-info"></i>
            Anda sedang dalam sesi mengajar
        </p>
    @elseif($status_hari_ini === 'selesai')
        <p class="alert-presensi" style="color: #34a853;">
            <i class="fas fa-circle-check"></i>
            Presensi hari ini sudah selesai. Terima kasih!
        </p>
    @endif

@endsection