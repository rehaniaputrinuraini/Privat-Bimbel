<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pegawai;
use Illuminate\Support\Facades\Hash;

class KelolaAdminController extends Controller
{
    public function index(Request $request)
    {
        $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        $perPage = $request->get('per_page', 10);
        
        $admin = User::where('peran', 'admin')
                     ->with('pegawai')
                     ->orderBy('id_user', 'desc')
                     ->paginate($perPage)
                     ->appends($request->query());
        
        return view('dashboard.superadmin.kelola-admin.kelola-admin', [
            'role' => $role,
            'admin' => $admin
        ]);
    }

    public function create(Request $request)
    {
        $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        return view('dashboard.superadmin.kelola-admin.create-admin', ['role' => $role]);
    }

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

    public function edit(Request $request, $hashId)
    {
        $id = unhash_id($hashId);
        if (!$id) {
            abort(404, 'Data tidak ditemukan');
        }
        
        $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        
        $admin = User::where('peran', 'admin')
                     ->with('pegawai')
                     ->findOrFail($id);
        
        return view('dashboard.superadmin.kelola-admin.edit-admin', [
            'role' => $role,
            'admin' => $admin
        ]);
    }

    public function update(Request $request, $hashId)
    {
        $id = unhash_id($hashId);
        if (!$id) {
            return response()->json(['success' => false, 'message' => 'Data tidak valid'], 404);
        }
        
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
            $userData = [
                'username' => $request->username,
                'email' => $request->email,
            ];
            
            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }
            
            $user->update($userData);

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

    public function updatePassword(Request $request, $hashId)
    {
        $id = unhash_id($hashId);
        if (!$id) {
            return response()->json(['success' => false, 'message' => 'Data tidak valid'], 404);
        }
        
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

    public function toggleStatus($hashId)
    {
        $id = unhash_id($hashId);
        if (!$id) {
            return redirect()->back()->with('error', 'Data tidak valid');
        }
        
        $user = User::findOrFail($id);
        $user->update(['status' => $user->status == 1 ? 0 : 1]);
        
        $referer = request()->headers->get('referer');
        $role = str_contains($referer, 'superadmin') ? 'superadmin' : 'admin';
        
        return redirect()->route($role . '.kelola-admin')->with('success', 'Status admin berhasil diubah');
    }

    public function destroy($hashId)
    {
        $id = unhash_id($hashId);
        if (!$id) {
            return redirect()->back()->with('error', 'Data tidak valid');
        }
        
        $user = User::with('pegawai')->findOrFail($id);
        
        if ($user->pegawai) {
            $user->pegawai->delete();
        }
        
        $user->delete();
        
        $referer = request()->headers->get('referer');
        $role = str_contains($referer, 'superadmin') ? 'superadmin' : 'admin';
        
        return redirect()->route($role . '.kelola-admin')->with('success', 'Admin berhasil dihapus');
    }
}