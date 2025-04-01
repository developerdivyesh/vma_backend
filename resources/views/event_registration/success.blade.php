<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Successful</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5 text-center">
    <h2>Registration Successful</h2>
    <p>Thank you, {{ $registration->name }}! Your registration is complete.</p>
    <h4>Your QR Code:</h4>
    <img src="{{ asset('qrcodes/' . $registration->qr_code_path) }}" alt="QR Code" class="img-fluid">
    <p>Please save this QR code. You will need it at the entrance.</p>
    <a href="{{ route('event_registration.form') }}" class="btn btn-success">Register Another</a>
</div>
</body>
</html>
