<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InquiryReceived extends Mailable
{
    use Queueable, SerializesModels;

    /** @var array */
    public $data;

    /**
     * Create a new message instance.
     *
     * @param array $data Prepared data array from controller
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $subject = 'New Enquiry from Website: ' . ($this->data['name'] ?? 'Unknown');

        return $this
            ->subject($subject)
            ->view('emails.inquiry-received')
            ->with(['data' => $this->data]);
    }
}