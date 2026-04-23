<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Periode extends Model
{
    protected $table = 'ms_periode';
    protected $primaryKey = 'id_periode';
    
    public $incrementing = true;
    public $timestamps = false; // Karena tabel ms_periode TIDAK punya created_at & updated_at

    protected $fillable = [
        'tahun_periode',
        'tanggal_mulai',
        'tanggal_selesai',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];

    /**
     * Relasi ke Kelas
     */
    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'id_periode', 'id_periode');
    }

    /**
     * Scope untuk periode aktif (berdasarkan tanggal sekarang)
     */
    public function scopeAktif($query)
    {
        $sekarang = now();
        return $query->where('tanggal_mulai', '<=', $sekarang)
                     ->where('tanggal_selesai', '>=', $sekarang);
    }

    /**
     * Get badge status (Aktif / Tidak Aktif)
     */
    public function getStatusAttribute()
    {
        $sekarang = now();
        if ($this->tanggal_mulai <= $sekarang && $this->tanggal_selesai >= $sekarang) {
            return '<span class="badge bg-success">Aktif</span>';
        }
        return '<span class="badge bg-secondary">Tidak Aktif</span>';
    }
}