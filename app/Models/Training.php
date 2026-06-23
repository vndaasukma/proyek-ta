<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'price',
        'quota',
        'status',
        'image',             
        'tanggal_pelatihan', 
        'id_pelatih'         
    ];

    // Relasi untuk menghitung kuota terisi secara otomatis
    public function registrations()
    {
        return $this->hasMany(PendaftaranPelatihan::class, 'training_id');
    }

    // Relasi ke User/Pelatih agar tombol WA dinamis
    public function coach()
    {
        return $this->belongsTo(User::class, 'id_pelatih');
    }
}