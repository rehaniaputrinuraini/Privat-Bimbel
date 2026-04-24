<?php

namespace App\Http\Controllers\Tentor;

use App\Http\Controllers\Controller;
use App\Models\Mengajar;
use App\Models\Pegawai;
use App\Models\Kelas;
use App\Models\Ruang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PresensiController extends Controller
{
    private function getTentorLogin()
    {
        $user = Auth::user();
        
        if (!$user) {
            return null;
        }
        
        return Pegawai::where('jenis_pegawai', 'tentor')
            ->where('id_pegawai', $user->id_pegawai)
            ->first();
    }

    private function generateIdMengajar()
    {
        $lastId = Mengajar::max('id_mengajar') ?? 0;
        return $lastId + 1;
    }

    public function index()
    {
        $tentor = $this->getTentorLogin();
        
        if (!$tentor) {
            return view('dashboard.tentor.presensi', [
                'presensiHariIni' => null,
                'tentor' => null,
                'kelasList' => [],
                'ruangList' => [],
                'error' => 'Data tentor tidak ditemukan'
            ]);
        }
        
        $presensiHariIni = Mengajar::where('id_pegawai', $tentor->id_pegawai)
            ->whereDate('tanggal', today())
            ->whereNull('jam_selesai')
            ->first();
        
        $kelasList = Kelas::orderBy('jenjang')->orderBy('nama_kelas')->get();
        $ruangList = Ruang::orderBy('nama_ruang')->get();
        
        return view('dashboard.tentor.presensi', compact(
            'presensiHariIni', 
            'tentor', 
            'kelasList', 
            'ruangList'
        ));
    }

    public function masuk()
    {
        try {
            $tentor = $this->getTentorLogin();
            
            if (!$tentor) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Data tentor tidak ditemukan'
                ], 404);
            }
            
            $existing = Mengajar::where('id_pegawai', $tentor->id_pegawai)
                ->whereDate('tanggal', today())
                ->whereNull('jam_selesai')
                ->first();
            
            if ($existing) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Anda sudah presensi masuk hari ini!'
                ], 400);
            }
            
            // ✅ AMBIL DEFAULT KELAS & RUANG
            $defaultKelas = Kelas::first();
            $defaultRuang = Ruang::first();
            
            DB::table('ms_mengajar')->insert([
                'id_mengajar' => $this->generateIdMengajar(),
                'id_pegawai' => $tentor->id_pegawai,
                'tanggal' => today(),
                'jam_mulai' => Carbon::now('Asia/Jakarta')->format('H:i:s'),
                'jam_selesai' => null,
                'lama_mengajar' => null,
                'id_kelas' => $defaultKelas ? $defaultKelas->id_kelas : 1,
                'id_ruang' => $defaultRuang ? $defaultRuang->id_ruang : 1,
                'murid_hadir' => null,
                'keterangan' => null,
                'bukti_mengajar' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            return response()->json([
                'success' => true, 
                'message' => '✅ Presensi masuk berhasil! Silakan isi laporan.'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false, 
                'message' => 'Gagal: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function simpanLaporan(Request $request)
    {
        try {
            // ✅ VALIDASI HANYA UNTUK LAPORAN
            $request->validate([
                'id_kelas' => 'required|exists:ms_kelas,id_kelas',
                'id_ruang' => 'required|exists:ms_ruang,id_ruang',
                'jenjang' => 'required|in:SD,SMP,SMA',
                'murid_hadir' => 'required|in:Hadir,Tidak Hadir',
                'keterangan' => 'nullable|string|max:30',
                'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048'
            ]);
            
            $tentor = $this->getTentorLogin();
            
            if (!$tentor) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Data tentor tidak ditemukan'
                ], 404);
            }
            
            $presensi = Mengajar::where('id_pegawai', $tentor->id_pegawai)
                ->whereDate('tanggal', today())
                ->whereNull('jam_selesai')
                ->first();
            
            if (!$presensi) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Anda belum presensi masuk!'
                ], 400);
            }
            
            // Upload foto
            $fotoPath = $request->file('foto')->store('bukti-mengajar', 'public');
            
            // UPDATE DATA
            DB::table('ms_mengajar')
                ->where('id_mengajar', $presensi->id_mengajar)
                ->update([
                    'id_kelas' => $request->id_kelas,
                    'id_ruang' => $request->id_ruang,
                    'murid_hadir' => $request->murid_hadir,
                    'keterangan' => $request->keterangan,
                    'bukti_mengajar' => $fotoPath,
                    'updated_at' => now(),
                ]);
            
            return response()->json([
                'success' => true, 
                'message' => '✅ Laporan berhasil disimpan! Silakan presensi keluar.'
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false, 
                'message' => 'Gagal: ' . implode(', ', $e->validator->errors()->all())
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false, 
                'message' => 'Gagal: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function keluar()
    {
        try {
            $tentor = $this->getTentorLogin();
            
            if (!$tentor) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Data tentor tidak ditemukan'
                ], 404);
            }
            
            $presensi = Mengajar::where('id_pegawai', $tentor->id_pegawai)
                ->whereDate('tanggal', today())
                ->whereNull('jam_selesai')
                ->first();
            
            if (!$presensi) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Anda belum presensi masuk!'
                ], 400);
            }
            
            if (!$presensi->bukti_mengajar) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Silakan isi laporan terlebih dahulu!'
                ], 400);
            }
            
            $jamKeluar = Carbon::now('Asia/Jakarta');
            $jamMulai = Carbon::parse($presensi->jam_mulai);
            $lamaMengajar = $jamMulai->diffInMinutes($jamKeluar);
            
            DB::table('ms_mengajar')
                ->where('id_mengajar', $presensi->id_mengajar)
                ->update([
                    'jam_selesai' => $jamKeluar->format('H:i:s'),
                    'lama_mengajar' => $lamaMengajar,
                    'updated_at' => now(),
                ]);
            
            $jam = floor($lamaMengajar / 60);
            $menit = $lamaMengajar % 60;
            
            return response()->json([
                'success' => true, 
                'message' => "✅ Selesai! Durasi: {$jam} jam {$menit} menit."
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false, 
                'message' => 'Gagal: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function cekStatus()
    {
        $tentor = $this->getTentorLogin();
        
        if (!$tentor) {
            return response()->json([
                'has_presensi_masuk' => false,
                'has_laporan' => false,
            ]);
        }
        
        $presensi = Mengajar::where('id_pegawai', $tentor->id_pegawai)
            ->whereDate('tanggal', today())
            ->whereNull('jam_selesai')
            ->first();
        
        return response()->json([
            'has_presensi_masuk' => $presensi ? true : false,
            'has_laporan' => $presensi && $presensi->bukti_mengajar ? true : false,
            'data' => $presensi
        ]);
    }
    
    public function riwayat(Request $request)
    {
        $tentor = $this->getTentorLogin();
        
        if (!$tentor) {
            return view('dashboard.tentor.riwayat-presensi', [
                'riwayat' => collect([]),
                'bulan' => date('m'),
                'tahun' => date('Y'),
                'perPage' => 10,
                'search' => null,
                'error' => 'Data tentor tidak ditemukan'
            ]);
        }
        
        $bulan = $request->get('bulan');
        $tahun = $request->get('tahun');
        $perPage = $request->get('perPage', 10);
        $search = $request->get('search');
        
        $query = Mengajar::with(['kelas', 'ruang'])
            ->where('id_pegawai', $tentor->id_pegawai);
        
        if ($bulan) {
            $query->whereMonth('tanggal', $bulan);
        }
        
        if ($tahun) {
            $query->whereYear('tanggal', $tahun);
        }
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->whereHas('kelas', function($subQ) use ($search) {
                    $subQ->where('nama_kelas', 'like', '%' . $search . '%')
                         ->orWhere('jenjang', 'like', '%' . $search . '%');
                })
                ->orWhereHas('ruang', function($subQ) use ($search) {
                    $subQ->where('nama_ruang', 'like', '%' . $search . '%');
                })
                ->orWhere('murid_hadir', 'like', '%' . $search . '%');
            });
        }
        
        $riwayat = $query->orderBy('tanggal', 'desc')
            ->orderBy('jam_mulai', 'desc')
            ->paginate($perPage)
            ->appends($request->all());
        
        return view('dashboard.tentor.riwayat-presensi', compact(
            'riwayat', 'bulan', 'tahun', 'perPage', 'search'
        ));
    }
}