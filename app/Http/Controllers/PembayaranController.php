<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Murid;
use App\Models\Pembayaran;
use App\Models\HargaPaket;
use App\Models\TransaksiPaket;
use App\Models\TransaksiKelas;
use App\Models\TransaksiUmum;
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
        
        // AMBIL SEMUA MURID
        $murids = Murid::all();
        
        $tagihan = collect();
        
        foreach ($murids as $murid) {
            // Ambil kelas terbaru
            $kelasTerbaru = TransaksiKelas::where('id_murid', $murid->id_murid)
                ->orderBy('created_at', 'desc')
                ->first();
            $namaKelas = '-';
            if ($kelasTerbaru) {
                $kelas = \App\Models\Kelas::find($kelasTerbaru->id_kelas);
                $namaKelas = $kelas ? $kelas->nama_kelas : '-';
            }
            
            // Ambil paket aktif
            $paketAktif = TransaksiPaket::where('id_murid', $murid->id_murid)
                ->orderBy('created_at', 'desc')
                ->first();
            $namaPaket = '-';
            $hargaPerBulan = 0;
            if ($paketAktif) {
                $paket = HargaPaket::find($paketAktif->id_paket);
                if ($paket) {
                    $namaPaket = $paket->tingkat;
                    $hargaPerBulan = $paket->harga;
                }
            }
            
            // Cek sudah bayar pendaftaran
            $sudahBayarPendaftaran = Pembayaran::where('id_murid', $murid->id_murid)
                ->whereNull('paket_selanjutnya')
                ->exists();
            $statusPendaftaran = $sudahBayarPendaftaran ? 'Lunas' : 'Belum';
            
            // Cek pembayaran bulan ini
            $pembayaranBulanIni = Pembayaran::where('id_murid', $murid->id_murid)
                ->whereNotNull('paket_selanjutnya')
                ->where('bulan_dibayar', $currentMonth)
                ->where('tahun_dibayar', $currentYear)
                ->first();
            
            // AMBIL SEMUA PEMBAYARAN BULANAN MURID INI + RELASI ms_transaksi
            $semuaPembayaranBulanan = Pembayaran::where('id_murid', $murid->id_murid)
                ->whereNotNull('paket_selanjutnya')
                ->with('transaksiUmum')
                ->get();
            
            // HITUNG UANG MUKA: kategori = 'uang_muka' di ms_transaksi
            $totalUangMuka = 0;
            $uangMukaBulanList = [];
            
            foreach ($semuaPembayaranBulanan as $pemb) {
                // CEK KATEGORI DARI ms_transaksi
                $kategori = $pemb->transaksiUmum->kategori ?? null;
                
                if ($kategori == 'uang_muka') {
                    // PRIORITAS: pakai total_uang_muka, kalau 0 pakai total_pembayaran
                    if ($pemb->total_uang_muka > 0) {
                        $totalUangMuka += $pemb->total_uang_muka;
                    } else {
                        $totalUangMuka += $pemb->total_pembayaran;
                    }
                    
                    // SIMPAN BULAN UANG MUKA
                    $bulanUangMuka = Carbon::create()->month($pemb->bulan_dibayar)->translatedFormat('F');
                    $tahunUangMuka = $pemb->tahun_dibayar;
                    $uangMukaBulanList[] = $bulanUangMuka . ' ' . $tahunUangMuka;
                }
            }
            
            // HITUNG PIUTANG: kategori = 'piutang' di ms_transaksi
            $totalPiutang = 0;
            
            foreach ($semuaPembayaranBulanan as $pemb) {
                $kategori = $pemb->transaksiUmum->kategori ?? null;
                
                if ($kategori == 'piutang' && $pemb->total_piutang > 0) {
                    $totalPiutang += $pemb->total_piutang;
                }
            }
            
            // Jika tidak ada piutang dari kategori, cek tunggakan dari status_tagihan
            if ($totalPiutang == 0) {
                $totalPiutang = Pembayaran::where('id_murid', $murid->id_murid)
                    ->whereNotNull('paket_selanjutnya')
                    ->where(function($q) use ($currentMonth, $currentYear) {
                        $q->where('tahun_dibayar', '<', $currentYear)
                          ->orWhere(function($q2) use ($currentMonth, $currentYear) {
                              $q2->where('tahun_dibayar', $currentYear)
                                 ->where('bulan_dibayar', '<', $currentMonth);
                          });
                    })
                    ->where('status_tagihan', 'tunggak')
                    ->sum('total_piutang');
            }
            
            $statusPembayaran = '-';
            $statusTagihan = '-';
            $tagihanBulan = '-';
            $totalPiutangDisplay = '-';
            $uangMukaDisplay = '-';
            
            if (!$sudahBayarPendaftaran) {
                // BELUM BAYAR PENDAFTARAN
                $statusTagihan = 'Belum Daftar';
                $tagihanBulan = 'Pendaftaran';
                $totalPiutangDisplay = 'Rp 100.000';
                $uangMukaDisplay = '-';
                $statusPembayaran = '-';
            } elseif ($totalUangMuka > 0) {
                // ADA UANG MUKA (DARI KATEGORI ms_transaksi)
                $statusPembayaran = 'Lunas';
                $statusTagihan = 'Uang Muka';
                
                if (!empty($uangMukaBulanList)) {
                    $tagihanBulan = implode(', ', $uangMukaBulanList);
                } else {
                    $tagihanBulan = '-';
                }
                
                $totalPiutangDisplay = '-';
                $uangMukaDisplay = 'Rp ' . number_format($totalUangMuka, 0, ',', '.');
                
            } elseif ($totalPiutang > 0) {
                // ADA TUNGGAKAN
                $statusPembayaran = 'Belum';
                $statusTagihan = 'Tunggak';
                $tagihanBulan = Carbon::create()->month($currentMonth)->translatedFormat('F') . ' ' . $currentYear;
                $totalPiutangDisplay = 'Rp ' . number_format($totalPiutang, 0, ',', '.');
                $uangMukaDisplay = '-';
                
            } elseif ($pembayaranBulanIni) {
                // LUNAS BULAN INI
                $statusPembayaran = 'Lunas';
                $statusTagihan = 'Lunas';
                $tagihanBulan = '-';
                $totalPiutangDisplay = '-';
                $uangMukaDisplay = '-';
                
            } else {
                // BELUM BAYAR BULAN INI
                $statusPembayaran = 'Belum';
                $statusTagihan = 'Tunggak';
                $tagihanBulan = Carbon::create()->month($currentMonth)->translatedFormat('F') . ' ' . $currentYear;
                $totalPiutangDisplay = 'Rp ' . number_format($hargaPerBulan, 0, ',', '.');
                $uangMukaDisplay = '-';
            }
            
            $tagihan->push((object)[
                'id_murid' => $murid->id_murid,
                'nama_murid' => $murid->nama_lengkap,
                'kelas' => $namaKelas,
                'paket' => $namaPaket,
                'status_pendaftaran' => $statusPendaftaran,
                'status_pembayaran' => $statusPembayaran,
                'status_tagihan' => $statusTagihan,
                'tagihan_bulan' => $tagihanBulan,
                'total_piutang' => $totalPiutangDisplay,
                'uang_muka' => $uangMukaDisplay,
            ]);
        }
        
        // Riwayat
        $riwayat = Pembayaran::with(['murid', 'transaksiUmum'])
            ->orderBy('tanggal', 'desc')
            ->get()
            ->map(function ($item) {
                $nama_murid = $item->murid ? $item->murid->nama_lengkap : 'Tidak Diketahui';
                $bulanDibayar = $item->bulan_dibayar 
                    ? Carbon::create()->month($item->bulan_dibayar)->translatedFormat('F') . ' ' . $item->tahun_dibayar
                    : '-';
                
                $keterangan = $item->paket_selanjutnya == null 
                    ? 'Pembayaran Pendaftaran' 
                    : 'Pembayaran SPP';
                
                $jenisPembayaran = $item->transaksiUmum ? $item->transaksiUmum->jenis_pembayaran : '-';
                
                return (object)[
                    'id_pembayaran' => $item->id_pembayaran,
                    'tanggal' => $item->tanggal ? date('d/m/Y', strtotime($item->tanggal)) : '-',
                    'nama_murid' => $nama_murid,
                    'paket_awal' => $item->paket_awal ? 'Rp ' . number_format($item->paket_awal, 0, ',', '.') : '-',
                    'paket_selanjutnya' => $item->paket_selanjutnya ?: '-',
                    'bulan_dibayar' => $bulanDibayar,
                    'jenis_pembayaran' => $jenisPembayaran,
                    'total_bayar' => 'Rp ' . number_format($item->total_pembayaran ?? 0, 0, ',', '.'),
                    'keterangan' => $keterangan,
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
            'jenis_pembayaran' => 'required|in:Tunai,Transfer',
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
            $idTransaksi = TransaksiUmum::create([
                'tanggal_bayar' => $request->tanggal,
                'bulan' => $request->tanggal,
                'jenis_pembayaran' => $request->jenis_pembayaran,
                'kategori' => 'pemasukan',
                'status_bayar' => 'Sudah',
                'keterangan' => 'Pembayaran Pendaftaran - ' . $murid->nama_lengkap,
            ])->id_transaksi;
            
            Pembayaran::create([
                'id_murid' => $request->id_murid,
                'id_paket' => null,
                'id_transaksi' => $idTransaksi,
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
        }
        
        // KASUS 2: PEMBAYARAN BULANAN
        $request->validate([
            'paket_selanjutnya' => 'required|string',
            'bulan_dibayar' => 'nullable|integer|min:1|max:12',
        ]);
        
        $hargaPaket = HargaPaket::where('tingkat', $request->paket_selanjutnya)->first();
        
        if (!$hargaPaket) {
            return redirect()->back()->withErrors(['error' => 'Harga paket tidak ditemukan.']);
        }
        
        $hargaPerBulan = $hargaPaket->harga;
        $jumlahDibayar = $request->total_pembayaran;
        $tahunDibayar = Carbon::now()->year;
        $bulanDibayar = $request->bulan_dibayar ?? Carbon::now()->month;
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        
        // Cek double payment
        $sudahLunas = Pembayaran::where('id_murid', $request->id_murid)
            ->whereNotNull('paket_selanjutnya')
            ->where('bulan_dibayar', $bulanDibayar)
            ->where('tahun_dibayar', $tahunDibayar)
            ->where('status_tagihan', 'lunas')
            ->exists();
        
        if ($sudahLunas) {
            $namaBulan = Carbon::create()->month($bulanDibayar)->translatedFormat('F');
            return redirect()->back()
                ->withErrors(['error' => "Murid ini SUDAH LUNAS untuk bulan $namaBulan $tahunDibayar!"])
                ->withInput();
        }
        
        // Tentukan kategori dan nilai yang akan disimpan
        if ($bulanDibayar > $currentMonth && $tahunDibayar == $currentYear) {
            // ✅ BULAN DEPAN = UANG MUKA
            $kategori = 'uang_muka';
            $status_tagihan = 'uang_muka';
            $total_pembayaran = 0;
            $total_uang_muka = $jumlahDibayar;
            $total_piutang = 0;
            
        } elseif ($bulanDibayar < $currentMonth && $tahunDibayar == $currentYear) {
            // ✅ BULAN LALU = PIUTANG/TUNGGAKAN
            $kategori = 'piutang';
            $status_tagihan = 'tunggak';
            $total_pembayaran = 0;
            $total_uang_muka = $jumlahDibayar;
            $total_piutang = $hargaPerBulan - $jumlahDibayar;
            
        } else {
            // ✅ BULAN INI = NORMAL
            $kategori = 'pemasukan';
            
            if ($jumlahDibayar >= $hargaPerBulan) {
                // Bayar penuh atau lebih
                $status_tagihan = 'lunas';
                $total_pembayaran = $hargaPerBulan;
                $total_uang_muka = $jumlahDibayar - $hargaPerBulan;
                $total_piutang = 0;
                
                if ($total_uang_muka > 0) {
                    $kategori = 'uang_muka';
                }
            } else {
                // Bayar kurang
                $status_tagihan = 'tunggak';
                $total_pembayaran = $jumlahDibayar;
                $total_uang_muka = 0;
                $total_piutang = $hargaPerBulan - $jumlahDibayar;
                $kategori = 'piutang';
            }
        }
        
        // Insert ke ms_transaksi
        $namaBulan = Carbon::create()->month($bulanDibayar)->translatedFormat('F');
        $idTransaksi = TransaksiUmum::create([
            'tanggal_bayar' => $request->tanggal,
            'bulan' => $request->tanggal,
            'jenis_pembayaran' => $request->jenis_pembayaran,
            'kategori' => $kategori,
            'status_bayar' => 'Sudah',
            'keterangan' => 'Pembayaran SPP ' . $namaBulan . ' ' . $tahunDibayar . ' - ' . $murid->nama_lengkap,
        ])->id_transaksi;
        
        // INSERT KE tr_transaksi
        Pembayaran::create([
            'id_murid' => $request->id_murid,
            'id_paket' => $hargaPaket->id_paket,
            'id_transaksi' => $idTransaksi,
            'tanggal' => $request->tanggal,
            'paket_awal' => null,
            'paket_selanjutnya' => $request->paket_selanjutnya,
            'bulan_dibayar' => $bulanDibayar,
            'tahun_dibayar' => $tahunDibayar,
            'status_tagihan' => $status_tagihan,
            'total_piutang' => $total_piutang,
            'total_uang_muka' => $total_uang_muka,
            'total_pembayaran' => $total_pembayaran,
        ]);
        
        $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        
        return redirect()->route($role . '.pembayaran')
            ->with('success', 'Data pembayaran berhasil disimpan');
    }
    
    public function destroy(Request $request, $id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        
        if ($pembayaran->id_transaksi) {
            TransaksiUmum::where('id_transaksi', $pembayaran->id_transaksi)->delete();
        }
        
        $pembayaran->delete();
        
        $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        
        return redirect()->route($role . '.pembayaran')
            ->with('success', 'Data pembayaran berhasil dihapus');
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
        
        $paketAktif = TransaksiPaket::where('id_murid', $id)
            ->orderBy('created_at', 'desc')
            ->first();
        
        $paketTingkat = null;
        if ($paketAktif) {
            $paket = HargaPaket::find($paketAktif->id_paket);
            if ($paket) {
                $paketTingkat = $paket->tingkat;
            }
        }
        
        $bulanTunggakan = null;
        if ($sudahBayarPendaftaran) {
            $currentMonth = Carbon::now()->month;
            $currentYear = Carbon::now()->year;
            
            $pembayaranBulanan = Pembayaran::where('id_murid', $id)
                ->whereNotNull('paket_selanjutnya')
                ->where('bulan_dibayar', $currentMonth)
                ->where('tahun_dibayar', $currentYear)
                ->exists();
            
            if (!$pembayaranBulanan) {
                $bulanTunggakan = $currentMonth;
            }
        }
        
        return response()->json([
            'sudah_bayar_pendaftaran' => $sudahBayarPendaftaran,
            'paket_awal' => 100000,
            'paket_aktif' => $paketTingkat,
            'bulan_tunggakan' => $bulanTunggakan,
        ]);
    }
}