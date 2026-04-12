<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PresensiTentor extends Model
{
    use HasFactory;

    protected $table = 'tr_presensi_tentor';
    protected $primaryKey = 'id_presensi';
    protected $keyType = 'int';
    public $incrementing = true;

    protected $fillable = [
        'id_tentor',
        'tanggal',
        'jam_masuk',
        'jam_keluar',
        'jam_mengajar',
        'kelas',
        'jenjang',
        'status_murid',
        'keterangan',
        'bukti_foto',
        'verifikasi_kehadiran',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jam_masuk' => 'datetime',
        'jam_keluar' => 'datetime',
        'jam_mengajar' => 'integer',
        'jenjang' => 'string',
        'verifikasi_kehadiran' => 'boolean',
    ];

    public $timestamps = true;
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    // ========== RELASI ==========
    public function tentor()
    {
        return $this->belongsTo(Tentor::class, 'id_tentor', 'id_tentor');
    }

    // ========== ACCESSORS ==========
    public function getJamMasukFormattedAttribute()
    {
        if (!$this->jam_masuk) return '-';
        return Carbon::parse($this->jam_masuk)->format('H:i');
    }

    public function getJamMasukFullAttribute()
    {
        if (!$this->jam_masuk) return '-';
        return Carbon::parse($this->jam_masuk)->format('H:i:s');
    }

    public function getJamKeluarFormattedAttribute()
    {
        if (!$this->jam_keluar) return '-';
        return Carbon::parse($this->jam_keluar)->format('H:i');
    }

    public function getTanggalFormattedAttribute()
    {
        if (!$this->tanggal) return '-';
        return Carbon::parse($this->tanggal)->translatedFormat('l, d F Y');
    }

    public function getJamMengajarFormattedAttribute()
    {
        if (!$this->jam_mengajar) return '-';
        return $this->jam_mengajar . ' Sesi';
    }

    public function getJenjangFormattedAttribute()
    {
        if (!$this->jenjang) return '-';
        $jenjangList = [
            'SD' => 'SD (Sekolah Dasar)',
            'SMP' => 'SMP (Sekolah Menengah Pertama)',
            'SMA' => 'SMA (Sekolah Menengah Atas)',
        ];
        return $jenjangList[$this->jenjang] ?? $this->jenjang;
    }

    public function getStatusMuridTextAttribute()
    {
        if ($this->status_murid == 'hadir') return 'Hadir';
        if ($this->status_murid == 'tidak hadir') return 'Tidak Hadir';
        if ($this->status_murid == 'tidak_hadir') return 'Tidak Hadir';
        return '-';
    }

    public function getStatusBadgeAttribute()
    {
        if ($this->verifikasi_kehadiran) {
            return '<span class="badge badge-success"><i class="fas fa-check-circle"></i> Terverifikasi</span>';
        }
        return '<span class="badge badge-warning"><i class="fas fa-clock"></i> Menunggu Verifikasi</span>';
    }

    // ========== ACCESSOR UNTUK HONOR (LANGSUNG DARI ms_tentor, TANPA SIMPAN DI DATABASE) ==========
    
    /**
     * Get honor per sesi berdasarkan jenjang dari data tentor
     */
    public function getHonorPerSesiAttribute()
    {
        if (!$this->tentor) return 0;
        
        switch ($this->jenjang) {
            case 'SD':
                return $this->tentor->hr_sd ?? 0;
            case 'SMP':
                return $this->tentor->hr_smp ?? 0;
            case 'SMA':
                return $this->tentor->hr_sma ?? 0;
            default:
                return 0;
        }
    }

    /**
     * Total Honor = Gaji per sesi dengan penyesuaian status murid
     * - Hadir: 100% dari honor per sesi
     * - Tidak Hadir: 50% dari honor per sesi
     * 
     * NOTE: Ini hanya perhitungan dinamis, TIDAK DISIMPAN ke database!
     */
    public function getTotalHonorAttribute()
    {
        $honorPerSesi = $this->honor_per_sesi;
        
        // Cek status murid (cakup semua kemungkinan format: 'tidak hadir', 'tidak_hadir')
        $status = strtolower(trim($this->status_murid ?? ''));
        
        if ($status == 'tidak hadir' || $status == 'tidak_hadir' || str_contains($status, 'tidak')) {
            // Tidak hadir → 50% dari honor
            return $honorPerSesi * 0.5;
        }
        
        // Hadir → 100% dari honor
        return $honorPerSesi;
    }

    public function getTotalHonorFormattedAttribute()
    {
        $honor = $this->total_honor;
        return 'Rp ' . number_format($honor, 0, ',', '.');
    }

    /**
     * Uang Makan (tetap 100% terlepas dari status murid)
     */
    public function getUangMakanAttribute()
    {
        return $this->tentor->uang_makan ?? 0;
    }

    public function getUangMakanFormattedAttribute()
    {
        return 'Rp ' . number_format($this->uang_makan, 0, ',', '.');
    }

    /**
     * Transport (tetap 100% terlepas dari status murid)
     */
    public function getTransportAttribute()
    {
        return $this->tentor->uang_transport ?? 0;
    }

    public function getTransportFormattedAttribute()
    {
        return 'Rp ' . number_format($this->transport, 0, ',', '.');
    }

    // ========== SCOPES ==========
    public function scopeForTentor($query, $idTentor)
    {
        return $query->where('id_tentor', $idTentor);
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

    public function scopeVerified($query)
    {
        return $query->where('verifikasi_kehadiran', true);
    }

    public function scopeUnverified($query)
    {
        return $query->where('verifikasi_kehadiran', false);
    }

    // ========== HELPERS ==========
    public function hasMasuk()
    {
        return !is_null($this->jam_masuk);
    }

    public function hasLaporan()
    {
        return !is_null($this->kelas) && !is_null($this->jenjang);
    }

    public function isVerified()
    {
        return $this->verifikasi_kehadiran == true;
    }

    public function approve()
    {
        $this->verifikasi_kehadiran = true;
        return $this->save();
    }

    public function reject()
    {
        $this->verifikasi_kehadiran = false;
        return $this->save();
    }
}