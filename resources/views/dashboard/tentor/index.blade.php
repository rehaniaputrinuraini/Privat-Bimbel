@extends('layouts.app')

@section('title', 'Dashboard Tentor')

@section('content')
<div class="dashboard-tentor">
    <div class="welcome-section">
        <h3>Selamat Datang di Sistem Manajemen Bimbel Privat</h3>
    </div>

    <div class="stats">
        <div class="card">
            <h3>12 Kali</h3>
            <p>Total Hadir Bulan Ini</p>
        </div>
        <div class="card">
            <h3>100 Jam</h3>
            <p>Total Jam Mengajar Bulan Ini</p>
        </div>
    </div>

    <div class="presensi-buttons">
        <button class="btn btn-presensi">Belum Presensi</button>
        <button class="btn btn-mengajar">Sedang Mengajar</button>
        <button class="btn btn-selesai">Selesai</button>
    </div>

    <div class="info">
        <p>Silahkan lakukan presensi masuk terlebih dahulu</p>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.body.classList.add('role-tentor');
    document.querySelector('.user-role-display').innerText = 'Tentor';
    document.querySelector('.profile-info h4').innerText = 'Aidilia Fitriasari';
</script>
@endsection