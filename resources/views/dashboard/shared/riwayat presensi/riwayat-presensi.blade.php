@extends('layouts.app')

@section('title', 'Riwayat Pengajaran')

@push('styles')
<style>
    .table thead th {
        white-space: nowrap;
    }
    .badge-hadir {
        background: #D1FAE5 !important;
        color: #065F46 !important;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }
    .badge-tidak-hadir {
        background: #FEE2E2 !important;
        color: #991B1B !important;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }
    .badge-verified {
        background: #D1FAE5 !important;
        color: #065F46 !important;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        cursor: pointer;
    }
    .btn-verifikasi {
        background: none;
        border: none;
        cursor: pointer;
        color: #9CA3AF;
        font-size: 13px;
        padding: 4px 10px;
        border-radius: 20px;
        transition: 0.2s;
    }
    .btn-verifikasi:hover {
        background: #F3E8FF;
        color: #4D0B87;
    }
    .badge-sesi-pertama {
        background: #E0E7FF !important;
        color: #3730A3 !important;
        padding: 2px 8px;
        border-radius: 10px;
        font-size: 10px;
        font-weight: 600;
    }
    .badge-sesi-lain {
        background: #F3F4F6 !important;
        color: #6B7280 !important;
        padding: 2px 8px;
        border-radius: 10px;
        font-size: 10px;
    }
    
    /* MODAL PREVIEW FOTO */
    .modal-preview-foto {
        display: none;
        position: fixed;
        z-index: 99999;
        left: 0; top: 0;
        width: 100%; height: 100%;
        background: rgba(0,0,0,0.85);
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
    .modal-preview-header {
        position: fixed;
        top: 0; left: 0; right: 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 20px;
        background: rgba(0,0,0,0.6);
        color: white;
        font-family: 'Poppins', sans-serif;
        z-index: 10;
    }
    .modal-preview-header .tentor-info {
        font-size: 14px;
        font-weight: 500;
    }
    .modal-preview-header .tentor-info strong {
        font-weight: 600;
    }
    .modal-preview-header .tentor-info small {
        color: #D1D5DB;
        font-weight: 400;
        font-size: 12px;
    }
    .modal-preview-header .header-actions {
        display: flex;
        gap: 8px;
        align-items: center;
    }
    .modal-preview-header .btn-icon {
        background: rgba(255,255,255,0.15);
        border: none;
        color: white;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 16px;
        transition: 0.2s;
        text-decoration: none;
    }
    .modal-preview-header .btn-icon:hover {
        background: rgba(255,255,255,0.3);
    }
    .modal-preview-body {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 100%;
        padding: 60px 20px 20px 20px;
    }
    .modal-preview-body img {
        max-width: 95%;
        max-height: 88vh;
        object-fit: contain;
        border-radius: 4px;
    }
    
    .btn-foto {
        background: #F3E8FF;
        color: #4D0B87;
        width: 30px;
        height: 30px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        border: none;
        transition: 0.2s;
    }
    .btn-foto:hover {
        background: #E0D5FF;
    }
</style>
@endpush

@section('content')
<div style="width: 100%;">
    
    {{-- HEADER --}}
    <div style="margin-bottom: 25px;">
        <p style="color: #374151; font-size: 13px; margin: 0 0 4px 0;">
            {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}
        </p>
        <h1 style="font-size: 26px; font-weight: 700; color: #111827; margin: 0; letter-spacing: -0.5px; line-height: 1.2;">
            Riwayat Pengajaran
        </h1>
        <p style="color: #374151; font-size: 14px; margin: 4px 0 0 0;">Lihat Riwayat Pengajaran Semua Tentor</p>
    </div>

    {{-- ALERT SUCCESS/ERROR --}}
    @if(session('success'))
        <div style="background: #D1FAE5; color: #065F46; padding: 12px; border-radius: 10px; margin-bottom: 20px;">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div style="background: #FEE2E2; color: #EF4444; padding: 12px; border-radius: 10px; margin-bottom: 20px;">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        </div>
    @endif

    {{-- FILTER --}}
    <form method="GET" action="{{ route($role . '.kelola-presensi') }}" id="filterForm">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; gap: 15px;">
            <div style="display: flex; align-items: center; gap: 12px; flex: 1; flex-wrap: wrap;">
                
                {{-- SEARCH BAR --}}
                <div style="position: relative; width: 300px;">
                    <i class="fas fa-search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #9CA3AF;"></i>
                    <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari Nama Tentor, Kelas..."
                           style="width: 100%; padding: 10px 15px 10px 45px; border-radius: 12px; border: 1px solid #E5E7EB; outline: none; background: white; font-size: 14px; color: #374151;">
                </div>

                {{-- FILTER TENTOR --}}
                <select name="tentor" style="padding: 10px 12px; border-radius: 12px; border: 1px solid #E5E7EB; color: #374151; font-size: 13px; min-width: 180px; background: white; outline: none; cursor: pointer;" onchange="this.form.submit()">
                    <option value="">Semua Tentor</option>
                    @foreach($tentors ?? [] as $t)
                        <option value="{{ $t->id_pegawai }}" {{ ($tentorFilter ?? '') == $t->id_pegawai ? 'selected' : '' }}>
                            {{ $t->nama_lengkap }}
                        </option>
                    @endforeach
                </select>

                {{-- FILTER BULAN --}}
                @php
                    $bulanSekarang = date('n');
                    $requestBulan = request('bulan');
                @endphp
                <select name="bulan" style="padding: 10px 12px; border-radius: 12px; border: 1px solid #E5E7EB; color: #374151; font-size: 13px; min-width: 140px; background: white; outline: none; cursor: pointer;" onchange="this.form.submit()">
                    @foreach(range(1, 12) as $b)
                        @php
                            $selected = false;
                            if ($requestBulan) {
                                $selected = ($requestBulan == $b);
                            } else {
                                $selected = ($bulanSekarang == $b);
                            }
                        @endphp
                        <option value="{{ $b }}" {{ $selected ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($b)->translatedFormat('F') }}
                        </option>
                    @endforeach
                </select>

                {{-- FILTER TAHUN --}}
                @php
                    $tahunSekarang = date('Y');
                    $requestTahun = request('tahun');
                @endphp
                <select name="tahun" style="padding: 10px 12px; border-radius: 12px; border: 1px solid #E5E7EB; color: #374151; font-size: 13px; min-width: 100px; background: white; outline: none; cursor: pointer;" onchange="this.form.submit()">
                    @foreach($tahunList ?? [] as $th)
                        @php
                            $selected = false;
                            if ($requestTahun) {
                                $selected = ($requestTahun == $th);
                            } else {
                                $selected = ($tahunSekarang == $th);
                            }
                        @endphp
                        <option value="{{ $th }}" {{ $selected ? 'selected' : '' }}>{{ $th }}</option>
                    @endforeach
                </select>
                
                {{-- RESET --}}
                @if(($bulan ?? '') || ($tahun ?? '') || ($search ?? '') || ($tentorFilter ?? ''))
                    <a href="{{ route($role . '.kelola-presensi') }}" style="padding: 10px 15px; border-radius: 12px; background: #F3F4F6; color: #374151; text-decoration: none; font-size: 13px;">
                        <i class="fas fa-times"></i> Reset
                    </a>
                @endif
            </div>
        </div>
        
        <input type="hidden" name="perPage" id="perPageInput" value="{{ request('perPage', 10) }}">
    </form>

    {{-- TABEL --}}
    <div style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.08); border: 1px solid #F3F4F6;">
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 13px; white-space: nowrap;">
                <thead>
                    <tr style="background: #F3E8FF; color: #111827;">
                        <th style="padding: 15px; font-weight: 700; width: 40px;">No</th>
                        <th style="padding: 15px; font-weight: 700;">Nama Tentor</th>
                        <th style="padding: 15px; font-weight: 700;">Tanggal</th>
                        <th style="padding: 15px; font-weight: 700;">Masuk</th>
                        <th style="padding: 15px; font-weight: 700;">Keluar</th>
                        <th style="padding: 15px; font-weight: 700;">Kelas</th>
                        <th style="padding: 15px; font-weight: 700;">Ruang</th>
                        <th style="padding: 15px; font-weight: 700; text-align: center;">Status Murid</th>
                        <th style="padding: 15px; font-weight: 700; text-align: right;">Honor Dasar</th>
                        <th style="padding: 15px; font-weight: 700; text-align: center;">Potongan</th>
                        <th style="padding: 15px; font-weight: 700; text-align: right;">Honor Akhir</th>
                        <th style="padding: 15px; font-weight: 700; text-align: right;">Uang Makan</th>
                        <th style="padding: 15px; font-weight: 700; text-align: right;">Transport</th>
                        <th style="padding: 15px; font-weight: 700; text-align: right;">Total Honor</th>
                        <th style="padding: 15px; font-weight: 700; text-align: left;">Keterangan</th>
                        <th style="padding: 15px; font-weight: 700; text-align: center;">Foto</th>
                        <th style="padding: 15px; font-weight: 700; text-align: center;">Verif</th>
                        @if($role == 'superadmin')
                        <th style="padding: 15px; font-weight: 700; text-align: center;">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody id="tableBody" style="color: #374151;">
                    @php $totalHonorKeseluruhan = 0; @endphp
                    @forelse($presensi as $index => $item)
                    @php
                        $namaTentor = $item->pegawai->nama_lengkap ?? '-';
                        $tanggal = \Carbon\Carbon::parse($item->tanggal)->format('d F Y');
                        $namaKelas = $item->kelas ? $item->kelas->jenjang . ' - ' . $item->kelas->nama_kelas : '-';
                        $namaRuang = $item->ruang ? $item->ruang->nama_ruang : '-';
                        $jenjang = $item->kelas->jenjang ?? 'SD';
                        
                        $isHadir = $item->murid_hadir == 'Hadir';
                        $statusText = $isHadir ? 'Hadir' : 'Tidak Hadir';
                        $statusClass = $isHadir ? 'badge-hadir' : 'badge-tidak-hadir';
                        
                        $isVerified = in_array($item->id_mengajar, $verifiedIds ?? []);
                        $isSesiPertama = in_array($item->id_mengajar, $sesiPertamaIds ?? []);
                        
                        $jamMasuk = $item->jam_mulai ? \Carbon\Carbon::parse($item->jam_mulai)->format('H:i') : '-';
                        $jamKeluar = $item->jam_selesai ? \Carbon\Carbon::parse($item->jam_selesai)->format('H:i') : '-';
                        
                        $honorPerJam = 0;
                        if ($item->pegawai) {
                            switch ($jenjang) {
                                case 'SD': $honorPerJam = $item->pegawai->hr_sd ?? 0; break;
                                case 'SMP': $honorPerJam = $item->pegawai->hr_smp ?? 0; break;
                                case 'SMA': $honorPerJam = $item->pegawai->hr_sma ?? 0; break;
                            }
                        }
                        
                        $lamaMengajar = $item->lama_mengajar ?? 0;
                        $jamMengajar = max(1, ceil($lamaMengajar / 60));
                        $honorDasar = $honorPerJam * $jamMengajar;
                        
                        if (!$isHadir) {
                            $potongan = $honorDasar * 0.5;
                            $honorAkhir = $honorDasar * 0.5;
                        } else {
                            $potongan = 0;
                            $honorAkhir = $honorDasar;
                        }
                        
                        if ($isSesiPertama) {
                            $uangMakan = $item->pegawai->uang_makan ?? 0;
                            $transport = $item->pegawai->uang_transport ?? 0;
                        } else {
                            $uangMakan = 0;
                            $transport = 0;
                        }
                        
                        $totalHonorItem = $honorAkhir + $uangMakan + $transport;
                        $totalHonorKeseluruhan += $totalHonorItem;
                        
                        $downloadUrl = route($role . '.kelola-presensi.download', $item->id_mengajar);
                    @endphp
                    <tr style="border-bottom: 1px solid #F3F4F6; transition: 0.2s;" onmouseover="this.style.background='#F9FAFB'" onmouseout="this.style.background='transparent'">
                        <td style="padding: 15px;">{{ $presensi->firstItem() + $index }}</td>
                        <td style="padding: 15px; font-weight: 500;">
                            {{ $namaTentor }}
                            @if($isSesiPertama)
                                <br><span class="badge-sesi-pertama">Sesi 1</span>
                            @endif
                        </td>
                        <td style="padding: 15px;">{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                        <td style="padding: 15px;">{{ $jamMasuk }}</td>
                        <td style="padding: 15px;">{{ $jamKeluar }}</td>
                        <td style="padding: 15px;">{{ $namaKelas }}</td>
                        <td style="padding: 15px;">{{ $namaRuang }}</td>
                        <td style="padding: 15px; text-align: center;">
                            <span class="{{ $statusClass }}">{{ $statusText }}</span>
                        </td>
                        <td style="padding: 15px; text-align: right;">Rp {{ number_format($honorDasar, 0, ',', '.') }}</td>
                        <td style="padding: 15px; text-align: center;">
                            @if(!$isHadir)
                                <span style="color: #EF4444; font-size: 11px;">-50%</span>
                                <br><span style="color: #EF4444; font-size: 11px;">(Rp {{ number_format($potongan, 0, ',', '.') }})</span>
                            @else
                                <span style="color: #10B981;">-</span>
                            @endif
                        </td>
                        <td style="padding: 15px; text-align: right; font-weight: 600; color: #4D0B87;">Rp {{ number_format($honorAkhir, 0, ',', '.') }}</td>
                        <td style="padding: 15px; text-align: right;">
                            @if($isSesiPertama) Rp {{ number_format($uangMakan, 0, ',', '.') }}
                            @else <span style="color: #9CA3AF;">-</span> @endif
                        </td>
                        <td style="padding: 15px; text-align: right;">
                            @if($isSesiPertama) Rp {{ number_format($transport, 0, ',', '.') }}
                            @else <span style="color: #9CA3AF;">-</span> @endif
                        </td>
                        <td style="padding: 15px; text-align: right; font-weight: 700; color: #111827;">Rp {{ number_format($totalHonorItem, 0, ',', '.') }}</td>
                        <td style="padding: 15px; text-align: left; white-space: normal; word-break: break-word; max-width: 200px;" title="{{ $item->keterangan ?? '' }}">
                            {{ $item->keterangan ?: '-' }}
                        </td>
                        <td style="padding: 15px; text-align: center;">
                            @if($item->bukti_mengajar)
                                <button onclick="bukaPreviewFoto('{{ asset('storage/' . $item->bukti_mengajar) }}', '{{ addslashes($namaTentor) }}', '{{ addslashes($tanggal) }}', '{{ asset('storage/' . $item->bukti_mengajar) }}')" class="btn-foto" title="Lihat Foto">
                                    <i class="fas fa-image"></i>
                                </button>
                            @else
                                <span style="color: #9CA3AF;">-</span>
                            @endif
                        </td>
                        <td style="padding: 15px; text-align: center;">
                            @if($role == 'superadmin' || $role == 'admin')
                                @if($isVerified)
                                    <form method="POST" action="{{ route($role . '.kelola-presensi.unverify', $item->id_mengajar) }}" style="display: inline;">
                                        @csrf
                                        <button type="submit" style="background: none; border: none; cursor: pointer;" title="Klik untuk batal verifikasi">
                                            <span class="badge-verified">✅ Verified</span>
                                        </button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route($role . '.kelola-presensi.verify', $item->id_mengajar) }}" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn-verifikasi" title="Klik untuk verifikasi">
                                            <i class="far fa-check-circle"></i> Verifikasi
                                        </button>
                                    </form>
                                @endif
                            @else
                                @if($isVerified)
                                    <span class="badge-verified">✅ Verified</span>
                                @else
                                    <span style="color: #9CA3AF; font-size: 13px;">⏳ Pending</span>
                                @endif
                            @endif
                        </td>
                        @if($role == 'superadmin')
                        <td style="padding: 15px; text-align: center;">
                            <button type="button" 
                                    onclick="bukaModalHapus({{ $item->id_mengajar }}, '{{ addslashes($namaTentor) }}', '{{ \Carbon\Carbon::parse($item->tanggal)->format('d F Y') }}')" 
                                    style="background: #E35D5D; color: white; padding: 6px 10px; border-radius: 6px; border: none; cursor: pointer; font-size: 11px;">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                        @endif
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ $role == 'superadmin' ? '18' : '17' }}" style="padding: 40px; text-align: center; color: #9CA3AF;">
                            <i class="fas fa-calendar-alt" style="font-size: 40px; margin-bottom: 10px; display: block;"></i>
                            Belum ada data presensi
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- TOTAL HONOR --}}
    @if($presensi->count() > 0)
    <div style="padding: 15px 30px; display: flex; justify-content: flex-end; align-items: center; background: #F9FAFB; border-top: 2px solid #F3F4F6; border-radius: 0 0 20px 20px;">
        <span style="font-size: 15px; font-weight: 700; color: #374151; margin-right: 15px;">Total Honor Bulan Ini :</span>
        <div style="background: #10B981; color: white; padding: 10px 25px; border-radius: 12px; font-size: 17px; font-weight: 800; box-shadow: 0 4px 10px rgba(16, 185, 129, 0.2);">
            Rp {{ number_format($totalHonorKeseluruhan, 0, ',', '.') }}
        </div>
    </div>
    @endif

    {{-- PAGINATION --}}
    @if($presensi->hasPages())
    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px; padding: 0 5px;">
        <div style="display: flex; align-items: center; gap: 10px;">
            <select id="perPageSelect" style="padding: 8px 12px; border-radius: 10px; border: 1px solid #E5E7EB; color: #374151; font-size: 13px; background: white; outline: none; cursor: pointer;">
                <option value="10" {{ request('perPage', 10) == 10 ? 'selected' : '' }}>10 baris</option>
                <option value="25" {{ request('perPage', 10) == 25 ? 'selected' : '' }}>25 baris</option>
                <option value="50" {{ request('perPage', 10) == 50 ? 'selected' : '' }}>50 baris</option>
            </select>
            <span style="color: #374151; font-size: 13px;">
                Menampilkan {{ $presensi->firstItem() }} - {{ $presensi->lastItem() }} dari {{ $presensi->total() }} data
            </span>
        </div>
        <div style="display: flex; gap: 5px;">
            @if($presensi->onFirstPage())
                <button style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: #F3F4F6; color: #9CA3AF; cursor: not-allowed;" disabled><i class="fas fa-angle-double-left"></i></button>
            @else
                <a href="{{ $presensi->url(1) }}" style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; display: flex; align-items: center; justify-content: center; text-decoration: none;"><i class="fas fa-angle-double-left"></i></a>
            @endif
            @if($presensi->onFirstPage())
                <button style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: #F3F4F6; color: #9CA3AF; cursor: not-allowed;" disabled><i class="fas fa-angle-left"></i></button>
            @else
                <a href="{{ $presensi->previousPageUrl() }}" style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; display: flex; align-items: center; justify-content: center; text-decoration: none;"><i class="fas fa-angle-left"></i></a>
            @endif
            <button style="width: 35px; height: 35px; border-radius: 8px; background: #4D0B87; color: white; border: none; font-weight: 600; cursor: default;">{{ $presensi->currentPage() }}</button>
            @if($presensi->hasMorePages())
                <a href="{{ $presensi->nextPageUrl() }}" style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; display: flex; align-items: center; justify-content: center; text-decoration: none;"><i class="fas fa-angle-right"></i></a>
            @else
                <button style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: #F3F4F6; color: #9CA3AF; cursor: not-allowed;" disabled><i class="fas fa-angle-right"></i></button>
            @endif
            @if($presensi->hasMorePages())
                <a href="{{ $presensi->url($presensi->lastPage()) }}" style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; display: flex; align-items: center; justify-content: center; text-decoration: none;"><i class="fas fa-angle-double-right"></i></a>
            @else
                <button style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: #F3F4F6; color: #9CA3AF; cursor: not-allowed;" disabled><i class="fas fa-angle-double-right"></i></button>
            @endif
        </div>
    </div>
    @endif

