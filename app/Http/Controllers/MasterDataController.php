<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HargaPaket;
use App\Models\Kelas;
use App\Models\Ruang;
use App\Models\Periode;

class MasterDataController extends Controller
{
    // Daftar tingkat yang tersedia (ENUM)
    private $tingkatOptions = ['SD', 'SMP', 'SMA'];
    private $jenjangOptions = ['SD', 'SMP', 'SMA'];

    // =============================================
    // HALAMAN UTAMA MASTER DATA (4 TAB)
    // =============================================
    public function index(Request $request)
    {
        // ✅ DETEKSI ROLE DARI URL
        $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        
        // Data untuk Tab 1: Harga Paket
        $paket = HargaPaket::orderBy('id_paket', 'asc')->get();
        
        // Data untuk Tab 2: Kelas
        $kelas = Kelas::orderBy('nama_kelas', 'asc')->get();
        
        // Data untuk Tab 3: Ruang
        $ruang = Ruang::orderBy('nama_ruang', 'asc')->get();
        
        // Data untuk Tab 4: Periode
        $periode = Periode::orderBy('tahun_mulai', 'desc')->get();
        
        return view('dashboard.shared.master-data.master-data', 
            compact('role', 'paket', 'kelas', 'ruang', 'periode'));
    }

    // =============================================
    // CRUD HARGA PAKET
    // =============================================
    
    public function createPaket(Request $request)
    {
        $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        $tingkatTerpakai = HargaPaket::pluck('tingkat')->toArray();
        $tingkatTersedia = array_diff($this->tingkatOptions, $tingkatTerpakai);
        
        return view('dashboard.shared.master-data.harga-paket.create', [
            'role' => $role,
            'tingkatTersedia' => $tingkatTersedia
        ]);
    }

    public function storePaket(Request $request)
    {
        $request->validate([
            'tingkat' => 'required|in:SD,SMP,SMA',
            'harga' => 'required|numeric|min:1000'
        ]);

        $existing = HargaPaket::where('tingkat', $request->tingkat)->first();
        if ($existing) {
            return redirect()->back()->withErrors(['tingkat' => 'Tingkat sudah ada.'])->withInput();
        }

        HargaPaket::create(['tingkat' => $request->tingkat, 'harga' => $request->harga]);

        $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        return redirect()->route($role . '.master-data')->with('success_paket', 'Harga paket berhasil ditambahkan');
    }

    public function editPaket(Request $request, $id)
    {
        $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        $paket = HargaPaket::findOrFail($id);
        return view('dashboard.shared.master-data.harga-paket.edit', compact('role', 'paket'));
    }

    public function updatePaket(Request $request, $id)
    {
        $request->validate(['harga' => 'required|numeric|min:1000']);
        $paket = HargaPaket::findOrFail($id);
        $paket->update(['harga' => $request->harga]);
        
        $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        return redirect()->route($role . '.master-data')->with('success_paket', 'Harga paket berhasil diperbarui');
    }

    public function destroyPaket(Request $request, $id)
    {
        HargaPaket::destroy($id);
        
        $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        return redirect()->route($role . '.master-data')->with('success_paket', 'Harga paket berhasil dihapus');
    }

    // =============================================
    // CRUD KELAS
    // =============================================
    
    public function createKelas(Request $request)
    {
        $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        $jenjangOptions = $this->jenjangOptions;
        $periodeList = Periode::orderBy('tahun_mulai', 'desc')->get();
        return view('dashboard.shared.master-data.kelas.create', compact('role', 'jenjangOptions', 'periodeList'));
    }

