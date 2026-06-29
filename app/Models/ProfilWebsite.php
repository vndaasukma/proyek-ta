<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfilWebsite extends Model
{
    use HasFactory;

    protected $table = 'profil_website';

    protected $fillable = [
        'judul',
        'deskripsi',
        'visi_judul',
        'visi_deskripsi',
        'edukasi_judul',
        'edukasi_deskripsi',
        'gambar'
    ];
}