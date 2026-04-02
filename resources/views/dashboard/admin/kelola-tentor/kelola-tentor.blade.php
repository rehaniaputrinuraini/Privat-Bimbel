@extends('layouts.app')

@section('title', 'Data Tentor')

@section('content')
<div style="margin-bottom: 20px;">
    <p style="color: #6B7280; font-size: 14px; margin-bottom: 5px;">{{ \Carbon\Carbon::now()->translatedFormat('F Y') }}</p>
    <h1 style="font-size: 24px; font-weight: 700; color: #111827; margin: 0;">Data Tentor</h1>
    <p style="color: #6B7280; font-size: 13px;">Manajemen Data Tentor</p>
</div>

{{-- Filter Area --}}
<div style="display: flex; gap: 15px; margin-bottom: 20px;">
    <div style="position: relative; flex: 1; max-width: 300px;">
        <i class="fas fa-search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #9CA3AF;"></i>
        <input type="text" placeholder="Cari" style="width: 100%; padding: 10px 15px 10px 40px; border-radius: 10px; border: 1px solid #E5E7EB; outline: none;">
    </div>
    <select style="padding: 10px 20px; border-radius: 10px; border: 1px solid #E5E7EB; color: #6B7280; background: white; outline: none;">
        <option value="">---Status Gaji---</option>
        <option value="Sudah">Sudah</option>
        <option value="Belum">Belum</option>
    </select>
</div>

{{-- Table Area --}}
<div style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border: 1px solid #E5E7EB;">
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 13px;">
            <thead>
                <tr style="background: #F3E8FF; color: #111827;">
                    <th style="padding: 15px; text-align: center;">No</th>
                    <th style="padding: 15px;">ID</th>
                    <th style="padding: 15px;">Nama Lengkap</th>
                    <th style="padding: 15px;">Alamat</th>
                    <th style="padding: 15px;">No HP</th>
                    <th style="padding: 15px;">Mapel</th>
                    <th style="padding: 15px; text-align: center;">Grade</th>
                    <th style="padding: 15px;">HR SD</th>
                    <th style="padding: 15px;">HR SMP</th>
                    <th style="padding: 15px;">HR SMA</th>
                    <th style="padding: 15px;">Uang Makan</th>
                    <th style="padding: 15px;">Transport</th>
                    <th style="padding: 15px;">Status Gaji</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $tentors = [
                        ['id' => 'TE0001', 'nama' => 'Rati Maria', 'alamat' => 'xxxxxxxxxxxxx', 'hp' => '0881999999', 'mapel' => 'xxxxxxxxxx', 'grade' => 'A', 'sd' => '50.000', 'smp' => '50.000', 'sma' => '50.000', 'makan' => '10.000', 'trans' => '-', 'status' => 'Sudah'],
                        ['id' => 'TE0002', 'nama' => 'Dwi Rahayu', 'alamat' => 'xxxxxxxxxxxxx', 'hp' => '0881999999', 'mapel' => 'xxxxxxxxxx', 'grade' => 'A', 'sd' => '50.000', 'smp' => '50.000', 'sma' => '50.000', 'makan' => '-', 'trans' => '-', 'status' => 'Sudah'],
                        ['id' => 'TE0003', 'nama' => 'Rahma Tyas', 'alamat' => 'xxxxxxxxxxxxx', 'hp' => '0881999999', 'mapel' => 'xxxxxxxxxx', 'grade' => 'B', 'sd' => '40.000', 'smp' => '40.000', 'sma' => '40.000', 'makan' => '-', 'trans' => '10.000', 'status' => 'Belum'],
                        ['id' => 'TE0004', 'nama' => 'Sinta Putri', 'alamat' => 'xxxxxxxxxxxxx', 'hp' => '0881999999', 'mapel' => 'xxxxxxxxxx', 'grade' => 'B', 'sd' => '40.000', 'smp' => '40.000', 'sma' => '40.000', 'makan' => '10.000', 'trans' => '10.000', 'status' => 'Belum'],
                    ];
                @endphp

                @foreach($tentors as $index => $t)
                <tr style="border-bottom: 1px solid #F3F4F6; transition: 0.3s;" onmouseover="this.style.backgroundColor='#F9FAFB'" onmouseout="this.style.backgroundColor='transparent'">
                    <td style="padding: 15px; text-align: center; color: #6B7280;">{{ $index + 1 }}</td>
                    <td style="padding: 15px; font-weight: 600;">{{ $t['id'] }}</td>
                    <td style="padding: 15px;">{{ $t['nama'] }}</td>
                    <td style="padding: 15px; color: #6B7280;">{{ $t['alamat'] }}</td>
                    <td style="padding: 15px;">{{ $t['hp'] }}</td>
                    <td style="padding: 15px; color: #6B7280;">{{ $t['mapel'] }}</td>
                    <td style="padding: 15px; text-align: center;"><span style="background: #EEF2FF; color: #4F46E5; padding: 4px 10px; border-radius: 6px; font-weight: 700;">{{ $t['grade'] }}</span></td>
                    <td style="padding: 15px;">{{ $t['sd'] }}</td>
                    <td style="padding: 15px;">{{ $t['smp'] }}</td>
                    <td style="padding: 15px;">{{ $t['sma'] }}</td>
                    <td style="padding: 15px;">{{ $t['makan'] }}</td>
                    <td style="padding: 15px;">{{ $t['trans'] }}</td>
                    <td style="padding: 15px;">
                        <span style="color: {{ $t['status'] == 'Sudah' ? '#059669' : '#DC2626' }}; font-weight: 600;">
                            {{ $t['status'] }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Pagination Area --}}
<div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px;">
    <div style="color: #6B7280; font-size: 13px;">
        <select style="padding: 5px; border-radius: 5px; border: 1px solid #E5E7EB;">
            <option>10 baris</option>
        </select>
    </div>
    <div style="display: flex; gap: 5px;">
        <button style="padding: 5px 10px; border-radius: 5px; border: 1px solid #E5E7EB; background: #F3F4F6; cursor: pointer;"><i class="fas fa-chevron-left"></i></button>
        <button style="padding: 5px 12px; border-radius: 5px; border: none; background: #5D10A2; color: white; cursor: pointer;">1</button>
        <button style="padding: 5px 10px; border-radius: 5px; border: 1px solid #E5E7EB; background: #F3F4F6; cursor: pointer;"><i class="fas fa-chevron-right"></i></button>
    </div>
</div>
@endsection