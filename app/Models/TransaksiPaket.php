<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiPaket extends Model
{
    use HasFactory;

    protected $table = 'tr_paket';
    protected $primaryKey = 'id_paket_murid';
    
    public $timestamps = true;

    protected $fillable = [
        'id_periode',
        'id_murid',
        'id_paket',
        'tanggal_daftar',
        'paket_awal',
        'biaya_pendaftaran',
    ];

    /**
     * Relasi ke Murid
     */
    public function murid()
    {
        return $this->belongsTo(Murid::class, 'id_murid', 'id_murid');
    }

    /**
     * Relasi ke Paket
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