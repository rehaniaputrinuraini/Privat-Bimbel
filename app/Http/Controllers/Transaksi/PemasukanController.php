<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Murid;
use App\Models\HargaPaket;
use App\Models\TransaksiKelas;
use App\Models\TransaksiPaket;
use App\Models\TransaksiUmum;
use App\Models\Periode;
use Carbon\Carbon;

class PemasukanController extends Controller
{
    public function index(Request $request)
    {
        $role      = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        $paketList = HargaPaket::orderBy('id_paket', 'asc')->get();
        $perPage   = $request->get('per_page', 10);

        $currentMonth = Carbon::now()->month;
        $currentYear  = Carbon::now()->year;
        $murids       = Murid::all();
        $tagihan      = collect();

        foreach ($murids as $murid) {
            // Kelas
            $kelasTerbaru = TransaksiKelas::where('id_murid', $murid->id_murid)
                ->orderBy('created_at', 'desc')->first();
            $namaKelas = '-';
            if ($kelasTerbaru) {
                $kelas     = \App\Models\Kelas::find($kelasTerbaru->id_kelas);
                $namaKelas = $kelas ? $kelas->nama_kelas : '-';
            }

            // Paket aktif
            $paketAktif    = TransaksiPaket::where('id_murid', $murid->id_murid)
                ->orderBy('id_paket_murid', 'desc')->first();
            $namaPaket     = '-';
            $hargaPerBulan = 0;
            if ($paketAktif) {
                $paket = HargaPaket::find($paketAktif->id_paket);
                if ($paket) {
                    $namaPaket     = $paket->tingkat;
                    $hargaPerBulan = $paket->harga;
                }
            }

            // Cek pendaftaran
            $sudahBayarPendaftaran = TransaksiUmum::where('id_murid', $murid->id_murid)
                ->where('keterangan', 'like', '%Pendaftaran%')
                ->exists();

            // Ambil semua pembayaran SPP - fleksibel handle semua format
            $semuaPembayaranSPP = TransaksiUmum::where('id_murid', $murid->id_murid)
                ->where('keterangan', 'like', '%SPP%')
                ->where('debit', '>', 0)
                ->get();

            // Bulan mulai dari tanggal daftar
            $bulanMulai = 1;
            if ($murid->tanggal_daftar) {
                $bulanMulai = (int) date('m', strtotime($murid->tanggal_daftar));
            }

            // 🔥 Hitung uang muka (bayar bulan depan)
            $totalUangMuka     = 0;
            $uangMukaBulanList = [];
            foreach ($semuaPembayaranSPP as $pemb) {
                if (preg_match('/SPP\s+(\w+)\s+(\d+)/', $pemb->keterangan, $matches)) {
                    try {
                        $bulanDibayar  = Carbon::parse($matches[1])->month;
                        $tahunDibayar  = (int) $matches[2];
                        $bulanTahunStr = $matches[1] . ' ' . $matches[2];
                        if ($tahunDibayar > $currentYear ||
                           ($tahunDibayar == $currentYear && $bulanDibayar > $currentMonth)) {
                            $totalUangMuka       += $pemb->debit;
                            $uangMukaBulanList[]  = $bulanTahunStr;
                        }
                    } catch (\Exception $e) {
                        continue;
                    }
                }
            }

            // 🔥 Hitung bulan yang belum dibayar (piutang)
            $bulanBelumDibayar = [];
            $totalPiutang      = 0;
            for ($i = $bulanMulai; $i <= $currentMonth; $i++) {
                // 🔥 FIX: skip bulan daftar jika belum bayar pendaftaran
                if ($i == $bulanMulai && !$sudahBayarPendaftaran) {
                    continue;
                }

                $bulanTahun   = Carbon::create()->month($i)->translatedFormat('F') . ' ' . $currentYear;
                $sudahDibayar = false;

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

            // Tentukan status tagihan
            $statusTagihan       = '-';
            $statusPembayaran    = '-';
            $tagihanBulan        = '-';
            $totalPiutangDisplay = '-';
            $uangMukaDisplay     = '-';

            if (!$sudahBayarPendaftaran) {
                $statusTagihan       = 'Belum Daftar';
                $statusPembayaran    = '-';
                $tagihanBulan        = 'Pendaftaran';
                $totalPiutangDisplay = 'Rp 100.000';
                $uangMukaDisplay     = '-';
            } elseif ($totalUangMuka > 0 && $totalPiutang == 0) {
                // Sudah bayar semua + ada uang muka
                $statusTagihan       = 'Tidak Ada';
                $statusPembayaran    = 'Lunas';
                $tagihanBulan        = '-';
                $totalPiutangDisplay = '-';
                $uangMukaDisplay     = 'Rp ' . number_format($totalUangMuka, 0, ',', '.');
            } elseif ($totalPiutang > 0) {
                // Ada tunggakan
                $statusTagihan       = 'Ada';
                $statusPembayaran    = 'Belum';
                $tagihanBulan        = implode(', ', $bulanBelumDibayar);
                $totalPiutangDisplay = 'Rp ' . number_format($totalPiutang, 0, ',', '.');
                $uangMukaDisplay     = '-';
            } else {
                // Semua lunas
                $statusTagihan       = 'Tidak Ada';
                $statusPembayaran    = 'Lunas';
                $tagihanBulan        = '-';
                $totalPiutangDisplay = '-';
                $uangMukaDisplay     = '-';
            }

            $tagihan->push((object) [
                'id_murid'           => $murid->id_murid,
                'nama_murid'         => $murid->nama_lengkap,
                'kelas'              => $namaKelas,
                'paket'              => $namaPaket,
                'status_pendaftaran' => $sudahBayarPendaftaran ? 'Lunas' : 'Belum',
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

        $totalBulanIni    = TransaksiUmum::where('debit', '>', 0)
            ->whereMonth('tanggal_bayar', now()->month)
            ->whereYear('tanggal_bayar', now()->year)
            ->sum('debit');
        $totalKeseluruhan = TransaksiUmum::where('debit', '>', 0)->sum('debit');
        $totalMurid       = TransaksiUmum::where('debit', '>', 0)->where(function ($q) {
            $q->where('keterangan', 'like', '%Pendaftaran%')
              ->orWhere('keterangan', 'like', '%SPP%');
        })->sum('debit');
        $totalLainnya     = TransaksiUmum::where('debit', '>', 0)
            ->where('keterangan', 'not like', '%Pendaftaran%')
            ->where('keterangan', 'not like', '%SPP%')
            ->sum('debit');

        $periodeList  = Periode::orderBy('tahun_periode', 'desc')->get();
        $today        = date('Y-m-d');
        $periodeAktif = Periode::where('tanggal_mulai', '<=', $today)
            ->where('tanggal_selesai', '>=', $today)
            ->first();

        return view('dashboard.shared.transaksi.pemasukan', compact(
            'role', 'tagihan', 'pemasukan', 'paketList', 'periodeList', 'periodeAktif',
            'totalBulanIni', 'totalKeseluruhan', 'totalMurid', 'totalLainnya'
        ));
    }
}