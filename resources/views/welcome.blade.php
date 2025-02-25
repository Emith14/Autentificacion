<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(135deg,rgb(0, 0, 0),rgb(77, 81, 86));
            color: #fff;
            text-align: center;
        }
        .container {
            max-width: 600px;
            padding: 40px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px);
        }
        h1 {
            font-size: 2.5rem;
            font-weight: 600;
            margin-bottom: 20px;
        }
        p {
            font-size: 1.2rem;
            margin-bottom: 30px;
            line-height: 1.6;
        }
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            font-size: 1rem;
        }
        .alert-success {
            background: #4caf50;
            color: #fff;
        }
        .alert-error {
            background: #f44336;
            color: #fff;
        }
        form {
            display: inline-block;
        }
        button {
            padding: 12px 24px;
            font-size: 1rem;
            font-weight: 500;
            color: #1e3a8a;
            background: #fff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s, color 0.3s;
        }
        button:hover {
            background: #3b82f6;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome</h1>
        <p>We are happy to have you here. Explore our site and enjoy the minimalist and modern experience we have designed for you.</p>
        <!-- Mostrar mensajes de éxito o error -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit">Close session</button>
        </form>
    </div>
</body>
</html>
