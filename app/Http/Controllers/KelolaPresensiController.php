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
        
        $query = Mengajar::with(['pegawai', 'kelas', 'ruang']);
        
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
        
        if ($request->filled('tentor')) {
            $query->where('id_pegawai', $request->tentor);
        }
        
        if ($request->filled('bulan') && $request->bulan !== '') {
            $query->whereMonth('tanggal', $request->bulan);
        }
        
        if ($request->filled('tahun') && $request->tahun !== '') {
            $query->whereYear('tanggal', $request->tahun);
        }
        
        $perPage = $request->get('perPage', 10);
        $presensi = $query->orderBy('tanggal', 'desc')
                          ->orderBy('jam_mulai', 'desc')
                          ->paginate($perPage)
                          ->appends($request->all());
        
        $sesiPertamaIds = [];
        foreach ($presensi as $item) {
            $tanggal = $item->tanggal;
            $idPegawai = $item->id_pegawai;
            
            $sesiPertama = Mengajar::where('id_pegawai', $idPegawai)
                ->whereDate('tanggal', $tanggal)
                ->orderBy('jam_mulai', 'asc')
                ->first();
            
            if ($sesiPertama && $sesiPertama->id_mengajar == $item->id_mengajar) {
                $sesiPertamaIds[] = $item->id_mengajar;
            }
        }
        $sesiPertamaIds = array_unique($sesiPertamaIds);
        
        $tahunList = Mengajar::selectRaw('YEAR(tanggal) as tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun')
            ->toArray();
        
        if (empty($tahunList)) {
            $tahunList = [date('Y')];
        }
        
        $tentors = Pegawai::where('jenis_pegawai', 'tentor')->get();
        
        $verifiedIds = session('verified_presensi', []);
        
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
            'tahunList',
            'verifiedIds',
            'sesiPertamaIds'
        ));
    }
    
    public function verify($hashId)
    {
        try {
            $id = unhash_id($hashId);
            if (!$id) {
                return redirect()->back()->with('error', 'Data tidak valid');
            }
            
            $verifiedIds = session('verified_presensi', []);
            if (!in_array($id, $verifiedIds)) {
                $verifiedIds[] = $id;
                session(['verified_presensi' => $verifiedIds]);
            }
            
            return redirect()->back()->with('success', '✅ Presensi berhasil diverifikasi!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', '❌ Gagal verifikasi: ' . $e->getMessage());
        }
    }
    
    public function unverify($hashId)
    {
        try {
            $id = unhash_id($hashId);
            if (!$id) {
                return redirect()->back()->with('error', 'Data tidak valid');
            }
            
            $verifiedIds = session('verified_presensi', []);
            $verifiedIds = array_diff($verifiedIds, [$id]);
            session(['verified_presensi' => $verifiedIds]);
            
            return redirect()->back()->with('success', '✅ Verifikasi dibatalkan!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', '❌ Gagal: ' . $e->getMessage());
        }
    }
    
    public function destroy($hashId)
    {
        if (auth()->user()->peran != 'superadmin') {
            return redirect()->back()->with('error', '❌ Anda tidak memiliki izin untuk menghapus data!');
        }
        
        try {
            $id = unhash_id($hashId);
            if (!$id) {
                return redirect()->back()->with('error', 'Data tidak valid');
            }
            
            $presensi = Mengajar::findOrFail($id);
            
            if ($presensi->bukti_mengajar && Storage::exists('public/' . $presensi->bukti_mengajar)) {
                Storage::delete('public/' . $presensi->bukti_mengajar);
            }
            
            $namaTentor = $presensi->pegawai->nama_lengkap ?? 'Tentor';
            $tanggal = Carbon::parse($presensi->tanggal)->translatedFormat('d F Y');
            $presensi->delete();
            
            $verifiedIds = session('verified_presensi', []);
            $verifiedIds = array_diff($verifiedIds, [$id]);
            session(['verified_presensi' => $verifiedIds]);
            
            return redirect()->back()->with('success', "✅ Data presensi {$namaTentor} ({$tanggal}) berhasil dihapus!");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', '❌ Gagal hapus: ' . $e->getMessage());
        }
    }
    
    public function downloadFoto($hashId)
    {
        $id = unhash_id($hashId);
        if (!$id) {
            return redirect()->back()->with('error', 'Data tidak valid');
        }
        
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
    
    public function show($hashId)
    {
        $id = unhash_id($hashId);
        if (!$id) {
            abort(404, 'Data tidak ditemukan');
        }
        
        $presensi = Mengajar::with(['pegawai', 'kelas', 'ruang'])->findOrFail($id);
        $role = auth()->user()->peran;
        
        $verifiedIds = session('verified_presensi', []);
        $isVerified = in_array($id, $verifiedIds);
        
        return view('dashboard.shared.riwayat presensi.detail-presensi', compact('presensi', 'role', 'isVerified'));
    }
}