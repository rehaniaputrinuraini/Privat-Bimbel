<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransaksiUmum;
use App\Models\Murid;
use App\Models\HargaPaket;
use Carbon\Carbon;

class LaporanKeuanganController extends Controller
{
    // ========== HALAMAN INDEX ==========
    public function index(Request $request)
    {
        $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        
        $filterBulan = $request->bulan;
        $filterTahun = $request->tahun;
        
        // ========== QUERY DASAR ==========
        $query = TransaksiUmum::with('murid');
        
        if ($filterBulan) {
            $query->whereMonth('tanggal_bayar', $filterBulan);
        }
        
        if ($filterTahun) {
            $query->whereYear('tanggal_bayar', $filterTahun);
        }
        
        // ========== PEMASUKAN (SEMUA DEBIT) ==========
        $pemasukan = (clone $query)->orderBy('tanggal_bayar', 'desc')->get()->map(function($item) {
            $isPendaftaran = str_contains($item->keterangan, 'Pendaftaran');
            $isManual = !$isPendaftaran && !str_contains($item->keterangan, 'SPP');
            
            return (object)[
                'id' => ($isPendaftaran ? 'P' : 'M') . $item->id_transaksi,
                'tanggal' => $item->tanggal_bayar,
                'rincian' => $item->keterangan ?? 'Pemasukan',
                'jenis_pembayaran' => $item->jenis_pembayaran ?? '-',
                'jumlah' => $item->debit ?? 0,
                'sumber' => $isPendaftaran ? 'pendaftaran' : ($isManual ? 'manual' : 'pembayaran'),
            ];
        })->filter(function($item) {
            return $item->jumlah > 0;
        })->values();
        
        // ========== PENGELUARAN (SEMUA KREDIT) ==========
        $pengeluaran = (clone $query)->where('kredit', '>', 0)->orderBy('tanggal_bayar', 'desc')->get()->map(function($item) {
            return (object)[
                'id' => 'K' . $item->id_transaksi,
                'tanggal' => $item->tanggal_bayar,
                'rincian' => $item->keterangan ?? 'Pengeluaran',
                'jenis_pembayaran' => $item->jenis_pembayaran ?? '-',
                'jumlah' => $item->kredit ?? 0,
            ];
        });
        
        // ========== PIUTANG & UANG MUKA (DARI SPP) ==========
        $piutang = collect();
        $uang_muka = collect();
        
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        
        $sppTransactions = TransaksiUmum::with('murid')
            ->where('keterangan', 'like', '%SPP%')
            ->get();
        
        foreach ($sppTransactions as $item) {
            preg_match('/SPP\s+(\w+)\s+(\d+)/', $item->keterangan, $matches);
            
            if (isset($matches[1]) && isset($matches[2])) {
                try {
                    $bulanDibayar = Carbon::parse($matches[1])->month;
                    $tahunDibayar = (int)$matches[2];
                    
                    $data = (object)[
                        'id' => ($bulanDibayar > $currentMonth ? 'W' : 'T') . $item->id_transaksi,
                        'tanggal' => $item->tanggal_bayar,
                        'nama_murid' => $item->murid->nama_lengkap ?? 'Tidak Diketahui',
                        'bulan_periode' => $matches[1] . ' ' . $matches[2],
                        'jumlah' => $item->debit ?? 0,
                        'sumber' => 'pembayaran',
                    ];
                    
                    // Bulan depan = Uang Muka
                    if ($tahunDibayar > $currentYear || 
                        ($tahunDibayar == $currentYear && $bulanDibayar > $currentMonth)) {
                        $uang_muka->push($data);
                    }
                    // Bulan lalu = Piutang (jika belum lunas)
                    elseif ($tahunDibayar < $currentYear || 
                        ($tahunDibayar == $currentYear && $bulanDibayar < $currentMonth)) {
                        $murid = $item->murid;
                        if ($murid) {
                            $paketAktif = \App\Models\TransaksiPaket::where('id_murid', $murid->id_murid)->first();
                            if ($paketAktif) {
                                $hargaPaket = HargaPaket::find($paketAktif->id_paket);
                                if ($hargaPaket && $item->debit < $hargaPaket->harga) {
                                    $data->jumlah = $hargaPaket->harga - $item->debit;
                                    $piutang->push($data);
                                }
                            }
                        }
                    }
                } catch (\Exception $e) {
                    continue;
                }
            }
        }
        
        // ========== HITUNG TOTAL ==========
        $totalPemasukan = $pemasukan->sum('jumlah');
        $totalPengeluaran = $pengeluaran->sum('jumlah');
        $totalPiutang = $piutang->sum('jumlah');
        $totalUangMuka = $uang_muka->sum('jumlah');
        $totalPemasukanKas = $totalPemasukan + $totalPiutang + $totalUangMuka;
        $saldoKas = $totalPemasukanKas - $totalPengeluaran;
        
        // ========== BULAN LIST ==========
        $bulanList = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        
        // ========== TAHUN LIST ==========
        $tahunList = TransaksiUmum::selectRaw('YEAR(tanggal_bayar) as tahun')
            ->distinct()
            ->whereNotNull('tanggal_bayar')
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');
        
        return view('dashboard.shared.laporan-keuangan.laporan-keuangan', [
            'role' => $role,
            'pemasukan' => $pemasukan,
            'pengeluaran' => $pengeluaran,
            'piutang' => $piutang,
            'uang_muka' => $uang_muka,
            'totalPemasukan' => $totalPemasukan,
            'totalPengeluaran' => $totalPengeluaran,
            'totalPiutang' => $totalPiutang,
            'totalUangMuka' => $totalUangMuka,
            'totalPemasukanKas' => $totalPemasukanKas,
            'saldoKas' => $saldoKas,
            'bulanList' => $bulanList,
            'tahunList' => $tahunList,
            'filterBulan' => $filterBulan,
            'filterTahun' => $filterTahun,
        ]);
    }

