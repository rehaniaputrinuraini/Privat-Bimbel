<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'tr_pembayaran';
    protected $primaryKey = 'id_pembayaran';
    
    protected $fillable = [
        'id_murid',
        'id_paket',
        'tanggal',
        'paket_awal',
        'paket_selanjutnya',
        'status_tagihan',
        'total_piutang',
        'total_uang_muka',
        'total_pembayaran',
        'keterangan',
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
        return date('d/m/Y', strtotime($this->tanggal));
    }
    
    // Accessor untuk format total pembayaran
    public function getTotalPembayaranFormattedAttribute()
    {
        return 'Rp ' . number_format($this->total_pembayaran, 0, ',', '.');
    }
    
    // Scope untuk filter berdasarkan tanggal
    public function scopeBulanTahun($query, $bulan, $tahun)
    {
        if ($bulan && $tahun) {
            return $query->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun);
        }
        return $query;
    }
    
    // Scope untuk filter berdasarkan murid
    public function scopeByMurid($query, $id_murid)
    {
        if ($id_murid) {
            return $query->where('id_murid', $id_murid);
        }
        return $query;
    }
}