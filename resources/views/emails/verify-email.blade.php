<!DOCTYPE html>

<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="x-apple-disable-message-reformatting">
    <meta name="color-scheme" content="light">
    <meta name="supported-color-schemes" content="light">
    <title>Verifikasi Email</title>

</head>

<body
    style="
    margin: 0;
    padding: 0;
    width: 100%;
    background-color: #f8fafc;
    font-family: Arial, Helvetica, sans-serif;
    color: #0f172a;
">

    <!-- Preheader -->
    <div style="
    display: none;
    max-height: 0;
    overflow: hidden;
    opacity: 0;
    color: transparent;
">
        Verifikasi alamat email Anda untuk melanjutkan menggunakan {{ config('app.name') }}.
    </div>

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0"
        style="
        width: 100%;
        background-color: #f8fafc;
        margin: 0;
        padding: 0;
    ">
        <tr>
            <td align="center" style="padding: 40px 16px;">

                <!-- Main Card -->
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0"
                    style="
                    width: 100%;
                    max-width: 520px;
                    background-color: #ffffff;
                    border: 1px solid #f1f5f9;
                    border-radius: 16px;
                    box-shadow: 0 10px 30px rgba(15, 23, 42, 0.06);
                ">

                    <!-- Logo / Brand -->
                    <tr>
                        <td align="center" style="padding: 32px 32px 10px;">

                            <div
                                style="
                            font-size: 24px;
                            line-height: 32px;
                            font-weight: 800;
                            letter-spacing: -0.5px;
                            color: #232f72;
                        ">
                                {{ config('app.name') }}
                            </div>

                        </td>
                    </tr>

                    <!-- Icon -->
                    <tr>
                        <td align="center" style="padding: 20px 32px 0;">

                            <table role="presentation" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td align="center" valign="middle" width="64" height="64"
                                        style="
                                        width: 64px;
                                        height: 64px;
                                        background-color: #eef2ff;
                                        border-radius: 16px;
                                        border: 8px solid #f5f7ff;
                                    ">

                                        <!-- Email Icon -->
                                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M3 8L10.89 13.26C11.56 13.71 12.44 13.71 13.11 13.26L21 8"
                                                stroke="#232F72" stroke-width="1.8" stroke-linecap="round"
                                                stroke-linejoin="round" />

                                            <path
                                                d="M5 19H19C20.1 19 21 18.1 21 17V7C21 5.9 20.1 5 19 5H5C3.9 5 3 5.9 3 7V17C3 18.1 3.9 19 5 19Z"
                                                stroke="#232F72" stroke-width="1.8" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>

                                    </td>
                                </tr>
                            </table>

                        </td>
                    </tr>

                    <!-- Header -->
                    <tr>
                        <td align="center" style="padding: 24px 40px 0;">

                            <h1
                                style="
                            margin: 0;
                            font-size: 26px;
                            line-height: 34px;
                            font-weight: 700;
                            letter-spacing: -0.5px;
                            color: #0f172a;
                        ">
                                Verifikasi Email Anda
                            </h1>

                        </td>
                    </tr>

                    <!-- Greeting -->
                    <tr>
                        <td style="padding: 24px 40px 0;">

                            <p
                                style="
                            margin: 0;
                            font-size: 15px;
                            line-height: 24px;
                            color: #475569;
                        ">
                                Halo,
                                <strong style="color: #0f172a;">
                                    {{ $user->name }}
                                </strong>
                                👋
                            </p>

                        </td>
                    </tr>

                    <!-- Description -->
                    <tr>
                        <td style="padding: 10px 40px 0;">

                            <p
                                style="
                            margin: 0;
                            font-size: 14px;
                            line-height: 24px;
                            color: #64748b;
                        ">
                                Terima kasih sudah mendaftar di
                                <strong style="color: #232f72;">
                                    {{ config('app.name') }}
                                </strong>.
                                Untuk melanjutkan, silakan verifikasi alamat email
                                Anda dengan menekan tombol di bawah.
                            </p>

                        </td>
                    </tr>

                    <!-- Button -->
                    <tr>
                        <td align="center" style="padding: 30px 40px;">

                            <table role="presentation" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td align="center"
                                        style="
                                        border-radius: 10px;
                                        background-color: #232f72;
                                    ">

                                        <a href="{{ $verificationUrl }}" target="_blank"
                                            style="
                                            display: inline-block;
                                            padding: 14px 28px;
                                            border-radius: 10px;
                                            background-color: #232f72;
                                            color: #ffffff;
                                            font-size: 14px;
                                            line-height: 20px;
                                            font-weight: 700;
                                            text-decoration: none;
                                        ">
                                            Verifikasi Email
                                        </a>

                                    </td>
                                </tr>
                            </table>

                        </td>
                    </tr>

                    <!-- Information Box -->
                    <tr>
                        <td style="padding: 0 40px 24px;">

                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0"
                                style="
                                width: 100%;
                                background-color: #eef2ff;
                                border: 1px solid #e0e7ff;
                                border-radius: 12px;
                            ">
                                <tr>
                                    <td style="padding: 16px;">

                                        <table role="presentation" cellpadding="0" cellspacing="0" border="0">
                                            <tr>

                                                <td valign="top" style="padding-right: 10px;">
                                                    <span
                                                        style="
                                                    display: inline-block;
                                                    font-size: 16px;
                                                    line-height: 20px;
                                                    color: #232f72;
                                                ">
                                                        ✉
                                                    </span>
                                                </td>

                                                <td valign="top"
                                                    style="
                                                    font-size: 12px;
                                                    line-height: 19px;
                                                    color: #475569;
                                                ">
                                                    Link verifikasi ini digunakan untuk
                                                    memastikan bahwa alamat email ini
                                                    benar-benar milik Anda.
                                                </td>

                                            </tr>
                                        </table>

                                    </td>
                                </tr>
                            </table>

                        </td>
                    </tr>

                    <!-- Fallback URL -->
                    <tr>
                        <td style="padding: 0 40px 10px;">

                            <p
                                style="
                            margin: 0;
                            font-size: 12px;
                            line-height: 19px;
                            color: #94a3b8;
                        ">
                                Jika tombol di atas tidak dapat digunakan,
                                salin dan buka link berikut di browser Anda:
                            </p>

                        </td>
                    </tr>

                    <tr>
                        <td style="padding: 0 40px 24px;">

                            <div
                                style="
                            padding: 12px;
                            background-color: #f8fafc;
                            border: 1px solid #e2e8f0;
                            border-radius: 8px;
                            word-break: break-all;
                            font-size: 11px;
                            line-height: 17px;
                        ">
                                <a href="{{ $verificationUrl }}" target="_blank"
                                    style="
                                    color: #475569;
                                    text-decoration: none;
                                ">
                                    {{ $verificationUrl }}
                                </a>
                            </div>

                        </td>
                    </tr>

                    <!-- Security Notice -->
                    <tr>
                        <td style="padding: 0 40px 30px;">

                            <p
                                style="
                            margin: 0;
                            font-size: 12px;
                            line-height: 19px;
                            color: #94a3b8;
                            text-align: center;
                        ">
                                Jika Anda tidak membuat akun di
                                {{ config('app.name') }},
                                Anda dapat mengabaikan email ini.
                            </p>

                        </td>
                    </tr>

                    <!-- Divider -->
                    <tr>
                        <td style="padding: 0 40px;">

                            <div
                                style="
                            height: 1px;
                            background-color: #f1f5f9;
                            line-height: 1px;
                            font-size: 1px;
                        ">
                                &nbsp;
                            </div>

                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td align="center" style="padding: 24px 32px 30px;">

                            <p
                                style="
                            margin: 0;
                            font-size: 13px;
                            line-height: 20px;
                            font-weight: 600;
                            color: #475569;
                        ">
                                Salam,
                            </p>

                            <p
                                style="
                            margin: 3px 0 0;
                            font-size: 13px;
                            line-height: 20px;
                            font-weight: 700;
                            color: #232f72;
                        ">
                                {{ config('app.name') }}
                            </p>

                            <p
                                style="
                            margin: 12px 0 0;
                            font-size: 11px;
                            line-height: 18px;
                            color: #94a3b8;
                        ">
                                © {{ date('Y') }} {{ config('app.name') }}.
                                Semua hak dilindungi.
                            </p>

                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>

</html>
