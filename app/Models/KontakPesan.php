<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KontakPesan extends Model
{
    use HasFactory;

    // Nama tabel di database (Laravel otomatis jamak, tapi kita tegaskan di sini)
    protected $table = 'kontak_pesans';

    // Daftar kolom yang boleh diisi secara massal (Mass Assignment)
    protected $fillable = [
        'nama', 
        'alamat', 
        'email', 
        'no_hp', 
        'pesan', 
        'is_read'
    ];
}