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

        .c-label   { width: 70%; }
        .c-rp-item { width: 8%;  text-align: left; }
        .c-nom     { width: 22%; text-align: right; padding-right: 8px !important; }

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

    
    <table class="header-table">
        <tr>
            <td class="logo-cell">
                <?php if(file_exists(public_path('images/logo/foto_logo.png'))): ?>
                    <img src="<?php echo e(public_path('images/logo/foto_logo.png')); ?>" class="logo-img" alt="Logo">
                <?php else: ?>
                    <div style="width:70px;height:70px;"></div>
                <?php endif; ?>
            </td>
            <td class="title-cell">
                <div class="title-main">LAPORAN KEUANGAN</div>
                <div class="title-sub">REKAP KAS &mdash; CABANG <?php echo e(strtoupper($cabang)); ?></div>
            </td>
        </tr>
    </table>
    <hr class="header-line">

    
    <table class="info-table">
        <tr>
            <td style="width:80px; font-weight:bold;">CABANG</td>
            <td style="width:14px; text-align:center;">:</td>
            <td style="width:200px;"><?php echo e(strtoupper($cabang)); ?></td>
            <td style="width:80px; font-weight:bold;">PERIODE</td>
            <td style="width:14px; text-align:center;">:</td>
            <td><?php echo e(strtoupper($periode)); ?></td>
        </tr>
    </table>

    
    <table class="data-table">

        
        <tr class="r-section">
            <td class="c-label"><strong>A.&nbsp; SALDO KAS AWAL</strong></td>
            <td class="c-rp-item"></td>
            <td class="c-nom"><strong>Rp <?php echo e(number_format($saldoAwal, 0, ',', '.')); ?></strong></td>
        </tr>

        <tr class="r-gap"><td colspan="3"></td></tr>

        
        <tr class="r-section">
            <td colspan="3"><strong>B.&nbsp; PENERIMAAN</strong></td>
        </tr>
        <tr class="r-item">
            <td class="c-label">&nbsp;&nbsp;&nbsp;-&nbsp; Pembayaran Murid (Pendaftaran & SPP)</td>
            <td class="c-rp-item">Rp</td>
            <td class="c-nom"><?php echo e(number_format(($pemasukanData['Pendaftaran'] ?? 0) + ($pemasukanData['Bimbingan'] ?? 0), 0, ',', '.')); ?></td>
        </tr>
        <?php if(($pemasukanData['Modal_Owner'] ?? 0) > 0): ?>
        <tr class="r-item">
            <td class="c-label">&nbsp;&nbsp;&nbsp;-&nbsp; Modal (Owner)</td>
            <td class="c-rp-item">Rp</td>
            <td class="c-nom"><?php echo e(number_format($pemasukanData['Modal_Owner'] ?? 0, 0, ',', '.')); ?></td>
        </tr>
        <?php endif; ?>
        <?php if(($pemasukanData['TryOut'] ?? 0) > 0): ?>
        <tr class="r-item">
            <td class="c-label">&nbsp;&nbsp;&nbsp;-&nbsp; Try Out</td>
            <td class="c-rp-item">Rp</td>
            <td class="c-nom"><?php echo e(number_format($pemasukanData['TryOut'] ?? 0, 0, ',', '.')); ?></td>
        </tr>
        <?php endif; ?>
        <tr class="r-item">
            <td class="c-label">&nbsp;&nbsp;&nbsp;-&nbsp; Pemasukan Lainnya</td>
            <td class="c-rp-item">Rp</td>
            <td class="c-nom"><?php echo e(number_format($pemasukanData['Lainnya_Pemasukan'] ?? 0, 0, ',', '.')); ?></td>
        </tr>
        <tr class="r-total">
            <td class="c-label"><strong>JUMLAH PENERIMAAN</strong></td>
            <td class="c-rp-item"></td>
            <td class="c-nom"><strong>Rp <?php echo e(number_format($totalPemasukan, 0, ',', '.')); ?></strong></td>
        </tr>

        <tr class="r-gap"><td colspan="3"></td></tr>

        
        <tr class="r-section">
            <td colspan="3"><strong>C.&nbsp; PENGELUARAN</strong></td>
        </tr>
        <tr class="r-item">
            <td class="c-label">&nbsp;&nbsp;&nbsp;-&nbsp; Pengeluaran Lainnya (Operasional, Pembelian, dll)</td>
            <td class="c-rp-item">Rp</td>
            <td class="c-nom"><?php echo e(number_format(
                ($pengeluaranData['Lainnya_Pengeluaran'] ?? 0) + 
                ($pengeluaranData['BiayaOperasional'] ?? 0) + 
                ($pengeluaranData['BiayaRapatPelatihan'] ?? 0) + 
                ($pengeluaranData['FeeManagement'] ?? 0) + 
                ($pengeluaranData['PembelianAktiva'] ?? 0) + 
                ($pengeluaranData['Modul'] ?? 0) + 
                ($pengeluaranData['BiayaAkademik'] ?? 0) + 
                ($pengeluaranData['BiayaPemasaran'] ?? 0) + 
                ($pengeluaranData['BiayaKeuangan'] ?? 0) + 
                ($pengeluaranData['SetorKePusat'] ?? 0), 0, ',', '.')); ?></td>
        </tr>
        <?php if(($pengeluaranData['Penggajian'] ?? 0) > 0): ?>
        <tr class="r-item">
            <td class="c-label">&nbsp;&nbsp;&nbsp;-&nbsp; Penggajian (Gaji Tentor & Admin)</td>
            <td class="c-rp-item">Rp</td>
            <td class="c-nom"><?php echo e(number_format($pengeluaranData['Penggajian'] ?? 0, 0, ',', '.')); ?></td>
        </tr>
        <?php endif; ?>
        <tr class="r-total">
            <td class="c-label"><strong>JUMLAH PENGELUARAN</strong></td>
            <td class="c-rp-item"></td>
            <td class="c-nom"><strong>Rp <?php echo e(number_format($totalPengeluaran, 0, ',', '.')); ?></strong></td>
        </tr>

        <tr class="r-gap"><td colspan="3"></td></tr>

        
        <tr class="r-saldo">
            <td class="c-label"><strong>D.&nbsp; SALDO KAS AKHIR</strong></td>
            <td class="c-rp-item"></td>
            <td class="c-nom"><strong>Rp <?php echo e(number_format($saldoAkhir, 0, ',', '.')); ?></strong></td>
        </tr>

    </table>

    
    <table class="data-table" style="margin-top: 10px;">
        <tr class="r-item">
            <td class="c-label">Saldo Kas Awal</td>
            <td class="c-rp-item">Rp</td>
            <td class="c-nom"><?php echo e(number_format($saldoAwal, 0, ',', '.')); ?></td>
        </tr>
        <tr class="r-item">
            <td class="c-label">Penerimaan</td>
            <td class="c-rp-item">Rp</td>
            <td class="c-nom"><?php echo e(number_format($totalPemasukan, 0, ',', '.')); ?></td>
        </tr>
        <tr class="r-item">
            <td class="c-label">Pengeluaran</td>
            <td class="c-rp-item">Rp</td>
            <td class="c-nom">(<?php echo e(number_format($totalPengeluaran, 0, ',', '.')); ?>)</td>
        </tr>
        <tr class="r-saldo">
            <td class="c-label"><strong>Saldo Kas Akhir</strong></td>
            <td class="c-rp-item"><strong>Rp</strong></td>
            <td class="c-nom"><strong><?php echo e(number_format($saldoAkhir, 0, ',', '.')); ?></strong></td>
        </tr>
    </table>

    
    <table class="sig-table">
        <tr>
            <td style="width:33%; text-align:center;">Mengetahui,</td>
            <td style="width:34%; text-align:center;">Dibuat oleh,</td>
            <td style="width:33%; text-align:right;"><?php echo e($cabang); ?>, <?php echo e($tanggalCetak); ?></td>
        </tr>
        <tr>
            <td style="text-align:center;"><span class="sig-name"><?php echo e($mengetahui); ?></span></td>
            <td style="text-align:center;"><span class="sig-name"><?php echo e($dibuatOleh); ?></span></td>
            <td style="text-align:right;"></td>
        </tr>
    </table>

</body>
</html><?php /**PATH C:\xampp\htdocs\Privat-Bimbel\resources\views/dashboard/shared/laporan-keuangan/laporan-keuangan-pdf.blade.php ENDPATH**/ ?>