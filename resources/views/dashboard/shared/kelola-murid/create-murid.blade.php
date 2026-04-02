@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div style="margin-bottom: 25px;">
        <a href="{{ route('admin.kelola-murid') }}" style="text-decoration: none; color: #5D10A2; font-size: 14px; display: flex; align-items: center; gap: 8px;">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Murid
        </a>
        <h1 style="font-size: 24px; font-weight: 600; color: #5D10A2; margin-top: 10px;">Tambah Murid Baru (Admin)</h1>
        <p style="color: #6B7280; font-size: 13px;">Input data murid baru untuk pendaftaran bimbel.</p>
    </div>

    <div class="card" style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); max-width: 900px;">
        <form action="#" method="POST">
            @csrf
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 25px;">
                
                <div class="form-group">
                    <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #374151;">Nama Lengkap Murid</label>
                    <input type="text" name="nama_lengkap_murid" placeholder="Masukkan nama lengkap" required style="width: 100%; padding: 12px; border: 1px solid #E5E7EB; border-radius: 8px; outline-color: #5D10A2;">
                </div>

                <div class="form-group">
                    <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #374151;">Kelas</label>
                    <select name="kelas" required style="width: 100%; padding: 12px; border: 1px solid #E5E7EB; border-radius: 8px; outline-color: #5D10A2; background: white;">
                        <option value="">--- Pilih Kelas ---</option>
                        <option>7 SMP</option>
                        <option>8 SMP</option>
                        <option>9 SMP</option>
                        <option>10 SMA</option>
                        <option>11 SMA</option>
                        <option>12 SMA</option>
                    </select>
                </div>

                <div class="form-group">
                    <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #374151;">Asal Sekolah</label>
                    <input type="text" name="asal_sekolah" placeholder="Misal: SMAN 1 Madiun" required style="width: 100%; padding: 12px; border: 1px solid #E5E7EB; border-radius: 8px; outline-color: #5D10A2;">
                </div>

                <div class="form-group">
                    <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #374151;">Tahun Masuk</label>
                    <input type="number" name="tahun_masuk" value="{{ date('Y') }}" style="width: 100%; padding: 12px; border: 1px solid #E5E7EB; border-radius: 8px; outline-color: #5D10A2;">
                </div>

                <div class="form-group">
                    <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #374151;">Pilihan Paket</label>
                    <input type="text" name="pilihan_paket" placeholder="Misal: IPA / Matematika" style="width: 100%; padding: 12px; border: 1px solid #E5E7EB; border-radius: 8px; outline-color: #5D10A2;">
                </div>

                <div class="form-group">
                    <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #374151;">No. HP Murid</label>
                    <input type="text" name="no_hp_murid" placeholder="0812xxxx" style="width: 100%; padding: 12px; border: 1px solid #E5E7EB; border-radius: 8px; outline-color: #5D10A2;">
                </div>
            </div>

            <div style="margin-top: 35px; border-top: 1px solid #F3F4F6; padding-top: 20px; display: flex; gap: 15px;">
                <button type="submit" style="background: #5D10A2; color: white; padding: 12px 30px; border: none; border-radius: 8px; cursor: pointer; font-weight: 600; transition: 0.3s;">
                    Simpan Data
                </button>
                <a href="{{ route('admin.kelola-murid') }}" style="background: #F3F4F6; color: #374151; padding: 12px 30px; border-radius: 8px; text-decoration: none; text-align: center; font-weight: 500;">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection