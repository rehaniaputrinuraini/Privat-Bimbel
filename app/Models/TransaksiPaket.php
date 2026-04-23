<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiPaket extends Model
{
    protected $table = 'tr_paket';
    protected $primaryKey = 'id_paket_murid';
    
    // ✅ MATIKAN TIMESTAMPS karena tabel tidak punya created_at & updated_at
    public $timestamps = false;

    protected $fillable = [
        'id_periode',
        'id_murid',
        'id_paket',
        'tanggal_daftar',
        'paket_awal',
        'biaya_pendaftaran',
    ];

    protected $casts = [
        'tanggal_daftar' => 'date',
        'paket_awal' => 'boolean',
        'biaya_pendaftaran' => 'integer',
    ];

    /**
     * Relasi ke Murid
     */
    public function murid()
    {
        return $this->belongsTo(Murid::class, 'id_murid', 'id_murid');
    }

    /**
     * Relasi ke Paket (HargaPaket)
     */
    public function paket()
    {
        return $this->belongsTo(HargaPaket::class, 'id_paket', 'id_paket');
    }

    /**
     * Relasi ke Periode
     */
    public function periode()
    {
        return $this->belongsTo(Periode::class, 'id_periode', 'id_periode');
    }
}