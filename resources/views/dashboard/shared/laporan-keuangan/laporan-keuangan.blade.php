{{-- =============================================
     Dashboard Shared - Laporan Keuangan
     File: resources/views/dashboard/shared/laporan-keuangan/laporan-keuangan.blade.php
============================================= --}}

@extends('layouts.app')

@section('title', 'Laporan Keuangan')

@push('styles')
<style>
    .filter-select {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='10' viewBox='0 0 24 24' fill='none' stroke='%236B7280' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
        background-size: 12px 12px;
        padding-right: 36px !important;
    }
</style>
@endpush

@section('content')
<div style="width: 100%;">

    @php $role = $role ?? (Auth::user()->peran); @endphp

    {{-- ── 1. HEADER HALAMAN ── --}}
    <div style="margin-bottom: 25px;">
        <p style="color: #374151; font-size: 13px; margin: 0 0 4px 0;">
            {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}
        </p>
        <h1 style="font-size: 26px; font-weight: 700; color: #111827; margin: 0; letter-spacing: -0.5px; line-height: 1.2;">
            Laporan Keuangan
        </h1>
        <p style="color: #374151; font-size: 14px; margin: 4px 0 0 0;">Data Laporan Arus Kas Masuk dan Keluar</p>
    </div>

    {{-- SESSION SUCCESS --}}
    @if(session('success'))
        <div style="background: #D1FAE5; color: #065F46; padding: 12px; border-radius: 10px; margin-bottom: 20px;">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    {{-- ── 2. RINGKASAN KARTU ── --}}
    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 30px;">
        <div style="background: white; padding: 20px; border-radius: 15px; border-left: 8px solid #4472DF; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
            <p style="margin: 0; color: #4472DF; font-weight: 700; font-size: 13px;">Pemasukan Periode Berjalan</p>
            <h3 style="margin: 10px 0 0; font-size: 20px; font-weight: 800; color: #4472DF;">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</h3>
        </div>
        <div style="background: white; padding: 20px; border-radius: 15px; border-left: 8px solid #D74E4E; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
            <p style="margin: 0; color: #D74E4E; font-weight: 700; font-size: 13px;">Pengeluaran Periode Berjalan</p>
            <h3 style="margin: 10px 0 0; font-size: 20px; font-weight: 800; color: #D74E4E;">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</h3>
        </div>
        <div style="background: white; padding: 20px; border-radius: 15px; border-left: 8px solid #E7C255; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
            <p style="margin: 0; color: #E7C255; font-weight: 700; font-size: 13px;">Pelunasan Piutang</p>
            <h3 style="margin: 10px 0 0; font-size: 20px; font-weight: 800; color: #E7C255;">Rp {{ number_format($totalPiutang, 0, ',', '.') }}</h3>
        </div>
        <div style="background: white; padding: 20px; border-radius: 15px; border-left: 8px solid #4AB462; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
            <p style="margin: 0; color: #4AB462; font-weight: 700; font-size: 13px;">Pendapatan Uang Dimuka</p>
            <h3 style="margin: 10px 0 0; font-size: 20px; font-weight: 800; color: #4AB462;">Rp {{ number_format($totalUangMuka, 0, ',', '.') }}</h3>
        </div>
        <div style="background: white; padding: 20px; border-radius: 15px; border-left: 8px solid #ACB2AD; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
            <p style="margin: 0; color: #ACB2AD; font-weight: 700; font-size: 13px;">Total Pemasukan Kas</p>
            <h3 style="margin: 10px 0 0; font-size: 20px; font-weight: 800; color: #ACB2AD;">Rp {{ number_format($totalPemasukanKas, 0, ',', '.') }}</h3>
        </div>
        <div style="background: white; padding: 20px; border-radius: 15px; border-left: 8px solid #4D0B87; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
            <p style="margin: 0; color: #4D0B87; font-weight: 700; font-size: 13px;">Saldo Kas</p>
            <h3 style="margin: 10px 0 0; font-size: 20px; font-weight: 800; color: #4D0B87;">Rp {{ number_format($saldoKas, 0, ',', '.') }}</h3>
        </div>
    </div>

    {{-- ── 3. FILTER & TOMBOL TAMBAH ── --}}
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; gap: 15px;">
        <div style="display: flex; align-items: center; gap: 12px; flex: 1;">
            <div style="position: relative; width: 280px;">
                <i class="fas fa-search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #9CA3AF;"></i>
                <input type="text" id="searchInput" placeholder="Cari..."
                       style="width: 100%; padding: 10px 15px 10px 45px; border-radius: 12px; border: 1px solid #E5E7EB; outline: none; background: white; font-size: 14px; color: #374151;">
            </div>
        </div>

        <a href="{{ route($role . '.laporan-keuangan.create') }}" style="text-decoration: none;">
            <button style="background-color: #4D0B87; color: white; border: none; padding: 12px 25px; border-radius: 12px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 10px; font-size: 14px;">
                <i class="fas fa-plus"></i> Tambah
            </button>
        </a>
    </div>

    {{-- ── 4. TABEL PEMASUKAN ── --}}
    <div style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.08); border: 1px solid #F3F4F6; margin-bottom: 25px;">
        <div style="padding: 20px 20px 15px;">
            <h4 style="margin: 0; font-size: 15px; font-weight: 700; color: #111827;">Riwayat Pemasukan Periode Berjalan</h4>
        </div>
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 13px; white-space: nowrap;">
                <thead>
                    <tr style="background: #A2B9EE; color: #111827;">
                        <th style="padding: 15px; font-weight: 700; text-align: center; width: 50px;">No</th>
                        <th style="padding: 15px; font-weight: 700;">Tanggal</th>
                        <th style="padding: 15px; font-weight: 700;">Rincian Pemasukan</th>
                        <th style="padding: 15px; font-weight: 700; text-align: right;">Jumlah</th>
                        <th style="padding: 15px; font-weight: 700; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tablePemasukan" style="color: #374151;">
                    @forelse($pemasukan as $index => $p)
                    <tr style="border-bottom: 1px solid #F3F4F6; background: #F0F4FF;">
                        <td style="padding: 15px; text-align: center;">{{ $loop->iteration }}</td>
                        <td style="padding: 15px;">{{ \Carbon\Carbon::parse($p->tanggal)->format('d M Y') }}</td>
                        <td style="padding: 15px;">{{ $p->rincian }}</td>
                        <td style="padding: 15px; text-align: right; font-weight: 700; color: #4472DF;">Rp {{ number_format($p->jumlah, 0, ',', '.') }}</td>
                        <td style="padding: 15px; text-align: center;">
                            <form action="{{ route($role . '.laporan-keuangan.destroy', $p->id_keuangan) }}" method="POST" onsubmit="return confirm('Yakin hapus data ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" style="background: #E35D5D; color: white; padding: 6px 12px; border-radius: 6px; border: none; cursor: pointer;">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="padding: 40px; text-align: center; color: #9CA3AF;">Belum ada data pemasukan</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div style="display: flex; justify-content: space-between; padding: 15px 20px; background: #F9FAFB; border-top: 1px solid #F3F4F6;">
            <span style="font-size: 14px; font-weight: 700; color: #111827;">Total Pemasukan Periode Berjalan</span>
            <span style="font-size: 15px; font-weight: 800; color: #4472DF;">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</span>
        </div>
    </div>

    {{-- ── 5. TABEL PENGELUARAN ── --}}
    <div style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.08); border: 1px solid #F3F4F6; margin-bottom: 25px;">
        <div style="padding: 20px 20px 15px;">
            <h4 style="margin: 0; font-size: 15px; font-weight: 700; color: #111827;">Riwayat Pengeluaran Periode Berjalan</h4>
        </div>
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 13px; white-space: nowrap;">
                <thead>
                    <tr style="background: #EEA2A2; color: #111827;">
                        <th style="padding: 15px; font-weight: 700; text-align: center; width: 50px;">No</th>
                        <th style="padding: 15px; font-weight: 700;">Tanggal</th>
                        <th style="padding: 15px; font-weight: 700;">Rincian Pengeluaran</th>
                        <th style="padding: 15px; font-weight: 700; text-align: right;">Jumlah</th>
                        <th style="padding: 15px; font-weight: 700; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tablePengeluaran">
                    @forelse($pengeluaran as $index => $p)
                    <tr style="border-bottom: 1px solid #F3F4F6; background: #FFF0F0;">
                        <td style="padding: 15px; text-align: center;">{{ $loop->iteration }}</td>
                        <td style="padding: 15px;">{{ \Carbon\Carbon::parse($p->tanggal)->format('d M Y') }}</td>
                        <td style="padding: 15px;">{{ $p->rincian }}</td>
                        <td style="padding: 15px; text-align: right; font-weight: 700; color: #D74E4E;">Rp {{ number_format($p->jumlah, 0, ',', '.') }}</td>
                        <td style="padding: 15px; text-align: center;">
                            <form action="{{ route($role . '.laporan-keuangan.destroy', $p->id_keuangan) }}" method="POST" onsubmit="return confirm('Yakin hapus data ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" style="background: #E35D5D; color: white; padding: 6px 12px; border-radius: 6px; border: none; cursor: pointer;">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="padding: 40px; text-align: center; color: #9CA3AF;">Belum ada data pengeluaran</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div style="display: flex; justify-content: space-between; padding: 15px 20px; background: #F9FAFB; border-top: 1px solid #F3F4F6;">
            <span style="font-size: 14px; font-weight: 700; color: #111827;">Total Pengeluaran Periode Berjalan</span>
            <span style="font-size: 15px; font-weight: 800; color: #D74E4E;">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</span>
        </div>
    </div>

    {{-- TABEL PIUTANG --}}
    <div style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.08); border: 1px solid #F3F4F6; margin-bottom: 25px;">
        <div style="padding: 20px 20px 15px;">
            <h4 style="margin: 0; font-size: 15px; font-weight: 700; color: #111827;">Riwayat Pelunasan Piutang (Tunggakan)</h4>
        </div>
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 13px;">
                <thead>
                    <tr style="background: #EEDCA2; color: #111827;">
                        <th style="padding: 15px;">No</th>
                        <th style="padding: 15px;">Tanggal</th>
                        <th style="padding: 15px;">Nama Murid</th>
                        <th style="padding: 15px;">Bulan Tagihan</th>
                        <th style="padding: 15px; text-align: right;">Jumlah</th>
                        <th style="padding: 15px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($piutang as $index => $p)
                    <tr style="border-bottom: 1px solid #F3F4F6; background: #FFFDF0;">
                        <td style="padding: 15px;">{{ $loop->iteration }}</td>
                        <td style="padding: 15px;">{{ \Carbon\Carbon::parse($p->tanggal)->format('d M Y') }}</td>
                        <td style="padding: 15px;">{{ $p->nama_murid }}</td>
                        <td style="padding: 15px;">{{ $p->bulan_periode }}</td>
                        <td style="padding: 15px; text-align: right; font-weight: 700; color: #E7C255;">Rp {{ number_format($p->jumlah, 0, ',', '.') }}</td>
                        <td style="padding: 15px; text-align: center;">
                            <form action="{{ route($role . '.laporan-keuangan.destroy', $p->id_keuangan) }}" method="POST" onsubmit="return confirm('Yakin hapus?')">
                                @csrf @method('DELETE')
                                <button type="submit" style="background: #E35D5D; color: white; padding: 6px 12px; border-radius: 6px; border: none; cursor: pointer;">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="padding: 40px; text-align: center;">Belum ada data piutang</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div style="display: flex; justify-content: space-between; padding: 15px 20px; background: #F9FAFB; border-top: 1px solid #F3F4F6;">
            <span style="font-size: 14px; font-weight: 700;">Total Pemasukan Piutang</span>
            <span style="font-size: 15px; font-weight: 800; color: #E7C255;">Rp {{ number_format($totalPiutang, 0, ',', '.') }}</span>
        </div>
    </div>

    {{-- TABEL UANG MUKA --}}
    <div style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.08); border: 1px solid #F3F4F6; margin-bottom: 25px;">
        <div style="padding: 20px 20px 15px;">
            <h4 style="margin: 0; font-size: 15px; font-weight: 700; color: #111827;">Riwayat Pendapatan Uang Dimuka</h4>
        </div>
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 13px;">
                <thead>
                    <tr style="background: #A2EEB9; color: #111827;">
                        <th style="padding: 15px;">No</th>
                        <th style="padding: 15px;">Tanggal</th>
                        <th style="padding: 15px;">Nama Murid</th>
                        <th style="padding: 15px;">Periode</th>
                        <th style="padding: 15px; text-align: right;">Jumlah</th>
                        <th style="padding: 15px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($uang_muka as $index => $u)
                    <tr style="border-bottom: 1px solid #F3F4F6; background: #F0FFF4;">
                        <td style="padding: 15px;">{{ $loop->iteration }}</td>
                        <td style="padding: 15px;">{{ \Carbon\Carbon::parse($u->tanggal)->format('d M Y') }}</td>
                        <td style="padding: 15px;">{{ $u->nama_murid }}</td>
                        <td style="padding: 15px;">{{ $u->bulan_periode }}</td>
                        <td style="padding: 15px; text-align: right; font-weight: 700; color: #4AB462;">Rp {{ number_format($u->jumlah, 0, ',', '.') }}</td>
                        <td style="padding: 15px; text-align: center;">
                            <form action="{{ route($role . '.laporan-keuangan.destroy', $u->id_keuangan) }}" method="POST" onsubmit="return confirm('Yakin hapus?')">
                                @csrf @method('DELETE')
                                <button type="submit" style="background: #E35D5D; color: white; padding: 6px 12px; border-radius: 6px; border: none; cursor: pointer;">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="padding: 40px; text-align: center;">Belum ada data uang muka</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div style="display: flex; justify-content: space-between; padding: 15px 20px; background: #F9FAFB; border-top: 1px solid #F3F4F6;">
            <span style="font-size: 14px; font-weight: 700;">Total Pendapatan Uang Dimuka</span>
            <span style="font-size: 15px; font-weight: 800; color: #4AB462;">Rp {{ number_format($totalUangMuka, 0, ',', '.') }}</span>
        </div>
    </div>

    {{-- ── TOMBOL EXPORT PDF ── --}}
    <button style="width: 100%; background: #22C55E; color: white; border: none; padding: 18px; border-radius: 15px; font-size: 16px; font-weight: 700; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 12px; margin-bottom: 30px;">
        <i class="fas fa-file-pdf" style="font-size: 20px;"></i> EXPORT PDF
    </button>

</div>

<script>
    // Search sederhana
    document.getElementById('searchInput').addEventListener('keyup', function() {
        let searchValue = this.value.toLowerCase();
        let tables = ['tablePemasukan', 'tablePengeluaran'];
        
        tables.forEach(tableId => {
            let rows = document.querySelectorAll('#' + tableId + ' tr');
            rows.forEach(row => {
                let text = row.innerText.toLowerCase();
                row.style.display = text.includes(searchValue) ? '' : 'none';
            });
        });
    });
</script>
@endsection