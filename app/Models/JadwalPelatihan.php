<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @author Vinda Ambitha Sukma
 */
class JadwalPelatihan extends Model
{
    use HasFactory;

    protected $table = 'jadwal_pelatihans';

    protected $fillable = [
        'kelas_pelatihan_id',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'materi',
        'keterangan'
    ];


    public function kelas()
    {
        return $this->belongsTo(KelasPelatihan::class, 'kelas_pelatihan_id');
    }
}