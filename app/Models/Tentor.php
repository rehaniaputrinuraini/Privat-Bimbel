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

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    // ✅ TAMBAHKAN RELASI INI
    public function presensi()
    {
        return $this->hasMany(PresensiTentor::class, 'id_tentor', 'id_tentor');
    }
}