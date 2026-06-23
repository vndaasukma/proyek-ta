<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kemitraan extends Model
{
    use HasFactory;

    protected $table = 'kemitraan';

    protected $fillable = [
        'nama_perwakilan',
        'nama_instansi',
        'no_wa',
        'email',
        'deskripsi',
        'proposal_path',
        'status'
    ];
}