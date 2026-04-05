<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HargaPaket extends Model
{
    use HasFactory;

    protected $table = 'ms_paket';
    protected $primaryKey = 'id_paket';

    protected $fillable = [
        'tingkat',
        'harga'
    ];

    // Accessor untuk format harga
    public function getHargaFormattedAttribute()
    {
        return 'Rp ' . number_format($this->harga, 0, ',', '.');
    }
    
    // Accessor untuk memudahkan panggilan (opsional)
    public function getNamaPaketAttribute()
    {
        return $this->tingkat;
    }
}