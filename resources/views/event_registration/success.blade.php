<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Successful</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon-32x32.png') }}">
</head>
<body>
<div class="container mt-5 text-center">
    <h2>Registration Successful</h2>
    <p>Thank you, {{ $registration->name }} Ji! Your registration is complete.</p>
    <h4>Your QR Code:</h4>
    <img src="{{ asset('qrcodes/' . $registration->qr_code_path) }}" alt="QR Code" class="img-fluid">
    <p>Please save this QR code. You will need it at the entrance.</p>

    <p class="text-danger mt-3"><strong>Note:</strong> This is single person registration, for multiple people please do different registrations.</p>

    <!-- Download QR Code -->
    <a href="{{ asset('qrcodes/' . $registration->qr_code_path) }}" download="qr_code_{{ $registration->id }}.png" class="btn btn-primary mt-3">Download QR Code</a>

    <!-- Share on WhatsApp -->
    <a href="https://wa.me/?text={{ urlencode('Hi, Here is your QR Code for the event: ' .  route('show_qr', ['id' => $registration->id])) }}" 
       target="_blank" 
       class="btn btn-success mt-3">
        Share on WhatsApp
    </a>

    <a href="{{ route('event_registration.form') }}" class="btn btn-secondary mt-3">Register Another</a>
</div>
</body>
</html>
