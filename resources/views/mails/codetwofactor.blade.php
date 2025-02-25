<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Código de Verificación</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 500px;
            margin: 30px auto;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
        }
        .logo {
            width: 120px;
            margin-bottom: 20px;
        }
        h2 {
            color: #333;
            margin-bottom: 10px;
        }
        p {
            color: #555;
            font-size: 16px;
            line-height: 1.5;
            margin-bottom: 20px;
        }
        .code {
            display: inline-block;
            font-size: 24px;
            font-weight: bold;
            background-color: #2d89ef;
            color: #fff;
            padding: 10px 20px;
            border-radius: 8px;
            letter-spacing: 4px;
        }
        .footer {
            margin-top: 20px;
            font-size: 14px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="{{ asset('images/logo.png') }}" class="logo" alt="Logo"> <!-- Agrega tu logo aquí -->
        <h2>Hola,</h2>
        <p>Tu código de verificación es:</p>
        <div class="code">{{ $code }}</div>
        <p>Este código expirará en 10 minutos. No lo compartas con nadie.</p>
        <p>Si no solicitaste este código, ignora este mensaje.</p>
        <p class="footer">Atentamente, <br> <strong>El equipo de soporte</strong></p>
    </div>
</body>
</html>
