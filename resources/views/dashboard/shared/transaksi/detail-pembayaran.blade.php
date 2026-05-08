{{-- POP-UP DETAIL PEMBAYARAN MURID --}}
<div style="padding: 25px;">
    
    {{-- HEADER --}}
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 2px solid #F3E8FF; padding-bottom: 15px;">
        <h3 style="font-size: 18px; font-weight: 700; color: #111827; margin: 0;">
            <i class="fas fa-receipt" style="color: #4D0B87; margin-right: 8px;"></i> Detail Pembayaran Murid
        </h3>
        <button onclick="tutupModalDetail()" 
                style="background: #FEE2E2; color: #EF4444; border: none; width: 32px; height: 32px; border-radius: 50%; cursor: pointer; font-size: 16px; display: flex; align-items: center; justify-content: center;">
            <i class="fas fa-times"></i>
        </button>
    </div>
    
    {{-- INFO MURID --}}
    <div style="background: #F9FAFB; border-radius: 12px; padding: 20px; margin-bottom: 20px;">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
            <div>
                <p style="color: #6B7280; font-size: 12px; margin: 0 0 2px 0;">Nama Murid</p>
                <p style="color: #111827; font-weight: 600; font-size: 15px; margin: 0;">{{ $murid->nama_lengkap }}</p>
            </div>
            <div>
                <p style="color: #6B7280; font-size: 12px; margin: 0 0 2px 0;">Kelas</p>
                <p style="color: #111827; font-weight: 600; font-size: 15px; margin: 0;">{{ $namaKelas }}</p>
            </div>
            <div>
                <p style="color: #6B7280; font-size: 12px; margin: 0 0 2px 0;">Paket</p>
                <p style="color: #111827; font-weight: 600; font-size: 15px; margin: 0;">{{ $namaPaket }}</p>
            </div>
            <div>
                <p style="color: #6B7280; font-size: 12px; margin: 0 0 2px 0;">Status Pendaftaran</p>
                <p style="margin: 0;">
                    @if($sudahBayarPendaftaran)
                        <span style="padding:4px 10px;border-radius:20px;background:#D1FAE5;color:#065F46;font-size:12px;font-weight:600;">Lunas</span>
                    @else
                        <span style="padding:4px 10px;border-radius:20px;background:#FEE2E2;color:#EF4444;font-size:12px;font-weight:600;">Belum</span>
                    @endif
                </p>
            </div>
            <div>
                <p style="color: #6B7280; font-size: 12px; margin: 0 0 2px 0;">Harga Paket/Bulan</p>
                <p style="color: #111827; font-weight: 600; font-size: 15px; margin: 0;">Rp {{ number_format($hargaPerBulan, 0, ',', '.') }}</p>
            </div>
            <div>
                <p style="color: #6B7280; font-size: 12px; margin: 0 0 2px 0;">Total Pembayaran</p>
                <p style="color: #4D0B87; font-weight: 700; font-size: 15px; margin: 0;">Rp {{ number_format($totalBayar, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>
    
    {{-- RIWAYAT PEMBAYARAN --}}
    <h4 style="font-size: 15px; font-weight: 700; color: #111827; margin: 0 0 12px 0;">
        <i class="fas fa-history" style="color: #4D0B87; margin-right: 6px;"></i> Riwayat Pembayaran
    </h4>
    
    @if($riwayatPembayaran->count() > 0)
        <div style="overflow-x: auto; border-radius: 12px; border: 1px solid #E5E7EB;">
            <table style="width: 100%; border-collapse: collapse; font-size: 13px; font-family: 'Poppins', sans-serif;">
                <thead>
                    <tr style="background: #F3E8FF;">
                        <th style="padding: 10px 14px; text-align: left;">No</th>
                        <th style="padding: 10px 14px; text-align: left;">Tanggal</th>
                        <th style="padding: 10px 14px; text-align: left;">Jenis</th>
                        <th style="padding: 10px 14px; text-align: right;">Jumlah</th>
                        <th style="padding: 10px 14px; text-align: left;">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($riwayatPembayaran as $i => $r)
                    <tr style="border-bottom: 1px solid #F3F4F6; {{ $i % 2 == 0 ? 'background: #FAFAFA;' : '' }}">
                        <td style="padding: 10px 14px;">{{ $i + 1 }}</td>
                        <td style="padding: 10px 14px;">{{ $r->tanggal }}</td>
                        <td style="padding: 10px 14px;">{{ $r->jenis_pembayaran }}</td>
                        <td style="padding: 10px 14px; text-align: right; font-weight: 600; color: #10B981;">{{ $r->jumlah }}</td>
                        <td style="padding: 10px 14px; color: #6B7280;">{{ $r->keterangan }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div style="text-align: center; padding: 30px; color: #9CA3AF; font-size: 14px;">
            <i class="fas fa-inbox" style="font-size: 32px; display: block; margin-bottom: 8px; opacity: .4;"></i>
            Belum ada riwayat pembayaran
        </div>
    @endif
    
    {{-- TUTUP --}}
    <div style="text-align: right; margin-top: 20px;">
        <button onclick="tutupModalDetail()" 
                style="background: #E5E7EB; color: #374151; border: none; padding: 10px 24px; border-radius: 10px; cursor: pointer; font-weight: 600; font-size: 13px; font-family: 'Poppins', sans-serif;">
            <i class="fas fa-times"></i> Tutup
        </button>
    </div>
    
</div>