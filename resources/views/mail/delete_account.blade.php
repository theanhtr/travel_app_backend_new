@php
    $logoUrl = asset('/images/logo.svg');
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Delete Account</title>
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
                            <h1 style="font-size: 24px; font-weight: 600; margin-bottom: 20px;">Warning!</h1>
            
                            <p style="font-size: 16px; line-height: 24px; margin-bottom: 30px;">Your account violated our community guidelines and has been permanently deleted !!!</p>
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