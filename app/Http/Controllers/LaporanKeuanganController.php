<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LaporanKeuangan;
use App\Models\HargaPaket;
use App\Models\Murid;
use Carbon\Carbon;

class LaporanKeuanganController extends Controller
{
    // Menampilkan semua data keuangan
    public function index(Request $request)
    {
        $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        
        $paketList = HargaPaket::orderBy('id_paket', 'asc')->get();
        
        $queryPemasukan = LaporanKeuangan::where('kategori', 'pemasukan');
        $queryPengeluaran = LaporanKeuangan::where('kategori', 'pengeluaran');
        $queryPiutang = LaporanKeuangan::where('kategori', 'piutang');
        $queryUangMuka = LaporanKeuangan::where('kategori', 'uang_muka');
        
        // Filter Bulan
        if ($request->filled('bulan')) {
            $queryPemasukan->whereMonth('tanggal', $request->bulan);
            $queryPengeluaran->whereMonth('tanggal', $request->bulan);
            $queryPiutang->whereMonth('tanggal', $request->bulan);
            $queryUangMuka->whereMonth('tanggal', $request->bulan);
        }
        
        // Filter Tahun
        if ($request->filled('tahun')) {
            $queryPemasukan->whereYear('tanggal', $request->tahun);
            $queryPengeluaran->whereYear('tanggal', $request->tahun);
            $queryPiutang->whereYear('tanggal', $request->tahun);
            $queryUangMuka->whereYear('tanggal', $request->tahun);
        }
        
        // Filter Search (Nama Murid)
        if ($request->filled('search')) {
            $searchTerm = '%' . $request->search . '%';
            $queryPemasukan->where('rincian', 'like', $searchTerm);
            $queryPengeluaran->where('rincian', 'like', $searchTerm);
            $queryPiutang->where('nama_murid', 'like', $searchTerm);
            $queryUangMuka->where('nama_murid', 'like', $searchTerm);
        }
        
        // Filter Paket
        if ($request->filled('paket')) {
            $queryPemasukan->where('rincian', 'like', '%' . $request->paket . '%');
        }
        
        $pemasukan = $queryPemasukan->orderBy('tanggal', 'desc')->get();
        $pengeluaran = $queryPengeluaran->orderBy('tanggal', 'desc')->get();
        $piutang = $queryPiutang->orderBy('tanggal', 'desc')->get();
        $uang_muka = $queryUangMuka->orderBy('tanggal', 'desc')->get();
        
        $totalPemasukan = $pemasukan->sum('jumlah');
        $totalPengeluaran = $pengeluaran->sum('jumlah');
        $totalPiutang = $piutang->sum('jumlah');
        $totalUangMuka = $uang_muka->sum('jumlah');
        $totalPemasukanKas = $totalPemasukan + $totalPiutang + $totalUangMuka;
        $saldoKas = $totalPemasukan - $totalPengeluaran;
        
        $bulanList = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        
        $tahunList = LaporanKeuangan::selectRaw('YEAR(tanggal) as tahun')
            ->distinct()
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
            'paketList' => $paketList,
            'bulanList' => $bulanList,
            'tahunList' => $tahunList,
            'filterBulan' => $request->bulan,
            'filterTahun' => $request->tahun,
            'filterPaket' => $request->paket,
            'filterSearch' => $request->search,
        ]);
    }

    // Form tambah data
    public function create(Request $request)
    {
        $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        
        $muridList = Murid::orderBy('nama_lengkap_murid', 'asc')->get();
        $paketList = HargaPaket::orderBy('id_paket', 'asc')->get();
        
        return view('dashboard.shared.laporan-keuangan.create-laporan-keuangan', [
            'role' => $role,
            'muridList' => $muridList,
            'paketList' => $paketList,
        ]);
    }

    // Simpan data
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'kategori' => 'required|in:pemasukan,pengeluaran,piutang,uang_muka',
            'rincian' => 'required|string|max:255',
            'jumlah' => 'required|numeric|min:0'
        ]);

        // Bersihkan jumlah
        $jumlah = str_replace(['.', ','], '', $request->jumlah);
        $jumlah = (float) $jumlah;
        
        // Siapkan data untuk disimpan
        $data = [
            'tanggal' => $request->tanggal,
            'kategori' => $request->kategori,
            'rincian' => $request->rincian,
            'jumlah' => $jumlah,
            'nama_murid' => $request->nama_murid ?? null,
            'bulan_periode' => $request->bulan_periode ?? null,
        ];
        
        try {
            LaporanKeuangan::create($data);
            
            $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
            
            return redirect()->route($role . '.laporan-keuangan')
                ->with('success', 'Data berhasil ditambahkan');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    // Hapus data
    public function destroy($id)
    {
        $data = LaporanKeuangan::findOrFail($id);
        $data->delete();
        
        $referer = request()->headers->get('referer');
        $role = str_contains($referer, 'superadmin') ? 'superadmin' : 'admin';
        
        return redirect()->route($role . '.laporan-keuangan')->with('success', 'Data berhasil dihapus');
    }
    
    // Laporan rekap per bulan
    public function rekapBulanan(Request $request)
    {
        $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        
        $tahun = $request->tahun ?? Carbon::now()->year;
        
        $rekap = [];
        for ($bulan = 1; $bulan <= 12; $bulan++) {
            $pemasukan = LaporanKeuangan::where('kategori', 'pemasukan')
                ->whereYear('tanggal', $tahun)
                ->whereMonth('tanggal', $bulan)
                ->sum('jumlah');
            
            $pengeluaran = LaporanKeuangan::where('kategori', 'pengeluaran')
                ->whereYear('tanggal', $tahun)
                ->whereMonth('tanggal', $bulan)
                ->sum('jumlah');
            
            $rekap[$bulan] = [
                'bulan' => Carbon::create()->month($bulan)->translatedFormat('F'),
                'pemasukan' => $pemasukan,
                'pengeluaran' => $pengeluaran,
                'saldo' => $pemasukan - $pengeluaran
            ];
        }
        
        $tahunList = LaporanKeuangan::selectRaw('YEAR(tanggal) as tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');
        
        return view('dashboard.shared.laporan-keuangan.rekap-bulanan', [
            'role' => $role,
            'rekap' => $rekap,
            'tahun' => $tahun,
            'tahunList' => $tahunList,
        ]);
    }
    
    // Laporan rekap per murid
    public function rekapPerMurid(Request $request)
    {
        $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        
        $query = LaporanKeuangan::whereIn('kategori', ['pemasukan', 'piutang', 'uang_muka'])
            ->whereNotNull('nama_murid');
        
        if ($request->filled('murid_id')) {
            $murid = Murid::find($request->murid_id);
            if ($murid) {
                $query->where('nama_murid', $murid->nama_lengkap_murid);
            }
        }
        
        if ($request->filled('tahun')) {
            $query->whereYear('tanggal', $request->tahun);
        }
        
        $laporanMurid = $query->orderBy('tanggal', 'desc')->get();
        
        $muridList = Murid::orderBy('nama_lengkap_murid', 'asc')->get();
        $tahunList = LaporanKeuangan::selectRaw('YEAR(tanggal) as tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');
        
        $totalPerMurid = [];
        foreach ($laporanMurid as $item) {
            if (!isset($totalPerMurid[$item->nama_murid])) {
                $totalPerMurid[$item->nama_murid] = 0;
            }
            $totalPerMurid[$item->nama_murid] += $item->jumlah;
        }
        
        return view('dashboard.shared.laporan-keuangan.rekap-per-murid', [
            'role' => $role,
            'laporanMurid' => $laporanMurid,
            'totalPerMurid' => $totalPerMurid,
            'muridList' => $muridList,
            'tahunList' => $tahunList,
            'filterMurid' => $request->murid_id,
            'filterTahun' => $request->tahun,
        ]);
    }
}