<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'ms_user';
    protected $primaryKey = 'id_user';

    // Jika tidak ada kolom created_at dan updated_at
    public $timestamps = false;
    
    // Atau jika pakai kolom 'created' saja
    // const CREATED_AT = 'created';
    // const UPDATED_AT = null;

    protected $fillable = [
        'username',
        'email',
        'password',
        'peran',
        'status_akun',  // ← perhatikan: di database kamu kolomnya 'status_akun' bukan 'status'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Relasi ke ms_admin
    public function admin()
    {
        return $this->hasOne(Admin::class, 'id_user', 'id_user');
    }

    // Relasi ke ms_tentor
    public function tentor()
    {
        return $this->hasOne(Tentor::class, 'id_user', 'id_user');
    }

    // Helper untuk cek role
    public function isSuperAdmin()
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
}