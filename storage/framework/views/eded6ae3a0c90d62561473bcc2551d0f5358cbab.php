<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tentor;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class KelolaTentorController extends Controller
{
    // Menampilkan semua data tentor
    public function index(Request $request)
    {
        $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        
        $query = Tentor::with('user');
        
        // Filter berdasarkan status gaji
        if ($request->has('status_gaji') && $request->status_gaji != '') {
            $query->where('status_gaji', $request->status_gaji);
        }
        
        // Filter berdasarkan status akun
        if ($request->has('status_akun') && $request->status_akun != '') {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('status_akun', $request->status_akun);
            });
        }
        
        // Pencarian
        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('nama_lengkap_tentor', 'like', '%' . $request->search . '%')
                  ->orWhere('id_tentor', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', function($u) use ($request) {
                      $u->where('email', 'like', '%' . $request->search . '%')
                        ->orWhere('username', 'like', '%' . $request->search . '%');
                  });
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
    
    // Simpan tentor baru (ke ms_user dan ms_tentor)
    public function store(Request $request)
    {
        // Validasi input
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
            'email' => 'required|email|unique:ms_user,email',
            'username' => 'required|string|unique:ms_user,username',
            'password' => 'required|string|min:6',
        ]);
        
        try {
            // 1. Buat user di tabel ms_user
            $user = User::create([
                'email' => $request->email,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'status_akun' => 'Aktif',
                'peran' => $request->peran ?? 'tentor',
            ]);
            
            // 2. Buat tentor di tabel ms_tentor dengan id_user
            $tentor = Tentor::create([
                'id_user' => $user->id_user,
                'nama_lengkap_tentor' => $request->nama_lengkap_tentor,
                'alamat_tentor' => $request->alamat_tentor,
                'no_hp_tentor' => $request->no_hp_tentor,
                'mapel' => $request->mapel,
                'grade' => $request->grade,
                'hr_sd' => $request->hr_sd ?? 0,
                'hr_smp' => $request->hr_smp ?? 0,
                'hr_sma' => $request->hr_sma ?? 0,
                'uang_makan' => $request->uang_makan ?? 0,
                'uang_transport' => $request->uang_transport ?? 0,
                'status_gaji' => 'Belum',
            ]);
            
            return redirect()->route('superadmin.kelola-tentor')
                ->with('success', 'Data tentor berhasil ditambahkan');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])
                ->withInput();
        }
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
            'email' => 'required|email|unique:ms_user,email,' . $tentor->id_user . ',id_user',
            'username' => 'required|string|unique:ms_user,username,' . $tentor->id_user . ',id_user',
            'password' => 'nullable|string|min:6',
        ]);
        
        try {
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
            $tentor->update([
                'nama_lengkap_tentor' => $request->nama_lengkap_tentor,
                'alamat_tentor' => $request->alamat_tentor,
                'no_hp_tentor' => $request->no_hp_tentor,
                'mapel' => $request->mapel,
                'grade' => $request->grade,
                'hr_sd' => $request->hr_sd ?? 0,
                'hr_smp' => $request->hr_smp ?? 0,
                'hr_sma' => $request->hr_sma ?? 0,
                'uang_makan' => $request->uang_makan ?? 0,
                'uang_transport' => $request->uang_transport ?? 0,
                'status_gaji' => $request->status_gaji ?? $tentor->status_gaji,
            ]);
            
            return redirect()->route('superadmin.kelola-tentor')
                ->with('success', 'Data tentor berhasil diperbarui');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])
                ->withInput();
        }
    }
    
    // Hapus tentor (beserta user-nya)
    public function destroy($id)
    {
        try {
            $tentor = Tentor::findOrFail($id);
            $userId = $tentor->id_user;
            $tentor->delete();
            
            if ($userId) {
                User::where('id_user', $userId)->delete();
            }
            
            return redirect()->route('superadmin.kelola-tentor')
                ->with('success', 'Data tentor berhasil dihapus');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }
    
    // Aktifkan/Nonaktifkan tentor
    public function toggleStatus($id)
    {
        try {
            $tentor = Tentor::findOrFail($id);
            $user = User::findOrFail($tentor->id_user);
            
            $newStatus = $user->status_akun == 'Aktif' ? 'Nonaktif' : 'Aktif';
            $user->update(['status_akun' => $newStatus]);
            
            $message = $newStatus == 'Aktif' ? 'diaktifkan' : 'dinonaktifkan';
            return redirect()->route('superadmin.kelola-tentor')
                ->with('success', 'Status tentor berhasil ' . $message);
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }
} ?><?php /**PATH C:\xampp\htdocs\Privat-Bimbel\resources\views/dashboard/superadmin/kelola-tentor/kelola-tentor.blade.php ENDPATH**/ ?>