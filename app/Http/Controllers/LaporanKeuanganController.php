<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransaksiUmum;
use App\Models\Penggajian;
use App\Models\Pembayaran;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanKeuanganController extends Controller
{
    public function index(Request $request)
    {
        $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        $perPage = $request->get('per_page', 10);
        
        // Default ke bulan dan tahun saat ini jika tidak ada filter
        $bulan = $request->bulan ?? date('n');
        $tahun = $request->tahun ?? date('Y');
        
        // Query semua transaksi
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
                case 'Pengeluaran':
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
        
        // Filter BULAN (WAJIB - default bulan saat ini)
        $query->whereMonth('tanggal_bayar', $bulan);
        
        // Filter TAHUN (WAJIB - default tahun saat ini)
        $query->whereYear('tanggal_bayar', $tahun);
        
        $laporan = $query->paginate($perPage)->through(function ($item) {
            $isPendaftaran = str_contains($item->keterangan, 'Pendaftaran');
            $isSPP = str_contains($item->keterangan, 'SPP');
            $isGaji = str_contains($item->keterangan, 'Gaji') || str_contains($item->keterangan, 'Penggajian');
            $isPemasukanLain = str_contains($item->keterangan, 'Pemasukan Lainnya');
            
            // Tentukan kategori
            if ($isPendaftaran || $isSPP) {
                $kategori = 'Pembayaran Murid';
            } elseif ($isPemasukanLain) {
                $kategori = 'Pemasukan Lainnya';
            } elseif ($isGaji) {
                $kategori = 'Penggajian';
            } elseif ($item->kredit > 0) {
                $kategori = 'Pengeluaran';
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
        
        // Total pemasukan berdasarkan filter bulan & tahun
        $totalPemasukan = TransaksiUmum::where('debit', '>', 0)
                            ->whereMonth('tanggal_bayar', $bulan)
                            ->whereYear('tanggal_bayar', $tahun)
                            ->sum('debit');
        
        // Total pengeluaran berdasarkan filter bulan & tahun
        $totalPengeluaran = TransaksiUmum::where('kredit', '>', 0)
                             ->whereMonth('tanggal_bayar', $bulan)
                             ->whereYear('tanggal_bayar', $tahun)
                             ->sum('kredit');
        
        return view('dashboard.shared.laporan-keuangan.laporan-keuangan', compact(
            'role', 'laporan', 'totalPemasukan', 'totalPengeluaran'
        ));
    }

    /**
     * Export PDF Laporan Keuangan format Rekap Kas
     */
    public function exportPdf(Request $request)
    {
        $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        
        // Default ke bulan dan tahun saat ini jika tidak ada filter
        $bulan = $request->bulan ?? date('n');
        $tahun = $request->tahun ?? date('Y');
        
        // Ambil data pemasukan per kategori
        $pemasukanData = [
            'Pendaftaran' => 0,
            'Bimbingan' => 0,
            'Modal_Owner' => 0,
            'TryOut' => 0,
            'Lainnya_Pemasukan' => 0,
        ];
        
        // Ambil data pengeluaran per kategori
        $pengeluaranData = [
            'BiayaOperasional' => 0,
            'BiayaRapatPelatihan' => 0,
            'FeeManagement' => 0,
            'PembelianAktiva' => 0,
            'Modul' => 0,
            'BiayaAkademik' => 0,
            'BiayaPemasaran' => 0,
            'BiayaKeuangan' => 0,
            'SetorKePusat' => 0,
            'Lainnya_Pengeluaran' => 0,
            'Penggajian' => 0,
        ];
        
        // Query pemasukan dengan filter bulan & tahun
        $queryPemasukan = TransaksiUmum::where('debit', '>', 0)
                            ->whereMonth('tanggal_bayar', $bulan)
                            ->whereYear('tanggal_bayar', $tahun);
        
        // Query pengeluaran dengan filter bulan & tahun
        $queryPengeluaran = TransaksiUmum::where('kredit', '>', 0)
                             ->whereMonth('tanggal_bayar', $bulan)
                             ->whereYear('tanggal_bayar', $tahun);
        
        // Proses pemasukan
        $pemasukan = $queryPemasukan->get();
        foreach ($pemasukan as $item) {
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
        $pengeluaran = $queryPengeluaran->get();
        foreach ($pengeluaran as $item) {
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
        
        // Hitung total
        $totalPemasukan = array_sum($pemasukanData);
        $totalPengeluaran = array_sum($pengeluaranData);
        
        // Saldo kas akhir
        $saldoAwal = 0;
        $saldoAkhir = $saldoAwal + $totalPemasukan - $totalPengeluaran;
        
        // Data untuk PDF
        $data = [
            'cabang' => 'UTERAN',
            'periode' => $this->getNamaBulan($bulan) . ' ' . $tahun,
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
        
        return $pdf->download('Laporan_Keuangan_' . $data['periode'] . '.pdf');
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
}