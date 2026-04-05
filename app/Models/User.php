<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'ms_user';
    protected $primaryKey = 'id_user';

    protected $fillable = [
        'username',
        'email',
        'password',
        'peran',
        'status',
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
}