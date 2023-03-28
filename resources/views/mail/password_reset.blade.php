@php
    $logoUrl = asset('/images/logo.svg');
    $resetUrl = env('BASE_URL_HOME') . '/api/reset-password/' . $token;
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
                            <img src="{{ $logoUrl }}" alt="My App Logo" width="150" style="display: block;">\
                            <svg version="1.0" xmlns="http://www.w3.org/2000/svg"
                                width="1500.000000pt" height="1500.000000pt" viewBox="0 0 500.000000 500.000000"
                                preserveAspectRatio="xMidYMid meet">

                                <g transform="translate(0.000000,500.000000) scale(0.100000,-0.100000)"
                                fill="#000000" stroke="none">
                                <path d="M2306 3834 c-324 -64 -589 -266 -731 -559 -60 -123 -94 -242 -102
                                -357 l-6 -77 54 21 c237 90 593 59 1214 -109 249 -68 250 -68 380 -67 118 0
                                137 3 205 28 210 80 359 244 392 433 26 157 -53 292 -224 379 -26 13 -51 24
                                -55 24 -4 0 14 -21 39 -47 116 -119 139 -280 57 -412 l-21 -34 -29 86 c-121
                                363 -417 621 -792 692 -97 18 -287 18 -381 -1z"/>
                                <path d="M3300 3654 c0 -9 61 -228 65 -232 1 -1 13 25 25 58 l23 61 -54 56
                                -54 56 45 -27 c89 -54 84 -53 145 -11 30 20 55 38 55 39 0 6 -250 6 -250 0z"/>
                                <path d="M1554 2725 c-89 -16 -102 -23 -157 -86 -50 -57 -91 -135 -106 -200
                                -40 -170 51 -315 214 -345 l40 -7 -32 37 c-88 99 -94 210 -17 311 l26 35 54
                                -108 c149 -298 421 -501 748 -558 119 -21 319 -14 428 15 310 81 573 306 694
                                592 28 67 31 80 17 74 -119 -49 -242 -71 -342 -61 -88 9 -193 35 -427 105
                                -648 194 -907 239 -1140 196z m1146 -326 c0 -4 10 -5 22 -1 14 3 19 1 14 -6
                                -5 -8 -2 -10 8 -6 9 3 16 1 16 -6 0 -6 5 -8 10 -5 6 3 10 1 10 -4 0 -6 3 -10
                                8 -10 20 3 33 -2 27 -11 -4 -6 -3 -10 2 -9 23 4 36 -5 73 -53 23 -28 39 -57
                                36 -65 -3 -8 -2 -12 3 -9 11 7 23 -22 15 -35 -3 -5 0 -9 7 -9 6 0 9 -8 6 -20
                                -3 -10 0 -21 5 -22 11 -4 15 -74 6 -128 -5 -33 -10 -37 -80 -68 -134 -57 -217
                                -74 -373 -76 -134 -1 -197 6 -193 22 1 4 -3 17 -10 29 -6 12 -9 29 -5 39 4 11
                                3 15 -4 11 -12 -7 -18 11 -28 86 -4 27 -3 47 2 47 5 0 8 14 5 30 -3 19 0 30 7
                                30 7 0 10 4 6 10 -9 14 23 82 48 105 13 11 16 16 7 10 -8 -5 1 8 20 29 41 44
                                115 90 130 81 5 -3 10 -1 10 5 0 7 8 9 21 5 12 -4 19 -3 16 2 -3 4 30 8 74 8
                                43 0 79 -3 79 -6z"/>
                                <path d="M2850 2316 c0 -2 8 -10 18 -17 15 -13 16 -12 3 4 -13 16 -21 21 -21
                                13z"/>
                                <path d="M1934 1737 c-2 -7 -3 -82 -2 -167 3 -152 3 -155 26 -158 l22 -3 0
                                170 c0 165 -1 171 -20 171 -11 0 -23 -6 -26 -13z"/>
                                <path d="M800 1705 c0 -23 3 -25 50 -25 l50 0 0 -135 0 -135 25 0 25 0 0 135
                                0 135 50 0 c47 0 50 2 50 25 l0 25 -125 0 -125 0 0 -25z"/>
                                <path d="M2248 1721 c-69 -22 -108 -74 -108 -144 0 -97 57 -159 148 -160 50
                                -1 122 27 122 47 0 28 -23 35 -48 16 -53 -42 -139 -15 -167 54 -18 42 -8 81
                                27 116 35 35 92 40 139 13 26 -16 31 -16 39 -3 15 23 12 28 -19 44 -38 20 -99
                                27 -133 17z"/>
                                <path d="M1062 1533 c3 -114 4 -118 26 -121 21 -3 22 0 22 60 0 76 15 108 58
                                127 19 9 32 22 32 33 0 24 -31 23 -64 -3 l-26 -20 0 20 c0 16 -6 21 -25 21
                                l-26 0 3 -117z"/>
                                <path d="M1243 1640 c-25 -10 -27 -17 -13 -40 7 -12 12 -12 22 -2 15 15 80 16
                                96 0 24 -24 13 -38 -28 -38 -60 0 -108 -23 -116 -56 -16 -65 59 -114 124 -82
                                26 13 32 14 36 2 3 -8 15 -14 26 -14 19 0 20 6 20 99 0 96 -1 100 -26 120 -29
                                22 -99 28 -141 11z m117 -140 c0 -42 -80 -65 -103 -29 -20 32 -1 49 53 49 43
                                0 50 -3 50 -20z"/>
                                <path d="M1430 1646 c0 -2 20 -55 44 -118 41 -104 47 -113 71 -113 25 0 30 8
                                71 115 24 63 44 116 44 118 0 1 -11 2 -24 2 -21 0 -28 -11 -56 -90 -18 -50
                                -34 -89 -37 -87 -2 2 -16 42 -32 88 -25 75 -31 84 -54 87 -15 2 -27 1 -27 -2z"/>
                                <path d="M1694 1616 c-30 -30 -34 -40 -34 -86 0 -43 5 -56 28 -80 36 -35 84
                                -45 136 -28 42 14 51 25 38 46 -7 10 -14 10 -38 -3 -16 -8 -36 -15 -45 -15
                                -19 0 -69 37 -69 51 0 5 41 9 90 9 90 0 90 0 90 25 0 38 -25 92 -48 104 -12 6
                                -42 11 -67 11 -40 0 -52 -5 -81 -34z m130 -22 c33 -32 20 -44 -49 -44 -69 0
                                -79 8 -48 42 20 22 76 24 97 2z"/>
                                <path d="M2500 1643 c-70 -26 -92 -134 -39 -191 27 -30 86 -44 131 -31 50 13
                                78 51 78 105 0 56 -17 92 -51 110 -28 14 -90 18 -119 7z m99 -50 c11 -10 24
                                -32 27 -50 5 -27 1 -37 -24 -63 -37 -36 -65 -38 -97 -5 -69 68 20 179 94 118z"/>
                                <path d="M2720 1535 l0 -115 25 0 c24 0 25 2 25 74 0 69 2 76 26 95 61 48 94
                                16 94 -92 0 -75 1 -77 25 -77 24 0 25 2 25 70 0 62 3 74 25 95 29 30 58 32 85
                                5 16 -16 20 -33 20 -95 0 -68 2 -75 20 -75 19 0 20 7 20 95 0 82 -3 98 -20
                                115 -29 29 -94 27 -125 -5 l-25 -24 -25 24 c-31 32 -96 34 -125 5 l-20 -20 0
                                20 c0 15 -7 20 -25 20 l-25 0 0 -115z"/>
                                <path d="M3180 1490 l0 -160 25 0 c24 0 25 3 25 62 0 57 1 60 18 46 43 -37
                                121 -26 156 23 19 27 21 97 4 134 -23 50 -109 72 -156 39 -20 -14 -22 -14 -22
                                0 0 10 -9 16 -25 16 l-25 0 0 -160z m171 101 c54 -43 6 -152 -60 -136 -85 20
                                -79 155 8 155 16 0 39 -8 52 -19z"/>
                                <path d="M3495 1638 c-11 -6 -21 -12 -23 -13 -1 -1 0 -9 4 -18 4 -13 10 -14
                                24 -7 26 14 84 12 98 -2 18 -18 15 -49 -3 -42 -26 10 -106 -7 -126 -27 -24
                                -24 -24 -60 -1 -90 15 -17 29 -22 65 -22 25 0 53 5 61 13 11 8 16 9 16 1 0 -6
                                11 -11 25 -11 25 0 25 1 25 90 0 83 -2 93 -25 115 -19 20 -34 25 -72 25 -26 0
                                -57 -6 -68 -12z m115 -137 c0 -24 -36 -51 -67 -51 -33 0 -55 27 -43 51 8 15
                                22 19 60 19 43 0 50 -3 50 -19z"/>
                                <path d="M3720 1535 l0 -115 25 0 c24 0 25 2 25 74 0 69 2 76 26 95 33 26 58
                                27 84 1 16 -16 20 -33 20 -95 0 -73 1 -75 25 -75 24 0 25 2 25 68 0 82 -15
                                138 -40 152 -38 20 -112 7 -132 -24 -5 -6 -8 -1 -8 12 0 17 -6 22 -25 22 l-25
                                0 0 -115z"/>
                                <path d="M4001 1553 c23 -54 45 -106 51 -116 15 -28 -17 -70 -48 -64 -30 5
                                -54 -27 -28 -37 26 -10 69 -7 86 7 9 6 43 79 76 160 59 148 59 148 34 145 -22
                                -3 -29 -15 -58 -93 -25 -70 -34 -86 -40 -70 -54 146 -62 160 -88 163 l-26 3
                                41 -98z"/>
                                <path d="M2803 1160 c0 -36 2 -50 4 -32 2 17 2 47 0 65 -2 17 -4 3 -4 -33z"/>
                                <path d="M3223 1160 c0 -36 2 -50 4 -32 2 17 2 47 0 65 -2 17 -4 3 -4 -33z"/>
                                <path d="M1303 1155 c0 -33 2 -46 4 -28 4 27 9 32 36 36 l32 4 -32 1 c-24 2
                                -33 7 -36 25 -2 12 -4 -5 -4 -38z"/>
                                <path d="M1409 1165 c6 -11 20 -31 32 -45 l21 -25 -15 26 c-14 23 -14 28 -1
                                43 13 14 12 15 -3 1 -14 -12 -18 -12 -30 3 -13 15 -13 15 -4 -3z"/>
                                <path d="M1491 1123 c1 -62 6 -56 11 15 2 23 0 42 -4 42 -5 0 -7 -26 -7 -57z"/>
                                <path d="M1548 1153 c5 -21 7 -23 10 -9 2 10 0 22 -6 28 -6 6 -7 0 -4 -19z"/>
                                <path d="M1636 1167 c3 -10 9 -15 12 -12 3 3 0 11 -7 18 -10 9 -11 8 -5 -6z"/>
                                <path d="M1683 1140 c0 -25 2 -35 4 -22 2 12 2 32 0 45 -2 12 -4 2 -4 -23z"/>
                                <path d="M1880 1140 c0 -22 2 -40 4 -40 2 0 6 18 8 40 2 22 0 40 -4 40 -5 0
                                -8 -18 -8 -40z"/>
                                <path d="M2323 1140 c0 -25 2 -35 4 -22 2 12 2 32 0 45 -2 12 -4 2 -4 -23z"/>
                                <path d="M2365 1169 c-4 -6 -5 -12 -2 -15 2 -3 7 2 10 11 7 17 1 20 -8 4z"/>
                                <path d="M2416 1167 c3 -10 9 -15 12 -12 3 3 0 11 -7 18 -10 9 -11 8 -5 -6z"/>
                                <path d="M2511 1164 c0 -11 3 -14 6 -6 3 7 2 16 -1 19 -3 4 -6 -2 -5 -13z"/>
                                <path d="M2733 1140 c0 -25 2 -35 4 -22 2 12 2 32 0 45 -2 12 -4 2 -4 -23z"/>
                                <path d="M2991 1164 c0 -11 3 -14 6 -6 3 7 2 16 -1 19 -3 4 -6 -2 -5 -13z"/>
                                <path d="M3035 1170 c3 -5 8 -10 11 -10 2 0 4 5 4 10 0 6 -5 10 -11 10 -5 0
                                -7 -4 -4 -10z"/>
                                <path d="M3123 1140 c0 -25 2 -35 4 -22 2 12 2 32 0 45 -2 12 -4 2 -4 -23z"/>
                                <path d="M3163 1145 c0 -22 2 -30 4 -17 2 12 2 30 0 40 -3 9 -5 -1 -4 -23z"/>
                                <path d="M3280 1137 c4 -41 5 -41 8 -8 2 18 0 37 -5 42 -5 5 -6 -11 -3 -34z"/>
                                <path d="M3377 1173 c-9 -9 -9 -51 1 -56 4 -3 7 10 7 29 0 19 0 34 -1 34 0 0
                                -4 -3 -7 -7z"/>
                                <path d="M3426 1167 c3 -10 9 -15 12 -12 3 3 0 11 -7 18 -10 9 -11 8 -5 -6z"/>
                                <path d="M3516 1144 c1 -47 14 -57 14 -11 0 20 -3 38 -7 40 -5 3 -8 -10 -7
                                -29z"/>
                                <path d="M1580 1141 c0 -11 4 -22 9 -25 4 -3 6 6 3 19 -5 30 -12 33 -12 6z"/>
                                <path d="M1781 1144 c0 -11 3 -14 6 -6 3 7 2 16 -1 19 -3 4 -6 -2 -5 -13z"/>
                                <path d="M1971 1144 c0 -11 3 -14 6 -6 3 7 2 16 -1 19 -3 4 -6 -2 -5 -13z"/>
                                <path d="M2051 1144 c0 -11 3 -14 6 -6 3 7 2 16 -1 19 -3 4 -6 -2 -5 -13z"/>
                                <path d="M2631 1144 c0 -11 3 -14 6 -6 3 7 2 16 -1 19 -3 4 -6 -2 -5 -13z"/>
                                <path d="M3565 1150 c3 -4 14 -10 25 -13 11 -3 18 -2 15 3 -3 4 -14 10 -25 13
                                -11 3 -18 2 -15 -3z"/>
                                <path d="M3465 1139 c-4 -6 -5 -12 -2 -15 2 -3 7 2 10 11 7 17 1 20 -8 4z"/>
                                <path d="M2360 1131 c0 -6 4 -13 10 -16 6 -3 7 1 4 9 -7 18 -14 21 -14 7z"/>
                                <path d="M2586 1125 c-9 -26 -7 -32 5 -12 6 10 9 21 6 23 -2 3 -7 -2 -11 -11z"/>
                                <path d="M3000 1125 c0 -8 4 -15 10 -15 5 0 7 7 4 15 -4 8 -8 15 -10 15 -2 0
                                -4 -7 -4 -15z"/>
                                <path d="M3066 1125 c-9 -26 -7 -32 5 -12 6 10 9 21 6 23 -2 3 -7 -2 -11 -11z"/>
                                <path d="M1399 1113 c-13 -16 -12 -17 4 -4 9 7 17 15 17 17 0 8 -8 3 -21 -13z"/>
                                <path d="M2520 1120 c0 -5 5 -10 11 -10 5 0 7 5 4 10 -3 6 -8 10 -11 10 -2 0
                                -4 -4 -4 -10z"/>
                                <path d="M3652 1114 c9 -9 21 -15 27 -13 6 2 -2 10 -17 17 -25 11 -25 11 -10
                                -4z"/>
                                <path d="M1625 1110 c-16 -7 -17 -9 -3 -9 9 -1 20 4 23 9 7 11 7 11 -20 0z"/>
                                <path d="M2217 1109 c7 -7 15 -10 18 -7 3 3 -2 9 -12 12 -14 6 -15 5 -6 -5z"/>
                                <path d="M3585 1110 c-16 -7 -17 -9 -3 -9 9 -1 20 4 23 9 7 11 7 11 -20 0z"/>
                                <path d="M1818 1103 c7 -3 16 -2 19 1 4 3 -2 6 -13 5 -11 0 -14 -3 -6 -6z"/>
                                <path d="M2088 1103 c7 -3 16 -2 19 1 4 3 -2 6 -13 5 -11 0 -14 -3 -6 -6z"/>
                                </g>
                                </svg>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 30px; background-color: #ffffff; border-radius: 4px; box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);">
                            <h1 style="color: #333333; font-size: 24px; margin-bottom: 20px;">Forgot Password</h1>
                            <p style="color: #666666; font-size: 16px; margin-bottom: 30px;">Hi,</p>
                            <p style="color: #666666; font-size: 16px; margin-bottom: 30px;">We received a request to reset your password for Travel App. If you did not request this, please ignore this email.</p>
                            <p style="color: #666666; font-size: 16px; margin-bottom: 30px;">To reset your password, please click the button below:</p>
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td align="center">
                                        <a href="{{ $resetUrl }}" style="background-color: #0033cc; border-radius: 4px; color: #ffffff; display: inline-block; font-size: 16px; font-weight: 600; padding: 10px 20px; text-align: center; text-decoration: none;">Reset Password</a>
                                    </td>
                                </tr>
                            </table>
                            <p style="color: #666666; font-size: 16px; margin-top: 30px;">If you're having trouble with the button above, copy and paste the following link into your web browser:</p>
                            <p style="color: #666666; font-size: 16px;"><a href="{{ $resetUrl }}" style="color: #0033cc; text-decoration: underline;">{{ $resetUrl }}</a></p>
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