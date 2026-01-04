<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EventRegistrationConfirmedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $content
    ) {}

    public function build()
    {
        return $this
            ->subject('Event Registration Confirmed')
            ->view('emails.generic')
            ->with(['content' => $this->content]);
    }
}
