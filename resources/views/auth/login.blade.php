<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Greenfields Coffee</title>
    <link rel="icon" type="image/x-icon" href="https://greenfieldsdairy.com/images/favicon/favicon-96x96.png" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #1a4d1a 0%, #2d5a27 50%, #4a7c59 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background:
                radial-gradient(circle at 20% 80%, rgba(120, 200, 120, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(120, 200, 120, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(120, 200, 120, 0.05) 0%, transparent 50%);
            pointer-events: none;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.98);
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            padding: 40px;
            width: 100%;
            max-width: 420px;
            position: relative;
            z-index: 1;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .login-header {
            text-align: center;
            margin-bottom: 35px;
        }

        .logo {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #4a7c59, #2d5a27);
            border-radius: 50%;
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            box-shadow: 0 8px 20px rgba(74, 124, 89, 0.3);
        }

        .login-title {
            color: #2d5a27;
            font-size: 1.8rem;
            font-weight: bold;
            margin-bottom: 8px;
        }

        .login-subtitle {
            color: #666;
            font-size: 0.95rem;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            color: #2d5a27;
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 0.9rem;
        }

        .form-input {
            width: 100%;
            padding: 14px 18px;
            border: 2px solid #e9ecef;
            border-radius: 12px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background: white;
        }

        .form-input:focus {
            outline: none;
            border-color: #4a7c59;
            box-shadow: 0 0 0 4px rgba(74, 124, 89, 0.1);
        }

        .form-input.error {
            border-color: #dc3545;
        }

        .error-message {
            color: #dc3545;
            font-size: 0.85rem;
            margin-top: 6px;
            display: block;
        }

        .alert {
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 0.9rem;
        }

        .alert-success {
            background: rgba(40, 167, 69, 0.1);
            border: 1px solid rgba(40, 167, 69, 0.3);
            color: #28a745;
        }

        .alert-error {
            background: rgba(220, 53, 69, 0.1);
            border: 1px solid rgba(220, 53, 69, 0.3);
            color: #dc3545;
        }

        .remember-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 25px;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .checkbox {
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: #4a7c59;
        }

        .checkbox-label {
            color: #666;
            font-size: 0.9rem;
            cursor: pointer;
            user-select: none;
        }

        .forgot-link {
            color: #4a7c59;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .forgot-link:hover {
            color: #2d5a27;
            text-decoration: underline;
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #4a7c59, #2d5a27);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(74, 124, 89, 0.3);
            position: relative;
            overflow: hidden;
        }

        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(74, 124, 89, 0.4);
        }

        .btn-login:hover::before {
            left: 100%;
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .btn-login:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        /* Responsive */
        @media (max-width: 480px) {
            .login-container {
                margin: 20px;
                padding: 30px 25px;
            }

            .login-title {
                font-size: 1.5rem;
            }

            .logo {
                width: 70px;
                height: 70px;
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <div class="logo">☕</div>
            <h1 class="login-title">Greenfields Coffee</h1>
            <p class="login-subtitle">Silakan login untuk melanjutkan</p>
        </div>

        <!-- Session Status -->
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="alert alert-error">
                <strong>Whoops!</strong> Ada masalah dengan input Anda.
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input
                    id="email"
                    class="form-input @error('email') error @enderror"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    autocomplete="username"
                    placeholder="Masukkan email Anda"
                >
                @error('email')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input
                    id="password"
                    class="form-input @error('password') error @enderror"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    placeholder="Masukkan password Anda"
                >
                @error('password')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="remember-row">
                <label for="remember_me" class="remember-me">
                    <input
                        id="remember_me"
                        type="checkbox"
                        class="checkbox"
                        name="remember"
                    >
                    <span class="checkbox-label">Ingat Saya</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="forgot-link" href="{{ route('password.request') }}">
                        Lupa Password?
                    </a>
                @endif
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn-login">
                Masuk
            </button>
        </form>
    </div>
</body>
</html>
