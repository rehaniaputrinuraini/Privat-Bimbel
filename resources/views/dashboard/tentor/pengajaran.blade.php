@extends('layouts.app')

@section('title', 'Pengajaran')

@section('content')
<style>
    .presensi-flex { 
        display: flex; 
        gap: 20px; 
        align-items: flex-start; 
        flex-wrap: wrap;
        font-family: 'Poppins', sans-serif;
    }
    
    .presensi-card { 
        background: #FFFFFF; 
        border-radius: 15px; 
        padding: 30px; 
        box-shadow: 0 4px 10px rgba(0,0,0,0.02); 
        flex: 1; 
        min-width: 350px;
        border: 1.5px solid #E5E7EB;
    }
    
    .card-header-custom h3 { 
        font-size: 18px; 
        font-weight: 700; 
        margin: 0; 
        color: #111827; 
    }
    .card-header-custom p { 
        font-size: 13px; 
        color: #6B7280; 
        margin: 5px 0 20px 0; 
    }

    .button-group-presensi { 
        display: flex; 
        gap: 12px; 
        margin-bottom: 20px; 
        flex-wrap: wrap;
    }
    .btn-presensi { 
        border: none; 
        border-radius: 12px; 
        padding: 14px 20px; 
        font-size: 15px; 
        font-weight: 600; 
        color: #fff; 
        cursor: pointer; 
        display: flex; 
        align-items: center; 
        gap: 10px; 
        flex: 1; 
        justify-content: center; 
        transition: 0.3s; 
        font-family: 'Poppins', sans-serif;
    }
    
    .btn-masuk { background-color: #10B981; }
    .btn-masuk:hover { background-color: #059669; }
    .btn-keluar { background-color: #EF4444; }
    .btn-keluar:hover { background-color: #DC2626; }

    .btn-presensi:disabled { 
        background-color: #E5E7EB !important; 
        color: #9CA3AF !important; 
        cursor: not-allowed; 
    }

    .form-group { margin-bottom: 18px; }
    .form-group label { 
        display: block; 
        font-size: 14px; 
        font-weight: 600; 
        color: #374151; 
        margin-bottom: 8px; 
        font-family: 'Poppins', sans-serif;
    }
    .form-control-custom { 
        width: 100%; 
        padding: 12px 15px; 
        border: 1px solid #E5E7EB; 
        border-radius: 12px; 
        outline: none; 
        font-size: 14px; 
        background: #FFFFFF;
        font-family: 'Poppins', sans-serif;
    }
    .form-control-custom:focus { 
        border-color: #4D0B87; 
        box-shadow: 0 0 0 2px rgba(77, 11, 135, 0.1);
    }
    
    textarea.form-control-custom { resize: vertical; min-height: 80px; }
    
    .radio-group { 
        display: flex; 
        gap: 20px; 
        font-size: 14px; 
        color: #4B5563; 
        font-family: 'Poppins', sans-serif;
    }
    .radio-group label {
        font-weight: normal;
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
    }
    
    .upload-area { 
        border: 2px dashed #E5E7EB; 
        border-radius: 12px; 
        padding: 20px; 
        text-align: center; 
        color: #9CA3AF; 
        cursor: pointer;
        transition: 0.3s;
        font-family: 'Poppins', sans-serif;
    }
    .upload-area:hover { 
        border-color: #4D0B87; 
        color: #4D0B87; 
        background: #F9FAFB;
    }
    .upload-area.has-file { border-color: #10B981; background: #F0FDF4; color: #065F46; }
    
    .upload-hint { font-size: 12px; color: #EF4444; margin-top: 5px; display: block; }
    .upload-hint-success { color: #10B981; }

    .btn-submit { 
        width: 100%; 
        background: #4D0B87; 
        color: white; 
        border: none; 
        padding: 14px; 
        border-radius: 10px; 
        font-weight: 600; 
        font-size: 16px;
        cursor: pointer; 
        transition: 0.3s; 
        font-family: 'Poppins', sans-serif;
        box-shadow: 0 4px 6px rgba(77, 11, 135, 0.2);
    }
    .btn-submit:hover { background: #3B0A6B; transform: translateY(-1px); }
    .btn-submit:disabled { background: #9CA3AF; cursor: not-allowed; transform: none; box-shadow: none; }

    .presensi-info { 
        font-size: 13px; 
        color: #6B7280; 
        line-height: 1.6; 
        padding: 12px 15px; 
        background: #F9FAFB; 
        border-radius: 10px; 
        border-left: 4px solid #4D0B87;
    }
    
    .alert-custom {
        padding: 12px 15px;
        border-radius: 10px;
        margin-bottom: 15px;
        display: none;
        font-size: 14px;
    }
    .alert-success { background: #D1FAE5; color: #065F46; }
    .alert-error { background: #FEE2E2; color: #EF4444; }
    
    #previewFoto { margin-top: 10px; max-width: 100%; border-radius: 10px; display: none; }
    
    small { font-size: 12px; color: #6B7280; }
    select.form-control-custom { cursor: pointer; }

    /* MODAL */
    .modal-overlay {
        display: none;
        position: fixed;
        z-index: 9999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        backdrop-filter: blur(3px);
        align-items: center;
        justify-content: center;
    }
    .modal-content {
        background: white;
        border-radius: 20px;
        padding: 30px;
        width: 550px;
        max-width: 95%;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 15px 30px rgba(0,0,0,0.15);
        font-family: 'Poppins', sans-serif;
    }
    .modal-confirm {
        background: white;
        border-radius: 20px;
        padding: 25px;
        width: 400px;
        max-width: 95%;
        text-align: center;
        box-shadow: 0 15px 30px rgba(0,0,0,0.15);
        font-family: 'Poppins', sans-serif;
    }
    .btn-confirm {
        padding: 10px 30px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        border: none;
        transition: 0.2s;
        font-family: 'Poppins', sans-serif;
    }
    .btn-tidak {
        background: #F3F4F6;
        color: #374151;
        border: 1px solid #E5E7EB;
    }
    .btn-ya {
        background: #EF4444;
        color: white;
    }
</style>

<div style="padding: 10px; font-family: 'Poppins', sans-serif;">
    <div style="width: 100%;">

        @php
            $currentMonth = date('n');
            $currentYear = date('Y');
            $selectedBulan = request('bulan', $currentMonth);
            $selectedTahun = request('tahun', $currentYear);
        @endphp

        <div style="margin-bottom: 25px;">
            <p style="color: #374151; font-size: 13px; margin: 0 0 4px 0;">
                {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}
            </p>
            <h1 style="font-size: 26px; font-weight: 700; color: #111827; margin: 0;">Pengajaran</h1>
            <p style="color: #374151; font-size: 14px; margin: 4px 0 0 0;">Presensi & Riwayat Pengajaran</p>
        </div>

        <div id="alertSuccess" class="alert-custom alert-success">
            <i class="fas fa-check-circle"></i> <span id="successMessage"></span>
        </div>
        <div id="alertError" class="alert-custom alert-error">
            <i class="fas fa-exclamation-circle"></i> <span id="errorMessage"></span>
        </div>

        <div class="presensi-flex">
            <div class="presensi-card">
                <div class="card-header-custom">
                    <h3>Presensi Hari Ini</h3>
                    <p>{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
                </div>

                <div class="button-group-presensi">
                    <button type="button" class="btn-presensi btn-masuk" id="btnMasuk" 
                        {{ $presensiHariIni && $presensiHariIni->bukti_mengajar ? 'disabled' : '' }}>
                        <i class="fas fa-sign-in-alt"></i> Masuk
                    </button>

                    <button type="button" class="btn-presensi btn-keluar" id="btnKeluar" 
                        {{ $presensiHariIni && $presensiHariIni->bukti_mengajar ? '' : 'disabled' }}>
                        <i class="fas fa-sign-out-alt"></i> Keluar
                    </button>
                </div>

                <div class="presensi-info">
                    <i class="fas fa-info-circle" style="margin-right: 5px; color: #4D0B87;"></i>
                    Presensi keluar bisa dilakukan setelah mengisi laporan kegiatan.
                </div>
            </div>
        </div>

        <div style="margin-top: 40px;">
            <div style="margin-bottom: 20px;">
                <h2 style="font-size: 22px; font-weight: 700; color: #111827; margin: 0;">Riwayat Pengajaran</h2>
                <p style="color: #374151; font-size: 14px; margin: 4px 0 0 0;">Lihat riwayat kehadiran mengajar Anda</p>
            </div>

            <form method="GET" action="{{ route('tentor.pengajaran') }}" id="filterForm">
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 20px; flex-wrap: wrap;">
                    <div style="position: relative; width: 250px;">
                        <i class="fas fa-search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #9CA3AF;"></i>
                        <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari Kelas, Ruang..."
                               style="width: 100%; padding: 10px 15px 10px 45px; border-radius: 12px; border: 1px solid #E5E7EB; outline: none; background: white; font-size: 14px;">
                    </div>

                    {{-- FILTER BULAN (default: bulan saat ini) --}}
                    <select name="bulan" style="padding: 10px 12px; border-radius: 12px; border: 1px solid #E5E7EB; font-size: 13px; min-width: 140px; background: white; outline: none; cursor: pointer;" onchange="this.form.submit()">
                        <option value="">Semua Bulan</option>
                        @for($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ $selectedBulan == $i ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                            </option>
                        @endfor
                    </select>

                    {{-- FILTER TAHUN (default: tahun saat ini) --}}
                    <select name="tahun" style="padding: 10px 12px; border-radius: 12px; border: 1px solid #E5E7EB; font-size: 13px; min-width: 100px; background: white; outline: none; cursor: pointer;" onchange="this.form.submit()">
                        <option value="">Semua Tahun</option>
                        @for($year = date('Y') - 2; $year <= date('Y') + 1; $year++)
                            <option value="{{ $year }}" {{ $selectedTahun == $year ? 'selected' : '' }}>{{ $year }}</option>
                        @endfor
                    </select>
                    
                    @if(request('bulan') || request('tahun') || request('search'))
                        <a href="{{ route('tentor.pengajaran') }}" style="padding: 10px 15px; border-radius: 12px; background: #F3F4F6; color: #374151; text-decoration: none; font-size: 13px;">
                            <i class="fas fa-times"></i> Reset
                        </a>
                    @endif
                </div>
                <input type="hidden" name="perPage" id="perPageInput" value="{{ request('perPage', 10) }}">
            </form>

            <div style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.08); border: 1px solid #F3F4F6;">
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 13px; white-space: nowrap;">
                        <thead>
                            <tr style="background: #F3E8FF; color: #111827;">
                                <th style="padding: 15px; font-weight: 700; width: 50px;">No</th>
                                <th style="padding: 15px; font-weight: 700;">Tanggal</th>
                                <th style="padding: 15px; font-weight: 700;">Kelas</th>
                                <th style="padding: 15px; font-weight: 700;">Ruang</th>
                                <th style="padding: 15px; font-weight: 700;">Jam Masuk</th>
                                <th style="padding: 15px; font-weight: 700;">Jam Keluar</th>
                                <th style="padding: 15px; font-weight: 700; text-align: center;">Status Murid</th>
                            </td>
                        </thead>
                        <tbody style="color: #374151;">
                            @forelse($riwayat as $index => $item)
                                @php
                                    $namaKelas = $item->kelas ? $item->kelas->jenjang . ' - ' . $item->kelas->nama_kelas : '-';
                                    $namaRuang = $item->ruang ? $item->ruang->nama_ruang : '-';
                                    $statusClass = $item->murid_hadir == 'Hadir' ? 'background: #D1FAE5; color: #065F46;' : 'background: #FEE2E2; color: #991B1B;';
                                    $jamMasuk = $item->jam_mulai ? \Carbon\Carbon::parse($item->jam_mulai)->format('H:i') : '-';
                                    $jamKeluar = $item->jam_selesai ? \Carbon\Carbon::parse($item->jam_selesai)->format('H:i') : '-';
                                @endphp
                                <tr style="border-bottom: 1px solid #F3F4F6;">
                                    <td style="padding: 15px;">{{ $riwayat->firstItem() + $index }}</td>
                                    <td style="padding: 15px;">{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}</td>
                                    <td style="padding: 15px;">{{ $namaKelas }}</td>
                                    <td style="padding: 15px;">{{ $namaRuang }}</td>
                                    <td style="padding: 15px;">{{ $jamMasuk }}</td>
                                    <td style="padding: 15px;">{{ $jamKeluar }}</td>
                                    <td style="padding: 15px; text-align: center;">
                                        <span style="padding: 5px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; {{ $statusClass }}">
                                            {{ $item->murid_hadir ?? '-' }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" style="padding: 40px; text-align: center; color: #9CA3AF;">
                                        <i class="fas fa-calendar-alt" style="font-size: 40px; margin-bottom: 10px; display: block;"></i>
                                        Belum ada data presensi untuk bulan ini
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            @if($riwayat->count() > 0)
            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px; padding: 0 5px;">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <select id="perPageSelect" style="padding: 8px 12px; border-radius: 10px; border: 1px solid #E5E7EB; font-size: 13px; background: white; outline: none; cursor: pointer;">
                        <option value="10" {{ request('perPage', 10) == 10 ? 'selected' : '' }}>10 baris</option>
                        <option value="25" {{ request('perPage', 10) == 25 ? 'selected' : '' }}>25 baris</option>
                        <option value="50" {{ request('perPage', 10) == 50 ? 'selected' : '' }}>50 baris</option>
                    </select>
                    <span style="color: #374151; font-size: 13px;">Menampilkan {{ $riwayat->total() }} data</span>
                </div>
                <div style="display: flex; gap: 5px;">
                    @if($riwayat->onFirstPage())
                        <button disabled style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: #F3F4F6; color: #9CA3AF; cursor: not-allowed;"><i class="fas fa-angle-double-left"></i></button>
                        <button disabled style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: #F3F4F6; color: #9CA3AF; cursor: not-allowed;"><i class="fas fa-angle-left"></i></button>
                    @else
                        <a href="{{ $riwayat->url(1) }}" style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; display: flex; align-items: center; justify-content: center; text-decoration: none;"><i class="fas fa-angle-double-left"></i></a>
                        <a href="{{ $riwayat->previousPageUrl() }}" style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; display: flex; align-items: center; justify-content: center; text-decoration: none;"><i class="fas fa-angle-left"></i></a>
                    @endif
                    <button style="width: 35px; height: 35px; border-radius: 8px; background: #4D0B87; color: white; border: none; font-weight: 600;">{{ $riwayat->currentPage() }}</button>
                    @if($riwayat->hasMorePages())
                        <a href="{{ $riwayat->nextPageUrl() }}" style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; display: flex; align-items: center; justify-content: center; text-decoration: none;"><i class="fas fa-angle-right"></i></a>
                        <a href="{{ $riwayat->url($riwayat->lastPage()) }}" style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; display: flex; align-items: center; justify-content: center; text-decoration: none;"><i class="fas fa-angle-double-right"></i></a>
                    @else
                        <button disabled style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: #F3F4F6; color: #9CA3AF; cursor: not-allowed;"><i class="fas fa-angle-right"></i></button>
                        <button disabled style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: #F3F4F6; color: #9CA3AF; cursor: not-allowed;"><i class="fas fa-angle-double-right"></i></button>
                    @endif
                </div>
            </div>
            @endif
        </div>

    </div>
</div>

<div class="modal-overlay" id="modalLaporan">
    <div class="modal-content">
        <div class="card-header-custom" style="margin-bottom: 20px;">
            <h3>Laporan Kegiatan</h3>
            <p>Input detail pengajaran hari ini - {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
        </div>

        <form id="formLaporan" enctype="multipart/form-data">
            @csrf
            
            <div class="form-group">
                <label>Kelas <span style="color: #EF4444;">*</span></label>
                <select class="form-control-custom" id="id_kelas" name="id_kelas" required>
                    <option value="">-- Pilih Kelas --</option>
                    @foreach($kelasList as $kelas)
                        <option value="{{ $kelas->id_kelas }}" data-jenjang="{{ $kelas->jenjang }}">
                            {{ $kelas->jenjang }} - {{ $kelas->nama_kelas }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Ruang <span style="color: #EF4444;">*</span></label>
                <select class="form-control-custom" id="id_ruang" name="id_ruang" required>
                    <option value="">-- Pilih Ruang --</option>
                    @foreach($ruangList as $ruang)
                        <option value="{{ $ruang->id_ruang }}">{{ $ruang->nama_ruang }}</option>
                    @endforeach
                </select>
            </div>

            <input type="hidden" id="jenjang" name="jenjang">

            <div class="form-group">
                <label>Status Kehadiran Murid <span style="color: #EF4444;">*</span></label>
                <div class="radio-group">
                    <label><input type="radio" name="murid_hadir" value="Hadir" checked> Hadir</label>
                    <label><input type="radio" name="murid_hadir" value="Tidak Hadir"> Tidak Hadir</label>
                </div>
            </div>

            <div class="form-group">
                <label>Keterangan</label>
                <textarea class="form-control-custom" id="keterangan" name="keterangan" 
                          placeholder="Isikan materi yang diajarkan..." maxlength="30"></textarea>
                <small>Maksimal 30 karakter</small>
            </div>

            <div class="form-group">
                <label>Upload Foto Kegiatan <span style="color: #EF4444;">*</span></label>
                <div class="upload-area" id="uploadArea">
                    <i class="fas fa-camera" style="font-size: 20px; margin-bottom: 8px; display: block;"></i>
                    <p style="font-size: 12px; margin: 0;">Klik untuk ambil atau pilih foto KBM</p>
                </div>
                <input type="file" id="foto" name="foto" accept="image/*" style="display: none;" required>
                <small class="upload-hint" id="uploadHint">
                    <i class="fas fa-info-circle"></i> Pastikan foto menunjukkan wajah murid
                </small>
                <img id="previewFoto" alt="Preview Foto">
            </div>

            <div style="display: flex; gap: 12px;">
                <button type="button" class="btn-submit" id="btnKeluarDariPopup" 
                        style="background: #EF4444; flex: 1;">
                    <i class="fas fa-sign-out-alt"></i> Keluar
                </button>
                <button type="submit" class="btn-submit" id="btnSubmitForm" style="flex: 1;">
                    <i class="fas fa-paper-plane"></i> Kirim Laporan
                </button>
            </div>
        </form>
    </div>
</div>

<div class="modal-overlay" id="modalKonfirmasiBatalLaporan">
    <div class="modal-confirm">
        <div style="color: #F59E0B; font-size: 40px; margin-bottom: 10px;">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <h2 style="margin: 0; font-size: 18px; color: #111827; font-weight: 700;">Apakah Anda Ingin Keluar?</h2>
        <p style="color: #6B7280; font-size: 13px; margin: 8px 0 20px 0;">
            Laporan kegiatan belum dikirim. Jika keluar, data laporan tidak akan tersimpan.
        </p>
        <div style="display: flex; gap: 10px; justify-content: center;">
            <button type="button" class="btn-confirm btn-tidak" id="btnTidakBatalLaporan">
                Tidak
            </button>
            <button type="button" class="btn-confirm btn-ya" id="btnYaBatalLaporan">
                Iya
            </button>
        </div>
    </div>
</div>

<div class="modal-overlay" id="modalKonfirmasiKeluar">
    <div class="modal-confirm">
        <div style="color: #F59E0B; font-size: 40px; margin-bottom: 10px;">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <h2 style="margin: 0; font-size: 18px; color: #111827; font-weight: 700;">Selesaikan Pengajaran?</h2>
        <p style="color: #6B7280; font-size: 13px; margin: 8px 0 20px 0;">
            Apakah Anda yakin menyelesaikan pengajaran pada sesi ini di tanggal 
            <strong>{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</strong>?
        </p>
        <div style="display: flex; gap: 10px; justify-content: center;">
            <button type="button" class="btn-confirm btn-tidak" id="btnTidakKeluar">
                Tidak
            </button>
            <button type="button" class="btn-confirm btn-ya" id="btnYaKeluar">
                Ya, Selesaikan
            </button>
        </div>
    </div>
</div>

<script>
    const btnMasuk = document.getElementById('btnMasuk');
    const btnKeluar = document.getElementById('btnKeluar');
    const modalLaporan = document.getElementById('modalLaporan');
    const modalKonfirmasiKeluar = document.getElementById('modalKonfirmasiKeluar');
    const modalKonfirmasiBatalLaporan = document.getElementById('modalKonfirmasiBatalLaporan');
    const formLaporan = document.getElementById('formLaporan');
    const uploadArea = document.getElementById('uploadArea');
    const fotoInput = document.getElementById('foto');
    const previewFoto = document.getElementById('previewFoto');
    const uploadHint = document.getElementById('uploadHint');
    const btnSubmit = document.getElementById('btnSubmitForm');
    const kelasSelect = document.getElementById('id_kelas');
    const ruangSelect = document.getElementById('id_ruang');
    const jenjangHidden = document.getElementById('jenjang');
    const keteranganInput = document.getElementById('keterangan');
    const btnTidakKeluar = document.getElementById('btnTidakKeluar');
    const btnYaKeluar = document.getElementById('btnYaKeluar');
    const btnKeluarDariPopup = document.getElementById('btnKeluarDariPopup');
    const btnTidakBatalLaporan = document.getElementById('btnTidakBatalLaporan');
    const btnYaBatalLaporan = document.getElementById('btnYaBatalLaporan');
    
    let laporanTerkirim = false;
    
    function showAlert(type, message) {
        if (type === 'success') {
            document.getElementById('successMessage').innerText = message;
            document.getElementById('alertSuccess').style.display = 'block';
            setTimeout(() => { document.getElementById('alertSuccess').style.display = 'none'; }, 3000);
        } else {
            document.getElementById('errorMessage').innerText = message;
            document.getElementById('alertError').style.display = 'block';
            setTimeout(() => { document.getElementById('alertError').style.display = 'none'; }, 3000);
        }
    }
    
    kelasSelect?.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        jenjangHidden.value = selectedOption.getAttribute('data-jenjang') || '';
    });
    
    uploadArea?.addEventListener('click', function() { fotoInput.click(); });
    fotoInput?.addEventListener('change', function(e) {
        if (e.target.files && e.target.files[0]) {
            const reader = new FileReader();
            reader.onload = function(event) {
                previewFoto.src = event.target.result;
                previewFoto.style.display = 'block';
                uploadArea.classList.add('has-file');
                uploadHint.innerHTML = '<i class="fas fa-check-circle"></i> Foto sudah dipilih';
                uploadHint.classList.add('upload-hint-success');
            };
            reader.readAsDataURL(e.target.files[0]);
        }
    });
    
    btnMasuk?.addEventListener('click', function() {
        fetch('{{ route("tentor.presensi.masuk") }}', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' }
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                showAlert('success', data.message);
                btnMasuk.disabled = true;
                laporanTerkirim = false;
                modalLaporan.style.display = 'flex';
            } else { showAlert('error', data.message); }
        })
        .catch(error => {
            showAlert('error', 'Gagal terhubung ke server');
        });
    });
    
    btnKeluarDariPopup?.addEventListener('click', function() {
        modalKonfirmasiBatalLaporan.style.display = 'flex';
    });
    
    btnTidakBatalLaporan?.addEventListener('click', function() {
        modalKonfirmasiBatalLaporan.style.display = 'none';
    });
    
    btnYaBatalLaporan?.addEventListener('click', function() {
        modalKonfirmasiBatalLaporan.style.display = 'none';
        modalLaporan.style.display = 'none';
        
        fetch('{{ route("tentor.presensi.batal") }}', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' }
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                showAlert('success', data.message);
                btnMasuk.disabled = false;
                btnKeluar.disabled = true;
                laporanTerkirim = false;
            } else {
                showAlert('error', data.message);
            }
        });
        
        ['kelasSelect','ruangSelect','keteranganInput','fotoInput'].forEach(id => {
            const el = document.getElementById(id); if (el) { el.disabled = false; el.value = ''; }
        });
        document.querySelectorAll('input[name="murid_hadir"]').forEach(r => { r.disabled = false; });
        document.querySelector('input[name="murid_hadir"][value="Hadir"]').checked = true;
        if (uploadArea) uploadArea.style.pointerEvents = 'auto';
        if (previewFoto) previewFoto.style.display = 'none';
        if (uploadHint) { 
            uploadHint.innerHTML = '<i class="fas fa-info-circle"></i> Pastikan foto menunjukkan wajah murid'; 
            uploadHint.classList.remove('upload-hint-success'); 
        }
        if (uploadArea) uploadArea.classList.remove('has-file');
        btnSubmit.disabled = false;
        btnSubmit.innerHTML = '<i class="fas fa-paper-plane"></i> Kirim Laporan';
    });
    
    formLaporan?.addEventListener('submit', function(e) {
        e.preventDefault();
        if (!fotoInput.files[0]) { showAlert('error', 'Foto kegiatan wajib diupload!'); return; }
        if (!kelasSelect.value) { showAlert('error', 'Silakan pilih kelas!'); return; }
        if (!ruangSelect.value) { showAlert('error', 'Silakan pilih ruang!'); return; }
        
        const formData = new FormData();
        formData.append('id_kelas', kelasSelect.value);
        formData.append('id_ruang', ruangSelect.value);
        formData.append('jenjang', jenjangHidden.value);
        formData.append('murid_hadir', document.querySelector('input[name="murid_hadir"]:checked').value);
        formData.append('keterangan', keteranganInput.value);
        formData.append('foto', fotoInput.files[0]);
        
        btnSubmit.disabled = true;
        btnSubmit.innerHTML = '<i class="fas fa-spinner fa-pulse"></i> Mengirim...';
        
        fetch('{{ route("tentor.presensi.laporan") }}', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: formData
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                showAlert('success', data.message);
                laporanTerkirim = true;
                btnKeluar.disabled = false;
                modalLaporan.style.display = 'none';
                ['kelasSelect','ruangSelect','keteranganInput','fotoInput'].forEach(id => {
                    const el = document.getElementById(id); if (el) el.disabled = true;
                });
                document.querySelectorAll('input[name="murid_hadir"]').forEach(r => r.disabled = true);
                if (uploadArea) uploadArea.style.pointerEvents = 'none';
            } else {
                showAlert('error', data.message);
                btnSubmit.disabled = false;
                btnSubmit.innerHTML = '<i class="fas fa-paper-plane"></i> Kirim Laporan';
            }
        });
    });
    
    btnKeluar?.addEventListener('click', function() {
        if (!laporanTerkirim) {
            showAlert('error', 'Silakan isi laporan terlebih dahulu!');
            return;
        }
        modalKonfirmasiKeluar.style.display = 'flex';
    });
    
    btnTidakKeluar?.addEventListener('click', function() {
        modalKonfirmasiKeluar.style.display = 'none';
    });
    
    btnYaKeluar?.addEventListener('click', function() {
        modalKonfirmasiKeluar.style.display = 'none';
        btnKeluar.disabled = true;
        btnKeluar.innerHTML = '<i class="fas fa-spinner fa-pulse"></i> Memproses...';
        
        fetch('{{ route("tentor.presensi.keluar") }}', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' }
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                showAlert('success', data.message);
                btnMasuk.disabled = false;
                btnKeluar.disabled = true;
                btnKeluar.innerHTML = '<i class="fas fa-sign-out-alt"></i> Keluar';
                laporanTerkirim = false;
                
                ['kelasSelect','ruangSelect','keteranganInput','fotoInput'].forEach(id => {
                    const el = document.getElementById(id); if (el) { el.disabled = false; el.value = ''; }
                });
                document.querySelectorAll('input[name="murid_hadir"]').forEach(r => { r.disabled = false; });
                document.querySelector('input[name="murid_hadir"][value="Hadir"]').checked = true;
                if (uploadArea) uploadArea.style.pointerEvents = 'auto';
                if (previewFoto) previewFoto.style.display = 'none';
                if (uploadHint) { 
                    uploadHint.innerHTML = '<i class="fas fa-info-circle"></i> Pastikan foto menunjukkan wajah murid'; 
                    uploadHint.classList.remove('upload-hint-success'); 
                }
                if (uploadArea) uploadArea.classList.remove('has-file');
                btnSubmit.disabled = false;
                btnSubmit.innerHTML = '<i class="fas fa-paper-plane"></i> Kirim Laporan';
                
                setTimeout(() => { window.location.reload(); }, 2000);
            } else {
                showAlert('error', data.message);
                btnKeluar.disabled = false;
                btnKeluar.innerHTML = '<i class="fas fa-sign-out-alt"></i> Keluar';
            }
        })
        .catch(error => {
            showAlert('error', 'Terjadi kesalahan: ' + error);
            btnKeluar.disabled = false;
            btnKeluar.innerHTML = '<i class="fas fa-sign-out-alt"></i> Keluar';
        });
    });
    
    modalKonfirmasiKeluar?.addEventListener('click', function(e) {
        if (e.target === modalKonfirmasiKeluar) modalKonfirmasiKeluar.style.display = 'none';
    });
    
    modalKonfirmasiBatalLaporan?.addEventListener('click', function(e) {
        if (e.target === modalKonfirmasiBatalLaporan) modalKonfirmasiBatalLaporan.style.display = 'none';
    });
    
    fetch('{{ route("tentor.presensi.cek-status") }}')
        .then(r => r.json())
        .then(data => {
            if (data.has_presensi_masuk) btnMasuk.disabled = true;
            if (data.has_laporan && data.data) {
                laporanTerkirim = true;
                btnKeluar.disabled = false;
                ['kelasSelect','ruangSelect','keteranganInput','fotoInput'].forEach(id => {
                    const el = document.getElementById(id); if (el) el.disabled = true;
                });
                document.querySelectorAll('input[name="murid_hadir"]').forEach(r => r.disabled = true);
                if (uploadArea) uploadArea.style.pointerEvents = 'none';
                
                if (data.data.id_kelas) {
                    kelasSelect.value = data.data.id_kelas;
                    jenjangHidden.value = kelasSelect.options[kelasSelect.selectedIndex].getAttribute('data-jenjang') || '';
                }
                if (data.data.id_ruang) ruangSelect.value = data.data.id_ruang;
                keteranganInput.value = data.data.keterangan || '';
                if (data.data.murid_hadir) {
                    document.querySelector(`input[name="murid_hadir"][value="${data.data.murid_hadir}"]`).checked = true;
                }
                if (data.data.bukti_mengajar) {
                    previewFoto.src = '/storage/' + data.data.bukti_mengajar;
                    previewFoto.style.display = 'block';
                    uploadHint.innerHTML = '<i class="fas fa-check-circle"></i> Foto sudah terupload';
                    uploadHint.classList.add('upload-hint-success');
                }
            }
        });
    
    document.getElementById('perPageSelect')?.addEventListener('change', function() {
        document.getElementById('perPageInput').value = this.value;
        document.getElementById('filterForm').submit();
    });
</script>
@endsection