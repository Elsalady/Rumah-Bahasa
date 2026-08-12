<?php

namespace App\Mail;

use App\Models\Kontak;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class KontakMasukMail extends Mailable
{
    use Queueable, SerializesModels;

    public Kontak $kontak;

    public function __construct(Kontak $kontak)
    {
        $this->kontak = $kontak;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '📩 Pesan Baru dari ' . ($this->kontak->nama ?? 'Pengunjung'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.kontak-masuk',
        );
    }
}
