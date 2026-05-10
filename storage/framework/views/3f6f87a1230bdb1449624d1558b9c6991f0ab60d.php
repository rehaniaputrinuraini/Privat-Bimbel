<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Slip Gaji - <?php echo e($tentor->nama_lengkap); ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 10pt;
            color: #000;
            padding: 20px 25px;
            background: white;
        }

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
            width: 80px;
            text-align: center;
        }
        .logo-img {
            width: 65px;
            height: 65px;
            object-fit: contain;
        }
        .title-cell {
            text-align: center;
        }
        .title-main {
            font-size: 16pt;
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

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        .info-table td {
            font-size: 10pt;
            padding: 8px 10px;
            border: 1px solid #c0a0d0;
        }
        .info-table .label {
            width: 15%;
            font-weight: bold;
            background-color: #F3E8FF;
        }
        .info-table .colon {
            width: 3%;
            text-align: center;
            background-color: #F3E8FF;
        }
        .info-table .value {
            width: 32%;
            background-color: #ffffff;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 9pt;
        }
        .data-table th {
            background-color: #6a0dad;
            color: #ffffff;
            font-weight: bold;
            font-size: 9pt;
            padding: 8px 4px;
            text-align: center;
            border: 1px solid #5a009d;
        }
        .data-table td {
            border: 1px solid #c0a0d0;
            padding: 5px 4px;
            text-align: center;
            color: #1A1A1A;
        }
        .data-table .col-ket {
            text-align: left;
        }
        .data-table tbody tr:nth-child(even) td {
            background-color: #FAF5FF;
        }
        .data-table tbody tr:nth-child(odd) td {
            background-color: #FFFFFF;
        }
        .data-table .total-row td {
            font-weight: bold;
            background-color: #D8B4FE !important;
            border: 1px solid #9f6fc0;
        }
        .hadir {
            color: #065F46;
            font-weight: bold;
        }
        .tidak-hadir {
            color: #CC0000;
            font-weight: bold;
        }

        .signature-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }
        .signature-table td {
            width: 33%;
            text-align: center;
            vertical-align: top;
            padding: 10px 8px;
            font-size: 10pt;
            color: #1A1A1A;
        }
        .signature-table .sig-name {
            font-weight: bold;
            color: #4a0080;
            margin-top: 40px;
            display: block;
            border-top: 1px solid #000;
            padding-top: 5px;
            width: 80%;
            margin-left: auto;
            margin-right: auto;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 8pt;
            border-top: 1px solid #ccc;
            padding-top: 8px;
        }
        .text-right {
            text-align: right;
        }
        .bold {
            font-weight: bold;
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
                    <div style="width:65px;height:65px;"></div>
                <?php endif; ?>
            </td>
            <td class="title-cell">
                <div class="title-main">DATA HONORARIUM TENTOR</div>
                <div class="title-sub">BULAN <?php echo e(strtoupper($namaBulan)); ?> <?php echo e($tahun); ?></div>
            </td>
        </tr>
    </table>
    <hr class="header-line">

    
    <table class="info-table">
        <tr>
            <td class="label">NAMA TENTOR</td>
            <td class="colon">:</td>
            <td class="value"><?php echo e(strtoupper($tentor->nama_lengkap)); ?></td>
            <td class="label">NOMINAL</td>
            <td class="colon">:</td>
            <td class="value">Rp <?php echo e(number_format($totalGaji, 0, ',', '.')); ?></td>
        </tr>
        <tr>
            <td class="label">MAPEL</td>
            <td class="colon">:</td>
            <td class="value"><?php echo e($tentor->mapel ?? '-'); ?></td>
            <td class="label">GRADE</td>
            <td class="colon">:</td>
            <td class="value"><?php echo e($tentor->grade ?? '-'); ?></td>
        </tr>
    </table>

    
    <table class="data-table">
        <thead>
            <tr>
                <th style="width:3%;">NO</th>
                <th style="width:10%;">TANGGAL</th>
                <th style="width:12%;">KELAS</th>
                <th style="width:8%;">RUANG</th>
                <th style="width:10%;">KEHADIRAN MURID</th>
                <th style="width:8%;">HR</th>
                <th style="width:8%;">UANG MAKAN</th>
                <th style="width:8%;">UANG TRANSPORT</th>
                <th style="width:8%;">TOTAL HR</th>
                <th style="width:10%;">KETERANGAN</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $detailPresensi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($d->no); ?></td>
                <td><?php echo e($d->tanggal); ?></td>
                <td><?php echo e($d->kelas); ?></td>
                <td><?php echo e($d->ruang); ?></td>
                <td class="<?php echo e($d->kehadiran_murid == 'Hadir' ? 'hadir' : 'tidak-hadir'); ?>"><?php echo e($d->kehadiran_murid); ?></td>
                <td>Rp <?php echo e(number_format($d->honor, 0, ',', '.')); ?></td>
                <td>Rp <?php echo e(number_format($d->uang_makan, 0, ',', '.')); ?></td>
                <td>Rp <?php echo e(number_format($d->uang_transport, 0, ',', '.')); ?></td>
                <td>Rp <?php echo e(number_format($d->total_hr, 0, ',', '.')); ?></td>
                <td class="col-ket"><?php echo e($d->keterangan); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="5" class="text-right"><strong>TOTAL</strong></td>
                <td><strong>Rp <?php echo e(number_format($totalHonor, 0, ',', '.')); ?></strong></td>
                <td><strong>Rp <?php echo e(number_format($totalUangMakan, 0, ',', '.')); ?></strong></td>
                <td><strong>Rp <?php echo e(number_format($totalUangTransport, 0, ',', '.')); ?></strong></td>
                <td colspan="2"><strong>Rp <?php echo e(number_format($totalGaji, 0, ',', '.')); ?></strong></td>
            </tr>
        </tfoot>
    </table>

    
    <table class="signature-table">
        <tr>
            <td>Staf Privat,<br><br><br><br><span class="sig-name">NINDYA MAWARNI</span></td>
            <td>Tentor,<br><br><br><br><span class="sig-name"><?php echo e(strtoupper($tentor->nama_lengkap)); ?></span></td>
            <td>Uteran, <?php echo e(\Carbon\Carbon::now()->translatedFormat('d F Y')); ?><br><br><br><br>&nbsp;</td>
        </tr>
    </table>

    <div class="footer">Dokumen ini merupakan bukti sah honorarium tentor</div>

</body>
</html><?php /**PATH C:\xampp\htdocs\Privat-Bimbel\resources\views/dashboard/shared/transaksi/slip-gaji.blade.php ENDPATH**/ ?>