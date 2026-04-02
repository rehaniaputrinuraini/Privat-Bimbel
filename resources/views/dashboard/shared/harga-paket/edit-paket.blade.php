@extends('layouts.app')

@section('title', 'Edit Harga Paket')

@section('content')
<div style="margin-bottom: 25px;">
    <h1 style="font-size: 28px; font-weight: 700; color: #111827; margin: 0;">Edit Harga Paket</h1>
    <p style="color: #6B7280;">Perbarui data paket yang sudah ada ({{ ucfirst($role) }})</p>
</div>

{{-- Border warna Orange untuk menandakan mode EDIT --}}
<div style="background: white; border: 4px solid #f39c12; border-radius: 20px; padding: 45px; box-shadow: 0 4px 20px rgba(0,0,0,0.05);">
    <form action="#" method="POST">
        @csrf
        @method('PUT')
        
        <div style="margin-bottom: 30px;">
            <label style="display: block; font-weight: 700; margin-bottom: 12px; color: #111827; font-size: 16px;">ID Paket</label>
            <input type="text" name="kode" value="PK0001" disabled style="width: 100%; padding: 18px; border: 1px solid #D1D5DB; border-radius: 12px; background-color: #EEEEEE; font-size: 14px; color: #6B7280;">
        </div>

        <div style="margin-bottom: 30px;">
            <label style="display: block; font-weight: 700; margin-bottom: 12px; color: #111827; font-size: 16px;">Harga Paket</label>
            <input type="number" name="harga" value="120000" style="width: 100%; padding: 18px; border: 1px solid #D1D5DB; border-radius: 12px; background-color: #F9FAFB; font-size: 14px; outline: none;">
        </div>

        <div style="margin-bottom: 45px;">
            <label style="display: block; font-weight: 700; margin-bottom: 12px; color: #111827; font-size: 16px;">Tingkat</label>
            <select name="tingkat" style="width: 100%; padding: 18px; border: 1px solid #D1D5DB; border-radius: 12px; background-color: #F9FAFB; font-size: 14px; outline: none;">
                <option value="SD" selected>SD</option>
                <option value="SMP">SMP</option>
                <option value="SMA">SMA</option>
                <option value="Biaya Pendaftaran">Biaya Pendaftaran</option>
            </select>
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 20px;">
            <a href="{{ route($role . '.harga-paket') }}" style="text-decoration: none; padding: 14px 45px; border: 2px solid #5D10A2; color: #5D10A2; border-radius: 15px; font-weight: 700; text-align: center; font-size: 16px;">
                Batal
            </a>
            <button type="submit" style="padding: 14px 55px; background-color: #5D10A2; color: white; border: none; border-radius: 15px; font-weight: 700; cursor: pointer; font-size: 16px;">
                Update Data
            </button>
        </div>
    </form>
</div>
@endsection