<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Murid;
use App\Models\Pembayaran;
use App\Models\HargaPaket;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PembayaranController extends Controller
{
    // Halaman utama pembayaran
    public function index(Request $request)
    {
        $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        $paketList = HargaPaket::orderBy('id_paket', 'asc')->get();
        
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        
        $tagihan = Murid::with(['pembayaran' => function($q) {
                $q->orderBy('tanggal', 'desc');
            }])
            ->get()
            ->map(function ($murid) use ($currentMonth, $currentYear) {
                
                $sudahBayarPendaftaran = $murid->pembayaran
                    ->whereNull('paket_selanjutnya')
                    ->isNotEmpty();
                $status_pendaftaran = $sudahBayarPendaftaran ? 'Lunas' : 'Belum';
                
                // Placeholder karena paket belum terintegrasi penuh
                $hargaPerBulan = 0;
                
                $pembayaranBulanan = $murid->pembayaran
                    ->whereNotNull('paket_selanjutnya')
                    ->whereNotNull('bulan_dibayar')
                    ->whereNotNull('tahun_dibayar');
                
                $pembayaranBulanIni = $pembayaranBulanan
                    ->where('bulan_dibayar', $currentMonth)
                    ->where('tahun_dibayar', $currentYear)
                    ->first();
                $status_pembayaran_bulan_ini = $pembayaranBulanIni ? 'Lunas' : 'Belum';
                
                // Hitung tunggakan
                $tunggakan = [];
                $totalPiutang = 0;

                if ($murid->tanggal_daftar) {
                    $tanggalDaftar = Carbon::parse($murid->tanggal_daftar);
                    $bulanMulai = $tanggalDaftar->month;
                    $tahunMulai = $tanggalDaftar->year;
                } else {
                    $bulanMulai = 1;
                    $tahunMulai = $currentYear;
                }

                for ($tahun = $tahunMulai; $tahun <= $currentYear; $tahun++) {
                    $bulanAwal = ($tahun == $tahunMulai) ? $bulanMulai : 1;
                    $bulanAkhir = ($tahun == $currentYear) ? $currentMonth : 12;
                    
                    for ($bulan = $bulanAwal; $bulan <= $bulanAkhir; $bulan++) {
                        $sudahBayar = $pembayaranBulanan
                            ->where('bulan_dibayar', $bulan)
                            ->where('tahun_dibayar', $tahun)
                            ->where('status_tagihan', 'lunas')
                            ->isNotEmpty();
                        
                        if (!$sudahBayar) {
                            $tunggakan[] = Carbon::create()->month($bulan)->translatedFormat('F') . ' ' . $tahun;
                            $totalPiutang += $hargaPerBulan;
                        }
                    }
                }
                
                // Hitung uang muka
                $uangMukaBulan = [];
                $totalUangMuka = 0;
                
                for ($bulan = $currentMonth + 1; $bulan <= 12; $bulan++) {
                    $tahun = $currentYear;
                    
                    $bayarDulu = $pembayaranBulanan
                        ->where('bulan_dibayar', $bulan)
                        ->where('tahun_dibayar', $tahun)
                        ->whereIn('status_tagihan', ['lunas', 'Uang Muka'])
                        ->first();
                    
                    if ($bayarDulu) {
                        $uangMukaBulan[] = Carbon::create()->month($bulan)->translatedFormat('F');
                        $totalUangMuka += $bayarDulu->total_pembayaran;
                    }
                }
                
                // Tentukan status tagihan
                if (count($tunggakan) > 0) {
                    $status_tagihan = 'Tunggak';
                    $tagihan_bulan = implode(', ', $tunggakan);
                    $total_piutang = 'Rp ' . number_format($totalPiutang, 0, ',', '.');
                    $uang_muka = '-';
                } elseif (count($uangMukaBulan) > 0) {
                    $status_tagihan = 'Uang Muka';
                    $tagihan_bulan = implode(', ', $uangMukaBulan);
                    $total_piutang = '-';
                    $uang_muka = 'Rp ' . number_format($totalUangMuka, 0, ',', '.');
                } else {
                    $status_tagihan = 'Lunas';
                    $tagihan_bulan = '-';
                    $total_piutang = '-';
                    $uang_muka = '-';
                }
                
                if (!$sudahBayarPendaftaran) {
                    $status_pembayaran_bulan_ini = '-';
                    $status_tagihan = '-';
                    $tagihan_bulan = '-';
                    $total_piutang = 'Rp ' . number_format(100000, 0, ',', '.');
                    $uang_muka = '-';
                }
                
                return (object)[
                    'id_murid' => $murid->id_murid,
                    'nama_murid' => $murid->nama_lengkap,
                    'paket' => '-',
                    'status_pendaftaran' => $status_pendaftaran,
                    'status_pembayaran' => $status_pembayaran_bulan_ini,
                    'status_tagihan' => $status_tagihan,
                    'tagihan_bulan' => $tagihan_bulan,
                    'total_piutang' => $total_piutang,
                    'uang_muka' => $uang_muka,
                ];
            });
        
        $riwayat = Pembayaran::with('murid')
            ->orderBy('tanggal', 'desc')
            ->get()
            ->map(function ($item) {
                $nama_murid = $item->murid ? $item->murid->nama_lengkap : 'Tidak Diketahui';
                $bulanDibayar = $item->bulan_dibayar 
                    ? Carbon::create()->month($item->bulan_dibayar)->translatedFormat('F') . ' ' . $item->tahun_dibayar
                    : '-';
                
                return (object)[
                    'id_pembayaran' => $item->id_pembayaran,
                    'tanggal' => $item->tanggal ? date('d/m/Y', strtotime($item->tanggal)) : '-',
                    'nama_murid' => $nama_murid,
                    'paket_awal' => $item->paket_awal ? 'Rp ' . number_format($item->paket_awal, 0, ',', '.') : '-',
                    'paket_selanjutnya' => $item->paket_selanjutnya ?: '-',
                    'bulan_dibayar' => $bulanDibayar,
                    'total_bayar' => 'Rp ' . number_format($item->total_pembayaran ?? 0, 0, ',', '.'),
                    'keterangan' => '-',
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
        $murids = Murid::orderBy('nama_lengkap', 'asc')->get();
        $pakets = HargaPaket::orderBy('id_paket', 'asc')->get();
        
        return view('dashboard.shared.pembayaran.create-pembayaran', [
            'role' => $role,
            'murids' => $murids,
            'pakets' => $pakets,
        ]);
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'id_murid' => 'required|exists:ms_murid,id_murid',
            'tanggal' => 'required|date',
            'total_pembayaran' => 'required|numeric|min:1000',
        ]);
        
        $murid = Murid::find($request->id_murid);
        
        if (!$murid) {
            return redirect()->back()->withErrors(['error' => 'Data murid tidak ditemukan']);
        }
        
        $sudahBayarPendaftaran = Pembayaran::where('id_murid', $request->id_murid)
            ->whereNull('paket_selanjutnya')
            ->exists();
        
        // KASUS 1: BELUM BAYAR PENDAFTARAN
        if (!$sudahBayarPendaftaran) {
            try {
                Pembayaran::create([
                    'id_murid' => $request->id_murid,
                    'id_paket' => null,
                    'id_transaksi' => null,
                    'tanggal' => $request->tanggal,
                    'paket_awal' => 100000,
                    'paket_selanjutnya' => null,
                    'bulan_dibayar' => null,
                    'tahun_dibayar' => null,
                    'status_tagihan' => 'lunas',
                    'total_piutang' => 0,
                    'total_uang_muka' => 0,
                    'total_pembayaran' => $request->total_pembayaran,
                ]);
                
                $murid->update(['tanggal_daftar' => $request->tanggal]);
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
            return redirect()->back()->withErrors(['error' => 'Harga paket tidak ditemukan.']);
        }
        
        $hargaPerBulan = $hargaPaket->harga;
        $totalPembayaran = $request->total_pembayaran;
        $tahunDibayar = Carbon::now()->year;
        $bulanDibayar = $request->bulan_dibayar ?? Carbon::now()->month;
        
        $total_piutang = 0;
        $total_uang_muka = 0;
        $status_tagihan = 'lunas';
        
        if ($totalPembayaran >= $hargaPerBulan) {
            $total_uang_muka = $totalPembayaran - $hargaPerBulan;
            $status_tagihan = $total_uang_muka > 0 ? 'uang_muka' : 'lunas';
        } else {
            $total_piutang = $hargaPerBulan - $totalPembayaran;
            $total_uang_muka = $totalPembayaran;
            $status_tagihan = 'uang_muka';
        }
        
        Pembayaran::create([
            'id_murid' => $request->id_murid,
            'id_paket' => $hargaPaket->id_paket,
            'id_transaksi' => null,
            'tanggal' => $request->tanggal,
            'paket_awal' => null,
            'paket_selanjutnya' => $request->paket_selanjutnya,
            'bulan_dibayar' => $bulanDibayar,
            'tahun_dibayar' => $tahunDibayar,
            'status_tagihan' => $status_tagihan,
            'total_piutang' => $total_piutang,
            'total_uang_muka' => $total_uang_muka,
            'total_pembayaran' => $totalPembayaran,
        ]);
        
        $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        
        return redirect()->route($role . '.pembayaran')
            ->with('success', 'Data pembayaran berhasil disimpan');
    }
    
    public function getMuridPaket($id)
    {
        $murid = Murid::find($id);
        if ($murid) {
            return response()->json([
                'nama_lengkap' => $murid->nama_lengkap,
            ]);
        }
        return response()->json([], 404);
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