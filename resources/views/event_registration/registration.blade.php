<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon-32x32.png') }}">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .form-container {
            max-width: 500px;
            margin: 40px auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
        .form-container h2 {
            font-weight: bold;
            text-align: center;
        }
        .form-container .logo {
            display: block;
            max-width: 120px;
            margin: 0 auto 20px;
        }
        .btn-submit {
            width: 100%;
            font-weight: bold;
        }
        .form-group {
            margin-bottom: 15px;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

    <div class="form-container">
        <!-- Logo -->
        <img src="{{ asset('images/logo.jpeg') }}" alt="Logo" class="logo">

        <h2>VMA & FTS, Pune <br><i>प्रस्तुत: मेगा इवेंट – शौर्य स्मृति</i></h2>

        <form id="registrationForm" action="{{ route('event_registration.submit') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required>
                @if ($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
            </div>

            <div class="form-group">
                <label for="mobile">Mobile Number</label>
                <input type="tel" id="mobile" name="mobile" class="form-control" pattern="\d{10}" value="{{ old('mobile') }}" required>
                @if ($errors->has('mobile'))
                    <span class="text-danger">{{ $errors->first('mobile') }}</span>
                @endif
            </div>

            <div class="form-group">
                <label for="source">Where did you hear about us?</label>
                <input type="text" id="source" name="source" class="form-control" value="{{ old('source') }}" required>
                @if ($errors->has('source'))
                    <span class="text-danger">{{ $errors->first('source') }}</span>
                @endif
            </div>

            <!-- Send OTP Button -->
            <button type="button" id="sendOtpBtn" class="btn btn-info btn-submit">{{ $errors->has('otp') ? 'Resend OTP' : 'Send OTP' }}</button>

            <!-- OTP Input Field -->
            <div class="form-group mt-3" id="otpField" style="{{ $errors->has('otp') ? 'display: block;' : 'display: none;' }}">
                <label for="otp">Enter OTP</label>
                <input type="text" id="otp" name="otp" class="form-control" pattern="\d{6}" value="{{ old('otp') }}">
                @if ($errors->has('otp'))
                    <span class="text-danger">{{ $errors->first('otp') }}</span>
                @endif
            </div>

            <button type="submit" class="btn btn-warning btn-submit" id="registerBtn" disabled>Register</button>
        </form>
    </div>

    <script>
        $(document).ready(function () {
            $('#sendOtpBtn').click(function () {
                const mobile = $('#mobile').val();
                if (!mobile.match(/^\d{10}$/)) {
                    alert('Please enter a valid 10-digit mobile number.');
                    return;
                }

                // Send OTP via AJAX
                $.ajax({
                    url: "{{ route('otp.send') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        mobile: mobile
                    },
                    success: function (response) {
                        alert(response.message);
                        if (response.success) {
                            $('#otpField').show();
                            $('#registerBtn').prop('disabled', false);
                            $('#sendOtpBtn').text('Resend OTP'); // Change button label to "Resend OTP"
                        }
                    },
                    error: function () {
                        alert('Failed to send OTP. Please try again.');
                    }
                });
            });
        });
    </script>

</body>
</html>