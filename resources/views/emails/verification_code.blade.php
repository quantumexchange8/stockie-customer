<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verification Code</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            background-color: #ffffff;
            margin: 20px auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .logo {
            max-width: 150px;
            margin-bottom: 20px;
        }
        .header {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }
        .code {
            font-size: 28px;
            font-weight: bold;
            color: #007BFF;
            margin: 20px 0;
            display: inline-block;
            padding: 10px 20px;
            border: 2px dashed #007BFF;
            border-radius: 5px;
        }
        .message {
            font-size: 16px;
            color: #555;
            margin: 10px 0;
        }
        .footer {
            font-size: 12px;
            color: #777;
            margin-top: 20px;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>
<body>

    <div class="container">
        <!-- Logo -->
        <img src="{{ asset('assets/image/stockie-logo.png') }}" alt="Company Logo" class="logo">


        <!-- Header -->
        <div class="header">Your Verification Code</div>

        <!-- Message -->
        <p class="message">Dear <strong>{{ $email }}</strong>,</p>
        <p class="message">Use the verification code below to complete your authentication process.</p>

        <!-- Verification Code -->
        <div class="code">{{ $verificationCode }}</div>

        <p class="message">This code will expire in <strong>5 minutes</strong>. Please do not share this code with anyone.</p>

        <!-- Footer -->
        <div class="footer">
            &copy; {{ date('Y') }} STOXPOS. All rights reserved.
            <br>Need help? <a href="mailto:support@stoxpos.com">Contact Support</a>
        </div>
    </div>

</body>
</html>
