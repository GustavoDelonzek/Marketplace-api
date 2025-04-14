<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Atualização do Seu Pedido</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.5;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #FF4500;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            padding: 20px;
            background-color: #f8f9fa;
            border: 1px solid #e1e1e1;
            border-top: none;
            border-radius: 0 0 5px 5px;
        }
        .order-info {
            background-color: white;
            padding: 15px;
            margin: 15px 0;
            border-radius: 5px;
            border-left: 4px solid #FF4500;
        }
        .status {
            font-weight: bold;
            color: #FF4500;

        }
        .footer {
            font-size: 12px;
            color: #7f8c8d;
            text-align: center;
            margin-top: 20px;
        }

        .capitalize {
            text-transform: capitalize;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1 style="margin:0;">Order Updated</h1>
    </div>

    <div class="content">
        <p class="capitalize">Hello {{ $user->name }},</p>

        <div class="order-info">
            <p>The status of your order was updated to:</p>
            <p class="status capitalize">{{ $order->status }}</p>
        </div>

        <p>You can track your order anytime on our platform.</p>

        <div class="footer">
            <p>Marketplace Team</p>
        </div>
    </div>
</body>
</html>
