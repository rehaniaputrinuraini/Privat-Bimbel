<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pembayaran; // ← TAMBAHKAN BARIS INI

class Murid extends Model
{
    use HasFactory;

    protected $table = 'ms_murid';
    protected $primaryKey = 'id_murid';

    protected $fillable = [
        'nama_lengkap_murid',
        'kelas',
        'asal_sekolah',
        'alamat_murid',
        'no_hp_murid',
        'nama_orang_tua',
        'no_hp_orang_tua',
        'paket_awal',
        'pilihan_paket',
        'tahun_masuk'
    ];

    /**
     * Relasi ke tabel pembayaran (tr_pembayaran)
     * Satu murid bisa memiliki banyak pembayaran
     */
    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class, 'id_murid', 'id_murid');
    }
}