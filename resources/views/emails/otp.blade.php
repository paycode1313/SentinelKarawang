<!DOCTYPE html>
<html>
<head>
    <title>Kode OTP Reset Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 0;
        }
        .header {
            background-color: #0056b3;
            padding: 20px;
            text-align: center;
        }
        .header h1 {
            color: white;
            margin: 0;
        }
        .content {
            padding: 30px;
            background-color: #f9f9f9;
        }
        .otp-container {
            text-align: center;
            margin: 30px 0;
        }
        .otp-code {
            display: inline-block;
            padding: 15px 30px;
            background-color: #e9f0ff;
            border-radius: 5px;
            font-size: 24px;
            font-weight: bold;
            letter-spacing: 3px;
            color: #0056b3;
        }
        .footer {
            background-color: #f0f0f0;
            padding: 15px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Sentinel Karawang</h1>
    </div>
    
    <div class="content">
        <h2>Reset Password</h2>
        <p>Anda telah meminta untuk mereset password akun Sentinel Karawang Anda.</p>
        <p>Gunakan kode OTP berikut untuk melanjutkan:</p>
        
        <div class="otp-container">
            <div class="otp-code">{{ $otp }}</div>
        </div>
        
        <p>Kode ini akan kadaluarsa dalam 10 menit. Jika Anda tidak meminta reset password, abaikan email ini.</p>
        
        <p>Terima kasih,<br>Tim Sentinel Karawang</p>
    </div>
    
    <div class="footer">
        <p>&copy; {{ date('Y') }} Sentinel Karawang. Hak cipta dilindungi.</p>
    </div>
</body>
</html>