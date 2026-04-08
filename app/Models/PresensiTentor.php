<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresensiTentor extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang digunakan
     */
    protected $table = 'tr_presensi_tentor';
    
    /**
     * Primary key tabel
     */
    protected $primaryKey = 'id_presensi';
    
    /**
     * Tipe primary key
     */
    protected $keyType = 'int';
    
    /**
     * Apakah primary key auto-increment?
     */
    public $incrementing = true;

    /**
     * Kolom-kolom yang bisa diisi (mass assignable)
     */
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

    /**
     * Tipe data casting
     */
    protected $casts = [
        'tanggal' => 'date',
        'jam_masuk' => 'datetime',
        'jam_mengajar' => 'decimal:2',
        'total_honor' => 'decimal:2',
        'uang_makan' => 'decimal:2',
        'transport' => 'decimal:2',
        'verifikasi_kehadiran' => 'boolean',
    ];

    /**
     * Nonaktifkan timestamps jika tidak ada kolom created_at/updated_at
     * Jika ada kolom created_at/updated_at, ubah jadi true
     */
    public $timestamps = false;

    /**
     * Jika pakai timestamps, tapi nama kolomnya beda:
     * const CREATED_AT = 'created_at';
     * const UPDATED_AT = 'updated_at';
     */

    // ============================================================
    // RELASI
    // ============================================================
    
    /**
     * Relasi ke model Tentor (many to one)
     */
    public function tentor()
    {
        return $this->belongsTo(Tentor::class, 'id_tentor', 'id_tentor');
    }

    // ============================================================
    // ACCESSORS (Getter)
    // ============================================================
    
    /**
     * Format jam masuk (H:i)
     */
    public function getJamMasukFormattedAttribute()
    {
        if (!$this->jam_masuk) {
            return '-';
        }
        return date('H:i', strtotime($this->jam_masuk));
    }

    /**
     * Format jam masuk lengkap (H:i:s)
     */
    public function getJamMasukFullAttribute()
    {
        if (!$this->jam_masuk) {
            return '-';
        }
        return date('H:i:s', strtotime($this->jam_masuk));
    }

    /**
     * Format tanggal Indonesia
     */
    public function getTanggalFormattedAttribute()
    {
        if (!$this->tanggal) {
            return '-';
        }
        return $this->tanggal->translatedFormat('l, d F Y');
    }

    /**
     * Format jam mengajar
     */
    public function getJamMengajarFormattedAttribute()
    {
        if (!$this->jam_mengajar) {
            return '-';
        }
        return $this->jam_mengajar . ' Jam';
    }

    /**
     * Format total honor (Rupiah)
     */
    public function getTotalHonorFormattedAttribute()
    {
        if (!$this->total_honor) {
            return 'Rp 0';
        }
        return 'Rp ' . number_format($this->total_honor, 0, ',', '.');
    }

    /**
     * Format uang makan (Rupiah)
     */
    public function getUangMakanFormattedAttribute()
    {
        if (!$this->uang_makan) {
            return 'Rp 0';
        }
        return 'Rp ' . number_format($this->uang_makan, 0, ',', '.');
    }

    /**
     * Format transport (Rupiah)
     */
    public function getTransportFormattedAttribute()
    {
        if (!$this->transport) {
            return 'Rp 0';
        }
        return 'Rp ' . number_format($this->transport, 0, ',', '.');
    }

    /**
     * Status kehadiran murid dalam bahasa Indonesia
     */
    public function getStatusMuridTextAttribute()
    {
        if ($this->status_murid == 'hadir') {
            return 'Hadir';
        } elseif ($this->status_murid == 'tidak_hadir') {
            return 'Tidak Hadir';
        }
        return '-';
    }

    /**
     * Badge status verifikasi (HTML)
     */
    public function getStatusBadgeAttribute()
    {
        if ($this->verifikasi_kehadiran) {
            return '<span class="badge badge-success"><i class="fas fa-check-circle"></i> Terverifikasi</span>';
        }
        return '<span class="badge badge-warning"><i class="fas fa-clock"></i> Menunggu Verifikasi</span>';
    }

    /**
     * Badge status verifikasi plain text
     */
    public function getStatusVerifikasiTextAttribute()
    {
        return $this->verifikasi_kehadiran ? 'Terverifikasi' : 'Belum Verifikasi';
    }

    /**
     * Warna status verifikasi untuk styling
     */
    public function getStatusColorAttribute()
    {
        return $this->verifikasi_kehadiran ? 'green' : 'orange';
    }

    // ============================================================
    // MUTATORS (Setter)
    // ============================================================
    
    /**
     * Set jam masuk otomatis
     */
    public function setJamMasukAttribute($value)
    {
        $this->attributes['jam_masuk'] = $value;
    }

    /**
     * Set total honor berdasarkan perhitungan
     */
    public function setTotalHonorFromHourly($honorPerJam)
    {
        if ($this->jam_mengajar && $honorPerJam) {
            $this->attributes['total_honor'] = $honorPerJam * $this->jam_mengajar;
        }
    }

    // ============================================================
    // SCOPES (Query Filters)
    // ============================================================
    
    /**
     * Scope untuk filter berdasarkan tentor
     */
    public function scopeForTentor($query, $idTentor)
    {
        return $query->where('id_tentor', $idTentor);
    }

    /**
     * Scope untuk filter berdasarkan tanggal
     */
    public function scopeOnDate($query, $date)
    {
        return $query->whereDate('tanggal', $date);
    }

    /**
     * Scope untuk hari ini
     */
    public function scopeToday($query)
    {
        return $query->whereDate('tanggal', today());
    }

    /**
     * Scope untuk bulan ini
     */
    public function scopeThisMonth($query)
    {
        return $query->whereYear('tanggal', date('Y'))
                     ->whereMonth('tanggal', date('m'));
    }

    /**
     * Scope untuk yang sudah terverifikasi
     */
    public function scopeVerified($query)
    {
        return $query->where('verifikasi_kehadiran', true);
    }

    /**
     * Scope untuk yang belum terverifikasi
     */
    public function scopeUnverified($query)
    {
        return $query->where('verifikasi_kehadiran', false);
    }

    /**
     * Scope untuk status murid hadir
     */
    public function scopeMuridHadir($query)
    {
        return $query->where('status_murid', 'hadir');
    }

    // ============================================================
    // HELPER METHODS
    // ============================================================
    
    /**
     * Cek apakah sudah presensi masuk
     */
    public function hasMasuk()
    {
        return !is_null($this->jam_masuk);
    }

    /**
     * Cek apakah sudah mengisi laporan
     */
    public function hasLaporan()
    {
        return !is_null($this->kelas) && !is_null($this->jam_mengajar);
    }

    /**
     * Cek apakah sudah diverifikasi
     */
    public function isVerified()
    {
        return $this->verifikasi_kehadiran == true;
    }

    /**
     * Hitung ulang total honor (jika grade berubah)
     */
    public function recalculateHonor($honorPerJam)
    {
        if ($this->jam_mengajar) {
            $this->total_honor = $honorPerJam * $this->jam_mengajar;
            return $this->total_honor;
        }
        return 0;
    }

    /**
     * Approve verifikasi oleh admin
     */
    public function approve()
    {
        $this->verifikasi_kehadiran = true;
        return $this->save();
    }

    /**
     * Batalkan verifikasi
     */
    public function reject()
    {
        $this->verifikasi_kehadiran = false;
        return $this->save();
    }
}