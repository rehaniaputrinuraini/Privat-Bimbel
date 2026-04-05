<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    protected $table = 'ms_admin';
    protected $primaryKey = 'id_admin';

    protected $fillable = [
        'id_user',
        'nama_lengkap_admin',
        'alamat_admin',
        'no_hp_admin',
        'gaji_pokok',
        'status_gaji',
    ];

    // Relasi ke ms_user
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}