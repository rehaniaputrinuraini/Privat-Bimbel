<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HargaPaket extends Model
{
    use HasFactory;

    protected $table = 'ms_paket';  // Nama tabel di database
    protected $primaryKey = 'id_paket';

    protected $fillable = [
        'tingkat',
        'harga'
    ];

    // Optional: Jika ingin format harga otomatis
    public function getHargaFormattedAttribute()
    {
        return number_format($this->harga, 0, ',', '.');
    }
}   