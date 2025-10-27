<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Password Reset | Patani Trinidad</title>
    <style>
        body {
            font-family: 'Poppins', Arial, sans-serif;
            background-color: #f8f9fa;
            color: #333;
            padding: 0;
            margin: 0;
        }
        .email-container {
            max-width: 480px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .header {
            background-color: #dc3545;
            color: #fff;
            text-align: center;
            padding: 20px;
            font-size: 22px;
            font-weight: bold;
        }
        .content {
            padding: 30px 25px;
            line-height: 1.6;
        }
        .content p {
            margin-bottom: 15px;
        }
        .btn {
            display: inline-block;
            background-color: #dc3545;
            color: #fff;
            text-decoration: none;
            padding: 12px 20px;
            border-radius: 6px;
            margin: 20px 0;
            font-weight: 500;
        }
        .btn:hover {
            background-color: #c82333;
        }
        .footer {
            text-align: center;
            background-color: #f1f1f1;
            font-size: 13px;
            color: #555;
            padding: 15px;
        }
        .footer a {
            color: #dc3545;
            text-decoration: none;
        }
    </style>
</head>
    <body>
        <div class="container">
            <h1>Password Reset Request</h1>
            <p>Hello,</p>
            <p>You are receiving this email because we received a password reset request for your account.</p>
            <p>Click the button below to reset your password:</p>

            <a href="{{ $url }}" class="button">Reset Password</a>

            <p>If you did not request a password reset, no further action is required.</p>
            <p>— Patani Trinidad Team</p>
        </div>
    </body>
</html>
