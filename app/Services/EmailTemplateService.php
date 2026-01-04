<?php

namespace App\Services;

use App\Models\FormSubmission;

// class EmailTemplateService
// {
//     /**
//      * Render an email template by replacing placeholders
//      * with submission + event data.
//      */
//     public static function render(string $template, FormSubmission $submission): string
//     {
//         // Merge submission data + system placeholders
//         $data = array_merge(
//             $submission->data ?? [],
//             [
//                 'event_title'   => optional($submission->event)->title,
//                 'submission_id'=> $submission->id,
//                 'submitted_at' => optional($submission->created_at)->format('d M Y, h:i A'),
//             ]
//         );

//         foreach ($data as $key => $value) {
//             if (is_array($value)) {
//                 $value = implode(', ', $value);
//             }

//             $template = preg_replace(
//                 '/{{\s*' . preg_quote($key, '/') . '\s*}}/i',
//                 e($value),
//                 $template
//             );
//         }

//         return nl2br($template);
//     }
// }

class EmailTemplateService
{
    public static function render(string $template, FormSubmission $submission): string
    {
        $data = self::data($submission);

        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $value = implode(', ', $value);
            }

            $template = preg_replace(
                '/{{\s*' . preg_quote($key, '/') . '\s*}}/i',
                $value,
                $template
            );
        }

        return $template;
    }

    public static function data(FormSubmission $submission): array
    {
        return array_merge(
            $submission->data ?? [],
            [
                'event_title'    => optional($submission->event)->title,
                'submission_id'  => $submission->id,
                'submitted_at'   => optional($submission->created_at)->format('d M Y, h:i A'),
            ]
        );
    }
}
