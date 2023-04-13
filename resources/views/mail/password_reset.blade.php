@php
    $logoUrl = asset('/images/logo.svg');
@endphp

<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
</head>

<body style="margin: 0; padding: 0; font-family: sans-serif;">
    <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border-collapse: collapse;">
        <tr>
            <td align="center" bgcolor="#ffffff" style="padding: 40px 0;">
                <table border="0" cellpadding="0" cellspacing="0" width="80%">
                    <tr>
                        <td align="center" style="padding-bottom: 30px;">
                            <img src="{{ $logoUrl }}" alt="My App Logo" width="150" style="display: block;">
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 30px; background-color: #ffffff; border-radius: 4px; box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);">
                            <h1 style="color: #333333; font-size: 24px; margin-bottom: 20px;">Forgot Password</h1>
                            <p style="color: #666666; font-size: 16px; margin-bottom: 30px;">Hi,</p>
                            <p style="color: #666666; font-size: 16px; margin-bottom: 30px;">We received a request to reset your password for Travel App. If you did not request this, please ignore this email.</p>
                            <p style="color: #666666; font-size: 16px; margin-bottom: 30px;">To reset your password, please use this number:</p>
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td align="center">
                                        <div style="background-color: #0033cc; border-radius: 4px; color: #ffffff; display: inline-block; font-size: 16px; font-weight: 600; padding: 10px 20px; text-align: center; text-decoration: none;">{{ $token }}</div>
                                    </td>
                                </tr>
                            </table>
                            <p style="color: #666666; font-size: 16px; margin-top: 30px;">This reset number expires in <span style="color: red">15</span> minutes</p>
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