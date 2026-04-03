@extends('layouts.app')

@section('content')
<div class="presensi-container">
    {{-- Header Halaman --}}
    <div class="dashboard-header" style="margin-bottom: 24px;">
        <div class="month" style="font-size: 13px; color: #888; font-weight: 500;">
            {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}
        </div>
        <h1 style="font-size: 26px; font-weight: 800; color: #1a1a2e;">Presensi</h1>
        <p style="font-size: 13px; color: #888;">Silakan kelola kehadiran sesi mengajar Anda di sini.</p>
    </div>

    <div class="presensi-flex">
        {{-- CARD KIRI: TOMBOL MASUK/KELUAR --}}
        <div class="presensi-card main-card">
            <div class="card-header-custom">
                <h3>Presensi Hari Ini</h3>
                {{-- Menampilkan Maret 2026 sesuai desain dashboard --}}
                <p>{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
            </div>

            <div class="button-group-presensi">
                <button type="button" class="btn-presensi btn-masuk" id="btnMasuk">
                    <i class="fas fa-sign-in-alt"></i> Masuk
                </button>

                <button type="button" class="btn-presensi btn-keluar" id="btnKeluar" disabled>
                    <i class="fas fa-sign-out-alt"></i> Keluar
                </button>
            </div>

            <p class="presensi-info">
                Presensi keluar bisa dilakukan setelah 90 menit, setelah presensi masuk. 
                Pastikan Anda telah mengisi laporan kegiatan dengan benar.
            </p>
        </div>

        {{-- CARD KANAN: FORMULIR --}}
        <div class="presensi-card form-card" id="formPresensi" style="display: none;">
            <div class="card-header-custom">
                <h3>Laporan Kegiatan</h3>
                <p>Input detail pengajaran hari ini</p>
            </div>

            <form id="submitFormPresensi">
                <div class="form-group">
                    <label>Kelas</label>
                    <input type="text" class="form-control-custom" placeholder="Contoh: 9A atau Intensif SBMPTN">
                </div>

                <div class="form-group">
                    <label>Status Kehadiran Murid</label>
                    <div class="radio-group">
                        <label><input type="radio" name="status" checked> Hadir</label>
                        <label><input type="radio" name="status"> Tidak Hadir</label>
                    </div>
                </div>

                <div class="form-group">
                    <label>Upload Foto Kegiatan</label>
                    <div class="upload-area">
                        <i class="fas fa-camera"></i>
                        <p>Ambil atau pilih foto kegiatan belajar mengajar</p>
                    </div>
                </div>

                <button type="button" class="btn-submit" id="btnSubmitForm">Kirim Laporan</button>
            </form>
        </div>
    </div>
</div>

<style>
    .presensi-flex { display: flex; gap: 20px; align-items: flex-start; }
    .presensi-card { background: #fff; border-radius: 16px; padding: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.06); flex: 1; max-width: 450px; }
    
    .card-header-custom h3 { font-size: 20px; font-weight: 700; margin: 0; color: #1a1a2e; }
    .card-header-custom p { font-size: 14px; color: #888; margin: 5px 0 25px 0; }

    .button-group-presensi { display: flex; gap: 15px; margin-bottom: 20px; }
    .btn-presensi { border: none; border-radius: 12px; padding: 12px; font-size: 16px; font-weight: bold; color: #fff; cursor: pointer; display: flex; align-items: center; gap: 10px; flex: 1; justify-content: center; transition: 0.3s; }
    
    .btn-masuk { background-color: #4ade80; }
    .btn-keluar { background-color: #b04b4b; }

    /* Visual Tombol Disabled (Abu-abu) */
    .btn-presensi:disabled { 
        background-color: #d1d5db !important; 
        color: #9ca3af !important; 
        cursor: not-allowed; 
        box-shadow: none;
    }

    .form-group { margin-bottom: 15px; }
    .form-group label { display: block; font-size: 14px; font-weight: 600; color: #1a1a2e; margin-bottom: 8px; }
    .form-control-custom { width: 100%; padding: 10px; border: 1px solid #e5e7eb; border-radius: 8px; outline: none; }
    .radio-group { display: flex; gap: 20px; font-size: 14px; }
    .upload-area { border: 2px dashed #e5e7eb; border-radius: 12px; padding: 20px; text-align: center; color: #888; }
    .btn-submit { width: 100%; background: #4ade80; color: white; border: none; padding: 12px; border-radius: 10px; font-weight: bold; cursor: pointer; transition: 0.3s; }
    .btn-submit:hover { opacity: 0.9; }
    .presensi-info { font-size: 12px; color: #666; line-height: 1.6; margin: 0; }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const btnMasuk = document.getElementById('btnMasuk');
        const btnKeluar = document.getElementById('btnKeluar');
        const formCard = document.getElementById('formPresensi');
        const btnSubmit = document.getElementById('btnSubmitForm');

        // Klik Masuk -> Form Muncul, Masuk Disabled
        btnMasuk.addEventListener('click', function() {
            formCard.style.display = 'block';
            this.disabled = true;
        });

        // Klik Submit -> Form Hilang, Keluar Enabled
        btnSubmit.addEventListener('click', function() {
            alert('Laporan pengajaran berhasil dikirim!');
            formCard.style.display = 'none';
            btnKeluar.disabled = false;
        });

        // Klik Keluar -> Kembali ke Awal (Reset)
        btnKeluar.addEventListener('click', function() {
            alert('Sesi mengajar berakhir. Terima kasih!');
            this.disabled = true; 
            btnMasuk.disabled = false; 
        });
    });
</script>
@endsection