<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class GenericSubmissionMail extends Mailable
{
    public function __construct(
        public string $subjectLine,
        public string $htmlContent
    ) {}

    public function build()
    {
        return $this
            ->subject($this->subjectLine)
            ->html($this->htmlContent);
    }
}
