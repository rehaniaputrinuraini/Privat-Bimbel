<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kode OTP Reset Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 500px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #4D0B87;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .header h2 {
            color: #4D0B87;
            margin: 0;
        }
        .otp-code {
            text-align: center;
            margin: 30px 0;
        }
        .otp-code span {
            font-size: 32px;
            font-weight: bold;
            color: #4D0B87;
            letter-spacing: 5px;
            background: #f0f0f0;
            padding: 15px 25px;
            border-radius: 10px;
            display: inline-block;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #999;
            border-top: 1px solid #eee;
            padding-top: 20px;
        }
        .warning {
            color: #e74c3c;
            font-size: 12px;
            text-align: center;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Bimbel Privat</h2>
        </div>
        
        <h3>Halo!</h3>
        
        <p>Anda telah melakukan permintaan <strong>reset password</strong> untuk akun Bimbel Privat Anda.</p>
        
        <p>Gunakan kode OTP di bawah ini untuk melanjutkan proses reset password:</p>
        
        <div class="otp-code">
            <span><?php echo e($otp); ?></span>
        </div>
        
        <p>Kode ini berlaku selama <strong>5 menit</strong> sejak email ini dikirim.</p>
        
        <p>Jika Anda tidak merasa melakukan permintaan ini, abaikan email ini. Tidak ada perubahan pada akun Anda.</p>
        
        <div class="warning">
            ⚠️ Jangan berikan kode OTP ini kepada siapapun demi keamanan akun Anda.
        </div>
        
        <div class="footer">
            © <?php echo e(date('Y')); ?> Bimbel Privat. All rights reserved.
        </div>
    </div>
</body>
</html> <?php /**PATH C:\xampp\htdocs\Privat-Bimbel\resources\views/emails/otp.blade.php ENDPATH**/ ?>