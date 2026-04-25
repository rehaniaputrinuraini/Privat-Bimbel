<div style="padding: 20px; font-family: 'Poppins', sans-serif; background: #FFFFFF; border-radius: 16px;">
    
    <div style="margin-bottom: 20px; padding-bottom: 14px; border-bottom: 1.5px solid #F3F4F6;">
        <h2 style="font-size: 19px; font-weight: 700; color: #111827; margin: 0;">Input Data Tentor</h2>
        <p style="color: #9CA3AF; font-size: 12px; margin: 2px 0 0 0;">Lengkapi form di bawah</p>
    </div>

    <div id="alertError" style="display: none; background: #FEE2E2; color: #991B1B; padding: 12px 15px; border-radius: 10px; margin-bottom: 15px; align-items: center; gap: 10px;">
        <i class="fas fa-exclamation-circle" style="font-size: 18px;"></i>
        <span id="alertErrorText"></span>
    </div>

    <form id="mainForm" action="{{ route('superadmin.kelola-tentor.store') }}" method="POST">
        @csrf
        <input type="hidden" name="peran" value="tentor">

        <div style="margin-bottom: 15px;">
            <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 6px;">Nama Lengkap <span style="color: #EF4444;">*</span></label>
            <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" placeholder="Masukkan Nama Lengkap" required
                   style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: #FFFFFF; outline: none; font-size: 14px; font-family: 'Poppins', sans-serif;">
        </div>

        <div style="margin-bottom: 15px;">
            <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 6px;">Alamat <span style="color: #EF4444;">*</span></label>
            <textarea name="alamat" rows="2" placeholder="Masukkan Alamat" required
                      style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: #FFFFFF; outline: none; font-family: 'Poppins', sans-serif; font-size: 14px; resize: vertical;">{{ old('alamat') }}</textarea>
        </div>

        <div style="margin-bottom: 15px;">
            <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 6px;">No HP <span style="color: #EF4444;">*</span></label>
            <input type="tel" name="no_hp" value="{{ old('no_hp') }}" placeholder="08xxxxxxxxxx" required
                   oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                   style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; background: #FFFFFF; outline: none; font-size: 14px; font-family: 'Poppins', sans-serif;">
        </div>

        <hr style="border: 0; border-top: 1px solid #E5E7EB; margin-bottom: 20px;">

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0 40px;">
            <div>
                <div style="margin-bottom: 15px;">
                    <label style="font-weight: 600; font-size: 14px; color: #374151;">Mapel <span style="color: #EF4444;">*</span></label>
                    <input type="text" name="mapel" value="{{ old('mapel') }}" placeholder="Mapel" required style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; outline: none; font-size: 14px; font-family: 'Poppins', sans-serif;">
                </div>
                <div style="margin-bottom: 15px;">
                    <label style="font-weight: 600; font-size: 14px; color: #374151;">Grade <span style="color: #EF4444;">*</span></label>
                    <select name="grade" required style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; outline: none; font-size: 14px; font-family: 'Poppins', sans-serif; cursor: pointer;">
                        <option value="">Pilih Grade</option>
                        <option value="A" {{ old('grade')=='A'?'selected':'' }}>A</option>
                        <option value="B" {{ old('grade')=='B'?'selected':'' }}>B</option>
                    </select>
                </div>
                <div style="margin-bottom: 15px;">
                    <label style="font-weight: 600; font-size: 14px; color: #374151;">HR SD</label>
                    <input type="text" name="hr_sd" value="{{ old('hr_sd') }}" placeholder="HR SD" oninput="this.value = this.value.replace(/[^0-9]/g, '')" style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; outline: none; font-size: 14px; font-family: 'Poppins', sans-serif;">
                </div>
                <div style="margin-bottom: 15px;">
                    <label style="font-weight: 600; font-size: 14px; color: #374151;">HR SMP</label>
                    <input type="text" name="hr_smp" value="{{ old('hr_smp') }}" placeholder="HR SMP" oninput="this.value = this.value.replace(/[^0-9]/g, '')" style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; outline: none; font-size: 14px; font-family: 'Poppins', sans-serif;">
                </div>
                <div style="margin-bottom: 15px;">
                    <label style="font-weight: 600; font-size: 14px; color: #374151;">HR SMA</label>
                    <input type="text" name="hr_sma" value="{{ old('hr_sma') }}" placeholder="HR SMA" oninput="this.value = this.value.replace(/[^0-9]/g, '')" style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; outline: none; font-size: 14px; font-family: 'Poppins', sans-serif;">
                </div>
            </div>
            <div>
                <div style="margin-bottom: 15px;">
                    <label style="font-weight: 600; font-size: 14px; color: #374151;">Uang Makan</label>
                    <input type="text" name="uang_makan" value="{{ old('uang_makan') }}" placeholder="Uang Makan" oninput="this.value = this.value.replace(/[^0-9]/g, '')" style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; outline: none; font-size: 14px; font-family: 'Poppins', sans-serif;">
                </div>
                <div style="margin-bottom: 15px;">
                    <label style="font-weight: 600; font-size: 14px; color: #374151;">Uang Transport</label>
                    <input type="text" name="uang_transport" value="{{ old('uang_transport') }}" placeholder="Uang Transport" oninput="this.value = this.value.replace(/[^0-9]/g, '')" style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; outline: none; font-size: 14px; font-family: 'Poppins', sans-serif;">
                </div>
                <div style="margin-bottom: 15px;">
                    <label style="font-weight: 600; font-size: 14px; color: #374151;">Email <span style="color: #EF4444;">*</span></label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="Email" required style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; outline: none; font-size: 14px; font-family: 'Poppins', sans-serif;">
                </div>
                <div style="margin-bottom: 15px;">
                    <label style="font-weight: 600; font-size: 14px; color: #374151;">Username <span style="color: #EF4444;">*</span></label>
                    <input type="text" name="username" value="{{ old('username') }}" placeholder="Username" required style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; outline: none; font-size: 14px; font-family: 'Poppins', sans-serif;">
                </div>
                <div style="margin-bottom: 15px;">
                    <label style="font-weight: 600; font-size: 14px; color: #374151;">Password <span style="color: #EF4444;">*</span></label>
                    <input type="password" name="password" placeholder="Password" required autocomplete="new-password" style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1.5px solid #E5E7EB; outline: none; font-size: 14px; font-family: 'Poppins', sans-serif;">
                </div>
            </div>
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 20px; margin-top: 30px; padding-top: 16px; border-top: 1.5px solid #F3F4F6;">
            <button type="button" id="btnKeluar" style="padding: 10px 45px; border: 1.5px solid #4D0B87; color: #4D0B87; border-radius: 10px; font-weight: 600; font-size: 16px; background: #FFFFFF; cursor: pointer;">Keluar</button>
            <button type="submit" id="btnSimpan" style="padding: 10px 45px; border: none; background: #4D0B87; color: white; border-radius: 10px; font-weight: 600; font-size: 16px; cursor: pointer; box-shadow: 0 4px 6px rgba(77, 11, 135, 0.2);">Simpan</button>
        </div>
    </form>
