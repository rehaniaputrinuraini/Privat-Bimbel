<?php

namespace App\Http\Controllers;

use App\Models\PresensiTentor;
use App\Models\Tentor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class KelolaPresensiController extends Controller
{
    /**
     * Menampilkan semua riwayat presensi tentor (untuk admin & superadmin)
     */
    public function index(Request $request)
    {
        $role = auth()->user()->peran; // 'admin' atau 'superadmin'
        
        // Query dengan relasi tentor
        $query = PresensiTentor::with('tentor');
        
        // Filter berdasarkan nama tentor (search)
        if ($request->filled('search')) {
            $query->whereHas('tentor', function($q) use ($request) {
                $q->where('nama_lengkap_tentor', 'like', '%' . $request->search . '%');
            });
        }
        
        // Filter berdasarkan bulan
        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal', $request->bulan);
        }
        
        // Filter berdasarkan tahun
        if ($request->filled('tahun')) {
            $query->whereYear('tanggal', $request->tahun);
        }
        
        // Urutkan dari terbaru
        $presensi = $query->orderBy('tanggal', 'desc')
                          ->orderBy('jam_masuk', 'desc')
                          ->paginate(10)
                          ->appends($request->all());
        
        // Data untuk filter (opsional)
        $tentors = Tentor::all();
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $search = $request->search;
        
        return view('dashboard.shared.riwayat presensi.riwayat-presensi', compact('presensi', 'role', 'tentors', 'bulan', 'tahun', 'search'));
    }
    
    /**
     * Verifikasi presensi (Admin & Superadmin)
     */
    public function verify($id)
    {
        try {
            $presensi = PresensiTentor::findOrFail($id);
            $presensi->update(['verifikasi_kehadiran' => true]);
            
            return redirect()->back()->with('success', '✅ Presensi berhasil diverifikasi!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', '❌ Gagal verifikasi: ' . $e->getMessage());
        }
    }
    
    /**
     * Batalkan verifikasi (Admin & Superadmin)
     */
    public function unverify($id)
    {
        try {
            $presensi = PresensiTentor::findOrFail($id);
            $presensi->update(['verifikasi_kehadiran' => false]);
            
            return redirect()->back()->with('success', '✅ Verifikasi dibatalkan!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', '❌ Gagal: ' . $e->getMessage());
        }
    }
    
    /**
     * Hapus presensi (HANYA UNTUK SUPERADMIN)
     */
    public function destroy($id)
    {
        // Cegah admin menghapus
        if (auth()->user()->peran != 'superadmin') {
            return redirect()->back()->with('error', '❌ Anda tidak memiliki izin untuk menghapus data!');
        }
        
        try {
            $presensi = PresensiTentor::findOrFail($id);
            
            // Hapus file foto jika ada
            if ($presensi->bukti_foto && Storage::exists('public/' . $presensi->bukti_foto)) {
                Storage::delete('public/' . $presensi->bukti_foto);
            }
            
            $namaTentor = $presensi->tentor->nama_lengkap_tentor ?? 'Tentor';
            $tanggal = Carbon::parse($presensi->tanggal)->translatedFormat('d F Y');
            
            $presensi->delete();
            
            return redirect()->back()->with('success', "✅ Data presensi {$namaTentor} ({$tanggal}) berhasil dihapus!");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', '❌ Gagal hapus: ' . $e->getMessage());
        }
    }
    
    /**
     * Download bukti foto (Admin & Superadmin)
     */
    public function downloadFoto($id)
    {
        $presensi = PresensiTentor::findOrFail($id);
        
        if (!$presensi->bukti_foto) {
            return redirect()->back()->with('error', '❌ File foto tidak ditemukan!');
        }
        
        $filePath = 'public/' . $presensi->bukti_foto;
        
        if (!Storage::exists($filePath)) {
            return redirect()->back()->with('error', '❌ File foto tidak ditemukan di server!');
        }
        
        $namaTentor = $presensi->tentor->nama_lengkap_tentor ?? 'tentor';
        $tanggal = Carbon::parse($presensi->tanggal)->format('Ymd');
        $filename = "bukti_presensi_{$namaTentor}_{$tanggal}.jpg";
        
        return Storage::download($filePath, $filename);
    }
    
    /**
     * Tampilkan detail presensi (opsional)
     */
    public function show($id)
    {
        $presensi = PresensiTentor::with('tentor')->findOrFail($id);
        $role = auth()->user()->peran;
        
        return view('dashboard.shared.riwayat presensi.detail-presensi', compact('presensi', 'role'));
    }
}