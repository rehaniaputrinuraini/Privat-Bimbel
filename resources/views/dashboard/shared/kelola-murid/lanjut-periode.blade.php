<div style="padding: 20px; font-family: 'Poppins', sans-serif;">
    <div style="margin-bottom: 20px; padding-bottom: 14px; border-bottom: 1.5px solid #F3F4F6;">
        <h2 style="font-size: 19px; font-weight: 700; color: #111827; margin: 0;">Lanjutkan ke Periode Baru</h2>
        <p style="color: #9CA3AF; font-size: 12px; margin: 2px 0 0 0;">Lanjutkan murid <strong>{{ $murid->nama_lengkap }}</strong> ke periode berikutnya</p>
    </div>

    <form id="formLanjutPeriode" action="{{ route($role . '.murid.lanjut-periode') }}" method="POST">
        @csrf
        <input type="hidden" name="id_murid" value="{{ $murid->id_murid }}">
        
        <div style="margin-bottom: 15px;">
            <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 6px;">Periode Tujuan</label>
            <select name="id_periode_baru" required style="width: 100%; padding: 12px; border-radius: 12px; border: 1.5px solid #E5E7EB;">
                <option value="">-- Pilih Periode --</option>
                @foreach($periodeList as $periode)
                    <option value="{{ $periode->id_periode }}" {{ $periodeAktif && $periode->id_periode == $periodeAktif->id_periode ? 'selected' : '' }}>
                        {{ $periode->tahun_periode }} ({{ date('d/m/Y', strtotime($periode->tanggal_mulai)) }} - {{ date('d/m/Y', strtotime($periode->tanggal_selesai)) }})
                    </option>
                @endforeach
            </select>
        </div>
        
        <div style="margin-bottom: 15px;">
            <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 6px;">Paket Baru</label>
            <select name="id_paket_baru" required style="width: 100%; padding: 12px; border-radius: 12px; border: 1.5px solid #E5E7EB;">
                <option value="">-- Pilih Paket --</option>
                @foreach($paketList as $paket)
                    <option value="{{ $paket->id_paket }}">{{ $paket->tingkat }} - Rp {{ number_format($paket->harga, 0, ',', '.') }}</option>
                @endforeach
            </select>
        </div>
        
        <div style="margin-bottom: 15px;">
            <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 6px;">Kelas Baru</label>
            <select name="id_kelas_baru" required style="width: 100%; padding: 12px; border-radius: 12px; border: 1.5px solid #E5E7EB;">
                <option value="">-- Pilih Kelas --</option>
                @foreach($kelasList as $kelas)
                    @php $sisa = 10 - $kelas->jumlah_murid; @endphp
                    <option value="{{ $kelas->id_kelas }}">{{ $kelas->jenjang }} - {{ $kelas->nama_kelas }} ({{ $sisa }} kursi)</option>
                @endforeach
            </select>
        </div>
        
        <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px; padding-top: 16px; border-top: 1.5px solid #F3F4F6;">
            <button type="button" onclick="tutupModalLanjutPeriode()" style="padding: 10px 20px; border: 1px solid #E5E7EB; background: white; border-radius: 10px; cursor: pointer;">Batal</button>
            <button type="submit" id="btnLanjut" style="padding: 10px 20px; background: #F59E0B; color: white; border: none; border-radius: 10px; font-weight: 600; cursor: pointer;">Lanjutkan</button>
        </div>
    </form>
</div>