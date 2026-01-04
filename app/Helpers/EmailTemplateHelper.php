<?php

namespace App\Helpers;

class EmailTemplateHelper
{
    public static function render(string $template, array $data): string
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $value = implode(', ', $value);
            }

            $template = str_replace('{{' . $key . '}}', (string) $value, $template);
        }

        return $template;
    }
}
