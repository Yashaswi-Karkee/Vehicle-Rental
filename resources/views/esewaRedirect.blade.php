<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Redirecting...</title>
</head>

<body>
    <form action="http://rc-epay.esewa.com.np/api/epay/main/v2/form" method="POST">
        <input type="text" id="amount" name="amount" value="{{ $price }}" required>
        <input type="text" id="tax_amount" name="tax_amount" value="0" required>
        <input type="text" id="total_amount" name="total_amount" value="{{ $price }}" required>
        <input type="text" id="transaction_uuid" name="transaction_uuid" value="{{ $ord_id }}"required>
        <input type="text" id="product_code" name="product_code" value="EPAYTEST" required>
        <input type="text" id="product_service_charge" name="product_service_charge" value="0" required>
        <input type="text" id="product_delivery_charge" name="product_delivery_charge" value="0" required>
        <input type="text" id="success_url" name="success_url" value="{{ url('/success') }}" required>
        <input type="text" id="failure_url" name="failure_url" value="{{ url('/fail') }}" required>
        <input type="text" id="signed_field_names" name="signed_field_names"
            value="total_amount={{ $price }},transaction_uuid={{ $ord_id }},product_code=EPAYTEST"
            required>
        <input type="text" id="signature" name="signature" value="{{ $s }}">
        <input value="Continue" type="submit">
    </form>
</body>

</html>
