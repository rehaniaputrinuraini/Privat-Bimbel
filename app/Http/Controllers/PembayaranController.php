<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Murid;
use App\Models\HargaPaket;
use App\Models\Mengajar;
use App\Models\Pegawai;
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
        $currentYear  = Carbon::now()->year;

        $murids = Murid::all();

        $today       = date('Y-m-d');
        $periodeAktif = Periode::where('tanggal_mulai', '<=', $today)
            ->where('tanggal_selesai', '>=', $today)
            ->first();

        $tagihan = collect();

        foreach ($murids as $murid) {
            $kelasTerbaru = TransaksiKelas::where('id_murid', $murid->id_murid)
                ->orderBy('created_at', 'desc')
                ->first();
            $namaKelas = '-';
            if ($kelasTerbaru) {
                $kelas     = \App\Models\Kelas::find($kelasTerbaru->id_kelas);
                $namaKelas = $kelas ? $kelas->nama_kelas : '-';
            }

            $paketAktif    = TransaksiPaket::where('id_murid', $murid->id_murid)
                ->orderBy('id_paket_murid', 'desc')
                ->first();
            $namaPaket     = '-';
            $hargaPerBulan = 0;
            if ($paketAktif) {
                $paket = HargaPaket::find($paketAktif->id_paket);
                if ($paket) {
                    $namaPaket     = $paket->tingkat;
                    $hargaPerBulan = $paket->harga;
                }
            }

            $sudahBayarPendaftaran = TransaksiUmum::where('id_murid', $murid->id_murid)
                ->where('keterangan', 'like', '%Pendaftaran%')
                ->exists();
            $statusPendaftaran = $sudahBayarPendaftaran ? 'Lunas' : 'Belum';

            $semuaPembayaranSPP = TransaksiUmum::where('id_murid', $murid->id_murid)
                ->where('keterangan', 'like', '%SPP%')
                ->where('debit', '>', 0)
                ->orderBy('tanggal_bayar', 'desc')
                ->get();

            $pembayaranBulanIni = $semuaPembayaranSPP->filter(function ($item) use ($currentMonth, $currentYear) {
                preg_match('/SPP\s+(\w+)\s+(\d+)/', $item->keterangan, $matches);
                if (isset($matches[1]) && isset($matches[2])) {
                    try {
                        $bulanDibayar = Carbon::parse($matches[1])->month;
                        $tahunDibayar = (int) $matches[2];
                        return $bulanDibayar == $currentMonth && $tahunDibayar == $currentYear;
                    } catch (\Exception $e) {
                        return false;
                    }
                }
                return false;
            })->first();

            $totalUangMuka    = 0;
            $uangMukaBulanList = [];
            $totalPiutang     = 0;
            $piutangBulanList = [];

            foreach ($semuaPembayaranSPP as $pemb) {
                preg_match('/SPP\s+(\w+)\s+(\d+)/', $pemb->keterangan, $matches);
                if (isset($matches[1]) && isset($matches[2])) {
                    try {
                        $bulanDibayar = Carbon::parse($matches[1])->month;
                        $tahunDibayar = (int) $matches[2];
                        $bulanTahun   = $matches[1] . ' ' . $matches[2];

                        if ($tahunDibayar > $currentYear ||
                            ($tahunDibayar == $currentYear && $bulanDibayar > $currentMonth)) {
                            $totalUangMuka      += $pemb->debit;
                            $uangMukaBulanList[] = $bulanTahun;
                        }

                        if ($tahunDibayar < $currentYear ||
                            ($tahunDibayar == $currentYear && $bulanDibayar < $currentMonth)) {
                            $kekurangan = $hargaPerBulan - $pemb->debit;
                            if ($kekurangan > 0) {
                                $totalPiutang      += $kekurangan;
                                $piutangBulanList[] = $bulanTahun;
                            }
                        }
                    } catch (\Exception $e) {
                        continue;
                    }
                }
            }

            $bulanBelumDibayar = [];
            $bulanMulai        = 1;
            if ($murid->tanggal_daftar) {
                $bulanMulai = (int) date('m', strtotime($murid->tanggal_daftar));
            }

            for ($i = $bulanMulai; $i <= $currentMonth; $i++) {
                $bulanTahun  = Carbon::create()->month($i)->translatedFormat('F') . ' ' . $currentYear;
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
                    $totalPiutang       += $hargaPerBulan;
                }
            }

            $statusPembayaran    = '-';
            $statusTagihan       = '-';
            $tagihanBulan        = '-';
            $totalPiutangDisplay = '-';
            $uangMukaDisplay     = '-';

            if (!$sudahBayarPendaftaran) {
                $statusTagihan       = 'Belum Daftar';
                $tagihanBulan        = 'Pendaftaran';
                $totalPiutangDisplay = 'Rp 100.000';
                $uangMukaDisplay     = '-';
                $statusPembayaran    = '-';
            } elseif ($totalUangMuka > 0) {
                $statusPembayaran    = 'Lunas';
                $statusTagihan       = 'Uang Muka';
                $tagihanBulan        = !empty($uangMukaBulanList) ? implode(', ', $uangMukaBulanList) : '-';
                $totalPiutangDisplay = '-';
                $uangMukaDisplay     = 'Rp ' . number_format($totalUangMuka, 0, ',', '.');
            } elseif ($totalPiutang > 0) {
                $statusPembayaran    = 'Belum';
                $statusTagihan       = 'Tunggak';
                $allBulan            = array_merge($piutangBulanList, $bulanBelumDibayar);
                $tagihanBulan        = !empty($allBulan)
                    ? implode(', ', array_unique($allBulan))
                    : Carbon::create()->month($currentMonth)->translatedFormat('F') . ' ' . $currentYear;
                $totalPiutangDisplay = 'Rp ' . number_format($totalPiutang, 0, ',', '.');
                $uangMukaDisplay     = '-';
            } elseif ($pembayaranBulanIni) {
                $statusPembayaran    = 'Lunas';
                $statusTagihan       = 'Lunas';
                $tagihanBulan        = '-';
                $totalPiutangDisplay = '-';
                $uangMukaDisplay     = '-';
            } else {
                $statusPembayaran    = 'Belum';
                $statusTagihan       = 'Tunggak';
                $tagihanBulan        = Carbon::create()->month($currentMonth)->translatedFormat('F') . ' ' . $currentYear;
                $totalPiutangDisplay = 'Rp ' . number_format($hargaPerBulan, 0, ',', '.');
                $uangMukaDisplay     = '-';
            }

            $tagihan->push((object) [
                'id_murid'          => $murid->id_murid,
                'nama_murid'        => $murid->nama_lengkap,
                'kelas'             => $namaKelas,
                'paket'             => $namaPaket,
                'status_pendaftaran'=> $statusPendaftaran,
                'status_pembayaran' => $statusPembayaran,
                'status_tagihan'    => $statusTagihan,
                'tagihan_bulan'     => $tagihanBulan,
                'total_piutang'     => $totalPiutangDisplay,
                'uang_muka'         => $uangMukaDisplay,
            ]);
        }

        $perPage     = $request->get('per_page', 10);
        $currentPage = $request->get('page', 1);
        $total       = $tagihan->count();

        $tagihan = new \Illuminate\Pagination\LengthAwarePaginator(
            $tagihan->forPage($currentPage, $perPage),
            $total,
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('dashboard.shared.pembayaran.tagihan', [
            'role'      => $role,
            'tagihan'   => $tagihan,
            'paketList' => $paketList,
        ]);
    }

    // =============================================
    // RIWAYAT PEMBAYARAN
    // =============================================
    public function indexRiwayat(Request $request)
    {
        $role      = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        $paketList = HargaPaket::orderBy('id_paket', 'asc')->get();
        $perPage   = $request->get('per_page', 10);

        $riwayat = TransaksiUmum::with('murid')
            ->orderBy('tanggal_bayar', 'desc')
            ->paginate($perPage)
            ->through(function ($item) {
                $nama_murid     = $item->murid ? $item->murid->nama_lengkap : 'Tidak Diketahui';
                $isPendaftaran  = str_contains($item->keterangan, 'Pendaftaran');
                $isSPP          = str_contains($item->keterangan, 'SPP');
                $bulanDibayar   = '-';
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

                return (object) [
                    'id_pembayaran'    => $item->id_transaksi,
                    'tanggal'          => $item->tanggal_bayar ? date('d/m/Y', strtotime($item->tanggal_bayar)) : '-',
                    'nama_murid'       => $nama_murid,
                    'paket_awal'       => $isPendaftaran ? 'Rp 100.000' : '-',
                    'paket_selanjutnya'=> $paketSelanjutnya,
                    'bulan_dibayar'    => $bulanDibayar,
                    'jenis_pembayaran' => $item->jenis_pembayaran ?? '-',
                    'total_bayar'      => 'Rp ' . number_format($item->debit ?? 0, 0, ',', '.'),
                    'keterangan'       => $isPendaftaran
                        ? 'Pembayaran Pendaftaran'
                        : ($isSPP ? 'Pembayaran SPP' : $item->keterangan),
                ];
            });

        return view('dashboard.shared.pembayaran.riwayat', [
            'role'      => $role,
            'riwayat'   => $riwayat,
            'paketList' => $paketList,
        ]);
    }

    // =============================================
    // CREATE
    // =============================================
    public function create(Request $request)
    {
        $role   = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        $murids = Murid::orderBy('nama_lengkap', 'asc')->get();
        $pakets = HargaPaket::orderBy('id_paket', 'asc')->get();

        return view('dashboard.shared.pembayaran.create-pembayaran', [
            'role'   => $role,
            'murids' => $murids,
            'pakets' => $pakets,
        ]);
    }

    // =============================================
    // STORE
    // =============================================
    public function store(Request $request)
    {
        $today       = date('Y-m-d');
        $periodeAktif = Periode::where('tanggal_mulai', '<=', $today)
            ->where('tanggal_selesai', '>=', $today)
            ->first();

        if (!$periodeAktif) {
            return response()->json(['success' => false, 'message' => 'Tidak ada periode aktif!']);
        }

        if ($request->kategori_pemasukan == 'lainnya') {
            $request->validate([
                'tanggal_lainnya'          => 'required|date',
                'jenis_pembayaran_lainnya' => 'required|in:Tunai,Transfer',
                'sumber_pemasukan'         => 'required|string|max:100',
                'total_pembayaran_lainnya' => 'required|numeric|min:1000',
            ]);

            TransaksiUmum::create([
                'id_periode'       => (int) $periodeAktif->id_periode,
                'id_murid'         => null,
                'id_pegawai'       => null,
                'tanggal_bayar'    => $request->tanggal_lainnya,
                'bulan'            => (int) date('m', strtotime($request->tanggal_lainnya)),
                'jenis_pembayaran' => $request->jenis_pembayaran_lainnya,
                'keterangan'       => 'Pemasukan Lainnya: ' . $request->sumber_pemasukan
                    . ($request->keterangan_lainnya ? ' - ' . $request->keterangan_lainnya : ''),
                'debit'            => (int) $request->total_pembayaran_lainnya,
                'kredit'           => 0,
                'created_at'       => now(),
                'updated_at'       => now(),
            ]);

            return response()->json(['success' => true, 'message' => 'Pemasukan lainnya berhasil disimpan']);
        }

        $request->validate([
            'tanggal'             => 'required|date',
            'jenis_pembayaran'    => 'required|in:Tunai,Transfer',
            'total_pembayaran'    => 'required|numeric|min:1000',
            'kategori_pemasukan'  => 'required|in:murid,lainnya',
            'id_murid'            => 'required|exists:ms_murid,id_murid',
        ]);

        $murid = Murid::find($request->id_murid);

        if (!$murid) {
            return response()->json(['success' => false, 'message' => 'Data murid tidak ditemukan']);
        }

        $sudahBayarPendaftaran = TransaksiUmum::where('id_murid', $request->id_murid)
            ->where('keterangan', 'like', '%Pendaftaran%')
            ->exists();

        if (!$sudahBayarPendaftaran) {
            TransaksiUmum::create([
                'id_periode'       => (int) $periodeAktif->id_periode,
                'id_murid'         => (int) $request->id_murid,
                'id_pegawai'       => null,
                'tanggal_bayar'    => $request->tanggal,
                'bulan'            => (int) date('m', strtotime($request->tanggal)),
                'jenis_pembayaran' => $request->jenis_pembayaran,
                'keterangan'       => 'Pembayaran Pendaftaran - ' . $murid->nama_lengkap,
                'debit'            => (int) $request->total_pembayaran,
                'kredit'           => 0,
                'created_at'       => now(),
                'updated_at'       => now(),
            ]);

            $murid->update(['tanggal_daftar' => $request->tanggal]);

            return response()->json(['success' => true, 'message' => 'Pembayaran pendaftaran berhasil disimpan']);
        }

        $request->validate([
            'paket_selanjutnya' => 'required|string',
            'bulan_dibayar'     => 'nullable|integer|min:1|max:12',
        ]);

        $bulanDibayar = $request->bulan_dibayar ?? Carbon::now()->month;
        $tahunDibayar = Carbon::now()->year;
        $namaBulan    = Carbon::create()->month($bulanDibayar)->translatedFormat('F');

        TransaksiUmum::create([
            'id_periode'       => (int) $periodeAktif->id_periode,
            'id_murid'         => (int) $request->id_murid,
            'id_pegawai'       => null,
            'tanggal_bayar'    => $request->tanggal,
            'bulan'            => (int) $bulanDibayar,
            'jenis_pembayaran' => $request->jenis_pembayaran,
            'keterangan'       => 'Pembayaran SPP ' . $namaBulan . ' ' . $tahunDibayar . ' - ' . $murid->nama_lengkap,
            'debit'            => (int) $request->total_pembayaran,
            'kredit'           => 0,
            'created_at'       => now(),
            'updated_at'       => now(),
        ]);

        $hargaPaket = HargaPaket::where('tingkat', $request->paket_selanjutnya)->first();
        if ($hargaPaket) {
            TransaksiPaket::where('id_murid', $request->id_murid)->delete();
            TransaksiPaket::create([
                'id_murid'          => (int) $request->id_murid,
                'id_paket'          => (int) $hargaPaket->id_paket,
                'id_periode'        => (int) $periodeAktif->id_periode,
                'tanggal_daftar'    => date('Y-m-d'),
                'paket_awal'        => 0,
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
    // API CEK STATUS PEMBAYARAN MURID
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

        $paketAktif  = TransaksiPaket::where('id_murid', $id)
            ->orderBy('id_paket_murid', 'desc')
            ->first();

        $paketTingkat = null;
        $hargaPaket   = null;

        if ($paketAktif) {
            $paket = HargaPaket::find($paketAktif->id_paket);
            if ($paket) {
                $paketTingkat = $paket->tingkat;
                $hargaPaket   = $paket->harga;
            }
        }

        $bulanTunggakan  = null;
        $bulanLunas      = [];
        $bulanBerikutnya = null;

        if ($sudahBayarPendaftaran) {
            $currentMonth = Carbon::now()->month;
            $currentYear  = Carbon::now()->year;

            $semuaSPP = TransaksiUmum::where('id_murid', $id)
                ->where('keterangan', 'like', '%SPP%')
                ->where('debit', '>', 0)
                ->get();

            $pembayaranBulanIni = $semuaSPP->filter(function ($item) use ($currentMonth, $currentYear) {
                preg_match('/SPP\s+(\w+)\s+(\d+)/', $item->keterangan, $matches);
                if (isset($matches[1]) && isset($matches[2])) {
                    try {
                        $bulanDibayar = Carbon::parse($matches[1])->month;
                        $tahunDibayar = (int) $matches[2];
                        return $bulanDibayar == $currentMonth && $tahunDibayar == $currentYear;
                    } catch (\Exception $e) {
                        return false;
                    }
                }
                return false;
            })->first();

            if (!$pembayaranBulanIni) {
                $bulanTunggakan = $currentMonth;
            }

            foreach ($semuaSPP as $spp) {
                preg_match('/SPP\s+(\w+)\s+(\d+)/', $spp->keterangan, $matches);
                if (isset($matches[1])) {
                    try {
                        $bulan = Carbon::parse($matches[1])->month;
                        $tahun = (int) $matches[2];
                        if ($tahun == $currentYear && $hargaPaket && $spp->debit >= $hargaPaket) {
                            $bulanLunas[] = $bulan;
                        }
                    } catch (\Exception $e) {}
                }
            }

            if (in_array($currentMonth, $bulanLunas)) {
                $bulanBerikutnya = $currentMonth + 1;
                if ($bulanBerikutnya > 12) $bulanBerikutnya = 1;
            }
        }

        return response()->json([
            'sudah_bayar_pendaftaran' => $sudahBayarPendaftaran,
            'paket_awal'              => 100000,
            'paket_aktif'             => $paketTingkat,
            'bulan_tunggakan'         => $bulanTunggakan,
            'bulan_berikutnya'        => $bulanBerikutnya,
            'bulan_lunas'             => $bulanLunas,
        ]);
    }

    // =============================================
    // TRANSAKSI PEMASUKAN
    // =============================================
    public function indexPemasukan(Request $request)
    {
        $role      = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        $paketList = HargaPaket::orderBy('id_paket', 'asc')->get();
        $perPage   = $request->get('per_page', 10);

        $currentMonth = Carbon::now()->month;
        $currentYear  = Carbon::now()->year;
        $murids       = Murid::all();

        $tagihan = collect();

        foreach ($murids as $murid) {
            $kelasTerbaru = TransaksiKelas::where('id_murid', $murid->id_murid)->orderBy('created_at', 'desc')->first();
            $namaKelas    = '-';
            if ($kelasTerbaru) {
                $kelas     = \App\Models\Kelas::find($kelasTerbaru->id_kelas);
                $namaKelas = $kelas ? $kelas->nama_kelas : '-';
            }

            $paketAktif    = TransaksiPaket::where('id_murid', $murid->id_murid)->orderBy('id_paket_murid', 'desc')->first();
            $namaPaket     = '-';
            $hargaPerBulan = 0;
            if ($paketAktif) {
                $paket = HargaPaket::find($paketAktif->id_paket);
                if ($paket) { $namaPaket = $paket->tingkat; $hargaPerBulan = $paket->harga; }
            }

            $sudahBayarPendaftaran = TransaksiUmum::where('id_murid', $murid->id_murid)->where('keterangan', 'like', '%Pendaftaran%')->exists();
            $statusPendaftaran     = $sudahBayarPendaftaran ? 'Lunas' : 'Belum';

            $semuaPembayaranSPP = TransaksiUmum::where('id_murid', $murid->id_murid)->where('keterangan', 'like', '%SPP%')->where('debit', '>', 0)->orderBy('tanggal_bayar', 'desc')->get();

            $pembayaranBulanIni = $semuaPembayaranSPP->filter(function ($item) use ($currentMonth, $currentYear) {
                preg_match('/SPP\s+(\w+)\s+(\d+)/', $item->keterangan, $matches);
                if (isset($matches[1]) && isset($matches[2])) {
                    try { return Carbon::parse($matches[1])->month == $currentMonth && (int) $matches[2] == $currentYear; }
                    catch (\Exception $e) { return false; }
                }
                return false;
            })->first();

            $totalUangMuka    = 0; $uangMukaBulanList = [];
            $totalPiutang     = 0; $piutangBulanList  = [];

            foreach ($semuaPembayaranSPP as $pemb) {
                preg_match('/SPP\s+(\w+)\s+(\d+)/', $pemb->keterangan, $matches);
                if (isset($matches[1]) && isset($matches[2])) {
                    try {
                        $bulanDibayar = Carbon::parse($matches[1])->month;
                        $tahunDibayar = (int) $matches[2];
                        $bulanTahun   = $matches[1] . ' ' . $matches[2];
                        if ($tahunDibayar > $currentYear || ($tahunDibayar == $currentYear && $bulanDibayar > $currentMonth)) { $totalUangMuka += $pemb->debit; $uangMukaBulanList[] = $bulanTahun; }
                        if ($tahunDibayar < $currentYear || ($tahunDibayar == $currentYear && $bulanDibayar < $currentMonth)) { $kekurangan = $hargaPerBulan - $pemb->debit; if ($kekurangan > 0) { $totalPiutang += $kekurangan; $piutangBulanList[] = $bulanTahun; } }
                    } catch (\Exception $e) { continue; }
                }
            }

            $bulanBelumDibayar = []; $bulanMulai = 1;
            if ($murid->tanggal_daftar) { $bulanMulai = (int) date('m', strtotime($murid->tanggal_daftar)); }
            for ($i = $bulanMulai; $i <= $currentMonth; $i++) {
                $bulanTahun   = Carbon::create()->month($i)->translatedFormat('F') . ' ' . $currentYear;
                $sudahDibayar = false;
                if ($i == $bulanMulai && !$sudahBayarPendaftaran == false) { continue; }
                foreach ($semuaPembayaranSPP as $pemb) { if (str_contains($pemb->keterangan, $bulanTahun)) { $sudahDibayar = true; break; } }
                if (!$sudahDibayar) { $bulanBelumDibayar[] = $bulanTahun; $totalPiutang += $hargaPerBulan; }
            }

            $statusPembayaran = '-'; $statusTagihan = '-'; $tagihanBulan = '-'; $totalPiutangDisplay = '-'; $uangMukaDisplay = '-';

            if (!$sudahBayarPendaftaran) { $statusTagihan = 'Belum Daftar'; $tagihanBulan = 'Pendaftaran'; $totalPiutangDisplay = 'Rp 100.000'; $uangMukaDisplay = '-'; $statusPembayaran = '-'; }
            elseif ($totalUangMuka > 0)  { $statusPembayaran = 'Lunas'; $statusTagihan = 'Uang Muka'; $tagihanBulan = !empty($uangMukaBulanList) ? implode(', ', $uangMukaBulanList) : '-'; $totalPiutangDisplay = '-'; $uangMukaDisplay = 'Rp ' . number_format($totalUangMuka, 0, ',', '.'); }
            elseif ($totalPiutang > 0)   { $statusPembayaran = 'Belum'; $statusTagihan = 'Tunggak'; $allBulan = array_merge($piutangBulanList, $bulanBelumDibayar); $tagihanBulan = !empty($allBulan) ? implode(', ', array_unique($allBulan)) : Carbon::create()->month($currentMonth)->translatedFormat('F') . ' ' . $currentYear; $totalPiutangDisplay = 'Rp ' . number_format($totalPiutang, 0, ',', '.'); $uangMukaDisplay = '-'; }
            elseif ($pembayaranBulanIni) { $statusPembayaran = 'Lunas'; $statusTagihan = 'Lunas'; $tagihanBulan = '-'; $totalPiutangDisplay = '-'; $uangMukaDisplay = '-'; }
            else { $statusPembayaran = 'Belum'; $statusTagihan = 'Tunggak'; $tagihanBulan = Carbon::create()->month($currentMonth)->translatedFormat('F') . ' ' . $currentYear; $totalPiutangDisplay = 'Rp ' . number_format($hargaPerBulan, 0, ',', '.'); $uangMukaDisplay = '-'; }

            $tagihan->push((object) [
                'id_murid'           => $murid->id_murid,
                'nama_murid'         => $murid->nama_lengkap,
                'kelas'              => $namaKelas,
                'paket'              => $namaPaket,
                'status_pendaftaran' => $statusPendaftaran,
                'status_pembayaran'  => $statusPembayaran,
                'status_tagihan'     => $statusTagihan,
                'tagihan_bulan'      => $tagihanBulan,
                'total_piutang'      => $totalPiutangDisplay,
                'uang_muka'          => $uangMukaDisplay,
            ]);
        }

        $totalTagihan       = $tagihan->count();
        $currentPageTagihan = $request->get('page_tagihan', 1);
        $tagihan = new \Illuminate\Pagination\LengthAwarePaginator(
            $tagihan->forPage($currentPageTagihan, $perPage),
            $totalTagihan, $perPage, $currentPageTagihan,
            ['path' => $request->url(), 'query' => $request->query(), 'pageName' => 'page_tagihan']
        );

        $pemasukan = TransaksiUmum::with('murid')
            ->where('debit', '>', 0)
            ->orderBy('tanggal_bayar', 'desc')
            ->paginate($perPage, ['*'], 'page_riwayat')
            ->through(function ($item) {
                $isPendaftaran = str_contains($item->keterangan, 'Pendaftaran');
                $isSPP         = str_contains($item->keterangan, 'SPP');
                $paket         = '-';
                $kategori      = 'Lainnya';
                $nama          = $item->keterangan;

                if ($isPendaftaran || $isSPP) {
                    $nama     = $item->murid->nama_lengkap ?? '-';
                    $kategori = $isPendaftaran ? 'Pendaftaran' : 'SPP';
                    if ($isSPP) {
                        $paketAktif = TransaksiPaket::where('id_murid', $item->id_murid)->first();
                        if ($paketAktif) {
                            $p = HargaPaket::find($paketAktif->id_paket);
                            if ($p) { $paket = $p->tingkat; }
                        }
                    }
                }

                return (object) [
                    'id'               => $item->id_transaksi,
                    'tanggal'          => $item->tanggal_bayar ? date('d/m/Y', strtotime($item->tanggal_bayar)) : '-',
                    'nama_murid'       => $nama,
                    'kategori'         => $kategori,
                    'paket'            => $paket,
                    'jenis_pembayaran' => $item->jenis_pembayaran ?? '-',
                    'jumlah'           => $item->debit ?? 0,
                    'keterangan'       => $item->keterangan,
                ];
            });

        $totalBulanIni    = TransaksiUmum::where('debit', '>', 0)->whereMonth('tanggal_bayar', now()->month)->whereYear('tanggal_bayar', now()->year)->sum('debit');
        $totalKeseluruhan = TransaksiUmum::where('debit', '>', 0)->sum('debit');
        $totalMurid       = TransaksiUmum::where('debit', '>', 0)->where(function ($q) { $q->where('keterangan', 'like', '%Pendaftaran%')->orWhere('keterangan', 'like', '%SPP%'); })->sum('debit');
        $totalLainnya     = TransaksiUmum::where('debit', '>', 0)->where('keterangan', 'not like', '%Pendaftaran%')->where('keterangan', 'not like', '%SPP%')->sum('debit');

        return view('dashboard.shared.transaksi.pemasukan', compact(
            'role', 'tagihan', 'pemasukan', 'paketList',
            'totalBulanIni', 'totalKeseluruhan', 'totalMurid', 'totalLainnya'
        ));
    }

    // =============================================
    // TRANSAKSI PENGELUARAN
    // =============================================
    public function indexPengeluaran(Request $request)
    {
        $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        $perPage = $request->get('per_page', 10);
        
        $pengeluaran = TransaksiUmum::where('kredit', '>', 0)
            ->where('keterangan', 'not like', '%Gaji%')
            ->where('keterangan', 'not like', '%Honor%')
            ->orderBy('tanggal_bayar', 'desc')
            ->paginate($perPage)
            ->through(function ($item) {
                return (object)[
                    'id' => $item->id_transaksi,
                    'tanggal' => $item->tanggal_bayar ? date('d/m/Y', strtotime($item->tanggal_bayar)) : '-',
                    'keperluan' => str_replace('Pengeluaran: ', '', $item->keterangan),
                    'jenis_pembayaran' => $item->jenis_pembayaran ?? '-',
                    'jumlah' => $item->kredit ?? 0,
                    'keterangan' => $item->keterangan,
                ];
            });
        
        $totalBulanIni = TransaksiUmum::where('kredit', '>', 0)
            ->where('keterangan', 'not like', '%Gaji%')
            ->where('keterangan', 'not like', '%Honor%')
            ->whereMonth('tanggal_bayar', now()->month)
            ->whereYear('tanggal_bayar', now()->year)
            ->sum('kredit');
        
        $totalKeseluruhan = TransaksiUmum::where('kredit', '>', 0)
            ->where('keterangan', 'not like', '%Gaji%')
            ->where('keterangan', 'not like', '%Honor%')
            ->sum('kredit');
        
        return view('dashboard.shared.transaksi.pengeluaran', compact(
            'role', 'pengeluaran', 'totalBulanIni', 'totalKeseluruhan'
        ));
    }

    public function createPengeluaran(Request $request)
    {
        $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        return view('dashboard.shared.pembayaran.create-pengeluaran', compact('role'));
    }

    public function storePengeluaran(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'jenis_pembayaran' => 'required|in:Tunai,Transfer',
            'keperluan' => 'required|string|max:100',
            'total_pembayaran' => 'required|numeric|min:1000',
        ]);
        
        $today = date('Y-m-d');
        $periodeAktif = Periode::where('tanggal_mulai', '<=', $today)
            ->where('tanggal_selesai', '>=', $today)
            ->first();
        
        if (!$periodeAktif) {
            return response()->json(['success' => false, 'message' => 'Tidak ada periode aktif!']);
        }
        
        TransaksiUmum::create([
            'id_periode' => (int) $periodeAktif->id_periode,
            'id_murid' => null,
            'id_pegawai' => null,
            'tanggal_bayar' => $request->tanggal,
            'bulan' => (int) date('m', strtotime($request->tanggal)),
            'jenis_pembayaran' => $request->jenis_pembayaran,
            'keterangan' => 'Pengeluaran: ' . $request->keperluan . ($request->keterangan ? ' - ' . $request->keterangan : ''),
            'debit' => 0,
            'kredit' => (int) $request->total_pembayaran,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        return response()->json(['success' => true, 'message' => 'Pengeluaran berhasil disimpan']);
    }

    // =============================================
    // TRANSAKSI PENGGAJIAN (FIX - 1 HARI = 1 SESI)
    // =============================================
    public function indexPenggajian(Request $request)
    {
        $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        $perPage = $request->get('per_page', 10);
        $bulan = $request->get('bulan', now()->month);
        $tahun = $request->get('tahun', now()->year);
        
        $today = Carbon::now();
        $lastDayOfMonth = $today->copy()->endOfMonth()->day;
        $currentDay = $today->day;
        $isAkhirBulan = ($currentDay >= $lastDayOfMonth - 3);
        
        $tentors = Pegawai::with('user')
            ->where('jenis_pegawai', 'tentor')
            ->get();
        
        $penggajian = collect();
        
        foreach ($tentors as $tentor) {
            // Ambil SEMUA presensi bulan ini
            $presensi = Mengajar::with('kelas')
                ->where('id_pegawai', $tentor->id_pegawai)
                ->whereMonth('tanggal', $bulan)
                ->whereYear('tanggal', $tahun)
                ->get();
            
            if ($presensi->count() == 0) continue;
            
            // === HITUNG PER HARI (1 HARI = 1 SESI) ===
            $daftarTanggal = $presensi->pluck('tanggal')->unique()->values();
            $hariHadir = $daftarTanggal->count();
            
            $totalHonor = 0;
            
            foreach ($daftarTanggal as $tanggal) {
                // Ambil semua presensi di tanggal ini
                $presensiHarian = $presensi->where('tanggal', $tanggal);
                
                // Cek apakah ada yang "Hadir" di hari ini
                $adaHadir = $presensiHarian->where('murid_hadir', 'Hadir')->count() > 0;
                $adaTidakHadir = $presensiHarian->where('murid_hadir', 'Tidak Hadir')->count() > 0;
                
                // Ambil jenjang dari presensi pertama di hari itu
                $jenjang = $presensiHarian->first()->kelas->jenjang ?? null;
                $hr = 0;
                
                if ($jenjang == 'SD') $hr = $tentor->hr_sd ?? 0;
                elseif ($jenjang == 'SMP') $hr = $tentor->hr_smp ?? 0;
                elseif ($jenjang == 'SMA') $hr = $tentor->hr_sma ?? 0;
                
                // Jika HADIR (walaupun ada yang tidak hadir, tetap 100%)
                if ($adaHadir) {
                    $totalHonor += $hr;
                }
                // Jika TIDAK HADIR semua (50%)
                elseif ($adaTidakHadir) {
                    $totalHonor += ($hr / 2);
                }
            }
            
            $daftarTanggalStr = $daftarTanggal->map(function($t) {
                return \Carbon\Carbon::parse($t)->format('d/m');
            })->implode(', ');
            
            $uangMakanPerHari = $tentor->uang_makan ?? 0;
            $totalUangMakan = $hariHadir * $uangMakanPerHari;
            
            $uangTransportPerHari = $tentor->uang_transport ?? 0;
            $totalUangTransport = $hariHadir * $uangTransportPerHari;
            
            $totalGaji = $totalHonor + $totalUangMakan + $totalUangTransport;
            
            $sudahDibayar = TransaksiUmum::where('id_pegawai', $tentor->id_pegawai)
                ->where('kredit', '>', 0)
                ->where('keterangan', 'like', "%Gaji " . Carbon::create()->month($bulan)->translatedFormat('F') . " " . $tahun . "%")
                ->exists();
            
            $penggajian->push((object)[
                'id_pegawai' => $tentor->id_pegawai,
                'nama' => $tentor->nama_lengkap,
                'mapel' => $tentor->mapel ?? '-',
                'grade' => $tentor->grade ?? '-',
                'jumlah_sesi' => $hariHadir,        // ⬅️ 1 HARI = 1 SESI
                'hari_hadir' => $hariHadir,
                'daftar_tanggal' => $daftarTanggalStr,
                'total_honor' => $totalHonor,
                'uang_makan_per_hari' => $uangMakanPerHari,
                'uang_makan' => $totalUangMakan,
                'uang_transport_per_hari' => $uangTransportPerHari,
                'uang_transport' => $totalUangTransport,
                'total_gaji' => $totalGaji,
                'status' => $sudahDibayar ? 'Sudah Dibayar' : 'Belum Dibayar',
                'sudah_dibayar' => $sudahDibayar,
            ]);
        }
        
        $total = $penggajian->count();
        $currentPage = $request->get('page', 1);
        $penggajian = new \Illuminate\Pagination\LengthAwarePaginator(
            $penggajian->forPage($currentPage, $perPage),
            $total, $perPage, $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );
        
        return view('dashboard.shared.transaksi.penggajian', compact('role', 'penggajian', 'bulan', 'tahun', 'isAkhirBulan'));
    }

    public function bayarGaji(Request $request, $id)
    {
        try {
            $tentor = Pegawai::findOrFail($id);
            $bulan = $request->bulan;
            $tahun = $request->tahun;
            $totalGaji = $request->total_gaji;
            $jumlahSesi = $request->jumlah_sesi;
            
            $today = date('Y-m-d');
            $periodeAktif = Periode::where('tanggal_mulai', '<=', $today)
                ->where('tanggal_selesai', '>=', $today)
                ->first();
            
            if (!$periodeAktif) {
                return response()->json(['success' => false, 'message' => 'Tidak ada periode aktif!']);
            }
            
            $namaBulan = Carbon::create()->month($bulan)->translatedFormat('F');
            
            TransaksiUmum::create([
                'id_periode' => (int) $periodeAktif->id_periode,
                'id_murid' => null,
                'id_pegawai' => $tentor->id_pegawai,
                'tanggal_bayar' => $today,
                'bulan' => (int) $bulan,
                'jenis_pembayaran' => 'Transfer',
                'keterangan' => "Gaji " . $namaBulan . " " . $tahun . " - " . $tentor->nama_lengkap . " ({$jumlahSesi} sesi)",
                'debit' => 0,
                'kredit' => (int) $totalGaji,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            return response()->json(['success' => true, 'message' => 'Gaji berhasil dibayarkan']);
            
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    // =============================================
    // DETAIL PEMBAYARAN MURID (POP-UP)
    // =============================================
    public function detail(Request $request, $id)
    {
        $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        
        $murid = Murid::with(['transaksiUmum' => function ($q) {
            $q->orderBy('tanggal_bayar', 'desc');
        }])->findOrFail($id);
        
        // Kelas murid
        $kelasTerbaru = TransaksiKelas::where('id_murid', $murid->id_murid)
            ->orderBy('created_at', 'desc')
            ->first();
        $namaKelas = '-';
        if ($kelasTerbaru) {
            $kelas = \App\Models\Kelas::find($kelasTerbaru->id_kelas);
            $namaKelas = $kelas ? $kelas->nama_kelas : '-';
        }
        
        // Paket aktif
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
        
        // Riwayat pembayaran
        $riwayatPembayaran = TransaksiUmum::where('id_murid', $murid->id_murid)
            ->where('debit', '>', 0)
            ->orderBy('tanggal_bayar', 'desc')
            ->get()
            ->map(function ($item) {
                return (object) [
                    'tanggal'          => $item->tanggal_bayar ? date('d/m/Y', strtotime($item->tanggal_bayar)) : '-',
                    'jenis_pembayaran' => $item->jenis_pembayaran ?? '-',
                    'jumlah'           => 'Rp ' . number_format($item->debit ?? 0, 0, ',', '.'),
                    'keterangan'       => $item->keterangan,
                ];
            });
        
        // Status pendaftaran
        $sudahBayarPendaftaran = TransaksiUmum::where('id_murid', $murid->id_murid)
            ->where('keterangan', 'like', '%Pendaftaran%')
            ->exists();
        
        // Total pembayaran
        $totalBayar = TransaksiUmum::where('id_murid', $murid->id_murid)
            ->where('debit', '>', 0)
            ->sum('debit');
        
        $data = [
            'role'                    => $role,
            'murid'                   => $murid,
            'namaKelas'               => $namaKelas,
            'namaPaket'               => $namaPaket,
            'hargaPerBulan'           => $hargaPerBulan,
            'riwayatPembayaran'       => $riwayatPembayaran,
            'sudahBayarPendaftaran'   => $sudahBayarPendaftaran,
            'totalBayar'              => $totalBayar,
        ];
        
        return view('dashboard.shared.transaksi.detail-pembayaran', $data);
    }

    // =============================================
    // TRANSAKSI PEMASUKAN LAIN
    // =============================================
    public function indexPemasukanLain(Request $request)
    {
        $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        $perPage = $request->get('per_page', 10);
        
        // Ambil data pemasukan non-murid (debit > 0, bukan Pendaftaran & bukan SPP)
        $pemasukanLain = TransaksiUmum::where('debit', '>', 0)
            ->where('keterangan', 'not like', '%Pendaftaran%')
            ->where('keterangan', 'not like', '%SPP%')
            ->orderBy('tanggal_bayar', 'desc')
            ->paginate($perPage)
            ->through(function ($item) {
                return (object)[
                    'id'               => $item->id_transaksi,
                    'tanggal'          => $item->tanggal_bayar ? date('d/m/Y', strtotime($item->tanggal_bayar)) : '-',
                    'sumber'           => str_replace('Pemasukan Lainnya: ', '', $item->keterangan),
                    'jenis_pembayaran' => $item->jenis_pembayaran ?? '-',
                    'jumlah'           => $item->debit ?? 0,
                    'keterangan'       => $item->keterangan,
                ];
            });
        
        $totalBulanIni = TransaksiUmum::where('debit', '>', 0)
            ->where('keterangan', 'not like', '%Pendaftaran%')
            ->where('keterangan', 'not like', '%SPP%')
            ->whereMonth('tanggal_bayar', now()->month)
            ->whereYear('tanggal_bayar', now()->year)
            ->sum('debit');
        
        $totalKeseluruhan = TransaksiUmum::where('debit', '>', 0)
            ->where('keterangan', 'not like', '%Pendaftaran%')
            ->where('keterangan', 'not like', '%SPP%')
            ->sum('debit');
        
        return view('dashboard.shared.transaksi.pemasukan-lain', compact(
            'role', 'pemasukanLain', 'totalBulanIni', 'totalKeseluruhan'
        ));
    }
    // =============================================
    // CREATE PEMASUKAN LAIN
    // =============================================
    public function createPemasukanLain(Request $request)
    {
        $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        return view('dashboard.shared.pembayaran.create-pemasukan-lain', compact('role'));
    }

        // =============================================
    // DETAIL PENGGAJIAN (POP-UP) - CENTINO
    // =============================================
    public function detailPenggajian(Request $request, $id)
    {
        $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        $bulan = $request->get('bulan', now()->month);
        $tahun = $request->get('tahun', now()->year);
        
        $tentor = Pegawai::findOrFail($id);
        
        // Ambil presensi bulan ini
        $presensi = Mengajar::with('kelas')
            ->where('id_pegawai', $tentor->id_pegawai)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->get();
        
        // Hitung per hari (1 hari = 1 sesi)
        $daftarTanggal = $presensi->pluck('tanggal')->unique()->values();
        $hariHadir = $daftarTanggal->count();
        
        $detailPresensi = collect();
        $totalHonor = 0;
        
        foreach ($daftarTanggal as $tanggal) {
            $presensiHarian = $presensi->where('tanggal', $tanggal);
            $adaHadir = $presensiHarian->where('murid_hadir', 'Hadir')->count() > 0;
            $adaTidakHadir = $presensiHarian->where('murid_hadir', 'Tidak Hadir')->count() > 0;
            
            $jenjang = $presensiHarian->first()->kelas->jenjang ?? null;
            $hr = 0;
            
            if ($jenjang == 'SD') $hr = $tentor->hr_sd ?? 0;
            elseif ($jenjang == 'SMP') $hr = $tentor->hr_smp ?? 0;
            elseif ($jenjang == 'SMA') $hr = $tentor->hr_sma ?? 0;
            
            $honorHarian = 0;
            $statusHadir = 'Tidak Hadir';
            
            if ($adaHadir) {
                $honorHarian = $hr;
                $statusHadir = 'Hadir';
                $totalHonor += $hr;
            } elseif ($adaTidakHadir) {
                $honorHarian = $hr / 2;
                $statusHadir = 'Tidak Hadir (50%)';
                $totalHonor += ($hr / 2);
            }
            
            // Ambil nama murid + kelas
            $muridList = $presensiHarian->map(function($p) {
                return [
                    'nama_murid' => $p->nama_murid ?? '-',
                    'kelas' => $p->kelas->nama_kelas ?? '-',
                    'status' => $p->murid_hadir ?? '-',
                ];
            })->toArray();
            
            $detailPresensi->push((object)[
                'tanggal' => Carbon::parse($tanggal)->format('d/m/Y'),
                'hari' => Carbon::parse($tanggal)->translatedFormat('l'),
                'status' => $statusHadir,
                'honor' => $honorHarian,
                'murid_list' => $muridList,
            ]);
        }
        
        $uangMakanPerHari = $tentor->uang_makan ?? 0;
        $totalUangMakan = $hariHadir * $uangMakanPerHari;
        
        $uangTransportPerHari = $tentor->uang_transport ?? 0;
        $totalUangTransport = $hariHadir * $uangTransportPerHari;
        
        $totalGaji = $totalHonor + $totalUangMakan + $totalUangTransport;
        
        $sudahDibayar = TransaksiUmum::where('id_pegawai', $tentor->id_pegawai)
            ->where('kredit', '>', 0)
            ->where('keterangan', 'like', "%Gaji " . Carbon::create()->month($bulan)->translatedFormat('F') . " " . $tahun . "%")
            ->exists();
        
        $data = [
            'role' => $role,
            'tentor' => $tentor,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'namaBulan' => Carbon::create()->month($bulan)->translatedFormat('F'),
            'hariHadir' => $hariHadir,
            'detailPresensi' => $detailPresensi,
            'totalHonor' => $totalHonor,
            'uangMakanPerHari' => $uangMakanPerHari,
            'totalUangMakan' => $totalUangMakan,
            'uangTransportPerHari' => $uangTransportPerHari,
            'totalUangTransport' => $totalUangTransport,
            'totalGaji' => $totalGaji,
            'sudahDibayar' => $sudahDibayar,
        ];
        
        return view('dashboard.shared.transaksi.detail-penggajian', $data);
    }
}