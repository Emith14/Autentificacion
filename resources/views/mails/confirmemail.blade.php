<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Confirmed</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            color: #333;
            text-align: center;
            padding: 50px;
        }
        .message {
            font-size: 18px;
            margin-top: 20px;
        }
        .success {
            color: green;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1>Email Confirmed</h1>
    <p class="message success">Your account has been successfully activated! You can now <a href="{{ route('login') }}">log in</a>.</p>
</body>
</html>
