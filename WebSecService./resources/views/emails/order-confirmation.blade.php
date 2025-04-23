<!DOCTYPE html>
<html>
<head>
    <title>Order Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
        }
        .header {
            background-color: #4a6cf7;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .content {
            padding: 20px;
        }
        .footer {
            background-color: #f4f4f4;
            padding: 10px 20px;
            font-size: 12px;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .total {
            font-weight: bold;
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Order Confirmation</h1>
    </div>
    
    <div class="content">
        <p>Hello {{ $order->user->name }},</p>
        
        <p>Thank you for your purchase! Your order has been confirmed and processed.</p>
        
        <h2>Order #{{ $order->id }}</h2>
        <p>Date: {{ $order->created_at->format('F j, Y, g:i a') }}</p>
        
        <h3>Order Details:</h3>
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>${{ number_format($item->price, 2) }}</td>
                    <td>${{ number_format($item->subtotal, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="total">Total:</td>
                    <td>${{ number_format($order->total_amount, 2) }}</td>
                </tr>
            </tfoot>
        </table>
        
        <p>If you have any questions about your order, please contact our customer support team.</p>
        
        <p>Thank you for shopping with us!</p>
    </div>
    
    <div class="footer">
        <p>&copy; {{ date('Y') }} WebSec Service. All rights reserved.</p>
    </div>
</body>
</html>
