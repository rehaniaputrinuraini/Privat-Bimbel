<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiKelas extends Model
{
    protected $table = 'tr_kelas';
    protected $primaryKey = 'id_kelas_murid';
    
    public $timestamps = true;
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        'id_kelas',
        'id_murid',
    ];

    /**
     * Relasi ke Murid
     */
    public function murid()
    {
        return $this->belongsTo(Murid::class, 'id_murid', 'id_murid');
    }

    /**
     * Relasi ke Kelas
     */
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas', 'id_kelas');
    }
}