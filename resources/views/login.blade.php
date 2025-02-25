<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
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
            background: linear-gradient(135deg,rgb(0, 0, 0),rgb(0, 0, 0));
            position: relative;
        }
        .login-container {
            background: rgba(0, 0, 0, 0.1);
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px);
            text-align: center;
            width: 350px;
            border: 1px solid #333;
            position: relative;
            z-index: 2;
        }
        .login-container h2 {
            color: #00bfff;
            margin-bottom: 20px;
            font-weight: 600;
        }
        .input-field {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
            background: rgba(255, 255, 255, 0.2);
            color: black;
            outline: none;
        }
        .input-field::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }
        .btn {
            width: 100%;
            padding: 12px;
            background:#00bfff;
            border: none;
            border-radius: 5px;
            color: black;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 10px;
        }
        .btn:hover {
            background: #525252;
        }
        .register-btn {
            background: #1BBE86;
        }
        .register-btn:hover {
            background: #16996B;
        }
        .error {
            color: red;
            font-size: 14px;
            margin-bottom: 5px;
            text-align: left;
        }
        .success-message {
            background-color: #28a745;
            color: white;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            font-weight: bold;
        }

        /* Loader */
        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1;
        }
        .loader {
            border: 10px solid #f3f3f3;
            border-top: 10px solid #3498db;
            border-radius: 50%;
            width: 80px;
            height: 80px;
            animation: spin 1.5s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .btn:disabled {
            background: #ccc;
            cursor: not-allowed;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>

        <!-- Display validation errors -->
        @if ($errors->any())
            <div class="error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Display success message -->
        @if (session('success'))
            <div class="success-message">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <!-- Display error message for authentication issues -->
        @if (session('error'))
            <div class="error">
                <p>{{ session('error') }}</p>
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST" id="loginForm">

            @csrf
            <input type="email" class="input-field" name="email" placeholder="Email" value="{{ old('email') }}" required>
            <input type="password" class="input-field" name="password" placeholder="contraseña" required>

             <!-- reCAPTCHA -->
             <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.sitekey') }}"></div>
            @error('g-recaptcha-response')
                <span class="error">{{ $message }}</span>
            @enderror

            <button type="submit" class="btn" id="submitBtn">Continue</button>
        </form>

        <form action="{{ route('register') }}" method="GET">
            <button type="submit" class="btn register-btn">Register</button>
        </form>
    </div>

    <!-- Loader Overlay -->
    <div class="overlay" id="loaderOverlay">
        <div class="loader"></div>
    </div>

    <script>
        const form = document.getElementById('loginForm');
        const submitBtn = document.getElementById('submitBtn');
        const loaderOverlay = document.getElementById('loaderOverlay');

        // Muestra el loader al enviar el formulario
        form.addEventListener('submit', function() {
            submitBtn.disabled = true; 
            loaderOverlay.style.display = 'flex'; 
        });

        // Oculta el loader si la página se carga desde el caché (navegación hacia atrás)
        window.addEventListener('pageshow', function(event) {
            if (event.persisted || performance.getEntriesByType('navigation')[0].type === 'back_forward') {
                loaderOverlay.style.display = 'none';
                submitBtn.disabled = false;
            }
        });
    </script>
</body>
</html>