</div>

{{-- MODAL BATAL --}}
<div id="modalBatal" style="display: none; position: fixed; z-index: 99999; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); backdrop-filter: blur(3px); align-items: center; justify-content: center;">
    <div style="background: white; padding: 25px; border-radius: 20px; width: 320px; text-align: center; box-shadow: 0 15px 30px rgba(0,0,0,0.15); font-family: 'Poppins', sans-serif;">
        <div style="color: #F59E0B; font-size: 40px; margin-bottom: 10px;"><i class="fas fa-exclamation-triangle"></i></div>
        <h2 style="margin: 0; font-size: 18px; color: #111827; font-weight: 700;">Batalkan?</h2>
        <p style="color: #6B7280; font-size: 13px; margin: 8px 0 20px 0;">Data yang Anda masukkan tidak akan disimpan.</p>
        <div style="display: flex; gap: 10px; justify-content: center;">
            <button type="button" id="btnTidakBatal" style="flex: 1; padding: 10px; border-radius: 10px; border: 1px solid #E5E7EB; background: white; color: #374151; font-weight: 600; font-size: 13px; cursor: pointer;">Tidak</button>
            <button type="button" id="btnYaKeluar" style="flex: 1; padding: 10px; border-radius: 10px; border: none; background: #EF4444; color: white; font-weight: 600; font-size: 13px; cursor: pointer;">Ya, Keluar</button>
        </div>
    </div>
</div>

{{-- MODAL PERINGATAN --}}
<div id="modalPindahHalaman" style="display: none; position: fixed; z-index: 10000; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); backdrop-filter: blur(3px); align-items: center; justify-content: center;">
    <div style="background: white; padding: 25px; border-radius: 20px; width: 320px; text-align: center; box-shadow: 0 15px 30px rgba(0,0,0,0.15); font-family: 'Poppins', sans-serif;">
        <div style="color: #F59E0B; font-size: 40px; margin-bottom: 10px;"><i class="fas fa-exclamation-triangle"></i></div>
        <h2 style="margin: 0; font-size: 18px; color: #111827; font-weight: 700;">Perubahan Belum Disimpan</h2>
        <p style="color: #6B7280; font-size: 13px; margin: 8px 0 20px 0;">Ada data yang belum disimpan.</p>
        <div style="display: flex; gap: 10px; justify-content: center;">
            <button type="button" id="btnTidakPindah" style="flex: 1; padding: 10px; border-radius: 10px; border: 1px solid #E5E7EB; background: white; font-weight: 600; font-size: 13px; cursor: pointer;">Tidak</button>
            <button type="button" id="btnYaPindah" style="flex: 1; padding: 10px; border-radius: 10px; border: none; background: #EF4444; color: white; font-weight: 600; font-size: 13px; cursor: pointer;">Ya, Keluar</button>
        </div>
    </div>
</div>

{{-- MODAL SUKSES --}}
<div id="modalSukses" style="display: none; position: fixed; z-index: 99999; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); backdrop-filter: blur(3px); align-items: center; justify-content: center;">
    <div style="background: white; padding: 25px; border-radius: 20px; width: 320px; text-align: center; box-shadow: 0 15px 30px rgba(0,0,0,0.15); font-family: 'Poppins', sans-serif;">
        <div style="color: #10B981; font-size: 50px; margin-bottom: 10px;"><i class="fas fa-check-circle"></i></div>
        <h2 style="margin: 0; font-size: 18px; color: #111827; font-weight: 700;">Berhasil!</h2>
        <p style="color: #6B7280; font-size: 13px; margin: 8px 0 20px 0;" id="pesanSukses">Data tentor berhasil disimpan.</p>
        <button type="button" id="btnOkSukses" style="width: 100%; padding: 10px; border-radius: 10px; border: none; background: #10B981; color: white; font-weight: 600; font-size: 13px; cursor: pointer;">OK</button>
    </div>
</div>