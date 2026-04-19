<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $table = 'ms_kelas';
    protected $primaryKey = 'id_kelas';
    
    public $timestamps = true;
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        'id_periode',
        'jenjang',
        'nama_kelas',
        'jumlah_murid',
    ];

    protected $casts = [
        'jumlah_murid' => 'integer',
    ];

    /**
     * Relasi ke Periode
     */
    public function periode()
    {
        return $this->belongsTo(Periode::class, 'id_periode', 'id_periode');
    }

    /**
     * Relasi ke Murid (many-to-many via tr_kelas)
     */
    public function murid()
    {
        return $this->belongsToMany(Murid::class, 'tr_kelas', 'id_kelas', 'id_murid')
                    ->withPivot('created_at', 'updated_at');
    }

    /**
     * Scope untuk filter jenjang
     */
    public function scopeJenjang($query, $jenjang)
    {
        return $query->where('jenjang', $jenjang);
    }

    /**
     * Get badge untuk jenjang
     */
    public function getBadgeJenjangAttribute()
    {
        $badges = [
            'SD' => '<span class="badge bg-success">SD</span>',
            'SMP' => '<span class="badge bg-primary">SMP</span>',
            'SMA' => '<span class="badge bg-warning">SMA</span>',
        ];
        
        return $badges[$this->jenjang] ?? '<span class="badge bg-secondary">-</span>';
    }
}