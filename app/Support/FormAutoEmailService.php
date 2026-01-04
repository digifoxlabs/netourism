<?php

namespace App\Support;

use Illuminate\Support\Facades\Mail;
use App\Services\EmailTemplateService;


class FormAutoEmailService
{
    public static function sendIfEnabled($form, array $submissionData): void
    {
        // Check if form auto email is enabled
        if (!$form->auto_email_confirmation) {
            return;
        }

        if (empty($form->confirmation_email_template)) {
            return;
        }

        // Try to detect user email from submission
        $userEmail = $submissionData['email'] ?? null;

        if (!$userEmail) {
            return;
        }

        // Render template
        $body = self::renderTemplate(
            $form->confirmation_email_template,
            $submissionData
        );

        Mail::raw($body, function ($message) use ($userEmail) {
            $message
                ->to($userEmail)
                ->bcc(config('mail.admin_email'))
                ->subject('Your response is received');
        });


    }

    protected static function renderTemplate(string $template, array $data): string
    {
        foreach ($data as $key => $value) {
            $template = preg_replace(
                '/{{\s*' . preg_quote($key, '/') . '\s*}}/',
                (string) $value,
                $template
            );
        }

        return $template;
    }
}
