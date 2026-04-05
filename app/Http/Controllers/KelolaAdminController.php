<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class KelolaAdminController extends Controller
{
    // Menampilkan semua data admin
    public function index(Request $request)
    {
        $role = $request->route()->getPrefix() == '/superadmin' ? 'superadmin' : 'admin';
        
        // Ambil data user dengan peran 'admin' beserta relasi admin
        $admin = User::where('peran', 'admin')
                     ->with('admin')
                     ->orderBy('id_user', 'desc')
                     ->get();
        
        return view('dashboard.superadmin.kelola-admin.kelola-admin', [
            'role' => $role,
            'admin' => $admin
        ]);
    }

    // Form tambah admin
    public function create(Request $request)
    {
        $role = $request->route()->getPrefix() == '/superadmin' ? 'superadmin' : 'admin';
        return view('dashboard.superadmin.kelola-admin.create-admin', ['role' => $role]);
    }

    // Simpan data admin (TANPA password & status_gaji)
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:15|unique:ms_user,username',
            'email' => 'required|email|max:45|unique:ms_user,email',
            // 'password' => 'required|min:6',  // ← DIHAPUS
            'nama_lengkap_admin' => 'required|string|max:35',
            'alamat_admin' => 'nullable|string',
            'no_hp_admin' => 'nullable|string|max:15',
            'gaji_pokok' => 'nullable|numeric|min:0',
        ]);

        // Simpan ke ms_user (dengan password default)
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make('admin123'), // Password default
            'peran' => 'admin',
            'status' => 1,
        ]);

        // Simpan ke ms_admin
        Admin::create([
            'id_user' => $user->id_user,
            'nama_lengkap_admin' => $request->nama_lengkap_admin,
            'alamat_admin' => $request->alamat_admin,
            'no_hp_admin' => $request->no_hp_admin,
            'gaji_pokok' => $request->gaji_pokok ?? 0,
        ]);

        $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        
        return redirect()->route($role . '.kelola-admin')->with('success', 'Admin berhasil ditambahkan');
    }

    // Form edit admin
    public function edit(Request $request, $id)
    {
        $role = $request->route()->getPrefix() == '/superadmin' ? 'superadmin' : 'admin';
        
        $admin = User::where('peran', 'admin')
                     ->with('admin')
                     ->findOrFail($id);
        
        return view('dashboard.superadmin.kelola-admin.edit-admin', [
            'role' => $role,
            'admin' => $admin
        ]);
    }

    // Update data admin (TANPA password, status_gaji, dan status akun)
    public function update(Request $request, $id)
    {
        $request->validate([
            'username' => 'required|string|max:15|unique:ms_user,username,' . $id . ',id_user',
            'email' => 'required|email|max:45|unique:ms_user,email,' . $id . ',id_user',
            'nama_lengkap_admin' => 'required|string|max:35',
            'alamat_admin' => 'nullable|string',
            'no_hp_admin' => 'nullable|string|max:15',
            'gaji_pokok' => 'nullable|numeric|min:0',
            // 'status' => 'nullable|in:0,1',  // ← DIHAPUS
        ]);

        $user = User::findOrFail($id);
        $user->update([
            'username' => $request->username,
            'email' => $request->email,
            // 'status' => $request->status ?? 1,  // ← DIHAPUS
        ]);

        // Update password TIDAK ADA (karena field password dihapus dari form)

        // Update atau create data admin
        Admin::updateOrCreate(
            ['id_user' => $id],
            [
                'nama_lengkap_admin' => $request->nama_lengkap_admin,
                'alamat_admin' => $request->alamat_admin,
                'no_hp_admin' => $request->no_hp_admin,
                'gaji_pokok' => $request->gaji_pokok ?? 0,
            ]
        );

        $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        
        return redirect()->route($role . '.kelola-admin')->with('success', 'Admin berhasil diperbarui');
    }

    // Hapus data admin
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Hapus data admin terkait
        if ($user->admin) {
            $user->admin->delete();
        }
        
        // Hapus user
        $user->delete();
        
        $referer = request()->headers->get('referer');
        $role = str_contains($referer, 'superadmin') ? 'superadmin' : 'admin';
        
        return redirect()->route($role . '.kelola-admin')->with('success', 'Admin berhasil dihapus');
    }
}