</div>

{{-- MODAL PREVIEW FOTO --}}
<div id="modalPreviewFoto" class="modal-preview-foto" onclick="tutupPreviewFoto(event)">
    <div class="modal-preview-header">
        <span class="tentor-info" id="previewTentorInfo">-</span>
        <div class="header-actions">
            <a href="#" id="previewDownloadBtn" class="btn-icon" title="Download" download>
                <i class="fas fa-download"></i>
            </a>
            <button onclick="document.getElementById('modalPreviewFoto').style.display='none'" class="btn-icon" title="Tutup">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    <div class="modal-preview-body">
        <img id="previewFotoImg" src="" alt="Foto Bukti Mengajar">
    </div>
</div>

{{-- MODAL HAPUS - HANYA BISA DITUTUP DENGAN TOMBOL BATAL --}}
<div id="modalHapus" style="display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); backdrop-filter: blur(3px); align-items: center; justify-content: center;">
    <div style="background: white; padding: 25px; border-radius: 20px; width: 380px; text-align: center; box-shadow: 0 15px 30px rgba(0,0,0,0.15); font-family: 'Poppins', sans-serif;">
        <div style="color: #E35D5D; font-size: 40px; margin-bottom: 10px;"><i class="fas fa-trash-alt"></i></div>
        <h2 style="margin: 0; font-size: 18px; color: #111827; font-weight: 700;">Hapus Data Presensi?</h2>
        <p style="color: #6B7280; font-size: 13px; margin: 8px 0 20px 0; line-height: 1.5;" id="pesanHapus"></p>
        <div style="display: flex; gap: 10px; justify-content: center;">
            <button onclick="tutupModalHapus()" style="flex: 1; padding: 10px; border-radius: 10px; border: 1px solid #E5E7EB; background: white; font-weight: 600; font-size: 13px; cursor: pointer;">Batal</button>
            <form id="formHapus" method="POST" style="flex: 1;">
                @csrf @method('DELETE')
                <button type="submit" style="width: 100%; padding: 10px; border-radius: 10px; border: none; background: #E35D5D; color: white; font-weight: 600; font-size: 13px; cursor: pointer;">Ya, Hapus</button>
            </form>
        </div>
    </div>
