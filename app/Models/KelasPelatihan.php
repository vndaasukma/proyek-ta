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
        'nama_pelatih',
        'ttd_pelatih'  
    ];

    public function getNamaPelatihanAttribute() { return $this->title; }
    public function getDeskripsiAttribute() { return $this->description; }
    public function getHargaAttribute() { return $this->price; }
    public function getKuotaAttribute() { return $this->quota; }
}