@extends('layouts.app')

@push('styles')
<style>
    .dashboard-wrapper {
        width: 100%;
    }

    .dashboard-header { 
        margin-bottom: 25px; 
    }
    .header-meta { 
        font-size: 13px; 
        color: #6B7280; 
        margin-bottom: 4px; 
        font-weight: 400;
        display: block;
    }
    .header-title { 
        font-size: 26px; 
        font-weight: 700; 
        color: #111827; 
        margin: 0; 
        letter-spacing: -0.5px;
        line-height: 1.2;
    }
    .header-desc { 
        font-size: 14px; 
        color: #6B7280; 
        margin-top: 4px;
        display: block;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
        margin-bottom: 25px;
    }
    .stat-box {
        background: #fff;
        height: 160px;
        border-radius: 20px;
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: flex-end;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        padding: 25px;
        border: 1px solid #F3F4F6;
    }
    .stat-box .icon-wrap {
        position: absolute;
        top: 20px;
        left: 20px;
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 22px;
    }
    .stat-value {
        font-size: 32px;
        font-weight: 800;
        margin: 0;
        color: #111827;
    }
    .stat-label {
        font-size: 12px;
        color: #6B7280;
        margin: 5px 0 0 0;
        text-align: center;
    }
    .stat-sub {
        font-size: 11px;
        color: #9CA3AF;
        margin-top: 4px;
    }

    .status-panel {
        background: white;
        border-radius: 20px;
        padding: 20px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        border: 1px solid #F3F4F6;
        margin-bottom: 20px;
        display: flex;
        gap: 30px;
        justify-content: center;
    }
    .indicator { 
        display: flex; 
        align-items: center; 
        gap: 8px; 
        font-size: 13px; 
        font-weight: 600; 
        transition: all 0.3s ease;
    }
    .dot { 
        width: 10px; 
        height: 10px; 
        border-radius: 50%; 
        transition: all 0.3s ease;
    }

    .alert-banner {
        display: flex;
        align-items: center;
        padding: 16px 20px;
        border-radius: 15px;
        color: white;
        font-size: 14px;
        font-weight: 700;
        transition: all 0.3s ease;
    }
    
    .timer-container {
        background: #F3E8FF;
        border-radius: 15px;
        padding: 15px 20px;
        margin-top: 20px;
        text-align: center;
    }
    .timer-label {
        font-size: 12px;
        color: #4D0B87;
        font-weight: 600;
        margin-bottom: 5px;
    }
    .timer-value {
        font-size: 28px;
        font-weight: 800;
        color: #4D0B87;
        font-family: monospace;
    }
    .timer-note {
        font-size: 10px;
        color: #6B7280;
        margin-top: 5px;
    }
</style>
@endpush

@section('content')
<div class="dashboard-wrapper">

    {{-- HEADER DASHBOARD --}}
    <div class="dashboard-header">
        <span class="header-meta">{{ \Carbon\Carbon::now()->translatedFormat('F Y') }}</span>
        <h1 class="header-title">Dashboard Tentor</h1>
        <span class="header-desc">Selamat Datang, {{ $nama_tentor ?? 'Tentor' }}!</span>
    </div>

    {{-- KARTU STATISTIK --}}
    <div class="stats-grid">
        <div class="stat-box">
            <div class="icon-wrap" style="background: #4D0B87;">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div class="stat-value">{{ $total_hadir ?? 0 }} Kali</div>
            <div class="stat-label">TOTAL HADIR BULAN INI</div>
        </div>

        <div class="stat-box">
            <div class="icon-wrap" style="background: #F59E0B;">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-value" id="totalJamDisplay">{{ $total_jam_formatted ?? '0 Jam 0 Menit' }}</div>
            <div class="stat-label">TOTAL JAM MENGAJAR</div>
            <div class="stat-sub">(Akumulasi semua sesi)</div>
        </div>
    </div>

    {{-- INDIKATOR STATUS (BERUBAH SESUAI KONDISI) --}}
    <div class="status-panel">
        <div class="indicator" id="indicatorBelum">
            <div class="dot" style="background: {{ $status_hari_ini == 'belum' ? '#EF4444' : '#D1D5DB' }};"></div>
            <span style="color: {{ $status_hari_ini == 'belum' ? '#EF4444' : '#9CA3AF' }};">Belum Presensi</span>
        </div>
        <div class="indicator" id="indicatorSedang">
            <div class="dot" style="background: {{ $status_hari_ini == 'sedang' ? '#F59E0B' : '#D1D5DB' }};"></div>
            <span style="color: {{ $status_hari_ini == 'sedang' ? '#F59E0B' : '#9CA3AF' }};">Sedang Mengajar</span>
        </div>
        <div class="indicator" id="indicatorSelesai">
            <div class="dot" style="background: {{ $status_hari_ini == 'selesai' ? '#10B981' : '#D1D5DB' }};"></div>
            <span style="color: {{ $status_hari_ini == 'selesai' ? '#10B981' : '#9CA3AF' }};">Selesai Sesi</span>
        </div>
    </div>

    {{-- BANNER NOTIFIKASI DINAMIS --}}
    @if($status_hari_ini == 'belum')
    <div class="alert-banner" style="background: #EF4444;" id="alertBanner">
        <i class="fas fa-exclamation-triangle" style="margin-right: 12px; font-size: 18px;"></i>
        Silakan lakukan presensi masuk terlebih dahulu untuk memulai sesi mengajar hari ini.
    </div>
    @elseif($status_hari_ini == 'sedang')
    <div class="alert-banner" style="background: #F59E0B;" id="alertBanner">
        <i class="fas fa-chalkboard-teacher" style="margin-right: 12px; font-size: 18px;"></i>
        Anda sedang dalam sesi mengajar. Jangan lupa isi laporan dan presensi keluar setelah selesai!
    </div>
    
    {{-- TIMER REALTIME --}}
    <div class="timer-container" id="timerContainer">
        <div class="timer-label">
            <i class="fas fa-hourglass-half"></i> Durasi Mengajar Hari Ini
        </div>
        <div class="timer-value" id="realtimeTimer">
            {{ $durasi_berjalan ?? '0 jam 0 menit' }}
        </div>
        <div class="timer-note">
            Mulai mengajar pada: {{ $jam_mulai ? $jam_mulai->format('H:i:s') : '-' }}
        </div>
    </div>
    @else
    <div class="alert-banner" style="background: #10B981;" id="alertBanner">
        <i class="fas fa-check-circle" style="margin-right: 12px; font-size: 18px;"></i>
        Sesi mengajar hari ini telah selesai. Terima kasih!
    </div>
    @endif

