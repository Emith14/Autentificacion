<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activación de Cuenta</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(135deg, #BFC3D1,rgb(0, 0, 0));
            position: relative;
        }
        .activation-container {
            background: rgba(255, 255, 255, 0.1);
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px);
            text-align: center;
            width: 400px;
            position: relative;
            z-index: 2;
        }
        .activation-container h2 {
            color: black;
            margin-bottom: 20px;
            font-weight: 600;
        }
        .message {
            padding: 15px;
            border-radius: 5px;
            font-weight: bold;
            margin-bottom: 15px;
            text-align: center;
        }
        .success {
            background-color: #28a745;
            color: white;
        }
        .error {
            background-color: #dc3545;
            color: white;
        }
        .btn {
            width: 100%;
            padding: 12px;
            background: #2E4EB0;
            border: none;
            border-radius: 5px;
            color: black;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 10px;
            text-decoration: none;
            display: inline-block;
        }
        .btn:hover {
            background: #525252;
        }
    </style>
</head>
<body>
    <div class="activation-container">
        <h2>Account Activate</h2>

        @if (session('success'))
    <div class="message success">
        <p>{{ session('success') }}</p>
    </div>
    <a href="{{ route('login') }}" class="btn">Ir al Login</a>
@elseif (session('error'))
    <div class="message error">
        <p>{{ session('error') }}</p>
    </div>
    <form action="{{ route('refreshsignedroute') }}" method="POST">
        @csrf
        <input type="hidden" name="user_id" value="{{ $userId ?? '' }}">
        <button type="submit" class="btn">Refrescar</button>
    </form>
@endif

    </div>
</body>

</html>
