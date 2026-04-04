{{-- =============================================
     Dashboard Tentor - Presensi (FINAL SYNC)
     File: resources/views/dashboard/tentor/presensi.blade.php
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
            Presensi
        </h1>
        <p style="color: #6B7280; font-size: 14px; margin: 4px 0 0 0;">Silakan kelola kehadiran sesi mengajar Anda di sini.</p>
    </div>

    {{-- ── 2. KONTEN PRESENSI ── --}}
    <div class="presensi-flex">
        {{-- CARD KIRI: TOMBOL MASUK/KELUAR --}}
        <div class="presensi-card">
            <div class="card-header-custom">
                <h3>Presensi Hari Ini</h3>
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

            <div class="presensi-info">
                <i class="fas fa-info-circle" style="margin-right: 5px; color: #4D0B87;"></i>
                Presensi keluar bisa dilakukan setelah 90 menit sesi mengajar berjalan. Pastikan laporan kegiatan sudah diisi.
            </div>
        </div>

        {{-- CARD KANAN: FORMULIR LAPORAN (Hidden by Default) --}}
        <div class="presensi-card" id="formPresensi" style="display: none;">
            <div class="card-header-custom">
                <h3>Laporan Kegiatan</h3>
                <p>Input detail pengajaran hari ini</p>
            </div>

            <form id="submitFormPresensi">
                <div class="form-group">
                    <label>Kelas / Materi</label>
                    <input type="text" class="form-control-custom" placeholder="Contoh: 9A atau Intensif SBMPTN">
                </div>

                <div class="form-group">
                    <label>Status Kehadiran Murid</label>
                    <div class="radio-group">
                        <label style="cursor: pointer;"><input type="radio" name="status" checked> Hadir</label>
                        <label style="cursor: pointer;"><input type="radio" name="status"> Tidak Hadir</label>
                    </div>
                </div>

                <div class="form-group">
                    <label>Upload Foto Kegiatan</label>
                    <div class="upload-area">
                        <i class="fas fa-camera" style="font-size: 20px; margin-bottom: 8px; display: block;"></i>
                        <p style="font-size: 12px; margin: 0;">Ambil atau pilih foto KBM</p>
                    </div>
                </div>

                <button type="button" class="btn-submit" id="btnSubmitForm">Kirim Laporan</button>
            </form>
        </div>
    </div>
</div>

<style>
    /* Layout */
    .presensi-flex { display: flex; gap: 20px; align-items: flex-start; }
    
    /* Card Style Sync dengan Riwayat */
    .presensi-card { 
        background: #fff; 
        border-radius: 20px; 
        padding: 25px; 
        box-shadow: 0 4px 15px rgba(0,0,0,0.08); 
        flex: 1; 
        max-width: 450px; 
        border: 1px solid #F3F4F6;
    }
    
    .card-header-custom h3 { font-size: 18px; font-weight: 700; margin: 0; color: #111827; }
    .card-header-custom p { font-size: 13px; color: #6B7280; margin: 5px 0 20px 0; }

    /* Buttons */
    .button-group-presensi { display: flex; gap: 12px; margin-bottom: 20px; }
    .btn-presensi { 
        border: none; border-radius: 12px; padding: 14px; 
        font-size: 15px; font-weight: 700; color: #fff; 
        cursor: pointer; display: flex; align-items: center; 
        gap: 10px; flex: 1; justify-content: center; transition: 0.3s; 
    }
    
    .btn-masuk { background-color: #10B981; }
    .btn-keluar { background-color: #EF4444; }

    .btn-presensi:disabled { 
        background-color: #E5E7EB !important; 
        color: #9CA3AF !important; 
        cursor: not-allowed; 
    }

    /* Form Elements */
    .form-group { margin-bottom: 18px; }
    .form-group label { display: block; font-size: 13px; font-weight: 700; color: #374151; margin-bottom: 8px; text-transform: uppercase; }
    .form-control-custom { width: 100%; padding: 12px; border: 1px solid #E5E7EB; border-radius: 10px; outline: none; font-size: 14px; }
    .form-control-custom:focus { border-color: #4D0B87; }
    
    .radio-group { display: flex; gap: 20px; font-size: 14px; color: #4B5563; }
    .upload-area { border: 2px dashed #E5E7EB; border-radius: 12px; padding: 20px; text-align: center; color: #9CA3AF; cursor: pointer; }
    .upload-area:hover { border-color: #4D0B87; color: #4D0B87; }

    .btn-submit { 
        width: 100%; background: #4D0B87; color: white; border: none; 
        padding: 14px; border-radius: 12px; font-weight: 700; cursor: pointer; transition: 0.3s; 
    }
    .btn-submit:hover { opacity: 0.9; }

    .presensi-info { 
        font-size: 12px; color: #6B7280; line-height: 1.6; 
        padding: 12px; background: #F9FAFB; border-radius: 10px; border-left: 4px solid #4D0B87;
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const btnMasuk = document.getElementById('btnMasuk');
        const btnKeluar = document.getElementById('btnKeluar');
        const formCard = document.getElementById('formPresensi');
        const btnSubmit = document.getElementById('btnSubmitForm');

        btnMasuk.addEventListener('click', function() {
            formCard.style.display = 'block';
            this.disabled = true;
        });

        btnSubmit.addEventListener('click', function() {
            alert('Laporan pengajaran berhasil dikirim!');
            formCard.style.display = 'none';
            btnKeluar.disabled = false;
        });

        btnKeluar.addEventListener('click', function() {
            alert('Sesi mengajar berakhir. Terima kasih!');
            this.disabled = true; 
            btnMasuk.disabled = false; 
        });
    });
</script>
@endsection