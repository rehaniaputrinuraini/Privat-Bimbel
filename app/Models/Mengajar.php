<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Mengajar extends Model
{
    use HasFactory;

    protected $table = 'ms_mengajar';
    protected $primaryKey = 'id_mengajar';
    protected $keyType = 'int';
    public $incrementing = true;

    protected $fillable = [
        'id_pegawai',
        'id_kelas',
        'id_ruang',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'lama_mengajar',
        'murid_hadir',
        'bukti_mengajar',
        'keterangan',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public $timestamps = true;
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    // ========== RELASI ==========
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'id_pegawai', 'id_pegawai');
    }
    
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas', 'id_kelas');
    }
    
    public function ruang()
    {
        return $this->belongsTo(Ruang::class, 'id_ruang', 'id_ruang');
    }
    
    // Alias untuk kompatibilitas
    public function tentor()
    {
        return $this->pegawai();
    }

    // ========== ACCESSORS ==========
    public function getJamMasukFormattedAttribute()
    {
        if (!$this->jam_mulai) return '-';
        return Carbon::parse($this->jam_mulai)->format('H:i');
    }

    public function getJamKeluarFormattedAttribute()
    {
        if (!$this->jam_selesai) return '-';
        return Carbon::parse($this->jam_selesai)->format('H:i');
    }

    public function getTanggalFormattedAttribute()
    {
        if (!$this->tanggal) return '-';
        return Carbon::parse($this->tanggal)->translatedFormat('l, d F Y');
    }

    public function getStatusMuridTextAttribute()
    {
        if ($this->murid_hadir == 'Hadir') return 'Hadir';
        if ($this->murid_hadir == 'Tidak Hadir') return 'Tidak Hadir';
        return '-';
    }

    public function getStatusBadgeAttribute()
    {
        if ($this->murid_hadir == 'Hadir') {
            return '<span class="badge bg-success"><i class="fas fa-check-circle"></i> Hadir</span>';
        }
        return '<span class="badge bg-warning"><i class="fas fa-clock"></i> Tidak Hadir</span>';
    }

    public function getNamaTentorAttribute()
    {
        return $this->pegawai->nama_lengkap ?? '-';
    }

    public function getNamaKelasAttribute()
    {
        return $this->kelas->nama_kelas ?? '-';
    }

    public function getNamaRuangAttribute()
    {
        return $this->ruang->nama_ruang ?? '-';
    }

    // ========== SCOPES ==========
    public function scopeForTentor($query, $idPegawai)
    {
        return $query->where('id_pegawai', $idPegawai);
    }

    public function scopeOnDate($query, $date)
    {
        return $query->whereDate('tanggal', $date);
    }

    public function scopeToday($query)
    {
        return $query->whereDate('tanggal', today());
    }

    public function scopeThisMonth($query)
    {
        return $query->whereYear('tanggal', date('Y'))->whereMonth('tanggal', date('m'));
    }

    public function scopeHadir($query)
    {
        return $query->where('murid_hadir', 'Hadir');
    }

    public function scopeTidakHadir($query)
    {
        return $query->where('murid_hadir', 'Tidak Hadir');
    }

    // ========== HELPERS ==========
    public function hasMasuk()
    {
        return !is_null($this->jam_mulai);
    }

    public function hasKeluar()
    {
        return !is_null($this->jam_selesai);
    }

    public function isHadir()
    {
        return $this->murid_hadir == 'Hadir';
    }

    public function approve()
    {
        $this->murid_hadir = 'Hadir';
        return $this->save();
    }

    public function reject()
    {
        $this->murid_hadir = 'Tidak Hadir';
        return $this->save();
    }
}