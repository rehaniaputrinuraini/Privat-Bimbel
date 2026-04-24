<div style="padding: 28px 25px; font-family: 'Poppins', sans-serif; background: #FFFFFF; border-radius: 16px;">
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; padding-bottom: 14px; border-bottom: 1.5px solid #F3F4F6;">
        <div>
            <h2 style="font-size: 19px; font-weight: 700; color: #111827; margin: 0;">Input Data Murid</h2>
            <p style="color: #9CA3AF; font-size: 12px; margin: 2px 0 0 0;">Lengkapi form di bawah</p>
        </div>
        <button onclick="bukaModalBatal()" style="width: 32px; height: 32px; border-radius: 8px; border: 1.5px solid #E5E7EB; background: #F9FAFB; color: #6B7280; font-size: 16px; cursor: pointer; display: flex; align-items: center; justify-content: center;"
                onmouseover="this.style.background='#FEE2E2';this.style.borderColor='#FCA5A5'" onmouseout="this.style.background='#F9FAFB';this.style.borderColor='#E5E7EB'">&times;</button>
    </div>

    <form action="{{ route($role . '.murid.store') }}" method="POST" id="mainForm">
        @csrf

        <div style="margin-bottom: 15px;">
            <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 6px;">Nama Lengkap <span style="color: #EF4444;">*</span></label>
            <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" placeholder="Masukkan nama lengkap" required
                   style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: #FFFFFF; outline: none; font-size: 14px; font-family: 'Poppins', sans-serif;"
                   onfocus="this.style.borderColor='#4D0B87'" onblur="this.style.borderColor='#E5E7EB'">
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0 40px; margin-bottom: 15px;">
            <div>
                <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 6px;">Pilih Kelas <span style="color: #EF4444;">*</span></label>
                <select name="id_kelas" id="id_kelas" required style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: #FFFFFF; outline: none; font-size: 14px; font-family: 'Poppins', sans-serif; cursor: pointer;"
                        onfocus="this.style.borderColor='#4D0B87'" onblur="this.style.borderColor='#E5E7EB'">
                    <option value="">-- Pilih Kelas --</option>
                    @foreach($kelasList as $kelas)
                        @php $sisa = 10 - $kelas->jumlah_murid; @endphp
                        <option value="{{ $kelas->id_kelas }}" data-jenjang="{{ $kelas->jenjang }}">{{ $kelas->jenjang }} - {{ $kelas->nama_kelas }} ({{ $sisa }} kursi)</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 6px;">Pilih Paket <span style="color: #EF4444;">*</span></label>
                <select name="id_paket" id="id_paket" required style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: #FFFFFF; outline: none; font-size: 14px; font-family: 'Poppins', sans-serif; cursor: pointer;"
                        onfocus="this.style.borderColor='#4D0B87'" onblur="this.style.borderColor='#E5E7EB'">
                    <option value="">-- Pilih Paket --</option>
                    @foreach($paketList as $paket)
                        <option value="{{ $paket->id_paket }}" data-tingkat="{{ $paket->tingkat }}" data-harga="{{ $paket->harga }}">{{ $paket->tingkat }} - Rp {{ number_format($paket->harga, 0, ',', '.') }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div style="margin-bottom: 15px;">
            <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 6px;">Asal Sekolah</label>
            <input type="text" name="asal_sekolah" value="{{ old('asal_sekolah') }}" placeholder="Masukkan asal sekolah"
                   style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: #FFFFFF; outline: none; font-size: 14px; font-family: 'Poppins', sans-serif;"
                   onfocus="this.style.borderColor='#4D0B87'" onblur="this.style.borderColor='#E5E7EB'">
        </div>

        <div style="margin-bottom: 15px;">
            <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 6px;">Alamat</label>
            <textarea name="alamat" rows="3" placeholder="Masukkan alamat lengkap"
                      style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: #FFFFFF; outline: none; font-family: 'Poppins', sans-serif; font-size: 14px; resize: vertical;"
                      onfocus="this.style.borderColor='#4D0B87'" onblur="this.style.borderColor='#E5E7EB'">{{ old('alamat') }}</textarea>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0 40px;">
            <div>
                <div style="margin-bottom: 15px;">
                    <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 6px;">No HP Siswa</label>
                    <input type="tel" name="no_hp" value="{{ old('no_hp') }}" placeholder="08xxxxxxxxxx" oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                           style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: #FFFFFF; outline: none; font-size: 14px; font-family: 'Poppins', sans-serif;"
                           onfocus="this.style.borderColor='#4D0B87'" onblur="this.style.borderColor='#E5E7EB'">
                </div>
                <div style="margin-bottom: 15px;">
                    <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 6px;">Nama Orang Tua</label>
                    <input type="text" name="nama_orang_tua" value="{{ old('nama_orang_tua') }}" placeholder="Nama orang tua"
                           style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: #FFFFFF; outline: none; font-size: 14px; font-family: 'Poppins', sans-serif;"
                           onfocus="this.style.borderColor='#4D0B87'" onblur="this.style.borderColor='#E5E7EB'">
                </div>
                <div style="margin-bottom: 15px;">
                    <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 6px;">No HP Orang Tua</label>
                    <input type="tel" name="no_hp_orang_tua" value="{{ old('no_hp_orang_tua') }}" placeholder="08xxxxxxxxxx" oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                           style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: #FFFFFF; outline: none; font-size: 14px; font-family: 'Poppins', sans-serif;"
                           onfocus="this.style.borderColor='#4D0B87'" onblur="this.style.borderColor='#E5E7EB'">
                </div>
            </div>
            <div>
                <div style="margin-bottom: 15px;">
                    <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 6px;">Detail Paket</label>
                    <div style="padding: 12px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: #F9FAFB;">
                        <span id="hargaPaket" style="font-weight: 700; color: #4D0B87; font-size: 14px;">-</span>
                    </div>
                </div>
                <div style="margin-bottom: 15px;">
                    <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 6px;">Tahun Masuk</label>
                    <input type="tel" name="tahun_masuk" value="{{ old('tahun_masuk', date('Y')) }}" oninput="this.value = this.value.replace(/[^0-9]/g, '')" maxlength="4"
                           style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: #FFFFFF; outline: none; font-size: 14px; font-family: 'Poppins', sans-serif;"
                           onfocus="this.style.borderColor='#4D0B87'" onblur="this.style.borderColor='#E5E7EB'">
                </div>
                <input type="hidden" name="id_periode" value="{{ $periodeAktif->id_periode ?? '' }}">
            </div>
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 24px; padding-top: 16px; border-top: 1.5px solid #F3F4F6;">
            <button type="button" onclick="bukaModalBatal()" style="padding: 10px 28px; border: 1.5px solid #D1D5DB; color: #374151; border-radius: 10px; font-weight: 600; font-size: 14px; background: #FFFFFF; cursor: pointer; font-family: 'Poppins', sans-serif;">Keluar</button>
            <button type="submit" style="padding: 10px 35px; border: none; background: #4D0B87; color: white; border-radius: 10px; font-weight: 600; font-size: 14px; cursor: pointer; font-family: 'Poppins', sans-serif; box-shadow: 0 2px 8px rgba(77,11,135,0.2);">Simpan</button>
        </div>
    </form>
</div>

{{-- MODAL KONFIRMASI BATAL --}}
<div id="modalBatalCreate" style="display: none; position: fixed; z-index: 99999; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); backdrop-filter: blur(3px); align-items: center; justify-content: center; font-family: 'Poppins', sans-serif;">
    <div style="background: white; padding: 25px; border-radius: 20px; width: 320px; text-align: center; box-shadow: 0 15px 30px rgba(0,0,0,0.15);">
        <div style="color: #F59E0B; font-size: 40px; margin-bottom: 10px;"><i class="fas fa-exclamation-triangle"></i></div>
        <h2 style="margin: 0; font-size: 18px; font-weight: 700; color: #111827;">Batalkan?</h2>
        <p style="color: #6B7280; font-size: 13px; margin: 8px 0 20px 0;">Data yang Anda masukkan tidak akan disimpan.</p>
        <div style="display: flex; gap: 10px; justify-content: center;">
            <button onclick="tutupModalBatal()" style="flex: 1; padding: 10px; border-radius: 10px; border: 1px solid #E5E7EB; background: white; font-weight: 600; font-size: 13px; cursor: pointer;">Tidak</button>
            <button onclick="tutupModalForm()" style="flex: 1; padding: 10px; border-radius: 10px; border: none; background: #EF4444; color: white; font-weight: 600; font-size: 13px; cursor: pointer;">Ya, Keluar</button>
        </div>
    </div>
</div>

{{-- MODAL PERINGATAN PERUBAHAN --}}
<div id="modalPindahHalamanCreate" style="display: none; position: fixed; z-index: 10000; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); backdrop-filter: blur(3px); align-items: center; justify-content: center; font-family: 'Poppins', sans-serif;">
    <div style="background: white; padding: 25px; border-radius: 20px; width: 320px; text-align: center; box-shadow: 0 15px 30px rgba(0,0,0,0.15);">
        <div style="color: #F59E0B; font-size: 40px; margin-bottom: 10px;"><i class="fas fa-exclamation-triangle"></i></div>
        <h2 style="margin: 0; font-size: 18px; font-weight: 700; color: #111827;">Perubahan Belum Disimpan</h2>
        <p style="color: #6B7280; font-size: 13px; margin: 8px 0 20px 0;">Ada data yang belum disimpan. Yakin ingin meninggalkan halaman ini?</p>
        <div style="display: flex; gap: 10px; justify-content: center;">
            <button onclick="tutupModalPindah()" style="flex: 1; padding: 10px; border-radius: 10px; border: 1px solid #E5E7EB; background: white; font-weight: 600; font-size: 13px; cursor: pointer;">Tidak</button>
            <button onclick="tutupModalForm()" style="flex: 1; padding: 10px; border-radius: 10px; border: none; background: #EF4444; color: white; font-weight: 600; font-size: 13px; cursor: pointer;">Ya, Keluar</button>
        </div>
    </div>
</div>

<script>
    let formChanged = false;
    const form = document.getElementById('mainForm');
    if (form) {
        form.querySelectorAll('input, select, textarea').forEach(i => {
            i.addEventListener('change', () => formChanged = true);
            i.addEventListener('keyup', () => formChanged = true);
        });
        form.addEventListener('submit', () => formChanged = false);
    }
    function bukaModalBatal() { 
        if (formChanged) document.getElementById('modalPindahHalamanCreate').style.display = 'flex';
        else document.getElementById('modalBatalCreate').style.display = 'flex';
    }
    function tutupModalBatal() { document.getElementById('modalBatalCreate').style.display = 'none'; }
    function tutupModalPindah() { document.getElementById('modalPindahHalamanCreate').style.display = 'none'; }
    function tutupModalForm() {
        document.getElementById('modalForm').style.display = 'none';
        document.getElementById('modalContent').innerHTML = '';
    }
</script>