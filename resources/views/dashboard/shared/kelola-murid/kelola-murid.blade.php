@extends('layouts.app')

@section('content')
<div class="container-fluid" style="padding: 20px;">
    {{-- Header Halaman --}}
    <div style="margin-bottom: 20px;">
        <p style="color: #6B7280; font-size: 14px; margin: 0;">{{ date('F Y') }}</p>
        <h1 style="font-size: 24px; font-weight: 700; color: #000; margin: 0;">Kelola Murid</h1>
        <p style="color: #6B7280; font-size: 13px;">Manajemen Data Murid</p>
    </div>

    {{-- Filter & Tombol Tambah --}}
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; gap: 15px;">
        <div style="display: flex; gap: 10px;">
            <select name="kelas" style="padding: 8px 15px; border-radius: 20px; border: 1px solid #E5E7EB; color: #9CA3AF; font-size: 13px; min-width: 150px; background: white;">
                <option value="">---Pilih Kelas---</option>
                @foreach($filter_kelas as $kelas)
                    <option value="{{ $kelas }}">{{ $kelas }}</option>
                @endforeach
            </select>
            <select name="tahun" style="padding: 8px 15px; border-radius: 20px; border: 1px solid #E5E7EB; color: #9CA3AF; font-size: 13px; min-width: 150px; background: white;">
                <option value="">---Tahun Masuk---</option>
                @foreach($filter_tahun as $tahun)
                    <option value="{{ $tahun }}">{{ $tahun }}</option>
                @endforeach
            </select>
        </div>
        
        {{-- Route disesuaikan dengan variabel $role dari Controller --}}
        <a href="{{ route($role.'.murid.create') }}" style="background: #5D10A2; color: white; padding: 10px 25px; border-radius: 12px; text-decoration: none; font-weight: 600; display: flex; align-items: center; gap: 10px; font-size: 14px;">
            <span style="font-size: 20px;">+</span> Tambah
        </a>
    </div>

    {{-- Search Bar --}}
    <div style="position: relative; margin-bottom: 25px;">
        <input type="text" placeholder="Cari" style="width: 100%; padding: 12px 12px 12px 45px; border-radius: 25px; border: 1px solid #E5E7EB; outline: none; background: white;">
        <div style="position: absolute; left: 18px; top: 50%; transform: translateY(-50%); color: #9CA3AF;">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
            </svg>
        </div>
    </div>

    {{-- Tabel Utama (Desain Rounded & Purple Header) --}}
    <div style="background: white; border-radius: 20px; border: 1px solid #E5E7EB; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; min-width: 1300px;">
                <thead>
                    <tr style="background: #F3E8FF; text-align: left;">
                        <th style="padding: 15px; font-size: 13px; color: #000; font-weight: 700;">No</th>
                        <th style="padding: 15px; font-size: 13px; color: #000; font-weight: 700;">Nama Lengkap</th>
                        <th style="padding: 15px; font-size: 13px; color: #000; font-weight: 700;">Kelas</th>
                        <th style="padding: 15px; font-size: 13px; color: #000; font-weight: 700;">Asal Sekolah</th>
                        <th style="padding: 15px; font-size: 13px; color: #000; font-weight: 700;">Alamat</th>
                        <th style="padding: 15px; font-size: 13px; color: #000; font-weight: 700;">No HP Siswa</th>
                        <th style="padding: 15px; font-size: 13px; color: #000; font-weight: 700;">Nama Orang Tua</th>
                        <th style="padding: 15px; font-size: 13px; color: #000; font-weight: 700;">No HP Ortu</th>
                        <th style="padding: 15px; font-size: 13px; color: #000; font-weight: 700;">Paket Awal</th>
                        <th style="padding: 15px; font-size: 13px; color: #000; font-weight: 700;">Pilihan Paket</th>
                        <th style="padding: 15px; font-size: 13px; color: #000; font-weight: 700;">Tahun Masuk</th>
                        <th style="padding: 15px; font-size: 13px; color: #000; font-weight: 700; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($murids as $index => $m)
                    <tr style="border-bottom: 1px solid #F3F4F6;">
                        <td style="padding: 15px; font-size: 13px;">{{ $index + 1 }}</td>
                        <td style="padding: 15px; font-size: 13px;">{{ $m->nama_lengkap_murid }}</td>
                        <td style="padding: 15px; font-size: 13px;">{{ $m->kelas }}</td>
                        <td style="padding: 15px; font-size: 13px;">{{ $m->asal_sekolah }}</td>
                        <td style="padding: 15px; font-size: 13px; color: #6B7280;">{{ $m->alamat_murid ?? 'XXXXXXXXXX' }}</td>
                        <td style="padding: 15px; font-size: 13px;">{{ $m->no_hp_murid }}</td>
                        <td style="padding: 15px; font-size: 13px;">{{ $m->nama_orang_tua }}</td>
                        <td style="padding: 15px; font-size: 13px;">{{ $m->no_hp_orang_tua }}</td>
                        <td style="padding: 15px; font-size: 13px;">{{ $m->paket_awal }}</td>
                        <td style="padding: 15px; font-size: 13px;">{{ $m->pilihan_paket }}</td>
                        <td style="padding: 15px; font-size: 13px;">{{ $m->tahun_masuk }}</td>
                        <td style="padding: 15px;">
                            <div style="display: flex; gap: 8px; justify-content: center;">
                                <a href="{{ route($role.'.murid.edit', $m->id_murid) }}" style="background: #4ADE80; color: white; padding: 6px 15px; border-radius: 8px; text-decoration: none; font-size: 12px; display: flex; align-items: center; gap: 5px;">
                                    Edit
                                </a>
                                <form action="#" method="POST" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit" style="background: #F87171; color: white; padding: 6px 15px; border-radius: 8px; border: none; font-size: 12px; cursor: pointer;">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
    {{-- Pagination Dummy (Sesuai Gambar) --}}
    <div style="margin-top: 20px; display: flex; justify-content: space-between; align-items: center;">
        <select style="padding: 5px 10px; border-radius: 10px; border: 1px solid #E5E7EB; font-size: 12px;">
            <option>10 baris</option>
        </select>
        <div style="display: flex; gap: 5px;">
            <button style="padding: 5px 10px; border-radius: 8px; border: 1px solid #E5E7EB; background: white;"><<</button>
            <button style="padding: 5px 10px; border-radius: 8px; border: 1px solid #E5E7EB; background: white;"><</button>
            <button style="padding: 5px 10px; border-radius: 8px; background: #5D10A2; color: white; border: none;">1</button>
            <button style="padding: 5px 10px; border-radius: 8px; border: 1px solid #E5E7EB; background: white;">></button>
        </div>
    </div>
</div>
@endsection