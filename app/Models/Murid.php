<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Murid extends Model
{
    use HasFactory;

    protected $table = 'ms_murid';
    protected $primaryKey = 'id_murid';
    
    public $timestamps = true;
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        'nama_lengkap',
        'asal_sekolah',
        'alamat',
        'no_hp',
        'nama_orang_tua',
        'no_hp_orang_tua',
        'tahun_masuk',
        'tanggal_daftar',
    ];

    protected $casts = [
        'tanggal_daftar' => 'date',
        'tahun_masuk' => 'integer',
    ];

    /**
     * Relasi ke tabel transaksi kelas (tr_kelas)
     */
    public function transaksiKelas()
    {
        return $this->hasMany(TransaksiKelas::class, 'id_murid', 'id_murid');
    }

    /**
     * Relasi ke tabel transaksi paket (tr_paket)
     */
    public function transaksiPaket()
    {
        return $this->hasMany(TransaksiPaket::class, 'id_murid', 'id_murid');
    }

    /**
     * Relasi ke tabel pembayaran (tr_transaksi)
     */
    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class, 'id_murid', 'id_murid');
    }

    /**
     * Accessor untuk mendapatkan kelas terbaru (berdasarkan created_at)
     */
    public function getKelasAktifAttribute()
    {
        $kelasTerbaru = $this->transaksiKelas()
            ->orderBy('created_at', 'desc')
            ->with('kelas')
            ->first();
            
        return $kelasTerbaru && $kelasTerbaru->kelas 
            ? $kelasTerbaru->kelas->nama_kelas 
            : '-';
    }

    /**
     * Accessor untuk mendapatkan kelas lengkap dengan jenjang
     */
    public function getKelasLengkapAttribute()
    {
        $kelasTerbaru = $this->transaksiKelas()
            ->orderBy('created_at', 'desc')
            ->with('kelas')
            ->first();
            
        return $kelasTerbaru && $kelasTerbaru->kelas 
            ? $kelasTerbaru->kelas->jenjang . ' - ' . $kelasTerbaru->kelas->nama_kelas 
            : '-';
    }

    /**
     * Accessor untuk mendapatkan paket terbaru (berdasarkan created_at)
     */
    public function getPaketAktifAttribute()
    {
        $paketTerbaru = $this->transaksiPaket()
            ->orderBy('created_at', 'desc')
            ->with('paket')
            ->first();
            
        return $paketTerbaru && $paketTerbaru->paket 
            ? $paketTerbaru->paket->tingkat 
            : '-';
    }

    /**
     * Accessor untuk mendapatkan biaya pendaftaran terbaru
     */
    public function getBiayaPendaftaranAttribute()
    {
        $paketTerbaru = $this->transaksiPaket()
            ->orderBy('created_at', 'desc')
            ->first();
            
        return $paketTerbaru ? $paketTerbaru->biaya_pendaftaran : 0;
    }

    /**
     * Accessor untuk format biaya pendaftaran ke Rupiah
     */
    public function getBiayaPendaftaranFormattedAttribute()
    {
        return 'Rp ' . number_format($this->biaya_pendaftaran, 0, ',', '.');
    }

    /**
     * Accessor untuk ID Kelas terbaru
     */
    public function getIdKelasAktifAttribute()
    {
        $kelasTerbaru = $this->transaksiKelas()
            ->orderBy('created_at', 'desc')
            ->first();
            
        return $kelasTerbaru ? $kelasTerbaru->id_kelas : null;
    }

    /**
     * Accessor untuk ID Paket terbaru
     */
    public function getIdPaketAktifAttribute()
    {
        $paketTerbaru = $this->transaksiPaket()
            ->orderBy('created_at', 'desc')
            ->first();
            
        return $paketTerbaru ? $paketTerbaru->id_paket : null;
    }

    /**
     * Accessor untuk ID Periode dari transaksi paket terbaru
     */
    public function getIdPeriodeAktifAttribute()
    {
        $paketTerbaru = $this->transaksiPaket()
            ->orderBy('created_at', 'desc')
            ->first();
            
        return $paketTerbaru ? $paketTerbaru->id_periode : null;
    }

    /**
     * Accessor untuk mendapatkan tahun periode dari transaksi paket terbaru
     */
    public function getTahunPeriodeAttribute()
    {
        $paketTerbaru = $this->transaksiPaket()
            ->orderBy('created_at', 'desc')
            ->with('periode')
            ->first();
            
        return ($paketTerbaru && $paketTerbaru->periode) 
            ? $paketTerbaru->periode->tahun_periode 
            : '-';
    }

    /**
     * Scope untuk pencarian
     */
    public function scopeSearch($query, $search)
    {
        return $query->where('nama_lengkap', 'like', '%' . $search . '%')
                     ->orWhere('asal_sekolah', 'like', '%' . $search . '%')
                     ->orWhere('no_hp', 'like', '%' . $search . '%');
    }

    /**
     * Scope untuk tahun masuk
     */
    public function scopeTahunMasuk($query, $tahun)
    {
        return $query->where('tahun_masuk', $tahun);
    }

    /**
     * Scope untuk filter by paket
     */
    public function scopeByPaket($query, $paketTingkat)
    {
        return $query->whereHas('transaksiPaket', function($q) use ($paketTingkat) {
            $q->whereHas('paket', function($subQ) use ($paketTingkat) {
                $subQ->where('tingkat', $paketTingkat);
            });
        });
    }

    /**
     * Scope untuk filter by kelas
     */
    public function scopeByKelas($query, $idKelas)
    {
        return $query->whereHas('transaksiKelas', function($q) use ($idKelas) {
            $q->where('id_kelas', $idKelas);
        });
    }

    /**
     * Scope untuk filter by tahun periode (dari tr_paket)
     */
    public function scopeByTahunPeriode($query, $tahunPeriode)
    {
        return $query->whereHas('transaksiPaket', function($q) use ($tahunPeriode) {
            $q->whereHas('periode', function($subQ) use ($tahunPeriode) {
                $subQ->where('tahun_periode', $tahunPeriode);
            });
        });
    }
}