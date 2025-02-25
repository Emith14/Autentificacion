<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activación de Cuenta</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .email-container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .email-header {
            text-align: center;
            padding-bottom: 20px;
        }
        .email-header h1 {
            color: #333;
        }
        .email-body {
            font-size: 16px;
            line-height: 1.5;
            margin-bottom: 20px;
        }
        .email-footer {
            text-align: center;
            font-size: 14px;
            color: #888;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }
        .btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

    <div class="email-container">
        <div class="email-header">
            <h1>Account Activation</h1>
        </div>

        <div class="email-body">
            <p>Hello, welcome!</p>
            <p>Thank you for registering on our platform. To activate your account, please click on the following link:</p>
            <p><a href="{{ $signedroute }}" class="btn">Activate Account</a></p>
            <p>This link will be available for the next 30 minutes.</p>
        </div>

        <div class="email-footer">
            <p>If you did not request this activation, please ignore this email.</p>
        </div>
    </div>

</body>
</html>
