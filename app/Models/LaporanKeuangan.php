<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanKeuangan extends Model
{
    use HasFactory;

    protected $table = 'ms_transaksi';        // 👈 BENAR: pakai ms_transaksi
    protected $primaryKey = 'id_transaksi';   // 👈 BENAR: primary key ms_transaksi

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

    // Accessor format rupiah untuk debit
    public function getDebitFormattedAttribute()
    {
        return 'Rp ' . number_format($this->debit ?? 0, 0, ',', '.');
    }

    // Accessor format rupiah untuk kredit
    public function getKreditFormattedAttribute()
    {
        return 'Rp ' . number_format($this->kredit ?? 0, 0, ',', '.');
    }

    // Accessor format tanggal Indonesia
    public function getTanggalBayarFormattedAttribute()
    {
        return $this->tanggal_bayar ? $this->tanggal_bayar->translatedFormat('d M Y') : '-';
    }
}