<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class KelolaTentorController extends Controller
{
    public function index(Request $request)
    {
        $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        $perPage = $request->get('per_page', 10);
        
        $query = Pegawai::with('user')->where('jenis_pegawai', 'tentor');
        
        if ($request->has('status') && $request->status != '') {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('status', $request->status);
            });
        }
        
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_lengkap', 'like', '%' . $search . '%')
                  ->orWhere('id_pegawai', 'like', '%' . $search . '%')
                  ->orWhere('mapel', 'like', '%' . $search . '%')
                  ->orWhereHas('user', function($qu) use ($search) {
                      $qu->where('username', 'like', '%' . $search . '%')
                         ->orWhere('email', 'like', '%' . $search . '%');
                  });
            });
        }
        
        $tentors = $query->orderBy('id_pegawai', 'asc')->paginate($perPage)->appends($request->query());
        
        if ($role == 'superadmin') {
            return view('dashboard.superadmin.kelola-tentor.kelola-tentor', [
                'role' => $role,
                'tentors' => $tentors,
            ]);
        } else {
            return view('dashboard.admin.data-tentor.data-tentor', [
                'role' => $role,
                'tentors' => $tentors,
            ]);
        }
    }
    
    public function create()
    {
        if (auth()->user()->peran != 'superadmin') {
            abort(403, 'Unauthorized action.');
        }
        
        return view('dashboard.superadmin.kelola-tentor.create-tentor');
    }
    
    public function store(Request $request)
    {
        if (auth()->user()->peran != 'superadmin') {
            abort(403, 'Unauthorized action.');
        }
        
        $request->validate([
            'nama_lengkap' => 'required|string|max:35',
            'alamat' => 'required|string|max:100',
            'no_hp' => 'required|string|max:15',
            'mapel' => 'required|string|max:50',
            'grade' => 'required|in:A,B',
            'hr_sd' => 'nullable|integer|min:0',
            'hr_smp' => 'nullable|integer|min:0',
            'hr_sma' => 'nullable|integer|min:0',
            'uang_makan' => 'nullable|integer|min:0',
            'uang_transport' => 'nullable|integer|min:0',
            'email' => 'required|email|unique:ms_user,email',
            'username' => 'required|string|unique:ms_user,username',
            'password' => 'required|string|min:6',
        ]);
        
        DB::beginTransaction();
        try {
            $pegawai = Pegawai::create([
                'jenis_pegawai' => 'tentor',
                'nama_lengkap' => $request->nama_lengkap,
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp,
                'mapel' => $request->mapel,
                'gaji_pokok' => null,
                'grade' => $request->grade,
                'hr_sd' => $request->hr_sd ?? 0,
                'hr_smp' => $request->hr_smp ?? 0,
                'hr_sma' => $request->hr_sma ?? 0,
                'uang_makan' => $request->uang_makan ?? 0,
                'uang_transport' => $request->uang_transport ?? 0,
            ]);
            
            User::create([
                'id_pegawai' => $pegawai->id_pegawai,
                'email' => $request->email,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'status' => 1,
                'peran' => 'tentor',
            ]);
            
            DB::commit();
            
            return response()->json(['success' => true, 'message' => 'Data tentor berhasil ditambahkan']);
                
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }
    
    public function edit($id)
    {
        if (auth()->user()->peran != 'superadmin') {
            abort(403, 'Unauthorized action.');
        }
        
        $tentor = Pegawai::with('user')->where('jenis_pegawai', 'tentor')->findOrFail($id);
        
        return view('dashboard.superadmin.kelola-tentor.edit-tentor', [
            'tentor' => $tentor,
        ]);
    }
    
    public function update(Request $request, $id)
    {
        if (auth()->user()->peran != 'superadmin') {
            abort(403, 'Unauthorized action.');
        }
        
        $tentor = Pegawai::with('user')->where('jenis_pegawai', 'tentor')->findOrFail($id);
        
        $request->validate([
            'nama_lengkap' => 'required|string|max:35',
            'alamat' => 'required|string|max:100',
            'no_hp' => 'required|string|max:15',
            'mapel' => 'required|string|max:50',
            'grade' => 'required|in:A,B',
            'hr_sd' => 'nullable|integer|min:0',
            'hr_smp' => 'nullable|integer|min:0',
            'hr_sma' => 'nullable|integer|min:0',
            'uang_makan' => 'nullable|integer|min:0',
            'uang_transport' => 'nullable|integer|min:0',
            'email' => 'required|email|unique:ms_user,email,' . $tentor->user->id_user . ',id_user',
            'username' => 'required|string|unique:ms_user,username,' . $tentor->user->id_user . ',id_user',
            'password' => 'nullable|string|min:6',
        ]);
        
        DB::beginTransaction();
        try {
            $userData = [
                'email' => $request->email,
                'username' => $request->username,
            ];
            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }
            $tentor->user->update($userData);
            
            $tentor->update([
                'nama_lengkap' => $request->nama_lengkap,
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp,
                'mapel' => $request->mapel,
                'gaji_pokok' => null,
                'grade' => $request->grade,
                'hr_sd' => $request->hr_sd ?? 0,
                'hr_smp' => $request->hr_smp ?? 0,
                'hr_sma' => $request->hr_sma ?? 0,
                'uang_makan' => $request->uang_makan ?? 0,
                'uang_transport' => $request->uang_transport ?? 0,
            ]);
            
            DB::commit();
            
            return response()->json(['success' => true, 'message' => 'Data tentor berhasil diperbarui']);
                
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }
    
    public function updatePassword(Request $request, $id)
    {
        if (auth()->user()->peran != 'superadmin') {
            abort(403, 'Unauthorized action.');
        }
        
        $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ]);
        
        try {
            $tentor = Pegawai::with('user')->where('jenis_pegawai', 'tentor')->findOrFail($id);
            $tentor->user->update([
                'password' => Hash::make($request->password),
            ]);
            
            return response()->json(['success' => true, 'message' => 'Password berhasil diubah']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal: ' . $e->getMessage()]);
        }
    }
    
    public function toggleStatus($id)
    {
        if (auth()->user()->peran != 'superadmin') {
            abort(403, 'Unauthorized action.');
        }
        
        try {
            $tentor = Pegawai::with('user')->where('jenis_pegawai', 'tentor')->findOrFail($id);
            $user = $tentor->user;
            
            $newStatus = $user->status == 1 ? 0 : 1;
            $user->update(['status' => $newStatus]);
            
            $message = $newStatus == 1 ? 'diaktifkan' : 'dinonaktifkan';
            return redirect()->route('superadmin.kelola-tentor')
                ->with('success', 'Status tentor berhasil ' . $message);
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }
    
    public function destroy($id)
    {
        if (auth()->user()->peran != 'superadmin') {
            abort(403, 'Unauthorized action.');
        }
        
        DB::beginTransaction();
        try {
            $tentor = Pegawai::where('jenis_pegawai', 'tentor')->findOrFail($id);
            
            if ($tentor->user) {
                $tentor->user->delete();
            }
            
            $tentor->delete();
            
            DB::commit();
            
            return redirect()->route('superadmin.kelola-tentor')
                ->with('success', 'Data tentor berhasil dihapus');
                
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }
}