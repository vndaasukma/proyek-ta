<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @author Vinda Ambitha Sukma
 */
class KelasPelatihan extends Model
{
    use HasFactory;

    protected $table = 'trainings';

    protected $fillable = [
        'title',
        'description',
        'ketentuan',
        'price',
        'quota',
        'terisi',
        'status',
        'gambar',
        'tanggal_pelatihan',
        'tanggal_exp_pelatihan',
        'pelatih_id',
        'nama_pelatih',
        'ttd_pelatih',
        'nama_penyelenggara',
        'ttd_penyelenggara',
        'nama_ketua',
        'ttd_ketua',
        'template_sertifikat',
    ];

    protected $casts = [
        'tanggal_pelatihan'     => 'date',
        'tanggal_exp_pelatihan' => 'date',
    ];

    // =============================================
    // ACCESSORS — alias agar blade bisa pakai
    // nama "bahasa Indonesia" maupun nama kolom DB
    // =============================================

    public function getNamaPelatihanAttribute()
    {
        return $this->title;
    }

    public function getDeskripsiAttribute()
    {
        return $this->description;
    }

    public function getHargaAttribute()
    {
        return $this->price;
    }

    public function getKuotaAttribute()
    {
        return $this->quota;
    }

    /**
     * Accessor batas_pendaftaran → tanggal_exp_pelatihan
     * Agar view index yang memakai $p->batas_pendaftaran tidak error.
     */
    public function getBatasPendaftaranAttribute()
    {
        return $this->tanggal_exp_pelatihan;
    }

    // =============================================
    // RELATIONS
    // =============================================

    public function pelatih()
    {
        return $this->belongsTo(Pelatih::class, 'pelatih_id');
    }

    public function pendaftar()
    {
        return $this->hasMany(PendaftaranPelatihan::class, 'pelatihan_id', 'id');
    }

    /**
     * RELASI DETAIL JADWAL AGENDA
     * Menghubungkan Kelas Pelatihan ke tabel jadwal_pelatihans
     */
    public function jadwal()
    {
        return $this->hasMany(JadwalPelatihan::class, 'kelas_pelatihan_id');
    }

    /**
     * Menghubungkan Kelas Pelatihan ke tabel sertifikat_pelatihans
     */
    public function pengaturanSertifikat()
    {
        return $this->hasOne(SertifikatPelatihan::class, 'kelas_pelatihan_id', 'id');
    }
}