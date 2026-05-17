<?php

namespace App\Http\Controllers\Pembayaran;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Murid;
use App\Models\TransaksiKelas;
use App\Models\TransaksiPaket;
use App\Models\TransaksiUmum;
use App\Models\HargaPaket;
use Carbon\Carbon;

class DetailPembayaranController extends Controller
{
    public function detail(Request $request, $hashId)
    {
        $id = unhash_id($hashId);
        if (!$id) {
            abort(404, 'Data tidak ditemukan');
        }
        
        $role = str_contains($request->url(), 'superadmin') ? 'superadmin' : 'admin';
        
        $murid = Murid::with(['transaksiUmum' => function ($q) {
            $q->orderBy('tanggal_bayar', 'desc');
        }])->findOrFail($id);
        
        // Kelas
        $kelasTerbaru = TransaksiKelas::where('id_murid', $murid->id_murid)
            ->orderBy('created_at', 'desc')->first();
        $namaKelas = $kelasTerbaru ? optional(\App\Models\Kelas::find($kelasTerbaru->id_kelas))->nama_kelas : '-';
        
        // Paket aktif
        $paketAktif = TransaksiPaket::where('id_murid', $murid->id_murid)
            ->orderBy('id_paket_murid', 'desc')->first();
        $namaPaket = '-';
        $hargaPerBulan = 0;
        if ($paketAktif) {
            $paket = HargaPaket::find($paketAktif->id_paket);
            if ($paket) {
                $namaPaket = $paket->tingkat;
                $hargaPerBulan = $paket->harga;
            }
        }
        
        // Riwayat pembayaran
        $riwayatPembayaran = TransaksiUmum::where('id_murid', $murid->id_murid)
            ->where('debit', '>', 0)
            ->orderBy('tanggal_bayar', 'desc')
            ->get()
            ->map(function ($item) {
                return (object) [
                    'tanggal'          => $item->tanggal_bayar ? date('d/m/Y', strtotime($item->tanggal_bayar)) : '-',
                    'jenis_pembayaran' => $item->jenis_pembayaran ?? '-',
                    'jumlah'           => 'Rp ' . number_format($item->debit ?? 0, 0, ',', '.'),
                    'keterangan'       => $item->keterangan,
                ];
            });
        
        // Status pendaftaran
        $sudahBayarPendaftaran = TransaksiUmum::where('id_murid', $murid->id_murid)
            ->where('keterangan', 'like', '%Pendaftaran%')
            ->exists();
        
        // Total pembayaran
        $totalBayar = TransaksiUmum::where('id_murid', $murid->id_murid)
            ->where('debit', '>', 0)
            ->sum('debit');
        
        $currentMonth = Carbon::now()->month;
        $currentYear  = Carbon::now()->year;
        
        // Ambil semua pembayaran SPP
        $semuaPembayaranSPP = TransaksiUmum::where('id_murid', $murid->id_murid)
            ->where('keterangan', 'like', '%SPP%')
            ->where('debit', '>', 0)
            ->get();
        
        // Buat daftar bulan yang sudah dibayar
        $bulanDibayar = [];
        foreach ($semuaPembayaranSPP as $pemb) {
            if (preg_match('/SPP\s+(\w+)\s+(\d+)/', $pemb->keterangan, $matches)) {
                $namaBulan = $matches[1];
                $tahun = (int) $matches[2];
                $bulanAngka = $this->getBulanAngka($namaBulan);
                $bulanDibayar["{$tahun}-{$bulanAngka}"] = [
                    'tanggal_bayar' => $pemb->tanggal_bayar,
                    'jenis_pembayaran' => $pemb->jenis_pembayaran,
                    'jumlah' => $pemb->debit,
                ];
            }
        }
        
        // Buat detail tagihan per bulan
        $detailTagihan = collect();
        
        $tanggalDaftar = $murid->tanggal_daftar ?? date('Y-m-d');
        $bulanMulai = (int) date('m', strtotime($tanggalDaftar));
        $tahunMulai = (int) date('Y', strtotime($tanggalDaftar));
        
        for ($year = $tahunMulai; $year <= $currentYear; $year++) {
            $startMonth = ($year == $tahunMulai) ? $bulanMulai : 1;
            $endMonth = ($year == $currentYear) ? $currentMonth : 12;
            
            for ($month = $startMonth; $month <= $endMonth; $month++) {
                if ($year == $tahunMulai && $month == $bulanMulai && !$sudahBayarPendaftaran) {
                    continue;
                }
                
                $namaBulan = Carbon::create()->month($month)->translatedFormat('F') . ' ' . $year;
                $key = "{$year}-{$month}";
                
                if (isset($bulanDibayar[$key])) {
                    $bayar = $bulanDibayar[$key];
                    $status = 'Lunas';
                    $keterangan = 'SPP ' . $namaBulan;
                    $jumlah = $bayar['jumlah'];
                    $tanggalBayar = date('d/m/Y', strtotime($bayar['tanggal_bayar']));
                    $jenisBayar = $bayar['jenis_pembayaran'];
                    
                    if ($bayar['jumlah'] > $hargaPerBulan) {
                        $status = 'Uang Muka';
                        $kelebihan = $bayar['jumlah'] - $hargaPerBulan;
                        $keterangan = 'Uang Muka untuk ' . $namaBulan . ' (lebih Rp ' . number_format($kelebihan, 0, ',', '.') . ')';
                    }
                } else {
                    $status = 'Belum Lunas';
                    $keterangan = 'Belum dibayar';
                    $jumlah = 0;
                    $tanggalBayar = '-';
                    $jenisBayar = '-';
                }
                
                $detailTagihan->push((object)[
                    'bulan' => $namaBulan,
                    'tanggal_bayar' => $tanggalBayar,
                    'jenis_pembayaran' => $jenisBayar,
                    'jumlah' => $jumlah,
                    'keterangan' => $keterangan,
                    'status' => $status,
                ]);
            }
        }
        
        // Status tagihan
        $pembayaranBulanIni = $semuaPembayaranSPP->filter(function ($item) use ($currentMonth, $currentYear) {
            if (preg_match('/SPP\s+(\w+)\s+(\d+)/', $item->keterangan, $matches)) {
                $tahun = (int) $matches[2];
                $bulanNama = $matches[1];
                $bulanAngka = $this->getBulanAngka($bulanNama);
                return $bulanAngka == $currentMonth && $tahun == $currentYear;
            }
            return false;
        })->first();
        
        $totalPiutang = 0;
        for ($bulan = $bulanMulai; $bulan <= $currentMonth; $bulan++) {
            $key = "{$currentYear}-{$bulan}";
            if (!isset($bulanDibayar[$key])) {
                $totalPiutang += $hargaPerBulan;
            }
        }
        
        $statusTagihan = '-';
        if (!$sudahBayarPendaftaran) {
            $statusTagihan = 'Belum Daftar';
        } elseif ($totalPiutang > 0) {
            $statusTagihan = 'Ada Tagihan';
        } elseif ($pembayaranBulanIni) {
            $statusTagihan = 'Lunas';
        } else {
            $statusTagihan = 'Lunas';
        }
        
        $data = [
            'role'                    => $role,
            'murid'                   => $murid,
            'namaKelas'               => $namaKelas,
            'namaPaket'               => $namaPaket,
            'hargaPerBulan'           => $hargaPerBulan,
            'riwayatPembayaran'       => $riwayatPembayaran,
            'sudahBayarPendaftaran'   => $sudahBayarPendaftaran,
            'totalBayar'              => $totalBayar,
            'statusTagihan'           => $statusTagihan,
            'detailTagihan'           => $detailTagihan,
        ];
        
        return view('dashboard.shared.transaksi.detail-pembayaran', $data);
    }
    
    private function getBulanAngka($namaBulan)
    {
        $bulan = [
            'Januari' => 1, 'Februari' => 2, 'Maret' => 3, 'April' => 4,
            'Mei' => 5, 'Juni' => 6, 'Juli' => 7, 'Agustus' => 8,
            'September' => 9, 'Oktober' => 10, 'November' => 11, 'Desember' => 12
        ];
        return $bulan[$namaBulan] ?? 1;
    }
}