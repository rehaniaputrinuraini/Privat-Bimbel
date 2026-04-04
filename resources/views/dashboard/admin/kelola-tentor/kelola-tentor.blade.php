@extends('layouts.app')

@section('title', 'Data Tentor')

@section('content')
<div style="width: 100%;">
    
    {{-- HEADER HALAMAN --}}
    <div style="margin-bottom: 25px;">
        <p style="color: #374151; font-size: 13px; margin: 0 0 4px 0;">
            {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}
        </p>
        <h1 style="font-size: 26px; font-weight: 700; color: #111827; margin: 0; letter-spacing: -0.5px; line-height: 1.2;">
            Data Tentor
        </h1>
        <p style="color: #374151; font-size: 14px; margin: 4px 0 0 0;">Manajemen Data dan Honorarium Tentor Bimbel Privat</p>
    </div>

    {{-- ACTIONS BAR --}}
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; gap: 15px;">
        <div style="display: flex; align-items: center; gap: 12px; flex: 1;">
            <div style="position: relative; width: 300px;">
                <i class="fas fa-search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #9CA3AF;"></i>
                <input type="text" placeholder="Cari Nama atau ID Tentor..." 
                       style="width: 100%; padding: 10px 15px 10px 45px; border-radius: 12px; border: 1px solid #E5E7EB; outline: none; background: white; font-size: 14px; color: #374151;">
            </div>

            <select style="padding: 10px 12px; border-radius: 12px; border: 1px solid #E5E7EB; color: #374151; font-size: 13px; min-width: 160px; background: white; outline: none; cursor: pointer;">
                <option value="">--- Status Gaji ---</option>
                <option value="Sudah">Sudah</option>
                <option value="Belum">Belum</option>
            </select>
        </div>
        
        <a href="{{ route($role . '.data-tentor.create') }}" style="text-decoration: none;">
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
                        <th style="padding: 15px; font-weight: 700; width: 50px; text-align: center;">No</th>
                        <th style="padding: 15px; font-weight: 700;">ID</th>
                        <th style="padding: 15px; font-weight: 700;">Nama Lengkap</th>
                        <th style="padding: 15px; font-weight: 700;">Alamat</th>
                        <th style="padding: 15px; font-weight: 700;">No HP</th>
                        <th style="padding: 15px; font-weight: 700;">Mapel</th>
                        <th style="padding: 15px; font-weight: 700; text-align: center;">Grade</th>
                        <th style="padding: 15px; font-weight: 700;">HR SD</th>
                        <th style="padding: 15px; font-weight: 700;">HR SMP</th>
                        <th style="padding: 15px; font-weight: 700;">HR SMA</th>
                        <th style="padding: 15px; font-weight: 700;">Makan</th>
                        <th style="padding: 15px; font-weight: 700; text-align: center;">Status Gaji</th>
                        <th style="padding: 15px; font-weight: 700; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody style="color: #374151;">
                    @php
                        $tentors = [
                            ['id' => 'TE0001', 'nama' => 'Rati Maria', 'alamat' => 'Madiun, Jawa Timur', 'hp' => '0881999999', 'mapel' => 'Matematika', 'grade' => 'A', 'sd' => '50.000', 'smp' => '50.000', 'sma' => '50.000', 'makan' => '10.000', 'status' => 'Sudah'],
                            ['id' => 'TE0002', 'nama' => 'Dwi Rahayu', 'alamat' => 'Madiun, Jawa Timur', 'hp' => '0881999999', 'mapel' => 'B. Inggris', 'grade' => 'A', 'sd' => '50.000', 'smp' => '50.000', 'sma' => '50.000', 'makan' => '-', 'status' => 'Sudah'],
                            ['id' => 'TE0003', 'nama' => 'Rahma Tyas', 'alamat' => 'Madiun, Jawa Timur', 'hp' => '0881999999', 'mapel' => 'Fisika', 'grade' => 'B', 'sd' => '40.000', 'smp' => '40.000', 'sma' => '40.000', 'makan' => '-', 'status' => 'Belum'],
                        ];
                    @endphp

                    @foreach($tentors as $index => $t)
                    <tr style="border-bottom: 1px solid #F3F4F6; transition: 0.2s;" onmouseover="this.style.background='#F9FAFB'" onmouseout="this.style.background='transparent'">
                        <td style="padding: 15px; text-align: center;">{{ $index + 1 }}</td>
                        <td style="padding: 15px;">{{ $t['id'] }}</td>
                        <td style="padding: 15px;">{{ $t['nama'] }}</td>
                        <td style="padding: 15px;">{{ $t['alamat'] }}</td>
                        <td style="padding: 15px;">{{ $t['hp'] }}</td>
                        <td style="padding: 15px;">{{ $t['mapel'] }}</td>
                        <td style="padding: 15px; text-align: center;">{{ $t['grade'] }}</td>  {{-- HAPUS BACKGROUND & WARNA --}}
                        <td style="padding: 15px;">{{ $t['sd'] }}</td>
                        <td style="padding: 15px;">{{ $t['smp'] }}</td>
                        <td style="padding: 15px;">{{ $t['sma'] }}</td>
                        <td style="padding: 15px;">{{ $t['makan'] }}</td>
                        <td style="padding: 15px; text-align: center;">
                            <span style="padding: 5px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; 
                                background: {{ $t['status'] == 'Sudah' ? '#E1F7E3' : '#FEE2E2' }}; 
                                color: {{ $t['status'] == 'Sudah' ? '#0E7490' : '#EF4444' }};">
                                {{ $t['status'] == 'Sudah' ? 'Sudah' : 'Belum' }}
                            </span>
                        </td>
                        <td style="padding: 15px; text-align: center;">
                            <div style="display: flex; gap: 8px; justify-content: center;">
                                <a href="{{ route($role . '.data-tentor.edit', $t['id']) }}" 
                                   style="background: #5EB37E; color: white; padding: 6px 12px; border-radius: 6px; text-decoration: none; display: inline-flex; align-items: center; gap: 5px; font-size: 12px;">
                                    <i class="far fa-edit"></i> Edit
                                </a>
                                <form action="{{ route($role . '.data-tentor.destroy', $t['id']) }}" method="POST" style="margin: 0;">
                                    @csrf @method('DELETE')
                                    <button type="submit" onclick="return confirm('Hapus data tentor {{ $t['nama'] }}?')" 
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
            <span style="color: #374151; font-size: 13px;">Menampilkan {{ count($tentors) }} data</span>
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