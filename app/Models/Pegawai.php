<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    protected $table = 'ms_pegawai';
    protected $primaryKey = 'id_pegawai';
    
    // Karena tabel ms_pegawai punya created_at & updated_at
    public $timestamps = true;
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        'jenis_pegawai',
        'nama_lengkap',
        'alamat',
        'no_hp',
        'mapel',
        'gaji_pokok',
        'grade',
        'hr_sd',
        'hr_smp',
        'hr_sma',
        'uang_makan',
        'uang_transport',
    ];

    protected $casts = [
        'gaji_pokok' => 'integer',
        'hr_sd' => 'integer',
        'hr_smp' => 'integer',
        'hr_sma' => 'integer',
        'uang_makan' => 'integer',
        'uang_transport' => 'integer',
    ];

    /**
     * Relasi ke User (One to One)
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id_pegawai', 'id_pegawai');
    }

    /**
     * Relasi ke Gaji Tentor (One to Many)
     */
    public function gajiTentor()
    {
        return $this->hasMany(GajiTentor::class, 'id_pegawai', 'id_pegawai');
    }

    /**
     * Relasi ke Mengajar (One to Many)
     */
    public function mengajar()
    {
        return $this->hasMany(Mengajar::class, 'id_pegawai', 'id_pegawai');
    }

    /**
     * Scope untuk filter jenis pegawai
     */
    public function scopeSuperadmin($query)
    {
        return $query->where('jenis_pegawai', 'superadmin');
    }

    public function scopeAdmin($query)
    {
        return $query->where('jenis_pegawai', 'admin');
    }

    public function scopeTentor($query)
    {
        return $query->where('jenis_pegawai', 'tentor');
    }

    /**
     * Scope untuk tentor dengan grade tertentu
     */
    public function scopeGrade($query, $grade)
    {
        return $query->where('grade', $grade);
    }

    /**
     * Get total honor per jam berdasarkan grade dan jenjang
     */
    public function getHonorPerJam($jenjang)
    {
        if ($this->jenis_pegawai !== 'tentor') {
            return 0;
        }

        switch ($jenjang) {
            case 'SD':
                return $this->hr_sd ?? 0;
            case 'SMP':
                return $this->hr_smp ?? 0;
            case 'SMA':
                return $this->hr_sma ?? 0;
            default:
                return 0;
        }
    }

    /**
     * Get inisial nama (untuk avatar)
     */
    public function getInisialAttribute()
    {
        if (!$this->nama_lengkap) {
            return '?';
        }
        
        $words = explode(' ', trim($this->nama_lengkap));
        if (count($words) >= 2) {
            return strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
        }
        return strtoupper(substr($words[0], 0, 2));
    }

    /**
     * Get badge untuk jenis pegawai
     */
    public function getBadgeJenisAttribute()
    {
        $badges = [
            'superadmin' => '<span class="badge bg-danger">Superadmin</span>',
            'admin' => '<span class="badge bg-primary">Admin</span>',
            'tentor' => '<span class="badge bg-success">Tentor</span>',
        ];
        
        return $badges[$this->jenis_pegawai] ?? '<span class="badge bg-secondary">Unknown</span>';
    }

    /**
     * Get badge untuk grade tentor
     */
    public function getBadgeGradeAttribute()
    {
        if ($this->jenis_pegawai !== 'tentor') {
            return '-';
        }
        
        $badges = [
            'A' => '<span class="badge bg-warning text-dark">Grade A</span>',
            'B' => '<span class="badge bg-info">Grade B</span>',
        ];
        
        return $badges[$this->grade] ?? '<span class="badge bg-secondary">-</span>';
    }
}