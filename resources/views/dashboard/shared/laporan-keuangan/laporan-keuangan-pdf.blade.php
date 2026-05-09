<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan Keuangan - Rekap Kas</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 10pt;
            color: #000;
            padding: 24px 32px;
        }

        /* ── HEADER ── */
        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 6px;
        }

        .header-table td {
            vertical-align: middle;
            padding: 0;
        }

        .logo-cell {
            width: 90px;
            text-align: center;
        }

        .logo-img {
            width: 70px;
            height: 70px;
            object-fit: contain;
        }

        .title-cell {
            text-align: center;
        }

        .title-main {
            font-size: 17pt;
            font-weight: bold;
            color: #4a0080;
            letter-spacing: 0.5px;
        }

        .title-sub {
            font-size: 11pt;
            font-weight: bold;
            color: #6a0dad;
            margin-top: 2px;
        }

        .header-line {
            border: none;
            border-top: 2px solid #6a0dad;
            margin: 8px 0 10px 0;
        }

        /* ── INFO CABANG PERIODE ── */
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .info-table td {
            font-size: 10pt;
            padding: 2px 4px;
        }

        /* ── MAIN DATA TABLE ── */
        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .c-label   { width: 42%; }
        .c-rp-item { width: 5%;  text-align: left; }
        .c-nom     { width: 18%; text-align: right; padding-right: 8px !important; }
        .c-rp-tot  { width: 6%;  text-align: left; }
        .c-tot     { width: 29%; text-align: right; padding-right: 10px !important; }

        .r-section td {
            background-color: #6a0dad;
            color: #ffffff;
            font-weight: bold;
            padding: 6px 10px;
            border: 1px solid #5a009d;
        }

        .r-item td {
            background-color: #ffffff;
            color: #000;
            padding: 5px 10px;
            border: 1px solid #cccccc;
        }

        .r-total td {
            background-color: #6a0dad;
            color: #ffffff;
            font-weight: bold;
            padding: 6px 10px;
            border: 1px solid #5a009d;
        }

        .r-saldo td {
            background-color: #6a0dad;
            color: #ffffff;
            font-weight: bold;
            padding: 7px 10px;
            border: 1px solid #5a009d;
        }

        .r-gap td {
            height: 7px;
            background: #fff;
            border: none;
            padding: 0;
        }

        /* ── TANDA TANGAN ── */
        .sig-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 26px;
        }

        .sig-table td {
            font-size: 10pt;
            padding: 3px 6px;
            vertical-align: top;
        }

        .sig-name {
            font-weight: bold;
            display: block;
            margin-top: 44px;
        }
    </style>
