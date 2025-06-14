<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Kode OTP</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #262626;
            min-height: 100vh;
            padding: 20px;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background: #262626;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            border: 1px solid #444;
        }

        .header {
            background: #262626;
            padding: 40px 30px;
            text-align: center;
            color: white;
            border-bottom: 1px solid #444;
        }

        .header h1 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .header p {
            font-size: 16px;
            color: #ccc;
        }

        .content {
            padding: 40px 30px;
        }

        .greeting {
            font-size: 18px;
            color: #fff;
            margin-bottom: 20px;
            line-height: 1.5;
        }

        .message {
            font-size: 16px;
            color: #ccc;
            line-height: 1.6;
            margin-bottom: 30px;
        }

        .otp-container {
            background: #333;
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            margin: 30px 0;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
        }

        .otp-label {
            color: #ccc;
            font-size: 14px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 10px;
        }

        .otp-code {
            font-size: 36px;
            font-weight: 700;
            color: white;
            letter-spacing: 8px;
            font-family: 'Courier New', monospace;
            background: rgba(255, 255, 255, 0.1);
            padding: 15px 20px;
            border-radius: 10px;
            display: inline-block;
            margin: 10px 0;
            border: 2px solid rgba(255, 255, 255, 0.2);
        }

        .otp-validity {
            color: rgba(255, 255, 255, 0.8);
            font-size: 14px;
            margin-top: 10px;
        }

        .security-notice {
            background: #3a3a3a;
            border: 1px solid #555;
            border-radius: 10px;
            padding: 20px;
            margin: 25px 0;
        }

        .security-notice h3 {
            color: #ffca28;
            font-size: 16px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }

        .security-notice p {
            color: #e0c97a;
            font-size: 14px;
            line-height: 1.5;
        }

        .icon {
            width: 20px;
            height: 20px;
            margin-right: 8px;
            fill: #ffca28;
        }

        .footer {
            background: #1e1e1e;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #444;
        }

        .footer p {
            color: #aaa;
            font-size: 14px;
            line-height: 1.5;
            margin-bottom: 10px;
        }

        .footer .company {
            font-weight: 600;
            color: #fff;
        }

        .social-links {
            margin-top: 20px;
        }

        .social-links a {
            display: inline-block;
            margin: 0 10px;
            padding: 10px;
            background: #444;
            color: white;
            text-decoration: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            line-height: 20px;
            transition: transform 0.3s ease, background 0.3s ease;
        }

        .social-links a:hover {
            transform: translateY(-2px);
            background: #555;
        }

        @media (max-width: 600px) {
            body {
                padding: 10px;
            }

            .header {
                padding: 30px 20px;
            }

            .header h1 {
                font-size: 24px;
            }

            .content {
                padding: 30px 20px;
            }

            .otp-code {
                font-size: 28px;
                letter-spacing: 4px;
            }

            .footer {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>🔐 Reset Password</h1>
            <p>Verifikasi Identitas Anda</p>
        </div>

        <div class="content">
            <div class="greeting">Halo,</div>
            <div class="message">
                Kami menerima permintaan untuk mereset password akun Anda. Untuk melanjutkan proses reset password, silakan gunakan kode OTP berikut:
            </div>

            <div class="otp-container">
                <div class="otp-label">Kode OTP Anda</div>
                <div class="otp-code">{{ $otp }}</div>
            </div>

            <div class="security-notice">
                <h3>
                    <svg class="icon" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    Penting untuk Keamanan
                </h3>
                <p>
                    • Jangan bagikan kode OTP ini kepada siapa pun<br>
                    • Jika Anda tidak meminta reset password, abaikan email ini<br>
                </p>
            </div>

            <div class="message">
                Jika Anda mengalami kesulitan atau tidak meminta reset password, silakan hubungi tim support kami segera.
            </div>
        </div>

        <div class="footer">
            <p class="company">Tim Keamanan - Aplikasi Anda</p>
            <p>Email ini dikirim secara otomatis, mohon tidak membalas email ini.</p>
            <p>&copy; Copyright © 2025 Buns ceramics. All Rights Reserved</p>

            <div class="social-links">
                {{-- <a href="#" title="Facebook">f</a>
                <a href="#" title="Twitter">t</a> --}}
                <a href="https://www.instagram.com/buns.ceramics?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==" title="Instagram">i</a>
            </div>
            
        </div>
    </div>
</body>
</html>
