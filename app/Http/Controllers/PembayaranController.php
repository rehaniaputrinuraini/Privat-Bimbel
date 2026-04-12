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
                
                $hargaPaket = HargaPaket::where('tingkat', $murid->pilihan_paket)->first();
                $hargaPerBulan = $hargaPaket ? $hargaPaket->harga : 0;
                
                $pembayaranBulanan = $murid->pembayaran
                    ->whereNotNull('paket_selanjutnya')
                    ->whereNotNull('bulan_dibayar')
                    ->whereNotNull('tahun_dibayar');
                
                $pembayaranBulanIni = $pembayaranBulanan
                    ->where('bulan_dibayar', $currentMonth)
                    ->where('tahun_dibayar', $currentYear)
                    ->first();
                $status_pembayaran_bulan_ini = $pembayaranBulanIni ? 'Lunas' : 'Belum';
                
                $tunggakan = [];
                $totalPiutang = 0;
                
                for ($bulan = 1; $bulan <= $currentMonth; $bulan++) {
                    $tahun = $currentYear;
                    
                    $sudahBayar = $pembayaranBulanan
                        ->where('bulan_dibayar', $bulan)
                        ->where('tahun_dibayar', $tahun)
                        ->where('status_tagihan', 'lunas')
                        ->isNotEmpty();
                    
                    if (!$sudahBayar) {
                        $tunggakan[] = Carbon::create()->month($bulan)->translatedFormat('F');
                        $totalPiutang += $hargaPerBulan;
                    }
                }
                
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
                    $total_piutang = 'Rp ' . number_format($murid->paket_awal ?? 100000, 0, ',', '.');
                    $uang_muka = '-';
                }
                
                return (object)[
                    'id_murid' => $murid->id_murid,
                    'nama_murid' => $murid->nama_lengkap_murid,
                    'kelas' => $murid->kelas,
                    'paket' => $murid->pilihan_paket ?: '-',
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
                $nama_murid = $item->murid ? $item->murid->nama_lengkap_murid : 'Tidak Diketahui';
                $bulanDibayar = $item->bulan_dibayar 
                    ? Carbon::create()->month($item->bulan_dibayar)->translatedFormat('F') . ' ' . $item->tahun_dibayar
                    : '-';
                
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
    
    public function cekStatusPembayaran($id)
    {
        $murid = Murid::find($id);
        
        if (!$murid) {
            return response()->json(['error' => 'Murid tidak ditemukan'], 404);
        }
        
        $sudahBayarPendaftaran = Pembayaran::where('id_murid', $id)
            ->whereNull('paket_selanjutnya')
            ->exists();
        
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
                    'tahun_dibayar' => null,
                    'status_tagihan' => 'lunas',
                    'total_piutang' => 0,
                    'total_uang_muka' => 0,
                    'total_pembayaran' => $request->total_pembayaran,
                    'keterangan' => $request->keterangan ?: 'Pembayaran pendaftaran',
                ]);
                
                // CATAT KE LAPORAN KEUANGAN
                LaporanKeuangan::create([
                    'tanggal' => $request->tanggal,
                    'kategori' => 'pemasukan',
                    'rincian' => 'Pendaftaran - ' . $murid->nama_lengkap_murid,
                    'jumlah' => $request->total_pembayaran,
                    'nama_murid' => null,
                    'bulan_periode' => null,
                    'id_murid' => $request->id_murid
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
            return redirect()->back()->withErrors(['error' => 'Harga paket tidak ditemukan.']);
        }
        
        $hargaPerBulan = $hargaPaket->harga;
        $totalPembayaran = $request->total_pembayaran;
        $tahunDibayar = Carbon::now()->year;
        $bulanDibayar = $request->bulan_dibayar ?? Carbon::now()->month;
        $namaBulan = Carbon::create()->month($bulanDibayar)->translatedFormat('F') . ' ' . $tahunDibayar;
        
        // CEK APAKAH ADA PIUTANG SEBELUMNYA
        $piutangSebelumnya = LaporanKeuangan::where('id_murid', $request->id_murid)
            ->where('kategori', 'piutang')
            ->sum('jumlah');
        
        $sisaPembayaran = $totalPembayaran;
        
        // 1. BAYAR PIUTANG DULU JIKA ADA
        if ($piutangSebelumnya > 0 && $sisaPembayaran > 0) {
            $bayarPiutang = min($sisaPembayaran, $piutangSebelumnya);
            
            LaporanKeuangan::create([
                'tanggal' => $request->tanggal,
                'kategori' => 'piutang',
                'rincian' => 'Pelunasan Piutang - ' . $murid->nama_lengkap_murid,
                'jumlah' => $bayarPiutang,
                'nama_murid' => $murid->nama_lengkap_murid,
                'bulan_periode' => 'Pelunasan tunggakan',
                'id_murid' => $request->id_murid
            ]);
            
            $sisaPembayaran -= $bayarPiutang;
        }
        
        // 2. SISA PEMBAYARAN UNTUK BULAN BERJALAN
        if ($sisaPembayaran > 0) {
            if ($sisaPembayaran >= $hargaPerBulan) {
                $kelebihan = $sisaPembayaran - $hargaPerBulan;
                
                LaporanKeuangan::create([
                    'tanggal' => $request->tanggal,
                    'kategori' => 'pemasukan',
                    'rincian' => 'Pembayaran - ' . $murid->nama_lengkap_murid,
                    'jumlah' => $hargaPerBulan,
                    'nama_murid' => null,
                    'bulan_periode' => $namaBulan,
                    'id_murid' => $request->id_murid
                ]);
                
                if ($kelebihan > 0) {
                    LaporanKeuangan::create([
                        'tanggal' => $request->tanggal,
                        'kategori' => 'uang_muka',
                        'rincian' => 'Uang Muka - ' . $murid->nama_lengkap_murid,
                        'jumlah' => $kelebihan,
                        'nama_murid' => $murid->nama_lengkap_murid,
                        'bulan_periode' => 'Bulan depan',
                        'id_murid' => $request->id_murid
                    ]);
                }
                
                $total_piutang = 0;
                $total_uang_muka = $kelebihan;
                $status_tagihan = $kelebihan > 0 ? 'Uang Muka' : 'lunas';
                
            } else {
                LaporanKeuangan::create([
                    'tanggal' => $request->tanggal,
                    'kategori' => 'uang_muka',
                    'rincian' => 'Uang Muka - ' . $murid->nama_lengkap_murid,
                    'jumlah' => $sisaPembayaran,
                    'nama_murid' => $murid->nama_lengkap_murid,
                    'bulan_periode' => $namaBulan,
                    'id_murid' => $request->id_murid
                ]);
                
                $total_piutang = $hargaPerBulan - $sisaPembayaran;
                $total_uang_muka = $sisaPembayaran;
                $status_tagihan = 'Uang Muka';
            }
        } else {
            $total_piutang = 0;
            $total_uang_muka = 0;
            $status_tagihan = 'lunas';
        }
        
        // 3. HITUNG PIUTANG BULAN SEBELUMNYA YANG TERLEWAT
        $currentMonth = Carbon::now()->month;
        
        if ($bulanDibayar > $currentMonth) {
            for ($i = $currentMonth; $i < $bulanDibayar; $i++) {
                $bulanTerlewat = $i;
                $tahunTerlewat = Carbon::now()->year;
                
                $sudahBayar = Pembayaran::where('id_murid', $request->id_murid)
                    ->where('bulan_dibayar', $bulanTerlewat)
                    ->where('tahun_dibayar', $tahunTerlewat)
                    ->exists();
                
                if (!$sudahBayar && $i != $bulanDibayar) {
                    LaporanKeuangan::create([
                        'tanggal' => $request->tanggal,
                        'kategori' => 'piutang',
                        'rincian' => 'Piutang - ' . $murid->nama_lengkap_murid,
                        'jumlah' => $hargaPerBulan,
                        'nama_murid' => $murid->nama_lengkap_murid,
                        'bulan_periode' => Carbon::create()->month($bulanTerlewat)->translatedFormat('F Y'),
                        'id_murid' => $request->id_murid
                    ]);
                }
            }
        }
        
        // SIMPAN KE TABEL PEMBAYARAN
        Pembayaran::create([
            'id_murid' => $request->id_murid,
            'id_paket' => $hargaPaket->id_paket,
            'tanggal' => $request->tanggal,
            'paket_awal' => null,
            'paket_selanjutnya' => $request->paket_selanjutnya,
            'bulan_dibayar' => $bulanDibayar,
            'tahun_dibayar' => $tahunDibayar,
            'status_tagihan' => $status_tagihan,
            'total_piutang' => $total_piutang,
            'total_uang_muka' => $total_uang_muka,
            'total_pembayaran' => $totalPembayaran,
            'keterangan' => $request->keterangan,
        ]);
        
        // UPDATE PAKET MURID JIKA BERBEDA
        if ($murid->pilihan_paket != $request->paket_selanjutnya) {
            $murid->update(['pilihan_paket' => $request->paket_selanjutnya]);
        }
        
        $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        
        return redirect()->route($role . '.pembayaran')
            ->with('success', 'Data pembayaran berhasil disimpan');
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
        
        $hargaPaket = HargaPaket::where('tingkat', $request->paket_selanjutnya)->first();
        $hargaPerBulan = $hargaPaket ? $hargaPaket->harga : 0;
        
        if ($request->total_pembayaran >= $hargaPerBulan) {
            $kelebihan = $request->total_pembayaran - $hargaPerBulan;
            $total_piutang = 0;
            $total_uang_muka = $kelebihan;
            $status_tagihan = $kelebihan > 0 ? 'Uang Muka' : 'lunas';
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