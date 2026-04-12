<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HargaPaket;

class HargaPaketController extends Controller
{
    // Daftar tingkat yang tersedia (ENUM)
    private $tingkatOptions = ['SD', 'SMP', 'SMA'];

    // Menampilkan semua data
    public function index(Request $request)
    {
        $role = $request->route()->getPrefix() == '/superadmin' ? 'superadmin' : 'admin';
        $paket = HargaPaket::orderBy('id_paket', 'asc')->get();
        
        return view('dashboard.shared.harga-paket.harga-paket', [
            'role' => $role,
            'paket' => $paket
        ]);
    }

    // Form tambah data
    public function create(Request $request)
    {
        $role = $request->route()->getPrefix() == '/superadmin' ? 'superadmin' : 'admin';
        
        // ✅ Ambil tingkat yang SUDAH TERPAKAI di database
        $tingkatTerpakai = HargaPaket::pluck('tingkat')->toArray();
        
        // ✅ Filter tingkat yang BELUM TERPAKAI
        $tingkatTersedia = array_diff($this->tingkatOptions, $tingkatTerpakai);
        
        return view('dashboard.shared.harga-paket.create-paket', [
            'role' => $role,
            'tingkatTersedia' => $tingkatTersedia   // ✅ Kirim ke view
        ]);
    }

    // Simpan data
    public function store(Request $request)
    {
        $request->validate([
            'tingkat' => 'required|in:SD,SMP,SMA',   // ✅ Validasi enum
            'harga' => 'required|numeric|min:1000'
        ], [
            'tingkat.required' => 'Tingkat wajib dipilih.',
            'tingkat.in' => 'Tingkat tidak valid.',
            'harga.required' => 'Harga paket wajib diisi.',
            'harga.numeric' => 'Harga harus berupa angka.',
            'harga.min' => 'Harga minimal Rp 1.000.',
        ]);

        // ✅ Cek apakah tingkat sudah ada (double protection)
        $existing = HargaPaket::where('tingkat', $request->tingkat)->first();
        if ($existing) {
            return redirect()->back()
                ->withErrors(['tingkat' => 'Tingkat ' . $request->tingkat . ' sudah ada. Pilih tingkat lain.'])
                ->withInput();
        }

        HargaPaket::create([
            'tingkat' => $request->tingkat,
            'harga' => $request->harga
        ]);

        $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        
        return redirect()->route($role . '.harga-paket')->with('success', 'Data berhasil ditambahkan');
    }

    // Form edit data
    public function edit(Request $request, $id)
    {
        $role = $request->route()->getPrefix() == '/superadmin' ? 'superadmin' : 'admin';
        $paket = HargaPaket::findOrFail($id);
        
        return view('dashboard.shared.harga-paket.edit-paket', [
            'role' => $role,
            'paket' => $paket
        ]);
    }

    // Update data
    public function update(Request $request, $id)
    {
        $request->validate([
            // ✅ tingkat TIDAK DIVALIDASI karena tidak boleh diubah
            'harga' => 'required|numeric|min:1000',
        ], [
            'harga.required' => 'Harga paket wajib diisi.',
            'harga.numeric' => 'Harga harus berupa angka.',
            'harga.min' => 'Harga minimal Rp 1.000.',
        ]);

        $paket = HargaPaket::findOrFail($id);
        
        // ✅ HANYA UPDATE HARGA, tingkat TIDAK DIUBAH
        $paket->update([
            'harga' => $request->harga,
            // tingkat tidak diupdate
        ]);

        $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        
        return redirect()->route($role . '.harga-paket')->with('success', 'Data berhasil diperbarui');
    }

    // Hapus data
    public function destroy($id)
    {
        $paket = HargaPaket::findOrFail($id);
        $paket->delete();
        
        $referer = request()->headers->get('referer');
        $role = str_contains($referer, 'superadmin') ? 'superadmin' : 'admin';
        
        return redirect()->route($role . '.harga-paket')->with('success', 'Data berhasil dihapus');
    }
}