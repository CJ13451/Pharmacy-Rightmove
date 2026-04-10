<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In — Pharmacy Owner by P3</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Newsreader:wght@600;700;800&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', -apple-system, sans-serif; background: #f8f8f8; color: #1a1a1a; min-height: 100vh; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 40px 20px; }
        /* Brand lockup (grid so Pharmacy Owner and the tagline share exact width) */
        .login-lockup { display: inline-grid; grid-template-columns: auto auto auto; grid-template-rows: auto auto; column-gap: 12px; row-gap: 6px; align-items: center; margin: 0 auto 28px; text-decoration: none; }
        .login-logo { grid-column: 1; grid-row: 1; align-self: end; font-family: 'Newsreader', serif; font-weight: 800; font-size: 26px; letter-spacing: -0.5px; color: #1a1a1a; line-height: 1; white-space: nowrap; }
        .login-by { grid-column: 2; grid-row: 1; align-self: end; font-family: 'Newsreader', serif; font-style: italic; font-weight: 600; font-size: 22px; color: #00875a; line-height: 1; }
        .login-lockup img { grid-column: 3; grid-row: 1 / 3; height: 52px; width: auto; display: block; align-self: center; }
        .login-lockup .login-tagline { grid-column: 1; grid-row: 2; display: flex; justify-content: space-between; font-size: 9px; font-weight: 600; color: #666; letter-spacing: 1px; text-transform: uppercase; margin: 0; text-align: left; }
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
    <div style="text-align:center;">
        <a href="/" class="login-lockup">
            <span class="login-logo">Pharmacy Owner</span>
            <span class="login-by">by</span>
            <img src="{{ asset('images/p3-logo.png') }}" alt="P3 — For the Progressive Pharmacy Team">
            <span class="login-tagline"><span>Intelligence</span><span>&middot;</span><span>Analysis</span><span>&middot;</span><span>Insight</span></span>
        </a>
    </div>

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
