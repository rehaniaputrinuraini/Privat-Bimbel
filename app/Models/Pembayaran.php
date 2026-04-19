<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Pembayaran extends Model
{
    // ✅ GANTI NAMA TABEL KE tr_transaksi
    protected $table = 'tr_transaksi';
    
    protected $primaryKey = 'id_pembayaran';
    
    protected $fillable = [
        'id_murid',
        'id_paket',
        'id_transaksi',        // ✅ TAMBAHKAN INI
        'tanggal',
        'paket_awal',
        'paket_selanjutnya',
        'bulan_dibayar',
        'tahun_dibayar',
        'status_tagihan',
        'total_piutang',
        'total_uang_muka',
        'total_pembayaran',
    ];
    
    // Relasi ke tabel murid
    public function murid()
    {
        return $this->belongsTo(Murid::class, 'id_murid', 'id_murid');
    }
    
    // Relasi ke tabel harga paket
    public function paket()
    {
        return $this->belongsTo(HargaPaket::class, 'id_paket', 'id_paket');
    }
    
    // Accessor untuk format tanggal Indonesia
    public function getTanggalFormattedAttribute()
    {
        if (!$this->tanggal) return '-';
        return date('d/m/Y', strtotime($this->tanggal));
    }
    
    // Accessor untuk format total pembayaran
    public function getTotalPembayaranFormattedAttribute()
    {
        return 'Rp ' . number_format($this->total_pembayaran ?? 0, 0, ',', '.');
    }
    
    // Accessor untuk format paket awal
    public function getPaketAwalFormattedAttribute()
    {
        return $this->paket_awal ? 'Rp ' . number_format($this->paket_awal, 0, ',', '.') : '-';
    }
    
    // Accessor untuk nama bulan dibayar
    public function getBulanDibayarFormattedAttribute()
    {
        if ($this->bulan_dibayar) {
            $bulan = Carbon::create()->month($this->bulan_dibayar)->translatedFormat('F');
            $tahun = $this->tahun_dibayar ?? Carbon::now()->year;
            return $bulan . ' ' . $tahun;
        }
        return '-';
    }
    
    // Method untuk cek apakah ini pembayaran pendaftaran
    public function isPendaftaran()
    {
        return is_null($this->paket_selanjutnya);
    }
    
    // Method untuk cek apakah ini pembayaran bulanan
    public function isBulanan()
    {
        return !is_null($this->paket_selanjutnya);
    }
    
    // Method untuk cek apakah status lunas
    public function isLunas()
    {
        return strtolower($this->status_tagihan) == 'lunas';
    }
}