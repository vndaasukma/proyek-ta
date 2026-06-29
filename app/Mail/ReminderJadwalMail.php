<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * @author Vinda Ambitha Sukma
 */
class ReminderJadwalMail extends Mailable
{
    use Queueable, SerializesModels;

    public $kelas;
    public $peserta;

    public function __construct($kelas, $peserta)
    {
        $this->kelas = $kelas;
        $this->peserta = $peserta;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'PENTING: Pengingat & Pembaruan Jadwal Pelatihan - Gubuk Sayur',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.reminder_jadwal',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}