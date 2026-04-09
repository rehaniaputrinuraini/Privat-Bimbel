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
    /**
     * Tampilkan halaman presensi
     */
    public function index()
    {
        $tentor = Tentor::where('id_user', Auth::id())->first();
        
        if (!$tentor) {
            return view('dashboard.tentor.presensi', [
                'presensiHariIni' => null,
                'error' => 'Data tentor tidak ditemukan'
            ]);
        }
        
        // Cari presensi hari ini yang BELUM KELUAR
        $presensiHariIni = PresensiTentor::where('id_tentor', $tentor->id_tentor)
                                        ->whereDate('tanggal', today())
                                        ->whereNull('jam_keluar')
                                        ->first();
        
        return view('dashboard.tentor.presensi', compact('presensiHariIni', 'tentor'));
    }

    /**
     * Proses presensi masuk
     */
    public function masuk(Request $request)
    {
        try {
            $tentor = Tentor::where('id_user', Auth::id())->first();
            
            if (!$tentor) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data tentor tidak ditemukan'
                ], 404);
            }
            
            // Cek apakah sudah presensi hari ini dan BELUM KELUAR
            $existing = PresensiTentor::where('id_tentor', $tentor->id_tentor)
                                      ->whereDate('tanggal', today())
                                      ->whereNull('jam_keluar')
                                      ->first();
            
            if ($existing) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda sudah melakukan presensi masuk hari ini dan belum keluar!'
                ], 400);
            }
            
            // Buat presensi baru
            $presensi = PresensiTentor::create([
                'id_tentor' => $tentor->id_tentor,
                'tanggal' => today(),
                'jam_masuk' => Carbon::now('Asia/Jakarta'),
                'jam_keluar' => null,
                'durasi' => null,
                'kelas' => null,
                'status_murid' => null,
                'keterangan' => null,
                'uang_makan' => $tentor->uang_makan ?? 0,
                'transport' => $tentor->uang_transport ?? 0,
                'bukti_foto' => null,
                'verifikasi_kehadiran' => false,
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Presensi masuk berhasil! Silakan isi laporan kegiatan.',
                'data' => $presensi
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal presensi: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Simpan laporan kegiatan (foto WAJIB)
     */
    public function simpanLaporan(Request $request)
    {
        try {
            $request->validate([
                'kelas' => 'required|string|max:255',
                'status_murid' => 'required|in:hadir,tidak_hadir',
                'keterangan' => 'nullable|string',
                'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048'
            ]);
            
            $tentor = Tentor::where('id_user', Auth::id())->first();
            
            if (!$tentor) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data tentor tidak ditemukan'
                ], 404);
            }
            
            // Cari presensi hari ini yang BELUM KELUAR
            $presensi = PresensiTentor::where('id_tentor', $tentor->id_tentor)
                                      ->whereDate('tanggal', today())
                                      ->whereNull('jam_keluar')
                                      ->first();
            
            if (!$presensi) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda belum melakukan presensi masuk!'
                ], 400);
            }
            
            // Upload foto (WAJIB)
            $fotoPath = $request->file('foto')->store('bukti-presensi', 'public');
            
            // Update data laporan
            $presensi->update([
                'kelas' => $request->kelas,
                'jam_mengajar' => $request->jam_mengajar,
                'status_murid' => $request->status_murid,
                'keterangan' => $request->keterangan,
                'bukti_foto' => $fotoPath,
                'verifikasi_kehadiran' => false
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Laporan kegiatan berhasil disimpan! Menunggu verifikasi admin.'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan laporan: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Proses presensi keluar (hitung durasi otomatis)
     */
    public function keluar(Request $request)
    {
        try {
            $tentor = Tentor::where('id_user', Auth::id())->first();
            
            if (!$tentor) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data tentor tidak ditemukan'
                ], 404);
            }
            
            $presensi = PresensiTentor::where('id_tentor', $tentor->id_tentor)
                                      ->whereDate('tanggal', today())
                                      ->whereNull('jam_keluar')
                                      ->first();
            
            if (!$presensi) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda belum melakukan presensi masuk!'
                ], 400);
            }
            
            if (!$presensi->kelas) {
                return response()->json([
                    'success' => false,
                    'message' => 'Silakan isi laporan kegiatan terlebih dahulu!'
                ], 400);
            }
            
            // Hitung durasi dalam menit
            $jamMasuk = Carbon::parse($presensi->jam_masuk);
            $jamKeluar = Carbon::now();
            $durasiMenit = $jamMasuk->diffInMinutes($jamKeluar);
            
            $jam = floor($durasiMenit / 60);
            $menit = $durasiMenit % 60;
            $durasiText = $jam . ' jam ' . $menit . ' menit';
            
            $presensi->update([
                'jam_keluar' => Carbon::now('Asia/Jakarta'),
                'durasi' => $durasiMenit
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Sesi mengajar selesai! Durasi: ' . $durasiText
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Cek status presensi untuk UI
     */
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
        
        // Cek presensi yang BELUM KELUAR
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
    
    /**
     * Riwayat presensi tentor dengan filter bulan, tahun, dan search
     */
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
        
        // Ambil filter dari request
        $bulan = $request->get('bulan', date('m'));
        $tahun = $request->get('tahun', date('Y'));
        $perPage = $request->get('perPage', 10);
        $search = $request->get('search');
        
        // Query dasar
        $query = PresensiTentor::where('id_tentor', $tentor->id_tentor);
        
        // Filter bulan
        if ($bulan) {
            $query->whereMonth('tanggal', $bulan);
        }
        
        // Filter tahun
        if ($tahun) {
            $query->whereYear('tanggal', $tahun);
        }
        
        // Filter pencarian (kelas)
        if ($search) {
            $query->where('kelas', 'like', '%' . $search . '%');
        }
        
        // Urutkan dari tanggal terbaru
        $riwayat = $query->orderBy('tanggal', 'desc')
                         ->paginate($perPage)
                         ->appends($request->all());
        
        return view('dashboard.tentor.riwayat-presensi', compact('riwayat', 'bulan', 'tahun', 'perPage', 'search'));
    }
}