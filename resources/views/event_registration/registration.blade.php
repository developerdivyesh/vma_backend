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
            max-width: 240px;
            margin: 0 auto 20px;
        }
        .btn-submit {
            width: 100%;
            font-weight: bold;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .logo {
            width: 120px;
            height: auto;
            margin: 0 10px;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

    <div class="form-container">
        <!-- Logo -->
        <div class="text-center d-flex justify-content-center align-items-center">
            <img src="{{ asset('images/logo.jpeg') }}" alt="Logo 1" class="logo mx-2" style="width: 120px;">
            <img src="{{ asset('images/fts-logo.jpg') }}" alt="Logo 2" class="logo mx-2" style="width: 239px;">
        </div>
        

        <h2>VMA & FTS, Pune <br><i>प्रस्तुत: मेगा इवेंट – शौर्य स्मृति</i></h2>

        <form id="registrationForm" action="{{ route('event_registration.submit') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="salutation">Salutation</label>
                <select id="salutation" name="salutation" class="form-control" required>
                    <option selected disabled value="">Select</option>
                    <option value="Mr." {{ old('salutation') == 'Mr.' ? 'selected' : '' }}>Mr.</option>
                    <option value="Ms." {{ old('salutation') == 'Ms.' ? 'selected' : '' }}>Ms.</option>
                    <option value="Mrs." {{ old('salutation') == 'Mrs.' ? 'selected' : '' }}>Mrs.</option>
                </select>
                @if ($errors->has('salutation'))
                    <span class="text-danger">{{ $errors->first('salutation') }}</span>
                @endif
            </div>
            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" id="first_name" name="first_name" class="form-control" value="{{ old('first_name') }}" placeholder="First Name" required>
                @if ($errors->has('first_name'))
                    <span class="text-danger">{{ $errors->first('first_name') }}</span>
                @endif
            </div>

            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" id="last_name" name="last_name" class="form-control" value="{{ old('last_name') }}" placeholder="Last Name" required>
                @if ($errors->has('last_name'))
                    <span class="text-danger">{{ $errors->first('last_name') }}</span>
                @endif
            </div>

            <div class="form-group">
                <label for="mobile">Mobile Number</label>
                <input type="tel" id="mobile" name="mobile" class="form-control" maxlength="10" pattern="\d{10}" value="{{ old('mobile') }}" placeholder="Mobile No" required>
                @if ($errors->has('mobile'))
                    <span class="text-danger">{{ $errors->first('mobile') }}</span>
                @endif
            </div>

            <div class="form-group">
                <label for="age">Age</label>
                <input type="number" id="age" name="age" class="form-control" value="{{ old('age') }}"  placeholder="Age" required>
                @if ($errors->has('age'))
                    <span class="text-danger">{{ $errors->first('age') }}</span>
                @endif
            </div>

            <div class="form-group">
                <label for="native_place">Native Place</label>
                <input type="text" id="native_place" name="native_place" class="form-control" value="{{ old('native_place') }}"  placeholder="Native Place" required>
                @if ($errors->has('native_place'))
                    <span class="text-danger">{{ $errors->first('native_place') }}</span>
                @endif
            </div>

            <div class="form-group">
                <label for="source">Where did you hear about us?</label>
                <input type="text" id="source" name="source" class="form-control" maxlength="20" value="{{ old('source') }}" placeholder="Where did you here about us?" required>
                @if ($errors->has('source'))
                    <span class="text-danger">{{ $errors->first('source') }}</span>
                @endif
            </div>

            <!-- Send OTP Button -->
            <button type="button" id="sendOtpBtn" style="margin-bottom : 20px;" class="btn btn-info btn-submit">{{ $errors->has('otp') ? 'Resend OTP' : 'Send OTP' }}</button>

            <!-- OTP Input Field -->
            <div class="form-group mt-3" id="otpField" style="{{ $errors->has('otp') ? 'display: block;' : 'display: none;' }}">
                <label for="otp">Enter OTP</label>
                <input type="text" id="otp" name="otp" class="form-control" pattern="\d{6}" maxlength="6" value="{{ old('otp') }}">
                @if ($errors->has('otp'))
                    <span class="text-danger">{{ $errors->first('otp') }}</span>
                @endif
            </div>

            <button type="submit" class="btn btn-warning btn-submit" id="registerBtn" {{ $errors->has('otp') ? 'enabled' : 'disabled' }} >Verify OTP and Submit</button>
        </form>
    </div>

    <footer class="text-center mt-5 py-3 bg-light">
        <p class="mb-0">&copy; {{ date('Y') }} VMA & FTS, Pune. All rights reserved.</p>
        <p class="mb-0">Powered by <b>Tatva Digitals</b></p>
    </footer>

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
                            $('#sendOtpBtn').text('Resend OTP');
                        }
                    },
                    error: function () {
                        alert('Failed to send OTP. Please try again.');
                    }
                });
            });
        });

        $('#registrationForm').submit(function () {
            $('#registerBtn').prop('disabled', true).text('Processing...');
        });
    </script>

</body>
</html>