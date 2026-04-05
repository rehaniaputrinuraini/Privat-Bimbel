<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Murid;
use App\Models\Pembayaran;
use App\Models\HargaPaket;
use Illuminate\Support\Facades\Auth;

class PembayaranController extends Controller
{
    // Halaman utama pembayaran
    public function index(Request $request)
    {
        $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        
        $tagihan = Murid::with('pembayaran')
            ->select('ms_murid.*')
            ->get()
            ->map(function ($murid) {
                $total_bulan = '-';
                $total_piutang = '-';
                $uang_muka = '-';
                
                $piutang = $murid->pembayaran->sum('total_piutang');
                if ($piutang > 0) {
                    $total_piutang = 'Rp ' . number_format($piutang, 0, ',', '.');
                    $hargaPaket = HargaPaket::where('tingkat', $murid->pilihan_paket)->first();
                    $hargaPerBulan = $hargaPaket ? $hargaPaket->harga : 120000;
                    $total_bulan = round($piutang / $hargaPerBulan);
                }
                
                $uangMukaTotal = $murid->pembayaran->sum('total_uang_muka');
                if ($uangMukaTotal > 0) {
                    $uang_muka = 'Rp ' . number_format($uangMukaTotal, 0, ',', '.');
                }
                
                $lastPayment = $murid->pembayaran->last();
                $status_pembayaran = $lastPayment ? 
                    ($lastPayment->total_piutang > 0 ? 'Belum' : 'Lunas') : 'Belum';
                
                $status_tagihan = 'Lunas';
                if ($piutang > 0) {
                    $hargaPaket = HargaPaket::where('tingkat', $murid->pilihan_paket)->first();
                    $hargaPerBulan = $hargaPaket ? $hargaPaket->harga : 120000;
                    $bulan = round($piutang / $hargaPerBulan);
                    if ($bulan >= 3) {
                        $status_tagihan = 'Tunggak 3+ Bln';
                    } else {
                        $status_tagihan = 'Tunggak ' . $bulan . ' Bln';
                    }
                } elseif ($uangMukaTotal > 0) {
                    $status_tagihan = 'Uang Muka 1 Bln';
                }
                
                return (object)[
                    'id_murid' => $murid->id_murid,
                    'nama' => $murid->nama_lengkap_murid,
                    'kelas' => $murid->kelas,
                    'paket' => $murid->pilihan_paket,
                    'status_pembayaran' => $status_pembayaran,
                    'status_tagihan' => $status_tagihan,
                    'total_bulan' => $total_bulan,
                    'total_piutang' => $total_piutang,
                    'uang_muka' => $uang_muka,
                ];
            });
        
        $riwayat = Pembayaran::with('murid', 'paket')
            ->orderBy('tanggal', 'desc')
            ->get()
            ->map(function ($item) {
                $nama_murid = $item->murid ? $item->murid->nama_lengkap_murid : 'Tidak Diketahui';
                
                return (object)[
                    'id_pembayaran' => $item->id_pembayaran,
                    'tanggal' => date('d/m/Y', strtotime($item->tanggal)),
                    'nama_murid' => $nama_murid,
                    'paket_awal' => is_numeric($item->paket_awal) ? number_format($item->paket_awal, 0, ',', '.') : $item->paket_awal,
                    'paket_selanjutnya' => $item->paket_selanjutnya,
                    'total_bayar' => 'Rp ' . number_format($item->total_pembayaran, 0, ',', '.'),
                    'keterangan' => $item->keterangan,
                ];
            });
        
        return view('dashboard.shared.pembayaran.pembayaran', [
            'role' => $role,
            'tagihan' => $tagihan,
            'riwayat' => $riwayat,
        ]);
    }
    
    public function create(Request $request)
    {
        $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        $murids = Murid::orderBy('nama_lengkap_murid', 'asc')->get();
        $pakets = HargaPaket::all();
        
        return view('dashboard.shared.pembayaran.create-pembayaran', [
            'role' => $role,
            'murids' => $murids,
            'pakets' => $pakets,
        ]);
    }
    
