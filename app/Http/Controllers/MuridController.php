<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Murid;
use App\Models\Kelas;
use App\Models\HargaPaket;
use App\Models\Periode;
use App\Models\TransaksiKelas;
use App\Models\TransaksiPaket;
use Illuminate\Support\Facades\DB;

class MuridController extends Controller
{
    // Menampilkan semua data murid
    public function index(Request $request)
    {
        $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        $murids = Murid::orderBy('id_murid', 'asc')->get();
        
        return view('dashboard.shared.kelola-murid.kelola-murid', [
            'role' => $role,
            'murids' => $murids
        ]);
    }

    // Form tambah data
    public function create(Request $request)
    {
        $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        
        // Ambil kelas yang belum penuh (jumlah_murid < 10)
        $kelasList = Kelas::where('jumlah_murid', '<', 10)
            ->orderBy('jenjang', 'asc')
            ->orderBy('nama_kelas', 'asc')
            ->get();
            
        $paketList = HargaPaket::orderBy('id_paket', 'asc')->get();
        
        // Ambil periode aktif (tahun sekarang di antara tahun_mulai dan tahun_selesai)
        $tahunSekarang = date('Y');
        $periodeAktif = Periode::where('tahun_mulai', '<=', $tahunSekarang)
            ->where('tahun_selesai', '>=', $tahunSekarang)
            ->first();
        
        // Kalau tidak ada periode, ambil periode terakhir
        if (!$periodeAktif) {
            $periodeAktif = Periode::orderBy('id_periode', 'desc')->first();
        }
        
        return view('dashboard.shared.kelola-murid.create-murid', [
            'role' => $role,
            'kelasList' => $kelasList,
            'paketList' => $paketList,
            'periodeAktif' => $periodeAktif
        ]);
    }

    // Simpan data
    public function store(Request $request)
    {
        $request->validate([
            // Data Murid
            'nama_lengkap' => 'required|string|max:35',
            'asal_sekolah' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:100',
            'no_hp' => 'nullable|string|max:15',
            'nama_orang_tua' => 'nullable|string|max:35',
            'no_hp_orang_tua' => 'nullable|string|max:15',
            'tahun_masuk' => 'nullable|integer|min:1900|max:' . date('Y'),
            
            // Data Transaksi
            'id_kelas' => 'required|exists:ms_kelas,id_kelas',
            'id_paket' => 'required|exists:ms_paket,id_paket',
            'id_periode' => 'required|exists:ms_periode,id_periode',
        ]);

        DB::beginTransaction();
        
        try {
            // 1. Insert ke ms_murid
            $dataMurid = $request->only([
                'nama_lengkap',
                'asal_sekolah',
                'alamat',
                'no_hp',
                'nama_orang_tua',
                'no_hp_orang_tua',
                'tahun_masuk',
            ]);
            
            $dataMurid['tanggal_daftar'] = date('Y-m-d');
            
            $murid = Murid::create($dataMurid);
            
            // 2. Insert ke tr_kelas (hanya id_kelas dan id_murid)
            TransaksiKelas::create([
                'id_kelas' => $request->id_kelas,
                'id_murid' => $murid->id_murid,
            ]);
            
            // 3. Insert ke tr_paket (sesuai struktur tabel kamu)
            // Ambil harga paket untuk biaya_pendaftaran
            $paket = HargaPaket::find($request->id_paket);
            
            TransaksiPaket::create([
                'id_periode' => $request->id_periode,
                'id_murid' => $murid->id_murid,
                'id_paket' => $request->id_paket,
                'paket_awal' => 1,  // 1 = true (paket pertama)
                'biaya_pendaftaran' => $paket ? $paket->harga : 100000,
            ]);
            
            // 4. Tambah jumlah_murid di ms_kelas
            $kelas = Kelas::find($request->id_kelas);
            if ($kelas) {
                $kelas->increment('jumlah_murid');
            }
            
            DB::commit();
            
            $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
            
            return redirect()->route($role . '.kelola-murid')
                ->with('success', 'Data murid berhasil ditambahkan beserta kelas dan paket');
                
        } catch (\Exception $e) {
            DB::rollback();
            
            return back()->withInput()
                ->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    // Form edit data
    public function edit(Request $request, $id)
    {
        $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        $murid = Murid::findOrFail($id);
        
        $paketList = HargaPaket::orderBy('id_paket', 'asc')->get();
        
        return view('dashboard.shared.kelola-murid.edit-murid', [
            'role' => $role,
            'murid' => $murid,
            'paketList' => $paketList
        ]);
    }

    // Update data
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:35',
            'asal_sekolah' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:100',
            'no_hp' => 'nullable|string|max:15',
            'nama_orang_tua' => 'nullable|string|max:35',
            'no_hp_orang_tua' => 'nullable|string|max:15',
            'tahun_masuk' => 'nullable|integer|min:1900|max:' . date('Y'),
        ]);

        $murid = Murid::findOrFail($id);
        
        $dataMurid = $request->only([
            'nama_lengkap',
            'asal_sekolah',
            'alamat',
            'no_hp',
            'nama_orang_tua',
            'no_hp_orang_tua',
            'tahun_masuk',
        ]);
        
        $murid->update($dataMurid);

        $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        
        return redirect()->route($role . '.kelola-murid')
            ->with('success', 'Data murid berhasil diperbarui');
    }

    // Hapus data
    public function destroy($id)
    {
        DB::beginTransaction();
        
        try {
            $murid = Murid::findOrFail($id);
            
            // Kembalikan jumlah_murid di kelas (ambil dari tr_kelas terbaru)
            $kelasTerbaru = TransaksiKelas::where('id_murid', $id)
                ->orderBy('created_at', 'desc')
                ->first();
                
            if ($kelasTerbaru) {
                $kelas = Kelas::find($kelasTerbaru->id_kelas);
                if ($kelas && $kelas->jumlah_murid > 0) {
                    $kelas->decrement('jumlah_murid');
                }
            }
            
            // Hapus transaksi terkait
            TransaksiKelas::where('id_murid', $id)->delete();
            TransaksiPaket::where('id_murid', $id)->delete();
            
            // Hapus murid
            $murid->delete();
            
            DB::commit();
            
            $referer = request()->headers->get('referer');
            $role = str_contains($referer, 'superadmin') ? 'superadmin' : 'admin';
            
            return redirect()->route($role . '.kelola-murid')
                ->with('success', 'Data murid berhasil dihapus');
                
        } catch (\Exception $e) {
            DB::rollback();
            
            return back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    // Search murid
    public function search(Request $request)
    {
        $query = $request->get('q');
        
        if (strlen($query) < 2) {
            return response()->json([]);
        }
        
        $murids = Murid::where('nama_lengkap', 'like', "%{$query}%")
            ->limit(10)
            ->get(['id_murid', 'nama_lengkap', 'asal_sekolah', 'no_hp']);
        
        return response()->json($murids);
    }
}