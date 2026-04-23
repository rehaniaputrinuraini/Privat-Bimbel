@extends('layouts.app')

@section('title', 'Daftar Periode')

@section('content')
<div style="padding: 10px; font-family: 'Poppins', sans-serif;">
    <div style="margin-bottom: 25px;">
        <h1 style="font-size: 26px; font-weight: 700; color: #111827; margin: 0;">Daftar Periode</h1>
        <p style="color: #374151; font-size: 14px; margin: 4px 0 0 0;">Manajemen periode tahun ajaran</p>
    </div>

    <div style="background: white; border-radius: 20px; padding: 25px; box-shadow: 0 4px 15px rgba(0,0,0,0.08);">
        <div style="display: flex; justify-content: space-between; margin-bottom: 20px;">
            <a href="{{ route($role . '.periode.create') }}" style="text-decoration: none;">
                <button style="background: #4D0B87; color: white; border: none; padding: 12px 25px; border-radius: 12px; font-weight: 600;">
                    + Tambah Periode
                </button>
            </a>
        </div>

        @if(session('success_periode'))
            <div style="background: #D1FAE5; color: #065F46; padding: 12px; border-radius: 10px; margin-bottom: 20px;">
                {{ session('success_periode') }}
            </div>
        @endif

        <table style="width: 100%; border-collapse: collapse;">
            <thead style="background: #F3E8FF;">
                <tr>
                    <th style="padding: 15px;">No</th>
                    <th style="padding: 15px;">ID</th>
                    <th style="padding: 15px;">Tahun Periode</th>
                    <th style="padding: 15px;">Tanggal Mulai</th>
                    <th style="padding: 15px;">Tanggal Selesai</th>
                    <th style="padding: 15px;">Status</th>
                    <th style="padding: 15px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($periode as $item)
                <tr style="border-bottom: 1px solid #F3F4F6;">
                    <td style="padding: 15px; text-align: center;">{{ $loop->iteration }}</td>
                    <td style="padding: 15px; text-align: center;">PR{{ str_pad($item->id_periode, 4, '0', STR_PAD_LEFT) }}</td>
                    <td style="padding: 15px; text-align: center;">{{ $item->tahun_periode }}</td>
                    <td style="padding: 15px; text-align: center;">{{ $item->tanggal_mulai ? date('d/m/Y', strtotime($item->tanggal_mulai)) : '-' }}</td>
                    <td style="padding: 15px; text-align: center;">{{ $item->tanggal_selesai ? date('d/m/Y', strtotime($item->tanggal_selesai)) : '-' }}</td>
                    <td style="padding: 15px; text-align: center;">
                        @php
                            $sekarang = date('Y-m-d');
                            $aktif = ($item->tanggal_mulai <= $sekarang && $item->tanggal_selesai >= $sekarang);
                        @endphp
                        @if($aktif)
                            <span style="background: #D1FAE5; color: #065F46; padding: 4px 10px; border-radius: 20px;">Aktif</span>
                        @else
                            <span style="background: #F3F4F6; color: #6B7280; padding: 4px 10px; border-radius: 20px;">Nonaktif</span>
                        @endif
                    </td>
                    <td style="padding: 15px; text-align: center;">
                        <a href="{{ route($role . '.periode.edit', $item->id_periode) }}" style="background: #5EB37E; color: white; padding: 6px 12px; border-radius: 6px; text-decoration: none;">Edit</a>
                        <form action="{{ route($role . '.periode.destroy', $item->id_periode) }}" method="POST" style="display: inline;">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('Yakin hapus?')" style="background: #E35D5D; color: white; padding: 6px 12px; border-radius: 6px; border: none; cursor: pointer;">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" style="padding: 40px; text-align: center;">Belum ada data periode</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection