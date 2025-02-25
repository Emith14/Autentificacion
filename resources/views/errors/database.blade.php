<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error en la Base de Datos</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: #f8d7da;
            font-family: Arial, sans-serif;
            text-align: center;
        }
        .error-container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }
        h1 {
            color: #721c24;
        }
        p {
            color: #721c24;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <h1>Error en la Base de Datos</h1>
        <p>No pudimos conectar con la base de datos en este momento. Por favor, inténtalo más tarde.</p>
        <a href="{{ route('register') }}">Volver al Registro</a>
    </div>
</body>
</html>