    // ========== FORM CREATE ==========
    public function create(Request $request)
    {
        $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        
        return view('dashboard.shared.laporan-keuangan.create-laporan-keuangan', [
            'role' => $role,
        ]);
    }

    // ========== STORE ==========
    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'kategori' => 'required|in:pemasukan,pengeluaran',
            'jenis_pembayaran' => 'required|in:Tunai,Transfer',
            'rincian' => 'required|string|max:255',
            'jumlah' => 'required|numeric|min:0',
        ]);

        $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        
        // Pemasukan = debit, Pengeluaran = kredit
        $debit = $request->kategori == 'pemasukan' ? $request->jumlah : 0;
        $kredit = $request->kategori == 'pengeluaran' ? $request->jumlah : 0;
        
        TransaksiUmum::create([
            'tanggal_bayar' => $request->tanggal,
            'bulan' => (int) date('m', strtotime($request->tanggal)), // 👈 PERBAIKI: ambil bulan dari tanggal
            'jenis_pembayaran' => $request->jenis_pembayaran,
            'keterangan' => $request->rincian,
            'debit' => $debit,
            'kredit' => $kredit,
        ]);
        
        return redirect()->route($role . '.laporan-keuangan')
            ->with('success', 'Data berhasil ditambahkan');
    }

    // ========== DESTROY ==========
    public function destroy($id)
    {
        $role = request()->is('superadmin*') ? 'superadmin' : 'admin';
        
        // Hapus prefix (P/K/M/W/T) untuk dapatkan id asli
        $realId = (int) substr($id, 1); // 👈 PASTIKAN jadi integer
        
        if ($realId > 0) {
            TransaksiUmum::where('id_transaksi', $realId)->delete();
        }
        
        return redirect()->route($role . '.laporan-keuangan')
            ->with('success', 'Data berhasil dihapus');
    }
}