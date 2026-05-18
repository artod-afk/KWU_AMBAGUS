<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Sistem Toko Sembako</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }
        .login-card {
            background: white;
            border-radius: 20px;
            padding: 2.5rem 2rem;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 25px 60px rgba(0,0,0,0.4);
        }
        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .login-logo {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, #f97316, #ea580c);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            box-shadow: 0 8px 20px rgba(249,115,22,0.35);
        }
        .login-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 0.25rem;
        }
        .login-subtitle {
            font-size: 0.88rem;
            color: #9ca3af;
        }
        .form-group {
            margin-bottom: 1.25rem;
        }
        .form-label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.4rem;
        }
        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1.5px solid #e5e7eb;
            border-radius: 10px;
            font-size: 0.95rem;
            color: #1f2937;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
            background: #fafafa;
        }
        .form-input:focus {
            border-color: #f97316;
            box-shadow: 0 0 0 3px rgba(249,115,22,0.12);
            background: white;
        }
        .form-input.error {
            border-color: #ef4444;
        }
        .error-msg {
            color: #ef4444;
            font-size: 0.78rem;
            margin-top: 0.3rem;
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }
        .remember-row {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
        }
        .remember-row input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: #f97316;
            cursor: pointer;
        }
        .remember-row label {
            font-size: 0.88rem;
            color: #6b7280;
            cursor: pointer;
        }
        .btn-login {
            width: 100%;
            padding: 0.85rem;
            background: linear-gradient(135deg, #f97316, #ea580c);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: opacity 0.2s, transform 0.2s;
            box-shadow: 0 4px 15px rgba(249,115,22,0.35);
            letter-spacing: 0.02em;
        }
        .btn-login:hover {
            opacity: 0.92;
            transform: translateY(-1px);
        }
        .btn-login:active {
            transform: translateY(0);
        }
        .forgot-link {
            display: block;
            text-align: center;
            margin-top: 1.25rem;
            font-size: 0.85rem;
            color: #f97316;
            text-decoration: none;
        }
        .forgot-link:hover {
            text-decoration: underline;
        }
        .session-status {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            color: #16a34a;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            font-size: 0.85rem;
            margin-bottom: 1.25rem;
        }
        @media (max-width: 480px) {
            .login-card { padding: 2rem 1.25rem; border-radius: 16px; }
            .login-title { font-size: 1.3rem; }
        }
    </style>
</head>
<body>
    <div class="login-card">
        <!-- Header -->
        <div class="login-header">
            <div class="login-logo">
                <svg width="32" height="32" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
            <h1 class="login-title">Sistem Toko Sembako</h1>
            <p class="login-subtitle">Masuk untuk mengelola toko Anda</p>
        </div>

        <!-- Session Status -->
        @if (session('status'))
            <div class="session-status">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    class="form-input {{ $errors->has('email') ? 'error' : '' }}"
                    placeholder="admin@toko.com"
                    required
                    autofocus
                    autocomplete="username">
                @if ($errors->has('email'))
                    <div class="error-msg">
                        <svg width="12" height="12" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        {{ $errors->first('email') }}
                    </div>
                @endif
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input
                    id="password"
                    type="password"
                    name="password"
                    class="form-input {{ $errors->has('password') ? 'error' : '' }}"
                    placeholder="••••••••"
                    required
                    autocomplete="current-password">
                @if ($errors->has('password'))
                    <div class="error-msg">
                        <svg width="12" height="12" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        {{ $errors->first('password') }}
                    </div>
                @endif
            </div>

            <!-- Remember Me -->
            <div class="remember-row">
                <input id="remember_me" type="checkbox" name="remember">
                <label for="remember_me">Ingat saya</label>
            </div>

            <!-- Submit -->
            <button type="submit" class="btn-login">Masuk</button>

            <!-- Forgot Password -->
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="forgot-link">Lupa password?</a>
            @endif
        </form>
    </div>
</body>
</html>
