<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\EventRegistration;

class EventRegistrationConfirmed extends Mailable
{
    use Queueable, SerializesModels;

    public EventRegistration $registration;

    public function __construct(EventRegistration $registration)
    {
        $this->registration = $registration;
    }

    // public function build()
    // {
    //     return $this
    //         ->subject('Your registration for ' . $this->registration->event_name . ' is confirmed')
    //         ->markdown('emails.events.registration_confirmed');
    // }

    public function build()
{
    return $this
        ->subject('Your registration for ' . $this->registration->event_name . ' is confirmed')
        ->view('emails.events.registration_confirmed')
        ->with([
            'registration' => $this->registration,
        ]);
}
}
