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
            <img src="{{ asset('images/fts-yuva.jpeg') }}" alt="Logo 1" class="logo mx-2">
            <img src="{{ asset('images/fts-mahila.jpeg') }}" alt="Logo 1" class="logo mx-2">
            <img src="{{ asset('images/fts-logo.jpg') }}" alt="Logo 2" class="logo mx-2">
        </div>
        

        <h2>EKAL SURTAAL 2026</h2>
        <br>

        <form id="registrationForm" action="{{ route('event_registration.submit') }}" method="POST">
            @csrf
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
                <label for="source">Invited By</label>
                <input type="text" id="source" name="source" class="form-control" maxlength="20" value="{{ old('source') }}" placeholder="Invited By" required>
                @if ($errors->has('source'))
                    <span class="text-danger">{{ $errors->first('source') }}</span>
                @endif
            </div>

            <div class="form-group">
                <label for="custom_field_1">Are you interested in Ekal Membership?</label>
                <select id="custom_field_1" name="custom_field_1" class="form-control">
                    <option value="">Select</option>
                    <option value="Yes" {{ old('custom_field_1') == 'Yes' ? 'selected' : '' }}>Yes</option>
                    <option value="No" {{ old('custom_field_1') == 'No' ? 'selected' : '' }}>No</option>
                </select>
                @if ($errors->has('custom_field_1'))
                    <span class="text-danger">{{ $errors->first('custom_field_1') }}</span>
                @endif
            </div>
            <button type="submit" class="btn btn-warning btn-submit" id="registerBtn">Submit</button>
        </form>
    </div>

    <footer class="text-center mt-5 py-3 bg-light">
        <p class="mb-0">&copy; {{ date('Y') }} FTS, Pune. All rights reserved.</p>
        <p class="mb-0">Powered by <b>Tatva Digitals</b></p>
    </footer>

    <script>
        $('#registrationForm').submit(function () {
            $('#registerBtn').prop('disabled', true).text('Processing...');
        });
    </script>

</body>
</html>