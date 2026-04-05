<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Murid;
use App\Models\HargaPaket;

class MuridController extends Controller
{
    // Menampilkan semua data murid
    public function index(Request $request)
    {
        $role = $request->route()->getPrefix() == '/superadmin' ? 'superadmin' : 'admin';
        $murids = Murid::orderBy('id_murid', 'asc')->get();
        
        return view('dashboard.shared.kelola-murid.kelola-murid', [
            'role' => $role,
            'murids' => $murids
        ]);
    }

    // Form tambah data
    public function create(Request $request)
    {
        $role = $request->route()->getPrefix() == '/superadmin' ? 'superadmin' : 'admin';
        
        $paketList = HargaPaket::orderBy('id_paket', 'asc')->get();
        
        return view('dashboard.shared.kelola-murid.create-murid', [
            'role' => $role,
            'paketList' => $paketList
        ]);
    }

    // Simpan data
    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap_murid' => 'required|string|max:35',
            'kelas' => 'nullable|string|max:10',
            'asal_sekolah' => 'nullable|string|max:35',
            'alamat_murid' => 'nullable|string',
            'no_hp_murid' => 'nullable|string|max:15',
            'nama_orang_tua' => 'nullable|string|max:35',
            'no_hp_orang_tua' => 'nullable|string|max:15',
            'paket_awal' => 'nullable|numeric|min:0',
            'pilihan_paket' => 'nullable|string|max:25',
            'tahun_masuk' => 'nullable|integer|min:1900|max:' . date('Y')
        ]);

        $data = $request->all();
        if (empty($data['paket_awal'])) {
            $data['paket_awal'] = 100000;
        }
        
        Murid::create($data);

        $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        
        return redirect()->route($role . '.kelola-murid')->with('success', 'Data murid berhasil ditambahkan');
    }

    // Form edit data
    public function edit(Request $request, $id)
    {
        $role = $request->route()->getPrefix() == '/superadmin' ? 'superadmin' : 'admin';
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
            'nama_lengkap_murid' => 'required|string|max:35',
            'kelas' => 'nullable|string|max:10',
            'asal_sekolah' => 'nullable|string|max:35',
            'alamat_murid' => 'nullable|string',
            'no_hp_murid' => 'nullable|string|max:15',
            'nama_orang_tua' => 'nullable|string|max:35',
            'no_hp_orang_tua' => 'nullable|string|max:15',
            'paket_awal' => 'nullable|numeric|min:0',
            'pilihan_paket' => 'nullable|string|max:25',
            'tahun_masuk' => 'nullable|integer|min:1900|max:' . date('Y')
        ]);

        $murid = Murid::findOrFail($id);
        
        $data = $request->all();
        if (empty($data['paket_awal'])) {
            $data['paket_awal'] = 100000;
        }
        
        $murid->update($data);

        $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        
        return redirect()->route($role . '.kelola-murid')->with('success', 'Data murid berhasil diperbarui');
    }

    // Hapus data
    public function destroy($id)
    {
        $murid = Murid::findOrFail($id);
        $murid->delete();
        
        $referer = request()->headers->get('referer');
        $role = str_contains($referer, 'superadmin') ? 'superadmin' : 'admin';
        
        return redirect()->route($role . '.kelola-murid')->with('success', 'Data murid berhasil dihapus');
    }

        // Search murid untuk live search
    public function search(Request $request)
    {
        $query = $request->get('q');
        
        if (strlen($query) < 2) {
            return response()->json([]);
        }
        
        $murids = Murid::where('nama_lengkap_murid', 'like', "%{$query}%")
            ->limit(10)
            ->get(['id_murid', 'nama_lengkap_murid', 'kelas', 'paket_awal', 'pilihan_paket']);
        
        return response()->json($murids);
    }
}