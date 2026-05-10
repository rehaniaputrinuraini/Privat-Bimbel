<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransaksiUmum;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanKeuanganController extends Controller
{
    public function index(Request $request)
    {
        $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        $perPage = $request->get('per_page', 10);
        
        // Tipe laporan: 'bulan' atau 'periode'
        $tipe = $request->tipe ?? 'bulan';
        
        // Default ke bulan dan tahun saat ini
        $bulan = $request->bulan ?? date('n');
        $tahun = $request->tahun ?? date('Y');
        $periode = $request->periode ?? $this->getPeriodeSekarang();
        
        // Query transaksi
        $query = TransaksiUmum::orderBy('tanggal_bayar', 'desc');
        
        // Filter kategori
        if ($request->kategori) {
            switch ($request->kategori) {
                case 'Pembayaran Murid':
                    $query->where(function($q) {
                        $q->where('keterangan', 'like', '%Pendaftaran%')
                          ->orWhere('keterangan', 'like', '%SPP%');
                    });
                    break;
                case 'Pemasukan Lainnya':
                    $query->where('debit', '>', 0)
                          ->where('keterangan', 'not like', '%Pendaftaran%')
                          ->where('keterangan', 'not like', '%SPP%');
                    break;
                case 'Pengeluaran Lainnya':
                    $query->where('kredit', '>', 0)
                          ->where('keterangan', 'not like', '%Gaji%')
                          ->where('keterangan', 'not like', '%Penggajian%');
                    break;
                case 'Penggajian':
                    $query->where('kredit', '>', 0)
                          ->where(function($q) {
                              $q->where('keterangan', 'like', '%Gaji%')
                                ->orWhere('keterangan', 'like', '%Penggajian%');
                          });
                    break;
            }
        }
        
        // Filter berdasarkan tipe
        if ($tipe == 'periode') {
            $tahunMulai = substr($periode, 0, 4);
            $tahunAkhir = substr($periode, 5, 4);
            
            $query->where(function($q) use ($tahunMulai, $tahunAkhir) {
                $q->where(function($sub) use ($tahunMulai) {
                    $sub->whereYear('tanggal_bayar', $tahunMulai)
                        ->whereMonth('tanggal_bayar', '>=', 7);
                })->orWhere(function($sub) use ($tahunAkhir) {
                    $sub->whereYear('tanggal_bayar', $tahunAkhir)
                        ->whereMonth('tanggal_bayar', '<=', 6);
                });
            });
        } else {
            if ($bulan) $query->whereMonth('tanggal_bayar', $bulan);
            if ($tahun) $query->whereYear('tanggal_bayar', $tahun);
        }
        
        $laporan = $query->paginate($perPage)->through(function ($item) {
            $isPendaftaran = str_contains($item->keterangan, 'Pendaftaran');
            $isSPP = str_contains($item->keterangan, 'SPP');
            $isGaji = str_contains($item->keterangan, 'Gaji') || str_contains($item->keterangan, 'Penggajian');
            $isPemasukanLain = str_contains($item->keterangan, 'Pemasukan Lainnya');
            
            if ($isPendaftaran || $isSPP) {
                $kategori = 'Pembayaran Murid';
            } elseif ($isPemasukanLain) {
                $kategori = 'Pemasukan Lainnya';
            } elseif ($isGaji) {
                $kategori = 'Penggajian';
            } elseif ($item->kredit > 0) {
                $kategori = 'Pengeluaran Lainnya';
            } else {
                $kategori = 'Pemasukan Lainnya';
            }
            
            return (object)[
                'id' => $item->id_transaksi,
                'tanggal' => $item->tanggal_bayar ? date('d/m/Y', strtotime($item->tanggal_bayar)) : '-',
                'kategori' => $kategori,
                'keterangan' => $item->keterangan,
                'pemasukan' => $item->debit ?? 0,
                'pengeluaran' => $item->kredit ?? 0,
            ];
        });
        
        // Hitung total berdasarkan tipe
        if ($tipe == 'periode') {
            $tahunMulai = substr($periode, 0, 4);
            $tahunAkhir = substr($periode, 5, 4);
            
            $totalPemasukan = TransaksiUmum::where('debit', '>', 0)
                ->where(function($q) use ($tahunMulai, $tahunAkhir) {
                    $q->where(function($sub) use ($tahunMulai) {
                        $sub->whereYear('tanggal_bayar', $tahunMulai)->whereMonth('tanggal_bayar', '>=', 7);
                    })->orWhere(function($sub) use ($tahunAkhir) {
                        $sub->whereYear('tanggal_bayar', $tahunAkhir)->whereMonth('tanggal_bayar', '<=', 6);
                    });
                })->sum('debit');
            
            $totalPengeluaran = TransaksiUmum::where('kredit', '>', 0)
                ->where(function($q) use ($tahunMulai, $tahunAkhir) {
                    $q->where(function($sub) use ($tahunMulai) {
                        $sub->whereYear('tanggal_bayar', $tahunMulai)->whereMonth('tanggal_bayar', '>=', 7);
                    })->orWhere(function($sub) use ($tahunAkhir) {
                        $sub->whereYear('tanggal_bayar', $tahunAkhir)->whereMonth('tanggal_bayar', '<=', 6);
                    });
                })->sum('kredit');
        } else {
            $totalPemasukan = TransaksiUmum::where('debit', '>', 0)
                ->whereMonth('tanggal_bayar', $bulan)
                ->whereYear('tanggal_bayar', $tahun)
                ->sum('debit');
            
            $totalPengeluaran = TransaksiUmum::where('kredit', '>', 0)
                ->whereMonth('tanggal_bayar', $bulan)
                ->whereYear('tanggal_bayar', $tahun)
                ->sum('kredit');
        }
        
        // Data untuk dropdown
        $bulanTersedia = TransaksiUmum::selectRaw('DISTINCT MONTH(tanggal_bayar) as bulan')
            ->whereNotNull('tanggal_bayar')
            ->orderBy('bulan')
            ->pluck('bulan');
        
        $tahunTersedia = TransaksiUmum::selectRaw('DISTINCT YEAR(tanggal_bayar) as tahun')
            ->whereNotNull('tanggal_bayar')
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');
        
        $periodeTersedia = $this->getPeriodeTersedia();
        
        return view('dashboard.shared.laporan-keuangan.laporan-keuangan', compact(
            'role', 'laporan', 'totalPemasukan', 'totalPengeluaran',
            'tipe', 'bulan', 'tahun', 'periode',
            'bulanTersedia', 'tahunTersedia', 'periodeTersedia'
        ));
    }

    public function exportPdf(Request $request)
    {
        $tipe = $request->tipe ?? 'bulan';
        $bulan = $request->bulan ?? date('n');
        $tahun = $request->tahun ?? date('Y');
        $periode = $request->periode ?? $this->getPeriodeSekarang();
        
        $pemasukanData = [
            'Pendaftaran' => 0, 'Bimbingan' => 0, 'Modal_Owner' => 0,
            'TryOut' => 0, 'Lainnya_Pemasukan' => 0,
        ];
        
        $pengeluaranData = [
            'BiayaOperasional' => 0, 'BiayaRapatPelatihan' => 0, 'FeeManagement' => 0,
            'PembelianAktiva' => 0, 'Modul' => 0, 'BiayaAkademik' => 0,
            'BiayaPemasaran' => 0, 'BiayaKeuangan' => 0, 'SetorKePusat' => 0,
            'Lainnya_Pengeluaran' => 0, 'Penggajian' => 0,
        ];
        
        if ($tipe == 'periode') {
            $tahunMulai = substr($periode, 0, 4);
            $tahunAkhir = substr($periode, 5, 4);
            
            $queryPemasukan = TransaksiUmum::where('debit', '>', 0)
                ->where(function($q) use ($tahunMulai, $tahunAkhir) {
                    $q->where(function($sub) use ($tahunMulai) {
                        $sub->whereYear('tanggal_bayar', $tahunMulai)->whereMonth('tanggal_bayar', '>=', 7);
                    })->orWhere(function($sub) use ($tahunAkhir) {
                        $sub->whereYear('tanggal_bayar', $tahunAkhir)->whereMonth('tanggal_bayar', '<=', 6);
                    });
                });
            
            $queryPengeluaran = TransaksiUmum::where('kredit', '>', 0)
                ->where(function($q) use ($tahunMulai, $tahunAkhir) {
                    $q->where(function($sub) use ($tahunMulai) {
                        $sub->whereYear('tanggal_bayar', $tahunMulai)->whereMonth('tanggal_bayar', '>=', 7);
                    })->orWhere(function($sub) use ($tahunAkhir) {
                        $sub->whereYear('tanggal_bayar', $tahunAkhir)->whereMonth('tanggal_bayar', '<=', 6);
                    });
                });
        } else {
            $queryPemasukan = TransaksiUmum::where('debit', '>', 0)
                ->whereMonth('tanggal_bayar', $bulan)
                ->whereYear('tanggal_bayar', $tahun);
            
            $queryPengeluaran = TransaksiUmum::where('kredit', '>', 0)
                ->whereMonth('tanggal_bayar', $bulan)
                ->whereYear('tanggal_bayar', $tahun);
        }
        
        // Proses pemasukan
        foreach ($queryPemasukan->get() as $item) {
            $ket = $item->keterangan;
            if (str_contains($ket, 'Pendaftaran')) {
                $pemasukanData['Pendaftaran'] += $item->debit;
            } elseif (str_contains($ket, 'Bimbingan') || str_contains($ket, 'SPP')) {
                $pemasukanData['Bimbingan'] += $item->debit;
            } elseif (str_contains($ket, 'Modal') || str_contains($ket, 'Owner')) {
                $pemasukanData['Modal_Owner'] += $item->debit;
            } elseif (str_contains($ket, 'Try Out')) {
                $pemasukanData['TryOut'] += $item->debit;
            } else {
                $pemasukanData['Lainnya_Pemasukan'] += $item->debit;
            }
        }
        
        // Proses pengeluaran
        foreach ($queryPengeluaran->get() as $item) {
            $ket = $item->keterangan;
            if (str_contains($ket, 'Operasional') && !str_contains($ket, 'Gaji')) {
                $pengeluaranData['BiayaOperasional'] += $item->kredit;
            } elseif (str_contains($ket, 'Rapat') || str_contains($ket, 'Pelatihan')) {
                $pengeluaranData['BiayaRapatPelatihan'] += $item->kredit;
            } elseif (str_contains($ket, 'Fee') || str_contains($ket, 'Management')) {
                $pengeluaranData['FeeManagement'] += $item->kredit;
            } elseif (str_contains($ket, 'Aktiva')) {
                $pengeluaranData['PembelianAktiva'] += $item->kredit;
            } elseif (str_contains($ket, 'Modul')) {
                $pengeluaranData['Modul'] += $item->kredit;
            } elseif (str_contains($ket, 'Akademik')) {
                $pengeluaranData['BiayaAkademik'] += $item->kredit;
            } elseif (str_contains($ket, 'Pemasaran')) {
                $pengeluaranData['BiayaPemasaran'] += $item->kredit;
            } elseif (str_contains($ket, 'Keuangan')) {
                $pengeluaranData['BiayaKeuangan'] += $item->kredit;
            } elseif (str_contains($ket, 'Setor') || str_contains($ket, 'Pusat')) {
                $pengeluaranData['SetorKePusat'] += $item->kredit;
            } elseif (str_contains($ket, 'Gaji') || str_contains($ket, 'Penggajian')) {
                $pengeluaranData['Penggajian'] += $item->kredit;
            } else {
                $pengeluaranData['Lainnya_Pengeluaran'] += $item->kredit;
            }
        }
        
        $totalPemasukan = array_sum($pemasukanData);
        $totalPengeluaran = array_sum($pengeluaranData);
        $saldoAwal = 0;
        $saldoAkhir = $saldoAwal + $totalPemasukan - $totalPengeluaran;
        
        if ($tipe == 'periode') {
            $judulPeriode = 'PERIODE ' . $periode;
        } else {
            $judulPeriode = $this->getNamaBulan($bulan) . ' ' . $tahun;
        }
        
        $data = [
            'cabang' => 'UTERAN',
            'periode' => $judulPeriode,
            'saldoAwal' => $saldoAwal,
            'pemasukanData' => $pemasukanData,
            'pengeluaranData' => $pengeluaranData,
            'totalPemasukan' => $totalPemasukan,
            'totalPengeluaran' => $totalPengeluaran,
            'saldoAkhir' => $saldoAkhir,
            'tanggalCetak' => Carbon::now()->translatedFormat('d F Y'),
            'mengetahui' => 'ARIF BUDIMAN',
            'dibuatOleh' => 'NINDYA MAWARNI',
        ];
        
        $pdf = Pdf::loadView('dashboard.shared.laporan-keuangan.laporan-keuangan-pdf', $data);
        $pdf->setPaper('a4', 'portrait');
        
        if ($tipe == 'periode') {
            $filename = 'Laporan_Keuangan_Periode_' . $periode;
        } else {
            $filename = 'Laporan_Keuangan_' . $this->getNamaBulan($bulan) . '_' . $tahun;
        }
        
        return $pdf->download($filename . '.pdf');
    }
    
    private function getNamaBulan($bulan)
    {
        $namaBulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        return $namaBulan[$bulan] ?? 'Semua Bulan';
    }
    
    private function getPeriodeSekarang()
    {
        $tahun = date('Y');
        $bulan = date('n');
        if ($bulan >= 7) {
            return $tahun . '/' . ($tahun + 1);
        } else {
            return ($tahun - 1) . '/' . $tahun;
        }
    }
    
    private function getPeriodeTersedia()
    {
        $tahunList = TransaksiUmum::selectRaw('DISTINCT YEAR(tanggal_bayar) as tahun')
            ->whereNotNull('tanggal_bayar')
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');
        
        $periodeList = [];
        foreach ($tahunList as $tahun) {
            $periodeList[] = $tahun . '/' . ($tahun + 1);
            if ($tahun > date('Y') - 5) {
                $periodeList[] = ($tahun - 1) . '/' . $tahun;
            }
        }
        $periodeList = array_unique($periodeList);
        sort($periodeList);
        return $periodeList;
    }
}