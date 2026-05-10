{{-- POP-UP DETAIL PENGGAJIAN --}}
<div style="padding: 25px;">

    {{-- HEADER --}}
    <div style="margin-bottom: 20px; padding-bottom: 15px; border-bottom: 2px solid #F3E8FF;">
        <h3 style="font-size: 18px; font-weight: 700; color: #111827; margin: 0;">
            <i class="fas fa-money-bill-wave" style="color: #4D0B87; margin-right: 8px;"></i> Detail Penggajian
        </h3>
    </div>

    {{-- INFO TENTOR --}}
    <div style="background: #F9FAFB; border-radius: 12px; padding: 20px; margin-bottom: 20px;">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
            <div>
                <p style="color: #6B7280; font-size: 12px; margin: 0 0 2px 0;">Nama Tentor</p>
                <p style="color: #111827; font-weight: 600; font-size: 15px; margin: 0;">{{ $tentor->nama_lengkap }}</p>
            </div>
            <div>
                <p style="color: #6B7280; font-size: 12px; margin: 0 0 2px 0;">Periode Gaji</p>
                <p style="color: #111827; font-weight: 600; font-size: 15px; margin: 0;">{{ $namaBulan }} {{ $tahun }}</p>
            </div>
            <div>
                <p style="color: #6B7280; font-size: 12px; margin: 0 0 2px 0;">Mapel</p>
                <p style="color: #111827; font-weight: 600; font-size: 15px; margin: 0;">{{ $tentor->mapel ?? '-' }}</p>
            </div>
            <div>
                <p style="color: #6B7280; font-size: 12px; margin: 0 0 2px 0;">Grade</p>
                <p style="color: #111827; font-weight: 600; font-size: 15px; margin: 0;">{{ $tentor->grade ?? '-' }}</p>
            </div>
        </div>
    </div>

    {{-- LAPORAN GAJI --}}
    <div style="background: #F9FAFB; border-radius: 12px; padding: 20px; margin-bottom: 20px;">
        <h4 style="font-size: 15px; font-weight: 700; color: #111827; margin: 0 0 15px 0;">
            <i class="fas fa-file-invoice" style="color: #4D0B87; margin-right: 6px;"></i> Laporan Gaji
        </h4>

        {{-- TABEL PRESENSI --}}
        <div style="overflow-x: auto; border-radius: 10px; border: 1px solid #E5E7EB; margin-bottom: 0;">
            <table style="width: 100%; border-collapse: collapse; font-size: 12px; font-family: 'Poppins', sans-serif;">
                <thead>
                    <tr style="background: #F3E8FF;">
                        <th style="padding: 10px 12px; text-align: center;">No</th>
                        <th style="padding: 10px 12px; text-align: center;">Tanggal</th>
                        <th style="padding: 10px 12px; text-align: center;">Hari</th>
                        <th style="padding: 10px 12px; text-align: left;">Murid</th>
                        <th style="padding: 10px 12px; text-align: center;">Kehadiran</th>
                        <th style="padding: 10px 12px; text-align: right;">Honor</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($detailPresensi as $i => $d)
                    @php
                        $hariIndo = match($d->hari) {
                            'Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa',
                            'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat',
                            'Saturday' => 'Sabtu', default => $d->hari
                        };
                    @endphp
                    <tr style="border-bottom: 1px solid #F3F4F6; {{ $i % 2 == 0 ? 'background: #FAFAFA;' : '' }}">
                        <td style="padding: 10px 12px; text-align: center; vertical-align: top;">{{ $i + 1 }}</td>
                        <td style="padding: 10px 12px; text-align: center; vertical-align: top; font-weight: 500;">{{ $d->tanggal }}</td>
                        <td style="padding: 10px 12px; text-align: center; vertical-align: top; color: #6B7280;">{{ $hariIndo }}</td>
                        <td style="padding: 10px 12px; text-align: left; vertical-align: top;">
                            @foreach($d->murid_list as $m)
                                <div style="margin-bottom: 3px;">
                                    <strong>{{ $m['nama_murid'] }}</strong>
                                    <small style="color: #9CA3AF;">({{ $m['kelas'] }})</small>
                                    <br>
                                    <small style="color: {{ $m['status'] == 'Hadir' ? '#10B981' : '#EF4444' }};">
                                        {{ $m['status'] }}
                                    </small>
                                </div>
                            @endforeach
                        </td>
                        <td style="padding: 10px 12px; text-align: center; vertical-align: top;">
                            @if($d->status == 'Hadir')
                                <span style="background:#D1FAE5;color:#065F46;padding:3px 8px;border-radius:20px;font-size:11px;font-weight:600;">Hadir</span>
                            @elseif(str_contains($d->status, '50%'))
                                <span style="background:#FEF3C7;color:#92400E;padding:3px 8px;border-radius:20px;font-size:11px;font-weight:600;">Tidak Hadir</span>
                            @else
                                <span style="background:#FEE2E2;color:#991B1B;padding:3px 8px;border-radius:20px;font-size:11px;font-weight:600;">Alpha</span>
                            @endif
                        </td>
                        <td style="padding: 10px 12px; text-align: right; vertical-align: top; font-weight: 600; {{ $d->honor > 0 ? 'color:#10B981;' : 'color:#EF4444;' }}">
                            Rp {{ number_format($d->honor, 0, ',', '.') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- RINGKASAN (TABEL TERPISAH) --}}
        <div style="overflow-x: auto; border-radius: 10px; border: 1px solid #E5E7EB; border-top: none; border-top-left-radius: 0; border-top-right-radius: 0;">
            <table style="width: 100%; border-collapse: collapse; font-size: 13px; font-family: 'Poppins', sans-serif;">
                {{-- Subtotal Honor --}}
                <tr style="background: #F3E8FF; font-weight: 700;">
                    <td style="padding: 10px 12px; text-align: left;">Subtotal Honor ({{ $hariHadir }} Hari)</td>
                    <td style="padding: 10px 12px; text-align: right; color: #4D0B87;">Rp {{ number_format($totalHonor, 0, ',', '.') }}</td>
                </tr>

                {{-- Uang Makan --}}
                <tr style="background: #FAFAFA; font-weight: 600;">
                    <td style="padding: 10px 12px; text-align: left;">
                        Uang Makan
                        <br><small style="color: #9CA3AF; font-weight: 400;">(Rp {{ number_format($uangMakanPerHari, 0, ',', '.') }} × {{ $hariHadir }} hari)</small>
                    </td>
                    <td style="padding: 10px 12px; text-align: right; color: #F59E0B;">Rp {{ number_format($totalUangMakan, 0, ',', '.') }}</td>
                </tr>

                {{-- Uang Transport --}}
                <tr style="background: #FAFAFA; font-weight: 600;">
                    <td style="padding: 10px 12px; text-align: left;">
                        Uang Transport
                        <br><small style="color: #9CA3AF; font-weight: 400;">(Rp {{ number_format($uangTransportPerHari, 0, ',', '.') }} × {{ $hariHadir }} hari)</small>
                    </td>
                    <td style="padding: 10px 12px; text-align: right; color: #3B82F6;">Rp {{ number_format($totalUangTransport, 0, ',', '.') }}</td>
                </tr>

                {{-- TOTAL GAJI --}}
                <tr style="background: #4D0B87; font-weight: 700;">
                    <td style="padding: 15px 12px; text-align: left; color: white; font-size: 15px;">TOTAL GAJI</td>
                    <td style="padding: 15px 12px; text-align: right; color: white; font-size: 16px;">Rp {{ number_format($totalGaji, 0, ',', '.') }}</td>
                </tr>

                {{-- Status Pembayaran --}}
                <tr style="background: #FAFAFA;">
                    <td style="padding: 10px 12px; text-align: left; font-weight: 500; color: #374151;">Status Pembayaran</td>
                    <td style="padding: 10px 12px; text-align: right;">
                        @if($sudahDibayar)
                            <span style="background:#D1FAE5;color:#065F46;padding:4px 10px;border-radius:20px;font-size:11px;font-weight:600;">✅ Sudah Dibayar</span>
                        @else
                            <span style="background:#FEF3C7;color:#92400E;padding:4px 10px;border-radius:20px;font-size:11px;font-weight:600;">⏳ Belum Dibayar</span>
                        @endif
                    </td>
                </tr>
            </table>
        </div>
    </div>

    {{-- TUTUP --}}
    <div style="text-align: right; margin-top: 20px;">
        <button onclick="tutupModalDetailGaji()" 
                style="padding: 11px 40px; border: 1.5px solid #4D0B87; color: #4D0B87; border-radius: 10px; font-weight: 600; font-size: 15px; background: #FFFFFF; cursor: pointer; font-family: 'Poppins', sans-serif;">
            Tutup
        </button>
    </div>

</div>