    /**
     * Cek status pembayaran murid
     */
    public function cekStatusPembayaran($id)
    {
        $murid = Murid::find($id);
        
        if (!$murid) {
            return response()->json(['error' => 'Murid tidak ditemukan'], 404);
        }
        
        $sudahBayarPendaftaran = Pembayaran::where('id_murid', $id)
            ->whereNull('paket_selanjutnya')
            ->exists();
        
        return response()->json([
            'sudah_bayar_pendaftaran' => $sudahBayarPendaftaran,
            'paket_awal' => $murid->paket_awal ?? 100000,
            'pilihan_paket' => $murid->pilihan_paket,
            'nama_murid' => $murid->nama_lengkap_murid,
            'kelas' => $murid->kelas,
        ]);
    }
    
    // Proses simpan pembayaran
    public function store(Request $request)
    {
        $request->validate([
            'id_murid' => 'required|exists:ms_murid,id_murid',
            'tanggal' => 'required|date',
            'total_pembayaran' => 'required|numeric|min:1000',
            'keterangan' => 'nullable|string|max:255',
        ]);
        
        $murid = Murid::find($request->id_murid);
        
        if (!$murid) {
            return redirect()->back()->withErrors(['error' => 'Data murid tidak ditemukan']);
        }
        
        // Cek apakah sudah pernah bayar pendaftaran
        $sudahBayarPendaftaran = Pembayaran::where('id_murid', $request->id_murid)
            ->whereNull('paket_selanjutnya')
            ->exists();
        
        // KASUS 1: BELUM BAYAR PENDAFTARAN
        if (!$sudahBayarPendaftaran) {
            if ($request->total_pembayaran != $murid->paket_awal) {
                return redirect()->back()->withErrors([
                    'error' => 'Total pembayaran untuk pendaftaran harus Rp ' . number_format($murid->paket_awal, 0, ',', '.')
                ]);
            }
            
            try {
                Pembayaran::create([
                    'id_murid' => $request->id_murid,
                    'id_paket' => null,
                    'tanggal' => $request->tanggal,
                    'paket_awal' => $murid->paket_awal,
                    'paket_selanjutnya' => null,
                    'status_tagihan' => 'Lunas',
                    'total_piutang' => 0,
                    'total_uang_muka' => 0,
                    'total_pembayaran' => $request->total_pembayaran,
                    'keterangan' => $request->keterangan ?: 'Pembayaran pendaftaran',
                ]);
                
                $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
                
                return redirect()->route($role . '.pembayaran')
                    ->with('success', 'Pembayaran pendaftaran berhasil disimpan');
                    
            } catch (\Exception $e) {
                return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
            }
        }
        
        // KASUS 2: SUDAH BAYAR PENDAFTARAN
        $request->validate([
            'paket_selanjutnya' => 'required|in:SD,SMP,SMA',
        ]);
        
        $hargaPaket = HargaPaket::where('tingkat', $request->paket_selanjutnya)->first();
        
        if (!$hargaPaket) {
            return redirect()->back()->withErrors(['error' => 'Harga paket tidak ditemukan']);
        }
        
        $hargaPerBulan = $hargaPaket->harga;
        
        $totalPiutangSebelumnya = Pembayaran::where('id_murid', $request->id_murid)->sum('total_piutang');
        $sisa_piutang = $totalPiutangSebelumnya - $request->total_pembayaran;
        $total_piutang = max(0, $sisa_piutang);
        $status_tagihan = $total_piutang > 0 ? 'Belum Lunas' : 'Lunas';
        
        try {
            Pembayaran::create([
                'id_murid' => $request->id_murid,
                'id_paket' => $hargaPaket->id_paket,
                'tanggal' => $request->tanggal,
                'paket_awal' => null,
                'paket_selanjutnya' => $request->paket_selanjutnya,
                'status_tagihan' => $status_tagihan,
                'total_piutang' => $total_piutang,
                'total_uang_muka' => 0,
                'total_pembayaran' => $request->total_pembayaran,
                'keterangan' => $request->keterangan,
            ]);
            
            if ($request->total_pembayaran >= $hargaPerBulan && $murid->pilihan_paket != $request->paket_selanjutnya) {
                $murid->update(['pilihan_paket' => $request->paket_selanjutnya]);
            }
            
            $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
            
            return redirect()->route($role . '.pembayaran')
                ->with('success', 'Data pembayaran berhasil disimpan');
            
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }
    
    public function getMuridPaket($id)
    {
        $murid = Murid::find($id);
        if ($murid) {
            return response()->json([
                'pilihan_paket' => $murid->pilihan_paket,
                'kelas' => $murid->kelas,
                'nama_lengkap_murid' => $murid->nama_lengkap_murid,
                'paket_awal' => $murid->paket_awal,
            ]);
        }
        return response()->json(['pilihan_paket' => ''], 404);
    }
    
    public function edit(Request $request, $id)
    {
        $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        $pembayaran = Pembayaran::findOrFail($id);
        $murids = Murid::orderBy('nama_lengkap_murid', 'asc')->get();
        $pakets = HargaPaket::all();
        
        return view('dashboard.shared.pembayaran.edit-pembayaran', [
            'role' => $role,
            'pembayaran' => $pembayaran,
            'murids' => $murids,
            'pakets' => $pakets,
        ]);
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_murid' => 'required|exists:ms_murid,id_murid',
            'tanggal' => 'required|date',
            'paket_selanjutnya' => 'required|in:SD,SMP,SMA',
            'total_pembayaran' => 'required|numeric|min:1000',
            'keterangan' => 'nullable|string|max:255',
        ]);
        
        $pembayaran = Pembayaran::findOrFail($id);
        $murid = Murid::find($request->id_murid);
        
        $hargaPaket = HargaPaket::where('tingkat', $request->paket_selanjutnya)->first();
        $hargaPerBulan = $hargaPaket ? $hargaPaket->harga : 120000;
        
        $pembayaranLain = Pembayaran::where('id_murid', $request->id_murid)
            ->where('id_pembayaran', '!=', $id)
            ->get();
        
        $totalBayarLain = $pembayaranLain->sum('total_pembayaran');
        $totalPiutangLain = $pembayaranLain->sum('total_piutang');
        
        if ($totalBayarLain == 0) {
            if ($request->total_pembayaran >= $hargaPerBulan) {
                $total_piutang = 0;
                $total_uang_muka = 0;
                $status_tagihan = 'Lunas';
            } else {
                $total_piutang = $hargaPerBulan - $request->total_pembayaran;
                $total_uang_muka = $request->total_pembayaran;
                $status_tagihan = 'Uang Muka';
            }
        } else {
            $sisa_piutang = $totalPiutangLain - $request->total_pembayaran;
            $total_piutang = max(0, $sisa_piutang);
            $total_uang_muka = 0;
            $status_tagihan = $total_piutang > 0 ? 'Belum Lunas' : 'Lunas';
        }
        
        try {
            $pembayaran->update([
                'id_murid' => $request->id_murid,
                'id_paket' => $hargaPaket ? $hargaPaket->id_paket : null,
                'tanggal' => $request->tanggal,
                'paket_awal' => $murid->pilihan_paket ?? $pembayaran->paket_awal,
                'paket_selanjutnya' => $request->paket_selanjutnya,
                'status_tagihan' => $status_tagihan,
                'total_piutang' => $total_piutang,
                'total_uang_muka' => $total_uang_muka,
                'total_pembayaran' => $request->total_pembayaran,
                'keterangan' => $request->keterangan,
            ]);
            
            $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
            
            return redirect()->route($role . '.pembayaran')
                ->with('success', 'Data pembayaran berhasil diperbarui');
                
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }
    
    public function destroy(Request $request, $id)
    {
        try {
            $pembayaran = Pembayaran::findOrFail($id);
            $pembayaran->delete();
            
            $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
            
            return redirect()->route($role . '.pembayaran')
                ->with('success', 'Data pembayaran berhasil dihapus');
                
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }
}