<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Slip Gaji - <?php echo e($tentor->nama_lengkap); ?></title>
    <style>
        @page {
            size: a4 portrait;
            margin: 15mm 15mm 15mm 15mm;
        }
        * {
            font-family: 'Calibri', 'Arial', sans-serif;
            font-size: 11px;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            background: #fff;
            color: #1A1A1A;
        }

        .header-wrapper {
            display: flex;
            align-items: center;
            border-bottom: 2px solid #7B2D8B;
            padding-bottom: 6px;
            margin-bottom: 8px;
        }
        .header-logo {
            width: 70px;
            min-width: 70px;
            text-align: center;
        }
        .header-logo img {
            width: 65px;
            height: auto;
        }
        .header-title {
            flex: 1;
            text-align: center;
        }
        .header-title h2 {
            font-size: 20px;
            font-weight: bold;
            color: #4B0082;
            letter-spacing: 1px;
            margin: 0;
            line-height: 1.2;
        }
        .header-title p {
            font-size: 14px;
            font-weight: bold;
            color: #7B2D8B;
            margin: 2px 0 0 0;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
        }
        .info-table td {
            padding: 4px 6px;
            font-size: 11px;
            font-weight: bold;
            color: #1A1A1A;
            background: #F3E8FF;
        }
        .info-table .label {
            width: 18%;
            color: #1A1A1A;
        }
        .info-table .colon {
            width: 2%;
            text-align: center;
        }
        .info-table .value {
            width: 45%;
            color: #1A1A1A;
        }
        .info-table .sub-info {
            font-size: 10px;
            font-weight: normal;
            color: #555555;
            background: #F3E8FF;
            padding: 2px 6px;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
            font-size: 10px;
        }
        .data-table th {
            background-color: #4B0082;
            color: #FFFFFF;
            font-weight: bold;
            font-size: 10px;
            padding: 5px 4px;
            text-align: center;
            border: 1px solid #4B0082;
        }
        .data-table td {
            border: 1px solid #c0a0d0;
            padding: 4px 5px;
            text-align: center;
            color: #1A1A1A;
        }
        .data-table .col-ket {
            text-align: left;
        }
        .data-table .total-row td {
            font-weight: bold;
            background-color: #D8B4FE;
            color: #1A1A1A;
            border: 1px solid #9f6fc0;
        }
        .data-table tbody tr:nth-child(even) td {
            background-color: #FAF5FF;
        }
        .data-table tbody tr:nth-child(odd) td {
            background-color: #FFFFFF;
        }
        .data-table .total-row td {
            background-color: #D8B4FE !important;
        }
        .siswa-absen {
            font-weight: bold;
            color: #CC0000;
        }

        .signature-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .signature-table td {
            width: 33%;
            text-align: center;
            vertical-align: top;
            padding: 4px 8px;
            font-size: 11px;
            color: #1A1A1A;
        }
        .signature-table .sig-name {
            font-weight: bold;
            color: #4B0082;
            text-decoration: underline;
            margin-top: 2px;
        }
    </style>
