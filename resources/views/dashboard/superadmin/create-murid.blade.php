@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div style="margin-bottom: 25px;">
        <a href="{{ route('superadmin.kelola-murid') }}" style="text-decoration: none; color: #5D10A2; font-size: 14px;">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar
        </a>
        <h1 style="font-size: 24px; font-weight: 600; color: #5D10A2; margin-top: 10px;">Tambah Murid (Superadmin)</h1>
    </div>

    <div class="card" style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); max-width: 900px;">
        <form action="#" method="POST">
            @csrf
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 25px;">
                <div class="form-group">
                    <label style="display: block; margin-bottom: 8px; font-weight: 500;">Nama Lengkap Murid</label>
                    <input type="text" name="nama" placeholder="Masukkan nama" style="width: 100%; padding: 12px; border: 1px solid #E5E7EB; border-radius: 8px;">
                </div>
                <div class="form-group">
                    <label style="display: block; margin-bottom: 8px; font-weight: 500;">Kelas</label>
                    <select name="kelas" style="width: 100%; padding: 12px; border: 1px solid #E5E7EB; border-radius: 8px;">
                        <option>--- Pilih Kelas ---</option>
                        <option>7 SMP</option><option>8 SMP</option><option>9 SMP</option>
                        <option>10 SMA</option><option>11 SMA</option><option>12 SMA</option>
                    </select>
                </div>
                <div class="form-group">
                    <label style="display: block; margin-bottom: 8px; font-weight: 500;">Asal Sekolah</label>
                    <input type="text" name="sekolah" placeholder="Nama sekolah" style="width: 100%; padding: 12px; border: 1px solid #E5E7EB; border-radius: 8px;">
                </div>
                <div class="form-group">
                    <label style="display: block; margin-bottom: 8px; font-weight: 500;">Tahun Masuk</label>
                    <input type="number" name="tahun" value="2026" style="width: 100%; padding: 12px; border: 1px solid #E5E7EB; border-radius: 8px;">
                </div>
            </div>

            <div style="margin-top: 35px; border-top: 1px solid #F3F4F6; padding-top: 20px; display: flex; gap: 15px;">
                <button type="submit" style="background: #5D10A2; color: white; padding: 12px 30px; border: none; border-radius: 8px; cursor: pointer; font-weight: 600;">
                    Simpan Data Murid
                </button>
                <a href="{{ route('superadmin.kelola-murid') }}" style="background: #F3F4F6; color: #374151; padding: 12px 30px; border-radius: 8px; text-decoration: none; text-align: center;">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection