<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedido Criado - Marktplace </title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }
        .container {
            min-width: 600px;
            max-width: 600px;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            padding: 20px;
            background-color: #FF4500;
            color: white;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 20px;
            background-color: #ffffff;
        }
        .divider {
            height: 1px;
            background-color: #e0e0e0;
            margin: 15px 0;
        }
        .title-center {
            text-align: center;
            margin: 15px 0;
            color: #333333;
        }
        .order-items {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .order-items th {
            background-color: #f9f9f9;
            padding: 10px;
            text-align: left;
        }
        .order-items td {
            padding: 10px;
            border-bottom: 1px solid #f0f0f0;
        }
        .order-total {
            text-align: right;
            font-weight: bold;
            margin-top: 15px;
            font-size: 18px;
        }
        .footer {
            text-align: center;
            padding: 15px;
            font-size: 12px;
            color: #777777;
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Marketplace</h1>
        </div>

        <div class="content">
            <div class="divider"></div>

            <div class="title-center">
                <h2>Obrigado por sua compra!</h2>
                <p>Seu pedido #{{ $order->id }} foi recebido com sucesso.</p>
            </div>

            <div class="divider"></div>

            <h3>Detalhes do Pedido:</h3>
            <table class="order-items">
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Quantidade</th>
                        <th>Preço Unitário</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->orderItems as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>R$ {{ number_format($item->unit_price, 2, ',', '.') }}</td>
                        <td>R$ {{ number_format($item->quantity * $item->unit_price, 2, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="order-total">
                Total do Pedido: R$ {{ number_format($order->total_amount, 2, ',', '.') }}
            </div>

            <p>Você receberá um e-mail quando seu pedido for enviado.</a>.</p>
        </div>

        <div class="footer">
            <p>Atenciosamente,<br>Equipe Marketplace</p>
            <p>© {{ date('Y') }} Marketplace. Todos os direitos reservados.</p>
        </div>
    </div>
</body>
</html>
