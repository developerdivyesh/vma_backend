<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your QR Code</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon-32x32.png') }}">
</head>
<body>
<div class="container mt-5 text-center">
    <h2>Your QR Code</h2>
    <p>Thank you, {{ $registration->name }} Ji! Here is your QR code for the event.</p>
    <img src="{{ asset('qrcodes/' . $registration->qr_code_path) }}" alt="QR Code" class="img-fluid">
    <p>Please save this QR code. You will need it at the entrance.</p>

    <!-- Download QR Code -->
    <a href="{{ asset('qrcodes/' . $registration->qr_code_path) }}" download="qr_code_{{ $registration->id }}.png" class="btn btn-primary mt-3">Download QR Code</a>
</div>
</body>
</html>