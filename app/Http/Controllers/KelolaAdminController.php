<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pegawai;
use Illuminate\Support\Facades\Hash;

class KelolaAdminController extends Controller
{
    // Menampilkan semua data admin
    public function index(Request $request)
    {
        $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        
        $admin = User::where('peran', 'admin')
                     ->with('pegawai')
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
        $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        return view('dashboard.superadmin.kelola-admin.create-admin', ['role' => $role]);
    }

    // Simpan data admin
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:15|unique:ms_user,username',
            'email' => 'required|email|max:35|unique:ms_user,email',
            'password' => 'required|string|min:6',
            'nama_lengkap' => 'required|string|max:35',
            'alamat' => 'nullable|string|max:100',
            'no_hp' => 'nullable|string|max:15',
            'gaji_pokok' => 'nullable|integer', 
        ]);

        try {
            // Insert ke ms_pegawai dulu
            $pegawai = Pegawai::create([
                'jenis_pegawai' => 'admin',
                'nama_lengkap' => $request->nama_lengkap,
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp,
                'gaji_pokok' => $request->gaji_pokok,
                'grade' => null,
                'hr_sd' => null,
                'hr_smp' => null,
                'hr_sma' => null,
                'uang_makan' => null,
                'uang_transport' => null,
            ]);

            // Insert ke ms_user
            User::create([
                'id_pegawai' => $pegawai->id_pegawai,
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'peran' => 'admin',
                'status' => 1,
            ]);

            return response()->json(['success' => true, 'message' => 'Admin berhasil ditambahkan']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal: ' . $e->getMessage()]);
        }
    }

    // Form edit admin
    public function edit(Request $request, $id)
    {
        $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        
        $admin = User::where('peran', 'admin')
                     ->with('pegawai')
                     ->findOrFail($id);
        
        return view('dashboard.superadmin.kelola-admin.edit-admin', [
            'role' => $role,
            'admin' => $admin
        ]);
    }

    // Update data admin
    public function update(Request $request, $id)
    {
        $user = User::with('pegawai')->findOrFail($id);
        
        $request->validate([
            'username' => 'required|string|max:15|unique:ms_user,username,' . $id . ',id_user',
            'email' => 'required|email|max:35|unique:ms_user,email,' . $id . ',id_user',
            'nama_lengkap' => 'required|string|max:35',
            'alamat' => 'nullable|string|max:100',
            'no_hp' => 'nullable|string|max:15',
            'gaji_pokok' => 'nullable|integer',
            'password' => 'nullable|string|min:6',
        ]);

        try {
            // Update user
            $userData = [
                'username' => $request->username,
                'email' => $request->email,
            ];
            
            // Update password jika diisi
            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }
            
            $user->update($userData);

            // Update data pegawai
            if ($user->pegawai) {
                $user->pegawai->update([
                    'nama_lengkap' => $request->nama_lengkap,
                    'alamat' => $request->alamat,
                    'no_hp' => $request->no_hp,
                    'gaji_pokok' => $request->gaji_pokok,
                ]);
            } else {
                Pegawai::create([
                    'id_pegawai' => $user->id_pegawai,
                    'jenis_pegawai' => 'admin',
                    'nama_lengkap' => $request->nama_lengkap,
                    'alamat' => $request->alamat,
                    'no_hp' => $request->no_hp,
                    'gaji_pokok' => $request->gaji_pokok,
                ]);
            }

            return response()->json(['success' => true, 'message' => 'Admin berhasil diperbarui']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal: ' . $e->getMessage()]);
        }
    }

    // Update password admin
    public function updatePassword(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ]);
        
        try {
            $user = User::findOrFail($id);
            $user->update([
                'password' => Hash::make($request->password),
            ]);
            
            return response()->json(['success' => true, 'message' => 'Password berhasil diubah']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal: ' . $e->getMessage()]);
        }
    }

    // Hapus data admin
    public function destroy($id)
    {
        $user = User::with('pegawai')->findOrFail($id);
        
        // Hapus data pegawai terkait
        if ($user->pegawai) {
            $user->pegawai->delete();
        }
        
        // Hapus user
        $user->delete();
        
        $referer = request()->headers->get('referer');
        $role = str_contains($referer, 'superadmin') ? 'superadmin' : 'admin';
        
        return redirect()->route($role . '.kelola-admin')->with('success', 'Admin berhasil dihapus');
    }
}