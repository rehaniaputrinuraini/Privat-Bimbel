@extends('layouts.app')

@section('title', 'Daftar Kelas')

@section('content')
<div style="padding: 10px; font-family: 'Poppins', sans-serif;">
    <div style="margin-bottom: 25px;">
        <h1 style="font-size: 26px; font-weight: 700; color: #111827; margin: 0;">Daftar Kelas</h1>
        <p style="color: #374151; font-size: 14px; margin: 4px 0 0 0;">Manajemen data kelas</p>
    </div>

    <div style="background: white; border-radius: 20px; padding: 25px; box-shadow: 0 4px 15px rgba(0,0,0,0.08);">
        <div style="display: flex; justify-content: space-between; margin-bottom: 20px;">
            <a href="{{ route($role . '.kelas.create') }}" style="text-decoration: none;">
                <button style="background: #4D0B87; color: white; border: none; padding: 12px 25px; border-radius: 12px; font-weight: 600;">
                    + Tambah Kelas
                </button>
            </a>
        </div>

        @if(session('success_kelas'))
            <div style="background: #D1FAE5; color: #065F46; padding: 12px; border-radius: 10px; margin-bottom: 20px;">
                {{ session('success_kelas') }}
            </div>
        @endif

        <table style="width: 100%; border-collapse: collapse;">
            <thead style="background: #F3E8FF;">
                <tr>
                    <th style="padding: 15px;">No</th>
                    <th style="padding: 15px;">Nama Kelas</th>
                    <th style="padding: 15px;">Jenjang</th>
                    <th style="padding: 15px;">Jumlah Murid</th>
                    <th style="padding: 15px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kelas as $item)
                <tr style="border-bottom: 1px solid #F3F4F6;">
                    <td style="padding: 15px; text-align: center;">{{ $loop->iteration }}</td>
                    <td style="padding: 15px; text-align: center;">{{ $item->nama_kelas }}</td>
                    <td style="padding: 15px; text-align: center;">{{ $item->jenjang }}</td>
                    <td style="padding: 15px; text-align: center;">{{ $item->jumlah_murid ?? 0 }}</td>
                    <td style="padding: 15px; text-align: center;">
                        <a href="{{ route($role . '.kelas.edit', $item->id_kelas) }}" style="background: #5EB37E; color: white; padding: 6px 12px; border-radius: 6px; text-decoration: none;">Edit</a>
                        <form action="{{ route($role . '.kelas.destroy', $item->id_kelas) }}" method="POST" style="display: inline;">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('Yakin hapus?')" style="background: #E35D5D; color: white; padding: 6px 12px; border-radius: 6px; border: none; cursor: pointer;">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" style="padding: 40px; text-align: center;">Belum ada data kelas</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection