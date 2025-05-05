<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Print Order</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            padding: 20px;
            max-width: 400px;
            margin: auto;
            border: 1px solid #ccc;
        }

        h2, h4 {
            text-align: center;
            margin: 0;
        }

        .logo {
            text-align: center;
            margin-bottom: 10px;
        }

        .info, .items {
            margin-top: 20px;
            font-size: 15px;
        }

        .items table {
            width: 100%;
            border-collapse: collapse;
        }

        .items th, .items td {
            border-bottom: 1px dashed #ccc;
            padding: 8px 0;
            text-align: left;
        }

        .total {
            text-align: right;
            font-size: 18px;
            margin-top: 10px;
        }

        .print-btn {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            font-size: 16px;
        }

        @media print {
            .print-btn {
                display: none;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="logo">
        <h2>🍽️   مطعمي </h2>
        <h4>إيصال طلب</h4>
    </div>

    <div class="info" style="margin-top: 20px; padding: 15px; border: 1px solid #ddd; border-radius: 10px; background-color: #f9f9f9;">
        <h3 style="margin-bottom: 10px; text-align: center; color: #444;">معلومات الطلب</h3>

        <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
            <span>#{{ $order->id }}</span>
        </div>

        <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
            <span>{{ $order->customer_name }}</span>
            <span><strong>العميل</strong></span>

        </div>

        <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
            <span>{{ $order->customer_phone }}</span>
            <span><strong>الهاتف</strong></span>

        </div>

        <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
            <span>{{ $order->customer_address }}</span>
            <span><strong>العنوان</strong></span>

        </div>


        <div style="display: flex; justify-content: space-between;">
            <span>{{ $order->created_at->format('Y-m-d H:i') }}</span>
            <span><strong>التاريخ</strong></span>

        </div>
    </div>


    <div class="items">
        <table>
            <thead>
                <tr>
                    <th>المنتج</th>
                    <th>الكمية</th>
                    <th>السعر</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $order->product->name ?? '---' }}</td>
                    <td>{{ $order->quantity }}</td>
                    <td>{{ number_format($order->price, 2) }} EGP</td>
                </tr>
            </tbody>
        </table>

        <div class="total">
            <strong>الإجمالي: {{ number_format($order->price * $order->quantity, 2) }} EGP</strong>
        </div>
    </div>

    <button class="print-btn" onclick="window.print()">🖨️ طباعة</button>
</div>

</body>
</html>
