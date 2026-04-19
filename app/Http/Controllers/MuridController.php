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
            'nama_lengkap' => 'required|string|max:35',
            'asal_sekolah' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:100',
            'no_hp' => 'nullable|string|max:15',
            'nama_orang_tua' => 'nullable|string|max:35',
            'no_hp_orang_tua' => 'nullable|string|max:15',
            'tahun_masuk' => 'nullable|integer|min:1900|max:' . date('Y'),
            'tanggal_daftar' => 'nullable|date',
        ]);

        $data = $request->only([
            'nama_lengkap',
            'asal_sekolah',
            'alamat',
            'no_hp',
            'nama_orang_tua',
            'no_hp_orang_tua',
            'tahun_masuk',
            'tanggal_daftar',
        ]);
        
        // Set tanggal_daftar ke hari ini jika kosong
        if (empty($data['tanggal_daftar'])) {
            $data['tanggal_daftar'] = date('Y-m-d');
        }
        
        Murid::create($data);

        $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        
        return redirect()->route($role . '.kelola-murid')->with('success', 'Data murid berhasil ditambahkan');
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
            'tanggal_daftar' => 'nullable|date',
        ]);

        $murid = Murid::findOrFail($id);
        
        $data = $request->only([
            'nama_lengkap',
            'asal_sekolah',
            'alamat',
            'no_hp',
            'nama_orang_tua',
            'no_hp_orang_tua',
            'tahun_masuk',
            'tanggal_daftar',
        ]);
        
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
        
        $murids = Murid::where('nama_lengkap', 'like', "%{$query}%")
            ->limit(10)
            ->get(['id_murid', 'nama_lengkap', 'asal_sekolah', 'no_hp']);
        
        return response()->json($murids);
    }
    
    // Get harga paket (untuk AJAX)
    public function getHargaPaket($id)
    {
        $paket = HargaPaket::find($id);
        
        if ($paket) {
            return response()->json([
                'success' => true,
                'harga' => $paket->harga
            ]);
        }
        
        return response()->json([
            'success' => false,
            'harga' => 0
        ]);
    }
}