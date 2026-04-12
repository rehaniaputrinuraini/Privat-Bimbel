<?php

namespace App\Http\Controllers\Tentor;

use App\Http\Controllers\Controller;
use App\Models\PresensiTentor;
use App\Models\Tentor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class PresensiController extends Controller
{
    public function index()
    {
        $tentor = Tentor::where('id_user', Auth::id())->first();
        
        if (!$tentor) {
            return view('dashboard.tentor.presensi', [
                'presensiHariIni' => null,
                'error' => 'Data tentor tidak ditemukan'
            ]);
        }
        
        $presensiHariIni = PresensiTentor::where('id_tentor', $tentor->id_tentor)
                                        ->whereDate('tanggal', today())
                                        ->whereNull('jam_keluar')
                                        ->first();
        
        return view('dashboard.tentor.presensi', compact('presensiHariIni', 'tentor'));
    }

    public function masuk(Request $request)
    {
        try {
            $tentor = Tentor::where('id_user', Auth::id())->first();
            
            if (!$tentor) {
                return response()->json(['success' => false, 'message' => 'Data tentor tidak ditemukan'], 404);
            }
            
            $existing = PresensiTentor::where('id_tentor', $tentor->id_tentor)
                                      ->whereDate('tanggal', today())
                                      ->whereNull('jam_keluar')
                                      ->first();
            
            if ($existing) {
                return response()->json(['success' => false, 'message' => 'Anda sudah presensi masuk hari ini!'], 400);
            }
            
            $presensi = PresensiTentor::create([
                'id_tentor' => $tentor->id_tentor,
                'tanggal' => today(),
                'jam_masuk' => Carbon::now('Asia/Jakarta'),
                'jam_keluar' => null,
                'jam_mengajar' => null,
                'kelas' => null,
                'jenjang' => null,
                'status_murid' => null,
                'keterangan' => null,
                'bukti_foto' => null,
                'verifikasi_kehadiran' => false,
            ]);
            
            return response()->json(['success' => true, 'message' => '✅ Presensi masuk berhasil! Silakan isi laporan.']);
            
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal: ' . $e->getMessage()], 500);
        }
    }
    
    public function simpanLaporan(Request $request)
    {
        try {
            $request->validate([
                'kelas' => 'required|string|max:255',
                'jenjang' => 'required|in:SD,SMP,SMA',
                'status_murid' => 'required|in:hadir,tidak_hadir',
                'keterangan' => 'nullable|string',
                'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048'
            ]);
            
            $tentor = Tentor::where('id_user', Auth::id())->first();
            
            if (!$tentor) {
                return response()->json(['success' => false, 'message' => 'Data tentor tidak ditemukan'], 404);
            }
            
            $presensi = PresensiTentor::where('id_tentor', $tentor->id_tentor)
                                      ->whereDate('tanggal', today())
                                      ->whereNull('jam_keluar')
                                      ->first();
            
            if (!$presensi) {
                return response()->json(['success' => false, 'message' => 'Anda belum presensi masuk!'], 400);
            }
            
            $fotoPath = $request->file('foto')->store('bukti-presensi', 'public');
            
            $statusMurid = $request->status_murid;
            if ($statusMurid == 'tidak_hadir') {
                $statusMurid = 'tidak hadir';
            }
            
            $presensi->update([
                'kelas' => $request->kelas,
                'jenjang' => $request->jenjang,
                'status_murid' => $statusMurid,
                'keterangan' => $request->keterangan,
                'bukti_foto' => $fotoPath,
                'verifikasi_kehadiran' => false
            ]);
            
            return response()->json(['success' => true, 'message' => '✅ Laporan berhasil disimpan! Silakan presensi keluar.']);
            
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal: ' . $e->getMessage()], 500);
        }
    }
    
    public function keluar(Request $request)
    {
        try {
            $tentor = Tentor::where('id_user', Auth::id())->first();
            
            if (!$tentor) {
                return response()->json(['success' => false, 'message' => 'Data tentor tidak ditemukan'], 404);
            }
            
            $presensi = PresensiTentor::where('id_tentor', $tentor->id_tentor)
                                      ->whereDate('tanggal', today())
                                      ->whereNull('jam_keluar')
                                      ->first();
            
            if (!$presensi) {
                return response()->json(['success' => false, 'message' => 'Anda belum presensi masuk!'], 400);
            }
            
            if (!$presensi->kelas) {
                return response()->json(['success' => false, 'message' => 'Silakan isi laporan terlebih dahulu!'], 400);
            }
            
            $jamKeluar = Carbon::now('Asia/Jakarta');
            
            $presensi->update([
                'jam_keluar' => $jamKeluar,
                'jam_mengajar' => 1,
            ]);
            
            $jamMasuk = Carbon::parse($presensi->jam_masuk);
            $durasiMenit = $jamMasuk->diffInMinutes($jamKeluar);
            $jam = floor($durasiMenit / 60);
            $menit = $durasiMenit % 60;
            
            // TANPA MENAMPILKAN HONOR (RAHASIA UNTUK TENTOR)
            return response()->json([
                'success' => true, 
                'message' => "✅ Selesai! Durasi: {$jam} jam {$menit} menit."
            ]);
            
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal: ' . $e->getMessage()], 500);
        }
    }
    
    public function cekStatus()
    {
        $tentor = Tentor::where('id_user', Auth::id())->first();
        
        if (!$tentor) {
            return response()->json([
                'has_presensi_masuk' => false,
                'has_laporan' => false,
                'is_verified' => false
            ]);
        }
        
        $presensi = PresensiTentor::where('id_tentor', $tentor->id_tentor)
                                  ->whereDate('tanggal', today())
                                  ->whereNull('jam_keluar')
                                  ->first();
        
        return response()->json([
            'has_presensi_masuk' => $presensi ? true : false,
            'has_laporan' => $presensi && $presensi->kelas ? true : false,
            'is_verified' => $presensi && $presensi->verifikasi_kehadiran ? true : false,
            'data' => $presensi
        ]);
    }
    
    public function riwayat(Request $request)
    {
        $tentor = Tentor::where('id_user', Auth::id())->first();
        
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
        
        $bulan = $request->get('bulan', date('m'));
        $tahun = $request->get('tahun', date('Y'));
        $perPage = $request->get('perPage', 10);
        $search = $request->get('search');
        
        $query = PresensiTentor::where('id_tentor', $tentor->id_tentor);
        
        if ($bulan) {
            $query->whereMonth('tanggal', $bulan);
        }
        if ($tahun) {
            $query->whereYear('tanggal', $tahun);
        }
        if ($search) {
            $query->where('kelas', 'like', '%' . $search . '%');
        }
        
        $riwayat = $query->orderBy('tanggal', 'desc')->paginate($perPage)->appends($request->all());
        
        return view('dashboard.tentor.riwayat-presensi', compact('riwayat', 'bulan', 'tahun', 'perPage', 'search'));
    }
}