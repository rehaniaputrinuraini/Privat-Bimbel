@extends('layouts.app')

@section('title', 'Edit Kelas')

@section('content')
<div style="padding: 10px; font-family: 'Poppins', sans-serif;">
    <h1 style="font-size: 20px; font-weight: 700; color: #111827; margin-bottom: 20px;">Edit Kelas</h1>

    <div style="background: #F9FAFB; border-radius: 15px; padding: 30px; border: 1.5px solid #E5E7EB; box-shadow: 0 4px 10px rgba(0,0,0,0.02);">
        <form action="{{ route($role . '.master-data.kelas.update', $kelas->id_kelas) }}" method="POST" id="mainForm">
            @csrf
            @method('PUT')
            
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">ID Kelas</label>
                <input type="text" value="KLS{{ str_pad($kelas->id_kelas, 4, '0', STR_PAD_LEFT) }}" readonly 
                       style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #F3F4F6; outline: none; color: #6B7280; font-size: 14px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Nama Kelas <span style="color: red;">*</span></label>
                <input type="text" name="nama_kelas" value="{{ old('nama_kelas', $kelas->nama_kelas) }}" required
                       style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none; font-size: 14px;">
                @error('nama_kelas') <small style="color: red;">{{ $message }}</small> @enderror
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Jenjang <span style="color: red;">*</span></label>
                <select name="jenjang" required 
                        style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none; font-size: 14px; cursor: pointer;">
                    <option value="SD" {{ old('jenjang', $kelas->jenjang) == 'SD' ? 'selected' : '' }}>SD</option>
                    <option value="SMP" {{ old('jenjang', $kelas->jenjang) == 'SMP' ? 'selected' : '' }}>SMP</option>
                    <option value="SMA" {{ old('jenjang', $kelas->jenjang) == 'SMA' ? 'selected' : '' }}>SMA</option>
                </select>
                @error('jenjang') <small style="color: red;">{{ $message }}</small> @enderror
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Periode <span style="color: red;">*</span></label>
                <select name="id_periode" required 
                        style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none; font-size: 14px; cursor: pointer;">
                    @foreach($periodeList as $periode)
                        <option value="{{ $periode->id_periode }}" {{ old('id_periode', $kelas->id_periode) == $periode->id_periode ? 'selected' : '' }}>
                            {{ $periode->tahun_periode }}
                        </option>
                    @endforeach
                </select>
                @error('id_periode') <small style="color: red;">{{ $message }}</small> @enderror
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Jumlah Murid</label>
                <input type="text" value="{{ $kelas->jumlah_murid ?? 0 }}" readonly 
                       style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #F3F4F6; outline: none; color: #6B7280; font-size: 14px;">
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 20px; margin-top: 30px;">
                <button type="button" onclick="bukaModalBatal()" 
                        style="padding: 10px 45px; border: 1.5px solid #4D0B87; color: #4D0B87; border-radius: 10px; font-weight: 600; font-size: 16px; background: #FFFFFF; cursor: pointer;">Keluar</button>
                <button type="submit" 
                        style="padding: 10px 45px; border: none; background: #4D0B87; color: white; border-radius: 10px; font-weight: 600; font-size: 16px; cursor: pointer;">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- MODALS --}}
<div id="modalBatal" style="display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); backdrop-filter: blur(3px); align-items: center; justify-content: center;">
    <div style="background: white; padding: 25px; border-radius: 20px; width: 320px; text-align: center;">
        <div style="color: #F59E0B; font-size: 40px;"><i class="fas fa-exclamation-triangle"></i></div>
        <h2>Batalkan?</h2>
        <p>Perubahan tidak akan disimpan.</p>
        <div style="display: flex; gap: 10px;">
            <button onclick="tutupModalBatal()" style="flex: 1; padding: 10px; border-radius: 10px; border: 1px solid #E5E7EB;">Tidak</button>
            <a href="{{ route($role . '.master-data.kelas') }}" style="flex: 1; text-decoration: none;">
                <button style="width: 100%; padding: 10px; border-radius: 10px; border: none; background: #EF4444; color: white;">Ya</button>
            </a>
        </div>
    </div>
</div>

<div id="modalPindahHalaman" style="display: none; position: fixed; z-index: 10000; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); backdrop-filter: blur(3px); align-items: center; justify-content: center;">
    <div style="background: white; padding: 25px; border-radius: 20px; width: 320px; text-align: center;">
        <div style="color: #F59E0B; font-size: 40px;"><i class="fas fa-exclamation-triangle"></i></div>
        <h2>Perubahan Belum Disimpan</h2>
        <p>Yakin ingin keluar?</p>
        <div style="display: flex; gap: 10px;">
            <button onclick="tutupModalPindah()" style="flex: 1; padding: 10px; border-radius: 10px; border: 1px solid #E5E7EB;">Tidak</button>
            <button id="confirmPindahBtn" style="flex: 1; padding: 10px; border-radius: 10px; border: none; background: #EF4444; color: white;">Ya</button>
        </div>
    </div>
</div>

<script>
    let formChanged = false;
    const form = document.getElementById('mainForm');
    if (form) {
        form.querySelectorAll('input:not([readonly]), select, textarea').forEach(input => {
            input.addEventListener('change', () => formChanged = true);
            input.addEventListener('keyup', () => formChanged = true);
        });
        form.addEventListener('submit', () => formChanged = false);
    }
    function bukaModalBatal() { 
        if (formChanged) {
            document.getElementById('modalPindahHalaman').style.display = 'flex';
            document.getElementById('confirmPindahBtn').onclick = () => {
                formChanged = false;
                window.location.href = "{{ route($role . '.master-data.kelas') }}";
            };
        } else document.getElementById('modalBatal').style.display = 'flex';
    }
    function tutupModalBatal() { document.getElementById('modalBatal').style.display = 'none'; }
    function tutupModalPindah() { document.getElementById('modalPindahHalaman').style.display = 'none'; }
</script>
@endsection