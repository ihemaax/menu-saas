<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Osirix' }}</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="alternate icon" href="{{ asset('favicon.ico') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=cairo:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-['Cairo']">
    <div class="zz-auth-shell">
        <div class="zz-auth-noise"></div>
        <main class="zz-auth-center">
            <div class="zz-auth-card">
                <div class="zz-auth-brand">
                    <span class="zz-auth-brand-mark">𓂀</span>
                    <div>
                        <p class="zz-auth-brand-name">Osirix</p>
                        <p class="zz-auth-brand-sub">منصة إدارة المطاعم</p>
                    </div>
                </div>
                {{ $slot }}
            </div>
        </main>
    </div>
</body>
</html>
