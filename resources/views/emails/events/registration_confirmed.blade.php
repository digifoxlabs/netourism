<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registration Confirmed</title>
</head>
<body style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; background-color: #f3f4f6; padding: 20px;">
    <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" role="presentation" style="background-color: #ffffff; border-radius: 12px; padding: 24px;">
                    <tr>
                        <td>
                            @include('emails.events.partials.registration_confirmed_content', ['registration' => $registration])
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
