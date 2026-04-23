<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Murid;
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
            $sudahBayarPendaftaran = TransaksiUmum::where('id_murid', $murid->id_murid)
                ->where('keterangan', 'like', '%Pendaftaran%')
                ->exists();
            $statusPendaftaran = $sudahBayarPendaftaran ? 'Lunas' : 'Belum';
            
            // Ambil semua pembayaran SPP murid ini
            $semuaPembayaranSPP = TransaksiUmum::where('id_murid', $murid->id_murid)
                ->where('keterangan', 'like', '%SPP%')
                ->orderBy('tanggal_bayar', 'desc')
                ->get();
            
            // Cek pembayaran bulan ini
            $pembayaranBulanIni = $semuaPembayaranSPP->filter(function($item) use ($currentMonth, $currentYear) {
                // Cek dari keterangan
                preg_match('/SPP\s+(\w+)\s+(\d+)/', $item->keterangan, $matches);
                if (isset($matches[1]) && isset($matches[2])) {
                    try {
                        $bulanDibayar = Carbon::parse($matches[1])->month;
                        $tahunDibayar = (int)$matches[2];
                        return $bulanDibayar == $currentMonth && $tahunDibayar == $currentYear;
                    } catch (\Exception $e) {
                        return false;
                    }
                }
                return false;
            })->first();
            
            // Hitung Uang Muka (pembayaran untuk bulan depan)
            $totalUangMuka = 0;
            $uangMukaBulanList = [];
            
            // Hitung Piutang (tunggakan bulan lalu)
            $totalPiutang = 0;
            $piutangBulanList = [];
            
            foreach ($semuaPembayaranSPP as $pemb) {
                preg_match('/SPP\s+(\w+)\s+(\d+)/', $pemb->keterangan, $matches);
                if (isset($matches[1]) && isset($matches[2])) {
                    try {
                        $bulanDibayar = Carbon::parse($matches[1])->month;
                        $tahunDibayar = (int)$matches[2];
                        $bulanTahun = $matches[1] . ' ' . $matches[2];
                        
                        // Bulan depan = UANG MUKA
                        if ($tahunDibayar > $currentYear || 
                            ($tahunDibayar == $currentYear && $bulanDibayar > $currentMonth)) {
                            $totalUangMuka += $pemb->debit;
                            $uangMukaBulanList[] = $bulanTahun;
                        }
                        
                        // Bulan lalu = PIUTANG (jika kurang dari harga paket)
                        if ($tahunDibayar < $currentYear || 
                            ($tahunDibayar == $currentYear && $bulanDibayar < $currentMonth)) {
                            $kekurangan = $hargaPerBulan - $pemb->debit;
                            if ($kekurangan > 0) {
                                $totalPiutang += $kekurangan;
                                $piutangBulanList[] = $bulanTahun;
                            }
                        }
                    } catch (\Exception $e) {
                        continue;
                    }
                }
            }
            
            // Jika ada bulan yang belum dibayar sama sekali
            $bulanBelumDibayar = [];
            for ($i = 1; $i < $currentMonth; $i++) {
                $bulanTahun = Carbon::create()->month($i)->translatedFormat('F') . ' ' . $currentYear;
                $sudahDibayar = false;
                
                foreach ($semuaPembayaranSPP as $pemb) {
                    if (str_contains($pemb->keterangan, $bulanTahun)) {
                        $sudahDibayar = true;
                        break;
                    }
                }
                
                if (!$sudahDibayar) {
                    $bulanBelumDibayar[] = $bulanTahun;
                    $totalPiutang += $hargaPerBulan;
                }
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
                // ADA UANG MUKA
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
                
                $allBulan = array_merge($piutangBulanList, $bulanBelumDibayar);
                if (!empty($allBulan)) {
                    $tagihanBulan = implode(', ', array_unique($allBulan));
                } else {
                    $tagihanBulan = Carbon::create()->month($currentMonth)->translatedFormat('F') . ' ' . $currentYear;
                }
                
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
        
        // Riwayat - Ambil dari ms_transaksi
        $riwayat = TransaksiUmum::with('murid')
            ->orderBy('tanggal_bayar', 'desc')
            ->get()
            ->map(function ($item) {
                $nama_murid = $item->murid ? $item->murid->nama_lengkap : 'Tidak Diketahui';
                
                // Tentukan jenis transaksi dari keterangan
                $isPendaftaran = str_contains($item->keterangan, 'Pendaftaran');
                $isSPP = str_contains($item->keterangan, 'SPP');
                
                // Extract bulan dari keterangan SPP
                $bulanDibayar = '-';
                $paketSelanjutnya = '-';
                
                if ($isSPP) {
                    preg_match('/SPP\s+(\w+)\s+(\d+)/', $item->keterangan, $matches);
                    if (isset($matches[1]) && isset($matches[2])) {
                        $bulanDibayar = $matches[1] . ' ' . $matches[2];
                    }
                    
                    // Ambil paket dari transaksi paket
                    $paketAktif = TransaksiPaket::where('id_murid', $item->id_murid)->first();
                    if ($paketAktif) {
                        $paket = HargaPaket::find($paketAktif->id_paket);
                        if ($paket) {
                            $paketSelanjutnya = $paket->tingkat;
                        }
                    }
                }
                
                return (object)[
                    'id_pembayaran' => $item->id_transaksi,
                    'tanggal' => $item->tanggal_bayar ? date('d/m/Y', strtotime($item->tanggal_bayar)) : '-',
                    'nama_murid' => $nama_murid,
                    'paket_awal' => $isPendaftaran ? 'Rp 100.000' : '-',
                    'paket_selanjutnya' => $paketSelanjutnya,
                    'bulan_dibayar' => $bulanDibayar,
                    'jenis_pembayaran' => $item->jenis_pembayaran ?? '-',
                    'total_bayar' => 'Rp ' . number_format($item->debit ?? 0, 0, ',', '.'),
                    'keterangan' => $isPendaftaran ? 'Pembayaran Pendaftaran' : ($isSPP ? 'Pembayaran SPP' : $item->keterangan),
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
        
        $sudahBayarPendaftaran = TransaksiUmum::where('id_murid', $request->id_murid)
            ->where('keterangan', 'like', '%Pendaftaran%')
            ->exists();
        
        $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        
        // KASUS 1: BELUM BAYAR PENDAFTARAN
        if (!$sudahBayarPendaftaran) {
            TransaksiUmum::create([
                'id_murid' => $request->id_murid,
                'tanggal_bayar' => $request->tanggal,
                'bulan' => $request->tanggal,
                'jenis_pembayaran' => $request->jenis_pembayaran,
                'keterangan' => 'Pembayaran Pendaftaran - ' . $murid->nama_lengkap,
                'debit' => $request->total_pembayaran,
                'kredit' => 0,
            ]);
            
            $murid->update(['tanggal_daftar' => $request->tanggal]);
            
            return redirect()->route($role . '.pembayaran')
                ->with('success', 'Pembayaran pendaftaran berhasil disimpan');
        }
        
        // KASUS 2: PEMBAYARAN BULANAN (SPP)
        $request->validate([
            'paket_selanjutnya' => 'required|string',
            'bulan_dibayar' => 'nullable|integer|min:1|max:12',
        ]);
        
        $bulanDibayar = $request->bulan_dibayar ?? Carbon::now()->month;
        $tahunDibayar = Carbon::now()->year;
        $namaBulan = Carbon::create()->month($bulanDibayar)->translatedFormat('F');
        
        TransaksiUmum::create([
            'id_murid' => $request->id_murid,
            'tanggal_bayar' => $request->tanggal,
            'bulan' => $request->tanggal,
            'jenis_pembayaran' => $request->jenis_pembayaran,
            'keterangan' => 'Pembayaran SPP ' . $namaBulan . ' ' . $tahunDibayar . ' - ' . $murid->nama_lengkap,
            'debit' => $request->total_pembayaran,
            'kredit' => 0,
        ]);
        
        // Update atau create paket murid
        $hargaPaket = HargaPaket::where('tingkat', $request->paket_selanjutnya)->first();
        if ($hargaPaket) {
            TransaksiPaket::updateOrCreate(
                ['id_murid' => $request->id_murid],
                ['id_paket' => $hargaPaket->id_paket]
            );
        }
        
        return redirect()->route($role . '.pembayaran')
            ->with('success', 'Pembayaran SPP berhasil disimpan');
    }
    
    public function destroy(Request $request, $id)
    {
        TransaksiUmum::where('id_transaksi', $id)->delete();
        
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
        
        $sudahBayarPendaftaran = TransaksiUmum::where('id_murid', $id)
            ->where('keterangan', 'like', '%Pendaftaran%')
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
            
            $pembayaranBulanIni = TransaksiUmum::where('id_murid', $id)
                ->where('keterangan', 'like', '%SPP%')
                ->get()
                ->filter(function($item) use ($currentMonth, $currentYear) {
                    preg_match('/SPP\s+(\w+)\s+(\d+)/', $item->keterangan, $matches);
                    if (isset($matches[1]) && isset($matches[2])) {
                        try {
                            $bulanDibayar = Carbon::parse($matches[1])->month;
                            $tahunDibayar = (int)$matches[2];
                            return $bulanDibayar == $currentMonth && $tahunDibayar == $currentYear;
                        } catch (\Exception $e) {
                            return false;
                        }
                    }
                    return false;
                })
                ->first();
            
            if (!$pembayaranBulanIni) {
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