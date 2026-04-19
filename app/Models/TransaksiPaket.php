<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiPaket extends Model
{
    protected $table = 'tr_paket';
    protected $primaryKey = 'id_paket_murid';
    
    public $timestamps = true;
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        'id_periode',
        'id_murid',
        'id_paket',
        'paket_awal',
        'biaya_pendaftaran',
    ];

    protected $casts = [
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