</div>

@if($status_hari_ini == 'sedang' && $jam_mulai)
<script>
    // Timer realtime untuk menghitung durasi mengajar
    let startTime = new Date('{{ $jam_mulai->format('Y-m-d H:i:s') }}');
    let totalMenitSebelumnya = {{ $total_menit ?? 0 }};
    let timerInterval;
    
    function updateTimer() {
        let now = new Date();
        let diffMs = now - startTime;
        let diffMenit = Math.floor(diffMs / (1000 * 60));
        let diffJam = Math.floor(diffMenit / 60);
        let diffMenitSisa = diffMenit % 60;
        
        let timerText = diffJam + ' jam ' + diffMenitSisa + ' menit';
        let timerElement = document.getElementById('realtimeTimer');
        if (timerElement) {
            timerElement.innerHTML = timerText;
        }
        
        // Update total jam mengajar (akumulasi)
        let totalMenitBaru = totalMenitSebelumnya + diffMenit;
        let totalJamBaru = Math.floor(totalMenitBaru / 60);
        let totalMenitSisaBaru = totalMenitBaru % 60;
        let totalDisplay = totalJamBaru + ' Jam ' + totalMenitSisaBaru + ' Menit';
        let totalDisplayElement = document.getElementById('totalJamDisplay');
        if (totalDisplayElement) {
            totalDisplayElement.innerHTML = totalDisplay;
        }
    }
    
    // Update timer setiap detik
    timerInterval = setInterval(updateTimer, 1000);
    updateTimer();
    
    // Hentikan timer saat halaman ditutup
    window.addEventListener('beforeunload', function() {
        if (timerInterval) {
            clearInterval(timerInterval);
        }
    });
</script>
@endif

{{-- Script untuk update status secara realtime via AJAX --}}
<script>
    // Cek status setiap 10 detik untuk update indicator dan banner
    let statusInterval = setInterval(function() {
        fetch('{{ route("tentor.presensi.cek-status") }}')
            .then(response => response.json())
            .then(data => {
                let newStatus = 'belum';
                if (data.has_laporan && data.has_presensi_masuk) {
                    newStatus = 'sedang';
                } else if (data.has_presensi_masuk && !data.has_laporan) {
                    newStatus = 'sedang';
                } else if (!data.has_presensi_masuk) {
                    newStatus = 'belum';
                }
                
                if (data.data && data.data.jam_keluar) {
                    newStatus = 'selesai';
                }
                
                updateIndicators(newStatus);
                
                if (newStatus === 'selesai' && '{{ $status_hari_ini }}' !== 'selesai') {
                    location.reload();
                }
            })
            .catch(error => console.log('Error cek status:', error));
    }, 10000);
    
    function updateIndicators(status) {
        const belumDot = document.querySelector('#indicatorBelum .dot');
        const belumText = document.querySelector('#indicatorBelum span');
        if (status === 'belum') {
            belumDot.style.background = '#EF4444';
            belumText.style.color = '#EF4444';
        } else {
            belumDot.style.background = '#D1D5DB';
            belumText.style.color = '#9CA3AF';
        }
        
        const sedangDot = document.querySelector('#indicatorSedang .dot');
        const sedangText = document.querySelector('#indicatorSedang span');
        if (status === 'sedang') {
            sedangDot.style.background = '#F59E0B';
            sedangText.style.color = '#F59E0B';
        } else {
            sedangDot.style.background = '#D1D5DB';
            sedangText.style.color = '#9CA3AF';
        }
        
        const selesaiDot = document.querySelector('#indicatorSelesai .dot');
        const selesaiText = document.querySelector('#indicatorSelesai span');
        if (status === 'selesai') {
            selesaiDot.style.background = '#10B981';
            selesaiText.style.color = '#10B981';
        } else {
            selesaiDot.style.background = '#D1D5DB';
            selesaiText.style.color = '#9CA3AF';
        }
    }
</script>
@endsection