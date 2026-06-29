<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Pelatih extends Model
{
    protected $table = 'pelatih';
    protected $fillable = ['nama', 'no_wa', 'keahlian'];

    public function kelas() {
        return $this->hasMany(KelasPelatihan::class, 'pelatih_id');
    }
}
