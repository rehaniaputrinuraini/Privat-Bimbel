<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiUmum extends Model
{
    protected $table = 'ms_transaksi';
    protected $primaryKey = 'id_transaksi';
    
    public $timestamps = true;
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    
    protected $fillable = [
        'tanggal_bayar',
        'bulan',
        'jenis_pembayaran',
        'kategori',
        'status_bayar',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_bayar' => 'date',
        'bulan' => 'date',
    ];

    /**
     * Relasi ke tr_transaksi (one-to-many)
     */
    public function transaksiPembayaran()
    {
        return $this->hasMany(Pembayaran::class, 'id_transaksi', 'id_transaksi');
    }

    // ✅ TAMBAHAN: Relasi one-to-one ke Pembayaran (untuk input manual)
    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'id_transaksi', 'id_transaksi');
    }

    /**
     * Accessor untuk format tanggal bayar
     */
    public function getTanggalBayarFormattedAttribute()
    {
        return $this->tanggal_bayar ? date('d/m/Y', strtotime($this->tanggal_bayar)) : '-';
    }

    /**
     * Accessor untuk badge kategori
     */
    public function getBadgeKategoriAttribute()
    {
        $badges = [
            'pemasukan' => '<span class="badge bg-success">Pemasukan</span>',
            'pengeluaran' => '<span class="badge bg-danger">Pengeluaran</span>',
            'uang_muka' => '<span class="badge bg-info">Uang Muka</span>',
            'piutang' => '<span class="badge bg-warning">Piutang</span>',
        ];
        
        return $badges[$this->kategori] ?? '<span class="badge bg-secondary">-</span>';
    }

    /**
     * Accessor untuk badge status bayar
     */
    public function getBadgeStatusAttribute()
    {
        $badges = [
            'Sudah' => '<span class="badge bg-success">Sudah</span>',
            'Belum' => '<span class="badge bg-danger">Belum</span>',
        ];
        
        return $badges[$this->status_bayar] ?? '<span class="badge bg-secondary">-</span>';
    }

    /**
     * Scope untuk filter kategori
     */
    public function scopeKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }

    /**
     * Scope untuk filter status bayar
     */
    public function scopeStatusBayar($query, $status)
    {
        return $query->where('status_bayar', $status);
    }

    /**
     * Scope untuk filter tanggal
     */
    public function scopeTanggal($query, $tanggal)
    {
        return $query->whereDate('tanggal_bayar', $tanggal);
    }

    /**
     * Scope untuk filter bulan
     */
    public function scopeBulan($query, $bulan, $tahun = null)
    {
        $tahun = $tahun ?? date('Y');
        return $query->whereMonth('tanggal_bayar', $bulan)
                     ->whereYear('tanggal_bayar', $tahun);
    }
}