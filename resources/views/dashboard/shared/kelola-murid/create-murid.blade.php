@extends('layouts.app')
@section('content')
<div class="container-fluid" style="padding: 20px;">
    <h2 style="font-size: 20px; font-weight: 600; margin-bottom: 20px;">Input Data Murid</h2>
    <div style="background: white; padding: 30px; border-radius: 15px; border: 1.5px solid #D1D5DB;">
        <form action="{{ route($role.'.murid.store') }}" method="POST">
            @csrf
            <div style="margin-bottom: 15px;">
                <label>Nama Lengkap</label>
                <input type="text" name="nama_lengkap_murid" required style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #E5E7EB;">
            </div>
            <div style="display: flex; justify-content: flex-end; gap: 15px;">
                <a href="{{ route($role.'.kelola-murid') }}" style="padding: 10px 50px; border: 2px solid #5D10A2; color: #5D10A2; border-radius: 10px; text-decoration: none;">Keluar</a>
                <button type="submit" style="padding: 10px 50px; background: #5D10A2; color: white; border: none; border-radius: 10px; cursor: pointer;">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection