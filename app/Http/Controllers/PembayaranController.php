<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Murid;
use App\Models\Pembayaran;
use App\Models\HargaPaket;
use App\Models\LaporanKeuangan;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PembayaranController extends Controller
{
    // Halaman utama pembayaran
    public function index(Request $request)
    {
        $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        
        // Ambil semua paket untuk dropdown filter
        $paketList = HargaPaket::orderBy('id_paket', 'asc')->get();
        
        $tagihan = Murid::with('pembayaran')
            ->select('ms_murid.*')
            ->get()
            ->map(function ($murid) {
                $total_bulan = '-';
                $total_piutang = '-';
                $uang_muka = '-';
                $tagihan_bulan = '-';
                
                // Ambil harga paket murid
                $hargaPaket = HargaPaket::where('tingkat', $murid->pilihan_paket)->first();
                $hargaPerBulan = $hargaPaket ? $hargaPaket->harga : 0;
                
                // Hitung total pembayaran bulanan (bukan pendaftaran)
                $pembayaranBulanan = $murid->pembayaran->whereNotNull('paket_selanjutnya');
                $totalDibayar = $pembayaranBulanan->sum('total_pembayaran');
                $totalUangMuka = $pembayaranBulanan->sum('total_uang_muka');
                
                // Hitung piutang
                $piutang = max(0, $hargaPerBulan - $totalDibayar);
                
                if ($piutang > 0) {
                    $total_piutang = 'Rp ' . number_format($piutang, 0, ',', '.');
                    $total_bulan = ceil($piutang / max($hargaPerBulan, 1));
                    
                    // Status Tagihan berdasarkan jumlah bulan tunggak
                    if ($total_bulan >= 3) {
                        $status_tagihan = 'Tunggak ' . $total_bulan . ' Bulan';
                    } else {
                        $status_tagihan = 'Tunggak ' . $total_bulan . ' Bulan';
                    }
                    
                    // Hitung tagihan bulan (bulan berapa yang sedang ditagih)
                    $lastPayment = $pembayaranBulanan->sortByDesc('tanggal')->first();
                    if ($lastPayment) {
                        $lastMonth = Carbon::parse($lastPayment->tanggal)->month;
                        $currentMonth = Carbon::now()->month;
                        $selisihBulan = $currentMonth - $lastMonth;
                        $tagihan_bulan = Carbon::now()->addMonths($selisihBulan > 0 ? 1 : 0)->translatedFormat('F');
                    } else {
                        $tagihan_bulan = Carbon::now()->translatedFormat('F');
                    }
                } elseif ($totalUangMuka > 0) {
                    $status_tagihan = 'Uang Muka';
                    $uang_muka = 'Rp ' . number_format($totalUangMuka, 0, ',', '.');
                    $tagihan_bulan = Carbon::now()->addMonth()->translatedFormat('F');
                } else {
                    $status_tagihan = 'Lunas';
                    $tagihan_bulan = Carbon::now()->translatedFormat('F');
                }
                
                // Status Pembayaran (Pendaftaran)
                $sudahBayarPendaftaran = $murid->pembayaran->whereNull('paket_selanjutnya')->isNotEmpty();
                $status_pembayaran = $sudahBayarPendaftaran ? 'Lunas' : 'Belum';
                
                return (object)[
                    'id_murid' => $murid->id_murid,
                    'nama_murid' => $murid->nama_lengkap_murid,
                    'kelas' => $murid->kelas,
                    'paket' => $murid->pilihan_paket ?: '-',
                    'status_pembayaran' => $status_pembayaran,
                    'status_tagihan' => $status_tagihan,
                    'tagihan_bulan' => $tagihan_bulan,
                    'total_bulan' => $total_bulan,
                    'total_piutang' => $total_piutang,
                    'uang_muka' => $uang_muka,
                ];
            });
        
        $riwayat = Pembayaran::with('murid')
            ->orderBy('tanggal', 'desc')
            ->get()
            ->map(function ($item) {
                $nama_murid = $item->murid ? $item->murid->nama_lengkap_murid : 'Tidak Diketahui';
                $bulanDibayar = $item->bulan_dibayar ? Carbon::create()->month($item->bulan_dibayar)->translatedFormat('F') : '-';
                
                return (object)[
                    'id_pembayaran' => $item->id_pembayaran,
                    'tanggal' => date('d/m/Y', strtotime($item->tanggal)),
                    'nama_murid' => $nama_murid,
                    'paket_awal' => is_numeric($item->paket_awal) ? 'Rp ' . number_format($item->paket_awal, 0, ',', '.') : ($item->paket_awal ?: '-'),
                    'paket_selanjutnya' => $item->paket_selanjutnya ?: '-',
                    'bulan_dibayar' => $bulanDibayar,
                    'total_bayar' => 'Rp ' . number_format($item->total_pembayaran, 0, ',', '.'),
                    'keterangan' => $item->keterangan ?: '-',
                ];
            });
        
        return view('dashboard.shared.pembayaran.pembayaran', [
            'role' => $role,
            'tagihan' => $tagihan,
            'riwayat' => $riwayat,
            'paketList' => $paketList,
        ]);
    }
    
    public function create(Request $request)
    {
        $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        $murids = Murid::orderBy('nama_lengkap_murid', 'asc')->get();
        $pakets = HargaPaket::orderBy('id_paket', 'asc')->get();
        
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
        
        // Ambil harga paket
        $hargaPaket = HargaPaket::where('tingkat', $murid->pilihan_paket)->first();
        $hargaPerBulan = $hargaPaket ? $hargaPaket->harga : 0;
        
        return response()->json([
            'sudah_bayar_pendaftaran' => $sudahBayarPendaftaran,
            'paket_awal' => $murid->paket_awal ?? 100000,
            'pilihan_paket' => $murid->pilihan_paket,
            'nama_murid' => $murid->nama_lengkap_murid,
            'kelas' => $murid->kelas,
            'harga_per_bulan' => $hargaPerBulan,
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
                    'bulan_dibayar' => null,
                    'status_tagihan' => 'Lunas',
                    'total_piutang' => 0,
                    'total_uang_muka' => 0,
                    'total_pembayaran' => $request->total_pembayaran,
                    'keterangan' => $request->keterangan ?: 'Pembayaran pendaftaran',
                ]);
                
                LaporanKeuangan::create([
                    'tanggal' => $request->tanggal,
                    'kategori' => 'pemasukan',
                    'rincian' => 'Pembayaran Pendaftaran - ' . $murid->nama_lengkap_murid,
                    'jumlah' => $request->total_pembayaran,
                    'nama_murid' => $murid->nama_lengkap_murid,
                    'bulan_periode' => null
                ]);
                
                $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
                
                return redirect()->route($role . '.pembayaran')
                    ->with('success', 'Pembayaran pendaftaran berhasil disimpan');
                    
            } catch (\Exception $e) {
                return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
            }
        }
        
        // KASUS 2: SUDAH BAYAR PENDAFTARAN - PEMBAYARAN BULANAN
        $request->validate([
            'paket_selanjutnya' => 'required|string',
            'bulan_dibayar' => 'nullable|integer|min:1|max:12',
        ]);
        
        $hargaPaket = HargaPaket::where('tingkat', $request->paket_selanjutnya)->first();
        
        if (!$hargaPaket) {
            return redirect()->back()->withErrors(['error' => 'Harga paket tidak ditemukan. Silakan setup harga paket terlebih dahulu.']);
        }
        
        $hargaPerBulan = $hargaPaket->harga;
        $totalPembayaran = $request->total_pembayaran;
        
        // Hitung status
        if ($totalPembayaran >= $hargaPerBulan) {
            // Lunas atau lebih (uang muka untuk bulan depan)
            $kelebihan = $totalPembayaran - $hargaPerBulan;
            $total_piutang = 0;
            $total_uang_muka = $kelebihan;
            $status_tagihan = $kelebihan > 0 ? 'Uang Muka' : 'Lunas';
        } else {
            // Uang muka (kurang)
            $total_piutang = $hargaPerBulan - $totalPembayaran;
            $total_uang_muka = $totalPembayaran;
            $status_tagihan = 'Uang Muka';
        }
        
        try {
            Pembayaran::create([
                'id_murid' => $request->id_murid,
                'id_paket' => $hargaPaket->id_paket,
                'tanggal' => $request->tanggal,
                'paket_awal' => null,
                'paket_selanjutnya' => $request->paket_selanjutnya,
                'bulan_dibayar' => $request->bulan_dibayar,
                'status_tagihan' => $status_tagihan,
                'total_piutang' => $total_piutang,
                'total_uang_muka' => $total_uang_muka,
                'total_pembayaran' => $totalPembayaran,
                'keterangan' => $request->keterangan,
            ]);
            
            $rincianLaporan = 'Pembayaran Bulanan ' . $murid->nama_lengkap_murid . ' - Paket ' . $request->paket_selanjutnya;
            LaporanKeuangan::create([
                'tanggal' => $request->tanggal,
                'kategori' => 'pemasukan',
                'rincian' => $rincianLaporan,
                'jumlah' => $totalPembayaran,
                'nama_murid' => $murid->nama_lengkap_murid,
                'bulan_periode' => $request->bulan_dibayar ? Carbon::create()->month($request->bulan_dibayar)->translatedFormat('F Y') : Carbon::parse($request->tanggal)->translatedFormat('F Y')
            ]);
            
            // Update pilihan_paket murid jika berbeda
            if ($murid->pilihan_paket != $request->paket_selanjutnya) {
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
        $pakets = HargaPaket::orderBy('id_paket', 'asc')->get();
        
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
            'paket_selanjutnya' => 'required|string',
            'total_pembayaran' => 'required|numeric|min:1000',
            'keterangan' => 'nullable|string|max:255',
        ]);
        
        $pembayaran = Pembayaran::findOrFail($id);
        $murid = Murid::find($request->id_murid);
        
        $hargaPaket = HargaPaket::where('tingkat', $request->paket_selanjutnya)->first();
        $hargaPerBulan = $hargaPaket ? $hargaPaket->harga : 0;
        
        if ($request->total_pembayaran >= $hargaPerBulan) {
            $kelebihan = $request->total_pembayaran - $hargaPerBulan;
            $total_piutang = 0;
            $total_uang_muka = $kelebihan;
            $status_tagihan = $kelebihan > 0 ? 'Uang Muka' : 'Lunas';
        } else {
            $total_piutang = $hargaPerBulan - $request->total_pembayaran;
            $total_uang_muka = $request->total_pembayaran;
            $status_tagihan = 'Uang Muka';
        }
        
        try {
            $pembayaran->update([
                'id_murid' => $request->id_murid,
                'id_paket' => $hargaPaket ? $hargaPaket->id_paket : null,
                'tanggal' => $request->tanggal,
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