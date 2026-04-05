<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresensiTentor extends Model
{
    use HasFactory;

    protected $table = 'tr_presensi_tentor';
    protected $primaryKey = 'id_presensi';

    protected $fillable = [
        'id_tentor',
        'tanggal',
        'jam_masuk',
        'jam_keluar',
        'status',
        'keterangan',
    ];

    // Relasi ke tentor
    public function tentor()
    {
        return $this->belongsTo(Tentor::class, 'id_tentor', 'id_tentor');
    }

    // Accessor format jam
    public function getJamMasukFormattedAttribute()
    {
        return $this->jam_masuk ? date('H:i', strtotime($this->jam_masuk)) : '-';
    }

    public function getJamKeluarFormattedAttribute()
    {
        return $this->jam_keluar ? date('H:i', strtotime($this->jam_keluar)) : '-';
    }
}