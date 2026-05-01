<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Pembayaran extends Model
{
    protected $table      = 'ms_transaksi';
    protected $primaryKey = 'id_transaksi';

    public $timestamps = true;
    const CREATED_AT   = 'created_at';
    const UPDATED_AT   = 'updated_at';

    protected $fillable = [
        'id_periode',
        'id_murid',
        'id_pegawai',
        'tanggal_bayar',
        'bulan',
        'jenis_pembayaran',
        'keterangan',
        'debit',
        'kredit',
    ];

    protected $casts = [
        'tanggal_bayar' => 'date',
        'debit'         => 'integer',
        'kredit'        => 'integer',
        'bulan'         => 'integer',
    ];

    // =============================================
    // RELASI
    // =============================================

    public function murid()
    {
        return $this->belongsTo(Murid::class, 'id_murid', 'id_murid');
    }

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'id_pegawai', 'id_pegawai');
    }

    public function periode()
    {
        return $this->belongsTo(Periode::class, 'id_periode', 'id_periode');
    }

    // =============================================
    // ACCESSORS
    // =============================================

    public function getTanggalBayarFormattedAttribute(): string
    {
        if (!$this->tanggal_bayar) return '-';
        return $this->tanggal_bayar->format('d/m/Y');
    }

    public function getDebitFormattedAttribute(): string
    {
        return 'Rp ' . number_format($this->debit ?? 0, 0, ',', '.');
    }

    public function getKreditFormattedAttribute(): string
    {
        return 'Rp ' . number_format($this->kredit ?? 0, 0, ',', '.');
    }

    public function getNamaBulanAttribute(): string
    {
        if ($this->bulan) {
            return Carbon::create()->month($this->bulan)->translatedFormat('F');
        }
        return '-';
    }

    // =============================================
    // HELPERS
    // =============================================

    public function isPemasukan(): bool
    {
        return $this->debit > 0;
    }

    public function isPengeluaran(): bool
    {
        return $this->kredit > 0;
    }

    public function isPendaftaran(): bool
    {
        return str_contains($this->keterangan, 'Pendaftaran');
    }

    public function isSPP(): bool
    {
        return str_contains($this->keterangan, 'SPP');
    }

    public function isLainnya(): bool
    {
        return !$this->isPendaftaran() && !$this->isSPP() && $this->id_murid === null;
    }

    // =============================================
    // SCOPES
    // =============================================

    public function scopeLainnya($query)
    {
        return $query->whereNull('id_murid')
            ->where('keterangan', 'not like', '%Pendaftaran%')
            ->where('keterangan', 'not like', '%SPP%');
    }

    public function scopePemasukan($query)
    {
        return $query->where('debit', '>', 0);
    }

    public function scopePengeluaran($query)
    {
        return $query->where('kredit', '>', 0);
    }

    public function scopeBulanIni($query)
    {
        return $query->whereMonth('tanggal_bayar', now()->month)
            ->whereYear('tanggal_bayar', now()->year);
    }

    public function scopeDariMurid($query)
    {
        return $query->where(function ($q) {
            $q->where('keterangan', 'like', '%Pendaftaran%')
              ->orWhere('keterangan', 'like', '%SPP%');
        });
    }
}