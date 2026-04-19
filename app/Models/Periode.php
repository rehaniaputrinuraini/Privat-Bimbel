<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Periode extends Model
{
    protected $table = 'ms_periode';
    protected $primaryKey = 'id_periode';
    
    public $timestamps = true;
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        'tahun_periode',
        'tahun_mulai',
        'tahun_selesai',
    ];

    protected $casts = [
        'tahun_mulai' => 'integer',
        'tahun_selesai' => 'integer',
    ];

    /**
     * Relasi ke Kelas
     */
    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'id_periode', 'id_periode');
    }

    /**
     * Scope untuk periode aktif (default: tahun sekarang)
     */
    public function scopeAktif($query)
    {
        $tahunSekarang = date('Y');
        return $query->where('tahun_mulai', '<=', $tahunSekarang)
                     ->where('tahun_selesai', '>=', $tahunSekarang);
    }

    /**
     * Get badge status (Aktif / Tidak Aktif)
     */
    public function getStatusAttribute()
    {
        $tahunSekarang = date('Y');
        if ($this->tahun_mulai <= $tahunSekarang && $this->tahun_selesai >= $tahunSekarang) {
            return '<span class="badge bg-success">Aktif</span>';
        }
        return '<span class="badge bg-secondary">Tidak Aktif</span>';
    }
}