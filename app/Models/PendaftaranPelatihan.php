<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\KelasPelatihan;

class PendaftaranPelatihan extends Model
{
    protected $table = 'pendaftaran_pelatihan';
    protected $fillable = [
        'order_id', 
        'nama', 
        'email', 
        'no_hp',
        'status_pembayaran',
        'pelatihan_id', 
        'tanggal_daftar',
        'status_pendaftaran',
        'total_harga', 
        'snap_token'
    ];

    /**
     * Menghubungkan pendaftaran dengan detail kelas pelatihan
     */
    public function pelatihan()
    {
        return $this->belongsTo(KelasPelatihan::class, 'pelatihan_id');
    }
}