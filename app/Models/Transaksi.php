<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi';

    protected $fillable = [
        'user_id',
        'pendaftaran_id',
        'kode_invoice',
        'order_id',
        'gross_amount',
        'payment_type',
        'transaction_status',
        'snap_token',
        'tanggal_transaksi'
    ];
}

