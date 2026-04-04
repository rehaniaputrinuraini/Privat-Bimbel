@extends('layouts.app')

@section('title', 'Kelola Murid')

@section('content')
<div style="width: 100%;">
    
    {{-- HEADER HALAMAN --}}
    <div style="margin-bottom: 25px;">
        <p style="color: #374151; font-size: 13px; margin: 0 0 4px 0;">
            {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}
        </p>
        <h1 style="font-size: 26px; font-weight: 700; color: #111827; margin: 0; letter-spacing: -0.5px; line-height: 1.2;">
            Kelola Murid
        </h1>
        <p style="color: #374151; font-size: 14px; margin: 4px 0 0 0;">Manajemen Data Murid</p>
    </div>

    {{-- ACTIONS BAR --}}
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; gap: 15px;">
        <div style="display: flex; align-items: center; gap: 12px; flex: 1;">
            <div style="position: relative; width: 300px;">
                <i class="fas fa-search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #9CA3AF;"></i>
                <input type="text" placeholder="Cari Nama Murid..." 
                       style="width: 100%; padding: 10px 15px 10px 45px; border-radius: 12px; border: 1px solid #E5E7EB; outline: none; background: white; font-size: 14px; color: #374151;">
            </div>

            <select style="padding: 10px 12px; border-radius: 12px; border: 1px solid #E5E7EB; color: #374151; font-size: 13px; min-width: 160px; background: white; outline: none; cursor: pointer;">
                <option value="">--- Pilihan Paket ---</option>
                <option value="Reguler">Reguler</option>
                <option value="Privat">Privat</option>
                <option value="Intensif">Intensif</option>
            </select>

            <select style="padding: 10px 12px; border-radius: 12px; border: 1px solid #E5E7EB; color: #374151; font-size: 13px; min-width: 160px; background: white; outline: none; cursor: pointer;">
                <option value="">--- Tahun Masuk ---</option>
                <option value="2023">2023</option>
                <option value="2024">2024</option>
                <option value="2025">2025</option>
            </select>
        </div>
        
        <a href="{{ route($role . '.murid.create') }}" style="text-decoration: none;">
            <button style="background-color: #4D0B87; color: white; border: none; padding: 12px 25px; border-radius: 12px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 10px; font-size: 14px; transition: 0.3s; box-shadow: 0 4px 6px rgba(77, 11, 135, 0.2);">
                <i class="fas fa-plus"></i> Tambah
            </button>
        </a>
    </div>

    {{-- TABEL UTAMA --}}
    <div style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.08); border: 1px solid #F3F4F6;">
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 13px; white-space: nowrap;">
                <thead>
                    <tr style="background: #F3E8FF; color: #111827;">
                        <th style="padding: 15px; font-weight: 700; width: 50px;">No</th>
                        <th style="padding: 15px; font-weight: 700;">Nama Lengkap</th>
                        <th style="padding: 15px; font-weight: 700;">Kelas</th>
                        <th style="padding: 15px; font-weight: 700;">Asal Sekolah</th>
                        <th style="padding: 15px; font-weight: 700;">Alamat</th>
                        <th style="padding: 15px; font-weight: 700;">No HP Siswa</th>
                        <th style="padding: 15px; font-weight: 700;">Nama Orang Tua</th>
                        <th style="padding: 15px; font-weight: 700;">No HP Ortu</th>
                        <th style="padding: 15px; font-weight: 700; text-align: center;">Paket Awal</th>
                        <th style="padding: 15px; font-weight: 700;">Pilihan Paket</th>
                        <th style="padding: 15px; font-weight: 700; text-align: center;">Tahun Masuk</th>
                        <th style="padding: 15px; font-weight: 700; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody style="color: #374151;">
                    @php
                        if(empty($murids)) {
                            $murids = [
                                (object)[
                                    'id_murid' => 1,
                                    'nama_lengkap_murid' => 'Budi Santoso',
                                    'kelas' => '12 SMA',
                                    'asal_sekolah' => 'SMAN 1 Madiun',
                                    'alamat_murid' => 'Madiun, Jawa Timur',
                                    'no_hp_murid' => '08123456789',
                                    'nama_orang_tua' => 'Sutrisno',
                                    'no_hp_orang_tua' => '08123456700',
                                    'pilihan_paket' => 'Reguler',
                                    'tahun_masuk' => '2024'
                                ]
                            ];
                        }
                    @endphp

                    @foreach($murids as $index => $m)
                    <tr style="border-bottom: 1px solid #F3F4F6; transition: 0.2s;" onmouseover="this.style.background='#F9FAFB'" onmouseout="this.style.background='transparent'">
                        <td style="padding: 15px;">{{ $index + 1 }}</td>
                        <td style="padding: 15px;">{{ $m->nama_lengkap_murid }}</td>   {{-- HAPUS font-weight: 600 --}}
                        <td style="padding: 15px;">{{ $m->kelas }}</td>
                        <td style="padding: 15px;">{{ $m->asal_sekolah }}</td>
                        <td style="padding: 15px; color: #6B7280;">{{ $m->alamat_murid }}</td>
                        <td style="padding: 15px;">{{ $m->no_hp_murid }}</td>
                        <td style="padding: 15px;">{{ $m->nama_orang_tua }}</td>
                        <td style="padding: 15px;">{{ $m->no_hp_orang_tua }}</td>
                        <td style="padding: 15px; text-align: center;">
                            <input type="checkbox" checked disabled style="accent-color: #4D0B87; width: 16px; height: 16px;">
                        </td>
                        <td style="padding: 15px;">{{ $m->pilihan_paket }}</td>
                        <td style="padding: 15px; text-align: center;">{{ $m->tahun_masuk }}</td>
                        <td style="padding: 15px; text-align: center;">
                            <div style="display: flex; gap: 8px; justify-content: center;">
                                <a href="{{ route($role . '.murid.edit', $m->id_murid) }}" 
                                   style="background: #5EB37E; color: white; padding: 6px 12px; border-radius: 6px; text-decoration: none; display: inline-flex; align-items: center; gap: 5px; font-size: 12px;">
                                    <i class="far fa-edit"></i> Edit
                                </a>
                                <form action="{{ route($role . '.murid.destroy', $m->id_murid) }}" method="POST" style="margin: 0;">
                                    @csrf @method('DELETE')
                                    <button type="submit" onclick="return confirm('Hapus data murid {{ $m->nama_lengkap_murid }}?')" 
                                            style="background: #E35D5D; color: white; padding: 6px 12px; border-radius: 6px; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 5px; font-size: 12px;">
                                        <i class="fas fa-trash"></i> Hapus
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
    
    {{-- PAGINATION & SHOW ENTRIES --}}
    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px; padding: 0 5px;">
        <div style="display: flex; align-items: center; gap: 10px;">
            <select style="padding: 8px 12px; border-radius: 10px; border: 1px solid #E5E7EB; color: #374151; font-size: 13px; background: white; outline: none; cursor: pointer;">
                <option value="10">10 baris</option>
                <option value="25">25 baris</option>
                <option value="50">50 baris</option>
            </select>
            <span style="color: #374151; font-size: 13px;">Menampilkan {{ count($murids) }} data</span>
        </div>

        <div style="display: flex; gap: 5px;">
            <button style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; cursor: pointer;"><i class="fas fa-angle-double-left"></i></button>
            <button style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; cursor: pointer;"><i class="fas fa-angle-left"></i></button>
            <button style="width: 35px; height: 35px; border-radius: 8px; background: #4D0B87; color: white; border: none; font-weight: 600; cursor: pointer;">1</button>
            <button style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; cursor: pointer;"><i class="fas fa-angle-right"></i></button>
        </div>
    </div>

</div>
@endsection