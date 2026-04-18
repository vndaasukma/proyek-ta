<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kunjungan extends Model
{
    protected $table = 'kunjungan';

    protected $fillable = [
        'judul',
        'tanggal',
        'jam',
        'kuota',
        'terisi',
        'keterangan'
    ];
}

