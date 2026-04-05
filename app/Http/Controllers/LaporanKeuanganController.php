<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LaporanKeuangan;

class LaporanKeuanganController extends Controller
{
    // Menampilkan semua data keuangan
    public function index(Request $request)
    {
        $role = $request->route()->getPrefix() == '/superadmin' ? 'superadmin' : 'admin';
        
        // Ambil data dari database sesuai kategori
        $pemasukan = LaporanKeuangan::where('kategori', 'pemasukan')
            ->orderBy('tanggal', 'desc')
            ->get();
        
        $pengeluaran = LaporanKeuangan::where('kategori', 'pengeluaran')
            ->orderBy('tanggal', 'desc')
            ->get();
        
        $piutang = LaporanKeuangan::where('kategori', 'piutang')
            ->orderBy('tanggal', 'desc')
            ->get();
        
        $uang_muka = LaporanKeuangan::where('kategori', 'uang_muka')
            ->orderBy('tanggal', 'desc')
            ->get();
        
        // Hitung total
        $totalPemasukan = $pemasukan->sum('jumlah');
        $totalPengeluaran = $pengeluaran->sum('jumlah');
        $totalPiutang = $piutang->sum('jumlah');
        $totalUangMuka = $uang_muka->sum('jumlah');
        $totalPemasukanKas = $totalPemasukan + $totalPiutang + $totalUangMuka;
        $saldoKas = $totalPemasukan - $totalPengeluaran;
        
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
            'saldoKas' => $saldoKas
        ]);
    }

    // Form tambah data
    public function create(Request $request)
    {
        $role = $request->route()->getPrefix() == '/superadmin' ? 'superadmin' : 'admin';
        return view('dashboard.shared.laporan-keuangan.create-laporan-keuangan', ['role' => $role]);
    }

    // Simpan data
    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'kategori' => 'required|in:pemasukan,pengeluaran,piutang,uang_muka',
            'rincian' => 'required|string|max:255',
            'jumlah' => 'required|numeric|min:0'
        ]);

        // Bersihkan jumlah dari titik atau koma jika ada
        $jumlah = str_replace(['.', ','], '', $request->jumlah);
        
        LaporanKeuangan::create([
            'tanggal' => $request->tanggal,
            'kategori' => $request->kategori,
            'rincian' => $request->rincian,
            'jumlah' => $jumlah,
            'nama_murid' => $request->nama_murid ?? null,
            'bulan_periode' => $request->bulan_periode ?? null
        ]);

        $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        
        return redirect()->route($role . '.laporan-keuangan')->with('success', 'Data berhasil ditambahkan');
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
}