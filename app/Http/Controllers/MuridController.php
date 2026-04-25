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
use Illuminate\Support\Facades\Validator;

class MuridController extends Controller
{
    /**
     * Menampilkan halaman daftar murid
     */
    public function index(Request $request)
    {
        // Deteksi role berdasarkan URL
        $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        
        // Ambil semua data murid
        $murids = Murid::orderBy('id_murid', 'asc')->get();
        
        // Kumpulkan daftar paket yang digunakan
        $paketList = [];
        foreach($murids as $m) {
            $paket = $m->transaksiPaket()->orderBy('id_paket_murid', 'desc')->first();
            if($paket && $paket->paket) {
                $paketList[$paket->paket->tingkat] = $paket->paket->tingkat;
            }
        }
        sort($paketList);
        
        return view('dashboard.shared.kelola-murid.kelola-murid', [
            'role' => $role,
            'murids' => $murids,
            'paketList' => $paketList,
        ]);
    }

    /**
     * Menampilkan form tambah murid (via AJAX)
     */
    public function create(Request $request)
    {
        // Deteksi role berdasarkan URL
        $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        
        // Ambil data kelas yang masih tersedia (maks 10 murid per kelas)
        $kelasList = Kelas::where('jumlah_murid', '<', 10)
            ->orderBy('jenjang', 'asc')
            ->orderBy('nama_kelas', 'asc')
            ->get();
            
        // Ambil semua data paket
        $paketList = HargaPaket::orderBy('id_paket', 'asc')->get();
        
        // Cari periode aktif berdasarkan tanggal hari ini
        $today = date('Y-m-d');
        $periodeAktif = Periode::where('tanggal_mulai', '<=', $today)
            ->where('tanggal_selesai', '>=', $today)
            ->first();
            
        // Jika tidak ada periode aktif, ambil periode terakhir
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

    /**
     * Menyimpan data murid baru
     */
    public function store(Request $request)
    {
        // Deteksi role
        $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required|string|max:35',
            'asal_sekolah' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:100',
            'no_hp' => 'nullable|string|max:15',
            'nama_orang_tua' => 'nullable|string|max:35',
            'no_hp_orang_tua' => 'nullable|string|max:15',
            'tahun_masuk' => 'nullable|integer|min:2000|max:'.date('Y'),
            'id_kelas' => 'required|exists:ms_kelas,id_kelas',
            'id_paket' => 'required|exists:ms_paket,id_paket',
            'id_periode' => 'required|exists:ms_periode,id_periode',
        ], [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi',
            'nama_lengkap.max' => 'Nama lengkap maksimal 35 karakter',
            'asal_sekolah.max' => 'Asal sekolah maksimal 20 karakter',
            'alamat.max' => 'Alamat maksimal 100 karakter',
            'no_hp.max' => 'No HP maksimal 15 karakter',
            'nama_orang_tua.max' => 'Nama orang tua maksimal 35 karakter',
            'no_hp_orang_tua.max' => 'No HP orang tua maksimal 15 karakter',
            'tahun_masuk.integer' => 'Tahun masuk harus berupa angka',
            'tahun_masuk.min' => 'Tahun masuk minimal 2000',
            'tahun_masuk.max' => 'Tahun masuk maksimal tahun '.date('Y'),
            'id_kelas.required' => 'Kelas wajib dipilih',
            'id_kelas.exists' => 'Kelas tidak valid',
            'id_paket.required' => 'Paket wajib dipilih',
            'id_paket.exists' => 'Paket tidak valid',
            'id_periode.required' => 'Periode wajib dipilih',
            'id_periode.exists' => 'Periode tidak valid',
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();
        try {
            $tanggalDaftar = date('Y-m-d');
            
            // Siapkan data murid
            $dataMurid = [
                'nama_lengkap' => $request->nama_lengkap,
                'asal_sekolah' => $request->asal_sekolah,
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp,
                'nama_orang_tua' => $request->nama_orang_tua,
                'no_hp_orang_tua' => $request->no_hp_orang_tua,
                'tahun_masuk' => $request->tahun_masuk,
                'tanggal_daftar' => $tanggalDaftar,
            ];
            
            // Simpan data murid
            $murid = Murid::create($dataMurid);
            
            // Simpan ke transaksi kelas
            TransaksiKelas::create([
                'id_kelas' => $request->id_kelas,
                'id_murid' => $murid->id_murid
            ]);
            
            // Simpan ke transaksi paket
            TransaksiPaket::create([
                'id_periode' => $request->id_periode,
                'id_murid' => $murid->id_murid,
                'id_paket' => $request->id_paket,
                'tanggal_daftar' => $tanggalDaftar,
                'paket_awal' => 1,
                'biaya_pendaftaran' => 100000
            ]);
            
            // Update jumlah murid di kelas
            $kelas = Kelas::find($request->id_kelas);
            if ($kelas) {
                $kelas->increment('jumlah_murid');
            }
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Data murid berhasil disimpan'
            ]);
            
        } catch (\Exception $e) {
            DB::rollback();
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Menampilkan form edit murid (via AJAX)
     */
    public function edit(Request $request, $id)
    {
        // Deteksi role berdasarkan URL
        $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        
        // Cari data murid berdasarkan ID
        $murid = Murid::findOrFail($id);
        
        return view('dashboard.shared.kelola-murid.edit-murid', [
            'role' => $role,
            'murid' => $murid
        ]);
    }

    /**
     * Mengupdate data murid
     */
    public function update(Request $request, $id)
    {
        // Deteksi role
        $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required|string|max:35',
            'asal_sekolah' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:100',
            'no_hp' => 'nullable|string|max:15',
            'nama_orang_tua' => 'nullable|string|max:35',
            'no_hp_orang_tua' => 'nullable|string|max:15',
            'tahun_masuk' => 'nullable|integer|min:2000|max:'.date('Y'),
        ], [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi',
            'nama_lengkap.max' => 'Nama lengkap maksimal 35 karakter',
            'asal_sekolah.max' => 'Asal sekolah maksimal 20 karakter',
            'alamat.max' => 'Alamat maksimal 100 karakter',
            'no_hp.max' => 'No HP maksimal 15 karakter',
            'nama_orang_tua.max' => 'Nama orang tua maksimal 35 karakter',
            'no_hp_orang_tua.max' => 'No HP orang tua maksimal 15 karakter',
            'tahun_masuk.integer' => 'Tahun masuk harus berupa angka',
            'tahun_masuk.min' => 'Tahun masuk minimal 2000',
            'tahun_masuk.max' => 'Tahun masuk maksimal tahun '.date('Y'),
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Cari murid berdasarkan ID
            $murid = Murid::findOrFail($id);
            
            // Update data murid
            $murid->update([
                'nama_lengkap' => $request->nama_lengkap,
                'asal_sekolah' => $request->asal_sekolah,
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp,
                'nama_orang_tua' => $request->nama_orang_tua,
                'no_hp_orang_tua' => $request->no_hp_orang_tua,
                'tahun_masuk' => $request->tahun_masuk,
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Data murid berhasil diupdate'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupdate data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Menghapus data murid
     */
    public function destroy($id)
    {
        // Deteksi role dari URL request
        $role = request()->is('superadmin*') ? 'superadmin' : 'admin';
        
        DB::beginTransaction();
        try {
            // Cari murid berdasarkan ID
            $murid = Murid::findOrFail($id);
            
            // Ambil data kelas terbaru untuk mengurangi jumlah_murid
            $kelasTerbaru = TransaksiKelas::where('id_murid', $id)
                ->orderBy('created_at', 'desc')
                ->first();
                
            // Kurangi jumlah murid di kelas terkait
            if ($kelasTerbaru) {
                $kelas = Kelas::find($kelasTerbaru->id_kelas);
                if ($kelas && $kelas->jumlah_murid > 0) {
                    $kelas->decrement('jumlah_murid');
                }
            }
            
            // Hapus semua transaksi kelas terkait
            TransaksiKelas::where('id_murid', $id)->delete();
            
            // Hapus semua transaksi paket terkait
            TransaksiPaket::where('id_murid', $id)->delete();
            
            // Hapus data murid
            $murid->delete();
            
            DB::commit();
            
            return redirect()
                ->route($role . '.kelola-murid')
                ->with('success', 'Data murid berhasil dihapus');
                
        } catch (\Exception $e) {
            DB::rollback();
            
            return back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    /**
     * API untuk pencarian murid (autocomplete)
     */
    public function search(Request $request)
    {
        $query = $request->get('q');
        
        // Minimal 2 karakter untuk pencarian
        if (strlen($query) < 2) {
            return response()->json([]);
        }
        
        // Cari murid berdasarkan nama
        $murids = Murid::where('nama_lengkap', 'like', '%' . $query . '%')
            ->limit(10)
            ->get(['id_murid', 'nama_lengkap', 'asal_sekolah', 'no_hp']);
            
        return response()->json($murids);
    }
}