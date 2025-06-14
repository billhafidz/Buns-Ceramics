<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Peringatan Langganan</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #262626;
            color: #ffffff;
            padding: 20px;
            margin: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background: #262626;
            border-radius: 20px;
            overflow: hidden;
            border: 1px solid #444444;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.6);
        }
        .header {
            background-color: #262626;
            color: #ffffff;
            text-align: center;
            padding: 40px 30px;
            border-bottom: 1px solid #444444;
        }
        .header h1 {
            font-size: 26px;
            margin-bottom: 10px;
        }
        .header p {
            font-size: 16px;
            margin: 0;
        }
        .content {
            padding: 40px 30px;
            color: #dddddd;
        }
        .content p {
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 20px;
        }
        .highlight {
            background-color: #333333;
            color: #ffffff;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            font-weight: bold;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
            margin-bottom: 20px;
        }
        .footer {
            background-color: #262626;
            color: #aaaaaa;
            text-align: center;
            font-size: 14px;
            padding: 30px;
            border-top: 1px solid #444444;
        }
        .footer p {
            color: #aaa;
            font-size: 14px;
            line-height: 1.5;
            margin-bottom: 10px;
        }
        .footer .company {
            font-weight: 600;
            color: #ffffff;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>📢 Peringatan Langganan</h1>
            <p>Langganan Anda Akan Segera Berakhir</p>
        </div>

        <div class="content">
            <p>Halo {{ $member->nama_member }},</p>
            <p>
                Kami mendeteksi bahwa langganan Anda akan berakhir dalam waktu kurang dari 5 hari.
                Untuk menghindari gangguan layanan, segera lakukan perpanjangan.
            </p>
            <div class="highlight">
                Pastikan Anda memperpanjang sebelum masa aktif berakhir!
            </div>
            <p>
                Jika Anda tidak merasa melakukan langganan, abaikan email ini.
                Untuk bantuan lebih lanjut, silakan hubungi tim support kami.
            </p>
        </div>

        <div class="footer">
            <p class="company">Tim Keamanan - Aplikasi Anda</p>
            <p>Email ini dikirim otomatis, mohon tidak membalas email ini.</p>
            <p>&copy; Copyright © 2025 Buns ceramics. All Rights Reserved</p>
        </div>
    </div>
</body>
</html>
