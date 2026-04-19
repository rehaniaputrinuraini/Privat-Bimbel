<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'ms_user';
    protected $primaryKey = 'id_user';

    public $timestamps = true;
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        'id_pegawai',   
        'username',
        'email',
        'password',
        'peran',
        'foto',         
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    // Relasi ke ms_pegawai Satu user terhubung ke satu pegawai
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'id_pegawai', 'id_pegawai');
    }

    // Helper untuk cek role
    public function isSuperadmin()
    {
        return $this->peran === 'superadmin';
    }

    public function isAdmin()
    {
        return $this->peran === 'admin';
    }

    public function isTentor()
    {
        return $this->peran === 'tentor';
    }

    // Cek apakah user aktif
    public function isActive()
    {
        return $this->status == 1;
    }

    // Get nama lengkap dari relasi pegawai
    public function getNamaLengkapAttribute()
    {
        return $this->pegawai ? $this->pegawai->nama_lengkap : $this->username;
    }

    // Get foto profil (default jika kosong)
    public function getFotoUrlAttribute()
    {
        if ($this->foto) {
            return asset('storage/' . $this->foto);
        }
        return asset('images/default-avatar.png');
    }
}