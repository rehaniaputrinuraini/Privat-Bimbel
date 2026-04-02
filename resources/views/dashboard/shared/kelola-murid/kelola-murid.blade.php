@extends('layouts.app')

@section('content')
<div style="margin-bottom: 25px;">
    <p style="color: #6B7280; font-size: 13px;">{{ date('F Y') }}</p>
    <h1 style="font-size: 24px; font-weight: 600; color: #5D10A2;">Kelola Murid (Admin)</h1>
    <p style="color: #6B7280; font-size: 13px;">Manajemen Data Murid</p>
</div>

<div class="card" style="background: white; padding: 20px; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
    <div style="display: flex; align-items: center; justify-content: space-between; gap: 10px; margin-bottom: 20px;">
        <form action="{{ route('admin.kelola-murid') }}" method="GET" style="display: flex; gap: 10px;">
            <select name="kelas" onchange="this.form.submit()" style="padding: 8px 15px; border-radius: 8px; border: 1px solid #E5E7EB;">
                <option value="">---Pilih Kelas---</option>
                @foreach($filter_kelas as $k)
                    <option value="{{ $k }}" {{ request('kelas') == $k ? 'selected' : '' }}>{{ $k }}</option>
                @endforeach
            </select>

            <select name="tahun" onchange="this.form.submit()" style="padding: 8px 15px; border-radius: 8px; border: 1px solid #E5E7EB;">
                <option value="">---Tahun Masuk---</option>
                @foreach($filter_tahun as $t)
                    <option value="{{ $t }}" {{ request('tahun') == $t ? 'selected' : '' }}>{{ $t }}</option>
                @endforeach
            </select>
        </form>

        <a href="{{ route('admin.murid.create') }}" style="background: #5D10A2; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 500;">
            <i class="fas fa-plus"></i> Tambah Murid
        </a>
    </div>

    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #F9FAFB; text-align: left; border-bottom: 2px solid #F3F4F6;">
                    <th style="padding: 12px;">No</th>
                    <th style="padding: 12px;">Nama Lengkap</th>
                    <th style="padding: 12px;">Kelas</th>
                    <th style="padding: 12px;">Asal Sekolah</th>
                    <th style="padding: 12px;">Tahun</th>
                    <th style="padding: 12px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($murids as $index => $m)
                <tr style="border-bottom: 1px solid #F3F4F6;">
                    <td style="padding: 12px;">{{ $index + 1 }}</td>
                    <td style="padding: 12px; font-weight: 500;">{{ $m->nama_lengkap_murid }}</td>
                    <td style="padding: 12px;">{{ $m->kelas }}</td>
                    <td style="padding: 12px;">{{ $m->asal_sekolah }}</td>
                    <td style="padding: 12px;">{{ $m->tahun_masuk }}</td>
                    <td style="padding: 12px;">
                        <div style="display: flex; gap: 8px;">
                            <a href="{{ route('admin.murid.edit', $m->id_murid) }}" style="color: #5CB85C; text-decoration: none; font-size: 14px;">Edit</a>
                            <form action="#" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit" style="color: #D9534F; border: none; background: none; cursor: pointer; font-size: 14px;">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection