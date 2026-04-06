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
        'jam_mengajar',
        'kelas',
        'status_murid',
        'total_honor',
        'uang_makan',
        'transport',
        'bukti_foto',
        'verifikasi_kehadiran',
    ];

    // Nonaktifkan timestamps jika tidak ada kolom created_at/updated_at
    public $timestamps = false;

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

    public function getJamMengajarFormattedAttribute()
    {
        return $this->jam_mengajar ? $this->jam_mengajar . ' Jam' : '-';
    }

    // Accessor status badge
    public function getStatusBadgeAttribute()
    {
        if ($this->verifikasi_kehadiran) {
            return '<span class="badge badge-success">Terverifikasi</span>';
        }
        return '<span class="badge badge-warning">Belum Verifikasi</span>';
    }
}