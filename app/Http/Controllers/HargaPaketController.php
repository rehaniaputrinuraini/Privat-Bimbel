<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HargaPaket;

class HargaPaketController extends Controller
{
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
        return view('dashboard.shared.harga-paket.create-paket', ['role' => $role]);
    }

    // Simpan data
    public function store(Request $request)
{
    $request->validate([
        'tingkat' => 'required|string|max:25',
        'harga' => 'required|numeric|min:0'
    ]);

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
        'tingkat' => 'required|string|max:25',
        'harga' => 'required|numeric|min:0',
        'biaya_pendaftaran' => 'nullable|numeric|min:0'
    ]);

    $paket = HargaPaket::findOrFail($id);
    $paket->update([
        'tingkat' => $request->tingkat,
        'harga' => $request->harga,
       
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