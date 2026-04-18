<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KelasPelatihan extends Model
{
    protected $table = 'kelas_pelatihan';

    protected $fillable = [
        'nama_pelatihan',
        'deskripsi',
        'harga',
        'kuota',
        'status', 
        'gambar'
    ];
}