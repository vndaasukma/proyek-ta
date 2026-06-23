<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @author Vinda Ambitha Sukma
 */
class LockedDate extends Model
{
    // Mengunci nama tabel yang sinkron dengan database
    protected $table = 'locked_dates';
    
    // Mendaftarkan kolom yang boleh diisi
    protected $fillable = ['date', 'keterangan'];
}