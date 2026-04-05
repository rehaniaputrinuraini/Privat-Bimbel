<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tentor;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class KelolaTentorController extends Controller
{
    // Menampilkan semua data tentor (join dengan user)
    public function index(Request $request)
    {
        $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        
        $query = Tentor::with('user');
        
        if ($request->has('status_gaji') && $request->status_gaji != '') {
            $query->where('status_gaji', $request->status_gaji);
        }
        
        if ($request->has('search') && $request->search != '') {
            $query->where('nama_lengkap_tentor', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', function($q) use ($request) {
                      $q->where('username', 'like', '%' . $request->search . '%')
                        ->orWhere('email', 'like', '%' . $request->search . '%');
                  });
        }
        
        $tentors = $query->orderBy('id_tentor', 'asc')->paginate(10);
        
        return view('dashboard.superadmin.kelola-tentor.kelola-tentor', [
            'role' => $role,
            'tentors' => $tentors,
        ]);
    }
    
    // Form tambah tentor
    public function create()
    {
        return view('dashboard.superadmin.kelola-tentor.create-tentor', [
            'role' => 'superadmin'
        ]);
    }
    
    // Simpan tentor baru (buat user dulu, baru tentor)
    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap_tentor' => 'required|string|max:100',
            'alamat_tentor' => 'nullable|string',
            'no_hp_tentor' => 'nullable|string|max:15',
            'mapel' => 'nullable|string|max:50',
            'grade' => 'nullable|string|max:10',
            'hr_sd' => 'nullable|numeric|min:0',
            'hr_smp' => 'nullable|numeric|min:0',
            'hr_sma' => 'nullable|numeric|min:0',
            'uang_makan' => 'nullable|numeric|min:0',
            'uang_transport' => 'nullable|numeric|min:0',
            'status_gaji' => 'nullable|in:Sudah,Belum',
            // Data user
            'email' => 'required|email|unique:ms_user,email',
            'username' => 'required|string|unique:ms_user,username',
            'password' => 'required|string|min:6',
        ]);
        
        // 1. Buat user dulu
        $user = User::create([
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'status_akun' => 'Aktif',
            'peran' => 'tentor',
        ]);
        
        // 2. Buat tentor dengan id_user
        $data = $request->except(['email', 'username', 'password']);
        $data['id_user'] = $user->id_user;
        $data['status_gaji'] = $request->status_gaji ?? 'Belum';
        
        Tentor::create($data);
        
        return redirect()->route('superadmin.kelola-tentor')
            ->with('success', 'Data tentor berhasil ditambahkan');
    }
    
    // Form edit tentor
    public function edit($id)
    {
        $tentor = Tentor::with('user')->findOrFail($id);
        
        return view('dashboard.superadmin.kelola-tentor.edit-tentor', [
            'role' => 'superadmin',
            'tentor' => $tentor,
        ]);
    }
    
    // Update tentor
    public function update(Request $request, $id)
    {
        $tentor = Tentor::with('user')->findOrFail($id);
        
        $request->validate([
            'nama_lengkap_tentor' => 'required|string|max:100',
            'alamat_tentor' => 'nullable|string',
            'no_hp_tentor' => 'nullable|string|max:15',
            'mapel' => 'nullable|string|max:50',
            'grade' => 'nullable|string|max:10',
            'hr_sd' => 'nullable|numeric|min:0',
            'hr_smp' => 'nullable|numeric|min:0',
            'hr_sma' => 'nullable|numeric|min:0',
            'uang_makan' => 'nullable|numeric|min:0',
            'uang_transport' => 'nullable|numeric|min:0',
            'status_gaji' => 'nullable|in:Sudah,Belum',
            // Data user
            'email' => 'required|email|unique:ms_user,email,' . $tentor->id_user . ',id_user',
            'username' => 'required|string|unique:ms_user,username,' . $tentor->id_user . ',id_user',
            'password' => 'nullable|string|min:6',
        ]);
        
        // Update user
        $userData = [
            'email' => $request->email,
            'username' => $request->username,
        ];
        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }
        $tentor->user->update($userData);
        
        // Update tentor
        $tentor->update($request->except(['email', 'username', 'password']));
        
        return redirect()->route('superadmin.kelola-tentor')
            ->with('success', 'Data tentor berhasil diperbarui');
    }
    
    // Hapus tentor (beserta user-nya)
    public function destroy($id)
    {
        $tentor = Tentor::findOrFail($id);
        $userId = $tentor->id_user;
        $tentor->delete();
        
        // Hapus user juga
        if ($userId) {
            User::where('id_user', $userId)->delete();
        }
        
        return redirect()->route('superadmin.kelola-tentor')
            ->with('success', 'Data tentor berhasil dihapus');
    }
    
    // Aktifkan/Nonaktifkan tentor
    public function toggleStatus($id)
    {
        $tentor = Tentor::findOrFail($id);
        $user = User::findOrFail($tentor->id_user);
        
        $newStatus = $user->status_akun == 'Aktif' ? 'Nonaktif' : 'Aktif';
        $user->update(['status_akun' => $newStatus]);
        
        return redirect()->route('superadmin.kelola-tentor')
            ->with('success', 'Status tentor berhasil diubah menjadi ' . $newStatus);
    }
}