<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
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
</head>
<body>

    <div class="form-container">
        <!-- Logo (Replace with your logo URL) -->
        <img src="{{ asset('images/logo.jpeg') }}" alt="Logo" class="logo">

        <h2>VMA & FTS, Pune <br>प्रस्तुत: इवेंट – शौर्य स्मृति</h2>

        <form action="{{ route('event_registration.submit') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="mobile">Mobile Number</label>
                <input type="tel" id="mobile" name="mobile" class="form-control" pattern="\d{10}" required>
            </div>

            <div class="form-group">
                <label for="source">Where did you hear about us?</label>
                <select id="source" name="source" class="form-control" required>
                    <option value="" disabled selected>Select an option</option>
                    <option value="VMA Member">VMA Member</option>
                    <option value="Social Media">Social Media</option>
                    <option value="Friend/Colleague">Friend/Colleague</option>
                    <option value="Advertisement">Advertisement</option>
                    <option value="Other">Other</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary btn-submit">Register</button>
        </form>
    </div>

</body>
</html>
