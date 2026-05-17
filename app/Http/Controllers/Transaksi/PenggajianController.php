<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pegawai;
use App\Models\Mengajar;
use App\Models\TransaksiUmum;
use App\Models\Periode;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class PenggajianController extends Controller
{
    public function index(Request $request)
    {
        $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        $perPage = $request->get('per_page', 10);
        $bulan = $request->get('bulan', now()->month);
        $tahun = $request->get('tahun', now()->year);
        
        $today = Carbon::now();
        $lastDayOfMonth = $today->copy()->endOfMonth()->day;
        $currentDay = $today->day;
        $isAkhirBulan = ($currentDay >= $lastDayOfMonth - 3);
        
        $tentors = Pegawai::with('user')
            ->where('jenis_pegawai', 'tentor')
            ->get();
        
        $penggajian = collect();
        
        foreach ($tentors as $tentor) {
            $presensi = Mengajar::with('kelas')
                ->where('id_pegawai', $tentor->id_pegawai)
                ->whereMonth('tanggal', $bulan)
                ->whereYear('tanggal', $tahun)
                ->get();
            
            if ($presensi->count() == 0) continue;
            
            $jumlahSesi = $presensi->count();
            $hariUnik = $presensi->pluck('tanggal')->unique()->count();
            $hariHadir = $presensi->where('murid_hadir', 'Hadir')->pluck('tanggal')->unique()->count();
            
            $totalHonor = 0;
            foreach ($presensi as $p) {
                $jenjang = $p->kelas->jenjang ?? null;
                $hr = 0;
                if ($jenjang == 'SD') $hr = $tentor->hr_sd ?? 0;
                elseif ($jenjang == 'SMP') $hr = $tentor->hr_smp ?? 0;
                elseif ($jenjang == 'SMA') $hr = $tentor->hr_sma ?? 0;
                
                if ($p->murid_hadir == 'Hadir') {
                    $totalHonor += $hr;
                } else {
                    $totalHonor += ($hr / 2);
                }
            }
            
            $daftarTanggalStr = $presensi->pluck('tanggal')
                ->map(function($t) { return Carbon::parse($t)->format('d/m'); })
                ->unique()
                ->implode(', ');
            
            $uangMakanPerHari = $tentor->uang_makan ?? 0;
            $uangTransportPerHari = $tentor->uang_transport ?? 0;
            
            $totalUangMakan = $hariUnik * $uangMakanPerHari;
            $totalUangTransport = $hariUnik * $uangTransportPerHari;
            
            $totalGaji = $totalHonor + $totalUangMakan + $totalUangTransport;
            
            $sudahDibayar = TransaksiUmum::where('id_pegawai', $tentor->id_pegawai)
                ->where('kredit', '>', 0)
                ->where('keterangan', 'like', "%Gaji " . Carbon::create()->month($bulan)->translatedFormat('F') . " " . $tahun . "%")
                ->exists();
            
            $penggajian->push((object)[
                'id_pegawai' => $tentor->id_pegawai,
                'nama' => $tentor->nama_lengkap,
                'mapel' => $tentor->mapel ?? '-',
                'grade' => $tentor->grade ?? '-',
                'jumlah_sesi' => $jumlahSesi,
                'hari_hadir' => $hariHadir,
                'hari_unik' => $hariUnik,
                'daftar_tanggal' => $daftarTanggalStr,
                'total_honor' => $totalHonor,
                'uang_makan_per_hari' => $uangMakanPerHari,
                'uang_makan' => $totalUangMakan,
                'uang_transport_per_hari' => $uangTransportPerHari,
                'uang_transport' => $totalUangTransport,
                'total_gaji' => $totalGaji,
                'status' => $sudahDibayar ? 'Sudah Dibayar' : 'Belum Dibayar',
                'sudah_dibayar' => $sudahDibayar,
            ]);
        }
        
        $total = $penggajian->count();
        $currentPage = $request->get('page', 1);
        $penggajian = new \Illuminate\Pagination\LengthAwarePaginator(
            $penggajian->forPage($currentPage, $perPage),
            $total, $perPage, $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );
        
        $periodeList = Periode::orderBy('tahun_periode', 'desc')->get();
        
        $today = date('Y-m-d');
        $periodeAktif = Periode::where('tanggal_mulai', '<=', $today)
            ->where('tanggal_selesai', '>=', $today)
            ->first();
        
        return view('dashboard.shared.transaksi.penggajian', compact('role', 'penggajian', 'bulan', 'tahun', 'isAkhirBulan', 'periodeList', 'periodeAktif'));
    }

    public function bayar(Request $request, $hashId)
    {
        try {
            $id = unhash_id($hashId);
            if (!$id) {
                return response()->json(['success' => false, 'message' => 'Data tidak valid'], 404);
            }
            
            $tentor = Pegawai::findOrFail($id);
            $bulan = $request->bulan;
            $tahun = $request->tahun;
            $totalGaji = $request->total_gaji;
            $jumlahSesi = $request->jumlah_sesi;
            
            $today = date('Y-m-d');
            $periodeAktif = Periode::where('tanggal_mulai', '<=', $today)
                ->where('tanggal_selesai', '>=', $today)
                ->first();
            
            if (!$periodeAktif) {
                return response()->json(['success' => false, 'message' => 'Tidak ada periode aktif!']);
            }
            
            $namaBulan = Carbon::create()->month($bulan)->translatedFormat('F');
            
            TransaksiUmum::create([
                'id_periode' => (int) $periodeAktif->id_periode,
                'id_murid' => null,
                'id_pegawai' => $tentor->id_pegawai,
                'tanggal_bayar' => $today,
                'bulan' => (int) $bulan,
                'jenis_pembayaran' => 'Transfer',
                'keterangan' => "Gaji " . $namaBulan . " " . $tahun . " - " . $tentor->nama_lengkap . " ({$jumlahSesi} sesi)",
                'debit' => 0,
                'kredit' => (int) $totalGaji,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            return response()->json(['success' => true, 'message' => 'Gaji berhasil dibayarkan']);
            
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    public function detail(Request $request, $hashId)
    {
        Carbon::setLocale('id');
        
        $id = unhash_id($hashId);
        if (!$id) {
            abort(404, 'Data tidak ditemukan');
        }
        
        $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        $bulan = $request->get('bulan', now()->month);
        $tahun = $request->get('tahun', now()->year);
        
        $tentor = Pegawai::findOrFail($id);
        
        $presensi = Mengajar::with('kelas')
            ->where('id_pegawai', $tentor->id_pegawai)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->orderBy('tanggal', 'asc')
            ->get();
        
        $detailPresensi = collect();
        $totalHonor = 0;
        
        $hariUnik = $presensi->pluck('tanggal')->unique()->count();
        $uangMakanPerHari = $tentor->uang_makan ?? 0;
        $uangTransportPerHari = $tentor->uang_transport ?? 0;
        
        foreach ($presensi as $p) {
            $jenjang = $p->kelas->jenjang ?? null;
            $hr = 0;
            if ($jenjang == 'SD') $hr = $tentor->hr_sd ?? 0;
            elseif ($jenjang == 'SMP') $hr = $tentor->hr_smp ?? 0;
            elseif ($jenjang == 'SMA') $hr = $tentor->hr_sma ?? 0;
            
            $honorHarian = $hr;
            $statusText = 'Hadir';
            
            if ($p->murid_hadir == 'Tidak Hadir') {
                $honorHarian = $hr / 2;
                $statusText = 'Tidak Hadir';
            }
            
            $hariIndonesia = Carbon::parse($p->tanggal)->locale('id')->translatedFormat('l');
            
            $detailPresensi->push((object)[
                'tanggal' => Carbon::parse($p->tanggal)->format('d/m/Y'),
                'hari' => $hariIndonesia,
                'kelas' => $p->kelas->nama_kelas ?? '-',
                'status' => $statusText,
                'honor' => $honorHarian,
            ]);
            
            $totalHonor += $honorHarian;
        }
        
        $jumlahSesi = $presensi->count();
        
        $totalUangMakan = $hariUnik * $uangMakanPerHari;
        $totalUangTransport = $hariUnik * $uangTransportPerHari;
        
        $totalGaji = $totalHonor + $totalUangMakan + $totalUangTransport;
        
        $sudahDibayar = TransaksiUmum::where('id_pegawai', $tentor->id_pegawai)
            ->where('kredit', '>', 0)
            ->where('keterangan', 'like', "%Gaji " . Carbon::create()->month($bulan)->translatedFormat('F') . " " . $tahun . "%")
            ->exists();
        
        $data = [
            'role' => $role,
            'tentor' => $tentor,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'namaBulan' => Carbon::create()->month($bulan)->translatedFormat('F'),
            'jumlahSesi' => $jumlahSesi,
            'hariUnik' => $hariUnik,
            'detailPresensi' => $detailPresensi,
            'totalHonor' => $totalHonor,
            'uangMakanPerHari' => $uangMakanPerHari,
            'totalUangMakan' => $totalUangMakan,
            'uangTransportPerHari' => $uangTransportPerHari,
            'totalUangTransport' => $totalUangTransport,
            'totalGaji' => $totalGaji,
            'sudahDibayar' => $sudahDibayar,
        ];
        
        return view('dashboard.shared.transaksi.detail-penggajian', $data);
    }

    public function slip(Request $request, $hashId)
    {
        $id = unhash_id($hashId);
        if (!$id) {
            abort(404, 'Data tidak ditemukan');
        }
        
        $bulan = $request->get('bulan', now()->month);
        $tahun = $request->get('tahun', now()->year);
        
        $tentor = Pegawai::findOrFail($id);
        
        $presensi = Mengajar::with('kelas', 'ruang')
            ->where('id_pegawai', $tentor->id_pegawai)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->orderBy('tanggal', 'asc')
            ->get();
        
        $hariUnik = $presensi->pluck('tanggal')->unique()->count();
        
        $uangMakanPerHari = $tentor->uang_makan ?? 0;
        $uangTransportPerHari = $tentor->uang_transport ?? 0;
        
        $totalUangMakan = $hariUnik * $uangMakanPerHari;
        $totalUangTransport = $hariUnik * $uangTransportPerHari;
        
        $detailPresensi = collect();
        $totalHonor = 0;
        $no = 1;
        
        foreach ($presensi as $p) {
            $jenjang = $p->kelas->jenjang ?? null;
            $hr = 0;
            if ($jenjang == 'SD') $hr = $tentor->hr_sd ?? 0;
            elseif ($jenjang == 'SMP') $hr = $tentor->hr_smp ?? 0;
            elseif ($jenjang == 'SMA') $hr = $tentor->hr_sma ?? 0;
            
            $kehadiranMurid = $p->murid_hadir ?? 'Tidak Hadir';
            $honorHarian = $hr;
            $keterangan = '';
            
            if ($kehadiranMurid == 'Tidak Hadir') {
                $honorHarian = $hr / 2;
                $keterangan = 'SISWA ABSEN (50%)';
            }
            
            $totalPerSesi = $honorHarian;
            
            $namaKelas = $p->kelas ? ($p->kelas->jenjang . ' - ' . $p->kelas->nama_kelas) : '-';
            $namaRuang = $p->ruang->nama_ruang ?? '-';
            
            $detailPresensi->push((object)[
                'no' => $no++,
                'tanggal' => Carbon::parse($p->tanggal)->format('d/m/Y'),
                'kelas' => $namaKelas,
                'ruang' => $namaRuang,
                'kehadiran_murid' => $kehadiranMurid,
                'honor' => $honorHarian,
                'uang_makan' => 0,
                'uang_transport' => 0,
                'total_hr' => $totalPerSesi,
                'keterangan' => $keterangan,
            ]);
            
            $totalHonor += $honorHarian;
        }
        
        $totalGaji = $totalHonor + $totalUangMakan + $totalUangTransport;
        $namaBulan = Carbon::create()->month($bulan)->translatedFormat('F');
        
        $data = [
            'tentor' => $tentor,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'namaBulan' => $namaBulan,
            'detailPresensi' => $detailPresensi,
            'totalHonor' => $totalHonor,
            'hariUnik' => $hariUnik,
            'uangMakanPerHari' => $uangMakanPerHari,
            'totalUangMakan' => $totalUangMakan,
            'uangTransportPerHari' => $uangTransportPerHari,
            'totalUangTransport' => $totalUangTransport,
            'totalGaji' => $totalGaji,
        ];
        
        $pdf = Pdf::loadView('dashboard.shared.transaksi.slip-gaji', $data);
        $pdf->setPaper('a4', 'portrait');
        
        $filename = 'Slip_Gaji_' . str_replace(' ', '_', $tentor->nama_lengkap) . '_' . $namaBulan . '_' . $tahun . '.pdf';
        
        return $pdf->download($filename);
    }
}