<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reset Your Password</title>
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
        .message {
            font-size: 16px;
            color: #555;
            margin: 10px 0;
        }
        .button {
            display: inline-block;
            padding: 12px 20px;
            font-size: 16px;
            color: #ffffff;
            background-color: #7E171B;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
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
        <div class="header">Reset Your Password</div>

        <!-- Message -->
        <p class="message">Hello,</p>
        <p class="message">You recently requested to reset your password for your CRM account.</p>
        <p class="message">Click the button below to reset your password:</p>

        <!-- Reset Password Button -->
        <a href="{{ $resetUrl }}" class="button">Reset Password</a>

        <p class="message">If you did not request a password reset, please ignore this email.</p>

        <!-- Footer -->
        <div class="footer">
            &copy; {{ date('Y') }} Stockie. All rights reserved.
            <br>Need help? <a href="mailto:support@yourwebsite.com">Contact Support</a>
        </div>
    </div>

</body>
</html>
