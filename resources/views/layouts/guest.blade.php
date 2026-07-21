<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Le Ciel Design') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;500;600&family=Jost:wght@300;400;500;600&display=swap">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="font-family:'Jost',sans-serif; margin:0;">
    <div style="min-height:100vh; display:flex; flex-direction:column; align-items:center; justify-content:center; background:#F5F0E8; padding:2rem 1rem;">

        <div style="display:flex; justify-content:center; margin-bottom:1.5rem;">
            <a href="/" style="background:#152349; padding:1.25rem 2rem; border-radius:6px; display:inline-block;">
                <img src="https://lecieldesign.com/wp-content/uploads/2025/09/LogoLeciel-Putih.png" alt="Le Ciel Design" style="width:140px; height:auto; display:block;">
            </a>
        </div>

        <div style="width:100%; max-width:420px; background:#FDFAF5; border:1px solid #E0D8CC; padding:2rem; border-radius:4px;">
            {{ $slot }}
        </div>

    </div>
</body>
</html>