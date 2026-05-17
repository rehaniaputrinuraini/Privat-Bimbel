<?php

namespace App\Http\Controllers\Pembayaran;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Murid;
use App\Models\HargaPaket;
use App\Models\TransaksiPaket;
use App\Models\TransaksiUmum;
use App\Models\Periode;
use Carbon\Carbon;

class PembayaranMuridController extends Controller
{
    public function create(Request $request)
    {
        $role   = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        $murids = Murid::orderBy('nama_lengkap', 'asc')->get();
        $pakets = HargaPaket::orderBy('id_paket', 'asc')->get();

        return view('dashboard.shared.pembayaran.create-pembayaran', [
            'role'   => $role,
            'murids' => $murids,
            'pakets' => $pakets,
        ]);
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
            'tanggal'             => 'required|date',
            'jenis_pembayaran'    => 'required|in:Tunai,Transfer',
            'total_pembayaran'    => 'required|numeric|min:1000',
            'id_murid'            => 'required|exists:ms_murid,id_murid',
        ]);

        $murid = Murid::find($request->id_murid);

        if (!$murid) {
            return response()->json(['success' => false, 'message' => 'Data murid tidak ditemukan']);
        }

        $sudahBayarPendaftaran = TransaksiUmum::where('id_murid', $request->id_murid)
            ->where('keterangan', 'like', '%Pendaftaran%')
            ->exists();

        if (!$sudahBayarPendaftaran) {
            TransaksiUmum::create([
                'id_periode'       => (int) $periodeAktif->id_periode,
                'id_murid'         => (int) $request->id_murid,
                'id_pegawai'       => null,
                'tanggal_bayar'    => $request->tanggal,
                'bulan'            => (int) date('m', strtotime($request->tanggal)),
                'jenis_pembayaran' => $request->jenis_pembayaran,
                'keterangan'       => 'Pendaftaran - ' . $murid->nama_lengkap,
                'debit'            => (int) $request->total_pembayaran,
                'kredit'           => 0,
                'created_at'       => now(),
                'updated_at'       => now(),
            ]);

            $murid->update(['tanggal_daftar' => $request->tanggal]);

            return response()->json(['success' => true, 'message' => 'Pembayaran pendaftaran berhasil disimpan']);
        }

        $request->validate([
            'paket_selanjutnya' => 'required|string',
            'bulan_dibayar'     => 'nullable|integer|min:1|max:12',
            'jenis_tagihan'     => 'required|in:pendaftaran,spp',
        ]);

        $bulanDibayar = $request->bulan_dibayar ?? Carbon::now()->month;
        $tahunDibayar = Carbon::now()->year;
        $namaBulan    = Carbon::create()->month($bulanDibayar)->translatedFormat('F');

        TransaksiUmum::create([
            'id_periode'       => (int) $periodeAktif->id_periode,
            'id_murid'         => (int) $request->id_murid,
            'id_pegawai'       => null,
            'tanggal_bayar'    => $request->tanggal,
            'bulan'            => (int) $bulanDibayar,
            'jenis_pembayaran' => $request->jenis_pembayaran,
            'keterangan' => 'Pembayaran SPP ' . $namaBulan . ' ' . $tahunDibayar . ' - ' . $murid->nama_lengkap,
            'debit'            => (int) $request->total_pembayaran,
            'kredit'           => 0,
            'created_at'       => now(),
            'updated_at'       => now(),
        ]);

        $hargaPaket = HargaPaket::where('tingkat', $request->paket_selanjutnya)->first();
        if ($hargaPaket) {
            TransaksiPaket::where('id_murid', $request->id_murid)->delete();
            TransaksiPaket::create([
                'id_murid'          => (int) $request->id_murid,
                'id_paket'          => (int) $hargaPaket->id_paket,
                'id_periode'        => (int) $periodeAktif->id_periode,
                'tanggal_daftar'    => date('Y-m-d'),
                'paket_awal'        => 0,
                'biaya_pendaftaran' => 100000,
            ]);
        }

        return response()->json(['success' => true, 'message' => 'Pembayaran SPP berhasil disimpan']);
    }

    public function cekStatusPembayaran($hashId)
    {
        $id = unhash_id($hashId);
        if (!$id) {
            return response()->json(['error' => 'Data tidak valid'], 404);
        }
        
        $murid = Murid::find($id);
        if (!$murid) {
            return response()->json(['error' => 'Murid tidak ditemukan'], 404);
        }

        $sudahBayarPendaftaran = TransaksiUmum::where('id_murid', $id)
            ->where('keterangan', 'like', '%Pendaftaran%')
            ->exists();

        $paketAktif = TransaksiPaket::where('id_murid', $id)
            ->orderBy('id_paket_murid', 'desc')
            ->first();

        $paketTingkat = null;
        $hargaPaket   = null;

        if ($paketAktif) {
            $paket = HargaPaket::find($paketAktif->id_paket);
            if ($paket) {
                $paketTingkat = $paket->tingkat;
                $hargaPaket   = $paket->harga;
            }
        }

        $bulanDaftar = $murid->tanggal_daftar ? (int) date('m', strtotime($murid->tanggal_daftar)) : 1;
        $currentMonth = Carbon::now()->month;
        $currentYear  = Carbon::now()->year;

        $daftarBulanTunggakan = [];
        $bulanBerikutnya = null;

        if ($sudahBayarPendaftaran) {
            for ($bulan = $bulanDaftar; $bulan <= $currentMonth; $bulan++) {
                $namaBulan = Carbon::create()->month($bulan)->translatedFormat('F');
                $cariString = 'SPP ' . $namaBulan . ' ' . $currentYear;
                
                $sudahBayar = TransaksiUmum::where('id_murid', $id)
                    ->where('keterangan', 'like', '%' . $cariString . '%')
                    ->where('debit', '>', 0)
                    ->exists();

                if (!$sudahBayar) {
                    $daftarBulanTunggakan[] = $bulan;
                }
            }

            if (empty($daftarBulanTunggakan)) {
                $bulanBerikutnya = $currentMonth;
            }
        }

        return response()->json([
            'sudah_bayar_pendaftaran' => $sudahBayarPendaftaran,
            'paket_awal'              => 100000,
            'paket_aktif'             => $paketTingkat,
            'harga_per_bulan'         => $hargaPaket,
            'daftar_bulan_tunggakan'  => $daftarBulanTunggakan,
            'bulan_berikutnya'        => $bulanBerikutnya,
            'bulan_daftar'            => $bulanDaftar,
        ]);
    }

    public function getMuridPaket($hashId)
    {
        $id = unhash_id($hashId);
        if (!$id) {
            return response()->json(['error' => 'Data tidak valid'], 404);
        }
        
        $murid = Murid::find($id);
        if (!$murid) {
            return response()->json(['error' => 'Murid tidak ditemukan'], 404);
        }

        $paketAktif = TransaksiPaket::where('id_murid', $id)
            ->orderBy('id_paket_murid', 'desc')
            ->first();

        $paketTingkat = null;
        $hargaPaket = 0;

        if ($paketAktif) {
            $paket = HargaPaket::find($paketAktif->id_paket);
            if ($paket) {
                $paketTingkat = $paket->tingkat;
                $hargaPaket = $paket->harga;
            }
        }

        return response()->json([
            'paket_aktif' => $paketTingkat,
            'harga_paket' => $hargaPaket,
        ]);
    }

    public function destroy(Request $request, $hashId)
    {
        $id = unhash_id($hashId);
        if (!$id) {
            return redirect()->back()->with('error', 'Data tidak valid');
        }
        
        TransaksiUmum::where('id_transaksi', $id)->delete();
        $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        return redirect()->route($role . '.pembayaran.tagihan')
            ->with('success', 'Data pembayaran berhasil dihapus');
    }
}