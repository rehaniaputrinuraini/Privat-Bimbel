<?php

namespace App\Http\Controllers\Tentor;

use App\Http\Controllers\Controller;
use App\Models\PresensiTentor;
use App\Models\Tentor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PresensiController extends Controller
{
    // Tampilkan halaman presensi
    public function index()
    {
        // Cari tentor berdasarkan user yang login
        $tentor = Tentor::where('id_user', Auth::id())->first();
        
        if (!$tentor) {
            // Jika tentor tidak ditemukan, kirim variabel kosong
            return view('dashboard.tentor.presensi', [
                'presensiHariIni' => null,
                'error' => 'Data tentor tidak ditemukan'
            ]);
        }
        
        // Cari presensi hari ini
        $presensiHariIni = PresensiTentor::where('id_tentor', $tentor->id_tentor)
                                        ->whereDate('tanggal', today())
                                        ->first();
        
        // Kirim data ke view
        return view('dashboard.tentor.presensi', compact('presensiHariIni', 'tentor'));
    }

    // Proses presensi masuk
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
            
            // Cek apakah sudah presensi hari ini
            $existing = PresensiTentor::where('id_tentor', $tentor->id_tentor)
                                      ->whereDate('tanggal', today())
                                      ->first();
            
            if ($existing) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda sudah melakukan presensi masuk hari ini!'
                ], 400);
            }
            
            // Buat presensi baru
            $presensi = PresensiTentor::create([
                'id_tentor' => $tentor->id_tentor,
                'tanggal' => today(),
                'jam_masuk' => now(),
                'jam_mengajar' => null,
                'kelas' => null,
                'status_murid' => null,
                'total_honor' => null,
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
    
    // Simpan laporan kegiatan
    public function simpanLaporan(Request $request)
    {
        try {
            $request->validate([
                'kelas' => 'required|string|max:255',
                'status_murid' => 'required|in:hadir,tidak_hadir',
                'jam_mengajar' => 'required|numeric|min:0.5|max:12',
                'foto' => 'nullable|image|max:2048'
            ]);
            
            $tentor = Tentor::where('id_user', Auth::id())->first();
            
            if (!$tentor) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data tentor tidak ditemukan'
                ], 404);
            }
            
            // Cari presensi hari ini
            $presensi = PresensiTentor::where('id_tentor', $tentor->id_tentor)
                                      ->whereDate('tanggal', today())
                                      ->first();
            
            if (!$presensi) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda belum melakukan presensi masuk!'
                ], 400);
            }
            
            // Hitung total honor berdasarkan grade dan jam mengajar
            $grade = $tentor->grade;
            $jamMengajar = $request->jam_mengajar;
            $honorPerJam = 0;
            
            // Tentukan honor per jam berdasarkan grade
            if ($grade == 'A') {
                $honorPerJam = 50000;
            } elseif ($grade == 'B') {
                $honorPerJam = 40000;
            } else {
                $honorPerJam = 35000;
            }
            
            $totalHonor = $honorPerJam * $jamMengajar;
            
            // Upload foto jika ada
            $fotoPath = null;
            if ($request->hasFile('foto')) {
                $fotoPath = $request->file('foto')->store('bukti-presensi', 'public');
            }
            
            // Update data laporan
            $presensi->update([
                'kelas' => $request->kelas,
                'status_murid' => $request->status_murid,
                'jam_mengajar' => $jamMengajar,
                'total_honor' => $totalHonor,
                'bukti_foto' => $fotoPath,
                'verifikasi_kehadiran' => false
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Laporan kegiatan berhasil disimpan! Menunggu verifikasi admin.',
                'data' => [
                    'total_honor' => 'Rp ' . number_format($totalHonor, 0, ',', '.'),
                    'jam_mengajar' => $jamMengajar . ' Jam'
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan laporan: ' . $e->getMessage()
            ], 500);
        }
    }
    
    // Proses presensi keluar
    public function keluar(Request $request)
    {
        try {
            $tentor = Tentor::where('id_user', Auth::id())->first();
            
            $presensi = PresensiTentor::where('id_tentor', $tentor->id_tentor)
                                      ->whereDate('tanggal', today())
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
            
            return response()->json([
                'success' => true,
                'message' => 'Sesi mengajar selesai. Terima kasih!'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal: ' . $e->getMessage()
            ], 500);
        }
    }
    
    // Cek status presensi
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
                                  ->first();
        
        return response()->json([
            'has_presensi_masuk' => $presensi ? true : false,
            'has_laporan' => $presensi && $presensi->kelas ? true : false,
            'is_verified' => $presensi && $presensi->verifikasi_kehadiran ? true : false,
            'data' => $presensi
        ]);
    }
    
    // Riwayat presensi
    public function riwayat()
    {
        $tentor = Tentor::where('id_user', Auth::id())->first();
        
        if (!$tentor) {
            return view('dashboard.tentor.riwayat-presensi', [
                'riwayat' => collect([]),
                'error' => 'Data tentor tidak ditemukan'
            ]);
        }
        
        $riwayat = PresensiTentor::where('id_tentor', $tentor->id_tentor)
                                 ->orderBy('tanggal', 'desc')
                                 ->paginate(10);
        
        return view('dashboard.tentor.riwayat-presensi', compact('riwayat'));
    }
} ?><?php /**PATH C:\xampp\htdocs\privat-bimbel\resources\views/dashboard/tentor/presensi.blade.php ENDPATH**/ ?>