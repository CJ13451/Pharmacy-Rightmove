<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Pharmacy Owner by P3' }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    @livewireStyles
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', -apple-system, sans-serif; background: #f8f8f8; color: #1a1a1a; min-height: 100vh; }
        .form-group { margin-bottom: 20px; }
        .form-label { display: block; font-size: 13px; font-weight: 600; color: #444; margin-bottom: 6px; }
        .form-input, .form-select { width: 100%; padding: 10px 12px; border: 1px solid #ccc; font-family: inherit; font-size: 14px; background: white; }
        .form-input:focus, .form-select:focus { outline: none; border-color: #00875a; }
        .form-error { font-size: 12px; color: #dc2626; margin-top: 4px; }
        .btn { display: inline-flex; align-items: center; justify-content: center; gap: 6px; padding: 10px 20px; font-family: inherit; font-size: 14px; font-weight: 600; border-radius: 4px; text-decoration: none; border: none; cursor: pointer; }
        .btn-primary { background: #1a1a1a; color: white; }
        .btn-primary:hover { background: #333; }
        .btn-outline { background: none; border: 1px solid #ccc; color: #444; }
    </style>
</head>
<body>
    {{ $slot }}
    @livewireScripts
</body>
</html>
