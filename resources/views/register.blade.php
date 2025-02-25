<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        /* Global styles */
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: rgb(0, 0, 0);
            color: #fff;
        }

        /* Form container */
        .containerForm {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            padding: 20px;
        }

        /* Form styling */
        .form {
            display: flex;
            flex-direction: column;
            gap: 15px;
            max-width: 400px;
            width: 100%;
            padding: 20px;
            border-radius: 20px;
            background-color: rgb(0, 0, 0);
            color: #fff;
            border: 1px solid #333;
        }

        .title {
            font-size: 28px;
            font-weight: 600;
            letter-spacing: -1px;
            text-align: center;
            color: #00bfff;
        }

        .message,
        .signin {
            font-size: 14.5px;
            color: rgba(255, 255, 255, 0.7);
        }

        .signin {
            text-align: center;
        }

        .signin a {
            color: #00bfff;
            text-decoration: none;
            transition: 0.3s;
        }

        .signin a:hover {
            text-decoration: underline;
        }

        .flex {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .flex label {
            flex: 1; 
            min-width: 150px; 
        }

        /* Input styling */
        label {
            position: relative;
            width: 100%;
            margin-bottom: 5px;
        }

        .input {
            background-color: #333;
            color: #fff;
            width: 100%;
            padding: 15px 10px 5px;
            outline: 0;
            border: 1px solid rgba(105, 105, 105, 0.397);
            border-radius: 10px;
            font-size: 16px;
        }

        .input + span {
            color: rgba(255, 255, 255, 0.5);
            position: absolute;
            left: 10px;
            top: 15px;
            font-size: 14px;
            pointer-events: none;
            transition: 0.3s ease;
        }

        .input:placeholder-shown + span {
            top: 15px;
            font-size: 14px;
        }

        .input:focus + span,
        .input:valid + span {
            top: -5px;
            font-size: 12px;
            font-weight: 600;
            color: #00bfff;
        }

        /* Button styling */
        .submit {
            border: none;
            outline: none;
            padding: 12px;
            border-radius: 10px;
            color: #fff;
            font-size: 16px;
            background-color: #00bfff;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .submit:hover {
            background-color: #00bfff96;
        }

        /* Error messages */
        .error {
            font-size: 0.9em;
            color: red;
            margin-top: 5px; 
            display: block; 
        }

        /* Success message */
        .success {
            font-size: 1em;
            color: green;
            margin-top: 5px; 
            display: block; 
        }
    </style>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>
    <div class="containerForm">
        <form class="form" method="POST" action="{{ route('register.store') }}">
            @csrf
            <p class="title">Register</p>
            <p class="message">Signup now and get full access to our app.</p>

            @if (session('success'))
                <p class="success">{{ session('success') }}</p>
            @endif

            <div class="flex">
                <label>
                    <input class="input" type="text" name="firstName" value="{{ old('firstName') }}" required>
                    <span>Firstname</span>
                </label>
                @error('firstName')
                    <span class="error">{{ $message }}</span>
                @enderror

                <label>
                    <input class="input" type="text" name="lastName" value="{{ old('lastName') }}" required>
                    <span>Lastname</span>
                </label>
                @error('lastName')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <label>
                <input class="input" type="email" name="email" value="{{ old('email') }}" required>
                <span>Email</span>
            </label>
            @error('email')
                <span class="error">{{ $message }}</span>
            @enderror

            <label>
                <input class="input" type="password" name="password" required>
                <span>Password</span>
            </label>
            @error('password')
                <span class="error">{{ $message }}</span>
            @enderror

            <label>
                <input class="input" type="password" name="password_confirmation" required>
                <span>Confirm Password</span>
            </label>
            @error('password_confirmation')
                <span class="error">{{ $message }}</span>
            @enderror

            <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.sitekey') }}"></div>
            @error('g-recaptcha-response')
                <span class="error">{{ $message }}</span>
            @enderror

            <button class="submit" type="submit">Submit</button>

            <p class="signin">Already have an account? <a href="{{ route('login') }}">Signin</a></p>
        </form>
    </div>
</body>
</html>