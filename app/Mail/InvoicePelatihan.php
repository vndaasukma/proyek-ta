<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\PendaftaranPelatihan;

/**
 * @author Vinda Ambitha Sukma
 */
class InvoicePelatihan extends Mailable
{
    use Queueable, SerializesModels;

    public $pendaftaran;

    public function __construct(PendaftaranPelatihan $pendaftaran)
    {
        $this->pendaftaran = $pendaftaran;
    }

    public function build()
    {
        return $this->subject('Bukti Pembayaran Pelatihan - Gubuk Sayur')
                    ->view('emails.invoice');
    }
}