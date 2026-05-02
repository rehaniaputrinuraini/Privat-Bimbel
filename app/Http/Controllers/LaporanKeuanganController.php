<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransaksiUmum;
use App\Models\Periode;
use Carbon\Carbon;

class LaporanKeuanganController extends Controller
{
    // ========== LAPORAN PEMASUKAN ==========
    public function pemasukan(Request $request)
    {
        $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        
        $filterBulan = $request->bulan;
        $filterTahun = $request->tahun;
        $filterPeriode = $request->periode;
        $perPage = $request->get('per_page', 10);
        
        $query = TransaksiUmum::where('debit', '>', 0);
        
        if ($filterBulan) $query->whereMonth('tanggal_bayar', $filterBulan);
        if ($filterTahun) $query->whereYear('tanggal_bayar', $filterTahun);
        if ($filterPeriode) $query->where('id_periode', $filterPeriode);
        
        $transaksi = $query->orderBy('tanggal_bayar', 'desc')
            ->orderBy('id_transaksi', 'desc')
            ->paginate($perPage)
            ->appends($request->except('page'))
            ->through(function($item) {
                $isMurid = str_contains($item->keterangan, 'Pendaftaran') || str_contains($item->keterangan, 'SPP');
                return (object)[
                    'id' => $item->id_transaksi,
                    'tanggal' => $item->tanggal_bayar,
                    'keterangan' => $item->keterangan ?? '-',
                    'sumber' => $isMurid ? 'Murid' : 'Manual',
                    'jumlah' => $item->debit ?? 0,
                ];
            });
        
        $totalMurid = TransaksiUmum::where('debit', '>', 0)
            ->where(function($q) {
                $q->where('keterangan', 'like', '%Pendaftaran%')
                  ->orWhere('keterangan', 'like', '%SPP%');
            })
            ->when($filterBulan, fn($q) => $q->whereMonth('tanggal_bayar', $filterBulan))
            ->when($filterTahun, fn($q) => $q->whereYear('tanggal_bayar', $filterTahun))
            ->when($filterPeriode, fn($q) => $q->where('id_periode', $filterPeriode))
            ->sum('debit');
            
        $totalManual = TransaksiUmum::where('debit', '>', 0)
            ->where('keterangan', 'not like', '%Pendaftaran%')
            ->where('keterangan', 'not like', '%SPP%')
            ->when($filterBulan, fn($q) => $q->whereMonth('tanggal_bayar', $filterBulan))
            ->when($filterTahun, fn($q) => $q->whereYear('tanggal_bayar', $filterTahun))
            ->when($filterPeriode, fn($q) => $q->where('id_periode', $filterPeriode))
            ->sum('debit');
        
        $bulanList = ['', 'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        $tahunList = TransaksiUmum::selectRaw('YEAR(tanggal_bayar) as tahun')->distinct()->orderBy('tahun','desc')->pluck('tahun');
        $periodeList = Periode::orderBy('id_periode', 'desc')->get();
        
        return view('dashboard.shared.laporan-keuangan.laporan-pemasukan', compact(
            'role','transaksi','totalMurid','totalManual','bulanList','tahunList','periodeList','filterBulan','filterTahun','filterPeriode'
        ));
    }
    
    // ========== LAPORAN PENGELUARAN ==========
    public function pengeluaran(Request $request)
    {
        $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        
        $filterBulan = $request->bulan;
        $filterTahun = $request->tahun;
        $filterPeriode = $request->periode;
        $perPage = $request->get('per_page', 10);
        
        $query = TransaksiUmum::where('kredit', '>', 0)
            ->where('keterangan', 'not like', '%Gaji%')
            ->where('keterangan', 'not like', '%Honor%');
        
        if ($filterBulan) $query->whereMonth('tanggal_bayar', $filterBulan);
        if ($filterTahun) $query->whereYear('tanggal_bayar', $filterTahun);
        if ($filterPeriode) $query->where('id_periode', $filterPeriode);
        
        $transaksi = $query->orderBy('tanggal_bayar', 'desc')
            ->orderBy('id_transaksi', 'desc')
            ->paginate($perPage)
            ->appends($request->except('page'))
            ->through(function($item) {
                return (object)[
                    'id' => $item->id_transaksi,
                    'tanggal' => $item->tanggal_bayar,
                    'keterangan' => str_replace('Pengeluaran: ', '', $item->keterangan ?? '-'),
                    'jumlah' => $item->kredit ?? 0,
                ];
            });
        
        $totalPengeluaran = TransaksiUmum::where('kredit', '>', 0)
            ->where('keterangan', 'not like', '%Gaji%')
            ->where('keterangan', 'not like', '%Honor%')
            ->when($filterBulan, fn($q) => $q->whereMonth('tanggal_bayar', $filterBulan))
            ->when($filterTahun, fn($q) => $q->whereYear('tanggal_bayar', $filterTahun))
            ->when($filterPeriode, fn($q) => $q->where('id_periode', $filterPeriode))
            ->sum('kredit');
        
        $bulanList = ['', 'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        $tahunList = TransaksiUmum::selectRaw('YEAR(tanggal_bayar) as tahun')->distinct()->orderBy('tahun','desc')->pluck('tahun');
        $periodeList = Periode::orderBy('id_periode', 'desc')->get();
        
        return view('dashboard.shared.laporan-keuangan.laporan-pengeluaran', compact(
            'role','transaksi','totalPengeluaran','bulanList','tahunList','periodeList','filterBulan','filterTahun','filterPeriode'
        ));
    }
    
    // ========== LAPORAN PENGGAJIAN ==========
    public function penggajian(Request $request)
    {
        $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        
        $filterBulan = $request->bulan;
        $filterTahun = $request->tahun;
        $filterPeriode = $request->periode;
        $perPage = $request->get('per_page', 10);
        
        $query = TransaksiUmum::where('kredit', '>', 0)
            ->where(function($q) {
                $q->where('keterangan', 'like', '%Gaji%')
                  ->orWhere('keterangan', 'like', '%Honor%');
            });
        
        if ($filterBulan) $query->whereMonth('tanggal_bayar', $filterBulan);
        if ($filterTahun) $query->whereYear('tanggal_bayar', $filterTahun);
        if ($filterPeriode) $query->where('id_periode', $filterPeriode);
        
        $transaksi = $query->orderBy('tanggal_bayar', 'desc')
            ->orderBy('id_transaksi', 'desc')
            ->paginate($perPage)
            ->appends($request->except('page'))
            ->through(function($item) {
                return (object)[
                    'id' => $item->id_transaksi,
                    'tanggal' => $item->tanggal_bayar,
                    'keterangan' => $item->keterangan ?? '-',
                    'jumlah' => $item->kredit ?? 0,
                ];
            });
        
        $totalPenggajian = TransaksiUmum::where('kredit', '>', 0)
            ->where(function($q) {
                $q->where('keterangan', 'like', '%Gaji%')
                  ->orWhere('keterangan', 'like', '%Honor%');
            })
            ->when($filterBulan, fn($q) => $q->whereMonth('tanggal_bayar', $filterBulan))
            ->when($filterTahun, fn($q) => $q->whereYear('tanggal_bayar', $filterTahun))
            ->when($filterPeriode, fn($q) => $q->where('id_periode', $filterPeriode))
            ->sum('kredit');
        
        $bulanList = ['', 'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        $tahunList = TransaksiUmum::selectRaw('YEAR(tanggal_bayar) as tahun')->distinct()->orderBy('tahun','desc')->pluck('tahun');
        $periodeList = Periode::orderBy('id_periode', 'desc')->get();
        
        return view('dashboard.shared.laporan-keuangan.laporan-penggajian', compact(
            'role','transaksi','totalPenggajian','bulanList','tahunList','periodeList','filterBulan','filterTahun','filterPeriode'
        ));
    }
    
    // ========== DESTROY ==========
    public function destroy($id)
    {
        TransaksiUmum::where('id_transaksi', $id)->delete();
        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }
}