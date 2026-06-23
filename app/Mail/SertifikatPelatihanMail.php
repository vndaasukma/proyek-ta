<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Attachment;

/**
 * @author Vinda Ambitha Sukma
 */
class SertifikatPelatihanMail extends Mailable
{
    use Queueable, SerializesModels;

    public $peserta;

    /**
     * Create a new message instance.
     */
    public function __construct($peserta)
    {
        // Menangkap ringkasan data peserta dari controller
        $this->peserta = $peserta;
    }

    /**
     * Get the message envelope (Subjek Email).
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Sertifikat Resmi Pelatihan - P4S Gubuk Sayur',
        );
    }

    /**
     * Get the message content definition (Mengarahkan ke View Body isi Email).
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.sertifikat',
        );
    }

    /**
     * Get the attachments for the message (Menyisipkan Berkas PDF Sertifikat).
     */
    public function attachments(): array
    {
        return [
            // Mengubah string biner PDF dari dompdf menjadi file fisik .pdf saat nempel di email
            Attachment::fromData(fn () => $this->peserta->pdf_binary, 'Sertifikat_Resmi_Gubuk_Sayur.pdf')
                ->withMime('application/pdf'),
        ];
    }
}