    public function storeKelas(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:5',
            'jenjang' => 'required|in:SD,SMP,SMA',
            'id_periode' => 'required|exists:ms_periode,id_periode',
        ]);

        Kelas::create([
            'nama_kelas' => $request->nama_kelas,
            'jenjang' => $request->jenjang,
            'id_periode' => $request->id_periode,
            'jumlah_murid' => 0,
        ]);

        $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        return redirect()->route($role . '.master-data')->with('success_kelas', 'Kelas berhasil ditambahkan');
    }

    public function editKelas(Request $request, $id)
    {
        $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        $kelas = Kelas::findOrFail($id);
        $jenjangOptions = $this->jenjangOptions;
        $periodeList = Periode::orderBy('tahun_mulai', 'desc')->get();
        return view('dashboard.shared.master-data.kelas.edit', compact('role', 'kelas', 'jenjangOptions', 'periodeList'));
    }

    public function updateKelas(Request $request, $id)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:5',
            'jenjang' => 'required|in:SD,SMP,SMA',
            'id_periode' => 'required|exists:ms_periode,id_periode',
        ]);

        $kelas = Kelas::findOrFail($id);
        $kelas->update([
            'nama_kelas' => $request->nama_kelas,
            'jenjang' => $request->jenjang,
            'id_periode' => $request->id_periode,
        ]);

        $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        return redirect()->route($role . '.master-data')->with('success_kelas', 'Kelas berhasil diperbarui');
    }

    public function destroyKelas(Request $request, $id)
    {
        Kelas::destroy($id);
        
        $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        return redirect()->route($role . '.master-data')->with('success_kelas', 'Kelas berhasil dihapus');
    }

    // =============================================
    // CRUD RUANG
    // =============================================
    
    public function createRuang(Request $request)
    {
        $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        return view('dashboard.shared.master-data.ruang.create', compact('role'));
    }

    public function storeRuang(Request $request)
    {
        $request->validate([
            'nama_ruang' => 'required|string|max:2',
        ]);

        Ruang::create(['nama_ruang' => $request->nama_ruang]);

        $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        return redirect()->route($role . '.master-data')->with('success_ruang', 'Ruang berhasil ditambahkan');
    }

    public function editRuang(Request $request, $id)
    {
        $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        $ruang = Ruang::findOrFail($id);
        return view('dashboard.shared.master-data.ruang.edit', compact('role', 'ruang'));
    }

    public function updateRuang(Request $request, $id)
    {
        $request->validate([
            'nama_ruang' => 'required|string|max:2',
        ]);

        $ruang = Ruang::findOrFail($id);
        $ruang->update(['nama_ruang' => $request->nama_ruang]);

        $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        return redirect()->route($role . '.master-data')->with('success_ruang', 'Ruang berhasil diperbarui');
    }

    public function destroyRuang(Request $request, $id)
    {
        Ruang::destroy($id);
        
        $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        return redirect()->route($role . '.master-data')->with('success_ruang', 'Ruang berhasil dihapus');
    }

    // =============================================
    // CRUD PERIODE
    // =============================================
    
    public function createPeriode(Request $request)
    {
        $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        return view('dashboard.shared.master-data.periode.create', compact('role'));
    }

    public function storePeriode(Request $request)
    {
        $request->validate([
            'tahun_mulai' => 'required|integer|min:2020|max:2030',
            'tahun_selesai' => 'required|integer|min:2020|max:2030|gt:tahun_mulai',
        ]);

        $tahun_periode = $request->tahun_mulai . '/' . $request->tahun_selesai;

        Periode::create([
            'tahun_periode' => $tahun_periode,
            'tahun_mulai' => $request->tahun_mulai,
            'tahun_selesai' => $request->tahun_selesai,
        ]);

        $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        return redirect()->route($role . '.master-data')
            ->with('success_periode', 'Periode berhasil ditambahkan');
    }

    public function editPeriode(Request $request, $id)
    {
        $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        $periode = Periode::findOrFail($id);
        return view('dashboard.shared.master-data.periode.edit', compact('role', 'periode'));
    }

    public function updatePeriode(Request $request, $id)
    {
        $request->validate([
            'tahun_mulai' => 'required|integer|min:2020|max:2030',
            'tahun_selesai' => 'required|integer|min:2020|max:2030|gt:tahun_mulai',
        ]);

        $periode = Periode::findOrFail($id);
        $tahun_periode = $request->tahun_mulai . '/' . $request->tahun_selesai;

        $periode->update([
            'tahun_periode' => $tahun_periode,
            'tahun_mulai' => $request->tahun_mulai,
            'tahun_selesai' => $request->tahun_selesai,
        ]);

        $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        return redirect()->route($role . '.master-data')
            ->with('success_periode', 'Periode berhasil diperbarui');
    }

    public function destroyPeriode(Request $request, $id)
    {
        Periode::destroy($id);
        
        $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        return redirect()->route($role . '.master-data')
            ->with('success_periode', 'Periode berhasil dihapus');
    }
}