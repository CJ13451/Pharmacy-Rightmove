<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In — P3 Pharmacy</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', -apple-system, sans-serif; background: #f8f8f8; color: #1a1a1a; min-height: 100vh; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 40px 20px; }
        .login-logo { font-weight: 900; font-size: 28px; letter-spacing: -1px; text-decoration: none; color: #1a1a1a; margin-bottom: 4px; display: block; text-align: center; }
        .login-tagline { font-size: 11px; font-weight: 500; color: #888; letter-spacing: 0.5px; text-align: center; margin-bottom: 32px; }
        .login-box { background: #fff; border: 1px solid #e0e0e0; padding: 32px; width: 100%; max-width: 400px; }
        .login-title { font-size: 18px; font-weight: 800; margin-bottom: 4px; }
        .login-subtitle { font-size: 13px; color: #888; margin-bottom: 24px; }
        .login-subtitle a { color: #00875a; text-decoration: none; font-weight: 600; }
        .login-subtitle a:hover { text-decoration: underline; }
        .form-group { margin-bottom: 20px; }
        .form-label { display: block; font-size: 13px; font-weight: 600; color: #444; margin-bottom: 6px; }
        .form-input { width: 100%; padding: 10px 12px; border: 1px solid #ccc; font-family: inherit; font-size: 14px; }
        .form-input:focus { outline: none; border-color: #00875a; }
        .form-error { font-size: 12px; color: #dc2626; margin-top: 4px; }
        .form-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; font-size: 13px; }
        .form-row label { display: flex; align-items: center; gap: 6px; color: #444; cursor: pointer; }
        .form-row a { color: #00875a; text-decoration: none; font-weight: 600; }
        .form-row a:hover { text-decoration: underline; }
        .btn-submit { width: 100%; padding: 12px; background: #1a1a1a; color: #fff; border: none; font-family: inherit; font-size: 14px; font-weight: 600; cursor: pointer; }
        .btn-submit:hover { background: #333; }
        .flash { padding: 10px 14px; margin-bottom: 16px; font-size: 13px; border: 1px solid; }
        .flash-info { background: #eff6ff; border-color: #bfdbfe; color: #1e40af; }
        .flash-success { background: #f0fdf4; border-color: #bbf7d0; color: #166534; }
    </style>
</head>
<body>
    <a href="/" class="login-logo">p3pharmacy</a>
    <div class="login-tagline">Intelligence. Analysis. Insight.</div>

    <div class="login-box">
        <h1 class="login-title">Sign In</h1>
        <p class="login-subtitle">Don't have an account? <a href="{{ route('register') }}">Register free</a></p>

        @if(session('message'))
            <div class="flash flash-info">{{ session('message') }}</div>
        @endif
        @if(session('status'))
            <div class="flash flash-success">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label class="form-label" for="email">Email address</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus class="form-input">
                @error('email') <p class="form-error">{{ $message }}</p> @enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="password">Password</label>
                <input type="password" name="password" id="password" required class="form-input">
                @error('password') <p class="form-error">{{ $message }}</p> @enderror
            </div>
            <div class="form-row">
                <label><input type="checkbox" name="remember"> Remember me</label>
                <a href="{{ route('password.request') }}">Forgot password?</a>
            </div>
            <button type="submit" class="btn-submit">Sign In</button>
        </form>
    </div>
</body>
</html>
