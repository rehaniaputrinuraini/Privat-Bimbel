<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanKeuangan extends Model
{
    use HasFactory;

    protected $table = 'tr_keuangan';
    protected $primaryKey = 'id_keuangan';

    protected $fillable = [
        'tanggal',
        'kategori',
        'rincian',
        'jumlah',
        'nama_murid',
        'bulan_periode'
    ];
}