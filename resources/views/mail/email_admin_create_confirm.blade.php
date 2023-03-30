@php
    $logoUrl = asset('/images/logo.svg');
    $confirmUrl = env('BASE_URL_HOME') . '/api/email-confirm/' . $user_id . '/' . $email;
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Welcome to my App</title>
</head>
<body>
    <table cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td align="center" bgcolor="#f4f4f4" style="padding: 30px 10px;">
                <table cellpadding="0" cellspacing="0" width="600" bgcolor="#ffffff" style="border-radius: 4px; box-shadow: 0 0 8px rgba(0, 0, 0, 0.1);">
                    <tr>
                        <td align="center" style="padding: 40px 20px;">
                                <img src="{{ $logoUrl }}" alt="Logo" style="max-width: 100%;">
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 0 20px;">
                            <h1 style="font-size: 24px; font-weight: 600; margin-bottom: 20px;">Welcome!</h1>
                            <p style="font-size: 16px; line-height: 24px; margin-bottom: 30px;">The administrator has created an account for you:</p>
                            <p style="font-size: 20px; line-height: 24px; margin-bottom: 30px;">Email: {{$email}}</p>
                            <p style="font-size: 20px; line-height: 24px; margin-bottom: 30px;">Password: {{$password}}</p>
                            <p style="font-size: 16px; line-height: 24px; margin-bottom: 30px;">Please click button below to confirm then change password in Travel App:</p>
                            <table cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td style="text-align: center; padding: 10px 20px;">
                                        <a href="{{ $confirmUrl }}" target="_blank" rel="noopener" style="background-color: #007bff; border-radius: 4px; color: #ffffff; display:inline-block; font-size: 16px; font-weight: 600; padding: 10px 20px; text-align: center; text-decoration: none;">Confirm Email</a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                    <td bgcolor="#f4f4f4" style="padding: 20px; text-align: center;">
                    <p style="color: #666666; font-size: 12px; margin-bottom: 0;">This email was sent from Travel App.</p>
                    </td>
                    </tr>
                    </table>
                    </td>
                    </tr>
                    </table>

                    </body>
    </html>