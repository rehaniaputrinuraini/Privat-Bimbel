<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tentor extends Model
{
    use HasFactory;

    protected $table = 'ms_tentor';
    protected $primaryKey = 'id_tentor';

    protected $fillable = [
        'id_user',
        'nama_lengkap_tentor',
        'alamat_tentor',
        'no_hp_tentor',
        'mapel',
        'grade',
        'hr_sd',
        'hr_smp',
        'hr_sma',
        'uang_makan',
        'uang_transport',
        'status_gaji',
    ];

    public $timestamps = false;
    const CREATED_AT = 'created';
    const UPDATED_AT = null;

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    // Relasi ke PresensiTentor (ONE TO MANY)
    public function presensi()
    {
        return $this->hasMany(PresensiTentor::class, 'id_tentor', 'id_tentor');
    }

    // Relasi ke PresensiTentor untuk hari ini (ONE TO ONE)
    public function presensiHariIni()
    {
        return $this->hasOne(PresensiTentor::class, 'id_tentor', 'id_tentor')
                    ->whereDate('tanggal', today());
    }

    // Helper: hitung honor per jam berdasarkan grade
    public function getHonorPerJamAttribute()
    {
        switch ($this->grade) {
            case 'A':
                return 50000;
            case 'B':
                return 40000;
            default:
                return 35000;
        }
    }

    // Helper: format nama lengkap
    public function getNamaAttribute()
    {
        return $this->nama_lengkap_tentor;
    }

    // Helper: cek status gaji
    public function getStatusGajiBadgeAttribute()
    {
        if ($this->status_gaji == 'sudah') {
            return '<span class="badge badge-success">Sudah Dibayar</span>';
        }
        return '<span class="badge badge-warning">Belum Dibayar</span>';
    }
}