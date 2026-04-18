<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class KunjunganApproved extends Mailable
{
    use Queueable, SerializesModels;

    public $kunjungan;

    public function __construct($kunjungan)
    {
        $this->kunjungan = $kunjungan;
    }

    public function build()
    {
        return $this->subject('Konfirmasi Kunjungan - P4S Gubuk Sayur')
                    ->view('emails.kunjungan_approved');
    }
}