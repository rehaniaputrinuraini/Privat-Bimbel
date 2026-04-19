<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Murid extends Model
{
    use HasFactory;

    protected $table = 'ms_murid';
    protected $primaryKey = 'id_murid';
    
    public $timestamps = true;
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        'nama_lengkap',           // ✅ GANTI dari nama_lengkap_murid
        'asal_sekolah',
        'alamat',                 // ✅ GANTI dari alamat_murid
        'no_hp',                  // ✅ GANTI dari no_hp_murid
        'nama_orang_tua',
        'no_hp_orang_tua',
        'tahun_masuk',
        'tanggal_daftar',
    ];

    protected $casts = [
        'tanggal_daftar' => 'date',
        'tahun_masuk' => 'integer',
    ];

    /**
     * Relasi ke tabel pembayaran (tr_transaksi)
     */
    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class, 'id_murid', 'id_murid');
    }

    /**
     * Accessor untuk nama lengkap (kompatibilitas dengan kode lama)
     */
    public function getNamaLengkapMuridAttribute()
    {
        return $this->nama_lengkap;
    }

    /**
     * Accessor untuk alamat (kompatibilitas dengan kode lama)
     */
    public function getAlamatMuridAttribute()
    {
        return $this->alamat;
    }

    /**
     * Accessor untuk no_hp (kompatibilitas dengan kode lama)
     */
    public function getNoHpMuridAttribute()
    {
        return $this->no_hp;
    }

    /**
     * Scope untuk pencarian
     */
    public function scopeSearch($query, $search)
    {
        return $query->where('nama_lengkap', 'like', '%' . $search . '%')
                     ->orWhere('asal_sekolah', 'like', '%' . $search . '%');
    }

    /**
     * Scope untuk tahun masuk
     */
    public function scopeTahunMasuk($query, $tahun)
    {
        return $query->where('tahun_masuk', $tahun);
    }
}