</head>
<body>

    {{-- ======== HEADER ======== --}}
    <table class="header-table">
        <tr>
            <td class="logo-cell">
                @if($logoBase64)
                    <img src="data:image/png;base64,{{ $logoBase64 }}" class="logo-img" alt="Logo">
                @endif
            </td>
            <td class="title-cell">
                <div class="title-main">LAPORAN KEUANGAN BULANAN</div>
                <div class="title-sub">REKAP KAS &mdash; CABANG {{ strtoupper($cabang) }}</div>
            </td>
        </tr>
    </table>
    <hr class="header-line">

    {{-- ======== INFO CABANG & PERIODE ======== --}}
    <table class="info-table">
        <tr>
            <td style="width:80px; font-weight:bold;">CABANG</td>
            <td style="width:14px; text-align:center;">:</td>
            <td style="width:200px;">{{ strtoupper($cabang) }}</td>
            <td style="width:80px; font-weight:bold;">PERIODE</td>
            <td style="width:14px; text-align:center;">:</td>
            <td>{{ strtoupper($periode) }}</td>
        </tr>
    </table>

    {{-- ======== DATA TABLE ======== --}}
    <table class="data-table">

        {{-- A. SALDO KAS AWAL --}}
        <tr class="r-section">
            <td class="c-label"><strong>A.&nbsp; SALDO KAS AWAL</strong></td>
            <td class="c-rp-item"></td>
            <td class="c-nom"></td>
            <td class="c-rp-tot"><strong>Rp.</strong></td>
            <td class="c-tot"><strong>{{ number_format($saldoAwal, 0, ',', '.') }}</strong></td>
        </tr>

        <tr class="r-gap"><td colspan="5"></td></tr>

        {{-- C. PENERIMAAN --}}
        <tr class="r-section">
            <td colspan="5"><strong>C.&nbsp; PENERIMAAN DANA OPERASIONAL</strong></td>
        </tr>
        <tr class="r-item">
            <td class="c-label">&nbsp;&nbsp;&nbsp;-&nbsp; Pendaftaran</td>
            <td class="c-rp-item">Rp.</td>
            <td class="c-nom">{{ number_format($pemasukanData['Pendaftaran'], 0, ',', '.') }}</td>
            <td class="c-rp-tot"></td>
            <td class="c-tot"></td>
        </tr>
        <tr class="r-item">
            <td class="c-label">&nbsp;&nbsp;&nbsp;-&nbsp; Bimbingan</td>
            <td class="c-rp-item">Rp.</td>
            <td class="c-nom">{{ number_format($pemasukanData['Bimbingan'], 0, ',', '.') }}</td>
            <td class="c-rp-tot"></td>
            <td class="c-tot"></td>
        </tr>
        <tr class="r-item">
            <td class="c-label">&nbsp;&nbsp;&nbsp;-&nbsp; Modal (Owner)</td>
            <td class="c-rp-item">Rp.</td>
            <td class="c-nom">{{ number_format($pemasukanData['Modal_Owner'], 0, ',', '.') }}</td>
            <td class="c-rp-tot"></td>
            <td class="c-tot"></td>
        </tr>
        <tr class="r-item">
            <td class="c-label">&nbsp;&nbsp;&nbsp;-&nbsp; Try Out</td>
            <td class="c-rp-item">Rp.</td>
            <td class="c-nom">{{ number_format($pemasukanData['TryOut'], 0, ',', '.') }}</td>
            <td class="c-rp-tot"></td>
            <td class="c-tot"></td>
        </tr>
        <tr class="r-item">
            <td class="c-label">&nbsp;&nbsp;&nbsp;-&nbsp; Lain-lain</td>
            <td class="c-rp-item">Rp.</td>
            <td class="c-nom">{{ number_format($pemasukanData['Lainnya_Pemasukan'], 0, ',', '.') }}</td>
            <td class="c-rp-tot"></td>
            <td class="c-tot"></td>
        </tr>
        <tr class="r-total">
            <td class="c-label"><strong>JUMLAH DANA OPERASIONAL</strong></td>
            <td class="c-rp-item"></td>
            <td class="c-nom"></td>
            <td class="c-rp-tot"><strong>Rp.</strong></td>
            <td class="c-tot"><strong>{{ number_format($totalPemasukan, 0, ',', '.') }}</strong></td>
        </tr>

        <tr class="r-gap"><td colspan="5"></td></tr>

        {{-- D. PENGELUARAN --}}
        <tr class="r-section">
            <td colspan="5"><strong>D.&nbsp; PENGELUARAN DANA OPERASIONAL</strong></td>
        </tr>
        <tr class="r-item">
            <td class="c-label">&nbsp;&nbsp;&nbsp;-&nbsp; Biaya Operasional</td>
            <td class="c-rp-item">Rp.</td>
            <td class="c-nom">{{ number_format($pengeluaranData['BiayaOperasional'], 0, ',', '.') }}</td>
            <td class="c-rp-tot"></td>
            <td class="c-tot"></td>
        </tr>
        <tr class="r-item">
            <td class="c-label">&nbsp;&nbsp;&nbsp;-&nbsp; Biaya Rapat &amp; Pelatihan</td>
            <td class="c-rp-item">Rp.</td>
            <td class="c-nom">{{ number_format($pengeluaranData['BiayaRapatPelatihan'], 0, ',', '.') }}</td>
            <td class="c-rp-tot"></td>
            <td class="c-tot"></td>
        </tr>
        <tr class="r-item">
            <td class="c-label">&nbsp;&nbsp;&nbsp;-&nbsp; Fee Management</td>
            <td class="c-rp-item">Rp.</td>
            <td class="c-nom">{{ number_format($pengeluaranData['FeeManagement'], 0, ',', '.') }}</td>
            <td class="c-rp-tot"></td>
            <td class="c-tot"></td>
        </tr>
        <tr class="r-item">
            <td class="c-label">&nbsp;&nbsp;&nbsp;-&nbsp; Pembelian Aktiva</td>
            <td class="c-rp-item">Rp.</td>
            <td class="c-nom">{{ number_format($pengeluaranData['PembelianAktiva'], 0, ',', '.') }}</td>
            <td class="c-rp-tot"></td>
            <td class="c-tot"></td>
        </tr>
        <tr class="r-item">
            <td class="c-label">&nbsp;&nbsp;&nbsp;-&nbsp; Modul</td>
            <td class="c-rp-item">Rp.</td>
            <td class="c-nom">{{ number_format($pengeluaranData['Modul'], 0, ',', '.') }}</td>
            <td class="c-rp-tot"></td>
            <td class="c-tot"></td>
        </tr>
        <tr class="r-item">
            <td class="c-label">&nbsp;&nbsp;&nbsp;-&nbsp; Biaya Akademik</td>
            <td class="c-rp-item">Rp.</td>
            <td class="c-nom">{{ number_format($pengeluaranData['BiayaAkademik'], 0, ',', '.') }}</td>
            <td class="c-rp-tot"></td>
            <td class="c-tot"></td>
        </tr>
        <tr class="r-item">
            <td class="c-label">&nbsp;&nbsp;&nbsp;-&nbsp; Biaya Pemasaran</td>
            <td class="c-rp-item">Rp.</td>
            <td class="c-nom">{{ number_format($pengeluaranData['BiayaPemasaran'], 0, ',', '.') }}</td>
            <td class="c-rp-tot"></td>
            <td class="c-tot"></td>
        </tr>
        <tr class="r-item">
            <td class="c-label">&nbsp;&nbsp;&nbsp;-&nbsp; Biaya Keuangan</td>
            <td class="c-rp-item">Rp.</td>
            <td class="c-nom">{{ number_format($pengeluaranData['BiayaKeuangan'], 0, ',', '.') }}</td>
            <td class="c-rp-tot"></td>
            <td class="c-tot"></td>
        </tr>
        <tr class="r-item">
            <td class="c-label">&nbsp;&nbsp;&nbsp;-&nbsp; Setor ke Pusat</td>
            <td class="c-rp-item">Rp.</td>
            <td class="c-nom">{{ number_format($pengeluaranData['SetorKePusat'], 0, ',', '.') }}</td>
            <td class="c-rp-tot"></td>
            <td class="c-tot"></td>
        </tr>
        <tr class="r-item">
            {{-- Penggajian digabung ke Lain-lain sesuai tampilan template --}}
            <td class="c-label">&nbsp;&nbsp;&nbsp;-&nbsp; Lain-lain</td>
            <td class="c-rp-item">Rp.</td>
            <td class="c-nom">{{ number_format($pengeluaranData['Lainnya_Pengeluaran'] + $pengeluaranData['Penggajian'], 0, ',', '.') }}</td>
            <td class="c-rp-tot"></td>
            <td class="c-tot"></td>
        </tr>
        <tr class="r-total">
            <td class="c-label"><strong>JUMLAH PENGELUARAN DANA OPERASIONAL</strong></td>
            <td class="c-rp-item"></td>
            <td class="c-nom"></td>
            <td class="c-rp-tot"><strong>Rp.</strong></td>
            <td class="c-tot"><strong>{{ number_format($totalPengeluaran, 0, ',', '.') }}</strong></td>
        </tr>

        <tr class="r-gap"><td colspan="5"></td></tr>

        {{-- SALDO KAS AKHIR --}}
        <tr class="r-saldo">
            <td class="c-label"><strong>SALDO DANA OPERASIONAL (KAS AKHIR)</strong></td>
            <td class="c-rp-item"></td>
            <td class="c-nom"></td>
            <td class="c-rp-tot"><strong>Rp.</strong></td>
            <td class="c-tot"><strong>{{ number_format($saldoAkhir, 0, ',', '.') }}</strong></td>
        </tr>

    </table>

    {{-- ======== TANDA TANGAN ======== --}}
    <table class="sig-table">
        <tr>
            <td style="width:33%; text-align:center;">Mengetahui,</td>
            <td style="width:34%; text-align:center;">Dibuat oleh,</td>
            <td style="width:33%; text-align:right;">{{ $cabang }}, {{ $tanggalCetak }}</td>
        </tr>
        <tr>
            <td style="text-align:center;"><span class="sig-name">{{ $mengetahui }}</span></td>
            <td style="text-align:center;"><span class="sig-name">{{ $dibuatOleh }}</span></td>
            <td></td>
        </tr>
    </table>

</body>
</html>