<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ruang extends Model
{
    protected $table = 'ms_ruang';
    protected $primaryKey = 'id_ruang';
    
    public $timestamps = true;
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        'nama_ruang',
    ];

    /**
     * Relasi ke Mengajar
     */
    public function mengajar()
    {
        return $this->hasMany(Mengajar::class, 'id_ruang', 'id_ruang');
    }

    /**
     * Scope untuk pencarian
     */
    public function scopeSearch($query, $search)
    {
        return $query->where('nama_ruang', 'like', '%' . $search . '%');
    }
}