<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @author Vinda Ambitha Sukma
 */
class SertifikatPelatihan extends Model
{
    use HasFactory;

    protected $table = 'sertifikat_pelatihans';

    protected $fillable = [
        'kelas_pelatihan_id',
        'nama_pelatih',
        'ttd_pelatih',
        'nama_penyelenggara',
        'ttd_penyelenggara',
        'nama_ketua',
        'ttd_ketua',
        'template_sertifikat',
    ];

    // Hubungkan balik ke model KelasPelatihan
    public function kelasPelatihan()
    {
        return $this->belongsTo(KelasPelatihan::class, 'kelas_pelatihan_id', 'id');
    }
}