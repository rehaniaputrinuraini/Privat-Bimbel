@extends('layouts.app')

@section('content')
<div class="dashboard-header">
    <div class="month">{{ \Carbon\Carbon::now()->translatedFormat('F Y') }}</div>
    <h1>Dashboard {{ ucfirst($role ?? 'Admin') }}</h1>
    <p>Selamat Datang di Sistem Manajemen Bimbel Privat</p>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon icon-purple"></div>
        <div>
            <div class="stat-value">{{ $stats['total_murid'] ?? 0 }}</div>
            <div class="stat-label">Total Murid</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon icon-orange"></div>
        <div>
            <div class="stat-value">{{ $stats['total_tentor'] ?? 0 }}</div>
            <div class="stat-label">Total Tentor</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon icon-green"></div>
        <div>
            <div class="stat-value">Rp {{ number_format($stats['pemasukan'] ?? 0, 0, ',', '.') }}</div>
            <div class="stat-label">Pemasukan</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon icon-red"></div>
        <div>
            <div class="stat-value">Rp {{ number_format($stats['pengeluaran'] ?? 0, 0, ',', '.') }}</div>
            <div class="stat-label">Pengeluaran</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon icon-gold"></div>
        <div>
            <div class="stat-value">Rp {{ number_format($stats['laba_bersih'] ?? 0, 0, ',', '.') }}</div>
            <div class="stat-label">Laba Bersih</div>
        </div>
    </div>
</div>

<div class="finance-panel">
    <div class="finance-header">
        <h2>Rincian Keuangan Terakhir</h2>
        <a href="{{ route('admin.laporan-keuangan') }}" class="lihat-semua">Lihat Semua</a>
    </div>
    <div class="finance-list">
        @forelse (($keuangan ?? []) as $item)
            <div class="finance-row {{ $item['tipe'] === 'pemasukan' ? 'row-green' : 'row-red' }}">
                <span>{{ $item['label'] }}</span>
                <span class="finance-amount">Rp {{ number_format($item['jumlah'], 0, ',', '.') }}</span>
            </div>
        @empty
            <p class="text-muted">Belum ada data keuangan.</p>
        @endforelse
    </div>
</div>
@endsection

@push('styles')
<style>
    .dashboard-header { margin-bottom: 24px; }
    .dashboard-header .month { font-size: 13px; color: #888; margin-bottom: 4px; }
    .dashboard-header h1 { font-size: 26px; font-weight: 800; color: #1a1a2e; margin-bottom: 4px; }
    .dashboard-header p { font-size: 13px; color: #888; }
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 14px;
        margin-bottom: 28px;
    }
    .stat-card {
        background: #fff;
        border-radius: 16px;
        padding: 18px 16px 14px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.06);
    }
    .stat-value { font-size: 20px; font-weight: 800; color: #1a1a2e; }
    .stat-value.small { font-size: 15px; }
    .stat-label { font-size: 11.5px; color: #aaa; margin-top: 2px; }
    .finance-panel {
        background: #fff;
        border-radius: 20px;
        padding: 22px 24px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.06);
    }
    .finance-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 18px;
    }
    .finance-header h2 { font-size: 16px; font-weight: 700; }
    .lihat-semua { font-size: 13px; font-weight: 600; color: #7b5ea7; text-decoration: none; }
    .finance-list { display: flex; flex-direction: column; gap: 10px; }
    .finance-row {
        display: flex;
        justify-content: space-between;
        padding: 14px 20px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 13.5px;
        color: #fff;
    }
    .row-green { background: #34a853; }
    .row-red { background: #e53935; }
    @media (max-width: 1024px) { .stats-grid { grid-template-columns: repeat(3, 1fr); } }
    @media (max-width: 640px) { .stats-grid { grid-template-columns: repeat(2, 1fr); } }
</style>
@endpush