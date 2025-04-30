<!DOCTYPE html>
<html>
<head>
    <title>Pedidos da Semana</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>Pedidos Abertos - Semana {{ now()->startOfWeek()->format('d/m/Y') }} a {{ now()->endOfWeek()->format('d/m/Y') }}</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Data</th>
                <th>Status</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->user->email }}</td>
                <td>{{ $order->order_date }}</td>
                <td>{{ $order->status }}</td>
                <td>R$ {{ number_format($order->total_amount, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
