<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Pembayaran extends Model
{
    protected $table = 'tr_pembayaran';
    protected $primaryKey = 'id_pembayaran';
    
    protected $fillable = [
        'id_murid',
        'id_paket',
        'tanggal',
        'paket_awal',
        'paket_selanjutnya',
        'bulan_dibayar',
        'tahun_dibayar',
        'status_tagihan',
        'total_piutang',
        'total_uang_muka',
        'total_pembayaran',
        'keterangan',
    ];
    
    // Relasi ke tabel murid
    public function murid()
    {
        return $this->belongsTo(Murid::class, 'id_murid', 'id_murid');
    }
    
    // Relasi ke tabel harga paket
    public function paket()
    {
        return $this->belongsTo(HargaPaket::class, 'id_paket', 'id_paket');
    }
    
    // Accessor untuk format tanggal Indonesia
    public function getTanggalFormattedAttribute()
    {
        return date('d/m/Y', strtotime($this->tanggal));
    }
    
    // Accessor untuk format total pembayaran
    public function getTotalPembayaranFormattedAttribute()
    {
        return 'Rp ' . number_format($this->total_pembayaran, 0, ',', '.');
    }
    
    // Accessor untuk format paket awal
    public function getPaketAwalFormattedAttribute()
    {
        return $this->paket_awal ? 'Rp ' . number_format($this->paket_awal, 0, ',', '.') : '-';
    }
    
    // Accessor untuk format total piutang
    public function getTotalPiutangFormattedAttribute()
    {
        return $this->total_piutang > 0 ? 'Rp ' . number_format($this->total_piutang, 0, ',', '.') : '-';
    }
    
    // Accessor untuk format total uang muka
    public function getTotalUangMukaFormattedAttribute()
    {
        return $this->total_uang_muka > 0 ? 'Rp ' . number_format($this->total_uang_muka, 0, ',', '.') : '-';
    }
    
    // Accessor untuk nama bulan dibayar
    public function getBulanDibayarFormattedAttribute()
    {
        if ($this->bulan_dibayar) {
            $bulan = Carbon::create()->month($this->bulan_dibayar)->translatedFormat('F');
            $tahun = $this->tahun_dibayar ?? Carbon::now()->year;
            return $bulan . ' ' . $tahun;
        }
        return '-';
    }
    
    // Accessor untuk status tagihan dengan label dan warna
    public function getStatusTagihanLabelAttribute()
    {
        $status = strtolower($this->status_tagihan);
        
        if ($status == 'lunas') {
            return [
                'label' => 'Lunas',
                'class' => 'background: #E1F7E3; color: #0E7490;'
            ];
        } elseif ($status == 'tunggak') {
            return [
                'label' => 'Tunggak',
                'class' => 'background: #FEF3C7; color: #92400E;'
            ];
        } elseif ($status == 'uang muka') {
            return [
                'label' => 'Uang Muka',
                'class' => 'background: #E0E7FF; color: #4338CA;'
            ];
        } else {
            return [
                'label' => $this->status_tagihan ?? '-',
                'class' => 'background: #F3F4F6; color: #6B7280;'
            ];
        }
    }
    
    // Scope untuk filter berdasarkan status tagihan
    public function scopeStatusTagihan($query, $status)
    {
        if ($status) {
            return $query->where('status_tagihan', $status);
        }
        return $query;
    }
    
    // Scope untuk filter berdasarkan bulan dibayar
    public function scopeBulanDibayar($query, $bulan)
    {
        if ($bulan) {
            return $query->where('bulan_dibayar', $bulan);
        }
        return $query;
    }
    
    // Scope untuk filter berdasarkan tahun dibayar
    public function scopeTahunDibayar($query, $tahun)
    {
        if ($tahun) {
            return $query->where('tahun_dibayar', $tahun);
        }
        return $query;
    }
    
    // Scope untuk filter berdasarkan tanggal transaksi
    public function scopeBulanTahun($query, $bulan, $tahun)
    {
        if ($bulan && $tahun) {
            return $query->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun);
        }
        return $query;
    }
    
    // Scope untuk filter berdasarkan murid
    public function scopeByMurid($query, $id_murid)
    {
        if ($id_murid) {
            return $query->where('id_murid', $id_murid);
        }
        return $query;
    }
    
    // Scope untuk pembayaran pendaftaran (paket_awal)
    public function scopePendaftaran($query)
    {
        return $query->whereNull('paket_selanjutnya');
    }
    
    // Scope untuk pembayaran bulanan (paket_selanjutnya)
    public function scopeBulanan($query)
    {
        return $query->whereNotNull('paket_selanjutnya');
    }
    
    // Scope untuk rentang tanggal
    public function scopeTanggalBetween($query, $start, $end)
    {
        if ($start && $end) {
            return $query->whereBetween('tanggal', [$start, $end]);
        }
        return $query;
    }
    
    // Method untuk cek apakah ini pembayaran pendaftaran
    public function isPendaftaran()
    {
        return is_null($this->paket_selanjutnya);
    }
    
    // Method untuk cek apakah ini pembayaran bulanan
    public function isBulanan()
    {
        return !is_null($this->paket_selanjutnya);
    }
    
    // Method untuk cek apakah status lunas
    public function isLunas()
    {
        return strtolower($this->status_tagihan) == 'lunas';
    }
    
    // Method untuk cek apakah status tunggak
    public function isTunggak()
    {
        return strtolower($this->status_tagihan) == 'tunggak';
    }
    
    // Method untuk cek apakah status uang muka
    public function isUangMuka()
    {
        return strtolower($this->status_tagihan) == 'uang muka';
    }
    
    // Boot method untuk event handling
    protected static function boot()
    {
        parent::boot();
        
        // Sebelum create, set default values jika kosong
        static::creating(function ($model) {
            if (empty($model->status_tagihan)) {
                $model->status_tagihan = 'lunas';
            }
            if (empty($model->total_piutang)) {
                $model->total_piutang = 0;
            }
            if (empty($model->total_uang_muka)) {
                $model->total_uang_muka = 0;
            }
        });
    }
}