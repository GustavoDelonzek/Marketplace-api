<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Welcome to our Marketplace</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.5;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .welcome-header {
            background-color: #FF4500; /* Cor laranja-vermelho */
            color: white;
            padding: 15px;
            text-align: center;
            border-radius: 5px 5px 0 0;
            margin-bottom: 0;
        }
        .message {
            background: white;
            padding: 20px;
            border-radius: 0 0 5px 5px;
            border: 1px solid #e1e1e1;
            border-top: none;
        }
        .footer {
            font-size: 12px;
            color: #7f8c8d;
            background-color: #f1f1f1;
            text-align: center;
            padding: 5px;
        }
    </style>
</head>
<body>
    <div class="welcome-header">
        <h2 style="margin:0;">Welcome to our Marketplace</h2>
    </div>

    <div class="message">
        <p>Hello {{ $user->name }},</p>
        <p>Thank you for registering with us. </p>
        <p>We are excited to have you on board.</p>
    </div>

    <div class="footer">
        <p>Marketplace Team</p>
    </div>
</body>
</html>
