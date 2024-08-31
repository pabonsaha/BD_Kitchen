<!DOCTYPE html>
<html>
<head>
    <title>Invoice for Order {{ $order['code'] }}</title>
</head>
<body>
<p>Dear {{ $order['user']->name }},</p>
<p>{{$messageContent}}</p>
<p>Order Code: {{ $order['code'] }}</p>
<p>Total: {{ getPriceFormat($order['total']) }}</p>
<p>Thank you for shopping with us!</p>
</body>
</html>
