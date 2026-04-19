<?php

namespace App\Http\Controllers;

use App\Models\Mengajar;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class KelolaPresensiController extends Controller
{
    public function index(Request $request)
    {
        $role = auth()->user()->peran;
        
        // Query dengan relasi
        $query = Mengajar::with(['pegawai', 'kelas', 'ruang']);
        
        // Filter pencarian (nama tentor, kelas, ruang)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('pegawai', function($subQ) use ($search) {
                    $subQ->where('nama_lengkap', 'like', '%' . $search . '%');
                })
                ->orWhereHas('kelas', function($subQ) use ($search) {
                    $subQ->where('nama_kelas', 'like', '%' . $search . '%')
                         ->orWhere('jenjang', 'like', '%' . $search . '%');
                })
                ->orWhereHas('ruang', function($subQ) use ($search) {
                    $subQ->where('nama_ruang', 'like', '%' . $search . '%');
                });
            });
        }
        
        // Filter tentor
        if ($request->filled('tentor')) {
            $query->where('id_pegawai', $request->tentor);
        }
        
        // Filter bulan
        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal', $request->bulan);
        }
        
        // Filter tahun
        if ($request->filled('tahun')) {
            $query->whereYear('tanggal', $request->tahun);
        }
        
        $perPage = $request->get('perPage', 10);
        $presensi = $query->orderBy('tanggal', 'desc')
                          ->orderBy('jam_mulai', 'desc')
                          ->paginate($perPage)
                          ->appends($request->all());
        
        // Ambil daftar tahun dari data yang ada
        $tahunList = Mengajar::selectRaw('YEAR(tanggal) as tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');
        
        if ($tahunList->isEmpty()) {
            $tahunList = collect([date('Y')]);
        }
        
        // Ambil daftar tentor untuk filter
        $tentors = Pegawai::where('jenis_pegawai', 'tentor')->get();
        
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $search = $request->search;
        $tentorFilter = $request->tentor;
        
        return view('dashboard.shared.riwayat presensi.riwayat-presensi', compact(
            'presensi', 
            'role', 
            'tentors', 
            'bulan', 
            'tahun', 
            'search', 
            'tentorFilter',
            'tahunList'
        ));
    }
    
    public function verify($id)
    {
        try {
            $presensi = Mengajar::findOrFail($id);
            $presensi->update(['murid_hadir' => 'Hadir']);
            return redirect()->back()->with('success', '✅ Presensi berhasil diverifikasi!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', '❌ Gagal verifikasi: ' . $e->getMessage());
        }
    }
    
    public function unverify($id)
    {
        try {
            $presensi = Mengajar::findOrFail($id);
            $presensi->update(['murid_hadir' => 'Tidak Hadir']);
            return redirect()->back()->with('success', '✅ Verifikasi dibatalkan!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', '❌ Gagal: ' . $e->getMessage());
        }
    }
    
    public function destroy($id)
    {
        if (auth()->user()->peran != 'superadmin') {
            return redirect()->back()->with('error', '❌ Anda tidak memiliki izin untuk menghapus data!');
        }
        
        try {
            $presensi = Mengajar::findOrFail($id);
            
            // Hapus foto bukti jika ada
            if ($presensi->bukti_mengajar && Storage::exists('public/' . $presensi->bukti_mengajar)) {
                Storage::delete('public/' . $presensi->bukti_mengajar);
            }
            
            $namaTentor = $presensi->pegawai->nama_lengkap ?? 'Tentor';
            $tanggal = Carbon::parse($presensi->tanggal)->translatedFormat('d F Y');
            $presensi->delete();
            
            return redirect()->back()->with('success', "✅ Data presensi {$namaTentor} ({$tanggal}) berhasil dihapus!");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', '❌ Gagal hapus: ' . $e->getMessage());
        }
    }
    
    public function downloadFoto($id)
    {
        $presensi = Mengajar::findOrFail($id);
        
        if (!$presensi->bukti_mengajar) {
            return redirect()->back()->with('error', '❌ File foto tidak ditemukan!');
        }
        
        $filePath = 'public/' . $presensi->bukti_mengajar;
        
        if (!Storage::exists($filePath)) {
            return redirect()->back()->with('error', '❌ File foto tidak ditemukan di server!');
        }
        
        $namaTentor = $presensi->pegawai->nama_lengkap ?? 'tentor';
        $tanggal = Carbon::parse($presensi->tanggal)->format('Ymd');
        $filename = "bukti_mengajar_{$namaTentor}_{$tanggal}.jpg";
        
        return Storage::download($filePath, $filename);
    }
    
    public function show($id)
    {
        $presensi = Mengajar::with(['pegawai', 'kelas', 'ruang'])->findOrFail($id);
        $role = auth()->user()->peran;
        
        return view('dashboard.shared.riwayat presensi.detail-presensi', compact('presensi', 'role'));
    }
}