</div>

<script>
    // ========== PER PAGE ==========
    document.getElementById('perPageSelect')?.addEventListener('change', function() {
        document.getElementById('perPageInput').value = this.value;
        document.getElementById('filterForm').submit();
    });

    // ========== PREVIEW FOTO ==========
    function bukaPreviewFoto(url, namaTentor, tanggal, downloadUrl) {
        document.getElementById('previewFotoImg').src = url;
        document.getElementById('previewTentorInfo').innerHTML = '<strong>' + namaTentor + '</strong> <small>- ' + tanggal + '</small>';
        document.getElementById('previewDownloadBtn').href = downloadUrl;
        document.getElementById('modalPreviewFoto').style.display = 'flex';
    }

    function tutupPreviewFoto(event) {
        if (event.target === document.getElementById('modalPreviewFoto')) {
            document.getElementById('modalPreviewFoto').style.display = 'none';
        }
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            document.getElementById('modalPreviewFoto').style.display = 'none';
        }
    });

    // ========== MODAL HAPUS - TIDAK BISA TUTUP DENGAN KLIK DI LUAR ==========
    function bukaModalHapus(id, nama, tanggal) {
        let form = document.getElementById('formHapus');
        let url = "{{ route($role . '.kelola-presensi.destroy', ':id') }}";
        url = url.replace(':id', id);
        form.action = url;
        document.getElementById('pesanHapus').innerHTML = 'Apakah Anda <strong>benar-benar yakin</strong> ingin menghapus data presensi <strong>' + nama + '</strong><br>tanggal <strong>' + tanggal + '</strong>?<br><br><small style="color:#EF4444;">⚠️ <strong>PERINGATAN:</strong> Data yang dihapus tidak dapat dikembalikan.</small>';
        document.getElementById('modalHapus').style.display = 'flex';
    }

    function tutupModalHapus() { 
        document.getElementById('modalHapus').style.display = 'none'; 
    }

    // ⛔ TIDAK ADA EVENT LISTENER UNTUK TUTUP MODAL HAPUS DENGAN KLIK DI LUAR
    // HANYA BISA DITUTUP DENGAN TOMBOL BATAL
</script>
@endsection