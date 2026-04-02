@extends('layouts.app')

@section('title', 'Manajemen Harga Paket')

@section('content')
{{-- Header Halaman --}}
<div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 25px;">
    <div>
        <p style="color: #6B7280; font-size: 14px; margin-bottom: 5px;">{{ \Carbon\Carbon::now()->translatedFormat('F Y') }}</p>
        <h1 style="font-size: 28px; font-weight: 800; color: #111827; margin: 0;">Harga Paket</h1>
        <p style="color: #6B7280; font-size: 14px; margin-top: 5px;">Manajemen Harga Paket</p>
    </div>
    
    {{-- Tombol Tambah --}}
    <a href="{{ route($role . '.harga-paket.create') }}" style="text-decoration: none;">
        <button style="background-color: #4D0B87; color: white; border: none; padding: 12px 28px; border-radius: 12px; font-weight: 700; cursor: pointer; display: flex; align-items: center; gap: 10px; font-size: 16px;">
            <i class="fas fa-plus"></i> Tambah
        </button>
    </a>
</div>

{{-- Tabel Area --}}
<div style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border: 1px solid #E5E7EB;">
    <table style="width: 100%; border-collapse: collapse; text-align: center; font-family: 'Poppins', sans-serif;">
        <thead>
            <tr style="background-color: #F3E8FF; color: #111827; font-weight: 800; font-size: 15px;">
                <td style="padding: 20px; width: 80px;">No</td>
                <td style="padding: 20px;">ID</td>
                <td style="padding: 20px;">Harga Paket</td>
                <td style="padding: 20px;">Tingkat</td>
                <td style="padding: 20px;">Aksi</td>
            </tr>
        </thead>
        
        <tbody style="color: #111827; font-size: 15px;">
            @php
                // Menyesuaikan data dummy dengan gambar referensi
                $pakets = [
                    (object)['kode' => 'PK0001', 'harga' => '120.000', 'tingkat' => 'SD'],
                    (object)['kode' => 'PK0002', 'harga' => '150.000', 'tingkat' => 'SMP'],
                    (object)['kode' => 'PK0003', 'harga' => '180.000', 'tingkat' => 'SMA'],
                    (object)['kode' => 'PK0004', 'harga' => '100.000', 'tingkat' => 'Biaya Pendaftaran'],
                ];
            @endphp

            @foreach($pakets as $index => $p)
            <tr style="border-bottom: 1px solid #F3F4F6; transition: 0.3s;" onmouseover="this.style.backgroundColor='#F9FAFB'" onmouseout="this.style.backgroundColor='transparent'">
                <td style="padding: 22px; font-weight: 700;">{{ $index + 1 }}</td>
                <td style="padding: 22px; font-weight: 800; letter-spacing: 0.5px;">{{ $p->kode }}</td>
                <td style="padding: 22px; font-weight: 800;">{{ $p->harga }}</td>
                <td style="padding: 22px; font-weight: 700;">{{ $p->tingkat }}</td>
                <td style="padding: 22px;">
                    <div style="display: flex; gap: 10px; justify-content: center;">
                        {{-- Tombol Edit (Hijau) --}}
                        <a href="#" style="text-decoration: none;">
                            <button style="background-color: #5BB85C; color: white; border: none; padding: 8px 15px; border-radius: 8px; cursor: pointer; font-size: 13px; display: flex; align-items: center; gap: 6px; font-weight: 600;">
                                <i class="fas fa-edit" style="font-size: 14px;"></i> Edit
                            </button>
                        </a>
                        {{-- Tombol Hapus (Merah) --}}
                        <form action="#" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Hapus paket ini?')" style="background-color: #D9534F; color: white; border: none; padding: 8px 15px; border-radius: 8px; cursor: pointer; font-size: 13px; display: flex; align-items: center; gap: 6px; font-weight: 600;">
                                <i class="fas fa-trash" style="font-size: 14px;"></i> Hapus
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection