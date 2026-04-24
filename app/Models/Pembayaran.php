<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Pembayaran extends Model
{
    protected $table = 'ms_transaksi';           // 👈 BENAR: tabel transaksi umum
    protected $primaryKey = 'id_transaksi';      // 👈 BENAR: primary key ms_transaksi
    
    public $timestamps = true;
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    
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
    ];
    
    protected $casts = [
        'tanggal_bayar' => 'date',
        'debit' => 'integer',
        'kredit' => 'integer',
        'bulan' => 'integer',
    ];
    
    // Relasi ke murid
    public function murid()
    {
        return $this->belongsTo(Murid::class, 'id_murid', 'id_murid');
    }
    
    // Relasi ke pegawai
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'id_pegawai', 'id_pegawai');
    }
    
    // Relasi ke periode
    public function periode()
    {
        return $this->belongsTo(Periode::class, 'id_periode', 'id_periode');
    }
    
    // Accessor format tanggal Indonesia
    public function getTanggalBayarFormattedAttribute()
    {
        if (!$this->tanggal_bayar) return '-';
        return $this->tanggal_bayar->format('d/m/Y');
    }
    
    // Accessor format debit (pemasukan)
    public function getDebitFormattedAttribute()
    {
        return 'Rp ' . number_format($this->debit ?? 0, 0, ',', '.');
    }
    
    // Accessor format kredit (pengeluaran)
    public function getKreditFormattedAttribute()
    {
        return 'Rp ' . number_format($this->kredit ?? 0, 0, ',', '.');
    }
    
    // Accessor nama bulan
    public function getNamaBulanAttribute()
    {
        if ($this->bulan) {
            return Carbon::create()->month($this->bulan)->translatedFormat('F');
        }
        return '-';
    }
    
    // Cek apakah ini transaksi pemasukan
    public function isPemasukan()
    {
        return $this->debit > 0;
    }
    
    // Cek apakah ini transaksi pengeluaran
    public function isPengeluaran()
    {
        return $this->kredit > 0;
    }
    
    // Cek apakah ini pembayaran pendaftaran
    public function isPendaftaran()
    {
        return str_contains($this->keterangan, 'Pendaftaran');
    }
    
    // Cek apakah ini pembayaran SPP
    public function isSPP()
    {
        return str_contains($this->keterangan, 'SPP');
    }
}