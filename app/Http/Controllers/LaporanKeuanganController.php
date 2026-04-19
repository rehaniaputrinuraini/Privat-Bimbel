<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembayaran;
use App\Models\TransaksiUmum;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LaporanKeuanganController extends Controller
{
    // ========== HALAMAN INDEX ==========
    public function index(Request $request)
    {
        $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        
        $filterBulan = $request->bulan;
        $filterTahun = $request->tahun;
        
        // ========== DATA DARI tr_transaksi ==========
        
        // 1. PEMASUKAN PENDaftaran
        $queryPemasukanPendaftaran = Pembayaran::whereNotNull('paket_awal')
            ->whereNull('paket_selanjutnya');
        
        // 2. PEMASUKAN MANUAL (dari ms_transaksi via transaksiUmum)
        $queryPemasukanManual = Pembayaran::whereHas('transaksiUmum', function($q) {
            $q->where('kategori', 'pemasukan');
        });
        
        // 3. PENGELUARAN MANUAL
        $queryPengeluaran = Pembayaran::whereHas('transaksiUmum', function($q) {
            $q->where('kategori', 'pengeluaran');
        });
        
        // 4. PIUTANG (Tunggakan)
        $queryPiutang = Pembayaran::whereNotNull('paket_selanjutnya')
            ->where('status_tagihan', 'tunggak');
        
        // 5. UANG MUKA (dari pembayaran bulanan)
        $queryUangMuka = Pembayaran::whereNotNull('paket_selanjutnya')
            ->where('status_tagihan', 'uang_muka');
        
        // Filter Bulan & Tahun
        if ($filterBulan) {
            $queryPemasukanPendaftaran->whereMonth('tanggal', $filterBulan);
            $queryPemasukanManual->whereMonth('tanggal', $filterBulan);
            $queryPengeluaran->whereMonth('tanggal', $filterBulan);
            $queryPiutang->whereMonth('tanggal', $filterBulan);
            $queryUangMuka->whereMonth('tanggal', $filterBulan);
        }
        
        if ($filterTahun) {
            $queryPemasukanPendaftaran->whereYear('tanggal', $filterTahun);
            $queryPemasukanManual->whereYear('tanggal', $filterTahun);
            $queryPengeluaran->whereYear('tanggal', $filterTahun);
            $queryPiutang->whereYear('tanggal', $filterTahun);
            $queryUangMuka->whereYear('tanggal', $filterTahun);
        }
        
        // ========== GABUNGKAN DATA PEMASUKAN ==========
        $pemasukan = collect();
        
        // A. Pemasukan dari Pendaftaran
        $pendaftaranMurid = $queryPemasukanPendaftaran->with('murid')->orderBy('tanggal', 'desc')->get();
        foreach ($pendaftaranMurid as $item) {
            $pemasukan->push((object)[
                'id' => 'P' . $item->id_pembayaran,
                'tanggal' => $item->tanggal,
                'rincian' => 'Pendaftaran - ' . ($item->murid->nama_lengkap ?? 'Tidak Diketahui'),
                'jenis_pembayaran' => '-',
                'jumlah' => $item->paket_awal ?? 100000,
                'sumber' => 'pendaftaran',
            ]);
        }
        
        // B. Pemasukan Manual
        $pemasukanManual = $queryPemasukanManual->with('transaksiUmum')->orderBy('tanggal', 'desc')->get();
        foreach ($pemasukanManual as $item) {
            $pemasukan->push((object)[
                'id' => 'M' . $item->id_pembayaran,
                'tanggal' => $item->tanggal,
                'rincian' => $item->transaksiUmum->keterangan ?? 'Pemasukan Manual',
                'jenis_pembayaran' => $item->transaksiUmum->jenis_pembayaran ?? '-',
                'jumlah' => $item->total_pembayaran ?? 0,
                'sumber' => 'manual',
            ]);
        }
        
        $pemasukan = $pemasukan->sortByDesc('tanggal')->values();
        
        // ========== PENGELUARAN ==========
        $pengeluaran = $queryPengeluaran->with('transaksiUmum')->orderBy('tanggal', 'desc')->get()->map(function($item) {
            return (object)[
                'id' => 'K' . $item->id_pembayaran,
                'tanggal' => $item->tanggal,
                'rincian' => $item->transaksiUmum->keterangan ?? 'Pengeluaran',
                'jenis_pembayaran' => $item->transaksiUmum->jenis_pembayaran ?? '-',
                'jumlah' => $item->total_pembayaran ?? 0,
            ];
        });
        
        // ========== PIUTANG ==========
        $piutang = $queryPiutang->with('murid')->orderBy('tanggal', 'desc')->get()->map(function($item) {
            $bulanPeriode = $item->bulan_dibayar 
                ? Carbon::create()->month($item->bulan_dibayar)->translatedFormat('F') . ' ' . $item->tahun_dibayar
                : '-';
            return (object)[
                'id' => 'T' . $item->id_pembayaran,
                'tanggal' => $item->tanggal,
                'nama_murid' => $item->murid->nama_lengkap ?? 'Tidak Diketahui',
                'bulan_periode' => $bulanPeriode,
                'jumlah' => $item->total_piutang ?? 0,
                'sumber' => 'pembayaran',
            ];
        });
        
        // ========== UANG MUKA ==========
        $uang_muka = $queryUangMuka->with('murid')->orderBy('tanggal', 'desc')->get()->map(function($item) {
            $bulanPeriode = $item->bulan_dibayar 
                ? Carbon::create()->month($item->bulan_dibayar)->translatedFormat('F') . ' ' . $item->tahun_dibayar
                : '-';
            return (object)[
                'id' => 'W' . $item->id_pembayaran,
                'tanggal' => $item->tanggal,
                'nama_murid' => $item->murid->nama_lengkap ?? 'Tidak Diketahui',
                'bulan_periode' => $bulanPeriode,
                'jumlah' => $item->total_uang_muka ?? 0, // ✅ AMBIL DARI total_uang_muka
                'sumber' => 'pembayaran',
            ];
        });
        
        // ========== HITUNG TOTAL ==========
        $totalPemasukan = $pemasukan->sum('jumlah');
        $totalPengeluaran = $pengeluaran->sum('jumlah');
        $totalPiutang = $piutang->sum('jumlah');
        $totalUangMuka = $uang_muka->sum('jumlah'); // ✅ TOTAL DARI UANG MUKA
        $totalPemasukanKas = $totalPemasukan + $totalPiutang + $totalUangMuka;
        $saldoKas = $totalPemasukanKas - $totalPengeluaran;
        
        // ========== BULAN LIST ==========
        $bulanList = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        
        // ========== TAHUN LIST ==========
        $tahunPembayaran = Pembayaran::selectRaw('YEAR(tanggal) as tahun')
            ->distinct()
            ->whereNotNull('tanggal');
            
        $tahunTransaksiUmum = TransaksiUmum::selectRaw('YEAR(tanggal_bayar) as tahun')
            ->distinct()
            ->whereNotNull('tanggal_bayar');
            
        $tahunList = $tahunPembayaran->union($tahunTransaksiUmum)
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
        
        DB::beginTransaction();
        
        try {
            // 1. Insert ke ms_transaksi (DETAIL)
            $idTransaksi = DB::table('ms_transaksi')->insertGetId([
                'tanggal_bayar' => $request->tanggal,
                'kategori' => $request->kategori,
                'jenis_pembayaran' => $request->jenis_pembayaran,
                'keterangan' => $request->rincian,
                'status_bayar' => 'Sudah',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            // 2. Insert ke tr_transaksi (TOTAL)
            Pembayaran::create([
                'id_transaksi' => $idTransaksi,
                'tanggal' => $request->tanggal,
                'paket_awal' => null,
                'paket_selanjutnya' => null,
                'total_pembayaran' => $request->jumlah,
                'status_tagihan' => 'lunas',
            ]);
            
            DB::commit();
            
            return redirect()->route($role . '.laporan-keuangan')
                ->with('success', 'Data berhasil ditambahkan');
                
        } catch (\Exception $e) {
            DB::rollback();
            
            return back()->withInput()
                ->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    // ========== DESTROY ==========
    public function destroy($id)
    {
        $role = request()->is('superadmin*') ? 'superadmin' : 'admin';
        
        $prefix = substr($id, 0, 1);
        $realId = substr($id, 1);
        
        if (in_array($prefix, ['M', 'K'])) {
            // Hapus dari tr_transaksi dan ms_transaksi
            $pembayaran = Pembayaran::find($realId);
            if ($pembayaran) {
                DB::table('ms_transaksi')->where('id_transaksi', $pembayaran->id_transaksi)->delete();
                $pembayaran->delete();
            }
        } elseif (in_array($prefix, ['P', 'T', 'W'])) {
            // Hapus dari tr_transaksi (pembayaran murid)
            Pembayaran::where('id_pembayaran', $realId)->delete();
        }
        
        return redirect()->route($role . '.laporan-keuangan')
            ->with('success', 'Data berhasil dihapus');
    }
}