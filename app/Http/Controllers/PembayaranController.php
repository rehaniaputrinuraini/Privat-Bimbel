<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Murid;
use App\Models\HargaPaket;
use App\Models\TransaksiPaket;
use App\Models\TransaksiKelas;
use App\Models\TransaksiUmum; 
use App\Models\Periode;
use Carbon\Carbon;

class PembayaranController extends Controller
{
    // =============================================
    // TAGIHAN MURID
    // =============================================
    public function indexTagihan(Request $request)
    {
        $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        $paketList = HargaPaket::orderBy('id_paket', 'asc')->get();
        
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        
        $murids = Murid::all();
        
        $today = date('Y-m-d');
        $periodeAktif = Periode::where('tanggal_mulai', '<=', $today)
            ->where('tanggal_selesai', '>=', $today)
            ->first();
        
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
                ->orderBy('id_paket_murid', 'desc')
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
            
            // Ambil semua pembayaran SPP
            $semuaPembayaranSPP = TransaksiUmum::where('id_murid', $murid->id_murid)
                ->where('keterangan', 'like', '%SPP%')
                ->where('debit', '>', 0)
                ->orderBy('tanggal_bayar', 'desc')
                ->get();
            
            // Cek pembayaran bulan ini
            $pembayaranBulanIni = $semuaPembayaranSPP->filter(function($item) use ($currentMonth, $currentYear) {
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
            
            // Hitung Uang Muka
            $totalUangMuka = 0;
            $uangMukaBulanList = [];
            
            // Hitung Piutang
            $totalPiutang = 0;
            $piutangBulanList = [];
            
            foreach ($semuaPembayaranSPP as $pemb) {
                preg_match('/SPP\s+(\w+)\s+(\d+)/', $pemb->keterangan, $matches);
                if (isset($matches[1]) && isset($matches[2])) {
                    try {
                        $bulanDibayar = Carbon::parse($matches[1])->month;
                        $tahunDibayar = (int)$matches[2];
                        $bulanTahun = $matches[1] . ' ' . $matches[2];
                        
                        if ($tahunDibayar > $currentYear || 
                            ($tahunDibayar == $currentYear && $bulanDibayar > $currentMonth)) {
                            $totalUangMuka += $pemb->debit;
                            $uangMukaBulanList[] = $bulanTahun;
                        }
                        
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
            
            // Bulan belum dibayar
            $bulanBelumDibayar = [];
            $bulanMulai = 1;
            if ($murid->tanggal_daftar) {
                $bulanMulai = (int) date('m', strtotime($murid->tanggal_daftar));
            }
            for ($i = $bulanMulai; $i <= $currentMonth; $i++) {
                $bulanTahun = Carbon::create()->month($i)->translatedFormat('F') . ' ' . $currentYear;
                $sudahDibayar = false;
                
                if ($i == $bulanMulai && !$sudahBayarPendaftaran == false) {
                    continue;
                }
                
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
                $statusTagihan = 'Belum Daftar';
                $tagihanBulan = 'Pendaftaran';
                $totalPiutangDisplay = 'Rp 100.000';
                $uangMukaDisplay = '-';
                $statusPembayaran = '-';
            } elseif ($totalUangMuka > 0) {
                $statusPembayaran = 'Lunas';
                $statusTagihan = 'Uang Muka';
                $tagihanBulan = !empty($uangMukaBulanList) ? implode(', ', $uangMukaBulanList) : '-';
                $totalPiutangDisplay = '-';
                $uangMukaDisplay = 'Rp ' . number_format($totalUangMuka, 0, ',', '.');
            } elseif ($totalPiutang > 0) {
                $statusPembayaran = 'Belum';
                $statusTagihan = 'Tunggak';
                $allBulan = array_merge($piutangBulanList, $bulanBelumDibayar);
                $tagihanBulan = !empty($allBulan) ? implode(', ', array_unique($allBulan)) : Carbon::create()->month($currentMonth)->translatedFormat('F') . ' ' . $currentYear;
                $totalPiutangDisplay = 'Rp ' . number_format($totalPiutang, 0, ',', '.');
                $uangMukaDisplay = '-';
            } elseif ($pembayaranBulanIni) {
                $statusPembayaran = 'Lunas';
                $statusTagihan = 'Lunas';
                $tagihanBulan = '-';
                $totalPiutangDisplay = '-';
                $uangMukaDisplay = '-';
            } else {
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
        
        return view('dashboard.shared.pembayaran.tagihan', [
            'role' => $role,
            'tagihan' => $tagihan,
            'paketList' => $paketList,
        ]);
    }
    
    // =============================================
    // RIWAYAT PEMBAYARAN
    // =============================================
    public function indexRiwayat(Request $request)
    {
        $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        $paketList = HargaPaket::orderBy('id_paket', 'asc')->get();
        
        $riwayat = TransaksiUmum::with('murid')
            ->orderBy('tanggal_bayar', 'desc')
            ->get()
            ->map(function ($item) {
                $nama_murid = $item->murid ? $item->murid->nama_lengkap : 'Tidak Diketahui';
                $isPendaftaran = str_contains($item->keterangan, 'Pendaftaran');
                $isSPP = str_contains($item->keterangan, 'SPP');
                
                $bulanDibayar = '-';
                $paketSelanjutnya = '-';
                
                if ($isSPP) {
                    preg_match('/SPP\s+(\w+)\s+(\d+)/', $item->keterangan, $matches);
                    if (isset($matches[1]) && isset($matches[2])) {
                        $bulanDibayar = $matches[1] . ' ' . $matches[2];
                    }
                    
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
        
        return view('dashboard.shared.pembayaran.riwayat', [
            'role' => $role,
            'riwayat' => $riwayat,
            'paketList' => $paketList,
        ]);
    }
    
    // =============================================
    // CREATE
    // =============================================
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
    
    // =============================================
    // STORE (REVISI - RETURN JSON)
    // =============================================
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
            return response()->json(['success' => false, 'message' => 'Data murid tidak ditemukan']);
        }
        
        $sudahBayarPendaftaran = TransaksiUmum::where('id_murid', $request->id_murid)
            ->where('keterangan', 'like', '%Pendaftaran%')
            ->exists();
        
        $today = date('Y-m-d');
        $periodeAktif = Periode::where('tanggal_mulai', '<=', $today)
            ->where('tanggal_selesai', '>=', $today)
            ->first();
        
        if (!$periodeAktif) {
            return response()->json(['success' => false, 'message' => 'Tidak ada periode aktif!']);
        }
        
        // BELUM BAYAR PENDAFTARAN
        if (!$sudahBayarPendaftaran) {
            TransaksiUmum::create([
                'id_periode' => (int) $periodeAktif->id_periode,
                'id_murid' => (int) $request->id_murid,
                'id_pegawai' => null,
                'tanggal_bayar' => $request->tanggal,
                'bulan' => (int) date('m', strtotime($request->tanggal)),
                'jenis_pembayaran' => $request->jenis_pembayaran,
                'keterangan' => 'Pembayaran Pendaftaran - ' . $murid->nama_lengkap,
                'debit' => (int) $request->total_pembayaran,
                'kredit' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            $murid->update(['tanggal_daftar' => $request->tanggal]);
            
            return response()->json(['success' => true, 'message' => 'Pembayaran pendaftaran berhasil disimpan']);
        }
        
        // PEMBAYARAN SPP
        $request->validate([
            'paket_selanjutnya' => 'required|string',
            'bulan_dibayar' => 'nullable|integer|min:1|max:12',
        ]);
        
        $bulanDibayar = $request->bulan_dibayar ?? Carbon::now()->month;
        $tahunDibayar = Carbon::now()->year;
        $namaBulan = Carbon::create()->month($bulanDibayar)->translatedFormat('F');
        
        TransaksiUmum::create([
            'id_periode' => (int) $periodeAktif->id_periode,
            'id_murid' => (int) $request->id_murid,
            'id_pegawai' => null,
            'tanggal_bayar' => $request->tanggal,
            'bulan' => (int) $bulanDibayar,
            'jenis_pembayaran' => $request->jenis_pembayaran,
            'keterangan' => 'Pembayaran SPP ' . $namaBulan . ' ' . $tahunDibayar . ' - ' . $murid->nama_lengkap,
            'debit' => (int) $request->total_pembayaran,
            'kredit' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $hargaPaket = HargaPaket::where('tingkat', $request->paket_selanjutnya)->first();
        if ($hargaPaket) {
            TransaksiPaket::where('id_murid', $request->id_murid)->delete();
            TransaksiPaket::create([
                'id_murid' => (int) $request->id_murid,
                'id_paket' => (int) $hargaPaket->id_paket,
                'id_periode' => (int) $periodeAktif->id_periode,
                'tanggal_daftar' => date('Y-m-d'),
                'paket_awal' => 0,
                'biaya_pendaftaran' => 100000,
            ]);
        }
        
        return response()->json(['success' => true, 'message' => 'Pembayaran SPP berhasil disimpan']);
    }
    
    // =============================================
    // DESTROY
    // =============================================
    public function destroy(Request $request, $id)
    {
        TransaksiUmum::where('id_transaksi', $id)->delete();
        
        $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        
        return redirect()->route($role . '.pembayaran.tagihan')
            ->with('success', 'Data pembayaran berhasil dihapus');
    }

    // =============================================
    // API CEK STATUS
    // =============================================
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
            ->orderBy('id_paket_murid', 'desc')
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
                ->where('debit', '>', 0)
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