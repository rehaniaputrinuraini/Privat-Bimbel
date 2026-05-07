<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Pegawai;

class ProfileController extends Controller
{
    /**
     * Tampilkan halaman profil
     */
    public function index()
    {
        $user = Auth::user()->load('pegawai');
        
        return view('dashboard.shared.profil.index', compact('user'));
    }

    /**
     * Tampilkan halaman edit profil
     */
    public function edit()
    {
        $user = Auth::user()->load('pegawai');
        
        return view('dashboard.shared.profil.edit', compact('user'));
    }

    /**
     * Update profil
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'nama_lengkap' => 'required|string|max:35',
            'email' => 'required|email|max:35|unique:ms_user,email,' . $user->id_user . ',id_user',
            'no_hp' => 'nullable|string|max:15',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi',
            'nama_lengkap.max' => 'Nama lengkap maksimal 35 karakter',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah digunakan',
            'no_hp.max' => 'No HP maksimal 15 karakter',
            'foto.image' => 'File harus berupa gambar',
            'foto.mimes' => 'Format gambar harus JPG atau PNG',
            'foto.max' => 'Ukuran foto maksimal 2MB',
        ]);

        // Update email di ms_user
        $user->email = $request->email;

        // Hapus foto jika diminta
        if ($request->has('hapus_foto') && $request->hapus_foto == '1') {
            if ($user->foto) {
                Storage::disk('public')->delete($user->foto);
            }
            $user->foto = null;
        }

        // Upload foto jika ada
        if ($request->hasFile('foto')) {
            // Hapus foto lama
            if ($user->foto) {
                Storage::disk('public')->delete($user->foto);
            }
            
            // Simpan foto baru
            $path = $request->file('foto')->store('profil', 'public');
            $user->foto = $path;
        }

        $user->save();

        // Update nama_lengkap & no_hp di ms_pegawai
        if ($user->pegawai) {
            $user->pegawai->update([
                'nama_lengkap' => $request->nama_lengkap,
                'no_hp' => $request->no_hp,
            ]);
        }

        return redirect()->route('profile.index')->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Update password
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ], [
            'current_password.required' => 'Password saat ini wajib diisi',
            'password.required' => 'Password baru wajib diisi',
            'password.min' => 'Password minimal 6 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini salah']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('profile.index')->with('success', 'Password berhasil diubah!');
    }
}