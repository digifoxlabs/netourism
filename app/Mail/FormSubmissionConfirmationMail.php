<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class FormSubmissionConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $content
    ) {}

    public function build()
    {
        return $this
            ->subject('Submission Received')
            ->view('emails.generic')
            ->with(['content' => $this->content]);
    }
}