</head>
<body>

    
    <div class="header-wrapper">
        <div class="header-logo">
            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAALQAAACXCAYAAAC89XGqAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAOdEVYdFNvZnR3YXJlAEZpZ21hnrGWYwAAVgpJREFUeAHtXQd8VMXWn7l1e3az6Z0Qeq8qIIINBVFRQRRRsKCioKioPCzhU6qIigiCCiJgAUVAOii9995Cem/by63zzdwEHmoC5InvAe7fH2b3ltl7Z86cOX0ACCGEEEIIIYQQQgghhBBCCCGEEEIIIYQQQgghhBBCCCGEEEIIIYQQQgghhBBCCCGEEEIIIYQQQgghhBBCCCGEEEIIIYQQQgghhBBCCCGEEEIIIYQQQgghhBBC+B9CEAJ1RjfSj+n72TATPWCRBDnCkW1qUsZGBoOWomirylGiSFEiQ/MuhgEsxXKAsigqCagMqRMEBa/kkuGEEoBQ+glUHys0VUADTYkUTdqUFkTqLCUL5lTA50AgbJCDoixqQWWdZDQnAu8yiiyioBC6mP8A/y9OdiMv9/JMAAAAAElFTkSuQmCC" alt="Logo Privat">
        </div>
        <div class="header-title">
            <h2>DATA HONORARIUM TENTOR</h2>
            <p>BULAN <?php echo e(strtoupper($namaBulan)); ?> <?php echo e($tahun); ?></p>
        </div>
    </div>

    
    <table class="info-table">
        <tr>
            <td class="label">NAMA TENTOR</td>
            <td class="colon">:</td>
            <td class="value"><?php echo e(strtoupper($tentor->nama_lengkap)); ?></td>
            <td class="label" style="width:12%;">NOMINAL</td>
            <td class="colon">:</td>
            <td class="value" style="width:23%;">Rp <?php echo e(number_format($totalGaji, 0, ',', '.')); ?></td>
        </tr>
        <tr>
            <td class="sub-info" colspan="3">
                Bid. Study : <?php echo e($tentor->mapel ?? '-'); ?> &nbsp;|&nbsp; Jenjang : <?php echo e($tentor->grade ?? '-'); ?>

            </td>
            <td class="sub-info" colspan="3"></td>
        </tr>
    </table>

    
    <table class="data-table">
        <thead>
            <tr>
                <th style="width:4%;">NO</th>
                <th style="width:8%;">TANGGAL</th>
                <th style="width:10%;">JENJANG / KELAS</th>
                <th style="width:9%;">HR</th>
                <th style="width:9%;">UANG MAKAN</th>
                <th style="width:9%;">TRANSPOT</th>
                <th style="width:9%;">TOTAL HR</th>
                <th style="width:12%;" class="col-ket">KETERANGAN</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $detailPresensi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $totalHarian = $d->honor + $uangMakanPerHari + $uangTransportPerHari;
                    $keterangan = '';
                    if (str_contains($d->status, '50%') || $d->status == 'Tidak Hadir') {
                        $keterangan = 'SISWA ABSEN';
                    }
                ?>
                <tr>
                    <td><?php echo e($i + 1); ?></td>
                    <td><?php echo e(\Carbon\Carbon::parse($d->tanggal)->format('d-M')); ?></td>
                    <td><?php echo e($d->murid_list[0]['kelas'] ?? '-'); ?></td>
                    <td><?php echo e(number_format($d->honor, 0, ',', '.')); ?></td>
                    <td><?php echo e($uangMakanPerHari > 0 ? number_format($uangMakanPerHari, 0, ',', '.') : ''); ?></td>
                    <td><?php echo e($uangTransportPerHari > 0 ? number_format($uangTransportPerHari, 0, ',', '.') : ''); ?></td>
                    <td><?php echo e(number_format($totalHarian, 0, ',', '.')); ?></td>
                    <td class="col-ket <?php echo e($keterangan ? 'siswa-absen' : ''); ?>"><?php echo e($keterangan); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <?php for($j = 0; $j < 3; $j++): ?>
            <tr>
                <td>&nbsp;</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
            </tr>
            <?php endfor; ?>
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="3" style="text-align:right; padding-right:8px;">TOTAL</td>
                <td><?php echo e(number_format($totalHonor, 0, ',', '.')); ?></td>
                <td><?php echo e(number_format($totalUangMakan, 0, ',', '.')); ?></td>
                <td><?php echo e(number_format($totalUangTransport, 0, ',', '.')); ?></td>
                <td colspan="2"><?php echo e(number_format($totalGaji, 0, ',', '.')); ?></td>
            </tr>
        </tfoot>
    </table>

    
    <table class="signature-table">
        <tr>
            <td>
                Staf Privat,
                <br><br><br><br>
                <div class="sig-name">NINDYA MAWARNI</div>
            </td>
            <td>
                Tentor,
                <br><br><br><br>
                <div class="sig-name"><?php echo e(strtoupper($tentor->nama_lengkap)); ?></div>
            </td>
            <td>
                Uteran, <?php echo e(\Carbon\Carbon::now()->translatedFormat('d F Y')); ?>

                <br><br><br><br>
                &nbsp;
            </td>
        </tr>
    </table>

</body>
</html><?php /**PATH C:\xampp\htdocs\Privat-Bimbel\resources\views/dashboard/shared/transaksi/slip-gaji.blade.php ENDPATH**/ ?>