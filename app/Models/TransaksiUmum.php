<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class TransaksiUmum extends Model
{
    protected $table = 'ms_transaksi';  // tabelnya ms_transaksi
    protected $primaryKey = 'id_transaksi';
    public $timestamps = false; // karena pakai created_at & updated_at manual
    
    protected $fillable = [
        'id_periode',
        'id_murid',
        'id_pegawai',
        'tanggal_bayar',
        'bulan',
        'jenis_pembayaran',
        'keterangan',
        'debit',
        'kredit',
        'created_at',
        'updated_at'
    ];
    
    protected $casts = [
        'tanggal_bayar' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'debit' => 'integer',
        'kredit' => 'integer',
        'bulan' => 'integer'
    ];
    
    // Relasi ke tabel murid
    public function murid()
    {
        return $this->belongsTo(Murid::class, 'id_murid', 'id_murid');
    }
    
    // Relasi ke tabel pegawai
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'id_pegawai', 'id_pegawai');
    }
    
    // Relasi ke tabel periode
    public function periode()
    {
        return $this->belongsTo(Periode::class, 'id_periode', 'id_periode');
    }
    
    // Accessor untuk format tanggal Indonesia
    public function getTanggalFormattedAttribute()
    {
        if (!$this->tanggal_bayar) return '-';
        return date('d/m/Y', strtotime($this->tanggal_bayar));
    }
    
    // Accessor untuk format total pembayaran (debit)
    public function getTotalPembayaranFormattedAttribute()
    {
        return 'Rp ' . number_format($this->debit ?? 0, 0, ',', '.');
    }
    
    // Accessor untuk nama bulan dibayar
    public function getBulanDibayarFormattedAttribute()
    {
        if ($this->bulan) {
            $bulan = Carbon::create()->month($this->bulan)->translatedFormat('F');
            $tahun = $this->tanggal_bayar ? Carbon::parse($this->tanggal_bayar)->year : Carbon::now()->year;
            return $bulan . ' ' . $tahun;
        }
        return '-';
    }
    
    // Cek apakah ini pembayaran pendaftaran
    public function isPendaftaran()
    {
        return str_contains($this->keterangan, 'Pendaftaran');
    }
    
    // Cek apakah ini pembayaran SPP bulanan
    public function isSpp()
    {
        return str_contains($this->keterangan, 'SPP');
    }
}