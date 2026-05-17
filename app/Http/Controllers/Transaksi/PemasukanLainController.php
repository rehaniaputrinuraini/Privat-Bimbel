<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TransaksiUmum;
use App\Models\Periode;
use Carbon\Carbon;

class PemasukanLainController extends Controller
{
    public function index(Request $request)
    {
        $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        $perPage = $request->get('per_page', 10);
        
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
        
        $periodeList = Periode::orderBy('tahun_periode', 'desc')->get();
        
        $today = date('Y-m-d');
        $periodeAktif = Periode::where('tanggal_mulai', '<=', $today)
            ->where('tanggal_selesai', '>=', $today)
            ->first();
        
        return view('dashboard.shared.transaksi.pemasukan-lain', compact(
            'role', 'pemasukanLain', 'totalBulanIni', 'totalKeseluruhan',
            'periodeList', 'periodeAktif'
        ));
    }

    public function create(Request $request)
    {
        $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        return view('dashboard.shared.pembayaran.create-pemasukan-lain', compact('role'));
    }

    public function store(Request $request)
    {
        $today       = date('Y-m-d');
        $periodeAktif = Periode::where('tanggal_mulai', '<=', $today)
            ->where('tanggal_selesai', '>=', $today)
            ->first();

        if (!$periodeAktif) {
            return response()->json(['success' => false, 'message' => 'Tidak ada periode aktif!']);
        }

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

    public function destroy(Request $request, $hashId)
    {
        try {
            $id = unhash_id($hashId);
            if (!$id) {
                return redirect()->back()->with('error', 'Data tidak valid');
            }
            
            $transaksi = TransaksiUmum::findOrFail($id);
            
            if (str_contains($transaksi->keterangan, 'Pendaftaran') || 
                str_contains($transaksi->keterangan, 'SPP')) {
                return redirect()->back()->with('error', 'Tidak dapat menghapus pembayaran murid di sini!');
            }
            
            $transaksi->delete();
            
            $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
            return redirect()->route($role . '.transaksi.pemasukan-lain')
                ->with('success', 'Data pemasukan lain berhasil dihapus');
                
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}