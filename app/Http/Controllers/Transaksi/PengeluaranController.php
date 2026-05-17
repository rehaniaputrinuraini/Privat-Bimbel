<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TransaksiUmum;
use App\Models\Periode;
use Carbon\Carbon;

class PengeluaranController extends Controller
{
    public function index(Request $request)
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
        
        $periodeList = Periode::orderBy('tahun_periode', 'desc')->get();
        
        $today = date('Y-m-d');
        $periodeAktif = Periode::where('tanggal_mulai', '<=', $today)
            ->where('tanggal_selesai', '>=', $today)
            ->first();
        
        return view('dashboard.shared.transaksi.pengeluaran', compact(
            'role', 'pengeluaran', 'totalBulanIni', 'totalKeseluruhan',
            'periodeList', 'periodeAktif'
        ));
    }

    public function create(Request $request)
    {
        $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        return view('dashboard.shared.pembayaran.create-pengeluaran', compact('role'));
    }

    public function store(Request $request)
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

    public function destroy(Request $request, $hashId)
    {
        try {
            $id = unhash_id($hashId);
            if (!$id) {
                return redirect()->back()->with('error', 'Data tidak valid');
            }
            
            $transaksi = TransaksiUmum::findOrFail($id);
            
            if ($transaksi->kredit <= 0) {
                return redirect()->back()->with('error', 'Data ini bukan pengeluaran!');
            }
            
            if (str_contains($transaksi->keterangan, 'Gaji') || 
                str_contains($transaksi->keterangan, 'Honor')) {
                return redirect()->back()->with('error', 'Tidak dapat menghapus data penggajian di halaman ini!');
            }
            
            $transaksi->delete();
            
            $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
            return redirect()->route($role . '.transaksi.pengeluaran')
                ->with('success', 'Data pengeluaran berhasil dihapus');
                
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}